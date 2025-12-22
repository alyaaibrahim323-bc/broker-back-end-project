<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;

use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Notification;
use App\Events\NotificationEvent;




class UserController extends Controller
{


    public function index()
{


    $users = User::orderBy('id', 'desc')->get();
    $total = User::count();

    return view('adminUI.Users.usersshow', compact(['users', 'total']));
}


    public function create()
    { $roles = Role::all();
        return view('adminUI.Users.add-user',compact('roles'));
    }



    public function save(Request $request)
    {

        // التحقق من صحة البيانات المدخلة
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users',
        //     'phone_number' => 'nullable|string',
        //     'city' => 'nullable|string',
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // التأكد أن الملف صورة
        //     'password' => 'required|string|min:8|confirmed', // إضافة تحقق من كلمة المرور
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('users.add')->withInput()->withErrors($validator);
        // }

        // معالجة الصورة
        $imagePath = null; // متغير لتخزين مسار الصورة
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/users', 'public'); // حفظ الصورة في المسار المحدد
        }


        // إنشاء المستخدم مع تشفير كلمة المرور
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'city' => $request->input('city'),
            'image' => $imagePath, // تخزين مسار الصورة
            'roles' => 'required|array',
            'password' => Hash::make($request->input('password')), // تشفير كلمة المرور
        ]);

        $user->syncRoles($request->roles);
        if ($user) {
            $notification = Notification::create([
                'type' => 'create',
                'message' => "create new user   : {$user->name}",
                'user_id' => Auth::id(),
            ]);

            // **بث الإشعار**
            broadcast(new NotificationEvent($notification,Auth::user()->name));

            session()->flash('success', 'User created successfully.');
            return redirect()->route('users.show');
        } else {
            session()->flash('error', 'An error occurred while creating the account');
            return back()->withInput();
        }
    }



public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();


    return view('adminUI.Users.edit-user', compact('user','roles'));
}

public function delete($id)
{
    $user = User::findOrFail($id);

    $deleted = $user->delete();

    if ($deleted) {
        session()->flash('success', 'User Deleted Successfully');
        return redirect(route('users.show')); // يجب التأكد من وجود هذه المسار في routes
    } else {
        session()->flash('error', 'User Not Deleted Successfully');
        return redirect(route('users.show')); // إعادة التوجيه إلى قائمة المستخدمين
    }
}



public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => "required|email|unique:users,email,{$id}",
        'password' => 'nullable|string|min:6|confirmed',
        'phone_number' => 'nullable|string|max:15',
        'city' => 'nullable|string|max:100',
        'roles' => 'required|array',
    ]);

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->phone_number = $validatedData['phone_number'] ?? $user->phone_number;
    $user->city = $validatedData['city'] ?? $user->city;

    if (!empty($validatedData['password'])) {
        $user->password = Hash::make($validatedData['password']);
    }

    if ($request->hasFile('image')) {
        if ($user->image && file_exists(public_path('storage/' . $user->image))) {
            unlink(public_path('storage/' . $user->image));
        }

        $user->image = $request->file('image')->store('uploads/users', 'public');
    }


    $user->save();

    if ($request->has('roles')) {
        $user->syncRoles($validatedData['roles']);
    }

    $notification = Notification::create([
        'type' => 'update',
        'message' => " update user  : {$user->name}",
        'user_id' => Auth::id(), // الشخص اللي عمل التعديل
    ]);

    // **بث الإشعار**
    broadcast(new NotificationEvent($notification,Auth::user()->name));

    session()->flash('success', 'User updated successfully.');
    return redirect()->route('users.show');
}


// public function getProfileData()
// {
//     // التحقق مما إذا كان المستخدم مسجلاً للدخول
//     if (Auth::check()) {
//         $user = Auth::user();

//         // بناء بيانات الملف الشخصي مع التحقق من الخصائص
//         $profileData = [
//             'name' => $user->name ?? 'غير متوفر', // استخدام القيمة الافتراضية في حالة عدم وجود الاسم
//             'email' => $user->email ?? 'غير متوفر', // استخدام القيمة الافتراضية في حالة عدم وجود البريد
//             'phone' => $user->phone ?? 'غير متوفر', // استخدام القيمة الافتراضية في حالة عدم وجود الهاتف
//             'role' => $user->roles->pluck('name')->first() ?? 'غير متوفر', // استخدام القيمة الافتراضية في حالة عدم وجود دور
//             'image' => $user->image ? asset('storage/' . $user->image) : null, // التحقق من وجود الصورة
//         ];

//         return response()->json($profileData);
//     } else {
//         // إذا لم يكن المستخدم مسجلاً للدخول، يمكن إرجاع رسالة خطأ
//         return response()->json(['error' => 'المستخدم غير مسجل للدخول.'], 401);
//     }
// }


public function getUserData($id = null)
{
    if ($id) {
        $user = User::with('roles', 'userProperty')->find($id);
    } else {
        $user = User::with('roles', 'userProperty')->find(Auth::id());
    }

    if (!$user) {
        return response()->json(['error' => 'المستخدم غير موجود.'], 404);
    }

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'phone_number' => $user->phone_number,
        'city' => $user->city,
        'roles' => $user->roles->pluck('name'),
        'image' => $user->image ? asset('storage/' . $user->image) : null,
        'created_at' => $user->created_at,
        'user_property' => [
            'full_name' => $user->userProperty->full_name ?? null,
            'age' => $user->userProperty->age ?? null,
            'marital_status' => $user->userProperty->marital_status ?? null,
            'occupation' => $user->userProperty->occupation ?? null,
            'family_size' => $user->userProperty->family_size ?? null,
            'monthly_income' => $user->userProperty->monthly_income ?? null,
            'preferred_location' => $user->userProperty->preferred_location ?? null,
            'lifestyle' => $user->userProperty->lifestyle ?? null,
            'climate_preference' => $user->userProperty->climate_preference ?? null,
            'family_status' => $user->userProperty->family_status ?? null,
            'special_needs' => $user->userProperty->special_needs ?? null,
            'transport_nearby' => $user->userProperty->transport_nearby ?? null,
        ]
    ]);
}

public function deleteUserApi($id)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please provide a valid token.',
        ], 401);
    }

    try {
        $user = User::findOrFail($id);


        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User Deleted Successfully.',
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to delete user.',
        ], 500);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'User not found or error occurred.',
            'error' => $e->getMessage(),
        ], 404);
    }
}


public function getNewUsers()
    {
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth();

        $newUsers = DB::table('users')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        $previousMonthUsers = DB::table('users')
            ->whereBetween('created_at', [$startOfMonth->subMonth(), $endOfMonth->subMonth()])
            ->count();

        $percentageIncrease = $previousMonthUsers > 0
            ? (($newUsers - $previousMonthUsers) / $previousMonthUsers) * 100
            : ($newUsers > 0 ? 100 : 0);

        return response()->json([
            'new_users' => $newUsers,
            'percentage_increase' => round($percentageIncrease, 2),
        ]);
    }
public function UserStatus(Request $request)
    {
        $request->validate([
            'is_online' => 'required|boolean',
        ]);

        $user = $request->user(); // بيتم التعرف على المستخدم من الـ token
        $user->is_online = $request->is_online;
        $user->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }



}
