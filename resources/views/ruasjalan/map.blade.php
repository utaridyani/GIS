@extends('layouts.app')

@section('title', 'Map View')

@section('content')
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Polyline decoding library -->
    <script src="https://unpkg.com/polyline"></script>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('ruasjalan.master')}}" class="btn btn-dark">&#x2190; Back</a>
    </div>

    <div id="map" style="height: 400px;"></div>

    <script>
        function initializeMap(encodedPolyline) {
            // decode polyline
            var decodedPolyline = polyline.decode(encodedPolyline);

            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // adding the polyline
            L.polyline(decodedPolyline).addTo(map);

            map.fitBounds(L.latLngBounds(decodedPolyline));
        }

        // call the function
        initializeMap('{{ $encodedPolyline }}');
    </script>
@endsection
