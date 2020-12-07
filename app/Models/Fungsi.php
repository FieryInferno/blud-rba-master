<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fungsi extends Model
{
    protected $table = 'fungsi';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode', 'nama_fungsi'
    ];
}
