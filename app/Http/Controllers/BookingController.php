<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Menampilkan Katalog Open Trip di Halaman Utama
    public function index()
    {
        $trips = Trip::where('kuota', '>', 0)->latest()->get();
        return view('public.index', compact('trips'));
    }

    // Menampilkan Detail Trip & Form Pendaftaran Multi-Peserta
    public function create(Trip $trip)
    {
        return view('public.booking', compact('trip'));
    }

    // Menyimpan Data Pemesan & Banyak Peserta Sekaligus
    public function store(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'nama_pemesan'               => 'required|string|max:255',
            'no_wa'                      => 'required|string|max:20',
            'email'                      => 'required|email|max:255',
            'peserta'                    => 'required|array|min:1',
            'peserta.*.nama_peserta'     => 'required|string|max:255',
            'peserta.*.no_identitas'     => 'required|string|max:50',
            'peserta.*.kontak_darurat'   => 'required|string|max:20',
        ]);

        $jumlahPeserta = count($validated['peserta']);

        // Validasi ketersediaan kuota trip
        if ($jumlahPeserta > $trip->kuota) {
            return back()->withInput()->with('error', "Maaf, sisa kuota hanya tersedia {$trip->kuota} orang.");
        }

        // Gunakan DB Transaction agar data booking & peserta tersimpan utuh
        $booking = DB::transaction(function () use ($validated, $trip, $jumlahPeserta) {
            $kodeBooking = 'VAMS-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            $totalTagihan = $trip->harga * $jumlahPeserta;

            $booking = Booking::create([
                'kode_booking'   => $kodeBooking,
                'trip_id'        => $trip->id,
                'nama_pemesan'   => $validated['nama_pemesan'],
                'no_wa'          => $validated['no_wa'],
                'email'          => $validated['email'],
                'total_tagihan'  => $totalTagihan,
                'status_booking' => 'menunggu_dp',
            ]);

            foreach ($validated['peserta'] as $item) {
                $booking->participants()->create([
                    'nama_peserta'   => $item['nama_peserta'],
                    'no_identitas'   => $item['no_identitas'],
                    'kontak_darurat' => $item['kontak_darurat'],
                ]);
            }

            // Kurangi kuota trip sesuai jumlah peserta yang didaftarkan
            $trip->decrement('kuota', $jumlahPeserta);

            return $booking;
        });

        return redirect()->route('booking.cek', ['kode_booking' => $booking->kode_booking])
            ->with('success', "Pendaftaran berhasil! Simpan Kode Booking Anda: {$booking->kode_booking} untuk melakukan pembayaran DP.");
    }
        // Menampilkan Halaman Cek Booking & Form Upload Pembayaran (Public)
        public function cekBooking(Request $request)
        {
            $booking = null;
            if ($request->filled('kode_booking')) {
                $booking = Booking::with(['trip', 'participants', 'payments'])
                    ->where('kode_booking', $request->kode_booking)
                    ->first();

                if (!$booking) {
                    return back()->with('error', 'Kode Booking tidak ditemukan. Periksa kembali kode Anda.');
                }
            }

            return view('public.cek-booking', compact('booking'));
        }

    // Menyimpan Bukti Pembayaran DP / Pelunasan
    public function uploadPayment(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'jenis_bayar'    => 'required|in:DP,Pelunasan',
            'nominal'        => 'required|numeric|min:10000',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Cegah upload ganda jika jenis pembayaran yang sama masih pending atau sudah valid
        $sudahAda = $booking->payments()
            ->where('jenis_bayar', $validated['jenis_bayar'])
            ->whereIn('status_verifikasi', ['pending', 'valid'])
            ->exists();

        if ($sudahAda) {
            return back()->with('error', "Pembayaran {$validated['jenis_bayar']} sudah dikirim atau sudah terverifikasi.");
        }

        $path = $request->file('bukti_transfer')->store('payments', 'public');

        $booking->payments()->create([
            'jenis_bayar'       => $validated['jenis_bayar'],
            'nominal'           => $validated['nominal'],
            'bukti_transfer'    => $path,
            'status_verifikasi' => 'pending',
        ]);

        return redirect()->route('booking.cek', ['kode_booking' => $booking->kode_booking])
            ->with('success', "Bukti pembayaran {$validated['jenis_bayar']} berhasil diunggah dan menunggu verifikasi Admin.");
    }
}