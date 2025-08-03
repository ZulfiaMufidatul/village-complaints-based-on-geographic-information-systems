@extends('auth.layouts')

@section('title')
    Verifikasi Email
@endsection

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Verifikasi Email</h2>
        <p class="text-center mb-6">Kami sudah mengirimkan kode verifikasi ke email <span class="font-semibold">{{ $user->email }}</span>. Silakan masukkan kode verifikasi di bawah ini.</p>
        @error('error')
            <p class="text-red-500 font-medium">{{ $message }}</p>
        @enderror
        <form action="{{ route('verify-email.post') }}" method="post" class="flex flex-col gap-2">
            @csrf
            <input type="text" name="verification_code" placeholder="Kode Verifikasi" class="w-full p-2 rounded-md border border-gray-300">
            @error('verification_code')
                <p class="text-red-500 font-medium">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Verifikasi</button>
        </form>
        <div class="mt-2">
            <a href="{{ route('resend-verification-email') }}" class="text-blue-500 hover:underline ">Kirim ulang kode verifikasi</a>
        </div>
    </div>
@endsection
