@extends('complaints.layouts.app')

@section('title')
    Profil
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-center">Profil</h1>
            <a href="{{ route('index') }}" class="px-4 py-2 rounded-md transition-all duration-300 hover:bg-white hover:text-blue-600 font-semibold flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        <div class="bg-white px-10 py-6 rounded-lg shadow flex flex-col gap-6 mt-6">
            <h2 class="text-lg font-bold">Informasi Akun</h2>
            
            <form action="{{ route('profile.update-account') }}" method="post" class="flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-2">
                    <label for="nik" class="text-sm font-medium">NIK</label>
                    <input type="text" id="nik" name="nik" disabled class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $user->nik->value }}">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="name" class="text-sm font-medium">Nama</label>
                    <input type="text" id="name" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $user->name }}">
                </div>
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm font-medium">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $user->email }}">
                </div>

                <div class="text-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white px-10 py-6 rounded-lg shadow flex flex-col gap-6 mt-6">
            <h2 class="text-lg font-bold">Ubah Kata Sandi</h2>
            <form action="{{ route('profile.update-password') }}" method="post" class="flex flex-col gap-4">
                @csrf

                <div class="flex flex-col gap-2" x-data="{ show: false }">
                    <label for="old_password" class="text-sm font-medium">Kata Sandi Lama</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="old_password" id="old_password"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                            placeholder="Masukkan Kata Sandi Lama"
                            value="{{ old('old_password') }}">
                        <button type="button" class="absolute right-2 top-3 text-sm text-gray-500" @click="show = !show" >
                            <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                        </button>
                    </div>
                    @error('old_password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex flex-col gap-2" x-data="{ show: false }">
                    <label for="new_password" class="text-sm font-medium">Kata Sandi Baru</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="new_password" id="new_password"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                            placeholder="Masukkan Kata Sandi Baru"
                            value="{{ old('new_password') }}">
                        <button type="button" class="absolute right-2 top-3 text-sm text-gray-500" @click="show = !show">
                            <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex flex-col gap-2" x-data="{ show: false }">
                    <label for="confirm_password" class="text-sm font-medium">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="confirm_password" id="confirm_password"
                            class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"
                            placeholder="Ulangi Kata Sandi Baru"
                            value="{{ old('confirm_password') }}">
                        <button type="button" class="absolute right-2 top-3 text-sm text-gray-500" @click="show = !show">
                            <span><i :class="show ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i></span>
                        </button>
                    </div>
                    @error('confirm_password')
                        <p class="text-red-500 text-sm font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('password'))
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('password') }}',
                icon: 'success',
            });
        </script>
    @endif
    @if (session('account'))
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: '{{ session('account') }}',
                icon: 'success',
            });
        </script>
    @endif
@endpush