<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontraposRincian extends Model
{
    protected $table = 'kontrapos_rincian';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relation to akun
     *
     * @return void
     */
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode_akun');
    }

    public function kegiatan()
    { 
        return $this->belongsTo(Kegiatan::class);
    }

    public function sp2d()
    {
        return $this->belongsTo(Sp2d::class);
    }

    public function kontrapos()
    {
        return $this->belongsTo(Kontrapos::class);
    }

}
