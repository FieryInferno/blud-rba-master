<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rba extends Model
{
    use SoftDeletes;

    protected $table = 'rba';

    const KODE_RBA_1 = 'rba_1';
    const KODE_RBA_221 = 'rba_221';
    const KODE_RBA_31 = 'rba_31';
    const KODE_RBA_32 = 'rba_32';
    const TIPE_RBA_MURNI = 'MURNI';
    const TIPE_RBA_PAK = 'PAK';
    const STATUS_PERUBAHAN_MURNI = 'MURNI';
    const STATUS_PERUBAHAN_PERUBAHAN = 'PERUBAHAN';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode_rba', 'kode_opd', 'latar_belakang', 'kode_unit_kerja', 'pejabat_id', 'tipe', 'map_kegiatan_id', 
        'kelompok_sasaran', 'created_by', 'updated_by', 'rba_murni_id', 'status_anggaran_id'
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
        return $this->hasMany('App\Models\RbaRincianAnggaran');
    }

    /**
     * Relation to rincian sumber dana.
     *
     */
    public function rincianSumberDana()
    {
        return $this->hasMany('App\Models\RbaRincianSumberDana');
    }

    /**
     * Relation to rincian sumber dana.
     *
     */
    public function indikatorKerja()
    {
        return $this->hasMany('App\Models\RbaIndikatorKerja');
    }

    /**
     * Relation to self PAK.
     *
     */
    public function pak()
    {
        return $this->hasMany('App\Models\Rba', 'rba_murni_id', 'id');
    }

    /**
     * Relation to self Murni.
     *
     */
    public function murni()
    {
        return $this->belongsTo('App\Models\Rba', 'rba_murni_id', 'id');
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
     * Get kode rba
     *
     * @param [type] $value
     * @return void
     */
    public function getKodeRbaAttribute($value)
    {
        return strtoupper(str_replace('_', ' ', $value));
    }

    /**
     * Relation to pejabat unit
     * 
     * @return void
     */
    public function pejabatUnit()
    {
        return $this->belongsTo('App\Models\PejabatUnit', 'pejabat_id', 'id');
    }

    public function statusAnggaran()
    {
        return $this->belongsTo(StatusAnggaran::class);
    }

    public function mapSubKegiatan()
    {
        return $this->belongsTo('App\Models\MapSubKegiatan', 'map_kegiatan_id', 'idMapSubKegiatan');
    }
}
