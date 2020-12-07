<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rba;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use App\Repositories\RBA\RBARepository;
use App\Http\Requests\Report\ReportRequest;
use App\Models\Rka;
use App\Models\SumberDana;
use App\Repositories\DataDasar\AkunRepository;
use App\Repositories\Organisasi\UnitKerjaRepository;
use App\Repositories\RKA\RKARepository;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Unit kerja repository.
     * 
     * @var RBARepository
     */
    private $rba;

    /**
     * Unit kerja repository.
     * 
     * @var RKARepository
     */
    private $rka;

    /**
     * Unit kerja repository.
     * 
     * @var AkunRepository
     */
    private $akun;

    /**
     * Unit kerja repository.
     * 
     * @var UnitKerjaRepository
     */
    private $unitKerja;

    public function __construct(
        RBARepository $rba,
        RKARepository $rka,
        UnitKerjaRepository $unitKerja,
        AkunRepository $akun
    ) {
        $this->rba = $rba;
        $this->rka = $rka;
        $this->unitKerja = $unitKerja;
        $this->akun = $akun;
    }

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $whereRba = function ($query){
            $query->where('tipe', auth()->user()->status);
        };
        $rba = $this->rba->get(['*'], $whereRba);
        $kodeUnitKerja = $rba->pluck('kode_unit_kerja')->unique();

        $whereUnitKerja = function ($query) use($kodeUnitKerja){
            if (auth()->user()->hasRole('Puskesmas')) {
                $query->where('kode',  auth()->user()->kode_unit_kerja);
            }
            $query->whereIn('kode', $kodeUnitKerja);
        };

        $unitKerja = $this->unitKerja->get(['*'], $whereUnitKerja);

        return view('admin.report.index', compact('unitKerja'));
    }
    /**
     * Report PDF
     *
     * @return void
     */
    public function report(ReportRequest $request)
    {
        $rba1 = $this->rba->getRba($request->unit_kerja, auth()->user()->status, Rba::KODE_RBA_1);
        $rba2 = $this->rba->getRba221($request->unit_kerja, auth()->user()->status, Rba::KODE_RBA_221);
        $rba31 = $this->rba->getRba($request->unit_kerja, auth()->user()->status, Rba::KODE_RBA_31);

        $rka2 = $this->rka->getRka221($request->unit_kerja, auth()->user()->status, Rka::KODE_RKA_221);

        $totalRka = 0;
        $totalRka = $rka2->sum(function ($item){
            return $item->rincianSumberDana->sum('nominal');
        });

        $reportRba1 = [];
        $reportRba2 = [];
        $reportRka2 = [];
        $kodeAkunRba = [];
        $kodeAkunRka = [];

        if ($rba1){
            // get report for rba 1
            $reportRba1 = [
                'layanan_umum' => 0,
                'bpjs' => 0,
                'jampersal' => 0,
                'spm' => 0,
                'lain_lain' => 0
            ];

            foreach ($rba1->rincianSumberDana as $item) {
                if ($item->akun->kode_akun == '4.1.4.16.02') {
                    $reportRba1['layanan_umum'] += $item->nominal;
                } else if ($item->akun->kode_akun == '4.1.4.16.03') {
                    $reportRba1['bpjs'] += $item->nominal;
                } else if ($item->akun->kode_akun == '4.1.4.16.04') {
                    $reportRba1['jampersal'] += $item->nominal;
                } else if ($item->akun->kode_akun == '4.1.4.16.05') {
                    $reportRba1['spm'] += $item->nominal;
                } else {
                    $reportRba1['lain_lain'] += $item->nominal;
                }
            }

            $rba1->total_all = $rba1->rincianSumberDana->sum('nominal');
        }

        if ($rba2){
            // get report for rba 2
            $allKodeAkunRba = [];
            $kodeParent = [];
            $dataKode = [];
            foreach ($rba2 as $valueRba2) {
                foreach ($valueRba2->rincianAnggaran as $rincian) {
                    if (! in_array($rincian->akun->kode_akun, $allKodeAkunRba)){
                        array_push($allKodeAkunRba, $rincian->akun->kode_akun);
                    }
                }

                // get unique kode akun 
                foreach ($allKodeAkunRba as $item) {
                    $kode = substr($item, 0, 8);
                    if (!in_array($kode, $dataKode)) {
                        $dataKode[] = $kode;
                    }
                }

                // get parent from unique kode akun
               
                foreach ($dataKode as $kode) {
                    $explode = explode('.', $kode);
                    $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
                    foreach ($parents as $akunParent) {
                        array_push($kodeParent, $akunParent);
                    }
                }
            }
            $whereAllKodeAKunRba = collect($allKodeAkunRba)->merge(collect($kodeParent))->sort();

            foreach ($whereAllKodeAKunRba as $item) {
                $reportRba2["{$item}"] = 0;
                foreach ($rba2 as $rba2item){
                    foreach ($rba2item->rincianSumberDana as $dataRba) {
                        if (preg_match("/{$item}/m", $dataRba->akun->kode_akun)) {
                            $reportRba2["{$item}"] += $dataRba->nominal;
                        }
                    }
                }
            }
            $kodeAkunRba = $whereAllKodeAKunRba->toArray();
            // dd($reportRba2);

            // $rba2->total_all = $rba2->rincianSumberDana->sum('nominal');
            $totalRba2 = 0;
            foreach ($rba2 as $allRba2) {
                $totalRba2 += $allRba2->rincianSumberDana->sum('nominal');
            }
        }

        if ($rba31){
            $rba31->total_all = $rba31->total_all = $rba31->rincianSumberDana->sum('nominal');
        }

        $unitKerja = $this->unitKerja->findBy('kode', '=', $request->unit_kerja, ['*'], ['pejabat']);
        $kepala = $unitKerja->pejabat->where('jabatan_id', 1)->first();

        if ($rka2) {
            // get report for rba 2
            $allKodeAkunRka = [];
            $kodeParent = [];
            $dataKode = [];
            foreach ($rka2 as $valueRka2) {
                foreach ($valueRka2->rincianAnggaran as $rincian) {
                    if (!in_array($rincian->akun->kode_akun, $allKodeAkunRka)) {
                        array_push($allKodeAkunRka, $rincian->akun->kode_akun);
                    }
                }

                // get unique kode akun 
                foreach ($allKodeAkunRka as $item) {
                    $kode = substr($item, 0, 8);
                    if (!in_array($kode, $dataKode)) {
                        $dataKode[] = $kode;
                    }
                }

                // get parent from unique kode akun

                foreach ($dataKode as $kode) {
                    $explode = explode('.', $kode);
                    $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
                    foreach ($parents as $akunParent) {
                        array_push($kodeParent, $akunParent);
                    }
                }
            }
            $whereAllKodeAKun = collect($allKodeAkunRka)->merge(collect($kodeParent))->sort();

            $kodeAkunRka = $whereAllKodeAKun->toArray();

            foreach ($whereAllKodeAKun as $item) {
                $reportRka2["{$item}"] = 0;
                foreach ($rka2 as $rka2item) {
                    foreach ($rka2item->rincianSumberDana as $dataRka) {
                        if (preg_match("/{$item}/m", $dataRka->akun->kode_akun)) {
                            $reportRka2["{$item}"] += $dataRka->nominal;
                        }
                    }
                }
            }

            $totalRka2 = 0;
            foreach ($rka2 as $allRka2) {
                foreach ($allRka2->rincianSumberDana as $value) {
                    $totalRka2 += $value->nominal;
                }
            }

        }

        $kodeRba = collect($kodeAkunRba);
        $kodeRka = collect($kodeAkunRka);
        $kodeAll = $kodeRba->merge($kodeRka);

        $whereAkunAll = function ($query) use($kodeAll){
            $query->whereIn('kode_akun',$kodeAll);
        };
        $akun = $this->akun->get(['*'], $whereAkunAll)->sortBy('kode_akun');
        $akun = collect($akun->values()->all());

        $reportRbaAndRka = collect($reportRba2)->merge(collect($reportRka2));

        $pdf = PDF::loadview('admin.report.report_pdf', compact(
            'reportRba1', 'rba1','reportRbaAndRka', 'rba2', 'totalRba2', 'akun', 
            'rba31', 'request', 'unitKerja', 'totalRka2', 'reportRka2', 'totalRka',
            'kepala', 'reportRba2'
        ));
        return $pdf->download('report-anggaran.pdf');
    }

    /**
     * Report Rba
     *
     * @param [type] $id
     * @return void
     */
    public function reportRba($id)
    {
        $statusAnggaran = auth()->user()->statusAnggaran->status_perubahan;

        $rba = $this->rba->find($id, ['*'], [
            'mapKegiatan.blud.program.bidang', 'rincianAnggaran.akun', 'unitKerja', 'indikatorKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh', 
            'rincianSumberDana.akun'
            ]);
        $akunId = $rba->rincianAnggaran->pluck('akun_id')->toArray();

        $reportRba = [];
        $allKodeAkunRba = [];
        foreach($rba->rincianAnggaran as $item){
            if (!in_array($item->akun->kode_akun, $allKodeAkunRba)){
                array_push($allKodeAkunRba, $item->akun->kode_akun);
            }
        }

        // get unique kode akun 
        $dataKode = [];
        foreach ($allKodeAkunRba as $item) {
            $kode = substr($item, 0, 8);
            if (!in_array($kode, $dataKode)) {
                $dataKode[] = $kode;
            }
        }

        // get parent from unique kode akun
        $kodeParent = [];
        foreach ($dataKode as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParent, $akunParent);
            }
        }
        $whereAllKodeAKun = collect($allKodeAkunRba)->merge(collect($kodeParent))->sort();

        $whereAkun = function ($query) use ($whereAllKodeAKun) {
            $query->whereIn('kode_akun', $whereAllKodeAKun);
        };

        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');


        foreach ($whereAllKodeAKun as $item) {
            $reportRba["{$item}"] = 0;
            if ($statusAnggaran == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                $reportRba["{$item}_pak"] = 0;
            }
         
            foreach ($rba->rincianSumberDana as $dataRba) {
                if (preg_match("/{$item}/m", $dataRba->akun->kode_akun)) {
                    $reportRba["{$item}"] += $dataRba->nominal;
                    if ($statusAnggaran == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
                        $reportRba["{$item}_pak"] += $dataRba->nominal_pak;
                    }
                }
            }
            
        }

        $rba->total_all = $rba->rincianSumberDana->sum('nominal');
        if ($statusAnggaran == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
            $rba->total_all_pak = $rba->rincianSumberDana->sum('nominal_pak');
        }

        $kepala = $rba->unitKerja->pejabat->where('jabatan_id', 1)->first();

        if ($statusAnggaran == Rba::STATUS_PERUBAHAN_PERUBAHAN) {
            $pdf = PDF::loadview('admin.report.new_report_rba', compact(
                    'rba','reportRba', 'akun', 'kepala'
            ))->setPaper('a4', 'landscape');

        }else {
            $pdf = PDF::loadview('admin.report.report_rba', compact(
                'rba', 'reportRba', 'akun', 'kepala'
            ));
        }

        return $pdf->download('report-rba.pdf', ['Attachment' => false]);
    }

    /**
     * Report Rka
     *
     * @param [type] $id
     * @return void
     */
    public function reportRka($id)
    {
        $nominal = 'nominal';
        if (auth()->user()->status == Rba::TIPE_RBA_PAK) {
            $nominal = 'nominal_pak';
        }

        $rka = $this->rka->find($id, ['*'], [
            'mapKegiatan.blud.program.bidang', 'rincianAnggaran.akun', 'unitKerja', 'indikatorKerja', 'rincianAnggaran.akun', 'rincianAnggaran.ssh',
            'rincianSumberDana.akun'
        ]);

        $akunId = $rka->rincianAnggaran->pluck('akun_id')->toArray();

        $reportRba = [];
        $allKodeAkunRba = [];
        foreach ($rka->rincianAnggaran as $item) {
            if (!in_array($item->akun->kode_akun, $allKodeAkunRba)) {
                array_push($allKodeAkunRba, $item->akun->kode_akun);
            }
        }

        // get unique kode akun 
        $dataKode = [];
        foreach ($allKodeAkunRba as $item) {
            $kode = substr($item, 0, 8);
            if (!in_array($kode, $dataKode)) {
                $dataKode[] = $kode;
            }
        }

        // get parent from unique kode akun
        $kodeParent = [];
        foreach ($dataKode as $kode) {
            $explode = explode('.', $kode);
            $parents = $this->akun->getAkunParent($explode[0], $explode[1], $explode[2], $explode[3])->pluck('kode_akun')->toArray();
            foreach ($parents as $akunParent) {
                array_push($kodeParent, $akunParent);
            }
        }
        $whereAllKodeAKun = collect($allKodeAkunRba)->merge(collect($kodeParent))->sort();

        $whereAkun = function ($query) use ($whereAllKodeAKun) {
            $query->whereIn('kode_akun', $whereAllKodeAKun);
        };

        $akun = $this->akun->get(['*'], $whereAkun)->sortBy('kode_akun');


        foreach ($whereAllKodeAKun as $item) {
            $reportRba["{$item}"] = 0;

            foreach ($rka->rincianSumberDana as $dataRba) {
                if (preg_match("/{$item}/m", $dataRba->akun->kode_akun)) {
                    $reportRba["{$item}"] += $dataRba->{$nominal};
                }
            }
        }

        $rka->total_all = $rka->rincianSumberDana->sum($nominal);

        $pdf = PDF::loadview('admin.report.report_rka', compact('rka', 'reportRba', 'akun'));
        return $pdf->download('report-rka.pdf', ['Attachment' => false]);
    }

    public function newReportRba()
    {
        $pdf = PDF::loadview('admin.report.new_report_rba')->setPaper('a4', 'landscape');
        return $pdf->download('new_report_rba.pdf', ['Attachment' => false]);
    }

}
