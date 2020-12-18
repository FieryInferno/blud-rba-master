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

    public function rba()
    {
        return $this->hasMany('App\Models\Rba', 'map_kegiatan_id', 'idMapSubKegiatan');
    }

    public function rka()
    {
        return $this->hasMany('App\Models\Rka', 'map_kegiatan_id', 'idMapSubKegiatan');
    }
}
