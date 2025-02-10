<?php

namespace App\Http\Controllers\Api;

use App\Models\historyPenghuni;
use Illuminate\Http\Request;
use App\Http\Resources\HistoryPenghuniResource;
use Illuminate\Routing\Controller as BaseController;

class HistoryPenghuniController extends BaseController
{
    public function index()
    {
        $historyPenghuni = historyPenghuni::get()->all();
        return new HistoryPenghuniResource(true, 'Data history penghuni', $historyPenghuni);
    }

    public function show($id)
    {
        $historyPenghuni = historyPenghuni::where('id_history_penghuni', $id)->firstOrFail();
        return new HistoryPenghuniResource(true, 'Data history penghuni spesifik', $historyPenghuni);
    }

    public function update(Request $request, $id)
    {
        $request->validate([]);

        $historyPenghuni = historyPenghuni::where('id_history_penghuni', $id)->firstOrFail();
        $historyPenghuni->update($request->all());
        return new HistoryPenghuniResource(true, 'Data history penghuni diupdate', $historyPenghuni);
    }

    public function destroy($id)
    {
        $historyPenghuni = historyPenghuni::where('id_history_penghuni', $id)->firstOrFail();
        $historyPenghuni->delete();
        return new HistoryPenghuniResource(true, 'Data history penghuni dihapus', $historyPenghuni);
    }
}
