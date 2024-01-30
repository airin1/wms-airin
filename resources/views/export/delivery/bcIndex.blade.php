@extends('layout')
@section('custom_css')


@endsection
@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Realisasi Masuk / Gate In (Container)</h3>
<!--        <div class="box-tools">
            <a href="{{ route('lcl-manifest-create') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>-->
    </div>
    <div class="box-body">
        <div class="row" style="margin-bottom: 30px;">
            <div class="col-md-12 "> 
              <div class="table-container">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>Action</th>
                          <th>Status BC</th>
                          <th>No Booking</th>
                          <th>No Container</th>
                          <th>Size</th>
                          <th>Weight</th>
                          <th>Dok PKBE</th>
                          <th>Tgl. PKBE</th>
                          <th>No. Truck</th>
                          <th>Tanggal Keluar</th>
                          <th>Jam Keluar</th>
                          <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($container as $cont)
                    <tr class="{{ $cont->status_bc === 'HOLD' ? 'bg-yellow' : '' }}">
                      <td>
                      <button type="button" data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-success btn-xs Pilih" style="margin: 10px;">Release</button>
                      <!-- <button type="button"  data-id="{{$cont->TCONTAINER_PK}}" class="btn btn-danger btn-sm Barcode" style="margin: 10px;"><i class="fa fa-print"></i></button> -->
                      </td>
                      <td>{{$cont->status_bc}}</td>
                      <td>{{$cont->job->NOBOOKING}}</td>
                      <td>{{$cont->NOCONTAINER}}</td>
                      <td>{{$cont->SIZE}}</td>
                      <td>{{$cont->WEIGHT}}</td>
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
          url: '/export/release/bcCONT',
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
});

</script>

<script>
  $(document).on('click', '.save', function(e) {
    e.preventDefault();
    var idCont = $('#TCONTAINER_PK').val();
    var WEIGHT = $('#WEIGHT').val();
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
          url: '/export/release/updateGateOut',
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
              url: '/export/release/barcode',
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






@endsection