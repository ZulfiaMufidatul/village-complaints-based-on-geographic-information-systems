@extends('auth.layouts')

@section('title')
    Lupa Kata Sandi
@endsection

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Lupa Kata Sandi</h2>
        <p class="text-center mb-6">Masukkan email anda untuk mendapatkan kode verifikasi</p>
        @error('error')
            <p class="text-red-500 font-medium">{{ $message }}</p>
        @enderror

        <form action="{{ route('send-password-otp') }}" method="post" class="flex flex-col gap-2">
            @csrf
            <input type="text" name="email" placeholder="Email"
                class="w-full p-2 rounded-md border border-gray-300">
            @error('email')
                <p class="text-red-500 font-medium">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md font-semibold hover:bg-blue-900 transition-colors">Submit</button>
        </form>

        <div class="mt-4 flex justify-center">
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 hover:underline transition-colors">Kembali ke halaman login</a>
        </div>
    </div>
@endsection
