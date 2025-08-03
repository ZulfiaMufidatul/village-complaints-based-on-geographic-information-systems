<div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-50">
    <div class="mx-auto px-14">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold">SIPKIN Bulakan</h1>
                    <p class="text-sm opacity-90">Sistem Pengaduan Kerusakan Infrastruktur</p>
                </div>
            </div>

            <div>
                @if (Auth::check())
                <div x-data="{profile: false}" class="relative">
                    <button @click="profile = !profile" class="px-4 py-2 rounded-md text-white transition-all duration-300 hover:bg-white hover:text-blue-600 font-semibold flex items-center gap-2">
                        {{ $user->name }} <span><i class="fa-solid fa-chevron-down text-xs transform transition-all" :class="profile ? 'rotate-180' : ''"></i></span>
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