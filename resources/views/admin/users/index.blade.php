@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Pengguna</h1>
      </div>

      <div class="section-body">
          <div class="row">

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-4 ml-3">
                  <i class="fas fa-plus"></i> Tambah
              </a>

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
                        <h4>Pengguna</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-bordered table-hover">
                          <thead>
                            <th class="w-25">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Unit Kerja</th>
                            <th>Opsi</th>
                          </thead>
                          <tbody>
                            @foreach ($users as $item)
                              <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->role->role_name }}</td>
                                <td>{{ $item->unitKerja->nama_unit ?? '-' }}</td>
                                <td>
                                <a href="{{ route('admin.users.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit my-1">
                                    <i class="fas fa-edit"></i>
                                  </a>
                                  <button class="btn btn-sm btn-danger btn-delete my-1"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
                                  </button>
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

{{-- form delete --}}
<form id="form-delete" action="{{ route('admin.users.destroy') }}" class="d-none" method="POST">
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

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });
  });
</script>
@endsection