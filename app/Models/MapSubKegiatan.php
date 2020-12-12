<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapSubKegiatan extends Model
{
    protected $table        = 'mapSubKegiatan';
    protected $primaryKey   = 'idMapSubKegiatan';
    protected $guarded      = [];

    public function unitKerja()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'kodeUnitKerja', 'kode');
    }

    public function subKegiatanBlud()
    {
        return $this->belongsTo('App\Models\SubKegiatan', 'kodeSubKegiatanBlud', 'kodeSubKegiatan');
    }

    public function subKegiatanApbd()
    {
        return $this->belongsTo('App\Models\SubKegiatan', 'kodeSubKegiatanApbd', 'kodeSubKegiatan');
    }
}
