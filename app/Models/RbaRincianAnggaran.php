<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RbaRincianAnggaran extends Model
{
    protected $table = 'rba_rincian_anggaran';
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'rba_id', 'akun_id', 'ssh_id', 'uraian', 'satuan', 'volume', 'tarif', 'satuan_pak', 'volume_pak', 'tarif_pak', 'tahun_berikutnya', 'keterangan'
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
    public function rba()
    {
        return $this->belongsTo('App\Models\Rba');
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
