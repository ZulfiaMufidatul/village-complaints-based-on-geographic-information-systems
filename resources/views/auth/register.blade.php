@extends('auth.layouts')

@section('content')
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Daftar</h2>

        <form action="{{ route('register.post') }}" method="post" class="space-y-4">
            @csrf

            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input required type="text" name="nik" id="nik"
                    value="{{ old('nik') }}"
                    class="mt-1 px-4 py-2 border block w-full rounded-md shadow-sm sm:text-sm
                        {{ $errors->has('nik') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                    placeholder="Masukkan NIK">
                @error('nik')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input required type="text" name="name" id="name"
                    value="{{ old('name') }}"
                    class="mt-1 px-4 py-2 border block w-full rounded-md shadow-sm sm:text-sm
                        {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                    placeholder="Masukkan nama">
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input required type="email" name="email" id="email"
                    value="{{ old('email') }}"
                    class="mt-1 px-4 py-2 border block w-full rounded-md shadow-sm sm:text-sm
                        {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                    placeholder="Masukkan email">
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input required type="password" name="password" id="password"
                    class="mt-1 px-4 py-2 border block w-full rounded-md shadow-sm sm:text-sm
                        {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                    placeholder="Masukkan password">
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input required type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 px-4 py-2 border block w-full rounded-md shadow-sm sm:text-sm
                        {{ $errors->has('password_confirmation') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500' }}"
                    placeholder="Masukkan konfirmasi password">
                @error('password_confirmation')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition-colors">
                    Daftar
                </button>
            </div>

            <div class="text-center">Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Masuk</a>
            </div>
        </form>
    </div>
@endsection