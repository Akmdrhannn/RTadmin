<?php

namespace App\Http\Controllers\Api;

use App\Models\Rumah;
use Illuminate\Http\Request;
use App\Http\Resources\RumahResource;
use Illuminate\Routing\Controller as BaseController;

class RumahController extends BaseController
{
    public function index()
    {
        $rumah = Rumah::get()->all();
        return new RumahResource(true, 'Data rumah', $rumah);
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'status_rumah' => 'required',
        ]);

        $rumah = Rumah::create($request->all());
        return new RumahResource(true, 'Data rumah ditambah', $rumah);
    }

    public function show($id)
    {
        $rumah = Rumah::where('id_rumah', $id)->firstOrFail();
        return new RumahResource(true, 'Data rumah spesifik', $rumah);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alamat' => 'required|string|max:255',
            'status_rumah' => 'required',
        ]);

        $rumah = Rumah::where('id_rumah', $id)->firstOrFail();
        $rumah->update([
            'alamat' => $request->alamat,
            'status_rumah' => $request->status_rumah,
        ]);
        return new RumahResource(true, 'Data rumah diupdate', $rumah);
    }

    public function destroy($id)
    {
        $rumah = Rumah::where('id_rumah', $id)->firstOrFail();
        $rumah->delete();
        return new RumahResource(true, 'Data rumah dihapus ', $rumah);
    }
}
