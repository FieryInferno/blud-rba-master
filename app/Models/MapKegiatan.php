<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapKegiatan extends Model
{
    protected $table = 'map_kegiatan';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_unit_kerja', 'kegiatan_id_blud', 'kegiatan_id_apbd',
    ];

    /**
     * Relation to unit kerja.
     *
     */
    public function unit()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to kode kegiatan blud.
     *
     */
    public function blud()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kegiatan_id_blud', 'id');
    }

    /**
     * Relation to kode kegiatan apbd.
     *
     */
    public function apbd()
    {
        return $this->belongsTo('App\Models\Kegiatan', 'kegiatan_id_apbd', 'id');
    }

    /**
     * Relation to rba.
     *
     */
    public function rba()
    {
        return $this->hasMany('App\Models\Rba', 'map_kegiatan_id');
    }

    /**
     * Relation to rka.
     *
     */
    public function rka()
    {
        return $this->hasMany('App\Models\Rka', 'map_kegiatan_id');
    }
}
