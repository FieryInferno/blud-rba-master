@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Sumber Dana</h1>
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
                        <h4>Data Sumber Dana</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="w-25">Nama Sumber Dana</th>
                              <th>Kode Sumber Dana</th>
                              <th>Nama Akun</th>
                              <th>Nama Bank</th>
                              <th>No Rekening</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($sumberDana as $item)
                                <tr>
                                    <td>{{ $item->nama_sumber_dana }}</td>
                                    <td>{{ $item->akun->kode_akun }}</td>
                                    <td>{{ $item->akun->nama_akun }}</td>
                                    <td>{{ $item->nama_bank }}</td>
                                    <td>{{ $item->no_rekening }}</td>
                                    @if (Auth::user()->hasRole('admin'))
                                    <td>
                                      <button class="btn btn-sm btn-warning btn-edit"
                                        data-toggle="modal" data-target="#editModal"
                                        data-id="{{ $item->id }}"
                                        data-sumber_dana ="{{ $item->nama_sumber_dana }}"
                                        data-akun_id="{{ $item->akun_id }}"
                                        data-nama_bank="{{ $item->nama_bank }}"
                                        data-no_rekening="{{ $item->no_rekening }}">
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
        <h5 class="modal-title">Buat Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.sumber_dana.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Nama Sumber Dana</label>
              <input type="text" name="nama_sumber_dana" class="form-control" value="{{ old('nama_sumber_dana') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="akun" class="form-control selectpicker" title="Pilih Kode">
                @foreach ($akun as $item)
                  <option value="{{ $item->id }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" name="nama_bank" class="form-control" value="{{ old('nama_bank') }}" required>
            </div>
            <div class="form-group">
              <label>No Rekening Bank</label>
              <input type="text" name="no_rekening" class="form-control" value="{{ old('no_rekening') }}" required>
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
        <h5 class="modal-title">Buat Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.sumber_dana.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">
        <div class="modal-body">
            <div class="form-group">
              <label>Nama Sumber Dana</label>
              <input type="text" name="nama_sumber_dana" id="edit-nama_sumber" class="form-control" value="{{ old('nama_sumber_dana') }}" required>
            </div>
            <div class="form-group">
              <label>Kode Akun</label>
              <select name="akun" class="form-control selectpicker" title="Pilih Kode" id="edit-kode_akun">
                @foreach ($akun as $item)
                  <option value="{{ $item->id }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Nama Bank</label>
              <input type="text" name="nama_bank" id="edit-nama_bank" class="form-control" value="{{ old('nama_bank') }}" required>
            </div>
            <div class="form-group">
              <label>No Rekening Bank</label>
              <input type="text" name="no_rekening" id="edit-no_rekening" class="form-control" value="{{ old('no_rekening') }}" required>
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
<form id="form-delete" action="{{ route('admin.sumber_dana.destroy') }}" class="d-none" method="POST">
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

     $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const sumber_dana = $(this).attr('data-sumber_dana');
      const akun_id = $(this).attr('data-akun_id');
      const nama_bank = $(this).attr('data-nama_bank');
      const no_rekening = $(this).attr('data-no_rekening');

      $('#edit-id').val(id);
      $('#edit-nama_sumber').val(sumber_dana);
      $('#edit-kode_').val(sumber_dana);
      $('#edit-nama_sumber').val(sumber_dana);
      $('#edit-kode_akun.selectpicker').val(akun_id);
      $('.selectpicker').selectpicker('refresh');

      $('#edit-nama_bank').val(nama_bank);
      $('#edit-no_rekening').val(no_rekening);

    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

     $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-nama_sumber').val('');
      $('#edit-kode_').val('');
      $('#edit-nama_sumber').val('');
      $('#edit-kode_akun option[selected]').attr('selected', false);
      $('#edit-nama_bank').val('');
      $('#edit-no_rekening').val('');
      $('#edit-id').val('');
    });
  });
  </script>
  @endsection