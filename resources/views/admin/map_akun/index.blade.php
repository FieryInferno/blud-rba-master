@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pemetaan Akun</h1>
      </div>

      <div class="section-body">
          <div class="row">
              @if (Auth::user()->hasRole('admin'))
              <button class="btn btn-primary mb-4 ml-3" data-toggle="modal" data-target="#createModal">
                  <i class="fas fa-plus"></i> Tambah
              </button>
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
                        <h4>Data Pemetaan Akun</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="w-25">Kode Akun</th>
                              <th>Nama Akun</th>
                              <th>Pemetaan Akun</th>
                              <th>Nama Pemetaan Akun</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($mapAkun as $item)
                              <tr>
                                <td>{{ $item->kode_akun }}</td>
                                <td>{{ $item->akun->nama_akun }}</td>
                                <td>{{ $item->kode_map_akun }}</td>
                                <td>{{ $item->map->nama_akun ?? '' }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-kode-akun="{{ $item->kode_akun }}"
                                    data-nama-akun="{{ $item->akun->nama_akun }}"
                                    data-kode-map="{{ $item->kode_map_akun ?? '' }}"
                                    data-nama-map="{{ $item->map->nama_akun ?? '' }}">
                                    <i class="fas fa-edit"></i> Sunting
                                  </button>
                                  <button class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                  </button>
                                </td>
                                @endif
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

{{-- create modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="createModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Pemetaan Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.map_akun.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="kode_akun" class="form-control selectpicker" data-live-search="true" title="Pilih Kode">
                @foreach ($akun as $item)
                  <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Pemetaan Akun</label>
              <select name="kode_pemetaan" class="form-control selectpicker" title="Pilih Kode">
                @foreach ($akun as $item)
                  <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- edit modal --}}
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Pemetaan Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.map_akun.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
          <div class="form-group">
            <label>Kode Akun</label>
            <select id="edit-kode-akun" name="kode_akun" class="form-control selectpicker" data-live-search="true" title="Pilih Kode">
              @foreach ($akun as $item)
                <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kode Pemetaan Akun</label>
            <select id="edit-kode-map" name="kode_pemetaan" class="form-control selectpicker" title="Pilih Kode">
              @foreach ($akun as $item)
                <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- form delete --}}
<form id="form-delete" action="{{ route('admin.map_akun.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
<script src="{{ asset('dashboard/js/bootstrap-select.min.js') }}"></script>
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
      info: false
    });

    $('.selectpicker').selectpicker();

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const kodeAkun = $(this).attr('data-kode-akun');
      const namaAkun = $(this).attr('data-nama-akun');
      const kodeMap = $(this).attr('data-kode-map');
      const namaMap = $(this).attr('data-nama-map');

      // auto select options
      $('#edit-kode-akun.selectpicker').val(kodeAkun);
      $('#edit-kode-map.selectpicker').val(kodeMap);
      $('.selectpicker').selectpicker('refresh');

      $('#edit-id').val(id);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-kode-akun option[selected]').attr('selected', false);
      $('#edit-kode-map option[selected]').attr('selected', false);

      $('#edit-id').val('');
    });
  });
</script>
@endsection