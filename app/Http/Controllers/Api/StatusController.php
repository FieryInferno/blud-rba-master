<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\StatusAnggaran\StatusAnggaranRepository;

class StatusController extends Controller
{
    /**
     * Status anggaran repository
     * 
     * @var StatusAnggaranRepository
     */
    private $statusAnggaran;

    /**
     * Construct.
     */
    public function __construct(
        StatusAnggaranRepository $statusAnggaran
    ) {
        $this->statusAnggaran = $statusAnggaran;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $req_uri = $_SERVER['REQUEST_URI'];
            $path = substr($req_uri, 0, strrpos($req_uri,'/'));
            $path = explode('/', $path);

            $statusAnggaran = $this->statusAnggaran
                ->get(['id', 'status_anggaran']);
            
            return response()->json([
                'data' => [
                    'tahun' => intval($path[1]),
                    'status_anggaran' => $statusAnggaran
                ]
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
