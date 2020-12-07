@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap-datepicker.standalone.min.css') }}">
@endsection
@section('content')

<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Laporan </h1>
      </div>

      <div class="section-body">
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
          <div class="row">
               <div class="col-md-12">
                  <div class="card">
                      <div class="card-header">
                        <h4>Cetak Laporan APBD</h4>
                      </div>
                    <form action="{{ route('admin.report.print') }}" method="POST" id="form-rba">
                    @csrf
                      <div class="card-body">
                          <div class="form-group">
                            <label>Tanggal Pelaporan</label>
                            <input type="text" placeholder="Tanggal pelaporan" autocomplete="off" name="tanggal" id="date" class="form-control datepicker">
                          </div>
                          <div class="form-group">
                              <label>Unit Kerja</label>
                              <select name="unit_kerja" class="form-control">
                                  <option value="">Pilih Unit Kerja</option>
                                  @foreach ($unitKerja as $item)
                                      <option value="{{ $item->kode }}">{{ $item->nama_unit }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">
                                  <i class="fas fa-file-alt"></i>
                                  Cetak Laporan
                                </button>
                          </div>
                      </div>
                    </form>
                  </div>
               </div>
          </div>
      </div>
  </section>
</div>

@endsection
@section('js')
  <script src="{{ asset('dashboard/js/bootstrap-datepicker.min.js') }}"></script>
  <script>
      $("#date").datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        orientation: 'bottom',
      });
      $("#date").datepicker('update', '{{ date('d-m-Y') }}');

  </script>
@endsection