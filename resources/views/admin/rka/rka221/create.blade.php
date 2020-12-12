@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">
    
    <form action="{{ route('admin.rba2.store') }}" method="POST" id="form-rba">
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
                    <h4>BUAT RKA 2.2.1</h4>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                        <label>OPD</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="1.02.01" name="kode_opd" readonly>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="DINAS KESEHATAN" readonly>
                            </div>
                        </div>                      
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Unit Kerja</label>
                                <select name="unit_kerja" id="unit_kerja" class="form-control" {{ (auth()->user()->hasRole('Puskesmas') ? 'readonly' : '') }}>
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerja as $item)
                                        <option value="{{ $item->kode }}"
                                          {{ (auth()->user()->hasRole('Puskesmas') ? 'selected' : '') }}>{{ $item->kode }} - {{ $item->nama_unit }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label>Pejabat Unit Kerja</label>
                                <select name="pejabat_unit" id="pejabat_unit_kerja" class="form-control">
                                    <option value="">Pilih Pejabat Unit Kerja</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col">
                          <label>Sub Kegiatan</label>
                          <select name="subKegiatan" id="subKegiatan" class="form-control">
                            <option value="" selected>Pilih Sub Kegiatan</option>
                            @foreach ($mapSubKegiatan as $kegiatan)
                              <option value="{{ $kegiatan->idMapSubKegiatan }}">{{ $kegiatan->subKegiatanApbd->namaSubKegiatan }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                          <div class="col">
                              <label>Sasaran Kegiatan</label>
                              <input type="text" class="form-control" name="sasaran_kegiatan">
                          </div>
                      </div>
                  </div>
                  </div>
                </div>
               
                  <div class="card" style="min-height:400px">
                    <div class="card-header">
                      <h4>Rincian RKA</h4>
                    </div>
                    <div class="card-body">
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link  active show" id="home-tab" data-toggle="tab" href="#rincian_anggaran" role="tab" aria-controls="home" aria-selected="false">
                            Rincian Anggaran
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="indikator-tab" data-toggle="tab" href="#indikator" role="tab" aria-controls="sumber-dana" aria-selected="false">
                            Indikator Kerja
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" id="sumber-dana-tab" data-toggle="tab" href="#sumber_dana" role="tab" aria-controls="sumber-dana" aria-selected="false">
                            Sumber Dana
                          </a>
                        </li>
                        
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="indikator" role="tabpanel" aria-labelledby="indikator-tab">
                          <div class="row">
                            <div class="col">
                              <table class="table table-indikator">
                                <thead>
                                  <th>Jenis Indikator</th>
                                  <th>Tolak Ukur Kinerja</th>
                                  <th>Target Kinerja</th>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><input type="text" class="form-control" name="jenis_indikator[]" value="Input" readonly></td>
                                    <td><input type="text" class="form-control" name="tolak_ukur_kinerja[]" value=""></td>
                                    <td><input type="text" class="form-control" name="target_kinerja[]" value=""></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" class="form-control" name="jenis_indikator[]" value="Output" readonly></td>
                                    <td><input type="text" class="form-control" name="tolak_ukur_kinerja[]" value=""></td>
                                    <td><input type="text" class="form-control" name="target_kinerja[]" value=""></td>
                                  </tr>
                                  <tr>
                                    <td><input type="text" class="form-control" name="jenis_indikator[]" value="Outcame" readonly></td>
                                    <td><input type="text" class="form-control" name="tolak_ukur_kinerja[]" value=""></td>
                                    <td><input type="text" class="form-control" name="target_kinerja[]" value=""></td>
                                  </tr>
                                </tbody>
                              </table>
                              
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                          <div class="row">
                            <div class="col">
                              <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                  <i class="fas fa-plus"></i> Pilih Rekening
                              </button>
                              <table class="table table-rba">
                                <thead>
                                    <th></th>
                                    <th>Kode Rekening</th>
                                    <th>Uraian</th>
                                    <th>Volume</th>
                                    <th>Satuan</th>
                                    <th>Tarif</th>
                                    <th>Jumlah</th>
                                    <th>Realisasi</th>
                                    <th>Jumlah tahun berikutnya</th>
                                    <th>Keterangan</th>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                              </table>
                              
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="sumber_dana" role="tabpanel" aria-labelledby="sumber-dana-tab">
                          <div class="row">
                            <div class="col">
                              <table class="table table-sumber-dana">
                                <thead>
                                    <th>Kode Rekening</th>
                                    <th>Nama Rekening</th>
                                    <th>Sumber Dana</th>
                                    <th>Jumlah Total</th>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                              <p id="total-sumber-dana" class="text-right font-weight-bold"></p>
                              <button type="submit" id="buttonSubmit" class="btn btn-primary mt-3">
                                <i class="fa fa-save"></i>
                                Simpan
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                  </div>
              </div>

              
          </div>
      </div>
  </section>
  </form>
</div>
<!-- Modal akun / rekening -->
<div class="modal fade" tabindex="-1" role="dialog" id="akunModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Akun </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <table class="table table-rekening"  style="width:100%">
              <thead>
                <tr>
                  <th></th>
                  <th>Kode Rekening</th>
                  <th>Nama Rekening</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($akun as $item)
                  <tr class="text-dark {{ ($item->is_parent) ? 'table-primary' : '' }}"
                    data-id="{{ $item->id }}"
                    data-kode-rekening="{{ $item->kode_akun }}"
                    data-nama-rekening="{{ $item->nama_akun }}">
                      <td>
                        @if (!$item->is_parent)
                          <input type="checkbox" name="rekening" value="{{ $item->id }}">
                        @endif
                      </td>
                      <td>{{ $item->kode_akun }}</td>
                      <td>{{ $item->nama_akun }}</td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="get-rekening">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection
@section('js')
  <script src="{{ asset('dashboard/js/datatable-1.10.20.min.js') }}"></script>
  <script>
    $(document).ready(function () {
      $.ajax({
        url : "{{ route('admin.pejabatunit.data') }}",
        type : "POST",
        data : "kode_unit_kerja="+$('#unit_kerja option:selected').val(),
        success:function(response) {
          var dropdownPejabat = $('#pejabat_unit_kerja');
          dropdownPejabat.empty();
          if (response.total_data > 0){
            $(response.data).each(function () {
                $("<option />", {
                    val: this.id,
                    text: this.nama_pejabat
                }).appendTo(dropdownPejabat);
            });
          }
        }, error:function(jqXHR, exception){
          console.log(jqXHR);
        }
      })

      @if (auth()->user()->hasRole('Puskesmas'))
        $.ajax({
          url: "{{ route('admin.mapkegiatan.data') }}",
          type: "POST",
          data: "kode_unit_kerja="+$('#unit_kerja option:selected').val()+"&kode=rba",
          success:function(response){
            var dropdownKegiatan = $('#kegiatan');
            dropdownKegiatan.empty();
            if (response.total_data > 0){
              $(response.data).each(function () {
                  $("<option />", {
                      val: this.id,
                      text: this.blud.nama_kegiatan
                  }).appendTo(dropdownKegiatan);
              });
            }
          }, error:function(jqXHR, exception){
            console.log(jqXHR);
          }
        })
      @endif

      var kodes = [];
      var rekeningSSH = [];

      $('.table-rekening').DataTable({
          paging: false,
          info: false,
          ordering: false,
        });

      const parents = [];
       $.ajax({
          type: "POST",
          url: "{{ route('admin.akun.parent') }}",
          data: "tipe=5&kelompok=2",
          success: function(response) {
            response.data.forEach(function (item) {
              parents.push({
                '': '<button type="button" class="btn btn-sm btn-default is-parent d-none"></button>',
                'Kode Rekening': item.kode_akun,
                'Uraian': item.nama_akun,
                'Volume': '',
                'Satuan': '',
                'Tarif': '',
                'Jumlah': '',
                'Realisasi': '',
                'Jumlah Tahun Berikutnya': '',
                'Keterangan': '',
              });
            });
          }
      });

      var sumberDanaRba = [];
      $.get("{{ route('admin.sumberdana.data') }}", function (response, status) {
         response.data.forEach(function (item) {
           sumberDanaRba.push({
             id : item.id,
             nama_sumber_dana : item.nama_sumber_dana
           })
         });
      });

      $('#form-rba').on('submit', function (e) {
        e.preventDefault();
       var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "{{ route('admin.rka221.save') }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            iziToast.success({
              title: 'Sukses!',
              message: 'RKA berhasil disimpan',
              position: 'topRight',
              timeout: 2000,
              onClosed: function () {
                window.location.href = document.referrer
              }
            });
          },
          error:function (data, jqXHR) {
            let errors = [];
            let validationMessages = data.responseJSON.errors;
            for (var property in validationMessages) {
              if (validationMessages.hasOwnProperty(property)) {
                errors.push(validationMessages[property][0]);
              }
            }

            iziToast.error({
              title: 'Gagal!',
              message: errors.toString(),
              position: 'topRight'
            });

            $("#buttonSubmit").prop('disabled', false);
          }
        })
      });

      const tableRBA = $('.table-rba').DataTable({
        createdRow: function( row, data, dataIndex ) {
            if ($(row).find('button').hasClass('is-parent')) {
              $('.table-rekening input:checked').each(function (item) {
                let kode = $(this).closest('tr').attr('data-kode-rekening');
              });

              $(row).addClass('table-primary');
            }

          $(row).addClass('text-dark');
        },
        // scrollY: "600px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        info: false,
        bFilter: false,
        ordering: false,
        columns:[
          {data: ''},
          {data: 'Kode Rekening'},
          {data: 'Uraian'},
          {data: 'Volume'},
          {data: 'Satuan'},
          {data: 'Tarif'},
          {data: 'Jumlah'},
          {data: 'Realisasi'},
          {data: 'Jumlah Tahun Berikutnya'},
          {data: 'Keterangan'}
        ],
         columnDefs: [
              { width: 120, targets: 1 },
              { width: 400, targets: 2 },
              { width: 150, targets: 3 },
              { width: 150, targets: 4 },
              { width: 150, targets: 5 },
              { width: 150, targets: 6 },
              { width: 100, targets: 7 },
              { width: 200, targets: 8 },
              { width: 300, targets: 9 },
          ],
          fixedColumns: true,
          display : true
      });

      // event get rekening
      $('#get-rekening').click(function () {
        let rekening = [];
        rekeningSSH = [];
        $('.table-rekening input:checked').each(function() {
          rekening.push({
            id: parseInt($(this).closest('tr').attr('data-id')),
            kode_akun: $(this).closest('tr').attr('data-kode-rekening'),
            nama_akun: $(this).closest('tr').attr('data-nama-rekening'),
            is_parent: 0
          });
        });

        tableRBA.clear().draw();

        let data = [];

        kodes = rekening.map(function (item) {
          return item.kode_akun;
        });

        $.ajax({
            type: "POST",
            url: "{{ route('admin.akun.5.rka') }}",
            data: { rekening: rekening },
            dataType: "json",
            success: function(response) {
              rekeningSSH = [...response.data.akun];
              response.data.akun.forEach(function (item) {
                if (item.is_parent == 0){
                  data.push(...[
                    {
                      '': '<button type="button" class="btn btn-add btn-sm btn-primary is-parent parent-item"><i class="fas fa-plus"></i></button>',
                      'Kode Rekening': item.kode_akun,
                      'Uraian': item.nama_akun,
                      'Volume': '',
                      'Satuan': '',
                      'Tarif': '',
                      'Jumlah': '',
                      'Realisasi': '',
                      'Jumlah Tahun Berikutnya': '',
                      'Keterangan': '',
                    },
                    {
                      '': '<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>',
                      'Kode Rekening': `<input type="text" name="kode_rekening[]" class="form-control" value="${item.kode_akun}" readonly>`,
                      'Uraian': `<select class="form-control select_ssh" name="uraian[]">
                                  <option value="" disabled selected>-- Pilih Item --</option>
                                  ${item.ssh.map(function (itemSSH) {
                                      return "<option value='"+itemSSH.id+"' data-harga='"+itemSSH.harga+"' data-satuan='"+itemSSH.satuan+"'>"+itemSSH.nama_barang+"</option>";
                                  }).join('')}
                                </select>`,
                      'Volume': '<input type="text" name="volume[]" class="form-control" onkeyup="typingVolume(event)" value="0">',
                      'Satuan': '<input type="text" name="satuan[]" class="form-control">',
                      'Tarif': '<input type="text" name="tarif[]" class="form-control money" onkeyup="typingTarif(event)" value="0">',
                      'Jumlah': '<input type="text" name="jumlah[]" class="form-control" readonly>',
                      'Realisasi': '<input type="text" name="realisasi[]" class="form-control" readonly>',
                      'Jumlah Tahun Berikutnya': '<input type="text" name="jumlah_tahun[]" class="form-control" readonly>',
                      'Keterangan': '<input type="text" name="keterangan[]" class="form-control">',
                    }
                  ]);
                }else {
                  data.push(
                    {
                      '': '<button type="button" class="btn btn-add btn-sm btn-primary is-parent d-none"><i class="fas fa-plus"></i></button>',
                      'Kode Rekening': item.kode_akun,
                      'Uraian': item.nama_akun,
                      'Volume': '',
                      'Satuan': '',
                      'Tarif': '',
                      'Jumlah': '',
                      'Realisasi': '',
                      'Jumlah Tahun Berikutnya': '',
                      'Keterangan': '',
                    });
                }

            });
            tableRBA.rows.add(data).draw();
            $('#akunModal').modal('hide');
            initMaskMoney();
          }
        });
      });

      // select option ssh
      $('.table-rba tbody').on('change', '.select_ssh', function () {
        let _this = $(this);
        let volume = parseInt(_this.closest('tr').find('input[name="volume[]"]').val());
        let harga = _this.find('option:selected').attr('data-harga');
        let satuan = _this.find('option:selected').attr('data-satuan');
        let jumlah = volume * harga;
        _this.closest('tr').find('input[name="tarif[]"]').val(formatCurrency(harga));
        _this.closest('tr').find('input[name="satuan[]"]').val(satuan);
        _this.closest('tr').find('input[name="jumlah[]"]').val(formatCurrency(jumlah));
      });

      // add item
      $('.table-rba tbody').on('click', '.btn-add', function () {
        let tr = $(this).closest('tr');
        let index = tableRBA.row(tr).index();
        let kode = $(tr).children().eq(1).text();
        let kodeSSH = rekeningSSH.filter(function (item) {
          return item.kode_akun == kode;
        })[0];
        let element = `
            <tr class="text-dark">
              <td>
                <button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>
              </td>
              <td>
                <input type="text" name="kode_rekening[]" class="form-control" value="${kode}" readonly>
              </td>
              <td>
                <select class="form-control select_ssh" name="uraian[]">
                  <option value="" disabled selected>-- Pilih Item --</option>
                  ${kodeSSH.ssh.map(function (itemSSH) {
                      return "<option value='"+itemSSH.id+"' data-harga='"+itemSSH.harga+"' data-satuan='"+itemSSH.satuan+"'>"+itemSSH.nama_barang+"</option>";
                  }).join('')}
                </select>
              </td>
              <td>
                <input type="text" name="volume[]" class="form-control" onkeyup="typingVolume(event)" value="0">
              </td>
              <td>
                <input type="text" name="satuan[]" class="form-control">
              </td>
              <td>
                <input type="text" name="tarif[]" class="form-control money" onkeyup="typingTarif(event)" value="0">
              </td>
              <td>
                <input type="text" name="jumlah[]" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="realisasi[]" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="jumlah_tahun[]" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="keterangan[]" class="form-control">
              </td>
            </tr>
          `;

        let rowParent = $(tr).nextAll('tr.table-primary').first();
        if (rowParent.length) {
          $(rowParent).before(element);
        } else {
          $('.table-rba tbody').append(element);
        }

        initMaskMoney();
      });

      // remove item
      $('.table-rba tbody').on('click', '.btn-remove', function () {
        $(this).closest('tr').remove();
      });

      // get pejabat unit
      $("#unit_kerja").change(function () {
        $.ajax({
            url : "{{ route('admin.pejabatunit.data') }}",
            type : "POST",
            data : "kode_unit_kerja="+$(this).val(),
            success:function(response){
              var dropdownPejabat = $('#pejabat_unit_kerja');
              dropdownPejabat.empty();
              if (response.total_data > 0){
                $(response.data).each(function () {
                    $("<option />", {
                        val: this.id,
                        text: this.nama_pejabat
                    }).appendTo(dropdownPejabat);
                });
              }
            }, error:function(jqXHR, exception){
              console.log(jqXHR);
            }
          })

          $.ajax({
              url: "{{ route('admin.mapkegiatan.data') }}",
              type: "POST",
              data: "kode_unit_kerja="+$(this).val()+"&kode=rka",
              success:function(response){
                var dropdownKegiatan = $('#kegiatan');
                dropdownKegiatan.empty();
                if (response.total_data > 0){
                  $(response.data).each(function () {
                      $("<option />", {
                          val: this.id,
                          text: this.blud.nama_kegiatan
                      }).appendTo(dropdownKegiatan);
                  });
                }
              }, error:function(jqXHR, exception){
                console.log(jqXHR);
              }
          })
        });

        // sumber dana
        const tableSumberDana = $('.table-sumber-dana').DataTable({
          paging: false,
          info: false,
          bFilter: false,
          ordering: false,
        });

        $('#sumber-dana-tab').click(function () {
          $('.table-sumber-dana tbody').html('');

          let sumberDana = [];
          let total = 0;
          let rows = $('.table-rba tbody tr');
          rows.each(function () {
            if ($(this).find('td button').hasClass('parent-item')) {
              let kodeRekening = $(this).children('td').eq(1).text();
              let namaRekening = $(this).children('td').eq(2).text();

              $('.table-rba tbody').find(`input[name="kode_rekening[]"][value="${kodeRekening}"]`).each(function () {
                let jumlah = parseFloat(
                              $(this).closest('tr').find('td input[name="jumlah[]"]').val()
                                .replace(/\./g, '').replace(',', '.')
                            ).toFixed(2);
                if (Number.isNaN(jumlah)) jumlah = 0;

                total += parseFloat(jumlah)
                let i = sumberDana.findIndex(function (item) {
                  return item.kodeRekening == kodeRekening
                });

                if (i < 0) {
                  sumberDana.push({
                    kodeRekening: kodeRekening,
                    namaRekening: namaRekening,
                    jumlah: parseFloat(jumlah)
                  });
                } else {
                  sumberDana[i].jumlah += parseFloat(jumlah);
                }
              });
            }
          });

          sumberDana.forEach(function (item) {
            $('.table-sumber-dana tbody').append(`
              <tr>
                <td><input type="text" class="form-control" name="kode_rekening_sumber_dana[]" value="${item.kodeRekening}" readonly></td>
                <td>${item.namaRekening}</td>
                <td>
                    <select class="form-control" name="sumber_dana[]">
                      ${sumberDanaRba.map(function (sumberdana) {
                          let checked = '';
                          if (sumberdana.id == 2) checked = 'selected';
                          return "<option value='"+sumberdana.id+"'"+checked+">"+sumberdana.nama_sumber_dana+"</option>";
                      }).join('')}
                    </select>
                </td>
                <td><input type="text" name="nominal[]" value="${formatCurrency(item.jumlah)}" class="form-control" readonly></td>
              </tr>
            `);
          });

          $('#total-sumber-dana').text(`Rp. ${formatCurrency(total)}`);
        });
    });

    function typingVolume(event) {
      let tr = $(event.srcElement).closest('tr');
      let volume = parseInt($(event.srcElement).val());
      let tarif = parseFloat(
                    $(tr).children('td').find('input[name="tarif[]"]').val()
                      .replace(/\./g, '').replace(',', '.')
                  ).toFixed(2);
      if (Number.isNaN(parseFloat(tarif).toFixed(2))) tarif = 0;
      let jumlah = volume * parseFloat(tarif).toFixed(2);

      if (! Number.isInteger(volume)) {
        $(tr).children('td').find('input[name="jumlah[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah[]"]').val(formatCurrency(jumlah));
      }
    }

    function typingTarif(event) {
      let tr = $(event.srcElement).closest('tr');
      let tarif = parseFloat($(event.srcElement).val().replace(/\./g, '').replace(',', '.')).toFixed(2);
      let volume = parseInt($(tr).children('td').find('input[name="volume[]"]').val());
      let jumlah = volume * parseFloat(tarif).toFixed(2);
      if (Number.isNaN(parseFloat(tarif).toFixed(2))) {
        $(tr).children('td').find('input[name="jumlah[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah[]"]').val(formatCurrency(jumlah));
      }
    }

    function initMaskMoney() {
      jQuery(function($){
        $('.money').maskMoney({
          thousands: '.',
          decimal: ',',
          allowZero: true
        });
      });
    }

    function rupiah(angka) {
      var rupiah = '';		
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      return rupiah.split('',rupiah.length-1).reverse().join('') + ',00';
    }

  </script>
@endsection