<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RkaIndikatorKerja extends Model
{
    protected $table = 'rka_indikator_kerja';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'rka_id', 'jenis_indikator', 'tolak_ukur_kerja', 'target_kerja', 
       'jenis_indikator_pak', 'tolak_ukur_kerja_pak', 'target_kerja_pak'
    ];
}
