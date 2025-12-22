<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\PasswordResetLinkControllerApi;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CustomerSupportController;
use App\Http\Controllers\UserPropertyController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatHistoryController;
use App\Http\Controllers\CompoundController;

use App\Models\Notification;








// روت لإضافة بيانات جديدة
Route::post('/user-properties', [UserPropertyController::class, 'store']);

// روت لعرض جميع البيانات
Route::get('/user-properties', [UserPropertyController::class, 'index']);

// روت لعرض بيانات مستخدم معين بناءً على `user_id`
Route::get('/user-properties/{id}', [UserPropertyController::class, 'show']);

// روت لتحديث بيانات المستخدم
Route::put('/user-properties/{id}', [UserPropertyController::class, 'update']);

// روت لحذف بيانات المستخدم
Route::delete('/user-properties/{id}', [UserPropertyController::class, 'destroy']);

Route::prefix('support')->group(function () {
    Route::post('/create', [CustomerSupportController::class, 'store']); // إنشاء طلب جديد
    Route::get('/requests', [CustomerSupportController::class, 'index']); // عرض جميع الطلبات
    Route::get('/request/{id}', [CustomerSupportController::class, 'show']); // عرض طلب محدد
    Route::put('/request/{id}/status', [CustomerSupportController::class, 'updateStatus']); // تحديث الحالة
});


    Route::get('/bookings', [BookingController::class, 'apiIndex']);
Route::post('/bookings', [BookingController::class, 'store']); // إنشاء حجز جديد
Route::put('/bookings/{id}', [BookingController::class, 'update']); // تحديث الحجز
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']); // حذف الحجز
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user/bookings', [BookingController::class, 'userBookings']);
});

Route::post('/password/reset-link', [PasswordResetLinkControllerApi::class, 'store']);
Route::get('/units', [UnitController::class, 'getUnits']);
Route::post('/units/save', [UnitController::class, 'save']);
Route::get('/units/{id}', [UnitController::class, 'showunit']);


// // Route::get('/user', function (Request $request) {
// //     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/register', [AuthApiController::class, 'register']);
Route::delete('/users/{id}', [UserController::class, 'deleteUserApi'])->name('api.users.delete');


Route::middleware('auth:sanctum')->get('/profile', [Authapicontroller::class, 'profile']);
Route::middleware('auth:sanctum')->post('/profile/update', [Authapicontroller::class, 'updateProfile']);
Route::middleware('auth:sanctum')->get('/units/search', [UnitController::class, 'search']);

Route::middleware('auth:sanctum')->group(function () {
 Route::post('/units/{unitId}/favorite', [UnitController::class, 'addFavorite']);
    Route::delete('/units/{unitId}/favorite', [UnitController::class, 'removeFavorite']);
    Route::post('/units/{unitId}/favorite/toggle', [UnitController::class, 'toggleFavorite']);
    
});


// Route::post('/send-reset-otp', [Authapicontroller::class, 'sendResetOtp']);
// Route::post('/verify-reset-otp', [Authapicontroller::class, 'verifyResetOtp']);
// Route::post('/reset-password-with-otp', [Authapicontroller::class, 'resetPasswordWithOtp']);
///////////////////////////////////////////////////////////////////////////////////////



Route::get('/user/{id?}', [UserController::class, 'getUserData']); // API لجلب بيانات المستخدم حسب ID


Route::get('/unit/{unit_id}/developer', [UnitController::class, 'getDeveloperByUnit']);

Route::get('/unit/{unit_id}/project', [UnitController::class, 'getProjectByUnit']);

Route::get('/user/{user_id}/bookings', [BookingController::class, 'getUserBookings']);

Route::get('/filter-units', [UnitController::class, 'filterUnits']);

// Route::middleware('auth:sanctum')->post('/save-chat', [ChatController::class, 'store']);
// Route::middleware('auth:sanctum')->post('/save-conversation', [ChatController::class, 'saveConversation']);
// Route::middleware('auth:sanctum')->post('/save-convesation', [ChatController::class, 'saveConvesation']);
// Route::post('/chat/save', [ChatController::class, 'saveDirectConversation']);

// Route::get('/test-session', [ChatController::class, 'testSession']);
Route::post('/projects/store', [CompoundController::class, 'store'])->name('projects.store');

Route::middleware('auth:sanctum')->post('/update-user-status', [UserController::class, 'UserStatus']);

Route::get('/dashboard/active-users', [UIcontroller::class, 'activeUsersCount']);





// Route::post('/chat-history', [ChatHistoryController::class, 'store']);
// Route::get('/chat-history/{session_id}', [ChatHistoryController::class, 'getHistory']);


// Route::post('/save', [ChatHistoryController::class, 'save1']); // لحفظ المحادثة
// Route::get('/chat/history/{session_id}', [ChatHistoryController::class, 'getsave']);

// Route::post('/save-chat', [ChatHistoryController::class, 'save']); // لحفظ الرسائل في قاعدة البيانات
// Route::post('/get-chat-history', [ChatHistoryController::class, 'getChatHistory']);


// Route::post('/store', [ChatHistoryController::class, 'store']);

// // تخزين محادثة كاملة
// Route::post('/save-conversation', [ChatHistoryController::class, 'saveEntireConversationToJson']);

// // استرجاع المحادثة باستخدام session_id
// Route::get('/get-history/{session_id}', [ChatHistoryController::class, 'getHistory']);



// Route::post('/chat/message', [ChatHistoryController::class, 'storeMessage']);

Route::post('/chat/messages', [ChatHistoryController::class, 'storeMessagebyuserID']);
// Route::get('/chat/history/{userId}', [ChatHistoryController::class, 'getUserChatHistory']);
// Route::post('/link-session', [ChatController::class, 'linkSessionToUser']);
// استرجاع جميع الرسائل
Route::get('/user/{userId}/sessions', [ChatHistoryController::class, 'getUserSessions']);
Route::get('/user/{userId}/chat', [ChatHistoryController::class, 'getUserChatHistory']);
Route::get('/user/{userId}/chat/{sessionId}', [ChatHistoryController::class, 'getUserChatHistory']);

Route::post('/chat/message-feedback', [ChatHistoryController::class, 'storeMessageFeedback']);

// جلب التقييمات لرسالة محددة
Route::get('/chat/message-feedback/{messageId}', [ChatHistoryController::class, 'getMessageFeedback']);






// Route::get('/chat/history/{sessionId}', [ChatHistoryController::class, 'getChatHistory']);


Route::post('/feedback/message', [ChatHistoryController::class, 'storefeedback']);

// روت لاسترجاع الرسائل
Route::get('/feedback/history/{sessionId}', [ChatHistoryController::class, 'getfeedback']);


Route::get('/notifications', function () {
    return Notification::where('user_id', auth()->id())
        ->orWhereNull('user_id')
        ->orderBy('created_at', 'desc')
        ->get();
});
