<?php

namespace App\Models;

use App\Models\UnitKerja;
use App\Models\BkuRincian;
use Illuminate\Database\Eloquent\Model;

class Bku extends Model
{
    protected $table = 'bku';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomor', 'tanggal', 'kode_unit_kerja', 'keterangan', 'nomor_otomatis'
    ];

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
     * Relation to bku rincian
     *
     * @return void
     */
    public function bkuRincian()
    {
        return $this->hasMany(BkuRincian::class);
    }

    /**
     * Relation to bku rincian
     *
     * @return void
     */
    public function bkuSumberDana()
    {
        return $this->hasMany(BkuRincian::class);
    }
}
