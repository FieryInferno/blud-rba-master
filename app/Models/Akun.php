<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    protected $table = 'akun';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipe', 'kelompok', 'jenis', 'objek', 'rincian', 'sub1', 'sub2', 'sub3', 'kode_akun',
        'nama_akun', 'kategori_id', 'pagu', 'realisasi', 'is_parent'
    ];

    /**
     * Relation to Kategori akun
     */
    public function kategori()
    {
        return $this->belongsTo('App\Models\KategoriAkun');
    }

    /**
     * Relation to ssh
     *
     */
    public function ssh()
    {
        return $this->hasMany('App\Models\Ssh', 'kode_akun', 'kode_akun');
    }

    /**
     * Set the akun is_parent.
     *
     * @param  string  $value
     * @return void
     */
    public function setIsParentAttribute($value)
    {
        $this->attributes['is_parent'] = $value == 'on';
    }
}
