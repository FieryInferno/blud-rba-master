<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BastRincianPengadaan extends Model
{
    protected $table = 'bast_rincian_pengadaan';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function bast()
    {
        return $this->belongsTo(Bast::class);
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode_akun');
    }
}
