@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Ringkasan Paket Trip -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            @if($trip->poster)
                <img src="{{ asset('storage/' . $trip->poster) }}" class="card-img-top" alt="{{ $trip->nama_trip }}">
            @endif
            <div class="card-body">
                <h5 class="fw-bold">{{ $trip->nama_trip }}</h5>
                <p class="text-muted mb-2">{{ $trip->destinasi }} • {{ $trip->durasi }}</p>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Tanggal Berangkat</span>
                        <strong>{{ $trip->tgl_berangkat }}</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Sisa Kuota</span>
                        <strong>{{ $trip->kuota }} orang</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>Harga Satuan</span>
                        <strong>Rp {{ number_format($trip->harga, 0, ',', '.') }}</strong>
                    </li>
                </ul>
                <p class="small text-muted">{{ $trip->deskripsi }}</p>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Form Pemesan & Daftar Peserta -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">Formulir Pendaftaran Open Trip</div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store', $trip->id) }}" method="POST">
                    @csrf
                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">1. Data Penanggung Jawab (Pemesan)</h6>
                    <div class="row mb-4">
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" class="form-control" value="{{ old('nama_pemesan') }}" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control" placeholder="0812xxxx" value="{{ old('no_wa') }}" required>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h6 class="fw-bold text-primary mb-0">2. Data Peserta Rombongan</h6>
                        <button type="button" id="btn-tambah-peserta" class="btn btn-sm btn-success">+ Tambah Peserta</button>
                    </div>

                    <div id="container-peserta">
                        <!-- Baris Peserta Pertama (Index 0) -->
                        <div class="card bg-light mb-3 item-peserta">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <strong class="label-peserta">Peserta #1</strong>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label small">Nama Lengkap</label>
                                        <input type="text" name="peserta[0][nama_peserta]" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label small">NIK / No. Identitas</label>
                                        <input type="text" name="peserta[0][no_identitas]" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label small">Kontak Darurat (No. HP)</label>
                                        <input type="text" name="peserta[0][kontak_darurat]" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Estimasi Total Tagihan -->
                    <div class="alert alert-info d-flex justify-content-between align-items-center mt-3">
                        <span>Total Peserta: <strong id="total-orang">1</strong> orang</span>
                        <span>Total Tagihan: <strong id="total-harga">Rp {{ number_format($trip->harga, 0, ',', '.') }}</strong></span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Kirim Pendaftaran</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const hargaSatuan = {{ $trip->harga }};
    const maksKuota = {{ $trip->kuota }};
    let indexPeserta = 1;

    const container = document.getElementById('container-peserta');
    const btnTambah = document.getElementById('btn-tambah-peserta');

    function updateRingkasan() {
        const items = document.querySelectorAll('.item-peserta');
        const jumlah = items.length;
        items.forEach((item, idx) => {
            item.querySelector('.label-peserta').textContent = `Peserta #${idx + 1}`;
        });
        document.getElementById('total-orang').textContent = jumlah;
        document.getElementById('total-harga').textContent = 'Rp ' + (jumlah * hargaSatuan).toLocaleString('id-ID');
    }

    btnTambah.addEventListener('click', function () {
        const jumlahSekarang = document.querySelectorAll('.item-peserta').length;
        if (jumlahSekarang >= maksKuota) {
            alert('Jumlah peserta sudah mencapai batas sisa kuota trip!');
            return;
        }

        const card = document.createElement('div');
        card.className = 'card bg-light mb-3 item-peserta';
        card.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <strong class="label-peserta">Peserta #${indexPeserta + 1}</strong>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-hapus">Hapus</button>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                        <label class="form-label small">Nama Lengkap</label>
                        <input type="text" name="peserta[${indexPeserta}][nama_peserta]" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label small">NIK / No. Identitas</label>
                        <input type="text" name="peserta[${indexPeserta}][no_identitas]" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label small">Kontak Darurat (No. HP)</label>
                        <input type="text" name="peserta[${indexPeserta}][kontak_darurat]" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(card);
        indexPeserta++;
        updateRingkasan();
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-hapus')) {
            e.target.closest('.item-peserta').remove();
            updateRingkasan();
        }
    });
</script>
@endpush