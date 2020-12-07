<?php

namespace App\Models;

use App\Models\Bast;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spp';

    protected $guarded = [];

    /**
     * Relation to unit kerja
     *
     * @return void
     */
    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    /**
     * Relation to bast
     *
     * @return void
     */
    public function bast()
    {
        return $this->belongsTo(Bast::class);
    }

    /**
     * Relation to spp pajak
     *
     * @return void
     */
    public function referensiPajak()
    {
        return $this->hasMany(SppPajak::class);
    }

    /**
     * Relation to spp rincian spd
     *
     * @return void
     */
    public function referensiSpd()
    {
        return $this->hasMany(SppReferensiSpd::class);
    }

    /**
     * Relation to pejabat unit
     *
     * @return void
     */
    public function sppPemimpinBlud()
    {
        return $this->belongsTo(PejabatUnit::class, 'pemimpin_blud', 'id');
    }

    /**
     * Relation to pejabat unit
     *
     * @return void
     */
    public function sppPptk()
    {
        return $this->belongsTo(PejabatUnit::class, 'pptk', 'id');
    }

    /**
     * Relation to rekening bendahara
     *
     * @return void
     */
    public function bendaharaPengeluaran()
    {
        return $this->belongsTo(PejabatUnit::class, 'bendahara_pengeluaran', 'id');
    }

    /**
     * Relation to pihak ketiga
     *
     * @return void
     */
    public function pihakKetiga()
    {
        return $this->belongsTo(PihakKetiga::class);
    }
}
