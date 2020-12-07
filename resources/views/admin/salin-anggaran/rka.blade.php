@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">

@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Salin Anggaran</h1>
      </div>

      <div class="section-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h4>Salin Anggaran untuk RKA</h4>
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
                          <a href="{{ route('admin.salinanggaran.rka') }}" class="btn btn-outline-danger mb-2"><i class="fa fa-reset"></i> Reset</a>
                        </form>
                        <form action="{{ route('admin.salinanggaran.rka') }}" method="POST" id="form-copy">
                        @csrf
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th></th>
                              <th>Unit Kerja</th>
                              <th>Tipe </th>
                              <th>Status Anggaran</th>
                              <th>Kode Kegiatan</th>
                              <th>Nama Kegiatan</th>
                              <th>Salinan Anggaran</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($rka as $item)
                              <tr>
                                <td><input type="checkbox" name="rka_selected[]" value="{{ $item->id }}"></td>
                                <input type="hidden" name="rka[]" value="{{ $item->id }}">
                                <td>{{ $item->kode_unit_kerja }} - {{ $item->unitKerja->nama_unit }}</td>
                                <td>{{ $item->kode_rka }}</td>
                                <td>{{ $item->statusAnggaran->status_anggaran }}</td>
                                <td>
                                  @if ($item->mapKegiatan) 
                                    {{ $item->mapKegiatan->blud->kode_bidang.'.'.$item->mapKegiatan->blud->kode_program.'.'.$item->mapKegiatan->blud->kode }} 
                                  @endif
                                </td>
                                <td>@if ($item->mapKegiatan) {{ $item->mapKegiatan->blud->nama_kegiatan }} @endif</td>
                                <td>
                                  <select name="status_anggaran[]" class="form-control">
                                    <option value="">Pilih Status Anggaran</option>
                                    @foreach ($statusAnggaran as $status)
                                      @if ($status->id != $item->status_anggaran_id)
                                        <option value="{{ $status->id }}">{{ $status->status_anggaran }}</option>
                                      @endif
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">
                              <button type="submit" class="btn btn-primary mt-3"> 
                                <span class="fas fa-copy"></span>
                                Salin Anggaran
                              </button>
                            </div>
                          </div>
                        </div>
                        </form>
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
<script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
<script>
  $(document).ready(function () {
    @if ($message = Session::get('success'))
      iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('table').DataTable({
      paging: false,
      info: false,
      scrollX: true,
      scrollCollapse: true,
      columnDefs: [
            { width: 5, targets: 0 },
            { width: 200, targets: 1 },
            { width: 50, targets: 2 },
            { width: 80, targets: 3 },
            { width: 50, targets: 4 },
            { width: 150, targets: 5 },
        ],
        fixedColumns: true,
    });

    $("#form-copy").on('submit', function(e) {
      e.preventDefault();
      var rbaLength = $("input[type='checkbox'][name='rka_selected[]']:checked").length;
      if(!rbaLength) {
        return iziToast.error({
          title: 'Gagal!',
          message: 'Mohon untuk pilih satu atau lebih dari RBA yang telah tersedia.',
          position: 'topRight'
        });
      }
      this.submit();
    });
    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      orientation: 'bottom'
    });
  });
</script>  
@endsection