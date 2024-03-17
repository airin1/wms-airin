@extends('layout')
@section('custom_css')

<style>
    .table-container {
        max-height: 500px; /* Set the maximum height for the table */
        overflow-y: auto; /* Enable vertical scrolling if content overflows */
        width: 100%; /* Set the width of the table to 100% */
    }
    /* Optional: If you want to fix the table header */
    .table-container thead {
        position: sticky;
        top: 0;
        background-color: #f4f4f4; /* Set a background color for the header */
    }
    .bg-yellow {
        background-color: yellow;
    }
    .bg-green {
        background-color: green;
    }
</style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Delivery | Release Container</h3>

    </div>
    <div class="box-body">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12 "> 
              <div class="table-container">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th width="300px">Action</th>
                          <th>Status BC</th>
                          <th>No Booking</th>
                          <th>No Container</th>
                          <th>Size</th>
                          <th>Weight</th>
                          <th>Status</th>
                          <th>Jenis Dokumen</th>
                          <th>No Dokumen</th>
                          <th>Tgl. Dokumen</th>
                          <th>No. Truck</th>
                          <th>Tanggal Keluar</th>
                          <th>Jam Keluar</th>
                          <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($container as $cont)
                    <tr class="{{ $cont->status_bc === 'HOLD' ? 'bg-yellow' : 'bg-green' }}">
                      <td>
                        <div class="row">
                        <button type="button" data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-success btn-xs Pilih" style="margin: 10px;">Pilih</button>
                      <button type="button"  data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-danger btn-sm Barcode" style="margin: 10px;"><i class="fa fa-print"></i></button>
                      <button type="button"  data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-warning btn-sm Photo" style="margin: 10px;"><i class="fa fa-photo"></i></button>
					  <button type="button"  data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-warning btn-sm Detil" style="margin: 10px;" ><i class="fa fa-book" ></i></button>

                        </div>
                      </td>
                      @if($cont->status_bc =='HOLD')
                      <td>
                        <button class="btn btn-danger Release"  data-id="{{$cont->TCONTAINER_PK}}">HOLD (Change to Release)</button>
                      </td>
                      @else
                      <td>Released</td>
                      @endif
                      <td>{{$cont->job->NOBOOKING}}</td>
                      <td>{{$cont->NOCONTAINER}}</td>
                      <td>{{$cont->SIZE}}</td>
                      <td>{{$cont->WEIGHT}}</td>
                      <td>{{$cont->CTR_STATUS}}</td>
                      @if($cont->KD_DOKUMEN == '6')
                      <td>NPE</td>
                      @elseif($cont->KD_DOKUMEN == '7')
                      <td>PKBE</td>
                      @else
                      <td>Belum Ada Dokumen</td>
                      @endif
                      <td>{{$cont->NO_PKBE}}</td>
                      <td>{{$cont->TGL_PKBE}}</td>
                      <td>{{$cont->NOPOL_KELUAR}}</td>
                      <td>{{$cont->TGLKELUAR}}</td>
                      <td>{{$cont->JAMKELUAR}}</td>
                      <td>{{$cont->UID_KELUAR}}</td>
                    </tr>
                     @endforeach
                    </tbody>
                </table>
              </div>
            </div>
        </div> 
        
                
        <form class="form-horizontal" id="gatein-form" action="{{ route('exp-realisasi-gateOut-update') }}" method="POST">
                <div id="btn-toolbar" class="section-header btn-toolbar" role="toolbar" style="margin: 10px 0;">
                    <div id="btn-group-2" class="btn-group toolbar-block">
                        <button class="btn btn-default save"><i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-default" id="btn-cancel"><i class="fa fa-close"></i> Cancel</button>
                    </div>  
                    <div id="btn-group-4" class="btn-group">
                        <button class="btn btn-default SuratJalan" id="btn-print" disabled><i class="fa fa-print"></i> Cetak Surat Jalan</button>
                    </div>
                    <div id="btn-group-5" class="btn-group pull-right">
                    <button class="btn btn-default TPS" id="btn-upload" disabled><i class="fa fa-upload"></i> Upload TPS Online</button>
                    </div>
                </div>
            <div class="row">
                <div class="col-md-6">
                    
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input id="TCONTAINER_PK" name="TCONTAINER_PK" type="hidden">
                    <input id="idGate" name="id" type="hidden">
                    <input name="delete_photo" id="delete_photo" value="N" type="hidden">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Job</label>
                        <div class="col-sm-8">
                            <input type="text" id="NoJob" name="NoJob" class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. SPK</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOSPK" name="NOSPK" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Container</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOCONTAINER" name="NOCONTAINER" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Size</label>
                        <div class="col-sm-3">
                            <input type="text" id="SIZE" name="SIZE" class="form-control" readonly>
                </div>
                        <label class="col-sm-2 control-label">TPS Asal</label>
                        <div class="col-sm-3">
                            <input type="text" id="KD_TPS_ASAL" name="KD_TPS_ASAL" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Weight</label>
                        <div class="col-sm-8">
                            <input type="text" id="WEIGHT" name="WEIGHT" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Consolidator</label>
                        <div class="col-sm-8">
                            <input type="text" id="CONSOLIDATOR" name="CONSOLIDATOR" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row hide-when-empty">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl.Keluar</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                </div>
                                <input type="date" id="TGLKELUAR" name="TGLKELUAR" class="form-control pull-right" required>
                            </div>
                        </div>
                    </div>
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jam Keluar</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="time" id="JAMKELUAR" name="JAMKELUAR" class="form-control" required>
                                    <div class="input-group-addon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <hr>
                  
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nomor Dokumen</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                               
                                    <input type="text" id="pkbe" name="NO_PKBE" class="form-control">
                                    <input type="hidden" id="idCon" name="" class="form-control">
                                    <input type="hidden" id="status" name="" class="form-control">
                                    <button class="btn btn-info btn-sm DokPKBE" type="button">Search</button>
                               
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl Dokumen</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                              
                                    <input type="text" id="tglPKBE" name="TGL_PKBE" class="form-control"  readonly>
                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Petugas</label>
                        <div class="col-sm-8">
                            <input type="text" id="UID_KELUAR" name="UID_KELUAR" class="form-control" required readonly value="{{ Auth::getUser()->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.POL</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOPOL" name="NOPOL_KELUAR" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Segel Pelayaran</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_SEAL" name="NO_SEAL" class="form-control" required>
                        </div>
                    </div>
         
                    <div class="form-group hide-kddoc">
                        <div class="col-sm-12">
                            <div id="load_photos" style="text-align: center;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </form>  
    </div>
</div>
<div id="photo-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="modal">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="upload-title"></h4>
            </div>
            <form class="form-horizontal" id="upload-photo-form" action="{{ route('lcl-gatein-upload-photo') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_cont" name="id_cont" required>   
                            <input type="hidden" id="no_cont" name="no_cont" required>    
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Photo</label>
                                <div class="col-sm-8">
                                    <input type="file" name="photos[]" class="form-control" multiple="true" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    </div>
</div>

<div id="gati" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upload XLS File</h4>
            </div>
            <form class="form-horizontal" action="{{ route('create-manifest-excel-export') }}" method="POST" enctype="multipart/form-data">
                
            </form>
        </div>
    </div>
</div>

<div id="detil-modal" class="modal fade" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="detilModalLabel">Manifest</h4>
            </div>
            
                   <div class="modal-body"></div>
              
			
			  <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
        </div>
    </div>
</div>


@endsection
@section('custom_js')
<script>
  $(function() {
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $(document).on('click', '.Pilih', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('exp-getData-gateOut') }}",
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            $('.hide-when-empty').show();
            $('#btn-upload').prop('disabled', false);
            $('#btn-print').prop('disabled', false);
                $('#NoJob').val(response.data.NoJob);
                $('#NOSPK').val(response.data.NOSPK);
                $('#NOCONTAINER').val(response.data.NOCONTAINER);
                $('#SIZE').val(response.data.SIZE);
                $('#KD_TPS_ASAL').val(response.data.KD_TPS_ASAL);
                $('#WEIGHT').val(response.data.WEIGHT);
                $('#KD_DOKUMEN').val(response.data.KD_DOKUMEN);
                $('#CONSOLIDATOR').val(response.data.CONSOLIDATOR);
                $('#TGLKELUAR').val(response.data.TGLKELUAR);
                $('#JAMKELUAR').val(response.data.JAMKELUAR);
                $('#pkbe').val(response.data.NO_PKBE);
                $('#tglPKBE').val(response.data.TGL_PKBE);
                $('#UID_KELUAR').val(response.data.UID_KELUAR);
                $('#NOPOL').val(response.data.NOPOL_KELUAR);
                $('#TCONTAINER_PK').val(response.data.TCONTAINER_PK);
                $('#idCon').val(response.data.TCONTAINER_PK);
                $('#NO_SEAL').val(response.data.NO_SEAL);
                $('#status').val(response.data.CTR_STATUS);
                
        
         },
         error: function(data) {
            console.log('error:', data);
         }
      });
   });
});

</script>

<script>
  $(document).on('click', '.save', function(e) {
    e.preventDefault();
    var idCont = $('#TCONTAINER_PK').val();
    var WEIGHT = $('#WEIGHT').val();
    // var KD_DOKUMEN = $('#KD_DOKUMEN').val();
    var NO_SEAL = $('#NO_SEAL').val();
    var TGLKELUAR = $('#TGLKELUAR').val();
    var JAMKELUAR = $('#JAMKELUAR').val();
    var NOPOL_KELUAR = $('#NOPOL').val();
    var NOCONTAINER = $('#NOCONTAINER').val();
    var NO_PKBE = $('#pkbe').val();
    var TGL_PKBE = $('#tglPKBE').val();

    var data = {
      'idCont' : $('#TCONTAINER_PK').val(),
      'idGate' : $('#idGate').val(),
      'WEIGHT' : $('#WEIGHT').val(),
    //   'KD_DOKUMEN' : $('#KD_DOKUMEN').val(),
      'NO_SEAL' : $('#NO_SEAL').val(),
      'TGLKELUAR' : $('#TGLKELUAR').val(),
      'JAMKELUAR' : $('#JAMKELUAR').val(),
      'NOPOL_KELUAR' : $('#NOPOL').val(),
      'NO_PKBE' : $('#pkbe').val(),
      'TGL_PKBE' : $('#tglPKBE').val(),


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Truck " + NOPOL_KELUAR + " will bring container" + NOCONTAINER + "? ",
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
          url: "{{ route('exp-realisasi-gateOut-update') }}",
          data: data,
          cache: false,
          dataType: 'json',
          success: function(response) {
            console.log(response);
                        if (response.success) {
                            Swal.fire('Saved!', '', 'success')
                            .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
          },
          error: function(response) {
            var errors = response.responseJSON.errors;
            if (errors) {
              var errorMessage = '';
              $.each(errors, function(key, value) {
                errorMessage += value[0] + '<br>';
              });
              Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
              });
            } else {
              console.log('error:', response);
            }
          },
        });

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }


    })

  });
</script>

<script>
     $(document).on('click', '.Barcode', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Yakin untuk mencetak barcode?",
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
              url: "{{ route('exp-release-barcode') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                    // window.location.href = '/barcode/export/print/' + response.barcode.id;
                    window.open("{{ url('/barcode/export/print/') }}/"+response.barcode.id,"preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
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
$(document).on('click', '.DokPKBE', function(e) {
    e.preventDefault();
    var NO_PKBE = $('#pkbe').val();
    var id = $('#idCon').val();
    var SIZE = $('#SIZE').val();
    var NOCONTAINER = $('#NOCONTAINER').val();

    var status =  $('#status').val();
    // var KD_DOKUMEN = $('#KD_DOKUMEN').val();
    var data = {
        'NO_PKBE' :$('#pkbe').val(),
        'id' : $('#idCon').val(),
        'SIZE' :$('#SIZE').val(),
        'NOCONTAINER' :$('#NOCONTAINER').val(),
        // 'KD_DOKUMEN' :$('#KD_DOKUMEN').val(),
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: "{{ route('exp-getData-pkbe') }}", // Sesuaikan dengan alias rute yang benar
        method: "GET",
        data: data,
        success: function(response) {
        if (response.success) {
            alert("Data ditemukan: " + response.message);
            if (status === 'LCL') {
                $('#pkbe').val(response.data.NOPKBE);
                $('#tglPKBE').val(response.data.TGLPKBE);
            }else{
                $('#pkbe').val(response.data.NONPE);
                $('#tglPKBE').val(response.data.TGLNPE);
            }
         } else {
             alert("Error: " + response.message);
             $("#pkbe").val('');
             $("#tglPKBE").val('');
         }
        },
        error: function(xhr, status, error) {
            console.error("Request failed: " + status + ", " + error);
        }
    });

});
</script>

<script>
$(document).on('click', '.Detil', function(e) {
    e.preventDefault();
  var id = $(this).data('id');
    // var KD_DOKUMEN = $('#KD_DOKUMEN').val();
    var data = {
         'id' : id
        // 'KD_DOKUMEN' :$('#KD_DOKUMEN').val(),
    }
    //alert (id);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: "{{ route('exp-getData-detil') }}", // Sesuaikan dengan alias rute yang benar
        method: "GET",
        data: data,
        success: function(response) {
        if (response.success) {
            //alert("Data ditemukan: " + response.data[0].NOCONTAINER);
		
	    	 
		        

			$('#detil-modal #detilModalLabel').html('Container No:' + response.data[0].NOCONTAINER);
			//$('#detilModalLabel').val(response.data.manifest[0].NOCONTAINER);
			 var content ='<table id="example1" class="table table-bordered table-striped"><thead><tr>';
			// var content =content+ '<th>No Pack</th><th>Tgl Packing</th><th>Qty</th><th>Kode Dokumen</th><th>Nomor Dokumen</th><th>Tanggal Dokumen</th><th>Consignee</th></tr>';
            var content =content+ '<th>No Pack</th><th>Qty</th><th>Kode Dokumen</th><th>Nomor Dokumen</th><th>Tanggal Dokumen</th><th>Consignee</th></tr>';
						
			for (i = 0, n = response.data.length; i < n; i++) {
             	 var kode = response.data[i].KODE_DOKUMEN;
		        if (kode == '6'){
                  var jenis ='NPE';
			   }
		     if (kode == '37'){
                  var jenis ='ATA CARNET Ekspor';
			 }
			 	 if (kode == '38'){
                  var jenis ='CPD CARNET Ekspor';
			 }
			 	 if (kode == '8'){
                  var jenis ='CPD CARNET Ekspor';
			 }
			 	 if (kode == '5'){
                  var jenis ='SPPF';
			 }
			  	 if (kode == '45'){
                  var jenis ='NPP3BET';
			 }               
							
			 //var content = content + '<tr><th>'+ response.data[i].NO_PACK + '</th><th>' + response.data[i].TGL_PACK+'</th><th>'+response.data[i].QUANTITY+'</th><th>'+jenis+'</th><th>'+response.data[i].NO_NPE+'</th><th>'+response.data[i].TGL_NPE+'</th><th>'+response.data[i].CONSIGNEE+'</th></tr>';
             var content = content + '<tr><th>'+ response.data[i].NO_PACK + '</th></th><th>'+response.data[i].QUANTITY+'</th><th>'+jenis+'</th><th>'+response.data[i].NO_NPE+'</th><th>'+response.data[i].TGL_NPE+'</th><th>'+response.data[i].CONSIGNEE+'</th></tr>';
             
			 }
			 var content = content + '</table>';
			 $('#detil-modal .modal-body').html(content);
			//document.getElementById('#detil-modal').style.width = '500px';
            $('#detil-modal').modal('show');
         } else {
             alert("Error: " + response.message);
          }
        },
        error: function(xhr, response, error) {
            console.error("Request failed: " + response + ", " + error);
        }
    });

});
</script>






<script>
    $(document).ready(function () {
        // Initially hide the sections
        $('.hide-when-empty').hide();

        // Check TCONTAINER_PK value on input change
        $('#TCONTAINER_PK').on('input', function () {
            // Check if TCONTAINER_PK has a value
            if ($(this).val().trim() !== '') {
                // Show the sections
                $('.hide-when-empty').show();
            } else {
                // Hide the sections
                $('.hide-when-empty').hide();
            }
        });
    });

    $(document).on('click', '.Release', function() {
      let id = $(this).data('id');
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Release this container? ",
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
          url: "{{ route('exp-release-ContRelease') }}",
          data: {id:id},
          cache: false,
          dataType: 'json',
          success: function(response) {
            console.log(response);
                        if (response.success) {
                            Swal.fire('Saved!', '', 'success')
                            .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
          },
          error: function(response) {
            var errors = response.responseJSON.errors;
            if (errors) {
              var errorMessage = '';
              $.each(errors, function(key, value) {
                errorMessage += value[0] + '<br>';
              });
              Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
              });
            } else {
              console.log('error:', response);
            }
          },
        });

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }


    })
   });

</script>

<script>
     $(document).on('click', '.Photo', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "Ingin melihat foto?",
          icon: 'warning',
          showDenyButton: false,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'Confirm',
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {

            $.ajax({
              type: 'GET',
              url: "{{ route('exp-release-photo') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                 
                    // window.location.href = '/barcode/export/print/' + response.barcode.id;
                    window.open("{{ url('/export/photo/print/') }}/"+response.data.TCONTAINER_PK,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
                       
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
  $(document).on('click', '.TPS', function(e) {
    e.preventDefault();
    var idCont = $('#TCONTAINER_PK').val();
    var data = {
      'idCont' : $('#TCONTAINER_PK').val(),


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Yakin Upload TPS Online?",
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
          url: "{{ route('exp-UploadTPS-codeco-cont')}}",
          data: data,
          cache: false,
          dataType: 'json',
          success: function(response) {
            console.log(response);
                        if (response.success) {
                            Swal.fire('Saved!', '', 'success')
                            .then(() => {
                            // Memuat ulang halaman setelah berhasil menyimpan data
                            window.location.reload();
                        });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
          },
          error: function(response) {
            var errors = response.responseJSON.errors;
            if (errors) {
              var errorMessage = '';
              $.each(errors, function(key, value) {
                errorMessage += value[0] + '<br>';
              });
              Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
              });
            } else {
              console.log('error:', response);
            }
          },
        });

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }


    })

  });
</script>


<script>
  $(document).on('click', '.SuratJalan', function(e) {
    e.preventDefault();
    var id = $('#TCONTAINER_PK').val();
    var data = {
      'id' : $('#TCONTAINER_PK').val(),


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Yakin Mencetak Surat Jalan?",
      icon: 'warning',
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Confirm',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {


        $.ajax({
          type: 'GET',
          url: "{{ route('exp-release-SuratJalan')}}",
          data: data,
          cache: false,
          dataType: 'json',
          success: function(response) {
            console.log(response);
                        if (response.success) {
                            Swal.fire('Saved!', '', 'success')
                            .then(() => {
                              window.open("{{ url('/export/release/suratJalan/') }}/"+response.data.TCONTAINER_PK,"preview barcode","width=600,height=600,menubar=no,status=no,scrollbars=yes"); 
                        });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
          },
          error: function(response) {
            var errors = response.responseJSON.errors;
            if (errors) {
              var errorMessage = '';
              $.each(errors, function(key, value) {
                errorMessage += value[0] + '<br>';
              });
              Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: errorMessage,
              });
            } else {
              console.log('error:', response);
            }
          },
        });

      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }


    })

  });
</script>

@endsection