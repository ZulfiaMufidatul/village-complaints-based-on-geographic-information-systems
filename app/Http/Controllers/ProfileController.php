<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('complaints.profile.index', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'old_password.required' => 'Kata sandi lama wajib diisi.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
            'confirm_password.required' => 'Konfirmasi kata sandi baru wajib diisi.',
            'confirm_password.same' => 'Konfirmasi kata sandi baru tidak sesuai.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Kata sandi lama tidak sesuai.'])->withInput();
        }

        $user->password = Hash::make($request->new_password);
        try {
            $user->save();
        } catch (Exception $e) {
            return back()->with(['password' => 'Gagal memperbarui kata sandi.'])->withInput();
        }

        return back()->with('password', 'Kata sandi berhasil diperbarui.');
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        try {
            $user->save();
        } catch (Exception $e) {
            return back()->with(['account' => 'Gagal memperbarui informasi akun.'])->withInput();
        }

        return back()->with('account', 'Informasi akun berhasil diperbarui.');
    }
}
