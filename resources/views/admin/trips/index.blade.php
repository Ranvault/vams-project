@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Manajemen Paket Open Trip</h3>
    <a href="{{ route('admin.trips.create') }}" class="btn btn-primary">+ Tambah Trip Baru</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Poster</th>
                    <th>Nama Trip & Destinasi</th>
                    <th>Jadwal & Durasi</th>
                    <th>Harga / Pax</th>
                    <th>Kuota</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trips as $trip)
                <tr>
                    <td>
                        @if($trip->poster)
                            <img src="{{ asset('storage/' . $trip->poster) }}" width="80" class="rounded">
                        @else
                            <span class="badge bg-secondary">No Image</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $trip->nama_trip }}</strong><br>
                        <small class="text-muted">{{ $trip->destinasi }}</small>
                    </td>
                    <td>{{ $trip->tgl_berangkat }}<br><small>({{ $trip->durasi }})</small></td>
                    <td>Rp {{ number_format($trip->harga, 0, ',', '.') }}</td>
                    <td>{{ $trip->kuota }} org</td>
                    <td>
                        <a href="{{ route('admin.trips.edit', $trip->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.trips.destroy', $trip->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus paket trip ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data Open Trip.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection