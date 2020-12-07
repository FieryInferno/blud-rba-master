@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <div class="section-body">
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
            
              <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>SUNTING PROFILE</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link  active show" id="profile-tab" data-toggle="tab" href="#profile_tab" role="tab" aria-controls="profile" aria-selected="false">
                            Data
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" data-toggle="tab" id="password-tab" href="#password_tab" role="tab" aria-controls="password" aria-selected="false">
                            Ubah Password
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content" id="myTabContent">
                          <div class="tab-pane active show" id="profile_tab" role="tabpanel" aria-labelledby="profile-tab">
                              <form action="{{ route('admin.users.update_profile') }}" method="POST">
                                  @csrf
                                  @method('PUT')
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->name) }}">
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label>Username & Email</label>
                                  <div class="row">
                                      <div class="col-sm-4">
                                        <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}" placeholder="Username">
                                      </div>
                                      <div class="col-sm-8">
                                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
                                      </div>
                                  </div>                      
                              </div>
                              <div class="form-group">
                                  <div class="row">
                                      <div class="col">
                                          <label>Unit Kerja</label>
                                          <select name="unit_kerja" id="unit_kerja" class="form-control">
                                              <option value="">Pilih Unit Kerja</option>
                                              @foreach ($unitKerja as $item)
                                                  <option value="{{ $item->kode }}" {{ $user->kode_unit_kerja == $item->kode ? 'selected' : '' }}>{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                    <div class="form-check ml-3">
                                      <input class="form-check-input" type="radio" name="role" id="puskesmas" value="2" {{ $user->role_id == 2 ? 'checked' : '' }}>
                                      <label class="form-check-label" for="puskesmas">
                                        Puskesmas
                                      </label>
                                    </div>
                                    <div class="form-check ml-3">
                                      <input class="form-check-input" type="radio" name="role" id="admin" value="1" {{ $user->role_id == 1 ? 'checked' : '' }}>
                                      <label class="form-check-label" for="admin">
                                        Admin
                                      </label>
                                    </div>
                                </div>
                              </div>
          
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                          </div>
                          <div class="tab-pane fade" id="password_tab" role="tabpanel" aria-labelledby="password">
                              <form action="{{ route('admin.users.profile_password') }}" method="POST">
                                  @csrf
                                  @method('PUT')
                              <div class="form-group">
                                  <label>Password</label>
                                  <div class="row">
                                      <div class="col-sm-4">
                                        <input type="password" class="form-control" name="password" value="" placeholder="Password">
                                      </div>
                                      <div class="col-sm-8">
                                        <input type="password" class="form-control" name="password_confirmation" value="" placeholder="Konfirmasi Password">
                                      </div>
                                  </div>                      
                              </div>
          
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                          </div>
                        </div>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </section>
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
  });
</script>
@endsection