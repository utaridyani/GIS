@extends('layouts.app')

@section('title', 'Region Dashboard')

@section('content')
    <div class="container">
        <h3 class="text-center" font-weight="bold">Region Dashboard</h3>

        <div class="form-group">
            <label for="provinsi">Select Provinsi </label>
            <select id="provinsi" class="form-control">
                <option value="" selected disabled>Select Provinsi</option>
                @foreach($provinsi as $prov)
                    <option value="{{ $prov['id'] }}">{{ $prov['provinsi'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="kabupaten">Select Kabupaten</label>
            <select id="kabupaten" class="form-control" disabled>
                <option value="" selected disabled>Select Kabupaten</option>
                @foreach($kabupaten as $kab)
                    <option value="{{ $kab['id'] }}" data-province="{{ $kab['prov_id'] }}">{{ $kab['kabupaten'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="kecamatan">Select Kecamatan</label>
            <select id="kecamatan" class="form-control" disabled>
                <option value="" selected disabled>Select Kecamatan</option>
                @foreach($kecamatan as $kec)
                    <option value="{{ $kec['id'] }}" data-regency="{{ $kec['kab_id'] }}">{{ $kec['kecamatan'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceDropdown = document.getElementById('provinsi');
            const regencyDropdown = document.getElementById('kabupaten');
            const districtDropdown = document.getElementById('kecamatan');

            provinceDropdown.addEventListener('change', function () {
                // Enable/disable regency dropdown based on the selected province
                regencyDropdown.disabled = !provinceDropdown.value;
                districtDropdown.disabled = true; // Disable district dropdown when changing province

                // Filter regencies based on the selected province
                const selectedProvinceId = provinceDropdown.value;
                filterOptions(regencyDropdown, selectedProvinceId, 'data-province');
            });

            regencyDropdown.addEventListener('change', function () {
                // Enable/disable district dropdown based on the selected regency
                districtDropdown.disabled = !regencyDropdown.value;
                // You can add additional logic here if needed
            });

            function filterOptions(dropdown, filterValue, attributeName) {
                // Filter options in the dropdown based on the provided filterValue and attributeName
                Array.from(dropdown.options).forEach(function (option) {
                    option.disabled = option.getAttribute(attributeName) !== filterValue;
                });
            }
        });
    </script>
@endsection
