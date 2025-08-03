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
        const logoutBtn = document.getElementById('logoutBtn');
        logoutBtn.addEventListener('click', () => {
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
