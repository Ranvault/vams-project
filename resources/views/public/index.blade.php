@extends('layouts.app')

@section('content')
<div class="p-4 mb-4 bg-dark text-white rounded-3 shadow-sm">
    <h1 class="fw-bold">Jelajahi Destinasi Impian Bersama VEROS Adventure</h1>
    <p class="mb-0">Pilih paket Open Trip favoritmu, daftarkan rombongan dalam satu formulir, dan amankan kursi dengan DP.</p>
</div>

<div class="row">
    @forelse($trips as $trip)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            @if($trip->poster)
                <img src="{{ asset('storage/' . $trip->poster) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $trip->nama_trip }}">
            @else
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                    <span>Tidak Ada Poster</span>
                </div>
            @endif
            <div class="card-body d-flex flex-column">
                <span class="badge bg-info text-dark align-self-start mb-2">{{ $trip->destinasi }}</span>
                <h5 class="card-title fw-bold">{{ $trip->nama_trip }}</h5>
                <p class="text-muted small mb-2">
                    Jadwal: <strong>{{ $trip->tgl_berangkat }}</strong> ({{ $trip->durasi }})<br>
                    Sisa Kuota: <strong>{{ $trip->kuota }} peserta</strong>
                </p>
                <p class="card-text small">{{ Str::limit($trip->deskripsi, 100) }}</p>
                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block">Harga / Orang</small>
                        <strong class="text-primary fs-5">Rp {{ number_format($trip->harga, 0, ',', '.') }}</strong>
                    </div>
                    <a href="{{ route('booking.create', $trip->id) }}" class="btn btn-primary">Daftar Trip</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-warning text-center">Belum ada jadwal Open Trip yang tersedia saat ini.</div>
    </div>
    @endforelse
</div>
@endsection