@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>RKA 2.2.1 - {{ auth()->user()->statusAnggaran->status_anggaran }}</h1>
      </div>

      <div class="section-body">
          <div class="row">

            @if (auth()->user()->statusAnggaran->is_copyable == true)
              <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.rka221.create') }}">
                  <i class="fas fa-plus"></i> Tambah
              </a>
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
                        <h4>Data RKA OPD 2.2.1</h4>
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
                          <a href="{{ route('admin.rka221.index') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
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
                                  <th>Kegiatan</th>
                                  <th>Dibuat Pada</th>
                                  <th>Opsi</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($rka as $item)
                                  <tr>
                                    <td>{{ $item->kode_unit_kerja }}</td>
                                    <td>{{ $item->unitKerja->nama_unit }}</td>
                                    <td>{{ format_idr($item->total_nominal_murni) }}</td>
                                     @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                      <td>{{ format_idr($item->total_nominal_pak) }}</td>
                                      <td>{{ format_idr(abs($item->total_nominal_pak - $item->total_nominal_murni)) }}</td>
                                    @endif
                                    <td>{{ $item->mapKegiatan->blud->nama_kegiatan }}</td>
                                    <td>{{ $item->created_at->diffForHumans() }}</td>
                                    <td>
                                      @if (auth()->user()->statusAnggaran->status_perubahan == 'MURNI')
                                        <a href="{{ route('admin.rka221.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                          <span class="fa fa-plus"></span> Pilih
                                        </a>
                                      @else
                                        <a href="{{ route('admin.rka221.edit_pak', $item->id) }}" class="btn btn-sm btn-primary">
                                          <span class="fa fa-plus"></span> Pilih
                                        </a>
                                      @endif
                                      
                                      @if (! $item->pak->count())
                                        @if (auth()->user()->hasPermission('hapus RKA'))
                                          <button class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $item->id }}">
                                            <i class="fas fa-trash"></i> Hapus
                                          </button>
                                        @endif
                                      @else
                                        @if (auth()->user()->hasPermission('hapus RKA'))
                                          <button class="btn btn-sm btn-danger" disabled title="Tidak dapat menghapus MURNI karena tersalin PAK">
                                            <i class="fas fa-trash"></i> Hapus
                                          </button>
                                        @endif
                                      @endif
                                      <a class="btn btn-sm btn-warning" href="{{ route('admin.report.rka', $item->id) }}">
                                        <i class="fas fa-file-pdf"></i> Cetak
                                      </a>
                                    </td>
                                  </tr>
                                @endforeach
                                <thead>
                                  <th>Total</th>
                                  <th></th>
                                  <th>{{ format_idr($totalAllRka['murni']) }}</th>
                                    @if (auth()->user()->statusAnggaran->status_perubahan == 'PERUBAHAN')
                                      <th>{{ format_idr($totalAllRka['pak']) }}</th>
                                    @endif
                                  <th colspan="3"></th>
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
<form id="form-delete" action="{{ route('admin.rka221.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection
@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
<script>
  @if ($message = Session::get('success'))
      iziToast.success({
      title: 'Sukses!',
      message: '{{ $message }}',
      position: 'topRight'
    });
  @endif

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