<?php

namespace App\Http\Controllers\Admin;

use App\Models\StatusAnggaran;
use App\Http\Controllers\Controller;
use App\Http\Requests\DataDasar\StatusAnggaranRequest;

class StatusAnggaranController extends Controller
{
    public function store(StatusAnggaranRequest $request)
    {
        $copyable = $request->salin == 'true' ? true : false;
        $statusAnggaran = StatusAnggaran::create([
            'status_anggaran' => strtoupper($request->status_anggaran),
            'is_copyable' => $copyable,
            'status_perubahan' => $request->status_perubahan
        ]);

        return redirect()->back()->with(['success' => 'Status anggaran berhasil disimpan']);
    }

    public function update(StatusAnggaranRequest $request)
    {
        $copyable = $request->salin == 'true' ? true : false;
        $statusAnggaran = StatusAnggaran::findOrFail($request->id);
        $statusAnggaran->update([
            'status_anggaran' => strtoupper($request->status_anggaran),
            'is_copyable' => $copyable,
            'status_perubahan' => $request->status_perubahan
        ]);

        return redirect()->back()->with(['success' => 'Status anggaran berhasil disimpan']);
    }
}
