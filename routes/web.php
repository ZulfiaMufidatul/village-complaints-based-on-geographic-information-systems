<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [ComplaintController::class, 'index'])->name('index');
Route::middleware(['auth', 'verified'])->group(function () {
    // POST track (via form pencarian)
    Route::post('/track', [ComplaintController::class, 'track'])->name('complaints.track.post');
    // GET track (via link di email)

    Route::get('/track/{complaints_code}', [ComplaintController::class, 'trackCode'])->name('complaints.track');
    Route::get('/track/{complaints_code}/detail', [ComplaintController::class, 'showDetail'])->name('complaints.detail');
    
    Route::get('/complaints', [ComplaintController::class, 'create'])->name('complaints.create');
    Route::post('/complaints/store', [ComplaintController::class, 'store'])->name('complaints.store')->middleware("throttle:complaints");
});

Route::get('/get-rw/{hamletId}', [ComplaintController::class, 'getRW']);
Route::get('/get-rt/{hamletId}/{rwId}', [ComplaintController::class, 'getRT']);

// Export PDF Data
Route::get('/export-pdf', [ExportController::class, 'exportPdf'])->name('exportToPdf');

// Authentication
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

// Forget Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
Route::post('/send-password-otp', [AuthController::class, 'sendPasswordOTP'])->name('send-password-otp');

// Verification Password OTP
Route::get('/verify-password-otp', [AuthController::class, 'verifyPasswordOTPView'])->name('verify-password-otp');
Route::post('/verify-password-otp', [AuthController::class, 'verifyPasswordOTP'])->name('verify-password-otp');

// Reset Password
Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
Route::post('/reset-password', [AuthController::class, 'resetPasswordPost'])->name('reset-password.post');

// Register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::get('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email');
Route::post('/verify-email', [AuthController::class, 'verifyEmailPost'])->name('verify-email.post');
Route::get('/resend-verification-email', [AuthController::class, 'resendVerificationEmail'])->name('resend-verification-email');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
Route::post('/profile/update-account', [ProfileController::class, 'updateAccount'])->name('profile.update-account');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');