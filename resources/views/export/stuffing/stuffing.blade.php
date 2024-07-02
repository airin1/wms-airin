@extends('layout')

@section('content')


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Stuffing</h3>
        <div class="box-tools">
            <button id="manifestStuffing" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Add Manifest</button>
        </div>
    </div>
    <div class="box-body table-responsive">    
   
    <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Action</th>
                    <th>No Pack</th>
                    <th>Tgl Packing</th>
                    <th>Tgl Stuffing</th>
                    <th>Jam Stuffing</th>
                    <th>Bruto</th>
                    <th>Kode Dokumen</th>
                    <th>Nomor Dokumen</th>
                    <th>Tanggal Dokumen</th>
                    <th>Pelabuhan Bongkar</th>
                    <th>Consignee</th>
                    <th>UID</th>
                </tr>
              </thead>
              <tbody>
                @foreach($Listbarang as $man)
                <tr>
                  <!-- <td> <a class="btn btn-outline-warning btn-sm" href="{{ route('exp-register-edit', $man->TJOBORDER_PK) }}"><i class="fa fa-pencil"></i></a>
                  <button type="button" id="print-barcode-btn" data-job-order="{{$man->TJOBORDER_PK}}" class="btn btn-danger btn-sm" style="margin: 10px;"><i class="fa fa-print"></i></button> -->
                
                  <td>
                    <div class="row"> 
                      <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-danger btn-xs unStuffing" style="margin: 10px;">Cancel</button>
                      <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-warning btn-xs UploadTPS" style="margin: 10px;">Upload TPS</button>
                    </div>
                  </td>
                  <td>{{$man->NO_PACK}}</td>
                  <td>{{$man->TGL_PACK}}</td>
                  <td>{{$man->tglstufing}}</td>
                  <td>{{$man->jamstufing}}</td>
                  <td>{{$man->WEIGHT}}</td>
                  @if($man->KODE_DOKUMEN == '6')
                      <td>NPE</td>
                      @elseif($man->KODE_DOKUMEN == '37')
                      <td>ATA CARNET Ekspor</td>
                      @elseif($man->KODE_DOKUMEN == '38')
                      <td>CPD CARNET Ekspor</td>
					   @elseif($man->KODE_DOKUMEN == '8')
                      <td>PBB</td>
					   @elseif($man->KODE_DOKUMEN == '5')
                      <td>SPPF</td>
					    @elseif($man->KODE_DOKUMEN == '28')
                      <td>BC 1.2</td>
					   @elseif($man->KODE_DOKUMEN == '45')
                      <td>NPP3BET</td>
                      @else
                      <td>Dokumen Belum Tersedia</td>
                  @endif
				  
                  <td>{{$man->NO_NPE}}</td>
                  <td>{{$man->TGL_NPE}}</td>
                  <td>{{$man->PEL_BONGKAR}}</td>
                  <td>{{$man->CONSIGNEE}}</td>
                  <td>{{$man->UID}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
    </div>
</div>

<div id="manifestStuffing-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> </h4>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Barang</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="barang" name="TMANIFEST_PK[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                        @foreach($barang as $barang)
                                            <option value="{{$barang->TMANIFEST_PK}}">{{$barang->NO_PACK}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input id="idCont" name="TCONTAINER_PK" type="hidden" value="{{$container->TCONTAINER_PK}}" />
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Tanggal</label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control" id="tanggal" name="tglstufing">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Jam</label>
                                <div class="col-sm-8">
                                    <input type="time" class="form-control" id="jam" name="jamstufing">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                    <button type="submit" class="btn btn-primary addManifest">Upload</button>
                </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('custom_js')
<script>
     $('select').select2();
</script>
<script>
$('#manifestStuffing').on("click", function(){
    $('#manifestStuffing-modal').modal('show');
});
</script>

<script>
     $(document).on('click', '.unStuffing', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Yakin membatalkan proses stuffing?",
          icon: 'warning',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Confirm',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            $.ajax({
              type: 'POST',
              url: "{{ route('stuffing-cancel') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function(response) {
               
              },
            });

          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }


        })

      });
</script>

<script>
      $(document).on('click', '.addManifest', function(e) {
        e.preventDefault();
        var id = $('#idCont').val();
        var TMANIFEST_PK = $('#barang').val();
        var tglstufing = $('#tanggal').val();
        var jamstufing = $('#jam').val();
        var data ={
            'id' : $('#idCont').val(),
            'TMANIFEST_PK' : $('#barang').val(),
            'tglstufing' : $('#tanggal').val(),
            'jamstufing' : $('#jam').val(),
        }
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Yakin membatalkan proses stuffing?",
          icon: 'warning',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Confirm',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            $.ajax({
              type: 'POST',
              url: "{{ route('stuffing-prosses') }}",
              data: data,
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function(response) {
               
              },
            });

          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }


        })

      });
</script>

<script>
     $(document).on('click', '.UploadTPS', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "",
          icon: 'warning',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Confirm',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            $.ajax({
              type: 'POST',
              url: "{{ route('upload-TPS-Stuffing') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                } else {
                  Swal.fire('Error', response.message, 'error');
                }
              },
              error: function(response) {
               
              },
            });

          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }


        })

      });
</script>

@endsection