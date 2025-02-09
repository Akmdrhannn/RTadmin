<?php

namespace App\Http\Controllers\Api;

use App\Models\pembayaran;
use Illuminate\Http\Request;
use App\Http\Resources\PembayaranResource;
use Illuminate\Routing\Controller as BaseController;

class PembayaranController extends BaseController
{
    public function index()
    {
        $pembayaran = pembayaran::get()->all();
        return new PembayaranResource(true, 'Data pembayaran', $pembayaran);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Add validation rules here
        ]);

        $pembayaran = pembayaran::create($request->all());
        return new PembayaranResource(true, 'Data pembayaran ditambah', $pembayaran);
    }

    public function show($id)
    {
        $pembayaran = pembayaran::where('id_pembayaran', $id)->firstOrFail();
        return new PembayaranResource(true, 'Data pembayaran spesifik', $pembayaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Add validation rules here
        ]);

        $pembayaran = pembayaran::where('id_pembayaran', $id)->firstOrFail();
        $pembayaran->update($request->all());
        return new PembayaranResource(true, 'Data pembayaran diupdate', $pembayaran);
    }

    public function destroy($id)
    {
        $pembayaran = pembayaran::where('id_pembayaran', $id)->firstOrFail();
        $pembayaran->delete();
        return new PembayaranResource(true, 'Data pembayaran dihapus', $pembayaran);
    }
}
