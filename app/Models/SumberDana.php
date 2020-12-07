<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    protected $table = 'sumber_dana';

    const APBD = 'APBD';
    const BLUD = 'BLUD';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'akun_id', 'nama_sumber_dana', 'nama_bank', 'no_rekening'
    ];

     /**
     * Relation to akun
     */
    public function akun()
    {
        return $this->belongsTo('App\Models\Akun');
    }
}
