@extends('layouts.admin')

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Kategori Akun</h1>
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
                        <h4>Data Kategori Akun</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Kode Akun</th>
                              <th>Nama Akun</th>
                              <th>Saldo Normal</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($kategoriAkun as $item)
                              <tr>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_akun }}</td>
                                <td>{{ $item->saldo_normal }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-kode="{{ $item->kode }}"
                                    data-namaakun="{{ $item->nama_akun }}"
                                    data-saldonormal="{{ $item->saldo_normal }}">
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
        <h5 class="modal-title">Buat Kategori Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.kategoriakun.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" name="kode" class="form-control" value="{{ old('kode') }}" required>
            </div>
            <div class="form-group">
              <label>Nama Akun</label>
              <input type="text" name="nama_akun" class="form-control" value="{{ old('nama_akun') }}" required>
            </div>
            <div class="form-group">
              <label>Saldo Normal</label>
              <select name="saldo_normal" class="form-control">
                <option value="">Pilih Saldo Normal</option>
                @foreach ($saldoNormal as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
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
        <h5 class="modal-title">Sunting Pejabat Daerah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.kategoriakun.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Kode</label>
              <input type="text" id="edit-kode" name="kode" class="form-control" value="{{ old('kode') }}" required>
            </div>
            <div class="form-group">
              <label>Nama Akun</label>
              <input type="text" id="edit-namaakun" name="nama_akun" class="form-control" value="{{ old('nama_akun') }}" required>
            </div>
            <div class="form-group">
              <label>Saldo Normal</label>
              <select name="saldo_normal" id="edit-saldonormal" class="form-control">
                <option value="">Pilih Saldo Normal</option>
                @foreach ($saldoNormal as $item)
                    <option value="{{ $item }}">{{ $item }}</option>
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
<form id="form-delete" action="{{ route('admin.kategoriakun.destroy') }}" class="d-none" method="POST">
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
        const namaAkun = $(this).attr('data-namaakun');
        const saldoNormal = $(this).attr('data-saldonormal');

        $('#edit-id').val(id);
        $('#edit-kode').val(kode);
        $('#edit-namaakun').val(namaAkun);
        $(`#edit-saldonormal option[value="${saldoNormal}"]`).attr('selected', true);
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