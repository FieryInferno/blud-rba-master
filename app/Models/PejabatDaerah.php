<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PejabatDaerah extends Model
{
    protected $table = 'pejabat_daerah';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'nip', 'jabatan_id', 'status'
    ];

    /**
     * Relation to jabatan
     */
    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan');
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
