@extends('complaints.layouts.app')

@section('title')
    Form Aduan Masyarakat
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        <!-- Breadcrumb -->
        <nav class="mb-2">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('index') }}" class="text-blue-600 hover:text-blue-800 transition-colors">Beranda</a>
                </li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-700 font-medium">Tambah Aduan</li>
            </ol>
        </nav>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-center">Form Aduan Masyarakat</h1>
            <a href="{{ route('index') }}"
                class="px-4 py-2 rounded-md transition-all duration-300 hover:bg-white hover:text-blue-600 font-semibold flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>
        @if ($errors->has('too_many_requests'))
            <div id="alert-section"
                class="w-full bg-red-50 border border-red-400 rounded-lg px-6 py-4 mb-6 flex justify-between items-center">
                <span class="text-gray-600">{{ $errors->first('too_many_requests') }}</span>
                <button type="button" id="close-alert-btn"
                    class="w-5 h-5 hover:bg-white/70 flex justify-center items-center transition-colors rounded-lg">
                    <i class="fa-solid fa-x text-xs"></i>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {!! session('success') !!}
                <div><strong>Kode Aduan:</strong> {{ session('complaints_code') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data"
            class="bg-white px-10 py-6 rounded-lg shadow flex flex-col gap-6">
            @csrf

            <div>
                <label class="block font-semibold">Kode Aduan</label>
                <input type="text" value="{{ $kodeAduan ?? 'Akan muncul setelah dikirim' }}"
                    class="w-full mt-1 rounded border border-gray-300 p-2" readonly>
            </div>

            <div>
                <label class="block font-semibold">Nama Pelapor</label>
                <input placeholder="Masukkan Nama Anda" type="text" name="name"
                    value="{{ old('name') ? old('name') : $user->name }}" required
                    class="w-full mt-1 rounded border border-gray-300 p-2">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold">No HP</label>
                    <input placeholder="Masukkan No HP Anda" type="text" name="phone" value="{{ old('phone') }}"
                        required class="w-full mt-1 rounded border border-gray-300 p-2">
                </div>
                <div>
                    <label class="block font-semibold">Email</label>
                    <input placeholder="Masukkan Email Anda" type="email" name="email"
                        value="{{ old('email') ? old('email') : $user->email }}" required
                        class="w-full mt-1 rounded border border-gray-300 p-2">
                </div>
            </div>


            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-semibold">Dusun</label>
                    <select name="hamlet" id="hamlet" required class="w-full mt-1 rounded border border-gray-300 p-2">
                        <option value="">--Pilih Dusun--</option>
                        @foreach ($hamlets as $hamlet)
                            <option value="{{ $hamlet->name }}" data-id="{{ $hamlet->id }}">{{ $hamlet->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-semibold">RW</label>
                    <select name="rw" id="rw" required class="w-full mt-1 rounded border border-gray-300 p-2">
                        <option value="">--Pilih RW--</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold">RT</label>
                    <select name="rt" id="rt" required class="w-full mt-1 rounded border border-gray-300 p-2">
                        <option value="">--Pilih RT--</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block font-semibold">Kategori Infrastruktur</label>
                <select name="infrastructure_category" required class="w-full mt-1 rounded border border-gray-300 p-2">
                    <option value="">--Pilih Kategori--</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-semibold">Deskripsi</label>
                <textarea placeholder="Masukkan Deskripsi Aduan Anda" name="description" required
                    class="w-full mt-1 rounded border border-gray-300 p-2">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div>
                <div class="space-y-4">
                    <!-- Input Kamera -->
                    <input type="file" id="cameraInput" name="photo_camera" accept="image/*" capture="environment"
                        class="hidden" onchange="previewImage(this)">

                    <!-- Input Galeri -->
                    <input type="file" id="galleryInput" name="photo_gallery" accept="image/*" class="hidden"
                        onchange="previewImage(this)">

                    <!-- Tombol Kamera -->
                    <label for="cameraInput"
                        class="cursor-pointer px-4 py-2 text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-camera"></i>
                        Ambil Foto
                    </label>

                    <!-- Tombol Galeri -->
                    <label for="galleryInput"
                        class="cursor-pointer px-4 py-2 text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-400 transition">
                        <i class="fas fa-image"></i>
                        Pilih dari Galeri
                    </label>

                    <!-- Preview -->
                    <img id="preview" class="mt-2 w-32 h-32 object-cover rounded-lg hidden">

                    <!-- Preview -->
                    <div id="imagePreviewContainer" class="mt-4 hidden">
                        <p class="mb-2 text-gray-600 text-sm">Preview Gambar:</p>
                        <img id="imagePreview" src="" alt="Preview Foto"
                            class="w-52 h-52 object-cover rounded-lg shadow-md border cursor-pointer">
                    </div>
                </div>
            </div>

            <div>
                <div class="w-full justify-between flex items-center mb-4 ">
                    <label class="block font-semibold mb-1">Lokasi</label>
                    <button type="button" id="useNow"
                        class="rounded border border-gray-300 px-2 py-[1px] bg-blue-500 text-white text-sm flex items-center gap-1">
                        <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11 16C11 16.5523 11.4477 17 12 17C12.5523 17 13 16.5523 13 16H11ZM8.21567 14.3922C8.75496 14.2731 9.09558 13.7394 8.97647 13.2001C8.85735 12.6608 8.32362 12.3202 7.78433 12.4393L8.21567 14.3922ZM16.2157 12.4393C15.6764 12.3202 15.1426 12.6608 15.0235 13.2001C14.9044 13.7394 15.245 14.2731 15.7843 14.3922L16.2157 12.4393ZM15 7C15 8.65685 13.6569 10 12 10V12C14.7614 12 17 9.76142 17 7H15ZM12 10C10.3431 10 9 8.65685 9 7H7C7 9.76142 9.23858 12 12 12V10ZM9 7C9 5.34315 10.3431 4 12 4V2C9.23858 2 7 4.23858 7 7H9ZM12 4C13.6569 4 15 5.34315 15 7H17C17 4.23858 14.7614 2 12 2V4ZM11 11V16H13V11H11ZM20 17C20 17.2269 19.9007 17.5183 19.5683 17.8676C19.2311 18.222 18.6958 18.5866 17.9578 18.9146C16.4844 19.5694 14.3789 20 12 20V22C14.5917 22 16.9861 21.5351 18.7701 20.7422C19.6608 20.3463 20.4435 19.8491 21.0171 19.2463C21.5956 18.6385 22 17.8777 22 17H20ZM12 20C9.62114 20 7.51558 19.5694 6.04218 18.9146C5.30422 18.5866 4.76892 18.222 4.43166 17.8676C4.0993 17.5183 4 17.2269 4 17H2C2 17.8777 2.40438 18.6385 2.98287 19.2463C3.55645 19.8491 4.33918 20.3463 5.2299 20.7422C7.01386 21.5351 9.40829 22 12 22V20ZM4 17C4 16.6824 4.20805 16.2134 4.96356 15.6826C5.70129 15.1644 6.81544 14.7015 8.21567 14.3922L7.78433 12.4393C6.22113 12.7846 4.83528 13.3285 3.81386 14.0461C2.81023 14.7512 2 15.747 2 17H4ZM15.7843 14.3922C17.1846 14.7015 18.2987 15.1644 19.0364 15.6826C19.792 16.2134 20 16.6824 20 17H22C22 15.747 21.1898 14.7512 20.1861 14.0461C19.1647 13.3285 17.7789 12.7846 16.2157 12.4393L15.7843 14.3922Z"
                                fill="#FFFF" />
                        </svg>
                        <span>Gunakan Lokasi Saya Sekarang</span>
                    </button>
                </div>
                <div id="map" class="h-64 w-full rounded-lg border border-gray-300 z-0"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label>Latitude</label>
                    <input type="text" id="latitude_display" readonly
                        class="w-full rounded border border-gray-300 p-2">
                </div>
                <div>
                    <label>Longitude</label>
                    <input type="text" id="longitude_display" readonly
                        class="w-full rounded border border-gray-300 p-2">
                </div>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="text-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-medium">
                    Kirim Aduan
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.min.js"></script>

    <script>
        const alertSection = document.getElementById('alert-section');
        const closeBtn = document.getElementById('close-alert-btn');

        if (alertSection && closeBtn) {
            closeBtn.addEventListener('click', () => {
                alertSection.classList.add('hidden');
            });
        }

        const useMyLocation = document.getElementById('useNow');
        useMyLocation.addEventListener('click', () => {
            tryUseGeolocation();
        });

        // Dropdown dinamis RW
        $('#hamlet').change(function() {
            const hamletId = $(this).find(':selected').data('id');
            $('#rw').html('<option>Loading...</option>');
            $.get('/get-rw/' + hamletId, function(data) {
                let options = '<option value="">--Pilih RW--</option>';
                data.forEach(rw => {
                    options += `<option value="${rw.name}" data-id="${rw.id}">${rw.name}</option>`;
                });
                $('#rw').html(options);
                $('#rt').html('<option value="">--Pilih RT--</option>');
            });
        });

        // Dropdown dinamis RT
        $('#rw').change(function() {
            const rwId = $(this).find(':selected').data('id');
            const hamletId = $('#hamlet').find(':selected').data('id');
            $('#rt').html('<option>Loading...</option>');
            $.get(`/get-rt/${hamletId}/${rwId}`, function(data) {
                let options = '<option value="">--Pilih RT--</option>';
                data.forEach(rt => {
                    options += `<option value="${rt.name}">${rt.name}</option>`;
                });
                $('#rt').html(options);
            });
        });

        // Leaflet Map + GeoJSON Boundary
        const map = L.map('map').setView([-7.667, 110.787], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker;
        let polygonLayer;

        const setMarker = (lat, lng) => {
            $('#latitude').val(lat);
            $('#longitude').val(lng);
            $('#latitude_display').val(lat);
            $('#longitude_display').val(lng);

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        }

        // Load polygon batas wilayah
        fetch('{{ asset('js/filament/bulakan.geojson') }}')
            .then(res => res.json())
            .then(data => {
                polygonLayer = L.geoJSON(data, {
                    style: {
                        color: 'blue',
                        weight: 2,
                        fillOpacity: 0.05,
                    }
                }).addTo(map);
                map.fitBounds(polygonLayer.getBounds());

                // Setelah polygon dimuat, coba GPS otomatis
                // tryUseGeolocation();
            });

        // Manual klik
        map.addEventListener('click', function(e) {
            if (!polygonLayer) return;

            const lat = e.latlng.lat;
            const lng = e.latlng.lng;

            const inside = leafletPip.pointInLayer([lng, lat], polygonLayer);
            if (inside.length === 0) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Titik berada di luar wilayah yang diizinkan.",
                });
                return;
            }

            setMarker(lat, lng);
        });

        const tryUseGeolocation = () => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {

                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        const inside = leafletPip.pointInLayer([lng, lat], polygonLayer);
                        // tombol lokasi sekarang
                        // Comment mulai sini
                        if (inside.length === 0) {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal",
                                text: "Lokasi Anda di luar wilayah yang diizinkan. Silakan pilih manual.",
                            });
                            return;
                        }
                        // Comment sampai sini
                        setMarker(lat, lng);
                        map.setView([lat, lng], 17);
                    },
                    function(error) {
                        console.warn("Gagal mendapatkan lokasi GPS: ", error.message);
                        alert("Gagal mendapatkan lokasi GPS: " + error.message);
                    }
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: "Browser Anda tidak mendukung fitur GPS!",
                });
                return;
            }
        }

        // preview image
        function previewImage(input) {
            const file = input.files[0];
            if (file) {
                const url = URL.createObjectURL(file);

                const preview = document.getElementById('imagePreview');
                const container = document.getElementById('imagePreviewContainer');

                preview.src = url;
                container.classList.remove('hidden');

                preview.onclick = function() {
                    window.open(url, '_blank');
                };
            }
        }
    </script>
@endpush
