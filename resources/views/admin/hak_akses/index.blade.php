@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Hak Akses</h1>
      </div>

      <div class="section-body">
          <div class="row">
              <div class="col-md-12">
                @if ($message = Session::get('success'))
                  <div class="alert alert-success">
                    {{ $message }}
                  </div>
                @endif

                  <div class="card">
                      <div class="card-header">
                        <h4>Data Roles</h4>
                      </div>
                      <div class="card-body">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Nama Role</th>
                              <th>Opsi</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($roles as $item)
                              <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->role_name }}</td>
                                <td>
                                  <a href="{{ route('admin.hak_akses.edit', $item->id) }}" class="btn btn-sm btn-warning btn-edit"">
                                    <i class="fas fa-cog"></i> Atur
                                  </a>
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
@endsection

@section('js')
<script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>