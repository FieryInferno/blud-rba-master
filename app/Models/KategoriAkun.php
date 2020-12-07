<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriAkun extends Model
{
    protected $table = 'kategori_akun';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode', 'nama_akun', 'saldo_normal'
    ];
}
