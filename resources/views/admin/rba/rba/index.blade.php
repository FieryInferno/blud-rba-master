@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>RBA BLUD - {{ auth()->user()->statusAnggaran->status_anggaran }}</h1>
      </div>

      <div class="section-body">
          <div class="row">

              @if ($errors->any())
                <div class="alert alert-danger alert-has-icon w-100 mx-3">
                  <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Kesalahan Validasi</div>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </div>
                </div>
              @endif
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h4>Data RBA BLUD</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Unit</th>
                              <th>Nama Unit</th>
                              <th>Jenis RBA</th>
                              <th>Nominal Murni</th>
                                @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                  <th>Nominal PAK</th>
                                  <th>Selisih</th>
                                @endif
                              <th>Kegiatan</th>
                              <th>Dibuat Pada</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($rba as $item)
                              <tr>
                                <td>{{ $item->kode_unit_kerja }}</td>
                                <td>{{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ $item->kode_rba }}</td>
                                <td>{{ format_idr($item->total_nominal_murni) }}</td>
                                @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                  <td>{{ format_idr($item->total_nominal_pak) }}</td>
                                  <td>{{ format_idr(abs($item->total_nominal_pak - $item->total_nominal_murni)) }}</td>
                                @endif
                                @if ($item->mapKegiatan)
                                  <td>{{ $item->mapKegiatan->blud->nama_kegiatan }}</td>
                                @else 
                                  <td></td>
                                @endif
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>
                                  @if (auth()->user()->statusAnggaran->status_perubahan == 'MURNI')
                                    <a href="{{ route('admin.'. $item->rba_tipe .'.edit', $item->id) }}" class="btn btn-primary">
                                      <span class="fa fa-plus"></span> Pilih
                                    </a>
                                    @else
                                    <a href="{{ route('admin.'. $item->rba_tipe .'.edit_pak', $item->id) }}" class="btn btn-primary">
                                      <span class="fa fa-plus"></span> Pilih
                                    </a>
                                  @endif
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>

@endsection
@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>

<script>
   $('table').DataTable({
      paging: false,
      info: false
  });
</script>   
@endsection