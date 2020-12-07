<?php

namespace App\Models;

use App\Models\SumberDana;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RbaRincianSumberDana extends Model
{
    protected $table = 'rba_rincian_sumber_dana';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rba_id', 'akun_id', 'sumber_dana_id', 'nominal', 'nominal_pak'
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
     * Relation to sumberdana 
     *
     * @return void
     */
    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class);
    }
}
