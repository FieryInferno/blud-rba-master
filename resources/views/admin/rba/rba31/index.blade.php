@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>RBA Penerimaan Pembiayaan - {{ auth()->user()->statusAnggaran->status_anggaran }}</h1>
      </div>

      <div class="section-body">
          <div class="row">

            @if (auth()->user()->statusAnggaran->status_perubahan == 'MURNI')
              @if (auth()->user()->hasRole('Admin'))
                <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.rba31.create') }}">
                  <i class="fas fa-plus"></i> Tambah
                </a>
              @else
                @if (auth()->user()->hasRole('Puskesmas') && $rba->isEmpty())
                  <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.rba31.create') }}">
                    <i class="fas fa-plus"></i> Tambah
                  </a>
                @endif
              @endif
            @endif

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
                        <h4>Data RBA Penerimaan Pembiayaan</h4>
                      </div>
                      <div class="card-body">

                        <form class="form-inline">
                          @if (auth()->user()->hasRole('Admin'))
                            <div class="form-group mb-2 mx-2">
                              <select name="unit_kerja" class="form-control">
                                <option value="">-- Semua Unit Kerja --</option>
                                @foreach ($unitKerja as $item)
                                  <option value="{{ $item->kode }}"
                                    {{ ($item->kode == request()->query('unit_kerja')) ? 'selected' : '' }}
                                    >{{ $item->nama_unit }}</option>
                                @endforeach
                              </select>
                            </div>
                          @endif

                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control date" name="start_date" value="{{ request()->query('start_date') }}" placeholder="Tgl Mulai" autocomplete="off">
                          </div>
                          <div class="form-group mb-2 mx-2">
                            <input type="text" class="form-control date" name="end_date" value="{{ request()->query('end_date') }}" placeholder="Tgl Sampai" autocomplete="off">
                          </div>
                          <button type="submit" class="btn btn-outline-primary mb-2 mx-2"><i class="fa fa-filter"></i> Filter</button>
                          <a href="{{ route('admin.rba31.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Unit</th>
                              <th>Nama Unit</th>
                              <th>Nominal Murni</th>
                              @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                <th>Nominal PAK</th>
                                <th>Selisih</th>
                              @endif
                              <th>Dibuat Pada</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($rba as $item)
                              <tr>
                                <td>{{ $item->kode_unit_kerja }}</td>
                                <td>{{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ format_idr($item->total_nominal_murni) }}</td>
                                @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                  <td>{{ format_idr($item->total_nominal_pak) }}</td>
                                  <td>{{ format_idr(abs($item->total_nominal_pak - $item->total_nominal_murni)) }}</td>
                                @endif
                                <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>
                                  @if (auth()->user()->statusAnggaran->status_perubahan == 'MURNI')
                                    <a href="{{ route('admin.rba31.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                      <span class="fa fa-plus"></span> Pilih
                                    </a>
                                  @else
                                    <a href="{{ route('admin.rba31.edit_pak', $item->id) }}" class="btn btn-sm btn-primary">
                                      <span class="fa fa-plus"></span> Pilih
                                    </a>
                                  @endif
                                  
                                  @if (! $item->pak->count())
                                    @if (auth()->user()->hasPermission('hapus RBA'))
                                      <button class="btn btn-sm btn-danger btn-delete"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                      </button>
                                    @endif
                                  @else
                                    @if (auth()->user()->hasPermission('hapus RBA'))
                                      <button class="btn btn-sm btn-danger" disabled title="Tidak dapat menghapus MURNI karena tersalin PAK">
                                        <i class="fas fa-trash"></i> Hapus
                                      </button>
                                    @endif
                                  @endif
                                  <a class="btn btn-sm btn-warning" href="{{ route('admin.report.rba', $item->id) }}">
                                    <i class="fas fa-file-pdf"></i> Cetak
                                  </a>
                                </td>
                              </tr>
                            @endforeach
                            <thead>
                              <th>Total</th>
                              <th></th>
                              <th>{{ format_idr($totalAllRba['murni']) }}</th>
                                @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                  <th>{{ format_idr($totalAllRba['pak']) }}</th>
                                @endif
                              <th colspan="@if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN') 4 @else 2 @endif"></th>
                            </thead>
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<form id="form-delete" action="{{ route('admin.rba31.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection
@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
<script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      orientation: 'bottom'
    });

   $('table').DataTable({
      paging: false,
      info: false
  });
  $('.btn-delete').click(function () {
    if (confirm('Anda yakin akan menghapus data ini?')) {
      $('#delete-id').val($(this).attr('data-id'));
      $('#form-delete').submit();
    }
  });
</script>   
@endsection