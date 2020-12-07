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
		.col-print-10{width:83%; float:left;}
		.col-print-11{width:92%; float:left;}
		.col-print-12{width:100%; float:left;}
		.clearfix{clear: both}
		table, td, th { border: 1px solid black; }
		table { border-collapse: collapse; width: 100%; }
		/* th { padding: 8px; font-size: 14px; }
		td { padding: 5px; margin-left: 7px; font-size: 12px; } */
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000 !important; }
        .subHeader { 
            padding: 5px; font-size: 12px; border: 0; 
            border-top: 1px solid #000; border-bottom: 1px solid #000;
        }
        .colHeader {
            padding: 5px; font-size: 12px;
        }

        .content {
            padding: 5px; font-size: 12px;
        }

        footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="7" class="text-center" style="font-size: 16px;">
                DINAS KESEHATAN KOTA MALANG <br/>
                RENCANA BISNIS DAN ANGGARAN <br/>
                RINCIAN BIAYA BLUD <br/>
                Tahun Anggaran 2019
            </th>
        </tr>

        <tr>
            <td width="30%" class="subHeader">
                BLUD Unit Kerja
            </td>

            <td colspan="6" class="subHeader">
                : {{ $rka->unitKerja->nama_unit }}
            </td>
        </tr>

        @if ($rka->mapKegiatan)
            <tr>
                <td class="subHeader">
                    Program
                </td>

                <td colspan="2" class="subHeader">
                    : {{ $rka->mapKegiatan->blud->program->bidang->kode_urusan }}.{{ $rka->mapKegiatan->blud->program->bidang->kode_fungsi }}.{{ $rka->mapKegiatan->blud->program->kode_bidang }}.{{ $rka->mapKegiatan->blud->kode_program }} 
                </td>

                <td colspan="4" class="subHeader">
                    {{ $rka->mapKegiatan->blud->program->nama_program }}
                </td>
            </tr>

            <tr>
                <td class="subHeader">
                    Kegiatan
                </td>

                <td colspan="2" class="subHeader">
                    : {{ $rka->mapKegiatan->blud->program->bidang->kode_urusan }}.{{ $rka->mapKegiatan->blud->program->bidang->kode_fungsi }}.{{ $rka->mapKegiatan->blud->program->kode_bidang }}.{{ $rka->mapKegiatan->blud->kode_program }}.{{ $rka->mapKegiatan->kode_kegiatan_blud }} 
                </td>

                <td colspan="4" class="subHeader">
                    Pelayanan Pendukung Pelayanan BLUD Puskesmas Janti
                </td>
            </tr>

            <tr>
                <td colspan="2" class="font-weight-bold text-center" style="font-size: 13px;">
                    Jenis Indikator
                </td>

                <td colspan="3" class="font-weight-bold text-center" style="font-size: 13px;">
                    Tolak Ukur Kinerja
                </td>

                <td colspan="2" class="font-weight-bold text-center" style="font-size: 13px;">
                    Target Kinerja
                </td>
            </tr>

            @foreach ($rka->indikatorKerja as $item)
                <tr>
                    <td colspan="2" class="subHeader borderLeft">
                        {{ $item->jenis_indikator == 'Outcame' ? 'Outcome' : $item->jenis_indikator }}
                    </td>

                    <td colspan="3" class="subHeader borderLeft">
                        {{ $item->tolak_ukur_kerja }}
                    </td>

                    <td colspan="2" class="subHeader text-center borderLeft">
                        {{ is_numeric($item->target_kerja) ? format_idr($item->target_kerja) : $item->target_kerja }}
                    </td>
                </tr>
            @endforeach
        @endif


        <tr>
            <td colspan="7" style="padding: 10px;"></td>
        </tr>

        <tr class="text-center font-weight-bold">
            <td rowspan="2" class="colHeader" width="20%">
                Kode <br/> Rekening
            </td>

            <td rowspan="2" class="colHeader" width="30%">
                Uraian
            </td>

            <td rowspan="2" class="colHeader" width="10%">
                Kode <br/> Standar
            </td>

            <td colspan="4" class="colHeader" width="40%">
                Rincian Perhitungan
            </td>
        </tr>

        <tr class="text-center font-weight-bold">
            <td class="colHeader">Volume</td>
            <td class="colHeader">Satuan</td>
            <td class="colHeader">Harga <br/> Satuan</td>
            <td class="colHeader" width="20%">Jumlah</td>
        </tr>

        <tr class="text-center font-weight-bold">
            <td class="colHeader">1</td>
            <td class="colHeader">3</td>
            <td class="colHeader">2</td>
            <td class="colHeader">4</td>
            <td class="colHeader">5</td>
            <td class="colHeader">6</td>
            <td class="colHeader">7 = (4x6)</td>
        </tr>

        <!-- Content (Master) -->

        @foreach ($akun as $item)
            <tr>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-left content borderLeft">{{ $item->kode_akun }}</td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-left content borderLeft">{{ $item->nama_akun }}</td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-right content borderLeft"></td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-right content borderLeft"></td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-right content borderLeft"></td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-right content borderLeft"></td>
                <td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} text-right content borderLeft">{{ format_idr($reportRba[$item->kode_akun]) }}</td>
            </tr>
            @if (!$item->is_parent)
                @foreach ($rka->rincianAnggaran as $rincian)
                    @if ($rincian->akun->id == $item->id)
                        <tr>
                            <td class="text-left content borderLeft"></td>
                            <td class="text-left content borderLeft">{{ $rincian->ssh ? $rincian->ssh->nama_barang : $rincian->uraian }}</td>
                            <td class="text-right content borderLeft"></td>
                            <td class="text-right content borderLeft">{{ $rincian->volume }}</td>
                            <td class="text-right content borderLeft">{{ $rincian->satuan }}</td>
                            <td class="text-right content borderLeft">{{ format_idr($rincian->tarif) }}</td>
                            <td class="text-right content borderLeft">{{ format_idr($rincian->volume * $rincian->tarif) }}</td>
                        </tr>
                    @endif
                @endforeach
            @endif
        @endforeach
        
        <!-- Total -->
        <tr>
            <td class="font-weight-bold text-right content" colspan="3">
                Jumlah
            </td>
            <td class="font-weight-bold text-right content" colspan="4">
                {{ format_idr($rka->total_all) }}
            </td>
        </tr>

        <!-- Signature (TTD) -->
        <tr>
            <td colspan="4" style="border: 0;"></td>
            <td colspan="3" style="padding: 30px !important; font-size: 14px; border:0 !important;" class="text-center">
                KOTA MALANG, @for($i = 1; $i <= 18; $i++) &nbsp; @endfor {{ date('Y') }} <br/>
                KUASA PENGGUNA ANGGARAN, <br/><br/><br/>
                <u>ENDANG LISTYOWATI,S.S.Kep,Ns,M.MKes</u> <br/>
                NIP: 196709211988122001 
            </td>
        </tr>

        <tr>
            <td class="font-weight-bold text-center content" colspan="7">Tim Anggaran Pejabat Daerah</td>
        </tr>

        <tr>
            <td class="font-weight-bold text-center content" width="5%">No</td>
            <td class="font-weight-bold text-center content" width="35%" colspan="3">Nama</td>
            <td class="font-weight-bold text-center content" width="25%">NIP</td>
            <td class="font-weight-bold text-center content" width="25%">Jabatan</td>
            <td class="font-weight-bold text-center content" width="10%">Tandatangan</td>
        </tr>
    </table>

    <footer>
        <i>Dinas Kesehatan Kota Malang</i>
    </footer>

    <!-- <div class="page-break"></div> -->
</body>
</html>