<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    protected $table = 'unit_kerja';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_opd', 'kode', 'nama_unit'
    ];

    /**
     * Relation to pejabat unit
     */
    public function pejabat()
    {
        return $this->hasMany('App\Models\PejabatUnit', 'kode_unit_kerja', 'kode');
    }

    public function mapSubKegiatan()
    {
        return $this->hasMany('App\Models\MapSubKegiatan', 'kodeUnitKerja', 'kode');
    }
}
