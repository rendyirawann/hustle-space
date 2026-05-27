<?php

use Illuminate\Support\Facades\Route;

// Import Controller Dashboard
use App\Http\Controllers\Backend\Dashboard\DashboardAdminController; // Sesuaikan jika nama controllernya beda
// Import Controller PROFILE
use App\Http\Controllers\Backend\MyProfile\AccountController;
use App\Http\Controllers\Backend\MyProfile\ProfileController;
use App\Http\Controllers\Backend\MyProfile\SecurityController;
use App\Http\Controllers\Backend\MyProfile\ActivityController;
use App\Http\Controllers\Backend\MyProfile\LoginSessionController;

// Import Controller USER MANAGEMENT
use App\Http\Controllers\Backend\UserManagement\UserController;
use App\Http\Controllers\Backend\UserManagement\RoleController;

// Import Controller HELP/LOG
use App\Http\Controllers\Backend\Help\LogActivityController;
use App\Http\Controllers\Backend\Settings\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Halaman Depan (Langsung diarahkan ke Login)
// Halaman Depan (Langsung diarahkan ke Login)
Route::get('/', function () {
    return view('landing');
});

Route::get('/hustle-posed', function () {
    return view('photobooth', ['mode' => 'demo']);
})->name('hustle-posed.demo');

Route::middleware('guest')->group(function () {
    Route::get('/hustle-posed/login', function () {
        return view('photobooth_login');
    })->name('hustle-posed.login');

    Route::post('/hustle-posed/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Do not use intended(), force redirect to photobooth pro
            return redirect('/hustle-posed-pro');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    })->name('hustle-posed.login.submit');
});

use App\Http\Controllers\Frontend\CustomFrameController;

Route::middleware(['auth', 'check.subscription'])->group(function () {
    Route::get('/hustle-posed-pro', function () {
        return view('photobooth', ['mode' => 'pro']);
    })->name('hustle-posed.pro');

    Route::get('/hustle-posed-pro/frame-creation', [CustomFrameController::class, 'index'])->name('hustle-posed.frame-creation');
    Route::post('/api/photobooth/custom-frames', [CustomFrameController::class, 'store']);
    Route::post('/api/photobooth/custom-frames/upload', [CustomFrameController::class, 'uploadImage']);
    Route::delete('/api/photobooth/custom-frames/{id}', [CustomFrameController::class, 'destroy']);
    Route::put('/api/photobooth/custom-frames/{id}/publish', [CustomFrameController::class, 'togglePublish']);
});

Route::get('/api/photobooth/custom-frames', [CustomFrameController::class, 'getList']);


// Photobooth internal API limits
use App\Http\Controllers\Frontend\PhotoboothController;
use App\Http\Controllers\Frontend\GalleryController;

// Public routes for Spotlight Gallery
Route::get('/hustle-moments', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/api/photobooth/publish', [GalleryController::class, 'publish'])->name('photobooth.publish');
Route::post('/api/photobooth/capture', [PhotoboothController::class, 'checkCapture'])->name('photobooth.capture');
Route::post('/api/photobooth/download', [PhotoboothController::class, 'checkDownload'])->name('photobooth.download');
Route::post('/api/photobooth/ai-enhance', [\App\Http\Controllers\Backend\AIEnhanceController::class, 'enhance']);

Route::any('/dine-sync-pos', function () {
    return redirect('/admin/login');
});



// --- TARUH DEBUG DISINI (DI LUAR MIDDLEWARE AUTH) ---
Route::get('/admin/debug-session', function () {
    $user = auth()->user();

    // Cek manual apakah tabel bans error
    $bannedStatus = 'Tidak dicek';
    $error = null;

    if ($user) {
        try {
            // Kita coba panggil paksa relasi banned-nya
            $bannedStatus = $user->isBanned() ? 'YA TER-BANNED' : 'AMAN';
        } catch (\Exception $e) {
            $bannedStatus = 'ERROR SAAT CEK BANNED: ' . $e->getMessage();
        }
    }

    return [
        'status_login' => $user ? 'SUDAH LOGIN' : 'BELUM LOGIN / SESI HILANG',
        'user_id' => $user?->id,
        'user_name' => $user?->name,
        'session_id' => session()->getId(),
        'driver_session' => config('session.driver'),
        'cek_banned' => $bannedStatus,
    ];
});

// NOTE: Route /login POST dihapus dari sini karena sudah ada di auth.php
// agar tidak bentrok "Route [login] defined twice".

// Group Middleware untuk User yang sudah Login
// Kita tambahkan 'forbid-banned-user' agar user yang di-banned tidak bisa akses
Route::middleware(['auth', 'forbid-banned-user'])->group(function () {

    // --- SHARED ROLE ROUTES (generate-permissions helper, select) ---
    Route::post('/admin/roles/generate-permissions', [RoleController::class, 'generatePermissions'])->name('roles.generate');
    Route::get('/admin/select/role', [RoleController::class, 'select'])->name('role.select');

    // --- DASHBOARD (accessible by ALL authenticated roles) ---
    Route::get('/admin/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // --- MY ACCOUNT / PROFILE (accessible by ALL authenticated users) ---
    Route::get('/admin/my-account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/admin/my-account/{id}/avatar', [AccountController::class, 'editAvatar'])->name('avatar-edit');
    Route::post('/admin/my-account/{id}/update-avatar', [AccountController::class, 'updateAvatar'])->name('avatar-update');

    // --- PUBLISHED PHOTOS (Admin moderation) ---
    Route::get('/admin/published-photos', [\App\Http\Controllers\Backend\PublishedPhotoController::class, 'index'])->name('published-photos.index');
    Route::delete('/admin/published-photos/{id}', [\App\Http\Controllers\Backend\PublishedPhotoController::class, 'destroy'])->name('published-photos.destroy');

    Route::resource('/admin/my-profile', ProfileController::class);
    Route::resource('/admin/my-security', SecurityController::class);
    Route::post('/admin/my-security', [SecurityController::class, 'store'])->name('change.password');
    Route::post('/admin/my-security/logout-other-devices', [SecurityController::class, 'logoutOtherDevices'])->name('security.logout-other-devices');
    
    // Override logout route redirect
    Route::post('/hustle-posed/logout', function (\Illuminate\Http\Request $request) {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/hustle-posed');
    })->name('hustle-posed.logout');

    Route::get('/admin/my-activity', [ActivityController::class, 'index'])->name('my-activity.index');
    Route::get('/admin/mget-my-activity', [ActivityController::class, 'getActivity'])->name('get-my-activity');

    Route::get('/admin/mmy-login-session', [LoginSessionController::class, 'index'])->name('my-login-session.index');
    Route::get('/admin/mget-my-login-session', [LoginSessionController::class, 'getLoginSession'])->name('get-my-login-session');

    // --- SETTINGS (accessible by ALL authenticated users) ---
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/admin/settings/update', [SettingController::class, 'update'])->name('settings.update');

    // --- DEBUG/CHECK AUTH ---
    Route::get('/admin/check-auth', function () {
        $u = auth()->user();
        return [
            'user' => $u,
            'roles' => $u?->getRoleNames(),
            'permissions' => $u?->getAllPermissions()->pluck('name'),
        ];
    });
    Route::get('/admin/debug-session', function () {
        $user = auth()->user();
        return ['user' => $user?->name, 'roles' => $user?->getRoleNames()];
    });

    // ====================================================
    // RESOURCES (User & Role Mgmt): view_resources — Superadmin only
    // ====================================================
    Route::middleware('can:view_resources')->group(function () {
        Route::resource('/admin/users', UserController::class);
        Route::get('/admin/get-datauser', [UserController::class, 'getDataUsers'])->name('get-users');
        Route::post('/admin/users/mass-delete', [UserController::class, 'massDelete'])->name('users.mass-delete');
        Route::get('/admin/get-user-show-log/{id}', [UserController::class, 'getLoginSession'])->name('get-user-show-log');
        Route::get('/admin/get-user-show-log-activity/{id}', [UserController::class, 'getActivity'])->name('get-user-show-log-activity');
        Route::post('/admin/users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::post('/admin/users/{id}/unban', [UserController::class, 'unban'])->name('users.unban');

        Route::resource('/admin/roles', RoleController::class);
        Route::get('/admin/get-datarole', [RoleController::class, 'getDataRoles'])->name('get-datarole');
        Route::post('/admin/roles/mass-delete', [RoleController::class, 'massDelete'])->name('roles.mass-delete');
    });

    // ====================================================
    // HELP (Log Activity): view_help — Superadmin, admin
    // ====================================================
    Route::middleware('can:view_help')->group(function () {
        Route::resource('/admin/log-activity', LogActivityController::class);
        Route::get('/admin/get-datalogactivity', [LogActivityController::class, 'getDataLogActivity'])->name('get-datalogactivity');
    });
});

// Load Routes Authentication (Login, Register, Reset Password)
require __DIR__ . '/auth.php';
