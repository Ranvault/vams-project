@extends('layouts.app')

@section('content')
<h3 class="mb-3">Data Pemesanan & Verifikasi Pembayaran</h3>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Kode & Pemesan</th>
                    <th>Paket Trip</th>
                    <th>Daftar Peserta</th>
                    <th>Tagihan & Status</th>
                    <th>Bukti Pembayaran & Verifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr>
                    <td>
                        <strong>{{ $b->kode_booking }}</strong><br>
                        {{ $b->nama_pemesan }}<br>
                        <small class="text-muted">WA: {{ $b->no_wa }}</small>
                    </td>
                    <td>
                        {{ $b->trip->nama_trip }}<br>
                        <small class="text-muted">{{ $b->trip->tgl_berangkat }}</small>
                    </td>
                    <td>
                        <ul class="mb-0 ps-3 small">
                            @foreach($b->participants as $p)
                                <li>{{ $p->nama_peserta }} ({{ $p->no_identitas }})</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <strong>Rp {{ number_format($b->total_tagihan, 0, ',', '.') }}</strong><br>
                        <span class="badge bg-info text-dark text-uppercase">{{ str_replace('_', ' ', $b->status_booking) }}</span>
                    </td>
                    <td>
                        @forelse($b->payments as $pay)
                            <div class="border rounded p-2 mb-2 bg-light small">
                                <strong>{{ $pay->jenis_bayar }}</strong>: Rp {{ number_format($pay->nominal, 0, ',', '.') }}<br>
                                <a href="{{ asset('storage/' . $pay->bukti_transfer) }}" target="_blank" class="d-inline-block my-1">Lihat Bukti Transfer</a><br>
                                Status: <strong>{{ strtoupper($pay->status_verifikasi) }}</strong>

                                @if($pay->status_verifikasi == 'pending')
                                    <form action="{{ route('admin.payments.verifikasi', $pay->id) }}" method="POST" class="mt-1 d-flex gap-1">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" name="status_verifikasi" value="valid" class="btn btn-xs btn-success py-0 px-2">Valid</button>
                                        <button type="submit" name="status_verifikasi" value="ditolak" class="btn btn-xs btn-danger py-0 px-2">Tolak</button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <span class="text-muted small">Belum ada pembayaran</span>
                        @endforelse
                    </td>
                    <td>
                        <form action="{{ route('admin.bookings.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus booking ini? Kuota akan dikembalikan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data pemesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection