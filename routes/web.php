<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\permissioncontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UIController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\CompoundController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Events\NotificationEvent;
use App\Http\Controllers\BookingController;

use Illuminate\Support\Facades\Request;



Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {

        
        // routes/web.php
        Route::get('/statistics', function () {
            $data = [
                "labels" => ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                "users" => [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1100, 1200],
                "projects" => [50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325],
                "developers" => [20, 40, 60, 80, 100, 120, 140, 160, 180, 200, 220, 240]
            ];
            return response()->json($data);
        });
        Route::get('/statistics', [UIController::class, 'getChartData']);
        
        
        
        
        
        Route::get('/dashboard', function () {
            $user = Auth::user();
        
            // توجيه الـ Admin أو Super Admin
            if ($user->hasRole('admin') || $user->hasRole('super-admin')) {
                return redirect()->route('admin.dashboard');
            }
        
            // توجيه المستخدم العادي
            return view('dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard');
        
        // Route::get('/dashboard', function () {
        //     return view('dashboard');
        // })->middleware(['auth', 'verified'])->name('dashboard');
        
        Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });
        
        
        Route::get('/password-reset-success', function () {
            return view('auth.password-reset-success');
        })->name('password.reset.success');
        
        
        //code using permissoin and roles admin and super admin can acsess(A)
        
        
        
        
        
        
        
        // Route::delete('/units/{id}', [UnitController::class, 'delete'])->name('admin.units.delete');
        
        Route::delete('/units/{id}', [UIController::class, 'delete'])->name('units.delete');
        Route::get('adminUI/dashboardui', [UIController::class, 'index'])->name('admin.dashboard');
        Route::get('/new-users-count', [UserController::class, 'getNewUsersCount'])->name('new.users.count');
        // Route::get('/statistics', [UserController::class, 'getNewUsers']);
        // Route::get('/chart-data', [UIController::class, 'getChartData']);
        
        
        
        Route::get('/properties', [UIController::class, 'showProperties'])->name('properties.show');
        Route::get('/add-properties', [UnitController::class, 'create'])->name('properties.add');
        // Route::post('/admin/units/save/', [UnitController::class, 'save'])->name('admin/units/save');
        // عرض نموذج الرفع
        Route::get('/imports', [UnitController::class, 'importForm'])->name('units.import.form');
        
        // معالجة الرفع
        Route::post('/fileph/import', [UnitController::class, 'importCSV'])->name('units.import');// GET route for showing properties
        // GET route for showing properties
        Route::get('/properties', [UIController::class, 'showProperties'])->name('properties.show');
        Route::get('/property', [UIController::class, 'input'])->name('property.show');
        
        Route::post('/properties/show', [UnitController::class, 'save'])->name('properties.save');
        Route::get('/properties/edit/{id}', [UnitController::class, 'edit'])->name('properties.update');
        Route::put('/properties/edit/{id}', [UnitController::class, 'update'])->name('properties.UPdate');
        Route::get('/developers', [DeveloperController::class, 'index'])->name('developers.show');
        Route::get('/add-developer', [DeveloperController::class, 'create'])->name('developers.add');
        Route::post('/developers/show', [DeveloperController::class, 'store'])->name('developers.save');
        Route::get('/developers/edit/{id}', [DeveloperController::class, 'edit'])->name('developers.update');
        Route::put('/developers/edit/{id}', [DeveloperController::class, 'update'])->name('developers.UPdate');
        Route::get('/developers/{id}/properties', [DeveloperController::class, 'showproperties'])->name('developers.properties');
Route::get('/property/edit/{id}', [DeveloperController::class, 'editproperty'])->name('edit.property');

        Route::get('/developers/{id}/ads', [DeveloperController::class, 'showads'])->name('developers.ads');
        // مسار لعرض العروض الخاصة بالمطور
        Route::get('/developers/{id}/offers', [DeveloperController::class, 'showOffers'])->name('developers.offers');
        
        Route::get('/add-Ads', [DeveloperController::class, 'createads'])->name('Ads.add');
        Route::post('/Ads/show', [DeveloperController::class, 'storeads'])->name('Ads.save');
        Route::get('/offers', [OfferController::class, 'index'])->name('offers.show');
        Route::get('/add_offers', [OfferController::class, 'create'])->name('offers.add');
        Route::post('/offers/store', [OfferController::class, 'store'])->name('offers.store');
        Route::get('/offers/{id}/edit', [OfferController::class, 'edit'])->name('offers.edit');
        Route::put('/offers/{id}', [OfferController::class, 'update'])->name('offers.update');
        
        
        
        Route::get('/compounds', [CompoundController::class, 'index'])->name('compounds.show');
        Route::get('/add_compounds', [CompoundController::class, 'create'])->name('compounds.add');
        Route::post('/compounds/show', [CompoundController::class, 'store'])->name('compounds.save');
        Route::get('/compounds/edit/{id}', [CompoundController::class, 'edit'])->name('compounds.update');
        Route::put('/compounds/edit/{id}', [CompoundController::class, 'update'])->name('compounds.UPdate');
        
        Route::get('/add_projects', [CompoundController::class, 'add'])->name('project.add');
        
        Route::get('/users', [UserController::class, 'index'])->name('users.show');
        // Route::get('/users/create', [UserController::class, 'create'])->name('users.add');
        // Route::post('/users/show', [UserController::class, 'save'])->name('users.save');
        // Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.update');
        // Route::put('/users/edit/{id}', [UserController::class, 'update'])->name('users.UPdate');
        Route::get('/users/delete/{id}', [UserController::class, 'delete'])->name('users.delete');
        
        //as permission for superadmin to manage user
        Route::middleware(['auth', 'permission:manage users'])->group(function () {
            Route::get('/users/create', [UserController::class, 'create'])->name('users.add');
            Route::post('/users/show', [UserController::class, 'save'])->name('users.save');
            Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.update');
            Route::put('/users/edit/{id}', [UserController::class, 'update'])->name('users.UPdate');
        });
        
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.show');
        Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.add');
        Route::post('/sales', [SalesController::class, 'save'])->name('sales.save');
        Route::get('/sales/edit/{id}', [SalesController::class, 'edit'])->name('sales.update');
        Route::put('/sales/edit/{id}', [SalesController::class, 'update'])->name('sales.UPdate');
        Route::delete('/sales/delete/{id}', [SalesController::class, 'delete'])->name('sales.delete');
        
        
        Route::middleware(['auth', 'permission:manage roles &permission'])->group(function () {
        //routes roles الادمن بس
        Route::get('/adminUI/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/adminUI/roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/adminUI/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/adminUI/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/adminUI/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::get('roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');
        //routes permissions الادمن بس
        Route::get('/adminUI/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/adminUI/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/adminUI/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/edit/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('permissions/{id}', [PermissionController::class, 'delete'])->name('permissions.delete');
        });
        
        
        Route::post('/units/import', [FileUploadController::class, 'importCSV'])->name('units.import');
        
        Route::middleware(['auth'])->group(function () {
            Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
        });
        
        
        
        
        
        
        
        
        
        
        Route::get('/upload', function () {
            return view('upload');
        })->name('csv.form');
        
        Route::post('/upload', [FileUploadController::class, 'uploadCSV'])->name('csv.upload');
        
        
        
        
        
        
        
        
        
        
        //Route::delete('/admin/units/delete/{id}', [UnitController::class, 'delete'])->name('units.delete');
        Route::get('/notifications', function () {
            $notifications = Notification::where('user_id', Auth::id())
                ->orWhereNull('user_id')
                ->orderBy('created_at', 'desc')
                ->get();
        
            return response()->json($notifications);
        });
        
        Route::post('/notifications/create', function (Request $request) {
            $notification = Notification::create([
                'type' => $request->input('type'),
                'message' => $request->input('message'),
                'user_id' => $request->input('user_id'),
            ]);
        
            broadcast(new NotificationEvent($notification))->toOthers();
        
            return response()->json(['success' => true, 'notification' => $notification]);
        });
        
        // Route::post('/notifications/create', function (Request $request) {
        //     // طباعة البيانات المستلمة للتأكد منها
        //     dd($request->all());
        
        //     $notification = Notification::create([
        //         'type' => $request->input('type'), // تأكدنا من استخدام `input()` لتجنب الخطأ
        //         'message' => $request->input('message'),
        //         'user_id' => $request->input('user_id'),
        //     ]);
        
        //     broadcast(new NotificationEvent($notification))->toOthers();
        
        //     return response()->json(['success' => true, 'notification' => $notification]);
        // });
        
        // ???????????????????????????????????????????????????????????????????????????????????????????????????????????????
        Route::prefix('bookings')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('bookings.index');
            Route::get('/create', [BookingController::class, 'create'])->name('bookings.create');
            Route::post('/', [BookingController::class, 'store'])->name('bookings.store');
            Route::get('/{booking}', [BookingController::class, 'show'])->name('bookings.show');
            Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
            Route::put('/{booking}', [BookingController::class, 'update'])->name('bookings.update');
            Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
            Route::post('/{booking}/actions', [BookingController::class, 'addAction'])->name('bookings.actions.store');
        });
         Route::put('/bookings/{id}/add-action', [BookingController::class, 'addction'])
    ->name('bookings.addAction');
        
        Route::post('/notifications/{notification}/mark-read', [UIController::class, 'markAsRead']);
        Route::get('/notifications/unread', [UIController::class, 'getUnreadNotifications']);
        Route::get('/chart', [UIController::class, 'dashboard']);
        Route::get('/charts', [UIController::class, 'showCharts']);
        
        
        
        // Mark all as read
        // Mark all as read
        // Route::post('/notifications/mark-read', function () {
        //     $updated = Notification::where('user_id', Auth::id())
        //         ->orWhereNull('user_id')
        //         ->where('is_read', false)
        //         ->update(['is_read' => true]); // التحديث المباشر
        
        //     return response()->json(['success' => $updated > 0]);
        // });
        
        // // Mark single as read
        // Route::post('/notifications/{notification}/mark-read', function (Notification $notification) {
        //     $notification->update(['is_read' => true]);
        //     return response()->json(['success' => true]);
        // });
        
        Route::post('/units/import1', [UnitController::class, 'import'])->name('units.import');
        });
        
        Route::view('/privacy_policy', 'privacy_policy')->name('privacy_policy');
        Route::view('/chat_support', 'chat_support')->name('chat_support');



require __DIR__.'/auth.php';
