<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rka extends Model
{
    use SoftDeletes;

    protected $table = 'rka';

    const KODE_RKA_1 = 'rka_1';
    const KODE_RKA_21 = 'rka_21';
    const KODE_RKA_221 = 'rka_221';
    const TIPE_RKA_MURNI = 'MURNI';
    const TIPE_RKA_PAK = 'PAK';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_rka', 'kode_opd', 'kode_unit_kerja', 'pejabat_id', 'tipe', 'map_kegiatan_id', 
        'kelompok_sasaran', 'created_by', 'updated_by', 'rka_murni_id', 'status_anggaran_id'
    ];

    /**
     * Relation to unit kerja.
     */
    public function unitKerja()
    {
        return $this->belongsTo('App\Models\UnitKerja', 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to rincian anggaran.
     *
     */
    public function rincianAnggaran()
    {
        return $this->hasMany('App\Models\RkaRincianAnggaran');
    }

    /**
     * Relation to rincian sumber dana.
     *
     */
    public function indikatorKerja()
    {
        return $this->hasMany('App\Models\RkaIndikatorKerja');
    }

    /**
     * Relation to self PAK.
     *
     */
    public function pak()
    {
        return $this->hasMany('App\Models\Rka', 'rka_murni_id', 'id');
    }

    /**
     * Relation to self Murni.
     *
     */
    public function murni()
    {
        return $this->belongsTo('App\Models\Rka', 'rka_murni_id', 'id');
    }

    /**
     * Relation to map kegiatan
     *
     * @return void
     */
    public function mapKegiatan()
    {
        return $this->belongsTo('App\Models\MapKegiatan');
    }

    /**
     * Relation to rincian sumber dana.
     *
     */
    public function rincianSumberDana()
    {
        return $this->hasMany('App\Models\RkaRincianSumberDana');
    }

    public function getKodeRkaAttribute($value)
    {
        return strtoupper(str_replace('_', ' ', $value));
    }

    public function statusAnggaran()
    {
        return $this->belongsTo(StatusAnggaran::class);
    }
}
