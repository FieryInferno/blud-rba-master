<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RkaRincianAnggaran extends Model
{
    protected $table = 'rka_rincian_anggaran';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'rka_id', 'akun_id', 'uraian', 'ssh_id', 'satuan', 'volume', 'tarif', 'satuan_pak', 'volume_pak', 'tarif_pak', 'tahun_berikutnya', 'keterangan'
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
     * Relation to rba.
     *
     */
    public function rka()
    {
        return $this->belongsTo('App\Models\Rka');
    }

    /**
     * Relation to ssh
     *
     */
    public function ssh()
    {
        return $this->belongsTo('App\Models\Ssh');
    }
}
