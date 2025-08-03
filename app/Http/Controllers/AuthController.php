<?php

namespace App\Http\Controllers;

use App\Models\NIK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.',
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

        return redirect()->route('index')->with('success', 'Akun berhasil dibuat, silahkan login');
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
