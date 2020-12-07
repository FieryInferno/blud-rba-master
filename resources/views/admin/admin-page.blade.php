@extends('layouts.admin')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Halaman Admin</h1>
        </div>
    </section>
    <div class="row">
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

              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Pengaturan Umum</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link  active show" id="home-tab" data-toggle="tab" href="#status" role="tab" aria-controls="home" aria-selected="false">
                          Status
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="status-anggaran-tab" data-toggle="tab" href="#status_anggaran" role="tab" aria-controls="status-anggaran" aria-selected="false">
                          Status Anggaran
                        </a>
                      </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane active show" id="status" role="tabpanel" aria-labelledby="home-tab">
                        <form action="{{ route('admin.update_status') }}" method="POST">
                          @csrf
                          @method('PUT')
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Anggaran Aktif</label>
                            <div class="col-sm-12 col-md-7">
                                <select name="status" class="form-control">
                                    <option value="">-- Pilih Status --</option>
                                    @foreach ($statusAnggaran as $item)
                                      <option value="{{ $item->id }}"
                                        {{ (auth()->user()->status_anggaran_id == $item->id) ? 'selected' : '' }}
                                      >{{ $item->status_anggaran }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          
                          <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                              <button class="btn btn-primary">Simpan</button>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="tab-pane fade" id="status_anggaran" role="tabpanel" aria-labelledby="status-anggaran-tab">
                        <div class="row">
                          <button class="btn btn-primary btn-sm mb-3 ml-2" type="button" data-toggle="modal" data-target="#statusAnggaranModal">
                            <i class="fas fa-plus"></i> Buat Status Anggaran
                          </button>

                          <table class="table table-hover">
                            <thead>
                              <th>No</th>
                              <th>Status Anggaran</th>
                              <th>Salin</th>
                              <th>Status Perubahan</th>
                              <th>Opsi</th>
                            </thead>
                            <tbody>
                              @foreach ($statusAnggaran as $item)
                                <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ $item->status_anggaran }}</td>
                                  <td>{{ $item->is_copyable ? 'DAPAT DISALIN' : 'TIDAK DAPAT DISALIN' }}</td>
                                  <td>{{ $item->status_perubahan }}</td>
                                  <td>
                                    <button type="button" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#editStatusAnggaranModal"
                                      data-id="{{ $item->id }}"
                                      data-status-anggaran="{{ $item->status_anggaran }}"
                                      data-status-perubahan="{{ $item->status_perubahan }}"
                                      data-salin="{{ $item->is_copyable }}">
                                      <i class="fas fa-edit"></i> Sunting
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
              </div>
            </div>
</div>

<!-- Modal create status anggaran -->
<div class="modal fade" tabindex="-1" role="dialog" id="statusAnggaranModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat Status Anggaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form action="{{ route('admin.status_anggaran.store') }}" class="form" method="POST">
            @csrf
            <div class="form-group">
              <label>Status Anggaran</label>
              <input type="text" name="status_anggaran" class="form-control" value="{{ old('status_anggaran') }}" placeholder="Status Anggaran">
            </div>
            <div class="form-group">
              <select name="status_perubahan" class="form-control">
                <option value="MURNI">MURNI</option>
                <option value="PERUBAHAN">PERUBAHAN</option>
              </select>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="salin" id="salin1" value="true" checked>
              <label class="form-check-label" for="salin1">
                Dapat Disalin
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="salin" id="salin2" value="false">
              <label class="form-check-label" for="salin2">
                Tidak Dapat Disalin
              </label>
            </div>
          </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="get-rekening">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal edit status anggaran -->
<div class="modal fade" tabindex="-1" role="dialog" id="editStatusAnggaranModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sunting Status Anggaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <form action="{{ route('admin.status_anggaran.update') }}" class="form" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="form-id" value="">

            <div class="form-group">
              <label>Status Anggaran</label>
              <input type="text" id="form-status-anggaran" name="status_anggaran" class="form-control" value="{{ old('status_anggaran') }}" placeholder="Status Anggaran">
            </div>
            <div class="form-group">
              <select name="status_perubahan" id="form-status-perubahan" class="form-control">
                <option value="MURNI">MURNI</option>
                <option value="PERUBAHAN">PERUBAHAN</option>
              </select>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="salin" id="salin-true" value="true" checked>
              <label class="form-check-label" for="salin-true">
                Dapat Disalin
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="salin" id="salin-false" value="false">
              <label class="form-check-label" for="salin-false">
                Tidak Dapat Disalin
              </label>
            </div>
          </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" id="get-rekening">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
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
      const statusAnggaran = $(this).attr('data-status-anggaran');
      const statusPerubahan = $(this).attr('data-status-perubahan');
      const salin = $(this).attr('data-salin');

      $('#form-id').val(id);
      $('#form-status-anggaran').val(statusAnggaran);
      $(`#form-status-perubahan option[value="${statusPerubahan}"]`).attr('selected', true);

      if (salin == 1) {
        $('#salin-true').prop('checked', true);
        $('#salin-false').prop('checked', false);
      } else {
        $('#salin-true').prop('checked', false);
        $('#salin-false').prop('checked', true);
      }
    }); 
  });
</script>
@endsection