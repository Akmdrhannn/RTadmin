<?php

namespace App\Http\Controllers\Api;

use App\Models\pengeluaran;
use Illuminate\Http\Request;
use App\Http\Resources\PengeluaranResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class PengeluaranController extends BaseController
{
    public function index()
    {
        $pengeluaran = pengeluaran::get()->all();
        return new PengeluaranResource(true, 'Data pengeluaran', $pengeluaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'tanggal_pengeluaran' => 'required',
            'jumlah' => 'required',
            'penerima' => 'required',
            'bukti_pengeluaran' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userid = Auth::id(); // Get the authenticated user's ID

        // Up bukti pengeluaran
        $buktitrx = $request->file('bukti_pengeluaran');
        $buktitrx->storeAs('public/bukti_pengeluaran', $buktitrx->hashName());

        $pengeluaran = pengeluaran::create([
            'userid' => $userid,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
            'jumlah' => $request->jumlah,
            'penerima' => $request->penerima,
            'bukti_pengeluaran' => $buktitrx->hashName(),
        ]);
        return new PengeluaranResource(true, 'Data pengeluaran ditambah', $pengeluaran);
    }

    public function show($id)
    {
        $pengeluaran = pengeluaran::where('id_pengeluaran', $id)->firstOrFail();
        return new PengeluaranResource(true, 'Data pengeluaran spesifik', $pengeluaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Add validation rules here
        ]);

        $pengeluaran = pengeluaran::where('id_pengeluaran', $id)->firstOrFail();
        $pengeluaran->update($request->all());
        return new PengeluaranResource(true, 'Data pengeluaran diupdate', $pengeluaran);
    }

    public function destroy($id)
    {
        $pengeluaran = pengeluaran::where('id_pengeluaran', $id)->firstOrFail();
        $pengeluaran->delete();
        return new PengeluaranResource(true, 'Data pengeluaran dihapus', $pengeluaran);
    }
}
