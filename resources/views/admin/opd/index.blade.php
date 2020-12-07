@extends('layouts.admin')

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>OPD</h1>
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
                        <h4>Data OPD</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode OPD</th>
                              <th>Nama Pejabat</th>
                              <th>NIP</th>
                              <th>Jabatan</th>
                              <th>Status</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($opd as $item)
                              <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_pejabat }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->jabatan->nama_jabatan }}</td>
                                <td>{{ $item->status }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode }}"
                                    data-nama="{{ $item->nama_pejabat }}"
                                    data-nip="{{ $item->nip }}"
                                    data-jabatan="{{ $item->jabatan_id }}"
                                    data-status="{{ $item->status }}">
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
        <h5 class="modal-title">Buat OPD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.opd.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode OPD</label>
              <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
            </div>
            <div class="form-group">
              <label>Nama Pejabat</label>
              <input type="text" name="nama_pejabat" class="form-control" value="{{ old('nama_pejabat') }}" required>
            </div>
            <div class="form-group">
              <label>NIP</label>
              <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <select name="jabatan_id" class="form-control">
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
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
        <h5 class="modal-title">Sunting OPD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.opd.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Kode OPD</label>
              <input type="text" id="edit-kode" name="kode" class="form-control" value="" disabled>
            </div>
            <div class="form-group">
              <label>Nama Pejabat</label>
              <input type="text" id="edit-nama" name="nama_pejabat" class="form-control" value="" required>
            </div>
            <div class="form-group">
              <label>NIP</label>
              <input type="text" id="edit-nip" name="nip" class="form-control" value="" required>
            </div>
            <div class="form-group">
              <div class="form-group">
              <label>Jabatan</label>
              <select name="jabatan_id" id="edit-jabatan" class="form-control">
                <option value="">Pilih Jabatan</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                @endforeach
              </select>
            </div>
            </div>
            <div class="form-group">
                <label>Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="radioAktif" value="1">
                    <label class="form-check-label" for="radioAktif">
                        Aktif
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="radioTidakAktif" value="0">
                    <label class="form-check-label" for="radioTidakAktif">
                        Tidak Aktif
                    </label>
                </div>
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
<form id="form-delete" action="{{ route('admin.opd.destroy') }}" class="d-none" method="POST">
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
      const kode = $(this).attr('data-kode');
      const nama = $(this).attr('data-nama');
      const nip = $(this).attr('data-nip');
      const jabatan = $(this).attr('data-jabatan');
      const status = $(this).attr('data-status');

      $(`#edit-jabatan option[value="${jabatan}"]`).attr('selected', true);

      $('#edit-id').val(id);
      $('#edit-kode').val(kode);
      $('#edit-nama').val(nama);
      $('#edit-nip').val(nip);

      if (status == 'Aktif') {
        $('#radioAktif').prop('checked', true);
        $('#radioTidakAktif').prop('checked', false);
      } else {
        $('#radioAktif').prop('checked', false);
        $('#radioTidakAktif').prop('checked', true);
      }
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