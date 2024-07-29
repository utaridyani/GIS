@extends('layouts.app')

@section('title', 'Detail')

@section('content')
    <!-- Polyline decoding library -->
    <script src="https://unpkg.com/polyline"></script>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('ruasjalan.master')}}" class="btn btn-dark">&#x2190; Back</a>
        <div></div>
        <a href="{{ route('map', ['encodedPolyline' => urlencode($ruasDetail['ruasjalan']['paths'])]) }}" class="btn btn-dark">Lihat Map</a>
    </div>

    <h1>Detail Ruas</h1>
        <div class="form-group">
            <label for="paths">Paths</label>
            <input type="text" name="paths" id="paths" class="form-control" value="{{ $ruasDetail['ruasjalan']['paths'] ?? 'N/A' }}" readonly>
            <label for="desa_id">Desa</label>
                @foreach ($desa as $desa_nama)
                    @if ($desa_nama['id'] == $ruasDetail['ruasjalan']['desa_id'])
                        @php
                            $nama_desa = $desa_nama['desa'];
                        @endphp
                    @endif
                @endforeach
            <input type="text" name="desa" id="desa" class="form-control" value="{{ $nama_desa }}" readonly>
            <label for="nama_ruas">Nama Ruas</label>
            <input type="text" name="nama_ruas" id="nama_ruas" class="form-control" value="{{ $ruasDetail['ruasjalan']['nama_ruas'] ?? 'N/A' }}" readonly>
            <label for="kode_ruas">Kode Ruas</label>
            <input type="text" name="kode_ruas" id="kode_ruas" class="form-control" value="{{ $ruasDetail['ruasjalan']['kode_ruas'] ?? 'N/A' }}" readonly>
            <label for="panjang">Panjang</label>
            <input type="text" name="panjang" id="panjang" class="form-control" value="{{ $ruasDetail['ruasjalan']['panjang'] ?? 'N/A' }}" readonly>
            <label for="lebar">Lebar</label>
            <input type="text" name="lebar" id="lebar" class="form-control" value="{{ $ruasDetail['ruasjalan']['lebar'] ?? 'N/A' }}" readonly>
            <label for="eksisting_id">Eksisting</label>
                @foreach ($eksisting as $eksisting_nama)
                    @if ($eksisting_nama['id'] == $ruasDetail['ruasjalan']['eksisting_id'])
                        @php
                            $nama_eksisting = $eksisting_nama['eksisting'];
                        @endphp
                    @endif
                @endforeach
            <input type="text" name="eksisting_id" id="eksisting_id" class="form-control" value="{{ $nama_eksisting }}" readonly>
            <label for="kondisi_id">Kondisi</label>
                @foreach ($kondisi as $kondisi_nama)
                    @if ($kondisi_nama['id'] == $ruasDetail['ruasjalan']['kondisi_id'])
                        @php
                            $nama_kondisi = $kondisi_nama['kondisi'];
                        @endphp
                    @endif
                @endforeach
            <input type="text" name="kondisi_id" id="kondisi_id" class="form-control" value="{{ $nama_kondisi }}" readonly>
            <label for="jenisjalan_id">Jenis Jalan</label>
                @foreach ($jenisjalan as $jenisjalan_nama)
                    @if ($jenisjalan_nama['id'] == $ruasDetail['ruasjalan']['jenisjalan_id'])
                        @php
                            $nama_jenisjalan = $jenisjalan_nama['jenisjalan'];
                        @endphp
                    @endif
                @endforeach
            <input type="text" name="jenisjalan_id" id="jenisjalan_id" class="form-control" value="{{ $nama_jenisjalan }}" readonly>
            <label for="paths">Keterangan</label>
            <input type="text" name="keterangan" id="keterangan" class="form-control" value="{{ $ruasDetail['ruasjalan']['keterangan'] ?? 'N/A' }}" readonly>
        </div>
    </form>


@endsection
