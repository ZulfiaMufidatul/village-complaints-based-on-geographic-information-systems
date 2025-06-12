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
        <input type="text" class="form-control" value="{{ $kodeAduan ?? 'Akan muncul setelah dikirim' }}" readonly><br>

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
        <div id="map" style="height: 300px; width: 100%;"></div><br>

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

        // Leaflet map
        const map = L.map('map').setView([-7.5, 110.5], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker;
        map.on('click', function(e) {
            const { lat, lng } = e.latlng;

            $('#latitude').val(lat);
            $('#longitude').val(lng);
            $('#latitude_display').val(lat);
            $('#longitude_display').val(lng);

            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }
        });
    </script>
</body>

</html>
