<?php

namespace App\Http\Controllers\Api;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Resources\PembayaranResource;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranController extends BaseController
{
    public function index()
    {
        $pembayaran = Pembayaran::all();
        return new PembayaranResource(true, 'Data pembayaran', $pembayaran);
    }

    public function store(Request $request)
    {
        // dd(Auth::check(), Auth::user(), Auth::id());

        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id_penghuni',
            'iuran_kebersihan' => 'required|numeric',
            'iuran_satpam' => 'required|numeric',
            'qty' => 'required|integer',
            'qty1' => 'required|integer',
        ]);

        $tanggalPembayaran = Carbon::now();

        $lastPembayaran = Pembayaran::where('penghuni_id', $request->penghuni_id)
            ->orderBy('berlaku_sampai', 'desc')
            ->first();

        if ($lastPembayaran) {
            $berlakuSampai = Carbon::parse($lastPembayaran->berlaku_sampai)->addMonths((int)$request->qty);
        } else {
            $berlakuSampai = $tanggalPembayaran->copy()->addMonths((int)$request->qty);
        }

        $totalPembayaran = $request->iuran_kebersihan * $request->qty;
        $totalPembayaran1 = $request->iuran_satpam * $request->qty1;

        $pembayaran = Pembayaran::create([

            'userid' => Auth::id(),
            'penghuni_id' => $request->penghuni_id,
            'bulan_tahun' => Carbon::now()->format('Y-m-d'),
            'iuran_kebersihan' => $request->iuran_kebersihan,
            'qty' => $request->qty,
            'pembayaran_terakhir' => $lastPembayaran ? $lastPembayaran->tanggal_pembayaran : '1970-01-01',
            'tanggal_pembayaran' => $tanggalPembayaran,
            'total_pembayaran' => $totalPembayaran,
            'berlaku_sampai' => $berlakuSampai->format('Y-m-01'),
            'status_pembayaran_kebersihan' => 'Lunas',
            'iuran_satpam' => $request->iuran_satpam,
            'qty1' => $request->qty1,
            'pembayaran_terakhir1' => $lastPembayaran ? $lastPembayaran->tanggal_pembayaran : '1970-01-01',
            'tanggal_pembayaran1' => $tanggalPembayaran,
            'total_pembayaran1' => $totalPembayaran1,
            'berlaku_sampai1' => $berlakuSampai->format('Y-m-01'),
            'status_pembayaran_satpam' => 'Lunas',
        ]);

        return new PembayaranResource(true, 'Data pembayaran ditambah', $pembayaran);
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        return new PembayaranResource(true, 'Data pembayaran spesifik', $pembayaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'penghuni_id' => 'sometimes|exists:penghuni,id_penghuni',
            'iuran_kebersihan' => 'sometimes|numeric',
            'iuran_satpam' => 'sometimes|numeric',
            'qty' => 'sometimes|integer',
            'qty1' => 'sometimes|integer',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $updateData = $request->only([
            'penghuni_id',
            'iuran_kebersihan',
            'iuran_satpam',
            'qty',
            'qty1',
        ]);

        // Hitung ulang total pembayaran jika qty/iuran diubah
        if ($request->has('iuran_kebersihan') || $request->has('qty')) {
            $updateData['total_pembayaran'] = ($request->iuran_kebersihan ?? $pembayaran->iuran_kebersihan) *
                ($request->qty ?? $pembayaran->qty);
        }

        if ($request->has('iuran_satpam') || $request->has('qty1')) {
            $updateData['total_pembayaran1'] = ($request->iuran_satpam ?? $pembayaran->iuran_satpam) *
                ($request->qty1 ?? $pembayaran->qty1);
        }

        // Perbarui tanggal pembayaran jika ada perubahan
        if ($request->hasAny(['iuran_kebersihan', 'iuran_satpam', 'qty', 'qty1'])) {
            $updateData['tanggal_pembayaran'] = Carbon::now();
        }

        $pembayaran->update($updateData);
        return new PembayaranResource(true, 'Data pembayaran diupdate', $pembayaran);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return new PembayaranResource(true, 'Data pembayaran dihapus', null);
    }
}
