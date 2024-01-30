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
</style>
@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Realisasi Masuk / Gate In (Container)</h3>

    </div>
    <div class="box-body">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12 "> 
              <div class="table-container">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Action</th>
                    <th>No Pack</th>
                    <th>Tgl. Pack</th>
                    <th>Weight</th>
                    <th>No. Truck</th>
                    <th>Tanggal Masuk</th>
                    <th>Jam Masuk</th>
                    <th>UID</th>
                </tr>
              </thead>
              <tbody>
              @foreach($gate as $masuk)
              <tr>
                <td>
                <button type="button" data-id="{{$masuk->id}}" class="btn btn-success btn-xs Approve" style="margin: 10px;">Pilih</button>
                </td>
                <td>{{$masuk->manifest->NO_PACK}}</td>
                <td>{{$masuk->manifest->TGL_PACK}}</td>
                <td>{{$masuk->manifest->WEIGHT}}</td>
          
                <td>{{$masuk->manifest->NOPOL_MASUK}}</td>
                <td>{{$masuk->manifest->tglmasuk}}</td>
                <td>{{$masuk->manifest->jammasuk}}</td>
                <td>{{$masuk->manifest->UID}}</td>
              </tr>
               @endforeach
              </tbody>
            </table>
              </div>
            </div>
        </div> 
        
        <div id="btn-toolbar" class="section-header btn-toolbar" role="toolbar" style="margin: 10px 0;">
                    <div id="btn-group-2" class="btn-group toolbar-block">
                        <button class="btn btn-default save"><i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-default" id="btn-cancel"><i class="fa fa-close"></i> Cancel</button>
                    </div>  
                    <div id="btn-group-4" class="btn-group">
                        <button class="btn btn-default" id="btn-print"><i class="fa fa-print"></i> Cetak WO Lift Off</button>
                    </div>
                    <div id="btn-group-5" class="btn-group pull-right">
                        <button class="btn btn-default TPS" id="btn-upload" disabled><i class="fa fa-upload"></i> Upload TPS Online</button>
                    </div>
                </div>
        <form class="form-horizontal" method="POST">
            <div class="row">
                <div class="col-md-6">
                    
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input id="TMANIFEST_PK" name="TMANIFEST_PK" type="hidden">
                    <input id="idGate" name="id" type="hidden">
                    <input name="delete_photo" id="delete_photo" value="N" type="hidden">
                    
                
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Packing</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_PACK" name="NO_PACK" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Weight</label>
                        <div class="col-sm-8">
                            <input type="text" id="WEIGHT" name="WEIGHT" class="form-control">
                        </div>
                    </div>
                   
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.NPE</label>
                        <div class="col-sm-3">
                            <input type="text" id="NO_NPE" name="NO_BC11" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">Tgl.NPE</label>
                        <div class="col-sm-3">
                            <input type="text" id="TGL_NPE" name="TGL_BC11" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Exportir</label>
                        <div class="col-sm-3">
                            <input type="text" id="NAMA_IMP" name="NO_PLP" class="form-control" readonly>
                        </div>
                      
                    </div> 
                   

                    </div>
                </div>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    
                     <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl.Masuk</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                 <i class="fa fa-calendar"></i> 
                              </div> 
                                <input type="date" id="TGLMASUK" name="TGLMASUK" class="form-control pull-right" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bootstrap-timepicker">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jam Masuk</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="time" id="JAMMASUK" name="JAMMASUK" class="form-control" required>
                                    <div class="input-group-addon">
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    

                    </div>
                <div class="col-md-6"> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Petugas</label>
                        <div class="col-sm-8">
                            <input type="text" id="UIDMASUK" name="UIDMASUK" class="form-control" required readonly value="{{ Auth::getUser()->name }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.POL</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOPOL_MASUK" name="NOPOL_MASUK" class="form-control" required>
                        </div>
                    </div>

                    
                </div>
            </div>
        </form>  
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

   $(document).on('click', '.Approve', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('exp-manifest-gateIn-Approve', ['id' => '']) }}/" + id,
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            // $('#gati').modal('show');
            // $('#edit #cont').val(response.data.container_no);
            // $('#edit #contKey').val(response.data.container_key);
            $('#btn-upload').prop('disabled', false);
                $('#NoJob').val(response.cont.NOSPK);
                $('#NO_PACK').val(response.cont.NO_PACK);
               
                $('#NO_NPE').val(response.cont.NO_NPE);
                $('#TGL_NPE').val(response.cont.TGL_NPE);
                $('#NAMA_IMP').val(response.cont.NAMA_IMP);
                $('#WEIGHT').val(response.cont.WEIGHT);
                $('#JAMMASUK').val(response.cont.jammasuk);
                $('#TGLMASUK').val(response.cont.tglmasuk);
                $('#TMANIFEST_PK').val(response.cont.TMANIFEST_PK);
                $('#NOPOL_MASUK').val(response.cont.NOPOL_MASUK);
                $('#idGate').val(response.data.id);
        
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
    var idCont = $('#TMANIFEST_PK').val();
    var idGate = $('#idGate').val();
    var WEIGHT = $('#WEIGHT').val();
    var TGLMASUK = $('#TGLMASUK').val();
    var JAMMASUK = $('#JAMMASUK').val();
    var NOPOL_MASUK = $('#NOPOL_MASUK').val();
    var NO_PACK = $('#NO_PACK').val();
    var UIDMASUK = $('#UIDMASUK').val();
    var data = {
      'idCont' : $('#TMANIFEST_PK').val(),
      'idGate' : $('#idGate').val(),
      'WEIGHT' : $('#WEIGHT').val(),
      'TGLMASUK' : $('#TGLMASUK').val(),
      'JAMMASUK' : $('#JAMMASUK').val(),
      'UIDMASUK' : $('#UIDMASUK').val(),
      'NOPOL_MASUK' : $('#NOPOL_MASUK').val(),


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Truck " + NOPOL_MASUK + " will bring container" + NO_PACK + "? ",
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
          url: "{{ route('exp-manifest-gateIn-Approve-masuk') }}",
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

<!-- TPS Online -->
<script>
  $(document).on('click', '.TPS', function(e) {
    e.preventDefault();
    var id = $('#TMANIFEST_PK').val();
    var data = {
      'id' : $('#TMANIFEST_PK').val(),


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
          url: "{{ route('exp-manifest-UploadTPS-cont')}}",
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


@endsection