@extends('layouts.app')

@section('title', 'Create Ruas Jalan')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('ruasjalan.master')}}" class="btn btn-dark">&#x2190; Back</a>
    </div>

    <h1>Create Ruas Jalan</h1>

    <form action="{{ route('ruasjalan.store') }}" method="post">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div id="mapid" style="height: 400px;"></div>
        <div class="form-group">
            <label for="paths">Paths</label>
            <input type="text" name="paths" id="paths" class="form-control" readonly>
            <label for="provinsi">Provinsi</label>
            <select id="provinsi" class="form-control">
                <option value="" selected disabled>Select Provinsi</option>
                @foreach($provinsi as $prov)
                    <option value="{{ $prov['id'] }}">{{ $prov['provinsi'] }}</option>
                @endforeach
            </select> 
            <label for="kabupaten">Kabupaten</label>
            <select id="kabupaten" class="form-control" disabled>
                <option value="" selected disabled>Select Kabupaten</option>
                @foreach($kabupaten as $kab)
                    <option value="{{ $kab['id'] }}" data-province="{{ $kab['prov_id'] }}">{{ $kab['kabupaten'] }}</option>
                @endforeach
            </select>  
            <label for="kecamatan">Kecamatan</label>
            <select id="kecamatan" class="form-control" disabled>
                <option value="" selected disabled>Select Kecamatan</option>
                @foreach($kecamatan as $kec)
                    <option value="{{ $kec['id'] }}" data-regency="{{ $kec['kab_id'] }}">{{ $kec['kecamatan'] }}</option>
                @endforeach
            </select>     
            <label for="desa_id">Desa</label>
            <select name="desa_id" id="desa_id" class="form-control" disabled>
                <option value="" selected disabled>Select Desa</option>
                @foreach($desa as $desas)
                    <option value="{{ $desas['id'] }}" data-district="{{ $desas['kec_id'] }}">{{ $desas['desa'] }}</option>
                @endforeach
            </select> 
            <label for="nama_ruas">Nama Ruas</label>
            <input type="text" name="nama_ruas" id="nama_ruas" class="form-control">
            <label for="kode_ruas">Kode Ruas</label>
            <input type="text" name="kode_ruas" id="kode_ruas" class="form-control">
            <label for="panjang">Panjang</label>
            <input type="text" name="panjang" id="panjang" class="form-control">
            <label for="lebar">Lebar</label>
            <input type="text" name="lebar" id="lebar" class="form-control">
            <label for="eksisting_id">Eksisting</label>
            <select name="eksisting_id" id="eksisting_id" class="form-control">
                <option value="" selected disabled>Select Eksisting</option>
                @foreach($eksisting as $eksistings)
                    <option value="{{ $eksistings['id'] }}">{{ $eksistings['eksisting'] }}</option>
                @endforeach
            </select>
            <label for="kondisi_id">Kondisi</label>
            <select name="kondisi_id" id="kondisi_id" class="form-control">
                <option value="" selected disabled>Select Kondisi</option>
                @foreach($kondisi as $kondisis)
                    <option value="{{ $kondisis['id'] }}">{{ $kondisis['kondisi'] }}</option>
                @endforeach
            </select>
            <label for="jenisjalan_id">Jenis Jalan</label>
            <select name="jenisjalan_id" id="jenisjalan_id" class="form-control">
                <option value="" selected disabled>Select Jenis Jalan</option>
                @foreach($jenisjalan as $jenis)
                    <option value="{{ $jenis['id'] }}">{{ $jenis['jenisjalan'] }}</option>
                @endforeach
            </select>
            <label for="paths">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control">
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-dark">Save</button>
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
        districtDropdown.disabled = true;
        villageDropdown.disabled = true;

        // Filter regencies based on the selected province
        const selectedProvinceId = provinceDropdown.value;
        filterOptions(regencyDropdown, selectedProvinceId, 'data-province');
    });

    regencyDropdown.addEventListener('change', function () {
        districtDropdown.disabled = !regencyDropdown.value;
        villageDropdown.disabled = true;

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

    // MAP

    var mymap = L.map('mapid', { editable: true }).setView([-8.5330242817551, 115.21276982331896], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
    }).addTo(mymap);

    var polyline = L.polyline([], { color: 'red', editable: true }).addTo(mymap);

    polyline.enableEdit();

    // event listener click pada map
    mymap.on('click', function (e) {
        polyline.addLatLng(e.latlng);

        const latLngs = polyline.getLatLngs();

        //console.log(polyline);
        // console.log(polyline.encodePath());

        // encode + show in the input field
        document.getElementById('paths').value = polyline.encodePath();

        let totalDistance = 0;

        if (latLngs.length >= 2) {
            // const firstLatLng = latLngs[0];
            // const lastLatLng = latLngs[latLngs.length - 1];

            // const distanceInMeters = firstLatLng.distanceTo(lastLatLng);

            for(let i = 0; i < latLngs.length - 1; i++) {
                const currentLatLng = latLngs[i];
                const nextLatLng = latLngs[i + 1];

                const distance = currentLatLng.distanceTo(nextLatLng);
                totalDistance += distance;
                //console.log(totalDistance);
            }

            // console.log('Distance between first and last points:', totalDistance, 'meters');
            document.getElementById('panjang').value = totalDistance;
        } else {
            console.error('Polyline must have at least two points to calculate distance.');
        }
    });

    // delete polyline using klik kanan
    mymap.on('contextmenu', function (e) {
        polyline.setLatLngs([]);
        document.getElementById('paths').value = '';
        document.getElementById('panjang').value = '';
    });
    });
</script>
@endsection
