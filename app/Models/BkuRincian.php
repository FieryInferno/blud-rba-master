<?php

namespace App\Models;

use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Model;

class BkuRincian extends Model
{
    protected $table = 'bku_rincian';

    const STS = 'STS';
    const SP2D = 'SP2D';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bku_id', 'no_aktivitas', 'tipe', 'tanggal', 'penerimaan', 'pengeluaran', 'kode_unit_kerja', 
        'sts_id', 'sp2d_id', 'setor_pajak_pajak_id', 'kontrapos_id'
    ];

    /**
     * Relation to unitKerja
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to sts
     *
     * @return void
     */
    public function sts()
    {
        return $this->belongsTo(Sts::class);
    }

    /**
     * Relation to sp2d
     *
     * @return void
     */
    public function sp2d()
    {
        return $this->belongsTo(Sp2d::class);
    }

    /**
     * Relation to setorPajak
     *
     * @return void
     */
    public function setorPajak()
    {
        return $this->belongsTo(SetorPajakPajak::class, 'setor_pajak_pajak_id');
    }


    public function kontrapos()
    {
        return $this->belongsTo(Kontrapos::class, 'kontrapos_id');
    }

    /**
     * Relation to sts
     *
     * @return void
     */
    public function bku()
    {
        return $this->belongsTo(Bku::class);
    }
}
