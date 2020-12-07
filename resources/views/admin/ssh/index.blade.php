@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-select.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Standard Barang</h1>
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
                        <h4>Data Standard Barang</h4>
                      </div>
                      <div class="card-body">

                        <table class="table table-responsive table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Golongan</th>
                              <th>Bidang</th>
                              <th>Kelompok</th>
                              <th>Sub 1</th>
                              <th>Sub 2</th>
                              <th>Sub 3</th>
                              <th>Sub 4</th>
                              <th>Kode Akun</th>
                              <th>Kode Barang</th>
                              <th>Nama Barang</th>
                              <th>Satuan</th>
                              <th>Merk</th>
                              <th>Spesifikasi</th>
                              <th>Harga</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($ssh as $item)
                              <tr>
                                <td>{{ $item->golongan }}</td>
                                <td>{{ $item->bidang }}</td>
                                <td>{{ $item->kelompok }}</td>
                                <td>{{ $item->sub1 }}</td>
                                <td>{{ $item->sub2 }}</td>
                                <td>{{ $item->sub3 }}</td>
                                <td>{{ $item->sub4 }}</td>
                                <td>{{ $item->akun->kode_akun }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->satuan }}</td>
                                <td>{{ $item->merk }}</td>
                                <td>{{ $item->spesifikasi }}</td>
                                <td>{{ format_idr($item->harga) }}</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                    data-toggle="modal" data-target="#editModal"
                                    data-id="{{ $item->id }}"
                                    data-golongan="{{ $item->golongan }}"
                                    data-bidang="{{ $item->bidang }}"
                                    data-kelompok="{{ $item->kelompok }}"
                                    data-sub1="{{ $item->sub1 }}"
                                    data-sub2="{{ $item->sub2 }}"
                                    data-sub3="{{ $item->sub3 }}"
                                    data-sub4="{{ $item->sub4 }}"
                                    data-akun="{{ $item->kode_akun }}"
                                    data-kode="{{ $item->kode }}"
                                    data-nama="{{ $item->nama_barang }}"
                                    data-satuan="{{ $item->satuan }}"
                                    data-merk="{{ $item->merk }}"
                                    data-spesifikasi="{{ $item->spesifikasi }}"
                                    data-harga="{{ format_idr($item->harga) }}">
                                    <i class="fas fa-edit"></i>
                                  </button>
                                  <button class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $item->id }}">
                                    <i class="fas fa-trash"></i>
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="createModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Standard Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.ssh.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Golongan</label>
                    <input type="text" name="golongan" class="form-control ssh" value="{{ old('golongan') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Bidang</label>
                    <input type="text" name="bidang" class="form-control ssh" value="{{ old('bidang') }}">
                  </div>
                  <div class="form-group">
                    <label>Kelompok</label>
                    <input type="text" name="kelompok" class="form-control ssh" value="{{ old('kelompok') }}">
                  </div>
                  <div class="form-group">
                    <label>Sub 1</label>
                    <input type="text" name="sub1" class="form-control ssh" value="{{ old('sub1') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 2</label>
                    <input type="text" name="sub2" class="form-control ssh" value="{{ old('sub2') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 3</label>
                    <input type="text" name="sub3" class="form-control ssh" value="{{ old('sub3') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 4</label>
                    <input type="text" name="sub4" class="form-control ssh" value="{{ old('sub4') }}" >
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Akun</label>
                    <select name="kode_akun" class="form-control selectpicker" title="Pilih Kode">
                      @foreach ($akun as $item)
                        <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}" required readonly>
                  </div>
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Merk</label>
                    <input type="text" name="merk" class="form-control" value="{{ old('merk') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control money" value="{{ old('harga') }}" required>
                  </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Spesifikasi</label>
                  <input type="text" name="spesifikasi" class="form-control" value="{{ old('spesifikasi') }}" required>
                </div>
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

{{-- edit modal --}}
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Standard Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.ssh.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="edit-id" name="id">

        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label>Golongan</label>
                      <input type="text" id="edit-golongan" name="golongan" class="form-control ssh" value="{{ old('golongan') }}" required>
                    </div>
                    <div class="form-group">
                      <label>Bidang</label>
                      <input type="text" id="edit-bidang" name="bidang" class="form-control ssh" value="{{ old('bidang') }}">
                    </div>
                    <div class="form-group">
                      <label>Kelompok</label>
                      <input type="text" id="edit-kelompok" name="kelompok" class="form-control ssh" value="{{ old('kelompok') }}">
                    </div>
                    <div class="form-group">
                      <label>Sub 1</label>
                      <input type="text" id="edit-sub1" name="sub1" class="form-control ssh" value="{{ old('sub1') }}" >
                    </div>
                    <div class="form-group">
                      <label>Sub 2</label>
                      <input type="text" id="edit-sub2" name="sub2" class="form-control ssh" value="{{ old('sub2') }}" >
                    </div>
                    <div class="form-group">
                      <label>Sub 3</label>
                      <input type="text" id="edit-sub3" name="sub3" class="form-control ssh" value="{{ old('sub3') }}" >
                    </div>
                    <div class="form-group">
                      <label>Sub 4</label>
                      <input type="text" id="edit-sub4" name="sub4" class="form-control ssh" value="{{ old('sub4') }}" >
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label>Kode Akun</label>
                      <select id="edit-akun" name="kode_akun" class="form-control selectpicker" title="Pilih Kode">
                        @foreach ($akun as $item)
                          <option value="{{ $item->kode_akun }}">{{ $item->kode_akun }} - {{ $item->nama_akun }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Kode Barang</label>
                      <input type="text" id="edit-kode" name="kode_barang" class="form-control" value="{{ old('kode_barang') }}" required readonly>
                    </div>
                    <div class="form-group">
                      <label>Nama Barang</label>
                      <input type="text" id="edit-nama" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
                    </div>
                    <div class="form-group">
                      <label>Satuan</label>
                      <input type="text" id="edit-satuan" name="satuan" class="form-control" value="{{ old('satuan') }}" required>
                    </div>
                    <div class="form-group">
                      <label>Merk</label>
                      <input type="text" id="edit-merk" name="merk" class="form-control" value="{{ old('merk') }}" required>
                    </div>
                    <div class="form-group">
                      <label>Harga</label>
                      <input type="text" id="edit-harga" name="harga" class="form-control money" value="{{ old('harga') }}" required>
                    </div>
                </div>
    
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Spesifikasi</label>
                    <input type="text" id="edit-spesifikasi" name="spesifikasi" class="form-control" value="{{ old('spesifikasi') }}" required>
                  </div>
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
<form id="form-delete" action="{{ route('admin.ssh.destroy') }}" class="d-none" method="POST">
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

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.ssh').keyup(function () {
      const golongan = $('input[name="golongan"]').val(); 
      const bidang = $('input[name="bidang"]').val(); 
      const kelompok = $('input[name="kelompok"]').val(); 
      const sub1 = $('input[name="sub1"]').val(); 
      const sub2 = $('input[name="sub2"]').val(); 
      const sub3 = $('input[name="sub3"]').val(); 
      const sub4 = $('input[name="sub4"]').val(); 
      
      var concatData = '';
      if (golongan != ''){
        concatData += golongan;
      }

      if (bidang != ''){
        concatData += '.'+bidang;
      }

      if (kelompok != ''){
        concatData += '.'+kelompok;
      }

      if (sub1 != ''){
        concatData += '.'+sub1;
      }

      if (sub2 != ''){
        concatData += '.'+sub2;
      }

      if (sub3 != ''){
        concatData += '.'+sub3;
      }
      
      if (sub4 != ''){
        concatData += '.'+sub4;
      }

      $('input[name="kode_barang"]').val(concatData); 
    })

    $('.money').maskMoney({
        prefix: 'Rp.',
        thousands: '.',
        decimal: ',',
    })

    $('.btn-edit').click(function () {
      const id = $(this).attr('data-id');
      const golongan = $(this).attr('data-golongan');
      const bidang = $(this).attr('data-bidang');
      const kelompok = $(this).attr('data-kelompok');
      const sub1 = $(this).attr('data-sub1');
      const sub2 = $(this).attr('data-sub2');
      const sub3 = $(this).attr('data-sub3');
      const sub4 = $(this).attr('data-sub4');
      const akun = $(this).attr('data-akun');
      const kode = $(this).attr('data-kode');
      const nama = $(this).attr('data-nama');
      const satuan = $(this).attr('data-satuan');
      const merk = $(this).attr('data-merk');
      const spesifikasi = $(this).attr('data-spesifikasi');
      const harga = $(this).attr('data-harga');

      // auto select options
      $('#edit-akun.selectpicker').val(akun);
      $('.selectpicker').selectpicker('refresh');

      $('#edit-id').val(id);
      $('#edit-golongan').val(golongan);
      $('#edit-bidang').val(bidang);
      $('#edit-kelompok').val(kelompok);
      $('#edit-sub1').val(sub1);
      $('#edit-sub2').val(sub2);
      $('#edit-sub3').val(sub3);
      $('#edit-sub4').val(sub4);
      $('#edit-kode').val(kode);
      $('#edit-nama').val(nama);
      $('#edit-satuan').val(satuan);
      $('#edit-merk').val(merk);
      $('#edit-spesifikasi').val(spesifikasi);
      $('#edit-harga').val(harga);

      $('.ssh').keyup(function () {
      const editGolongan = $('#editModal input[name="golongan"]').val(); 
      const editBidang = $('#editModal input[name="bidang"]').val(); 
      const editKelompok = $('#editModal input[name="kelompok"]').val(); 
      const editSub1 = $('#editModal input[name="sub1"]').val(); 
      const editSub2 = $('#editModal input[name="sub2"]').val(); 
      const editSub3 = $('#editModal input[name="sub3"]').val(); 
      const editSub4 = $('#editModal input[name="sub4"]').val(); 
      
      var concatData = '';
        if (editGolongan != ''){
          concatData += editGolongan;
        }

        if (editBidang != ''){
          concatData += '.'+editBidang;
        }

        if (editKelompok != ''){
          concatData += '.'+editKelompok;
        }

        if (editSub1 != ''){
          concatData += '.'+editSub1;
        }

        if (editSub2 != ''){
          concatData += '.'+editSub2;
        }

        if (editSub3 != ''){
          concatData += '.'+editSub3;
        }

         if (editSub4 != ''){
          concatData += '.'+editSub4;
        }

        $('#editModal input[name="kode_barang"]').val(concatData); 
      })
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