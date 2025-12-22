<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Notification;
use App\Events\NotificationEvent;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // مصادقة المستخدم
        $request->authenticate();

        // تجديد الجلسة
        $request->session()->regenerate();

        // // الحصول على المستخدم المصادق عليه
        // $user = Auth::user();

        // // إنشاء إشعار تسجيل الدخول
        // $notification = Notification::create([
        //     'type' => 'login',
        //     'message' => "قام {$user->name} بتسجيل الدخول",
        //     'user_id' => $user->id, // حفظ الإشعار لليوزر المسجل
        // ]);

        // // بث الإشعار
        // broadcast(new NotificationEvent($notification));

        // توجيه المستخدم إلى الداشبورد بعد تسجيل الدخول
        return redirect()->intended(route('dashboard', absolute: false))->with('success', 'تم تسجيل الدخول بنجاح!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
