<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Mail\VerificationEmail;
use App\Models\NIK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('index')->with('success', 'Berhasil login');
        }
    
        return redirect()->route('login')
            ->withErrors(['error' => 'Email atau password salah'])
            ->withInput($request->only('email'));
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:nik,value',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
        ], [
            'nik.required' => 'NIK wajib diisi.',
            'nik.exists' => 'NIK tidak ditemukan sebagai warga Bulakan.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $nik = NIK::where('value', $request->nik)->first();

        $existingUser = User::where('nik_id', $nik->id)->first();
        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['nik' => 'NIK ini sudah digunakan oleh user lain.'])
                ->withInput();
        }
        $user = User::create([
            'nik_id' => $nik->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('public');

        Auth::login($user);

        $verification_code = Str::random(6);

        Mail::to($user->email)->send(new VerificationEmail($user, $verification_code));

        Cache::put('verification_code.'.$user->id, $verification_code, now()->addMinutes(10));
        return redirect()->route('verify-email');
    }

    public function verifyEmail()
    {
        $user = Auth::user();
        return view('auth.verify-email', compact('user'));
    }

    public function resendVerificationEmail()
    {
        $user = Auth::user();
        $verification_code = Str::random(6);

        Mail::to($user->email)->send(new VerificationEmail($user, $verification_code));
        Cache::put('verification_code.'.$user->id, $verification_code, now()->addMinutes(10));
        return redirect()->route('verify-email');
    }

    public function verifyEmailPost(Request $request)
    {
        $request->validate([
            'verification_code' => 'required',
        ], [
            'verification_code.required' => 'Kode verifikasi wajib diisi.',
        ]);

        $user = Auth::user();
        $verification_code = Cache::get('verification_code.'.$user->id);
        
        if ($request->verification_code !== $verification_code) {
            return redirect()->route('verify-email')->withErrors(['verification_code' => 'Kode verifikasi tidak valid.']);
        }

        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('index')->with('success', 'Akun berhasil diverifikasi.');
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak ditemukan.',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $otp = rand(100000, 999999);

        session([
            'password_reset_email' => $request->email,
            'password_reset_otp' => $otp,
        ]);

        Mail::to($user->email)->send(new ForgotPassword($user, $otp));

        return redirect()->route('verify-password-otp');
    }

    public function verifyPasswordOTPView()
    {
        return view('auth.verify-password-otp');
    }

    public function verifyPasswordOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ], [
            'otp.required' => 'Kode verifikasi wajib diisi.',
        ]);

        
        if ((int) $request->otp !== session('password_reset_otp')) {
            session()->put('password_reset_email', session('password_reset_email'));
            session()->put('password_reset_otp', session('password_reset_otp'));
            return redirect()->route('verify-password-otp')->withErrors(['otp' => 'Kode verifikasi tidak valid.']);
        }

        session()->put('password_reset_email', session('password_reset_email'));
        session()->forget('password_reset_otp');
        session()->put('can_reset_password', true);
        return redirect()->route('reset-password');
    }

    public function resetPassword()
    {
        if (!session('can_reset_password')) {
            return redirect()->route('login');
        }
        return view('auth.reset-password');
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password_confirmation.required' => 'Konfirmasi kata sandi wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi kata sandi tidak cocok.',
        ]);
        
        $user = User::where('email', session('password_reset_email'))->first();
        
        if (!$user) {
            return redirect()->route('reset-password')->withErrors(['error' => 'User tidak ditemukan.']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        session()->forget('password_reset_email');
        session()->forget('can_reset_password');
        
        return redirect()->route('login')->with('reset-password', 'Kata sandi berhasil diubah.');
    }

    public function logout()
    {
        $auth = Auth::user();
        if ($auth) {
            Auth::logout();
            return redirect()->route('index')->with('success', 'Berhasil logout');
        }

        return redirect()->route('index')->with('error', 'Gagal logout');
    }
}
