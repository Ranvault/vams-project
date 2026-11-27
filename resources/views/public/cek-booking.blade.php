@extends('layouts.app')

@section('content')
<div class="row justify-content-center mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Cek Status Booking & Upload Pembayaran</div>
            <div class="card-body">
                <form action="{{ route('booking.cek') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="kode_booking" class="form-control" placeholder="Masukkan Kode Booking (Contoh: VAMS-20261125-XXXX)" value="{{ request('kode_booking') }}" required>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if($booking)
<div class="row">
    <!-- Kolom Kiri: Rincian Booking & Daftar Peserta -->
    <div class="col-md-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Detail Booking: {{ $booking->kode_booking }}</strong>
                <span class="badge bg-primary text-uppercase">{{ str_replace('_', ' ', $booking->status_booking) }}</span>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Paket Trip:</strong> {{ $booking->trip->nama_trip }} ({{ $booking->trip->destinasi }})</p>
                <p class="mb-1"><strong>Tanggal Berangkat:</strong> {{ $booking->trip->tgl_berangkat }}</p>
                <p class="mb-1"><strong>Pemesan:</strong> {{ $booking->nama_pemesan }} ({{ $booking->no_wa }})</p>
                <p class="mb-3"><strong>Total Tagihan:</strong> <span class="text-danger fw-bold fs-5">Rp {{ number_format($booking->total_tagihan, 0, ',', '.') }}</span></p>

                <h6 class="fw-bold border-top pt-3">Daftar Peserta ({{ $booking->participants->count() }} Orang)</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Peserta</th>
                            <th>No. Identitas</th>
                            <th>Kontak Darurat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booking->participants as $idx => $p)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $p->nama_peserta }}</td>
                            <td>{{ $p->no_identitas }}</td>
                            <td>{{ $p->kontak_darurat }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <h6 class="fw-bold border-top pt-3">Riwayat Pembayaran</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Jenis</th>
                            <th>Nominal</th>
                            <th>Bukti</th>
                            <th>Status Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->payments as $pay)
                        <tr>
                            <td>{{ $pay->jenis_bayar }}</td>
                            <td>Rp {{ number_format($pay->nominal, 0, ',', '.') }}</td>
                            <td><a href="{{ asset('storage/' . $pay->bukti_transfer) }}" target="_blank">Lihat Foto</a></td>
                            <td>
                                @if($pay->status_verifikasi == 'valid')
                                    <span class="badge bg-success">Valid</span>
                                @elseif($pay->status_verifikasi == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada bukti pembayaran yang diunggah.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Upload Bukti Transfer -->
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">Upload Bukti Pembayaran</div>
            <div class="card-body">
                @if($booking->status_booking == 'lunas')
                    <div class="alert alert-success mb-0">Pembayaran Anda sudah <strong>LUNAS</strong> dan terverifikasi. Sampai jumpa di meeting point!</div>
                @else
                    <div class="alert alert-light border small mb-3">
                        <strong>Rekening Pembayaran VEROS Adventure:</strong><br>
                        BCA: 1234567890 a.n. VEROS Adventure<br>
                        <em>Minimal DP 50% (Rp {{ number_format($booking->total_tagihan * 0.5, 0, ',', '.') }})</em>
                    </div>

                    <form action="{{ route('booking.payment', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Jenis Pembayaran</label>
                            <select name="jenis_bayar" class="form-select" required>
                                <option value="DP">DP (Down Payment)</option>
                                <option value="Pelunasan">Pelunasan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nominal Transfer (Rp)</label>
                            <input type="number" name="nominal" class="form-control" placeholder="Contoh: 500000" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Bukti Transfer (JPG/PNG, Max 2MB)</label>
                            <input type="file" name="bukti_transfer" class="form-control @error('bukti_transfer') is-invalid @enderror" required>
                            @error('bukti_transfer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold">Kirim Bukti Pembayaran</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection