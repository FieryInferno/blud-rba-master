<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapAkun extends Model
{
    protected $table = 'map_akun';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_akun', 'kode_map_akun'
    ];

    /**
     * Relation to akun
     *
     */
    public function akun()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun', 'kode_akun');
    }

    /**
     * Relation to akun
     *
     */
    public function map()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_map_akun', 'kode_akun');
    }
}
