@extends('layouts.admin')

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pejabat Unit</h1>
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
                        <h4>Data Pejabat Unit</h4>
                      </div>
                      <div class="card-body">
                        <div class="accordion" id="accordionExample">

                          @foreach ($unitKerja as $unit)
                          <div class="card mb-2" style="background-color:#e3eaef">
                            <div class="card-header" id="heading{{ $unit->id }}">
                              <h2 class="mb-0">
                                <button style="font-size:14px" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{ $unit->id }}" aria-expanded="true" aria-controls="collapse{{ $unit->id }}">
                                  {{ $unit->kode_opd }} - {{ $unit->nama_unit }}
                                </button>
                              </h2>
                            </div>
                        
                            <div id="collapse{{ $unit->id }}" class="collapse" aria-labelledby="heading{{ $unit->id }}" data-parent="#accordionExample" style="background-color:#fff">
                              <div class="card-body">
                                <table class="table table-bordered table-hover">
                                  <thead>
                                    <tr>
                                      <th>Nama Pejabat</th>
                                      <th>NIP</th>
                                      <th>Jabatan</th>
                                      <th>Nama Unit</th>
                                      <th>Status</th>
                                      @if (Auth::user()->hasRole('admin'))
                                      <th style="width:24%">Opsi</th>
                                      @endif
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($unit->pejabat as $item)
                                      <tr>
                                        <td>{{ $item->nama_pejabat }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->jabatan->nama_jabatan }}</td>
                                        <td>{{ $item->unit->nama_unit }}</td>
                                        <td>{{ $item->status }}</td>
                                        @if (Auth::user()->hasRole('admin'))
                                        <td>
                                          <button class="btn btn-sm btn-warning btn-edit"
                                            data-toggle="modal" data-target="#editModal"
                                            data-id="{{ $item->id }}"
                                            data-nip="{{ $item->nip }}"
                                            data-nama="{{ $item->nama_pejabat }}"
                                            data-unit="{{ $item->kode_unit_kerja }}"
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
                          @endforeach
                        </div>
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
        <h5 class="modal-title">Buat Pejabat Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pejabat_unit.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Nama Pejabat</label>
              <input type="text" name="nama_pejabat" class="form-control" value="{{ old('nama_pejabat') }}" required>
            </div>
            <div class="form-group">
              <label>Nip</label>
              <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <select name="jabatan_id" class="form-control">
                <option value="">Pilih Jabatan</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="unit_kerja" class="form-control">
                <option value="">Pilih Unit Kerja</option>
                @foreach($unitKerja as $item)
                    <option value="{{ $item->kode }}">{{ $item->nama_unit }}</option>
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
        <h5 class="modal-title">Sunting Pejabat Unit</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.pejabat_unit.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Nama Pejabat</label>
              <input type="text" id="edit-nama" name="nama_pejabat" class="form-control" value="" required>
            </div>
            <div class="form-group">
              <label>NIP</label>
              <input type="text" id="edit-nip" name="nip" class="form-control" value="" required>
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <select name="jabatan_id" id="edit-jabatan" class="form-control">
                <option value="">Pilih Jabatan</option>
                @foreach($jabatan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <select name="unit_kerja" id="edit-unit" class="form-control">
                <option value="">Pilih Unit Kerja</option>
                @foreach($unitKerja as $item)
                    <option value="{{ $item->kode }}">{{ $item->nama_unit }}</option>
                @endforeach
              </select>
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
<form id="form-delete" action="{{ route('admin.pejabat_unit.destroy') }}" class="d-none" method="POST">
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

    @if ($message = Session::get('error'))
        iziToast.error({
        title: 'Gagal!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const nama = $(this).attr('data-nama');
      const nip = $(this).attr('data-nip');
      const jabatan = $(this).attr('data-jabatan');
      const unit = $(this).attr('data-unit');
      const status = $(this).attr('data-status');

      $(`#edit-jabatan option[value="${jabatan}"]`).attr('selected', true);
      $(`#edit-unit option[value="${unit}"]`).attr('selected', true);

      $('#edit-id').val(id);
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

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-jabatan option[selected]').attr('selected', false);
      $('#edit-unit option[selected]').attr('selected', false);

      $('#edit-id').val('');
      $('#edit-kode').val('');
      $('#edit-nama').val('');
    });
  });
</script>
@endsection