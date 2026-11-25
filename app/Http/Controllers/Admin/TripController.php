<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TripController extends Controller
{
    public function index()
    {
        $trips = Trip::latest()->get();
        return view('admin.trips.index', compact('trips'));
    }

    public function create()
    {
        return view('admin.trips.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_trip'     => 'required|string|max:255',
            'destinasi'     => 'required|string|max:255',
            'tgl_berangkat' => 'required|date',
            'durasi'        => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
            'kuota'         => 'required|integer|min:1',
            'deskripsi'     => 'required|string',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Trip::create($validated);

        return redirect()->route('admin.trips.index')->with('success', 'Paket Open Trip berhasil ditambahkan.');
    }

    public function edit(Trip $trip)
    {
        return view('admin.trips.edit', compact('trip'));
    }

    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'nama_trip'     => 'required|string|max:255',
            'destinasi'     => 'required|string|max:255',
            'tgl_berangkat' => 'required|date',
            'durasi'        => 'required|string|max:100',
            'harga'         => 'required|numeric|min:0',
            'kuota'         => 'required|integer|min:1',
            'deskripsi'     => 'required|string',
            'poster'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            if ($trip->poster) {
                Storage::disk('public')->delete($trip->poster);
            }
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $trip->update($validated);

        return redirect()->route('admin.trips.index')->with('success', 'Paket Open Trip berhasil diperbarui.');
    }

    public function destroy(Trip $trip)
    {
        if ($trip->poster) {
            Storage::disk('public')->delete($trip->poster);
        }
        $trip->delete();

        return redirect()->route('admin.trips.index')->with('success', 'Paket Open Trip berhasil dihapus.');
    }
}