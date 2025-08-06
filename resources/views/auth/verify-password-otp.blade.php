@extends('auth.layouts')

@section('title')
    Verifikasi Kode OTP
@endsection

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Verifikasi Kode OTP</h2>
        <p class="text-center mb-6">Masukkan kode OTP yang telah dikirim ke email <span class="font-semibold">{{ session('password_reset_email') }}</span></p>
        @error('error')
            <p class="text-red-500 font-medium">{{ $message }}</p>
        @enderror

        {{-- <span>Kode Otp : {{ session('password_reset_otp') }}</span> --}}
        <form action="{{ route('verify-password-otp') }}" method="post" class="flex flex-col gap-2">
            @csrf
            <input type="number" name="otp" placeholder="Kode OTP" required min="100000" max="999999"
                class="w-full p-2 rounded-md border border-gray-300">
            @error('otp')
                <p class="text-red-500 font-medium">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md font-semibold hover:bg-blue-600 transition-colors">Submit</button>
        </form>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('forgot-password') }}" class="text-blue-600 hover:text-blue-700 hover:underline transition-colors">Kembali ke halaman input email</a>
        </div>
    </div>
@endsection