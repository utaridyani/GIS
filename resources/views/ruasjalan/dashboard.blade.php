@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- Polyline decoding library -->
    <script src="https://unpkg.com/polyline"></script>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('ruasjalan.master')}}" class="btn btn-dark">&#x2190; Back</a>
    </div>

    <div id="mapid" style="height: 400px;"></div> 

    <script>
        var mymap = L.map('mapid').setView([-8.409518, 115.188919], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
        }).addTo(mymap);

        @foreach ($masterRuas as $ruas)
            var encodedPolyline = "{{ $ruas['paths'] }}";
            var decodedPolyline = polyline.decode(encodedPolyline);

            // Create polyline and associate information from $masterRuas
            var polylineAdd = L.polyline(decodedPolyline, { color: 'blue', ruasInfo: @json($ruas) }).addTo(mymap);

            // Add click event to show a styled popup with information
            polylineAdd.on('click', function (event) {
                var ruasInfo = this.options.ruasInfo;
                var popupContent = `
                    <div class="custom-popup">
                        <div class="popup-header">
                            <h3>${ruasInfo.nama_ruas}</h3>
                        </div>
                        <div class="popup-container">
                            <div class="popup-field">
                                <span class="popup-label">Kode Ruas :</span>
                                <span class="popup-value">${ruasInfo.kode_ruas}</span>
                            </div>
                            <div class="popup-field">
                                <span class="popup-label">Panjang :</span>
                                <span class="popup-value">${ruasInfo.panjang} m</span>
                            </div>    
                            <div class="popup-field">
                                <span class="popup-label">Lebar :</span>
                                <span class="popup-value">${ruasInfo.lebar}</span>
                            </div>  
                            <div class="popup-field">
                                <span class="popup-label">Desa :</span>
                                <span class="popup-value">${getDesaName(ruasInfo.desa_id)}</span>
                            </div> 
                            <div class="popup-field">
                                <span class="popup-label">Eksisting :</span>
                                <span class="popup-value">${getEksisting(ruasInfo.eksisting_id)}</span>
                            </div>
                            <div class="popup-field">
                                <span class="popup-label">Kondisi Jalan :</span>
                                <span class="popup-value">${getKondisiJalan(ruasInfo.kondisi_id)}</span>
                            </div>  
                            <div class="popup-field">
                                <span class="popup-label">Jenis Jalan :</span>
                                <span class="popup-value">${getJenisJalan(ruasInfo.jenisjalan_id)}</span>
                            </div>                                                                                                                   
                            <div class="popup-field">
                                <span class="popup-label">Keterangan :</span>
                                <span class="popup-value">${ruasInfo.keterangan}</span>
                            </div>   
                                                                     
                        </div>
                    </div>
                `;
                L.popup({ className: 'custom-popup' })
                    .setLatLng(event.latlng)
                    .setContent(popupContent)
                    .openOn(mymap);
            });
        @endforeach

        function getDesaName(desaId) {
            var namaDesa = @json($desa);
            var desaName = '';
            for (var i = 0; i < namaDesa.length; i++) {
                if (namaDesa[i]['id'] == desaId) {
                    desaName = namaDesa[i]['desa'];
                    break;
                }
            }
            return desaName;
        }

        function getEksisting(eksistingId) {
            var eksistingData = @json($eksisting);
            var eksisting = '';
            for (var i = 0; i < eksistingData.length; i++) {
                if (eksistingData[i]['id'] == eksistingId) {
                    eksisting = eksistingData[i]['eksisting'];
                    break;
                }
            }
            return eksisting;
        }

        function getKondisiJalan(kondisiId) {
            var kondisiData = @json($kondisi);
            var kondisi = '';
            for (var i = 0; i < kondisiData.length; i++) {
                if (kondisiData[i]['id'] == kondisiId) {
                    kondisi = kondisiData[i]['kondisi'];
                    break;
                }
            }
            return kondisi;
        }

        function getJenisJalan(jenisId) {
            var jenisJalanData = @json($jenisjalan);
            var jenisjalan = '';
            for (var i = 0; i < jenisJalanData.length; i++) {
                if (jenisJalanData[i]['id'] == jenisId) {
                    jenisjalan = jenisJalanData[i]['jenisjalan'];
                    break;
                }
            }
            return jenisjalan;
        }
    </script>

    <style>
        .custom-popup {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            max-width: 300px;
            margin: 0;
            padding: 0;
        }

        .popup-header {
            background-color: #3498db;
            color: #fff;
            padding: 15px;
            text-align: center;
            margin: 0;
        }

        .popup-container {
            padding: 15px;
            margin: 0;
        }

        .popup-field {
            display: flex;
        }

        .popup-label {
            font-weight: bold;
            margin-right: 10px;
        }

        .popup-value {
            display: block;
            color: #555;
        }
    </style>
@endsection