<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PejabatUnit extends Model
{
    protected $table = 'pejabat_unit';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_pejabat', 'nip', 'kode_unit_kerja', 'jabatan_id', 'status'
    ];

    /**
     * Relation to jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo('App\Models\JabatanPejabatUnit');
    }

    /**
     * Relation to unit kerja
     */
    public function unit()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'kode_unit_kerja');
    }

    /**
     * Get the pejabat status.
     *
     * @param  string  $value
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $value === 1 ? 'Aktif' : 'Tidak Aktif';
    }
}
