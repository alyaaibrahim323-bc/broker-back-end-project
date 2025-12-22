<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatHistory;
use App\Models\Feedback;
use App\Models\MessageFeedback; // تمت الإضافة
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // تمت الإضافة

class ChatHistoryController extends Controller
{
    /**
     * حفظ رسالة جديدة مرتبطة بمعرف المستخدم
     */
 public function storeMessageByUserId(Request $request)
{
    $validator = Validator::make($request->all(), [
        'role' => 'required|in:user,assistant',
        'message' => 'required|string',
        'user_id' => 'required|exists:users,id',
        'session_id' => 'nullable|string',
        'message_id' => 'required|string', // ✅ نتحقق إنه موجود
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    $query = ChatHistory::where('user_id', $request->user_id);

    if ($request->session_id) {
        $query->where('session_id', $request->session_id);
    } else {
        $query->whereNull('session_id');
    }

    $chatHistory = $query->first();

    if (!$chatHistory) {
        $chatHistory = ChatHistory::create([
            'user_id' => $request->user_id,
            'session_id' => $request->session_id,
            'message' => $request->message,
            'data' => json_encode([])
        ]);
    }

    $messages = json_decode($chatHistory->data, true) ?? [];

    foreach ($messages as $msg) {
    if (isset($msg['message_id']) && $msg['message_id'] === $request->message_id) {
        return response()->json([
            'success' => false,
            'message' => 'هذا الـ message_id مستخدم من قبل'
        ], 409);
    }
    }


    $messages[] = [
        'message_id' => $request->message_id,
        'role' => $request->role,
        'message' => $request->message,
        'timestamp' => now()->toDateTimeString(),
    ];

    $chatHistory->update([
        'data' => json_encode($messages),
        'message' => $request->message,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'تم حفظ الرسالة بنجاح',
        'data' => $chatHistory
    ]);
}


    public function getUserSessions($userId)
    {
        $sessions = ChatHistory::where('user_id', $userId)
                     ->select('session_id')
                     ->distinct()
                     ->get()
                     ->pluck('session_id');

        $filteredSessions = $sessions->filter()->values();

        return response()->json([
            'success' => true,
            'sessions' => $filteredSessions->isEmpty() ? [] : $filteredSessions,
            'message' => $filteredSessions->isEmpty() 
                ? 'No sessions found/لا توجد جلسات' 
                : 'Sessions retrieved/تم استرجاع الجلسات'
        ]);
    }

    public function getUserChatHistory($userId, $sessionId = null)
    {
        $query = ChatHistory::where('user_id', $userId);
        
        if ($sessionId === 'null') {
            $query->whereNull('session_id');
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        } else {
            $sessions = ChatHistory::where('user_id', $userId)
                       ->get()
                       ->groupBy('session_id');

            if ($sessions->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'sessions' => [],
                    'message' => 'No sessions found/لا توجد جلسات'
                ]);
            }

            $formattedSessions = [];
            foreach ($sessions as $sessionIdValue => $records) {
                $messages = $records->flatMap(fn($r) => json_decode($r->data, true));
                
                // جمع الـ IDs فقط للرسائل التي تحتوي على message_id
                $messageIds = collect($messages)
                    ->filter(fn($msg) => isset($msg['message_id']))
                    ->pluck('message_id')
                    ->toArray();
                
                $feedbacks = MessageFeedback::whereIn('message_id', $messageIds)
                    ->get()
                    ->groupBy('message_id');
                
                foreach ($messages as &$message) {
                    // تخطي الرسائل القديمة التي لا تحتوي على message_id
                    if (!isset($message['message_id'])) {
                        $message['likes'] = 0;
                        $message['dislikes'] = 0;
                        $message['comments'] = [];
                        continue;
                    }
                    
                    $messageFeedback = $feedbacks[$message['message_id']] ?? collect();
                    $message['likes'] = $messageFeedback->where('feedback_type', 'like')->count();
                    $message['dislikes'] = $messageFeedback->where('feedback_type', 'dislike')->count();
                    $message['comments'] = $messageFeedback->whereNotNull('comment')->map(function($item) {
                        return [
                            'user_id' => $item->user_id,
                            'comment' => $item->comment,
                            'timestamp' => $item->created_at->toDateTimeString()
                        ];
                    })->values()->toArray();
                }
                foreach ($messages as &$message) {
        if (!isset($message['message_id'])) {
            // إنشاء message_id للرسائل القديمة
            $message['message_id'] = (string) Str::uuid();
        }
    }

                $formattedSessions[] = [
                    'session_id' => $sessionIdValue,
                    'messages' => $messages
                ];
            }

            return response()->json([
                'success' => true,
                'sessions' => $formattedSessions
            ]);
        }

        $chatHistory = $query->first();

        if (!$chatHistory) {
            return response()->json([
                'success' => true,
                'messages' => [],
                'message' => 'Session not found/الجلسة غير موجودة'
            ]);
        }

        $messages = json_decode($chatHistory->data, true) ?? [];
        
        // جمع الـ IDs فقط للرسائل التي تحتوي على message_id
        $messageIds = collect($messages)
            ->filter(fn($msg) => isset($msg['message_id']))
            ->pluck('message_id')
            ->toArray();
        
        $feedbacks = MessageFeedback::whereIn('message_id', $messageIds)
            ->get()
            ->groupBy('message_id');
        
        foreach ($messages as &$message) {
            // تخطي الرسائل القديمة التي لا تحتوي على message_id
            if (!isset($message['message_id'])) {
                $message['likes'] = 0;
                $message['dislikes'] = 0;
                $message['comments'] = [];
                continue;
            }
            
            $messageFeedback = $feedbacks[$message['message_id']] ?? collect();
            $message['likes'] = $messageFeedback->where('feedback_type', 'like')->count();
            $message['dislikes'] = $messageFeedback->where('feedback_type', 'dislike')->count();
            $message['comments'] = $messageFeedback->whereNotNull('comment')->map(function($item) {
                return [
                    'user_id' => $item->user_id,
                    'comment' => $item->comment,
                    'timestamp' => $item->created_at->toDateTimeString()
                ];
            })->values()->toArray();
        }

        return response()->json([
            'success' => true,
            'session' => $sessionId,
            'messages' => $messages
        ]);
    }

    /**
     * ربط جلسة محادثة بمستخدم
     */
    public function linkSessionToUser(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'session_id' => 'nullable|string', // تم التعديل: أصبحت اختيارية
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // تحديث السجلات المرتبطة بالجلسة
        $query = ChatHistory::query();
        
        // تم التعديل: التعامل مع session_id كقيمة اختيارية
        if ($request->session_id) {
            $query->where('session_id', $request->session_id);
        } else {
            $query->whereNull('session_id');
        }
        
        $query->update(['user_id' => $request->user_id]);

        return response()->json([
            'success' => true,
            'message' => 'تم الربط بنجاح'
        ]);
    }

    /**
     * حفظ التغذية الراجعة
     */
    public function storeFeedback(Request $request)
    {
        // التحقق من صحة البيانات
        $validator = Validator::make($request->all(), [
            'session_id' => 'nullable|string', // تم التعديل: أصبحت اختيارية
            'message' => 'required|string',
            'feedback_type' => 'required|string',
            'comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // إنشاء أو تحديث سجل التغذية الراجعة
        $feedback = Feedback::firstOrCreate(
            ['session_id' => $request->session_id],
            ['messages' => json_encode([])]
        );

        // إضافة التغذية الجديدة
        $feedbacks = json_decode($feedback->messages, true) ?? [];
        $feedbacks[] = [
            'message' => $request->message,
            'feedback_type' => $request->feedback_type,
            'comment' => $request->comment,
            'timestamp' => now()->toDateTimeString()
        ];

        // حفظ التحديثات
        $feedback->update(['messages' => json_encode($feedbacks)]);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ التغذية الراجعة'
        ]);
    }

    /**
     * استرجاع التغذية الراجعة
     */
    public function getFeedback($sessionId = null) // تم التعديل: أصبحت اختيارية
    {
        $query = Feedback::query();
        
        // تم التعديل: التعامل مع session_id كقيمة اختيارية
        if ($sessionId === 'null') {
            $query->whereNull('session_id');
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }

        $feedback = $query->first();

        if (!$feedback) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد نتائج'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'feedback' => json_decode($feedback->messages, true)
        ]);
    }

// تمت الإضافة: دالة لتخزين تقييمات الرسائل
public function storeMessageFeedback(Request $request)
{
    $validator = Validator::make($request->all(), [
        'message_id' => 'required|string', // تم تغييره من uuid إلى string
        'user_id' => 'required|exists:users,id',
        'feedback_type' => 'required|in:like,dislike',
        'comment' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    // تمت إزالة التحقق من وجود الرسالة في ChatHistory
    
    // إنشاء أو تحديث التقييم مباشرة
    $feedback = MessageFeedback::updateOrCreate(
        [
            'message_id' => $request->message_id,
            'user_id' => $request->user_id
        ],
        [
            'feedback_type' => $request->feedback_type,
            'comment' => $request->comment
        ]
    );

    return response()->json([
        'success' => true,
        'message' => 'تم حفظ التقييم بنجاح',
        'feedback_id' => $feedback->id
    ]);
}

public function getMessageFeedback($messageId)
{
    // تمت إزالة التحقق من وجود الرسالة في ChatHistory
    
    $feedbacks = MessageFeedback::where('message_id', $messageId)->get();

    return response()->json([
        'success' => true,
        'likes' => $feedbacks->where('feedback_type', 'like')->count(),
        'dislikes' => $feedbacks->where('feedback_type', 'dislike')->count(),
        'comments' => $feedbacks->whereNotNull('comment')->map(function($item) {
            return [
                'user_id' => $item->user_id,
                'comment' => $item->comment,
                'timestamp' => $item->created_at->toDateTimeString()
            ];
        })->values()
    ]);
}
}