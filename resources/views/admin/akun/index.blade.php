@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Akun</h1>
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
                        <h4>Data Akun</h4>
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered table-hover table-responsive">
                          <thead>
                            <tr>
                              <th>Tipe</th>
                              <th>Kelompok</th>
                              <th>Jenis</th>
                              <th>Objek</th>
                              <th>Rincian</th>
                              <th>Sub 1</th>
                              <th>Sub 2</th>
                              <th>Sub 3</th>
                              <th>Kode Akun</th>
                              <th>Nama Akun</th>
                              <th>Kategori</th>
                              <th>Pagu</th>
                              <th>Realisasi</th>
                              @if (Auth::user()->hasRole('admin'))
                              <th>Opsi</th>
                              @endif
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($akun as $item)
                              <tr class="text-dark {{ ($item->is_parent) ? 'table-primary' : ''  }}">
                                <td>{{ $item->tipe }}</td>
                                <td>{{ $item->kelompok }}</td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->objek }}</td>
                                <td>{{ $item->rincian }}</td>
                                <td>{{ $item->sub1 }}</td>
                                <td>{{ $item->sub2 }}</td>
                                <td>{{ $item->sub3 }}</td>
                                <td>{{ $item->kode_akun }}</td>
                                <td>{{ $item->nama_akun }}</td>
                                <td>{{ $item->kategori->nama_akun }}</td>
                                <td>
                                  @if ($item->pagu)
                                    {{ format_idr($item->pagu) }}
                                  @else 
                                    0.0  
                                  @endif
                                </td>
                                <td>0</td>
                                @if (Auth::user()->hasRole('admin'))
                                <td>
                                  <div class="text-center">
                                    <button class="btn btn-sm btn-warning btn-edit d-inline-block"
                                      data-toggle="modal" data-target="#editModal"
                                      data-id="{{ $item->id }}"
                                      data-tipe="{{ $item->tipe }}"
                                      data-kelompok="{{ $item->kelompok }}"
                                      data-jenis="{{ $item->jenis }}"
                                      data-objek="{{ $item->objek }}"
                                      data-rincian="{{ $item->rincian }}"
                                      data-sub1="{{ $item->sub1 }}"
                                      data-sub2="{{ $item->sub2 }}"
                                      data-sub3="{{ $item->sub3 }}"
                                      data-kode_akun="{{ $item->kode_akun }}"
                                      data-nama_akun="{{ $item->nama_akun }}"
                                      data-kategori="{{ $item->kategori_id }}"
                                      data-pagu="{{ format_idr($item->pagu) }}"
                                      data-parent="{{ $item->is_parent }}">
                                      <i class="fas fa-edit"></i> 
                                    </button>
                                    
                                    <button class="btn btn-sm btn-danger btn-delete d-inline-block"
                                      data-id="{{ $item->id }}">
                                      <i class="fas fa-trash"></i> 
                                    </button>
                                  </div>
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
      <form action="{{ route('admin.akun.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Tipe</label>
                    <input type="text" name="tipe" class="form-control akun" value="{{ old('tipe') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Kelompok</label>
                    <input type="text" name="kelompok" class="form-control akun" value="{{ old('kelompok') }}">
                  </div>
                  <div class="form-group">
                    <label>Jenis</label>
                    <input type="text" name="jenis" class="form-control akun" value="{{ old('jenis') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 2</label>
                    <input type="text" name="sub2" class="form-control akun" value="{{ old('sub2') }}" >
                  </div>
                   <div class="form-group">
                    <label>Kode Akun</label>
                    <input type="text" name="kode_akun" class="form-control" value="{{ old('kode_akun') }}" required readonly>
                  </div>
                  <div class="form-group">
                      <label>Kategori</label>
                      <select name="kategori" class="form-control">
                          <option value="">Pilih Kategori</option>
                          @foreach ($kategori as $item)
                              <option value="{{ $item->id }}" >{{ $item->nama_akun }}</option>
                          @endforeach
                      </select>
                  </div>
                   <div class="form-group">
                      <label>Status Akun / Rekening </label>
                      <div class="form-check"> 
                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="is_parent">
                        <label class="form-check-label" for="inlineCheckbox1">Akun Induk</label>
                      
                      </div>
                  </div>
                  
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                    <label>Objek</label>
                    <input type="text" name="objek" class="form-control akun" value="{{ old('objek') }}" >
                  </div>
                  <div class="form-group">
                    <label>Rincian</label>
                    <input type="text" name="rincian" class="form-control akun" value="{{ old('rincian') }}" >
                  </div>
                   <div class="form-group">
                    <label>Sub 1</label>
                    <input type="text" name="sub1" class="form-control akun" value="{{ old('sub1') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 3</label>
                    <input type="text" name="sub3" class="form-control akun" value="{{ old('sub3') }}" >
                  </div>
                  <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" name="nama_akun" class="form-control" value="{{ old('nama_akun') }}" required>
                  </div>
                   <div class="form-group">
                      <label>Pagu</label>
                      <input type="text" name="pagu" class="form-control money" value="{{ old('pagu') }}">
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
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Akun</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('admin.akun.update') }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit-id" name="id">
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label>Tipe</label>
                    <input type="text" id="edit-tipe" name="tipe" class="form-control akun-edit" value="{{ old('tipe') }}" required>
                  </div>
                  <div class="form-group">
                    <label>Kelompok</label>
                    <input type="text" id="edit-kelompok" name="kelompok" class="form-control akun-edit" value="{{ old('kelompok') }}">
                  </div>
                  <div class="form-group">
                    <label>Jenis</label>
                    <input type="text" id="edit-jenis" name="jenis" class="form-control akun-edit" value="{{ old('jenis') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 2</label>
                    <input type="text" id="edit-sub2" name="sub2" class="form-control akun-edit" value="{{ old('sub2') }}" >
                  </div>
                  <div class="form-group">
                    <label>Kode Akun</label>
                    <input type="text" id="edit-kode_akun" name="kode_akun" class="form-control"  required readonly>
                  </div>
                  <div class="form-group">
                      <label>Kategori</label>
                      <select name="kategori" id="edit-kategori" class="form-control">
                          <option value="">Pilih Kategori</option>
                          @foreach ($kategori as $item)
                              <option value="{{ $item->id }}" >{{ $item->nama_akun }}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Status Akun / Rekening </label>
                      <div class="form-check"> 
                        <input class="form-check-input" type="checkbox" id="edit-parent" name="is_parent">
                        <label class="form-check-label" for="inlineCheckbox1">Akun Induk</label>
                      </div>
                  </div>
                  
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Objek</label>
                    <input type="text" id="edit-objek" name="objek" class="form-control akun-edit" value="{{ old('objek') }}" >
                  </div>
                  <div class="form-group">
                    <label>Rincian</label>
                    <input type="text" id="edit-rincian" name="rincian" class="form-control akun-edit" value="{{ old('rincian') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 1</label>
                    <input type="text" id="edit-sub1" name="sub1" class="form-control akun-edit" value="{{ old('sub1') }}" >
                  </div>
                  <div class="form-group">
                    <label>Sub 3</label>
                    <input type="text" id="edit-sub3" name="sub3" class="form-control akun-edit" value="{{ old('sub3') }}" >
                  </div>
                  <div class="form-group">
                    <label>Nama Akun</label>
                    <input type="text" id="edit-nama_akun" name="nama_akun" class="form-control" value="{{ old('nama_akun') }}" required>
                  </div>
                  <div class="form-group">
                      <label>Pagu</label>
                      <input type="text" id="edit-pagu" name="pagu" class="form-control money" value="{{ old('pagu') }}">
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
<form id="form-delete" action="{{ route('admin.akun.destroy') }}" class="d-none" method="POST">
  @csrf
  @method('DELETE')
  <input type="hidden" name="id" id="delete-id">
</form>
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
<script src="{{ asset('dashboard/js/jquery.maskMoney.min.js') }}"></script>
<script>
  $(document).ready(function () {
    @if ($message = Session::get('success'))
        iziToast.success({
        title: 'Sukses!',
        message: '{{ $message }}',
        position: 'topRight'
      });
    @endif

    $('table').DataTable();

    $('.akun').keyup(function () {
      const tipe      = $('input[name ="tipe"]').val(); 
      const kelompok  = $('input[name ="kelompok"]').val(); 
      const jenis     = $('input[name ="jenis"]').val(); 
      const objek     = $('input[name ="objek"]').val(); 
      const rincian   = $('input[name ="rincian"]').val(); 
      const sub1      = $('input[name ="sub1"]'   ).val(); 
      const sub2      = $('input[name ="sub2"]').val(); 
      const sub3      = $('input[name ="sub3"]').val(); 
      
      var concatData  = '';
      if (tipe != ''){
        concatData += tipe;
      }

      if (kelompok != ''){
        concatData += '.'+kelompok;
      }

      if (jenis != ''){
        concatData += '.'+jenis;
      }

      if (objek != ''){
        concatData += '.'+objek;
      }

      if (rincian != ''){
        concatData += '.'+rincian;
      }
      if (sub1 != '') concatData  += '.' + sub1;
      if (sub2 != '') concatData  += '.' + sub2;
      if (sub3 != '') concatData  += '.' + sub3;

      $('input[name ="kode_akun"]').val(concatData); 
    })


    $('.akun-edit').keyup(function () {
      const tipe      = $('#editModal input[name ="tipe"]').val(); 
      const kelompok  = $('#editModal input[name ="kelompok"]').val(); 
      const jenis     = $('#editModal input[name ="jenis"]').val(); 
      const objek     = $('#editModal input[name ="objek"]').val(); 
      const rincian   = $('#editModal input[name ="rincian"]').val(); 
      const sub1      = $('#editModal input[name ="sub1"]').val(); 
      console.log(sub1);
      
      var concatData = '';
      if (tipe != ''){
        concatData += tipe;
      }

      if (kelompok != ''){
        concatData += '.'+kelompok;
      }

      if (jenis != ''){
        concatData += '.'+jenis;
      }

      if (objek != ''){
        concatData += '.'+objek;
      }

      if (rincian != ''){
        concatData  += '.' + rincian;
      }

      if (sub1 != ''){
        concatData  += '.' + sub1;
      }

      $('input[name ="kode_akun"]').val(concatData); 
    })

    // resize datatable search box
    $('.dataTables_filter input[type="search"]').css(
      {'width':'380px','display':'inline-block'}
    );

    $('.btn-edit').click(function () {
      const id        = $(this).attr('data-id');
      const tipe      = $(this).attr('data-tipe');
      const kelompok  = $(this).attr('data-kelompok');
      const objek     = $(this).attr('data-objek');
      const rincian   = $(this).attr('data-rincian');
      const jenis     = $(this).attr('data-jenis');
      const sub1      = $(this).attr('data-sub1');
      const sub2      = $(this).attr('data-sub2');
      const sub3      = $(this).attr('data-sub3');
      const kode_akun = $(this).attr('data-kode_akun');
      const nama_akun = $(this).attr('data-nama_akun');
      const kategori  = $(this).attr('data-kategori');
      const pagu      = $(this).attr('data-pagu')+'00';
      const parent    = $(this).attr('data-parent');

      $('#edit-id').val(id);
      $('#edit-tipe').val(tipe);
      $('#edit-kelompok').val(kelompok);
      $('#edit-objek').val(objek);
      $('#edit-rincian').val(rincian);
      $('#edit-jenis').val(jenis);
      $('#edit-sub1').val(sub1);
      $('#edit-sub2').val(sub2);
      $('#edit-sub3').val(sub3);
      $('#edit-kode_akun').val(kode_akun);
      $('#edit-nama_akun').val(nama_akun);
      $(`#edit-kategori option[value="${kategori}"]`).attr('selected', true);
      $('#edit-pagu').val(pagu);
      if (parent == 1){
        $('#edit-parent').attr('checked', true);
      }
    });

    $('.btn-delete').click(function () {
      if (confirm('Anda yakin akan menghapus data ini?')) {
        $('#delete-id').val($(this).attr('data-id'));
        $('#form-delete').submit();
      }
    });

    $('.money').maskMoney({
        prefix: 'Rp.',
        thousands: '.',
        decimal: ',',
    })

    $('#editModal').on('hidden.bs.modal', function (e) {
      $('#edit-fungsi option[selected]').attr('selected', false);
      $('#edit-urusan option[selected]').attr('selected', false);
      $('#edit-parent').attr('checked', false);

      $('#edit-id').val('');
      $('#editModal input[name ="tipe"]').val(''); 
      $('#editModal input[name ="objek"]').val(''); 
      $('#editModal input[name ="kelompok"]').val(''); 
      $('#editModal input[name ="rincian"]').val(''); 
      $('#editModal input[name ="jenis"]').val(''); 
      $('#editModal input[name ="sub1"]').val(''); 
      $('#editModal input[name ="sub2"]').val(''); 
      $('#editModal input[name ="sub3"]').val(''); 
      $('#editModal input[name ="kode_akun"]').val(''); 
      $('#editModal input[name ="nama_akun"]').val(''); 
      $('#editModal input[name ="pagu"]').val(''); 
    });
  });
</script>
@endsection
