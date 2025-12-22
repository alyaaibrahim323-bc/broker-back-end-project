<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\Events\PasswordReset;
use \App\Mail\ResetPasswordOtp;
use Illuminate\Support\Facades\Storage;

class AuthApicontroller extends Controller
{
    public function register(Request $request)
{
    $fields = $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users',
        'phone_number' => 'required|unique:users',
        'password' => 'required|confirmed',
        'roles' => 'nullable|array',
    ]);

    $roles = $fields['roles'] ?? ['user'];

    $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'phone_number' => $fields['phone_number'],
        'password' => Hash::make($fields['password']),
    ]);

    $user->syncRoles($roles);

    $token = $user->createToken($request->name);

    return [
        'user' => $user,
        'token' => $token->plainTextToken
    ];
}


    public function login(Request $request)
{
    // Validate request input
    $request->validate([
        'email' => 'required_without:phone_number|email',
        'phone_number' => 'required_without:email',
        'password' => 'required'
    ]);

    // Find the user by email or phone number
    $user = null;
    if ($request->email) {
        $user = User::where('email', $request->email)->first();
    } elseif ($request->phone_number) {
        $user = User::where('phone_number', $request->phone_number)->first();
    }

    // Check if user exists and the password is correct
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'errors' => [
                'login' => ['The provided credentials are incorrect.']
            ]
        ], 401); // 401 Unauthorized
    }

    // Log in the user
    Auth::login($user);

    // Regenerate session (for session-based authentication)
    // $request->session()->regenerate();

    // Generate API token for API-based authentication (optional)
    $token = $user->createToken($user->name);

    // Return successful response with session info
    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token->plainTextToken, // Token for API access
    ], 200); // 200 OK
}



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
    public function sendResetOtp(Request $request)
    {
        set_time_limit(120);
        $request->validate(['email' => 'required|email']);

        $user= User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.',404]);
        }

        $otp = random_int(1000, 9999); // Generate a 6-digit OTP

        // Store the OTP temporarily (e.g., in cache)
        Cache::put('password_reset_otp_' . $user->email, $otp, now()->addMinutes(10));

        // Send OTP to user's email (use your email view here)
        Mail::to($user->email)->send(new ResetPasswordOtp($otp));

        return response()->json(['message' => 'OTP has been sent to your email.'], 200);
    }




    public function verifyResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $cachedOtp = Cache::get('password_reset_otp_' . $request->email);

        if ($cachedOtp && $cachedOtp == $request->otp) {
            // OTP is valid, allow the user to reset password
            return response()->json(['message' => 'OTP verified. Proceed to reset password.'], 200);
        } else {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }
    }


    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        // Update the password
        $user->forceFill([
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        // Clear the cached OTP
        Cache::forget('password_reset_otp_' . $request->email);

        event(new PasswordReset($user));

        return response()->json(['message' => 'Password has been reset successfully.'], 200);
    }


    public function profile(Request $request)
{
    // التحقق من المستخدم الحالي
    $user = $request->user();

    if ($user) {
        // تجهيز بيانات الملف الشخصي لإرجاعها كـ JSON
        $profileData = [
            'name' => $user->name ?? 'غير متوفر',
            'email' => $user->email ?? 'غير متوفر',
            'phone_number' => $user->phone_number ?? 'غير متوفر',
            'role' => $user->roles->pluck('name')->first() ?? 'غير متوفر', // التأكد من وجود الدور
            'image' => $user->image ? asset('storage/' . $user->image) : null, // التأكد من وجود الصورة
        ];

        return response()->json($profileData, 200); // إرجاع بيانات المستخدم
    } else {
        // المستخدم غير مسجل للدخول
        return response()->json(['error' => 'المستخدم غير مسجل للدخول.'], 401);
    }
}
public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => 'sometimes|string|max:255',
        'phone_number' => 'sometimes|unique:users,phone_number,' . $user->id,
        'password' => 'sometimes|min:8|confirmed',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->has('name')) {
        $user->name = $request->name;
    }

    if ($request->has('phone_number')) {
        $user->phone_number = $request->phone_number;
    }

    if ($request->has('password')) {
        $user->password = Hash::make($request->password);
    }

    if ($request->hasFile('image')) {
        if ($user->image && Storage::exists($user->image)) {
            Storage::delete($user->image);
        }

        $path = $request->file('image')->store('profile_images', 'public');
        $user->image = $path;
    }

    $user->save();
    $profileData = [
        'name' => $user->name,
        'email' => $user->email,
        'phone_number' => $user->phone_number,
        'role' => $user->roles->pluck('name')->first(),
        'image' => $user->image ? asset('storage/' . $user->image) : null,
    ];

    return response()->json(['message' => 'Profile updated successfully.', 'user' => $profileData], 200);
}
}
