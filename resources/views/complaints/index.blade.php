@extends('complaints.layouts.app')

@section('title')
    Beranda Pengaduan Infrastruktur
@endsection
@section('content')
    <div class="container mx-auto px-4 py-8 space-y-6">
        <div class="bg-white shadow-md rounded-lg py-12 px-6 md:px-10 mb-6 mt-6 card-hover">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                {{-- Tagline --}}
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 leading-snug">
                        Laporkan Kerusakan Infrastruktur, <br>
                        Wujudkan Lingkungan Nyaman
                    </h2>
                    <p class="text-gray-600 mt-4">
                        Sistem Pengaduan Kerusakan Infrastruktur Kelurahan Bulakan.
                    </p>
                    <p class="text-gray-600">
                        Mulai laporan Anda sekarang dengan mudah dan cepat.
                    </p>
                    <a href="{{ route('complaints.create') }}"
                        class="mt-6 inline-block bg-blue-600 text-white font-semibold px-6 py-3 rounded shadow hover:bg-blue-800 transition">
                        Buat Aduan Sekarang
                    </a>
                </div>

                {{-- Gambar dan Ikon --}}
                <div class="relative">
                    <div class=" w-[80%] h-[85%] absolute top-5 left-5 z-0"></div>
                    <img src="{{ asset('images/dashboard.jpg') }}" alt="Warga lapor" class="relative z-10 " />
                </div>
            </div>
        </div>

        <!-- FORM CARI -->
        <div data-aos="fade-up" class="bg-white p-6 rounded-lg shadow-md card-hover">
            <h2 class="text-lg font-semibold mb-2">Sudah pernah melapor?</h2>
            <p class="text-sm text-gray-500">Masukkan kode aduan Anda untuk melihat perkembangannya.</p><br>
            <form action="{{ route('complaints.track.post') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="complaints_code" placeholder="Masukkan Kode Aduan"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-400">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Cari</button>
            </form>
        </div>

        <!-- HASIL PENCARIAN -->
        @if (isset($searchedCode))
            <div class="bg-white rounded-lg border-t mt-8 pt-4 card-hover">
                <h2 class="text-center text-lg font-semibold mb-4 pb-4 border-b">Hasil Pencarian</h2>

                @if ($complaint)
                    <div class="flex flex-col sm:flex-row bg-white shadow-md rounded-lg p-4 gap-4">
                        {{-- Foto --}}
                        <div class="sm:w-1/3 flex flex-col items-center">
                            @if ($complaint->photo)
                                <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Aduan"
                                    class="rounded w-full object-cover max-h-48 ring-1 ring-gray-300">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                                    Tidak ada foto
                                </div>
                            @endif

                            <a href="{{ route('complaints.detail', $complaint->complaints_code) }}"
                                class="mt-3 inline-block w-full bg-blue-200 text-blue-500 text-center font-semibold py-1.5 rounded">
                                Detail
                            </a>
                        </div>

                        {{-- Detail --}}
                        <div class="sm:w-2/3 flex flex-col justify-between space-y-1">
                            <p class="text-blue-500 font-semibold text-base">Aduan Mengenai Kerusakan Infrastruktur
                                {{ $complaint->infrastructure_category }}</p>
                            <p class="text-sm text-gray-500">Oleh : {{ $complaint->name }}</p>
                            <p class="text-blue-500 font-medium mt-2">Dusun : {{ $complaint->hamlet }}</p>
                            <p class="text-sm">Rt : {{ $complaint->rt }}</p>
                            <p class="text-sm">Rw : {{ $complaint->rw }}</p>

                            @php
                                $statusMap = [
                                    'pending' => ['Menunggu', 'text-yellow-700 bg-yellow-100'],
                                    'cancel' => ['Dibatalkan', 'text-red-700 bg-red-100'],
                                    'process' => ['Diproses', 'text-blue-700 bg-blue-100'],
                                    'done' => ['Selesai', 'text-green-700 bg-green-100'],
                                ];

                                $statusKey = strtolower($complaint->status_complaint);
                                $status = $statusMap[$statusKey] ?? [
                                    'Status Tidak Dikenal',
                                    'bg-gray-100 text-gray-700',
                                ];
                            @endphp

                            {{-- <span class="mt-4 w-fit inline-block px-4 py-1.5 rounded text-sm {{ $statusStyle }}"> --}}
                            <span
                                class="mt-3 w-24 inline-block py-1.5 text-center font-semibold rounded {{ $status[1] }}">
                                {{ $status[0] }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="bg-white pt-6 text-center">
                        <div class="bg-gray-200 text-sm rounded px-6 py-3 mb-6 inline-block">
                            <span class="text-red-600 font-semibold">Data Tidak Ditemukan.</span>
                            <span class="text-gray-600"> Periksa Kode Anda</span><br>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        {{-- Aduan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mt-6">
            @foreach ($complaints as $c)
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                    {{-- Foto --}}
                    @if ($c->photo)
                        <img src="{{ asset('storage/' . $c->photo) }}" class="w-full h-32 object-cover" alt="Foto Aduan">
                    @else
                        <div class="w-full h-32 bg-gray-200 flex items-center justify-center text-gray-500">
                            Tidak ada foto
                        </div>
                    @endif

                    <div class="p-4">

                        {{-- Judul Aduan --}}
                        <h4 class="font-bold text-md mb-2">{{ $c->infrastructure_category ?? '-' }}</h4>

                        {{-- Alamat + Tanggal --}}
                        <p class="text-xs text-blue-600 font-medium mb-2">
                            Dusun {{ $c->hamlet }} • {{ $c->rt }}/{{ $c->rw }}
                        </p>
                        <p class="text-xs text-gray-500 mb-2">
                            {{ $c->created_at->format('d M Y') }}
                        </p>

                        {{-- Status --}}
                        @php
                            $statusMap = [
                                'pending' => ['Menunggu', 'bg-yellow-100 text-yellow-700'],
                                'cancel' => ['Dibatalkan', 'bg-red-100 text-red-700'],
                                'process' => ['Diproses', 'bg-blue-100 text-blue-700'],
                                'done' => ['Selesai', 'bg-green-100 text-green-700'],
                            ];

                            $statusKey = strtolower($c->status_complaint);
                            $status = $statusMap[$statusKey] ?? ['Tidak Diketahui', 'bg-gray-100 text-gray-700'];
                        @endphp

                        <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-medium rounded {{ $status[1] }}">
                            {{ $status[0] }}
                        </span>

                        {{-- Tombol Detail
                        <a href="{{ route('complaints.detail', $c->complaints_code) }}"
                            class="block w-full mt-4 text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Detail
                        </a> --}}
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginasi --}}
        {{-- Custom Pagination --}}
        @if ($complaints->hasPages())
            <div class="flex items-center justify-between bg-white px-4 py-3 border border-gray-200 rounded-lg shadow-sm">
                {{-- Info Results --}}
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($complaints->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default leading-5 rounded-md">
                            « Previous
                        </span>
                    @else
                        <a href="{{ $complaints->previousPageUrl() }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            « Previous
                        </a>
                    @endif

                    @if ($complaints->hasMorePages())
                        <a href="{{ $complaints->nextPageUrl() }}"
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-blue-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            Next »
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-gray-100 border border-gray-300 cursor-default leading-5 rounded-md">
                            Next »
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    {{-- Results Info --}}
                    <div>
                        <p class="text-sm text-gray-600 leading-5">
                            Menampilkan
                            <span class="font-semibold text-gray-800">{{ $complaints->firstItem() }}</span>
                            sampai
                            <span class="font-semibold text-gray-800">{{ $complaints->lastItem() }}</span>
                            dari
                            <span class="font-semibold text-gray-800">{{ $complaints->total() }}</span>
                            Data Aduan
                        </p>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="flex items-center space-x-1">
                        {{-- Previous Button --}}
                        @if ($complaints->onFirstPage())
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 text-gray-400 bg-gray-100 rounded-full cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $complaints->previousPageUrl() }}"
                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 bg-white border border-gray-300 rounded-full hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($complaints->getUrlRange(1, $complaints->lastPage()) as $page => $url)
                            @if ($page == $complaints->currentPage())
                                <span
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-blue-600 rounded-full shadow-sm">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($complaints->hasMorePages())
                            <a href="{{ $complaints->nextPageUrl() }}"
                                class="inline-flex items-center justify-center w-8 h-8 text-gray-600 bg-white border border-gray-300 rounded-full hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @else
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 text-gray-400 bg-gray-100 rounded-full cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- GRAFIK -->
        <div data-aos="fade-up" class="bg-white p-6 rounded-lg shadow-md mt-6 card-hover">
            <h3 class="text-lg font-semibold mb-4">Presentase Status Aduan</h3>

            <div class="flex flex-col md:flex-row items-center  gap-6">
                <!-- Bungkus canvas dengan pembatas ukuran -->
                <div class="w-full max-w-[160px] h-48 md:max-w-[240px] md:h-56 relative">
                    <canvas id="complaintPieChart" class="absolute inset-0 w-full h-full"></canvas>
                </div>

                <!-- Legend -->
                <div class="text-left text-sm space-y-1">
                    <p><span class="inline-block w-4 h-4 bg-green-500 rounded-full mr-2"></span>Selesai</p>
                    <p><span class="inline-block w-4 h-4 bg-blue-500 rounded-full mr-2"></span>Diproses</p>
                    <p><span class="inline-block w-4 h-4 bg-yellow-400 rounded-full mr-2"></span>Menunggu</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success') && session('complaints_code'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: `Aduan berhasil dikirim!<br>Simpan kode ini untuk melacak aduan Anda.<br><br><strong>Kode Aduan: {{ session('complaints_code') }}</strong>`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#7C3AED',
                });
            });
        </script>
    @endif
    <script>
        const ctx = document.getElementById('complaintPieChart');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Selesai', 'Diproses', 'Menunggu'],
                datasets: [{
                    label: 'Presentase Aduan',
                    data: [
                        {{ $finishedPercentage }},
                        {{ $processedPercentage }},
                        {{ $pendingPercentage }}
                    ],
                    backgroundColor: [
                        '#22c55e', // green-500
                        '#3b82f6', // blue-500
                        '#facc15' // yellow-400
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // penting untuk mencegah ukuran meledak
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    },
                    legend: {
                        display: false
                    }
                }
            }

        });
    </script>
@endpush
