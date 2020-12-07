<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ssh extends Model
{
    protected $table = 'ssh';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'golongan', 'bidang', 'kelompok', 'sub1', 'sub2', 'sub3', 'sub4', 'kode', 'kode_akun', 'nama_barang',
        'satuan', 'merk', 'spesifikasi', 'harga'
    ];

    /**
     * Set the harga.
     *
     * @param  string  $value
     * @return void
     */
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = parse_idr($value);
    }

     /**
     * Relation to Kategori akun
     */
    public function akun()
    {
        return $this->belongsTo('App\Models\Akun', 'kode_akun', 'kode_akun');
    }
}
