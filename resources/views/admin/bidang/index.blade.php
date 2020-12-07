@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Bidang</h1>
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
                        <h4>Data Bidang</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th class="w-25">Kode Fungsi</th>
                              <th>Kode Urusan</th>
                              <th>Kode Bidang</th>
                              <th>Nama Bidang</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($bidang as $item)
                              <tr>
                                <td>{{ $item->kode_fungsi }}</td>
                                <td>{{ $item->kode_urusan }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_bidang }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-fungsi="{{ $item->kode_fungsi }}"
                                    data-urusan="{{ $item->kode_urusan }}"
                                    data-kode="{{ $item->kode }}"
                                    data-nama="{{ $item->nama_bidang }}">
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
        <h5 class="modal-title">Buat Bidang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.bidang.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="form-group">
              <label>Kode Fungsi</label>
              <select name="kode_fungsi" class="form-control">
                <option value="" selected disabled>-- Pilih Fungsi --</option>
                @foreach ($fungsi as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_fungsi }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Urusan</label>
              <select name="kode_urusan" class="form-control">
                <option value="" selected disabled>-- Pilih Urusan --</option>
                @foreach ($urusan as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_urusan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Bidang</label>
              <input type="text" name="kode" class="form-control" value="{{ old('kode') }}">
            </div>
            <div class="form-group">
              <label>Nama Bidang</label>
              <input type="text" name="nama_bidang" class="form-control" value="{{ old('nama_bidang') }}" required>
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
        <h5 class="modal-title">Sunting Bidang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.bidang.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="form-group">
              <label>Kode Fungsi</label>
              <select name="kode_fungsi" id="edit-fungsi" class="form-control">
                <option value="" selected disabled>-- Pilih Fungsi --</option>
                @foreach ($fungsi as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_fungsi }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Urusan</label>
              <select name="kode_urusan" id="edit-urusan" class="form-control">
                <option value="" selected disabled>-- Pilih Urusan --</option>
                @foreach ($urusan as $item)
                  <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->nama_urusan }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Kode Bidang</label>
              <input type="text" id="edit-kode" name="kode" class="form-control" value="">
            </div>
            <div class="form-group">
              <label>Nama Bidang</label>
              <input type="text" id="edit-nama" name="nama_bidang" class="form-control" value="" required>
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
<form id="form-delete" action="{{ route('admin.bidang.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
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

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const fungsi = $(this).attr('data-fungsi');
      const urusan = $(this).attr('data-urusan');
      const kode = $(this).attr('data-kode');
      const nama = $(this).attr('data-nama');

      // auto select options
      $(`#edit-fungsi option[value="${fungsi}"]`).attr('selected', true)
      $(`#edit-urusan option[value="${urusan}"]`).attr('selected', true)

      $('#edit-id').val(id);
      $('#edit-kode').val(kode);
      $('#edit-nama').val(nama);
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

    // reset state when edit modal is closed
    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-fungsi option[selected]').attr('selected', false);
      $('#edit-urusan option[selected]').attr('selected', false);

      $('#edit-id').val('');
      $('#edit-kode').val('');
      $('#edit-nama').val('');
    });
  });
</script>
@endsection