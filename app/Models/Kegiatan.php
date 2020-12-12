<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode', 'kode_bidang', 'kode_program', 'nama_kegiatan'
    ];

    /**
     * Relation to program
     *
     * @return void
     */
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'kode_program', 'kode');
    }

    public function subKegiatan()
    {
        return $this->hasMany('App\Models\SubKegiatan', 'kodeKegiatan', 'kode');
    }
}
