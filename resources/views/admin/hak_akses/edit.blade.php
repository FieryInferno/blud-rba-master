@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

    <form action="{{ route('admin.hak_akses.update', $role->id) }}" method="POST">
      @method('PUT')
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
                    <h4>ATUR ROLE & PERMISSIONS</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Nama Role</label>
                      <input type="text" class="form-control" value="{{ $role->role_name }}" readonly>
                    </div>

                    <div class="form-group">
                      <label>Permissions</label>
                      @foreach ($permissions as $item)
                        <div class="form-check my-2">
                          <input class="form-check-input" type="checkbox"
                            name="permissions[]"
                            value="{{ $item->id }}" id="{{ $item->permission_name }}"
                            {{ $role->hasPermission($item->permission_name) ? 'checked' : '' }}
                            >
                          <label class="form-check-label" for="{{ $item->permission_name }}">
                            {{ ucwords($item->permission_name) }}
                          </label>
                        </div>
                      @endforeach
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