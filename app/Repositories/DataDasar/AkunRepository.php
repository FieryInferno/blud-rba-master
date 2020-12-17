<?php

namespace App\Repositories\DataDasar;

use App\Models\Akun;
use App\Repositories\Repository;

class AkunRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Akun::class;
    }

    /**
     * Get parent RKA 21
     *
     * @return void
     */
    public function getParentRka21()
    {
        $akun = Akun::where('is_parent', true)
                    ->where('tipe', 5)
                    ->where('kode_akun', '<', '5.1.2')
                    ->orWhere(function ($q) {
                        $q->where('tipe', 5)
                            ->where('kelompok', 1)
                            ->where('jenis', 1)
                            ->where('is_parent', true);
                    })->get();
        return $akun;
    }

    /**
     * Get akun parent
     *
     * @return void
     */
    public function getAkunParent($tipe, $kelompok, $jenis, $object)
    {
        return Akun::with('ssh')
                    ->select(['id', 'kode_akun', 'nama_akun', 'is_parent'])
                    ->where('tipe', $tipe)
                    ->whereNull('kelompok')
                    ->orWhere(function ($query) use ($tipe) {
                        $query->where('tipe', $tipe)
                            ->where('kelompok', '');
                    })
                    ->orWhere(function ($query) use ($tipe, $kelompok) {
                        $query->where('tipe', $tipe)
                                ->where('kelompok', $kelompok)
                                ->whereNull('jenis')
                                ->orWhere(function ($query) use ($tipe, $kelompok) {
                                    $query->where('tipe', $tipe)
                                    ->where('kelompok', $kelompok)
                                    ->where('jenis', '');
                                });
                    })
                    ->orWhere(function ($query) use ($tipe, $kelompok, $jenis) {
                        $query->where('tipe', $tipe)
                                ->where('kelompok', $kelompok)
                                ->where('jenis', $jenis)
                                ->whereNull('objek')
                                ->orWhere(function ($query) use ($tipe, $kelompok, $jenis) {
                                    $query->where('tipe', $tipe)
                                    ->where('kelompok', $kelompok)
                                    ->where('jenis', $jenis)
                                    ->where('objek', '');
                                });
                    })
                    ->orWhere(function ($query) use ($tipe, $kelompok, $jenis, $object) {
                        $query->where('tipe', $tipe)
                                ->where('kelompok', $kelompok)
                                ->where('jenis', $jenis)
                                ->where('objek', $object);
                    })
                    ->where('is_parent', '1')
                    ->get();
    }
}
