<?php

namespace App\Http\Controllers\Api;

use App\Models\pengeluaran;
use Illuminate\Http\Request;
use App\Http\Resources\PengeluaranResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'bukti_pengeluaran' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userid = Auth::id();

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
            'kategori' => 'sometimes',
            'deskripsi' =>  'sometimes',
            'tanggal_pengeluaran' => 'sometimes',
            'jumlah' =>  'sometimes',
            'penerima' =>  'sometimes',
            'bukti_pengeluaran' => 'sometimes|image|mimes:png,jpg,jpeg|max:2048'
        ]);
        $userid = Auth::id();

        $pengeluaran = pengeluaran::where('id_pengeluaran', $id)->firstOrFail();
        $data = [
            'userid' => $request->userid ?? $pengeluaran->userid,
            'kategori' => $request->kategori ?? $pengeluaran->kategori,
            'deskripsi' => $request->deskripsi ?? $pengeluaran->deskripsi,
            'tanggal_pengeluaran' => $request->tanggal_pengeluaran ?? $pengeluaran->tanggal_pengeluaran,
            'jumlah' => $request->jumlah ?? $pengeluaran->jumlah,
            'penerima' => $request->penerima ?? $pengeluaran->penerima,
        ];

        if ($request->bukti_pengeluaran) {
            $data['bukti_pengeluaran'] = $request->bukti_pengeluaran->hashName();
            $request->bukti_pengeluaran->storeAs('public/bukti_pengeluaran');
            Storage::delete('public/bukti_pengeluaran' . basename($pengeluaran->bukti_pengeluaran));
        } else {
            $data['bukti_pengeluaran'] = $pengeluaran->bukti_pengeluaran;
        }

        $pengeluaran->update($data);
        return new PengeluaranResource(true, 'Data pengeluaran diupdate', $pengeluaran);
    }

    public function destroy($id)
    {
        $pengeluaran = pengeluaran::where('id_pengeluaran', $id)->firstOrFail();
        $pengeluaran->delete();
        return new PengeluaranResource(true, 'Data pengeluaran dihapus', $pengeluaran);
    }
}
