<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrapos extends Model
{
    protected $table = 'kontrapos';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'kode_unit_kerja', 'kode');
    }

    public function kontraposRincian()
    {
        return $this->hasMany(KontraposRincian::class);
    }

    public function bkuRincian()
    {
        return $this->hasOne(BkuRincian::class);
    }
}
