<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kode', 'kode_bidang', 'nama_program'
    ];

    /**
     * Relation to program
     *
     * @return void
     */
    public function bidang()
    {
        return $this->belongsTo('App\Models\Bidang', 'kode_bidang', 'kode');
    }
}
