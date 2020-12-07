@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>RKA 1 - {{ auth()->user()->status }}</h1>
      </div>

      <div class="section-body">
          <div class="row">

            @if (auth()->user()->status == 'MURNI')
              @if (auth()->user()->hasRole('Admin'))
                <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.rka1.create') }}">
                  <i class="fas fa-plus"></i> Tambah
                </a>
              @else
                @if (auth()->user()->hasRole('Puskesmas') && $rka->isEmpty())
                  <a class="btn btn-primary mb-4 ml-3" href="{{ route('admin.rka1.create') }}">
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
                        <h4>Data RKA OPD 1</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Unit</th>
                              <th>Nama Unit</th>
                              <th>Nominal Murni</th>
                              @if (auth()->user()->status == 'PAK')
                                <th>Nominal PAK</th>
                                <th>Selisih</th>
                              @endif
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
                                @if (auth()->user()->status == 'PAK')
                                  <td>{{ format_idr($item->total_nominal_pak) }}</td>
                                  <td>{{ format_idr(abs($item->total_nominal_pak - $item->total_nominal_murni)) }}</td>
                                @endif
                                 <td>{{ $item->created_at->diffForHumans() }}</td>
                                <td>
                                  @if (auth()->user()->status == 'MURNI')
                                    <a href="{{ route('admin.rka1.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                      <span class="fa fa-plus"></span> Pilih
                                    </a>
                                  @else
                                    <a href="{{ route('admin.rka1.edit_pak', $item->id) }}" class="btn btn-sm btn-primary">
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
                          </tbody>
                        </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>
</div>
<form id="form-delete" action="{{ route('admin.rka1.destroy') }}" class="d-none" method="POST">
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