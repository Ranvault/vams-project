@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">Tambah Paket Open Trip</div>
    <div class="card-body">
        <form action="{{ route('admin.trips.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Trip</label>
                    <input type="text" name="nama_trip" class="form-control @error('nama_trip') is-invalid @enderror" value="{{ old('nama_trip') }}" required>
                    @error('nama_trip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Destinasi</label>
                    <input type="text" name="destinasi" class="form-control @error('destinasi') is-invalid @enderror" value="{{ old('destinasi') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tanggal Berangkat</label>
                    <input type="date" name="tgl_berangkat" class="form-control" value="{{ old('tgl_berangkat') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Durasi (Misal: 3H2M)</label>
                    <input type="text" name="durasi" class="form-control" value="{{ old('durasi') }}" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kuota Peserta</label>
                    <input type="number" name="kuota" class="form-control" value="{{ old('kuota') }}" min="1" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga per Peserta (Rp)</label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga') }}" min="0" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poster Trip (JPG/PNG, Max 2MB)</label>
                    <input type="file" name="poster" class="form-control @error('poster') is-invalid @enderror">
                    @error('poster')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Deskripsi & Itinerary Singkat</label>
                    <textarea name="deskripsi" rows="4" class="form-control" required>{{ old('deskripsi') }}</textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Trip</button>
            <a href="{{ route('admin.trips.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection