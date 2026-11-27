<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['trip', 'participants', 'payments'])->latest()->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function verifikasi(Request $request, Payment $payment)
    {
        $request->validate([
            'status_verifikasi' => 'required|in:valid,ditolak',
        ]);

        $payment->update([
            'status_verifikasi' => $request->status_verifikasi,
        ]);

        // Perbarui status_booking secara otomatis jika pembayaran dinyatakan valid
        if ($request->status_verifikasi === 'valid') {
            $booking = $payment->booking;
            if ($payment->jenis_bayar === 'DP') {
                $booking->update(['status_booking' => 'dp_terverifikasi']);
            } elseif ($payment->jenis_bayar === 'Pelunasan') {
                $booking->update(['status_booking' => 'lunas']);
            }
        }

        return back()->with('success', "Status pembayaran {$payment->jenis_bayar} berhasil diperbarui menjadi {$request->status_verifikasi}.");
    }

    public function destroy(Booking $booking)
    {
        // Kembalikan kuota trip sebelum menghapus booking
        $jumlahPeserta = $booking->participants()->count();
        $booking->trip->increment('kuota', $jumlahPeserta);

        $booking->delete();

        return back()->with('success', 'Data booking berhasil dihapus dan kuota trip telah dikembalikan.');
    }
}