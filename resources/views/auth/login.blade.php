@extends('auth.layouts')

@section('title')
    Masuk
@endsection

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
         {{-- <!-- Logo -->
        <div class="flex justify-center mb-0">
            <img src="{{ asset('images/brand-logo.svg') }}" alt="Logo" class="h-40 w-40 object-contain">
        </div> --}}

        <h2 class="text-2xl font-bold text-center mt-0 mb-3">Masuk</h2>
        <form action="{{ route('login.post') }}" method="post" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input required type="email" name="email" id="email"
                    value="{{ old('email') }}"
                    class="mt-1 px-4 py-2 border block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan email">
            </div>
            <div x-data="{ show: false }">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input required :type="show ? 'text' : 'password'" name="password" id="password"
                        class="mt-1 px-4 py-2 border block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Masukkan kata sandi">
                    <button type="button" class="absolute right-3 top-[10px] text-sm text-gray-500" @click="show = !show">
                        <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                    </button>
                </div>
                <div class="mt-2 text-sm underline text-right">
                    <a href="{{ route('forgot-password') }}" class="text-indigo-600 hover:text-indigo-900">Lupa kata sandi?</a>
                </div>
            </div>
            @error('error')
                    <p class="text-sm text-red-600 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            <div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md font-semibold hover:bg-indigo-700 transition-colors">Masuk</button>
            </div>
            <div class="text-center">Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700">Daftar</a></div>
        </form>
    </div>
@endsection

@push('scripts')
    @if (session('reset-password'))
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('reset-password') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
@endpush