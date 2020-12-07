@extends('layouts.admin')

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Unit Kerja</h1>
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
                        <h4>Data Unit Kerja</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode OPD</th>
                              <th>Kode Unit</th>
                              <th>Nama Unit</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($unitKerja as $item)
                              <tr>
                                <td>{{ $item->kode_opd }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_unit }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-opd="{{ $item->kode_opd }}"
                                    data-kode="{{ $item->kode }}"
                                    data-nama="{{ $item->nama_unit }}">
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
        <h5 class="modal-title">Buat Unit Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.unit_kerja.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode OPD</label>
              <input type="text" name="kode_opd" class="form-control" value="{{ old('kode_opd', '1.02.01') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Unit</label>
              <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
            </div>
            <div class="form-group">
              <label>Nama Unit</label>
              <input type="text" name="nama_unit" class="form-control" value="{{ old('nama_unit') }}" required>
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
        <h5 class="modal-title">Sunting Unit Kerja</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.unit_kerja.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Kode OPD</label>
              <input type="text" id="edit-opd" name="kode_opd" class="form-control" value="" disabled>
            </div>
            <div class="form-group">
              <label>Kode</label>
              <input type="text" id="edit-kode" name="kode" class="form-control" value="" disabled>
            </div>
            <div class="form-group">
              <label>Nama Unit</label>
              <input type="text" id="edit-nama" name="nama_unit" class="form-control" value="" required>
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
<form id="form-delete" action="{{ route('admin.unit_kerja.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script>
  $(document).ready(function () {
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const opd = $(this).attr('data-opd');
      const kode = $(this).attr('data-kode');
      const nama = $(this).attr('data-nama');

      $('#edit-id').val(id);
      $('#edit-opd').val(opd);
      $('#edit-kode').val(kode);
      $('#edit-nama').val(nama);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });
  });
</script>
@endsection