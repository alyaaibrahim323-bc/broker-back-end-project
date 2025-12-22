<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ChatController extends Controller
{
    public function store(Request $request)
{
    // التحقق من البيانات المرسلة
    $request->validate([
        'user_message' => 'required|string',
        'ai_response' => 'required|string',
    ]);

    // التحقق من تسجيل الدخول
    if (!Auth::check()) {
        return response()->json([
            'error' => 'User not authenticated.'
        ], 401); // حالة 401 تعني "غير مسموح"
    }

    // حفظ المحادثة في قاعدة البيانات
    $chatLog = ChatLog::create([
        'user_message' => $request->user_message,
        'ai_response' => $request->ai_response,
        'user_id' => Auth::id(), // أخذ ID المستخدم المسجل دخوله
    ]);

    // إعادة الاستجابة مع رسالة نجاح
    return response()->json([
        'message' => 'Chat saved successfully!',
        'data' => $chatLog
    ], 201);
}
public function saveConversation(Request $request)
{
    // التحقق من صحة البيانات
    $request->validate([
        'conversation' => 'required|string',
    ]);

    // التحقق من تسجيل الدخول (اختياري)
    $userId = Auth::check() ? Auth::id() : null;

    // حفظ المحادثة دفعة واحدة
    $chatLog = ChatLog::create([
        'conversation' => $request->conversation,
        'user_message' => '', // إضافة قيمة افتراضية فارغة
        'ai_response' => '',  // إضافة قيمة افتراضية فارغة
        'user_id' => $userId, // إذا لم يكن المستخدم مسجل دخول، يمكن أن يكون null
    ]);

    // إعادة الاستجابة مع رسالة نجاح
    return response()->json([
        'message' => 'Conversation saved successfully!',
        'data' => $chatLog
    ], 201);
}


public function saveConvesation(Request $request)
{
    $request->validate([
        'conversation' => 'required|string',
    ]);

    $userId = Auth::check() ? Auth::id() : null;

    $chatLog = ChatLog::create([
        'conversation' => $request->conversation,
        'user_id' => $userId,
    ]);

    return response()->json([
        'message' => 'Conversation saved successfully!',
        'data' => $chatLog,
    ], 201);
}



public function saveDirectConversation(Request $request)
{
    // حفظ المحادثة في الجلسة
    $conversation = 'User: ' . $request->user_message . '\nAI: ' . $request->ai_response;

    // إضافة المحادثة إلى الجلسة
    $request->session()->push('conversation', $conversation);

    // استرجاع المحادثة المحفوظة
    $savedConversation = $request->session()->get('conversation');

    // حفظ المحادثة في قاعدة البيانات
    $chatLog = ChatLog::create([
        'conversation' => implode("\n", $savedConversation),
        'user_id' => Auth::check() ? Auth::id() : null, // إذا كان المستخدم مسجل الدخول
        'session_id' => session()->getId(), // معرف الجلسة
    ]);

    return response()->json([
        'message' => 'Chat saved successfully!',
        'data' => $chatLog
    ], 201);
}



public function testSession(Request $request)
{
    $request->session()->put('test_key', 'test_value');
    return response()->json(['session_value' => $request->session()->get('test_key')]);
}



}


