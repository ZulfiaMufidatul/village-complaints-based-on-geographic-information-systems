<!DOCTYPE html>
<html>

<head>
    <title>Form Aduan Masyarakat</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>
    <h2>Form Aduan Masyarakat</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
            <br>
            <strong>Kode Aduan: </strong>{{ session('complaints_code') }}
        </div>
    @endif

    <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
        @csrf

        <label for="complaints_code" class="form-label">Kode Aduan</label>
        <input type="text" class="form-control" value="{{ $kodeAduan ?? 'Akan muncul setelah dikirim' }}"
            readonly><br>

        <label>Nama Pelapor</label>
        <input type="text" name="name" value="{{ old('name') }}" required><br>

        <label>No HP</label>
        <input type="text" name="phone" value="{{ old('phone') }}" required><br>

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}"><br>

        <label>Dusun</label>
        <select name="hamlet" id="hamlet" required>
            <option value="">--Pilih Dusun--</option>
            @foreach ($hamlets as $hamlet)
                <option value="{{ $hamlet->name }}" data-id="{{ $hamlet->id }}">{{ $hamlet->name }}</option>
            @endforeach
        </select><br>

        <label>RW</label>
        <select name="rw" id="rw" required>
            <option value="">--Pilih RW--</option>
        </select><br>

        <label>RT</label>
        <select name="rt" id="rt" required>
            <option value="">--Pilih RT--</option>
        </select><br>

        <label>Kategori Infrastruktur</label>
        <select name="infrastructure_category" required>
            <option value="">--Pilih Kategori--</option>
            @foreach ($categories as $category)
                <option value="{{ $category->name }}">{{ $category->name }}</option>
            @endforeach
        </select><br>

        <label>Deskripsi</label>
        <textarea name="description" required>{{ old('description') }}</textarea><br>

        <label>Upload Foto</label>
        <input type="file" name="photo" accept="image/*" required><br>

        <label>Lokasi</label><br>
        <div id="map" style="height: 400px; width: 100%;"></div><br>

        <label for="latitude_display">Latitude:</label>
        <input type="text" id="latitude_display" readonly><br>

        <label for="longitude_display">Longitude:</label>
        <input type="text" id="longitude_display" readonly><br>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button type="submit">Kirim Aduan</button>
    </form>

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
