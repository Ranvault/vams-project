@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">Edit Paket Open Trip</div>
    <div class="card-body">
        <form action="{{ route('admin.trips.update', $trip->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Trip</label>
                    <input type="text" name="nama_trip" class="form-control" value="{{ old('nama_trip', $trip->nama_trip) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Destinasi</label>
                    <input type="text" name="destinasi" class="form-control" value="{{ old('destinasi', $trip->destinasi) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tgl_berangkat" class="form-control" value="{{ old('tgl_berangkat', $trip->tgl_berangkat) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="durasi" class="form-control" value="{{ old('durasi', $trip->durasi) }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kuota Peserta</label>
                    <input type="number" name="kuota" class="form-control" value="{{ old('kuota', $trip->kuota) }}" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga per Peserta (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $trip->harga) }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ganti Poster (Kosongkan jika tidak diubah)</label>
                    <input type="file" name="poster" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi & Itinerary Singkat</label>
                    <textarea name="deskripsi" rows="4" class="form-control" required>{{ old('deskripsi', $trip->deskripsi) }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Trip</button>
            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection