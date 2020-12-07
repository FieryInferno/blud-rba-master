<html>
<head>
	<!-- <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-4.3.1.min.css') }}" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
	<style>
		body { font-family: "Times New Roman", Times, serif; }
		.col-print-1 {width:8%;  float:left;}
		.col-print-2 {width:16%; float:left;}
		.col-print-3 {width:25%; float:left;}
		.col-print-4 {width:33%; float:left;}
		.col-print-5 {width:42%; float:left;}
		.col-print-6 {width:50%; float:left;}
		.col-print-7 {width:58%; float:left;}
		.col-print-8 {width:66%; float:left;}
		.col-print-9 {width:75%; float:left;}
		.col-print-9{width:83%; float:left;}
		.col-print-11{width:92%; float:left;}
		.col-print-12{width:100%; float:left;}
		.clearfix{clear: both}
		table { width: 100%; }
		/* .container table, td, th { border: 1px solid black; } */
		/* .container th { background: grey; } */
		.container table { border-collapse: collapse; width: 100%; padding-top: 0; }
        /* .container table { display: inline-table; } */
        /* th { padding: 8px; font-size: 12.9px; } */
		td { padding: 5px; margin-left: 7px; font-size: 11px; vertical-align: top; }
        .content { border: 1px solid black; margin: 15px 0px; clear: both; }
        .content th { padding: 3px; font-size: 11.4px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
		.borderAll { border: 1px solid #000; }
		.borderNone { border: 0; }
        .container { font-size: 15px; }
        .container .list { padding-left: 30px; }
        .font-default { font-size: 13px }
        .footer { margin-top: 25px; font-size: 15px; clear: both; }
    </style>
    <title>Report RBA</title>
</head>
<body>
    <div class="container">
        <p class="text-center font-weight-bold">
            DINAS KESEHATAN KOTA MALANG <br/>
            RENCANA BISNIS DAN ANGGARAN <br/>
            RINCIAN PERUBAHAN BIAYA BLUD <br/>
            Tahun Anggaran {{ env('TAHUN_ANGGARAN', 2020) }} <br/>
        </p>

        <div class="col-print-2 font-default"> BLUD Unit Kerja </div>
        <div class="col-print-10 font-default"> : {{ $rba->unitKerja->nama_unit }} </div>
        <div class="clearfix"></div>
        
        @if ($rba->mapKegiatan)

            <div class="col-print-2 font-default"> Program </div>
            <div class="col-print-2 font-default"> : {{ $rba->mapKegiatan->blud->program->bidang->kode_urusan }}.{{ $rba->mapKegiatan->blud->program->bidang->kode_fungsi }}.{{ $rba->mapKegiatan->blud->program->kode_bidang }}.{{ $rba->mapKegiatan->blud->kode_program }}  </div>
            <div class="col-print-8 font-default"> {{ $rba->mapKegiatan->blud->program->nama_program }} </div>
            <div class="clearfix"></div>
            
            <div class="col-print-2 font-default"> BLUD Unit Kerja </div>
            <div class="col-print-2 font-default"> : {{ $rba->mapKegiatan->blud->program->bidang->kode_urusan }}.{{ $rba->mapKegiatan->blud->program->bidang->kode_fungsi }}.{{ $rba->mapKegiatan->blud->program->kode_bidang }}.{{ $rba->mapKegiatan->blud->kode_program }}.{{ $rba->mapKegiatan->kode_kegiatan_blud }} </div>
            <div class="col-print-8 font-default"> {{ $rba->mapKegiatan->blud->nama_kegiatan }}  </div>
            <div class="clearfix"></div>

            <div class="col-print-2 font-default"> Kelompok Sasaran Kegiatan </div>
            <div class="col-print-10 font-default"> : Masyarakat </div>
            <div class="clearfix"></div>

        @endif

        <table class="content">
            <tr>
                <th class="borderLeft text-center" rowspan="3" style="width: 10%">Kode <br/> Rekening</th>
                <th class="borderLeft text-center" rowspan="3" style="width: 12%;">Uraian</th>
                <th class="borderLeft text-center" rowspan="3" style="width: 10%;">Kode Standar</th>
                <th class="borderLeft text-center" colspan="4">Sebelum Perubahan</th>
                <th class="borderLeft text-center" colspan="4">Setelah Perubahan</th>
                <th class="borderLeft text-center" colspan="2">Bertambah/(Berkurang)</th>
            </tr>

            <tr>
                <th class="borderAll text-center" colspan="3">Rincian Perhitungan</th>        
                <th class="borderAll text-center" rowspan="2">Jumlah</th>        
                <th class="borderAll text-center" colspan="3">Rincian Perhitungan</th>        
                <th class="borderAll text-center" rowspan="2">Jumlah</th>        
                <th class="borderAll text-center" rowspan="2">Rp.</th>        
                <th class="borderAll text-center" rowspan="2">%</th>        
            </tr>

            <tr>
                <th class="borderAll text-center">Volume</th>
                <th class="borderAll text-center">Satuan</th>
                <th class="borderAll text-center">Harga Satuan</th>
                <th class="borderAll text-center">Volume</th>
                <th class="borderAll text-center">Satuan</th>
                <th class="borderAll text-center">Harga Satuan</th>
            </tr>

            <tr>
                <th class="borderAll text-center">1</th>
                <th class="borderAll text-center">2</th>
                <th class="borderAll text-center">3</th>
                <th class="borderAll text-center">4</th>
                <th class="borderAll text-center">5</th>
                <th class="borderAll text-center">6</th>
                <th class="borderAll text-center">7</th>
                <th class="borderAll text-center">8</th>
                <th class="borderAll text-center">9</th>
                <th class="borderAll text-center">10</th>
                <th class="borderAll text-center">11</th>
                <th class="borderAll text-center">12</th>
                <th class="borderAll text-center">13</th>
            </tr>

            @foreach ($akun as $item)
                @if ($item->is_parent)
                    <tr>
                        <td class="borderLeft text-left font-weight-bold">{{ $item->kode_akun }}</td>
                        <td class="borderLeft text-left font-weight-bold">{{ str_replace('/', ' / ', $item->nama_akun) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report($reportRba[$item->kode_akun]) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report($reportRba[$item->kode_akun.'_pak']) }}</td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report(abs($reportRba[$item->kode_akun.'_pak'] - $reportRba[$item->kode_akun])) }}</td>
                        <td class="borderLeft text-center font-weight-bold"></td>
                    </tr>
                @else
                    <tr>
                        <td class="borderLeft text-left font-weight-bold">{{ $item->kode_akun }}</td>
                        <td class="borderLeft text-left font-weight-bold">{{ str_replace('/', ' / ', $item->nama_akun) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report($reportRba[$item->kode_akun]) }}</td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-right"></td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report($reportRba[$item->kode_akun.'_pak']) }}</td>
                        <td class="borderLeft text-center font-weight-bold">{{ format_report(abs($reportRba[$item->kode_akun.'_pak'] - $reportRba[$item->kode_akun])) }}</td>
                        <td class="borderLeft text-center font-weight-bold"></td>
                    </tr>
                    @foreach ($rba->rincianAnggaran as $rincian)
                        @if ($rincian->akun->id == $item->id)
                        @php 
                            $selisih = abs(($rincian->volume_pak * $rincian->tarif_pak) - ($rincian->volume * $rincian->tarif));
                        @endphp
                            <tr>
                                <td class="borderLeft text-left"></td>
                                <td class="borderLeft text-left">{{ $rincian->ssh ? str_replace('/', ' / ', $rincian->ssh->nama_barang) : str_replace('/', ' / ', $rincian->uraian) }}</td>
                                <td class="borderLeft text-center"></td>
                                <td class="borderLeft text-right">{{ $rincian->volume }}</td>
                                <td class="borderLeft text-right">{{ $rincian->satuan }}</td>
                                <td class="borderLeft text-right">{{ format_report($rincian->tarif) }}</td>
                                <td class="borderLeft text-right">{{ format_report($rincian->volume * $rincian->tarif) }}</td>
                                <td class="borderLeft text-right">{{ $rincian->volume_pak }}</td>
                                <td class="borderLeft text-right">{{ $rincian->satuan_pak }}</td>
                                <td class="borderLeft text-right">{{ format_report($rincian->tarif_pak) }}</td>
                                <td class="borderLeft text-center">{{ format_report($rincian->volume_pak * $rincian->tarif_pak) }}</td>
                                <td class="borderLeft text-center">{{ format_report($selisih) }}</td>
                                <td class="borderLeft text-center"></td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </table>

        <div class="footer">
            <div class="col-print-6"></div>
            <div class="col-print-6 text-center">
                <strong>KUASA PENGGUNA ANGGARAN</strong> <br/>

                <br/><br/><br/>

                <u>{{ $kepala ? $kepala->nama_pejabat : 'KEPALA PUSKESMAS BELUM DI INPUT' }}</u> <br/>
                NIP: {{ $kepala ? $kepala->nip : '' }}
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-print-3 font-default"> Keterangan </div>
        <div class="col-print-9 font-default"> : </div>
        <div class="clearfix"></div>

        <div class="col-print-3 font-default"> Tanggal Pembahasan </div>
        <div class="col-print-9 font-default"> : </div>
        <div class="clearfix"></div>

        <div class="col-print-3 font-default"> Catatan Hasil Pembahasan </div>
        <div class="col-print-9 font-default"> : </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>