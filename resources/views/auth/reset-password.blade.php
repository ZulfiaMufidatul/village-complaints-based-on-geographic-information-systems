@extends('auth.layouts')

@section('title')
    Lupa Kata Sandi
@endsection

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-3">Reset Kata Sandi</h2>
        <p class="text-center mb-6">Silahkan masukan kata sandi baru anda.</p>
        @error('error')
            <p class="text-red-500 font-medium">{{ $message }}</p>
        @enderror
        <form action="{{ route('reset-password.post') }}" method="post" class="flex flex-col gap-4">
            @csrf
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Baru</label>
                <div class="relative">
                    <input required :type="show ? 'text' : 'password'" name="password" id="password"
                        class="mt-1 px-4 py-2 border block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Masukkan kata sandi">
                    <button type="button" class="absolute right-3 top-[10px] text-sm text-gray-500" @click="show = !show">
                        <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ show: false }">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input required :type="show ? 'text' : 'password'" name="password_confirmation" id="password_confirmation"
                        class="mt-1 px-4 py-2 border block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Masukkan kata sandi">
                    <button type="button" class="absolute right-3 top-[10px] text-sm text-gray-500" @click="show = !show">
                        <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded-md font-semibold hover:bg-blue-900 transition-colors">Reset Kata Sandi</button>
            <div class="mt-4 flex justify-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 hover:underline transition-colors">Kembali ke halaman login</a>
            </div>
        </form>
    </div>
@endsection
