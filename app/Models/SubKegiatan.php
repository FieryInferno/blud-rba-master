<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKegiatan extends Model
{
    protected $table        = 'subKegiatan';
    protected $primarykey   = 'idSubKegiatan';
    protected $guarded      = [];

    public function kegiatan()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kodeKegiatan', 'kode');
    }
}
