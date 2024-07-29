@extends('layouts.app')

@section('title', 'GIS')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('dashboard')}}" class="btn btn-dark">Full Map</a>
        <a href="{{ route('ruasjalan.create')}}" class="btn btn-dark">+ Create</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Ruas</th>
                <th>Panjang</th>
                <th>Lainnya</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @foreach($ruasjalanData as $ruas)
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td>{{ $ruas['nama_ruas'] }}</td>
                    <td>{{ $ruas['panjang'] }}</td>
                    <td>
                        <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ isset($ruas['id']) ? route('ruasjalan.detail', ['id' => $ruas['id']]) : '#' }}">Detail</a>
                            <a class="dropdown-item" href="{{ route('map', ['encodedPolyline' => urlencode($ruas['paths'])]) }}">Maps</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ isset($ruas['id']) ? route('ruasjalan.edit', ['id' => $ruas['id']]) : '#' }}">Edit</a>
                            <form action="{{ route('ruasjalan.delete', ['id' => $ruas['id']]) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="dropdown-item">Hapus</button>
                            </form>
                        </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
