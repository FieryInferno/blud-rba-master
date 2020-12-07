@extends('layouts.admin')

@section('css')
  <link rel="stylesheet" href="{{ asset('dashboard/css/datatable-1.10.20.min.css') }}">
@endsection

@section('content')
<div class="main-content">
  <section class="section">

      <form action="{{ route('admin.rka21.update_pak', $rka->id) }}" method="POST" id="form-rka">
      @csrf
      @method('PUT')
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
                    <h4>SUNTING RKA 2.1</h4>
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
                                <select name="unit_kerja" id="unit_kerja" class="form-control">
                                    <option value="">Pilih Unit Kerja</option>
                                    @foreach ($unitKerja as $item)
                                        <option value="{{ $item->kode }}" {{ ($item->kode == $rka->kode_unit_kerja) ? 'selected' : '' }}
                                          >{{ $item->kode }} - {{ $item->nama_unit }}</option>
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
                            <a class="nav-link" id="sumber-dana-tab" data-toggle="tab" href="#sumber_dana" role="tab" aria-controls="sumber-dana" aria-selected="false">
                              Sumber Dana
                            </a>
                          </li>
                          
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <div class="tab-pane active show" id="rincian_anggaran" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                              <div class="col">
                                {{-- <button class="btn btn-primary btn-sm mb-3" type="button" data-toggle="modal" data-target="#akunModal">
                                    <i class="fas fa-plus"></i> Pilih Rekening
                                </button> --}}
                                <table class="table table-rba">
                                  <thead>
                                    <th></th>
                                    <th>Kode Rekening</th>
                                    <th>Uraian</th>
                                    <th>Volume Murni</th>
                                    <th>Satuan Murni</th>
                                    <th>Tarif Murni</th>
                                    <th>Jumlah Murni</th>
                                    <th>Volume PAK</th>
                                    <th>Satuan PAK</th>
                                    <th>Tarif PAK</th>
                                    <th>Jumlah PAK</th>
                                    <th>Realisasi</th>
                                    <th>Jumlah tahun berikutnya</th>
                                    <th>Keterangan</th>
                                  </thead>
                                  <tbody>
                                    @foreach ($akunParent->where('kode_akun', '<=', $maxKodeAkun) as $item)
                                      <tr>
                                        <td><button type="button" class="btn btn-sm btn-default is-parent d-none parent-item"></button></td>
                                        <td>{{ $item->kode_akun }}</td>
                                        <td>{{ $item->nama_akun }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      </tr>
                                      
                                      @foreach ($rka->rincianAnggaran->groupBy('akun_id') as $key => $anggaran)
                                        @foreach ($anggaran as $index => $rincian)
                                          @if ($rincian->akun_id == $item->id)
                                            <tr>
                                              <td><button type="button" class="btn btn-remove btn-sm btn-danger d-none"><i class="fas fa-minus"></i></button></td>
                                              <td><input type="text" name="kode_rekening[]" class="form-control" value="{{ $rincian->akun->kode_akun }}" readonly></td>
                                              <td><input type="text" name="uraian[]" class="form-control" readonly value="{{ $rincian->uraian }}"></td>
                                              <td><input type="text" name="volume[]" class="form-control" readonly onkeyup="typingVolume(event)" value="{{ $rincian->volume }}"></td>
                                              <td><input type="text" name="satuan[]" class="form-control" readonly value="{{ $rincian->satuan }}"></td>
                                              <td><input type="text" name="tarif[]" class="form-control money" readonly onkeyup="typingTarif(event)" value="{{ $rincian->tarif }}"></td>
                                              <td><input type="text" name="jumlah[]" class="form-control" readonly readonly value="{{ ($rincian->volume * $rincian->tarif) }}"></td>
                                              <td><input type="text" name="volume_pak[]" class="form-control" onkeyup="typingVolumePak(event)" value="{{ $rincian->volume_pak }}"></td>
                                              <td><input type="text" name="satuan_pak[]" class="form-control" value="{{ $rincian->satuan_pak }}"></td>
                                              <td><input type="text" name="tarif_pak[]" class="form-control money" onkeyup="typingTarifPak(event)" value="{{ $rincian->tarif_pak }}"></td>
                                              <td><input type="text" name="jumlah_pak[]" class="form-control" readonly value="{{ ($rincian->volume_pak * $rincian->tarif_pak) }}"></td>
                                              <td><input type="text" name="realisasi[]" class="form-control" readonly></td>
                                              <td><input type="text" name="jumlah_tahun[]" class="form-control" readonly></td>
                                              <td><input type="text" name="keterangan[]" class="form-control"></td>
                                            </tr>
                                          @endif
                                        @endforeach
                                      @endforeach
                                    @endforeach
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
                                      <th>Jumlah Murni</th>
                                      <th>Jumlah PAK</th>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                                <p id="total-sumber-dana-murni" class="text-right font-weight-bold"></p>
                                <p id="total-sumber-dana-pak" class="text-right font-weight-bold"></p>
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
      initMaskMoney();
      $('.money, input[name="tarif[]"], input[name="jumlah[]"], input[name="tarif_pak[]"], input[name="jumlah_pak[]"]').each(function () {
        let value = $(this).val();
        $(this).attr('value', rupiah(value));
      });

      // init pejabat unit
      $.ajax({
        url : "{{ route('admin.pejabatunit.data') }}",
        type : "POST",
        data : "kode_unit_kerja="+$('#unit_kerja option:selected').val(),
        success:function(response){
          var dropdownPejabat = $('#pejabat_unit_kerja');
          dropdownPejabat.empty();
          if (response.total_data > 0){
            $(response.data).each(function () {
                $("<option />", {
                    val: this.id,
                    text: this.nama_pejabat,
                    selected: this.id == '{{ $rka->pejabat_id }}' ? true : false
                }).appendTo(dropdownPejabat);
            });
          }
        }, error:function(jqXHR, exception){
          console.log(jqXHR);
        }
      })

      const parents = [];
       $.ajax({
          type: "POST",
          url: "{{ route('admin.akun.parent') }}",
          data: "tipe=4",
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

      $('#form-rka').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
          type: "POST",
          url: "{{ route('admin.rka21.update_pak', $rka->id) }}",
          data: formData,
          beforeSend:function() {
            $("#buttonSubmit").prop('disabled', true);
          },
          success:function(response){
            iziToast.success({
              title: 'Sukses!',
              message: 'RKA berhasil disimpan',
              position: 'topRight',
              timeout: 1000,
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
          {data: 'Volume Murni'},
          {data: 'Satuan Murni'},
          {data: 'Tarif Murni'},
          {data: 'Jumlah Murni'},
          {data: 'Volume PAK'},
          {data: 'Satuan PAK'},
          {data: 'Tarif PAK'},
          {data: 'Jumlah PAK'},
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
            { width: 150, targets: 8 },
            { width: 150, targets: 9 },
            { width: 150, targets: 10 },
            { width: 150, targets: 11 },
            { width: 150, targets: 12 },
            { width: 100, targets: 13 },
          ],
          fixedColumns: true,
          display : true
      });

      // event get rekening
      $('#get-rekening').click(function () {
        let rekening = [];
        $('.table-rekening input:checked').each(function() {
          rekening.push({
            id: $(this).closest('tr').attr('data-id'),
            kode: $(this).closest('tr').attr('data-kode-rekening'),
            nama: $(this).closest('tr').attr('data-nama-rekening'),
          });
        });

        tableRBA.clear().draw();

        let data = [];

        data.push(...parents);
        rekening.forEach(function (item) {
          data.push(...[
            {
              '': '<button type="button" class="btn btn-add btn-sm btn-primary is-parent parent-item"><i class="fas fa-plus"></i></button>',
              'Kode Rekening': item.kode,
              'Uraian': item.nama,
              'Volume Murni': '',
              'Satuan Murni': '',
              'Tarif Murni': '',
              'Jumlah Murni': '',
              'Volume PAK': '',
              'Satuan PAK': '',
              'Tarif PAK': '',
              'Jumlah PAK': '',
              'Realisasi': '',
              'Jumlah Tahun Berikutnya': '',
              'Keterangan': '',
            },
            {
              '': '<button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>',
              'Kode Rekening': `<input type="text" name="kode_rekening[]" class="form-control" value="${item.kode}" readonly>`,
              'Uraian': '<input type="text" name="uraian[]" class="form-control">',
              'Volume Murni': '<input type="text" name="volume[]" class="form-control" onkeyup="typingVolume(event)" value="0">',
              'Satuan Murni': '<input type="text" name="satuan[]" class="form-control">',
              'Tarif Murni': '<input type="text" name="tarif[]" class="form-control money" onkeyup="typingTarif(event)" value="0">',
              'Jumlah Murni': '<input type="text" name="jumlah[]" class="form-control" readonly>',
              'Volume PAK': '<input type="text" name="volume_pak[]" class="form-control" onkeyup="typingVolumePak(event)" value="0">',
              'Satuan PAK': '<input type="text" name="satuan_pak[]" class="form-control">',
              'Tarif PAK': '<input type="text" name="tarif_pak[]" class="form-control money" onkeyup="typingTarifPak(event)" value="0">',
              'Jumlah PAK': '<input type="text" name="jumlah_pak[]" class="form-control" readonly>',
              'Realisasi': '<input type="text" name="realisasi[]" class="form-control" readonly>',
              'Jumlah Tahun Berikutnya': '<input type="text" name="jumlah_tahun[]" class="form-control" readonly>',
              'Keterangan': '<input type="text" name="keterangan[]" class="form-control">',
            }
          ]);
        });

        tableRBA.rows.add(data).draw();
        $('#akunModal').modal('hide');
        initMaskMoney();
      });

      // add item
      $('.table-rba tbody').on('click', '.btn-add', function () {
        let tr = $(this).closest('tr');
        let index = tableRBA.row(tr).index();
        let kode = $(tr).children().eq(1).text();
        let element = `
            <tr class="text-dark">
              <td>
                <button type="button" class="btn btn-remove btn-sm btn-danger"><i class="fas fa-minus"></i></button>
              </td>
              <td>
                <input type="text" name="kode_rekening[]" class="form-control" value="${kode}" readonly>
              </td>
              <td>
                <input type="text" name="uraian[]" class="form-control">
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
                <input type="text" name="volume_pak[]" class="form-control" onkeyup="typingVolumePak(event)" value="0">
              </td>
              <td>
                <input type="text" name="satuan_pak[]" class="form-control">
              </td>
              <td>
                <input type="text" name="tarif_pak[]" class="form-control money" onkeyup="typingTarifPak(event)" value="0">
              </td>
              <td>
                <input type="text" name="jumlah_pak[]" class="form-control" readonly>
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
          let totalMurni = 0;
          let totalPAK = 0;
          let rows = $('.table-rba tbody tr');
          rows.each(function () {
            if ($(this).find('td button').hasClass('parent-item')) {
              let kodeRekening = $(this).children('td').eq(1).text();
              let namaRekening = $(this).children('td').eq(2).text();

              $('.table-rba tbody').find(`input[name="kode_rekening[]"][value="${kodeRekening}"]`).each(function () {
                let jumlahPAK = parseInt(
                              $(this).closest('tr').find('td input[name="jumlah_pak[]"]').val()
                                .replace(/,.*|[^0-9]/g, ''), 10
                            );
                let jumlahMurni = parseInt(
                              $(this).closest('tr').find('td input[name="jumlah[]"]').val()
                                .replace(/,.*|[^0-9]/g, ''), 10
                            );
                if (Number.isNaN(jumlahPAK)) jumlahPAK = 0;
                if (Number.isNaN(jumlahMurni)) jumlahMurni = 0;

                totalMurni += jumlahMurni
                totalPAK += jumlahPAK
                let i = sumberDana.findIndex(function (item) {
                  return item.kodeRekening == kodeRekening
                });

                if (i < 0) {
                  sumberDana.push({
                    kodeRekening: kodeRekening,
                    namaRekening: namaRekening,
                    jumlahMurni: jumlahMurni,
                    jumlahPAK: jumlahPAK,
                  });
                } else {
                  sumberDana[i].jumlahMurni += jumlahMurni;
                  sumberDana[i].jumlahPAK += jumlahPAK;
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
                    <select class="form-control" name="sumber_dana[]" readonly>
                      <option value="1" selected>BLUD</option>
                    </select>
                </td>
                <td><input type="text" name="nominal[]" value="${rupiah(item.jumlahMurni)}" class="form-control" readonly></td>
                <td><input type="text" name="nominal_pak[]" value="${rupiah(item.jumlahPAK)}" class="form-control" readonly></td>
              </tr>
            `);
          });

          $('#total-sumber-dana-murni').text(`Total Murni: Rp. ${rupiah(totalMurni)}`);
          $('#total-sumber-dana-pak').text(`Total PAK: Rp. ${rupiah(totalPAK)}`);
        });
    });

    function typingVolume(event) {
      let tr = $(event.srcElement).closest('tr');
      let volume = parseInt($(event.srcElement).val());
      let tarif = parseInt(
                    $(tr).children('td').find('input[name="tarif[]"]').val()
                      .replace(/,.*|[^0-9]/g, ''), 10
                  );
      if (Number.isNaN(tarif)) tarif = 0;
      let jumlah = volume * tarif;

      if (! Number.isInteger(volume)) {
        $(tr).children('td').find('input[name="jumlah[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah[]"]').val(rupiah(jumlah));
      }
    }

    function typingTarif(event) {
      let tr = $(event.srcElement).closest('tr');
      let tarif = parseInt($(event.srcElement).val().replace(/,.*|[^0-9]/g, ''), 10);
      let volume = parseInt($(tr).children('td').find('input[name="volume[]"]').val());
      let jumlah = volume * tarif;
      if (! Number.isInteger(tarif)) {
        $(tr).children('td').find('input[name="jumlah[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah[]"]').val(rupiah(jumlah));
      }
    }

    function typingVolumePak(event) {
      let tr = $(event.srcElement).closest('tr');
      let volume = parseInt($(event.srcElement).val());
      let tarif = parseInt(
                    $(tr).children('td').find('input[name="tarif_pak[]"]').val()
                      .replace(/,.*|[^0-9]/g, ''), 10
                  );
      if (Number.isNaN(tarif)) tarif = 0;
      let jumlah = volume * tarif;

      if (! Number.isInteger(volume)) {
        $(tr).children('td').find('input[name="jumlah_pak[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah_pak[]"]').val(rupiah(jumlah));
      }
    }

    function typingTarifPak(event) {
      let tr = $(event.srcElement).closest('tr');
      let tarif = parseInt($(event.srcElement).val().replace(/,.*|[^0-9]/g, ''), 10);
      let volume = parseInt($(tr).children('td').find('input[name="volume_pak[]"]').val());
      let jumlah = volume * tarif;

      if (! Number.isInteger(tarif)) {
        $(tr).children('td').find('input[name="jumlah_pak[]"]').val(0)
        return;
      } else {
        $(tr).children('td').find('input[name="jumlah_pak[]"]').val(rupiah(jumlah));
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