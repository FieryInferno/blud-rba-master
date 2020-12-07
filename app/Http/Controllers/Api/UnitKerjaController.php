<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Organisasi\UnitKerjaRequest;
use App\Repositories\Organisasi\UnitKerjaRepository;

class UnitKerjaController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    /**
     * Constructor.
     */
    public function __construct(UnitKerjaRepository $unitKerja)
    {
        $this->unitKerja = $unitKerja;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $ttl = (60 * 24) * 7 ; // in minutes, 7 days
            $cache = Cache::remember('unit_kerja', $ttl, function () {
                $unitKerja = $this->unitKerja->get(['id', 'kode_opd', 'kode', 'nama_unit']);
    
                return $unitKerja;
            });
    
            return response()->json([
                'data' => $cache
            ], 200);
        } catch(\Exception $exception) {
            report($exception);
            return response()->json([
                'message' => $exception->getMessage() ?? 'Terdapat kesalahan pada server',
                'data' => $exception
            ], 400);
        }
    }
}
