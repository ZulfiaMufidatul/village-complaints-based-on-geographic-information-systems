<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Aduan Masyarakat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body class="bg-blue-100 text-gray-800">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6 text-center">Form Aduan Masyarakat</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                {!! session('success') !!}
                <div><strong>Kode Aduan:</strong> {{ session('complaints_code') }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-6">
            @csrf

            <div>
                <label class="block font-semibold">Kode Aduan</label>
                <input type="text" value="{{ $kodeAduan ?? 'Akan muncul setelah dikirim' }}" class="w-full mt-1 rounded border border-gray-300 p-2" readonly>
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold">Nama Pelapor</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full mt-1 rounded border border-gray-300 p-2">
                </div>

                <div>
                    <label class="block font-semibold">No HP</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full mt-1 rounded border border-gray-300 p-2">
                </div>
            </div>

            <div>
                <label class="block font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 rounded border border-gray-300 p-2">
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block font-semibold">Dusun</label>
                    <select name="hamlet" id="hamlet" required class="w-full mt-1 rounded border border-gray-300 p-2">
                        <option value="">--Pilih Dusun--</option>
                        @foreach ($hamlets as $hamlet)
                            <option value="{{ $hamlet->name }}" data-id="{{ $hamlet->id }}">{{ $hamlet->name }}</option>
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
                <textarea name="description" required class="w-full mt-1 rounded border border-gray-300 p-2">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block font-semibold">Upload Foto</label>
                <input type="file" name="photo" accept="image/*" required class="mt-1 border border-gray-300 p-2">
            </div>

            <div>
                <label class="block font-semibold mb-1">Lokasi</label>
                <div id="map" class="h-64 w-full rounded border"></div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label>Latitude</label>
                    <input type="text" id="latitude_display" readonly class="w-full rounded border border-gray-300 p-2">
                </div>
                <div>
                    <label>Longitude</label>
                    <input type="text" id="longitude_display" readonly class="w-full rounded border border-gray-300 p-2">
                </div>
            </div>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <div class="text-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim Aduan</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-pip/leaflet-pip.min.js"></script>

    <script>
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

        function setMarker(lat, lng) {
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

            // Setelah polygon dimuat, coba GPS
            tryUseGeolocation();
        });

    // Manual klik
    map.on('click', function (e) {
        if (!polygonLayer) return;

        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        const inside = leafletPip.pointInLayer([lng, lat], polygonLayer);
        if (inside.length === 0) {
            alert("Titik berada di luar wilayah yang diizinkan.");
            return;
        }

        setMarker(lat, lng);
    });

    function tryUseGeolocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    const inside = leafletPip.pointInLayer([lng, lat], polygonLayer);
                    if (inside.length === 0) {
                        alert("Lokasi Anda di luar wilayah yang diizinkan. Silakan pilih manual.");
                        return;
                    }

                    setMarker(lat, lng);
                    map.setView([lat, lng], 17);
                },
                function (error) {
                    console.warn("Gagal mendapatkan lokasi GPS: ", error.message);
                }
            );
        } else {
            alert("Browser Anda tidak mendukung fitur GPS.");
        }
    }
    </script>
</body>

</html>
