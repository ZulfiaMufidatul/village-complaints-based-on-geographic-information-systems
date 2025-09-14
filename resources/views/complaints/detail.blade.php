<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .status-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .image-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s;
        }

        .image-container:hover::before {
            transform: translateX(100%);
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    <!-- Header dengan pattern -->
    <div
        class="relative bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white py-4 shadow-lg sticky top-0 z-50">
        <div class="absolute inset-0 bg-black opacity-10"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="flex items-center space-x-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Detail Aduan</h1>
                    <p class="text-blue-100 mt-1">Informasi lengkap pengaduan masyarakat</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('index') }}"
                        class="text-blue-600 hover:text-blue-800 transition-colors">Beranda</a></li>
                <li class="text-gray-500">/</li>
                <li><a href="{{ route('complaints.track', $complaint->complaints_code) }}"
                        class="text-blue-600 hover:text-blue-800 transition-colors">Aduan</a></li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-700 font-medium">Detail</li>
            </ol>
        </nav>

        <!-- Main Content -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Foto Aduan -->
            <div class="lg:col-span-1">
                <div class="glass-effect rounded-2xl p-6 shadow-xl card-hover">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-camera text-blue-600 mr-3"></i>
                        Foto Aduan
                    </h3>
                    <div class="image-container rounded-xl overflow-hidden">
                        @if ($complaint->photo)
                            <img src="{{ asset('storage/' . $complaint->photo) }}" alt="Foto Aduan"
                                class="w-full h-64 object-contain rounded-xl shadow-lg">
                        @else
                            <div
                                class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center text-gray-500">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl mb-2"></i>
                                    <p class="text-sm">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Detail -->
            <div class="lg:col-span-2">
                <div class="glass-effect rounded-2xl p-6 shadow-xl card-hover">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-3"></i>
                        Informasi Detail
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Kode Aduan -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-barcode text-blue-600 mr-2"></i>
                                <p class="text-sm font-medium text-gray-600">Kode Aduan</p>
                            </div>
                            <p class="text-xl font-bold text-blue-700">{{ $complaint->complaints_code }}</p>
                        </div>

                        <!-- Status Cards -->
                        <div class="space-y-3">
                            <div
                                class="bg-gradient-to-r from-{{ $complaint->request_status == 'pending' ? 'yellow' : ($complaint->request_status == 'approved' ? 'green' : 'red') }}-50 to-{{ $complaint->request_status == 'pending' ? 'yellow' : ($complaint->request_status == 'approved' ? 'green' : 'red') }}-100 p-4 rounded-xl border border-{{ $complaint->request_status == 'pending' ? 'yellow' : ($complaint->request_status == 'approved' ? 'green' : 'red') }}-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 mb-1">Status Permintaan</p>
                                        @php
                                            $requestStatusMap = [
                                                'pending' => [
                                                    'text' => 'Menunggu',
                                                    'class' => 'bg-yellow-200 text-yellow-800',
                                                    'icon' => 'fas fa-clock',
                                                ],
                                                'approved' => [
                                                    'text' => 'Diterima',
                                                    'class' => 'bg-green-200 text-green-800',
                                                    'icon' => 'fas fa-check-circle',
                                                ],
                                                'rejected' => [
                                                    'text' => 'Ditolak',
                                                    'class' => 'bg-red-200 text-red-800',
                                                    'icon' => 'fas fa-times-circle',
                                                ],
                                            ];
                                            $reqStatus = $requestStatusMap[$complaint->request_status] ?? [
                                                'text' => ucfirst($complaint->request_status),
                                                'class' => 'bg-gray-200 text-gray-800',
                                                'icon' => 'fas fa-question-circle',
                                            ];
                                        @endphp
                                        <span
                                            class="status-badge px-3 py-1 {{ $reqStatus['class'] }} rounded-full text-sm font-semibold">
                                            <i class="{{ $reqStatus['icon'] }} mr-1"></i>
                                            {{ $reqStatus['text'] }}
                                        </span>
                                    </div>
                                    <i
                                        class="{{ $reqStatus['icon'] }} text-{{ $complaint->request_status == 'pending' ? 'yellow' : ($complaint->request_status == 'approved' ? 'green' : 'red') }}-500 text-2xl"></i>
                                </div>
                            </div>

                            <div
                                class="bg-gradient-to-r from-{{ $complaint->status_complaint == 'pending' ? 'yellow' : ($complaint->status_complaint == 'process' ? 'blue' : ($complaint->status_complaint == 'done' ? 'green' : 'red')) }}-50 to-{{ $complaint->status_complaint == 'pending' ? 'yellow' : ($complaint->status_complaint == 'process' ? 'blue' : ($complaint->status_complaint == 'done' ? 'green' : 'red')) }}-100 p-4 rounded-xl border border-{{ $complaint->status_complaint == 'pending' ? 'yellow' : ($complaint->status_complaint == 'process' ? 'blue' : ($complaint->status_complaint == 'done' ? 'green' : 'red')) }}-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-600 mb-1">Status Aduan</p>
                                        @php
                                            $statusMap = [
                                                'pending' => [
                                                    'text' => 'Menunggu',
                                                    'class' => 'bg-yellow-200 text-yellow-800',
                                                    'icon' => 'fas fa-hourglass-half',
                                                ],
                                                'process' => [
                                                    'text' => 'Diproses',
                                                    'class' => 'bg-blue-200 text-blue-800',
                                                    'icon' => 'fas fa-cogs',
                                                ],
                                                'done' => [
                                                    'text' => 'Selesai',
                                                    'class' => 'bg-green-200 text-green-800',
                                                    'icon' => 'fas fa-check-circle',
                                                ],
                                                'cancel' => [
                                                    'text' => 'Dibatalkan',
                                                    'class' => 'bg-red-200 text-red-800',
                                                    'icon' => 'fas fa-times-circle',
                                                ],
                                            ];
                                            $status = $statusMap[$complaint->status_complaint] ?? [
                                                'text' => ucfirst($complaint->status_complaint),
                                                'class' => 'bg-gray-200 text-gray-800',
                                                'icon' => 'fas fa-question-circle',
                                            ];
                                        @endphp
                                        <span
                                            class="status-badge px-3 py-1 {{ $status['class'] }} rounded-full text-sm font-semibold">
                                            <i
                                                class="{{ $status['icon'] }} mr-1 {{ $complaint->status_complaint == 'process' ? 'fa-spin' : '' }}"></i>
                                            {{ $status['text'] }}
                                        </span>
                                    </div>
                                    <i
                                        class="{{ $status['icon'] }} text-{{ $complaint->status_complaint == 'pending' ? 'yellow' : ($complaint->status_complaint == 'process' ? 'blue' : ($complaint->status_complaint == 'done' ? 'green' : 'red')) }}-500 text-2xl {{ $complaint->status_complaint == 'process' ? 'fa-spin' : '' }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Information Grid -->
                    <div class="mt-8 grid md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">Nama Pelapor</p>
                                <p class="font-semibold text-gray-800">{{ $complaint->name }}</p>
                            </div>

                            <div class="border-l-4 border-green-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">No HP Pelapor</p>
                                <p class="font-semibold text-gray-800">{{ $complaint->phone }}</p>
                            </div>

                            <div class="border-l-4 border-purple-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">Email Pelapor</p>
                                <p class="font-semibold text-gray-800">{{ $complaint->email }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="border-l-4 border-orange-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">Kategori Infrastruktur</p>
                                <p class="font-semibold text-gray-800">{{ $complaint->infrastructure_category }}</p>
                            </div>

                            <div class="border-l-4 border-red-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">Lokasi</p>
                                <p class="font-semibold text-gray-800">Dusun {{ $complaint->hamlet }},
                                    {{ $complaint->rw }}, {{ $complaint->rt }}</p>
                            </div>

                            <div class="border-l-4 border-indigo-500 pl-4">
                                <p class="text-sm text-gray-600 mb-1">Waktu Pengaduan</p>
                                <p class="font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($complaint->date_time)->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-align-left text-gray-600 mr-2"></i>
                            Deskripsi Aduan
                        </h4>
                        <p class="text-gray-700 leading-relaxed">{{ $complaint->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline Progress -->
        <div class="mt-12 glass-effect rounded-2xl p-6 shadow-xl">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-timeline text-blue-600 mr-3"></i>
                Timeline Proses
            </h3>

            <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-300"></div>

                <div class="space-y-6">
                    <!-- Step 1 - Aduan Dibuat -->
                    <div class="relative flex items-center">
                        <div
                            class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">Aduan Dibuat</p>
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($complaint->date_time)->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Step 2 - Status Permintaan -->
                    <div class="relative flex items-center">
                        @if ($complaint->request_status == 'approved')
                            <div
                                class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Permintaan Disetujui</p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($complaint->updated_at)->format('d M Y H:i') }}</p>
                            </div>
                        @elseif($complaint->request_status == 'rejected')
                            <div
                                class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                <i class="fas fa-times"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Permintaan Ditolak</p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($complaint->updated_at)->format('d M Y H:i') }}</p>
                            </div>
                        @else
                            <div
                                class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Menunggu Persetujuan</p>
                                <p class="text-sm text-gray-600">Dalam proses review...</p>
                            </div>
                        @endif
                    </div>

                    <!-- Step 3 - Status Aduan -->
                    <!-- Step 3 - Status Aduan -->
                    @if ($complaint->request_status == 'approved')
                        <div class="relative flex items-center">
                            @if ($complaint->status_complaint == 'done')
                                <div
                                    class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Aduan Selesai</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($complaint->updated_at)->format('d M Y H:i') }}
                                    </p>
                                </div>
                            @elseif($complaint->status_complaint == 'process')
                                <div
                                    class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                    <i class="fas fa-cog fa-spin"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Sedang Diproses</p>
                                    <p class="text-sm text-gray-600">{{ $complaint->process_comment ?? '...' }}</p>
                                </div>
                            @elseif($complaint->status_complaint == 'cancel')
                                <div
                                    class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                    <i class="fas fa-ban"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Aduan Dibatalkan</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($complaint->updated_at)->format('d M Y H:i') }}
                                    </p>
                                </div>
                            @else
                                <div
                                    class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="font-semibold text-gray-800">Menunggu Proses</p>
                                    <p class="text-sm text-gray-600">Akan segera diproses...</p>
                                </div>
                            @endif
                        </div>
                    @elseif($complaint->request_status == 'rejected')
                        <div class="relative flex items-center">
                            <div
                                class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-lg z-10">
                                <i class="fas fa-ban"></i>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">Aduan Dibatalkan</p>
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($complaint->updated_at)->format('d M Y H:i') }}
                                </p>
                                @if ($complaint->process_comment)
                                    <p class="mt-1 text-sm italic text-red-600">
                                        Alasan: {{ $complaint->process_comment }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400">© 2025 Sistem Pengaduan Masyarakat. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Auto refresh status setiap 30 detik
        setInterval(() => {
            if (document.querySelector('.fa-spin')) {
                // Refresh halaman jika ada status yang sedang diproses
                setTimeout(() => {
                    location.reload();
                }, 30000);
            }
        }, 30000);
    </script>
</body>

</html>
