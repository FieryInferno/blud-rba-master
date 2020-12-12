<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    protected $table        = 'subKegiatan';
    protected $primaryKey   = 'idSubKegiatan';
    protected $guarded      = [];

    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kodeKegiatan', 'kode');
    }

    public function mapSubKegiatanBlud()
    {
        return $this->hasMany('App\Models\MapSubKegiatan', 'kodeSubKegiatanBlud', 'kodeSubKegiatan');
    }

    public function mapSubKegiatanApbd()
    {
        return $this->hasMany('App\Models\MapSubKegiatan', 'kodeSubKegiatanApbd', 'kodeSubKegiatan');
    }
}
