<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    protected $table = 'bast';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function rincianPengadaan()
    {
        return $this->hasMany(BastRincianPengadaan::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    public function pihakKetiga()
    {
        return $this->belongsTo(PihakKetiga::class, 'pihak_ketiga_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kode_kegiatan', 'kode');
    }
}
