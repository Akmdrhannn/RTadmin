<?php

namespace App\Http\Controllers\api;

use App\Http\Resources\PenghuniResource;
use App\Models\penghuni;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghuni = penghuni::get()->all();
        return new PenghuniResource(true, 'Data penghuni', $penghuni);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'foto_ktp' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'status_penghuni' => 'required',
            'nomor_telp' => 'required',
            'status_menikah' => 'required'
        ]);

        //up fotoktp
        $foto = $request->file('foto_ktp');
        $foto->storeAs('public/fotoktp', $foto->hashName());
        $penghuni = penghuni::create([
            'nama_lengkap' => $request->nama_lengkap,
            'foto_ktp' => $foto->hashName(),
            'status_penghuni' => $request->status_penghuni,
            'nomor_telp' => $request->nomor_telp,
            'status_menikah' => $request->status_menikah
        ]);
        return new PenghuniResource(true, 'Data penghuni ditambah', $penghuni);
    }

    public function show($id)
    {
        $penghuni = penghuni::where('id_penghuni', $id)->firstOrFail();
        return new PenghuniResource(true, 'Data penghuni spesifik', $penghuni);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'status_penghuni' => 'required',
            'status_menikah' => 'required'
        ]);

        $penghuni = penghuni::where('id_penghuni', $id)->firstOrFail();

        // cek update gambar
        if ($request->hasFile('foto_ktp')) {
            //up gambar
            $foto = $request->file('foto_ktp');
            $foto->storeAs('public/fotoktp', $foto->hashName());

            //Hapus gambar lama
            Storage::delete('public/fotoktp' . basename($penghuni->foto));

            //Update gambar yang baru di upload
            $penghuni->update([
                'nama_lengkap' => $request->nama_lengkap,
                'foto_ktp' => $foto->hashName(),
                'status_penghuni' => $request->status_penghuni,
                'nomor_telp' => $request->nomor_telp,
                'status_menikah' => $request->status_menikah,
                'rumah_id' => $request->rumah_id
            ]);
        } else {
            //Jika tanpa foto
            $penghuni->update([
                'nama_lengkap' => $request->nama_lengkap,
                'status_penghuni' => $request->status_penghuni,
                'nomor_telp' => $request->nomor_telp,
                'status_menikah' => $request->status_menikah,
                'rumah_id' => $request->rumah_id

            ]);
        }
        return new PenghuniResource(true, 'Data penghuni diupdate', $penghuni);
    }

    public function destroy($id)
    {
        $penghuni = penghuni::where('id_penghuni', $id)->firstOrFail();
        Storage::delete('public/fotoktp' . basename($penghuni->foto));
        $penghuni->delete();
        return new PenghuniResource(true, 'Data penghuni dihapus ', $penghuni);
    }
}
