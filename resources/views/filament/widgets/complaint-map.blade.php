<div class="rounded-xl shadow border p-4">
    <h2 class="text-xl font-bold mb-2">Peta Aduan Infrastruktur</h2>
    <div id="map" style="height: 500px;"></div>
</div>

@push('styles')
    <style>
        /* Tambahan untuk mencegah peta tumpang tindih saat scroll */
        #map {
            z-index: 0 !important;
            position: relative;
        }

        .leaflet-pane,
        .leaflet-map-pane,
        .leaflet-tile,
        .leaflet-overlay-pane,
        .leaflet-shadow-pane,
        .leaflet-marker-pane,
        .leaflet-popup-pane {
            z-index: 0 !important;
        }

        .leaflet-control-container {
            z-index: 1 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const map = L.map('map');

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const markers = [];
            const complaints = @json($this->complaints);

            // Peta warna per kategori
            const categoryColors = {
                'Jalan': 'red',
                'Drainase': 'blue',
                'Jembatan': 'green',
                'Gorong-Gorong': 'yellow',
            };

            // Tambahkan marker untuk setiap aduan
            complaints.forEach(c => {
                if (c.latitude && c.longitude) {
                    const color = categoryColors[c.category] ?? 'purple'; // fallback jika tidak terdaftar

                    const icon = L.icon({
                        iconUrl: `https://maps.google.com/mapfiles/ms/icons/${color}-dot.png`,
                        iconSize: [32, 32],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -30]
                    });

                    const marker = L.marker([c.latitude, c.longitude], {
                        icon
                    }).addTo(map);

                    marker.bindPopup(`
                        <strong>${c.name}</strong><br>
                        <small>Kategori: ${c.category}</small>
                    `);

                    markers.push(marker.getLatLng());
                }
            });

            // Tampilkan batas wilayah dari GeoJSON
            fetch('{{ asset('js/filament/bulakan.geojson') }}')
                .then(res => res.json())
                .then(data => {
                    const geoLayer = L.geoJSON(data, {
                        style: {
                            color: 'blue',
                            weight: 2,
                            fillOpacity: 0.1,
                        }
                    }).addTo(map);

                    const polygonBounds = geoLayer.getBounds();
                    const markerBounds = markers.length > 0 ? L.latLngBounds(markers) : null;

                    // Gabungkan bounds polygon dan marker (jika ada)
                    if (markerBounds) {
                        polygonBounds.extend(markerBounds);
                    }

                    map.fitBounds(polygonBounds, {
                        padding: [50, 50]
                    });
                })
                .catch(() => {
                    // Jika gagal ambil geojson, fallback ke marker atau default center
                    if (markers.length > 0) {
                        map.fitBounds(L.latLngBounds(markers), {
                            padding: [50, 50]
                        });
                    } else {
                        map.setView([-7.667, 110.787], 14);
                    }
                });
        });
    </script>
@endpush
