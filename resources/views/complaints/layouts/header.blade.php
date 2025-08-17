<div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-50">
    <div class="mx-auto px-14">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="h-12 bg-white/70 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('images/brand-logo.svg') }}" alt="MAPIN Bulakan" class="h-full">
                </div>
                {{-- <div>
                    <h1 class="text-xl font-bold">MAPIN Bulakan</h1>
                    <p class="text-sm opacity-90">Sistem Pengaduan Kerusakan Infrastruktur</p>
                </div> --}}
            </div>

            <div>
                @if (Auth::check())
                <div x-data="{profile: false}" class="relative">
                    <button @click="profile = !profile" class="px-4 py-2 rounded-md text-white transition-all duration-300 hover:bg-white hover:text-blue-600 font-semibold flex items-center gap-2">
                        {{ auth()->user()->name }} <span><i class="fa-solid fa-chevron-down text-xs transform transition-all" :class="profile ? 'rotate-180' : ''"></i></span>
                    </button>
                    <div x-cloak @click.away="profile = !profile" x-show="profile" class="absolute right-0 mt-2 w-36 bg-white shadow-lg rounded-md py-2">
                        <a href="{{ route('profile') }}" class="w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100 font-medium flex items-center gap-2">
                            <i class="fa-regular fa-circle-user"></i> 
                            <span>Profil</span>
                        </a>
                        <button id="logoutBtn" class="w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100 font-medium flex items-center gap-2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-white transition-all duration-300 hover:bg-white hover:text-blue-600 font-semibold"> 
                    Masuk
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.getElementById('logoutBtn').addEventListener('click', () => {
            Swal.fire({
                title: 'Anda yakin ingin keluar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('logout') }}';
                }
            });
        });
    </script>
@endpush