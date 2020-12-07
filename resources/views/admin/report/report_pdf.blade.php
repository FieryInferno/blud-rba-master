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
		th { padding: 8px; font-size: 14px; }
		td { padding: 5px; margin-left: 7px; font-size: 12px; }
		.text-left{ text-align: left !important; }
		.text-center{ text-align: center !important; }
		.text-right{ text-align: right !important; }
		.font-weight-bold { font-weight: 700 !important; }
		.page-break { page-break-before: always; }
		.borderLeft { border: 0; border-left: 1px solid #000; }
    </style>
</head>
<body>
	{{-- Page 1 - Detail Unit Kerja --}}
	<div class="col-print-3">
		<img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
	</div>

	<div class="col-print-6">
		<p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">RENCANA BISNIS DAN ANGGARAN</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">TAHUN {{ date('Y') }}</p>
	</div>

	<div class="clearfix"></div>

	<table style="margin-bottom: 20px;">
		<tbody>
			<!-- 1. Nama SKPDB -->
			<tr>
				<td>1</td>
				<td class="font-weight-bold">Nama SKPD / UPTD BLUD</td>
				<td>{{ $unitKerja->nama_unit }}</td>
			</tr>

			<!-- 2. Pemimpin BLUD -->

			<tr>
				<td>2</td>
				<td class="font-weight-bold">Pemimpin BLUD</td>
				<td></td>
			</tr>

			<!-- 3. Pejabat Keuangan -->

			<tr>
				<td>3</td>
				<td class="font-weight-bold">Pejabat Keuangan</td>
				<td></td>
			</tr>

			<!-- 4. Pejabat Teknis -->

			<tr>
				<td>4</td>
				<td class="font-weight-bold">Pejabat Teknis</td>
				<td>1.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>2.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>3.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>4.</td>
			</tr>

			<!-- 5. Dewan Pengawas -->

			<tr>
				<td>5</td>
				<td class="font-weight-bold">Dewan Pengawas</td>
				<td>1.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>2.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>3.</td>
			</tr>

			<tr>
				<td></td>
				<td></td>
				<td>4.</td>
			</tr>
			
			<tr>
				<td></td>
				<td></td>
				<td>5.</td>
			</tr>
			
			<!-- 6. Usulan RBA -->
			
			<tr>
				<td>6</td>
				<td class="font-weight-bold">Usulan RBA</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Jenis RBA</td>
				<td>Indikatif/Definitif/Perubahan Tahun 2020</td>
			</tr>

			<tr>
				<td></td>
				<td class="font-weight-bold">Target Pendapatan</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Lain-lain PAD yang Sah</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td class="font-weight-bold">Pagu Belanja</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Dana Fungsional</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td>Dana APBD</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td class="font-weight-bold">Penerimaan Pembiayaan</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Pengunaan SILPA</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td>Hutang Jangka Panjang</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td class="font-weight-bold">Pengeluaran Pembiayaan</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Pelunasan Hutang Jangka Panjang</td>
				<td>Rp0,00</td>
			</tr>

			<tr>
				<td></td>
				<td class="font-weight-bold">Ambang Fleksibilitas</td>
				<td></td>
			</tr>

			<tr>
				<td></td>
				<td>Persentase</td>
				<td>10%</td>
			</tr>

			<tr>
				<td></td>
				<td>Besaran Fleksibilitas</td>
				<td>Rp0,00</td>
			</tr>
		</tbody>
	</table>

	<div class="text-center" style="font-size: 12px;">
		<div class="col-print-6">
			<br>
			Mengetahui
			<br/><br/><br/><br/><br/><br/>
			Ketua Dewan Pengawas
		</div>

		<div class="col-print-6">
			Kota Malang, {{ full_date($request->tanggal) }} <br/>
			Diusulkan Oleh <br />
			{{ $unitKerja->nama_unit }}
			<br/><br/><br/><br/><br/><br/>
			
			{{ $kepala->nama_pejabat }}
			<br/>
			@php 
				for($i = 0; $i < strlen($kepala->nama_pejabat); $i++){
					echo "--";
				}
			@endphp
			<br/> 
			Pemimpin BLUD
		</div>
	</div>
	{{-- End of page 1 --}}

	<div class="page-break"></div>

	{{-- Page 2 - Report RBA 1 --}}
	<div class="col-print-3">
	<img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
	</div>

	<div class="col-print-6">
		<p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">RENCANA BISNIS DAN ANGGARAN</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">ANGGARAN PENDAPATAN TAHUN {{ date('Y') }}</p>
	</div>

	<div class="clearfix"></div>

	<table style="margin-bottom: 20px;">
		<tbody>
			<tr>
				<th class="text-center">NO</th>
				<th class="text-center">URAIAN</th>
				<th class="text-center">JUMLAH</th>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">PENDAPATAN</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Jasa Layanan</td>
				<td class="borderLeft font-weight-bold text-right">{{ $rba1 ? format_report($rba1->total_all) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">a. Pendapatan Layanan BLUD Dari Pasien Umum</td>
				<td class="borderLeft text-right">{{ isset($reportRba1['layanan_umum']) ? format_report($reportRba1['layanan_umum']) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">b. BPJS</td>
				<td class="borderLeft text-right">{{ isset($reportRba1['bpjs']) ? format_report($reportRba1['bpjs']) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">c. Jampersal</td>
				<td class="borderLeft text-right">{{ isset($reportRba1['jampersal']) ? format_report($reportRba1['jampersal']) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">d. SPM</td>
				<td class="borderLeft text-right">{{ isset($reportRba1['spm']) ? format_report($reportRba1['spm']) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">e. Pendapatan BLUD Lain-lain</td>
				<td class="borderLeft text-right">{{ isset($reportRba1['lain_lain']) ? format_report($reportRba1['lain_lain']) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Hibah</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">a. Hibah BLUD</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Hasil Kerjasama</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">a.</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Anggaran Pendapatan Belanja Daerah</td>
				<td class="borderLeft font-weight-bold text-right">{{ isset($totalRka2) ? format_report($totalRka2) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">a. Pendapatan BLUD dari APBD</td>
				<td class="borderLeft text-right">{{ isset($totalRka2) ? format_report($totalRka2) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">b.</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Lain-lain Pendapatan Badan Layanan Umum Daerah yang sah</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">a.</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">b.</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td></td>
				<td class="text-center font-weight-bold">Jumlah Total</td>
				<td class="text-right font-weight-bold">{{ isset($rba1) ? format_report($rba1->total_all) : format_report(0) }}</td>
			</tr>
		</tbody>
	</table>

	<div class="text-center" style="font-size: 12px;">
		<div class="col-print-6">
		</div>

		<div class="col-print-6">
			Kota Malang, {{ full_date($request->tanggal) }} <br/>
			Diusulkan Oleh <br/>
			{{ $unitKerja->nama_unit }}
			<br/><br/><br/><br/><br/><br/>

			{{ $kepala->nama_pejabat }}
			<br/>
			@php 
				for($i = 0; $i < strlen($kepala->nama_pejabat); $i++){
					echo "--";
				}
			@endphp 
			<br/>
			Pemimpin BLUD
		</div>
	</div>
	{{-- End of page 2 --}}

	<div class="page-break"></div>

	{{-- Start of page 3 - Report Rba 2 --}}

	<div class="col-print-3">
		<img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
	</div>

	<div class="col-print-6">
		<p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
		<p class="text-center font-weight-bold" style="font-size: 19px;">RENCANA BISNIS DAN ANGGARAN</p>
		<p class="text-center font-weight-bold" style="font-size: 19px;">ANGGARAN BELANJA TAHUN {{ date('Y') }}</p>
	</div>

	<div class="clearfix"></div>

	<table style="margin-bottom: 20px;">
		<tbody>
			<tr>
				<th class="text-center" rowspan="2">URAIAN</th>
				<th class="text-center" colspan="5">Sumber Dana</th>
				<th class="text-center" rowspan="2">JUMLAH</th>
			</tr>

			<tr>
				<th class="text-center" colspan="4">Pendapatan <br/> Badan Layanan Umum Daerah</th>
				<th class="text-center">APBD</th>
			</tr>

			<tr>
				<td class="text-center">1</td>
				<td class="text-center" colspan="4">2</td>
				<td class="text-center">3</td>
				<td class="text-center">4</td>
			</tr>

			@foreach ($akun as $item)
				@foreach ($reportRbaAndRka as $key => $value)
					@if ($item->kode_akun == $key)
						<tr>
							@php $valueRba = isset($reportRba2[$item->kode_akun]) ? $reportRba2[$item->kode_akun] : 0 @endphp
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft">{{ $item->nama_akun }}</td>
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">{{ format_report($valueRba) }}</td>
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">0,00</td>
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">0,00</td>
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">0,00</td>
							@php $valueRka = isset($reportRka2[$item->kode_akun]) ? $reportRka2[$item->kode_akun] : 0 @endphp
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">{{ format_report($valueRka) }}</td>
							<td class="{{ $item->is_parent ? 'font-weight-bold' : '' }} borderLeft text-right">{{ format_report($valueRba + $valueRka) }}</td>
						</tr>
						@php unset($reportRbaAndRka[$key]) @endphp
					@endif
				@endforeach
			@endforeach

			@php 
				$allTotalRba2 = $totalRba2 ? $totalRba2 : 0; 
				$allTotalRka2 = $totalRka2 ? $totalRka2 : 0; 
			@endphp
			<tr>
				<td class="font-weight-bold text-center">JUMLAH</td>
				<td class="font-weight-bold text-right">{{ format_report($allTotalRba2) }}</td>
				<td class="font-weight-bold text-right">0,00</td>
				<td class="font-weight-bold text-right">0,00</td>
				<td class="font-weight-bold text-right">0,00</td>
				<td class="font-weight-bold text-right">{{ format_report($allTotalRka2) }}</td>
				<td class="font-weight-bold text-right">{{ format_report($allTotalRba2 + $allTotalRka2) }}</td>
			</tr>
		</tbody>
	</table>

	<div class="text-center" style="font-size: 12px;">
		<div class="col-print-6">
		</div>

		<div class="col-print-6">
			Kota Malang, {{ full_date($request->tanggal) }} <br/>
			Pemimpin Badan Layanan Umum Daerah <br/>
			{{ $unitKerja->nama_unit }}
			<br/><br/><br/><br/><br/><br/>
			
			{{ $kepala->nama_pejabat }}
			<br/>
			@php 
				for($i = 0; $i < strlen($kepala->nama_pejabat); $i++){
					echo "--";
				}
			@endphp 
			<br/>
			Pemimpin BLUD
		</div>
	</div>

	{{-- End of page 3 - Report Rba 2 --}}

	<div class="page-break"></div>

	{{-- Start of page 4 - Report Rba 3.1 --}}
	<div class="col-print-3">
		<img style="width:70px; margin-top: 15px;" src="{{ public_path('img/logo.png') }}" alt="">
	</div>

	<div class="col-print-6">
		<p class="text-center font-weight-bold">DINAS KESEHATAN KOTA MALANG</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">RENCANA BISNIS DAN ANGGARAN</p>
		<p class="text-center font-weight-bold" style="font-size: 18px;">ANGGARAN PEMBIAYAAN TAHUN {{ date('Y') }}</p>
	</div>

	<div class="clearfix"></div>

	<table style="margin-bottom: 20px;">
		<tbody>
			<tr>
				<th class="text-center">NO</th>
				<th class="text-center">URAIAN</th>
				<th class="text-center">JUMLAH</th>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">PEMBIAYAAN</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">PENERIMAAN PEMBIAYAAN</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">Penggunaan Sisa Lebih Perhitungan (SILPA)</td>
				<td class="borderLeft">{{ $rba31 ? format_report($rba31->total_all) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">.....</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Divestasi</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">.....</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">Penerimaan Utang/Pinjaman</td>
				<td class="borderLeft"></td>
			</tr>
			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">.....</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">dst</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td></td>
				<td class="text-center font-weight-bold">Jumlah</td>
				<td>{{ $rba31 ? format_report($rba31->total_all) : format_report(0) }}</td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">PENGELUARAAN PEMBIAYAAN</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">Investasi</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">.....</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft font-weight-bold">Pembayaran Pokok Utang/Pinjaman</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">.....</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td class="borderLeft"></td>
				<td class="borderLeft">dst</td>
				<td class="borderLeft"></td>
			</tr>

			<tr>
				<td></td>
				<td class="text-center font-weight-bold">Jumlah</td>
				<td></td>
			</tr>
		</tbody>
	</table>

	<div class="text-center" style="font-size: 12px;">
		<div class="col-print-6">
		</div>

		<div class="col-print-6">
			Kota Malang, {{ full_date($request->tanggal) }} <br/>
			Pemimpin Badan Layanan Umum Daerah <br/>
			{{ $unitKerja->nama_unit }}
			<br/><br/><br/><br/><br/><br/>
			
			{{ $kepala->nama_pejabat }}
			<br/>
			@php 
				for($i = 0; $i < strlen($kepala->nama_pejabat); $i++){
					echo "--";
				}
			@endphp 
			<br/>
			Pemimpin BLUD
		</div>
	</div>
	{{-- End of page 4 - Report Rba 3.1 --}}
</body>
</html>