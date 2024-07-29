@extends('layouts.app')

@section('title', 'Edit Ruas Jalan')

@section('content')
    <!-- Polyline decoding library -->
    <script src="https://unpkg.com/polyline"></script>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('ruasjalan.master')}}" class="btn btn-dark">&#x2190; Back</a>
    </div>

    <h1>Edit Ruas Jalan</h1>

    <form action="{{ route('ruasjalan.update', ['id' => $ruasDetail['ruasjalan']['id']]) }}" method="post">
        @csrf
        @method('put')

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        
        <div id="mapid" style="height: 400px;"></div>
        <div class="form-group">
            <label for="paths">Paths</label>
            <input type="text" name="paths" id="paths" class="form-control" value="{{ $ruasDetail['ruasjalan']['paths'] }}">
            <label for="provinsi">Provinsi</label>
            <select id="provinsi" class="form-control">
                @foreach ($desa as $desa_data)
                    @if ($desa_data['id'] == $ruasDetail['ruasjalan']['desa_id'])
                        @php
                            $kecamatanId = $desa_data['kec_id'];
                        @endphp
                        @foreach ($kecamatan as $kecamatan_data)
                            @if ($kecamatan_data['id'] == $kecamatanId)
                                @php
                                    $nama_kecamatan = $kecamatan_data['kecamatan'];
                                    $kabupatenId = $kecamatan_data['kab_id'];
                                @endphp
                                @foreach ($kabupaten as $kabupaten_data)
                                    @if ($kabupaten_data['id'] == $kabupatenId)
                                        @php
                                            $nama_kabupaten = $kabupaten_data['kabupaten'];
                                            $provinsiId = $kabupaten_data['prov_id'];
                                        @endphp
                                        @foreach ($provinsi as $provinsi_data)
                                            @if ($provinsi_data['id'] == $provinsiId)
                                                @php
                                                    $nama_provinsi = $provinsi_data['provinsi'];
                                                @endphp
                                            @endif
                                        @endforeach                                         
                                    @endif
                                @endforeach                                
                            @endif
                        @endforeach  
                    @endif
                @endforeach
                <option value="{{$provinsiId}}" selected disabled>{{$nama_provinsi}}</option>
                @foreach($provinsi as $prov)
                    <option value="{{ $prov['id'] }}">{{ $prov['provinsi'] }}</option>
                @endforeach
            </select> 
            <label for="kabupaten">Kabupaten</label>
            <select id="kabupaten" class="form-control">
                @foreach ($desa as $desa_data)
                    @if ($desa_data['id'] == $ruasDetail['ruasjalan']['desa_id'])
                        @php
                            $kecamatanId = $desa_data['kec_id'];
                        @endphp
                        @foreach ($kecamatan as $kecamatan_data)
                            @if ($kecamatan_data['id'] == $kecamatanId)
                                @php
                                    $nama_kecamatan = $kecamatan_data['kecamatan'];
                                    $kabupatenId = $kecamatan_data['kab_id'];
                                @endphp
                                @foreach ($kabupaten as $kabupaten_data)
                                    @if ($kabupaten_data['id'] == $kabupatenId)
                                        @php
                                            $nama_kabupaten = $kabupaten_data['kabupaten'];
                                        @endphp
                                    @endif
                                @endforeach                                
                            @endif
                        @endforeach  
                    @endif
                @endforeach
                <option value="{{ $kabupatenId }}" selected>{{ $nama_kabupaten }}</option>
                @foreach($kabupaten as $kab)
                    <option value="{{ $kab['id'] }}" data-province="{{ $kab['prov_id'] }}">{{ $kab['kabupaten'] }}</option>
                @endforeach
            </select>  
            <label for="kecamatan">Kecamatan</label>
            <select id="kecamatan" class="form-control">
                @foreach ($desa as $desa_data)
                    @if ($desa_data['id'] == $ruasDetail['ruasjalan']['desa_id'])
                        @php
                            $kecamatanId = $desa_data['kec_id'];
                        @endphp
                        @foreach ($kecamatan as $kecamatan_data)
                            @if ($kecamatan_data['id'] == $kecamatanId)
                                @php
                                    $nama_kecamatan = $kecamatan_data['kecamatan'];
                                @endphp                                
                            @endif
                        @endforeach  
                    @endif
                @endforeach
                <option value="{{ $kecamatanId }}" selected>{{$nama_kecamatan}}</option>
                @foreach($kecamatan as $kec)
                    <option value="{{ $kec['id'] }}" data-regency="{{ $kec['kab_id' ]}}" @if($kec['kecamatan'] == $nama_kecamatan) selected @endif>{{ $kec['kecamatan'] }}</option>                
                @endforeach
            </select>          
            <label for="desa_id">Desa</label>
            <select name="desa_id" id="desa_id" class="form-control">
                @foreach ($desa as $desa_nama)
                    @if ($desa_nama['id'] == $ruasDetail['ruasjalan']['desa_id'])
                        @php
                            $nama_desa = $desa_nama['desa'];
                        @endphp
                    @endif
                @endforeach
                <option value="{{ $ruasDetail['ruasjalan']['desa_id'] }}" selected>{{ $nama_desa }}</option>
                @foreach($desa as $desas)
                    <option value="{{ $desas['id'] }}" data-district="{{ $desas['kec_id'] }}">{{ $desas['desa'] }}</option>
                @endforeach
            </select>
            <label for="nama_ruas">Nama Ruas</label>
            <input type="text" name="nama_ruas" id="nama_ruas" class="form-control" value="{{ $ruasDetail['ruasjalan']['nama_ruas'] }}">
            <label for="kode_ruas">Kode Ruas</label>
            <input type="text" name="kode_ruas" id="kode_ruas" class="form-control" value="{{ $ruasDetail['ruasjalan']['kode_ruas'] }}">
            <label for="panjang">Panjang</label>
            <input type="text" name="panjang" id="panjang" class="form-control" value="{{ $ruasDetail['ruasjalan']['panjang'] }}">
            <label for="lebar">Lebar</label>
            <input type="text" name="lebar" id="lebar" class="form-control" value="{{ $ruasDetail['ruasjalan']['lebar'] }}">
            <label for="eksisting_id">Eksisting</label>
            <select name="eksisting_id" id="eksisting_id" class="form-control">
                @foreach ($eksisting as $eksisting_nama)
                    @if ($eksisting_nama['id'] == $ruasDetail['ruasjalan']['eksisting_id'])
                        @php
                            $nama_eksisting = $eksisting_nama['eksisting'];
                        @endphp
                    @endif
                @endforeach
                <option value="{{ $ruasDetail['ruasjalan']['eksisting_id'] }}" selected >{{ $nama_eksisting }}</option>
                @foreach($eksisting as $eksistings)
                    <option value="{{ $eksistings['id'] }}">{{ $eksistings['eksisting'] }}</option>
                @endforeach
            </select>
            <label for="kondisi_id">Kondisi</label>
            <select name="kondisi_id" id="kondisi_id" class="form-control">
                @foreach ($kondisi as $kondisi_nama)
                    @if ($kondisi_nama['id'] == $ruasDetail['ruasjalan']['kondisi_id'])
                        @php
                            $nama_kondisi = $kondisi_nama['kondisi'];
                        @endphp
                    @endif
                @endforeach
                <option value="{{ $ruasDetail['ruasjalan']['kondisi_id'] }}" selected>{{ $nama_kondisi }}</option>
                @foreach($kondisi as $kondisis)
                    <option value="{{ $kondisis['id'] }}">{{ $kondisis['kondisi'] }}</option>
                @endforeach
            </select>
            <label for="jenisjalan_id">Jenis Jalan</label>
            <select name="jenisjalan_id" id="jenisjalan_id" class="form-control">
                @foreach ($jenisjalan as $jenisjalan_nama)
                    @if ($jenisjalan_nama['id'] == $ruasDetail['ruasjalan']['jenisjalan_id'])
                        @php
                            $nama_jenisjalan = $jenisjalan_nama['jenisjalan'];
                        @endphp
                    @endif
                @endforeach
                <option value="{{ $ruasDetail['ruasjalan']['jenisjalan_id'] }}" selected >{{ $nama_jenisjalan }}</option>
                @foreach($jenisjalan as $jenis)
                    <option value="{{ $jenis['id'] }}">{{ $jenis['jenisjalan'] }}</option>
                @endforeach
            </select>
            <label for="paths">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $ruasDetail['ruasjalan']['keterangan'] }}">
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-dark">Update</button>
        </div>
        
    </form>

<script>
    document.addEventListener('DOMContentLoaded', function () {

    const provinceDropdown = document.getElementById('provinsi');
    const regencyDropdown = document.getElementById('kabupaten');
    const districtDropdown = document.getElementById('kecamatan');
    const villageDropdown = document.getElementById('desa_id');

    provinceDropdown.addEventListener('change', function () {
        // Enable/disable regency dropdown based on the selected province
        regencyDropdown.disabled = !provinceDropdown.value;

        // Filter regencies based on the selected province
        const selectedProvinceId = provinceDropdown.value;
        filterOptions(regencyDropdown, selectedProvinceId, 'data-province');
    });

    regencyDropdown.addEventListener('change', function () {
        districtDropdown.disabled = !regencyDropdown.value;

        // Filter districts based on the selected regency
        const selectedRegencyId = regencyDropdown.value;
        filterOptions(districtDropdown, selectedRegencyId, 'data-regency');
    });

    districtDropdown.addEventListener('change', function () {
        // Enable/disable village dropdown based on the selected district
        villageDropdown.disabled = !districtDropdown.value;

        // Filter villages based on the selected district
        const selectedDistrictId = districtDropdown.value;
        filterOptions(villageDropdown, selectedDistrictId, 'data-district');
    });

    villageDropdown.addEventListener('change', function () {
        // Log the selected value for testing
        console.log('Selected Village ID:', villageDropdown.value);
    });

    function filterOptions(dropdown, filterValue, attributeName) {
        // Filter options in the dropdown based on the provided filterValue and attributeName
        Array.from(dropdown.options).forEach(function (option) {
            const shouldDisplay = option.getAttribute(attributeName) === filterValue;
            option.style.display = shouldDisplay ? 'block' : 'none';
            option.disabled = !shouldDisplay;
        });
    }

    var encodedPolyline = "{{ $ruasDetail['ruasjalan']['paths'] }}";
    //console.log(encodedPolyline);

    var decodedPolyline = polyline.decode(encodedPolyline);
    //console.log(decodedPolyline);

    const firstCoordinates = decodedPolyline[0];
    const latitude = firstCoordinates[0];
    const longitude = firstCoordinates[1];
        
    var mymap = L.map('mapid', { editable: true }).setView([latitude, longitude], 20);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    }).addTo(mymap);
        
    var polylineOld = L.polyline([decodedPolyline], { color: 'red', editable: true }).addTo(mymap);

    polylineOld.enableEdit();
    
    // event listener click pada map
    mymap.on('click', function (e) {
        polylineOld.addLatLng(e.latlng);

        const latLngs = polylineOld.getLatLngs();

        // console.log(polyline);
        // console.log(polyline.encodePath());
        document.getElementById('paths').value = polylineOld.encodePath();

        let totalDistance = 0;

        if (latLngs.length >= 2) {
            // const firstLatLng = latLngs[0];
            // const lastLatLng = latLngs[latLngs.length - 1];

            // hitung
            // const distanceInMeters = firstLatLng.distanceTo(lastLatLng);

            for(let i = 0; i < latLngs.length - 1; i++) {
                const currentLatLng = latLngs[i];
                const nextLatLng = latLngs[i + 1];

                const distance = currentLatLng.distanceTo(nextLatLng);
                totalDistance += distance;
                console.log(totalDistance);
            }
            document.getElementById('panjang').value = totalDistance;
        } else {
            console.error('Polyline must have at least two points to calculate distance.');
        }
    });

    // delete polyline using klik kanan
    mymap.on('contextmenu', function (e) {
        polylineOld.setLatLngs([]);
        document.getElementById('paths').value = '';
        document.getElementById('panjang').value = '';
    });
    });
</script>
@endsection
