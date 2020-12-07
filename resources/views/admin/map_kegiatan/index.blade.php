@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pemetaan Kegiatan</h1>
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
                        <h4>Data Pemetaan Kegiatan</h4>
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="w-25">Kode Unit Kerja</th>
                              <th>Nama Unit Kerja</th>
                              <th>Kode Kegiatan BLUD</th>
                              <th>Nama Kegiatan BLUD</th>
                              <th>Kode Kegiatan APBD</th>
                              <th>Nama Kegiatan APBD</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($mapKegiatan as $item)
                              <tr>
                                <td>{{ $item->kode_unit_kerja }}</td>
                                <td>{{ $item->unit->nama_unit }}</td>
                                <td>{{ $item->blud->kode }}</td>
                                <td>{{ $item->blud->nama_kegiatan }}</td>
                                <td>{{ $item->apbd->kode }}</td>
                                <td>{{ $item->apbd->nama_kegiatan }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-kode-unit="{{ $item->kode_unit_kerja }}"
                                    data-nama-unit="{{ $item->unit->nama_unit }}"
                                    data-kode-blud="{{ $item->kegiatan_id_blud }}"
                                    data-nama-blud="{{ $item->blud->nama_kegiatan }}"
                                    data-kode-apbd="{{ $item->kegiatan_id_apbd }}"
                                    data-nama-apbd="{{ $item->apbd->nama_kegiatan }}">
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
        <h5 class="modal-title">Buat Pemetaan Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.map_kegiatan.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode Unit Kerja</label>
              <select name="kode_unit_kerja" class="form-control selectpicker" data-live-search="true" title="Pilih Kode">
                @foreach ($unitKerja as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_unit }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Kegiatan BLUD</label>
              <select name="kegiatan_id_blud" class="form-control selectpicker" title="Pilih Kode">
                @foreach ($kegiatan as $item)
                  <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama_kegiatan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Kegiatan APBD</label>
              <select name="kegiatan_id_apbd" class="form-control selectpicker" title="Pilih Kode">
                @foreach ($kegiatan as $item)
                  <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama_kegiatan }}</option>
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
        <h5 class="modal-title">Sunting Pemetaan Kegiatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.map_kegiatan.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
          <div class="form-group">
            <label>Kode Unit Kerja</label>
            <select id="edit-kode-unit" name="kode_unit_kerja" class="form-control selectpicker" data-live-search="true" title="Pilih Kode">
              @foreach ($unitKerja as $item)
                <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_unit }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kode Kegiatan BLUD</label>
            <select id="edit-kode-blud" name="kegiatan_id_blud" class="form-control selectpicker" title="Pilih Kode">
              @foreach ($kegiatan as $item)
                <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama_kegiatan }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Kode Kegiatan APBD</label>
            <select id="edit-kode-apbd" name="kegiatan_id_apbd" class="form-control selectpicker" title="Pilih Kode">
              @foreach ($kegiatan as $item)
                <option value="{{ $item->id }}">{{ $item->kode }} - {{ $item->nama_kegiatan }}</option>
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
<form id="form-delete" action="{{ route('admin.map_kegiatan.destroy') }}" class="d-none" method="POST">
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

    @if ($message = Session::get('error'))
        iziToast.error({
        title: 'Gagal!',
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
      const kodeUnit = $(this).attr('data-kode-unit');
      const kodeBLUD = $(this).attr('data-kode-blud');
      const kodeAPBD = $(this).attr('data-kode-apbd');

      // auto select options
      $('#edit-kode-unit.selectpicker').val(kodeUnit);
      $('#edit-kode-blud.selectpicker').val(kodeBLUD);
      $('#edit-kode-apbd.selectpicker').val(kodeAPBD);
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
      $('#edit-kode-unit option[selected]').attr('selected', false);
      $('#edit-kode-blud option[selected]').attr('selected', false);
      $('#edit-kode-apbd option[selected]').attr('selected', false);

      $('#edit-id').val('');
    });
  });
</script>
@endsection