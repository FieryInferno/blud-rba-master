<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RkaRincianSumberDana extends Model
{
    protected $table = 'rka_rincian_sumber_dana';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rka_id', 'akun_id', 'sumber_dana_id', 'nominal', 'nominal_pak'
    ];

    /**
     * Relation to akun.
     *
     */
    public function akun()
    {
        return $this->belongsTo('App\Models\Akun');
    }

    /**
     * Relation to sumber dana 
     *
     */
    public function sumberDana()
    {
        return $this->belongsTo('App\Models\SumberDana');
    }
}
