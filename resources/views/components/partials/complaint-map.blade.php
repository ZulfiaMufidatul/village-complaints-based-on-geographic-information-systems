@props(['latitude', 'longitude'])

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        z-index: 0 !important;
    }

    .leaflet-pane,
    .leaflet-top,
    .leaflet-bottom {
        z-index: 0 !important;
    }

    .leaflet-control-container {
        z-index: 1 !important;
    }
</style>

<div id="map" style="height: 300px; margin-top: 10px; border-radius: 8px;"></div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            const map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([{{ $latitude }}, {{ $longitude }}])
                .addTo(map)
                .bindPopup(`
                    
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $latitude }},{{ $longitude }}"
                       target="_blank"
                       style="color:blue;">📍 Lihat di Google Maps</a>
                `)
                .openPopup();
        }, 100);
    });
</script>
