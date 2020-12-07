@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
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
                    <h4>BUAT PENGGUNA</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                              <label>Nama</label>
                              <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Username & Email</label>
                        <div class="row">
                            <div class="col-sm-4">
                              <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username">
                            </div>
                            <div class="col-sm-8">
                              <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                            </div>
                        </div>                      
                    </div>
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
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Unit Kerja</label>
                                <select name="unit_kerja" id="unit_kerja" class="form-control">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerja as $item)
                                        <option value="{{ $item->kode }}" {{ old('unit_kerja') == $item->kode ? 'selected' : '' }}>{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                          <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="role" id="puskesmas" value="2" checked>
                            <label class="form-check-label" for="puskesmas">
                              Puskesmas
                            </label>
                          </div>
                          <div class="form-check ml-3">
                            <input class="form-check-input" type="radio" name="role" id="admin" value="1">
                            <label class="form-check-label" for="admin">
                              Admin
                            </label>
                          </div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </section>
  </form>
</div>
@endsection