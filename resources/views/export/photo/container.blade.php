@extends('layout')

@section('content')

@include('partials.form-alert')


    <!-- /.box-header -->
    

<div class="box box-default">
    
    <!-- /.box-header -->
    <div class="form-horizontal">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-12">
                    <div class="box-body">       
                         <table id="example1" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                                <th>Action</th>
                                <th>No Container</th>
                                <th>Size</th>
                                <th>Status</th>
                                <th>TEUS</th>
                                <th>No Seal</th>
                                <th>Weight</th>
                                <th>Measurement</th>
                                <th>Tgl Entry</th>
                                <th>Update</th>
                                <th>UID</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($container as $cont)
                            <tr>
                                <td>
                                  <a href="{{ route('exp-uploadPhoto-cont', $cont->TCONTAINER_PK) }}" class="btn btn-success">Upload Photo</a>
                                </td>
                                <td>{{$cont->NOCONTAINER}}</td>
                                <td>{{$cont->SIZE}}</td>
                                <td>{{$cont->CTR_STATUS}}</td>
                                <td>{{$cont->TEUS}}</td>
                                <td>{{$cont->NO_SEAL}}</td>
                                <td>{{$cont->WEIGHT}}</td>
                                <td>{{$cont->MEAS}}</td>
                              
                                <!-- <td>
                                    @if($cont->photo_get_in != NULL)
                                    <img src="{{ asset('/uploads/photos/export/container/' . $cont->photo_get_in) }}" alt=""  width="70" height="70"><br>
                                    <button type="button" class="btn btn-success gateIn" data-id="{{$cont->TCONTAINER_PK}}">Upload</button>
                                    @else
                                    <button type="button" class="btn btn-success gateIn" data-id="{{$cont->TCONTAINER_PK}}">Upload</button>
                                    @endif
                                </td>
                                <td>
                                @if($cont->photo_stripping != NULL)
                                    <img src="{{ asset('/uploads/photos/export/container/' . $cont->photo_stripping) }}" alt=""  width="70" height="70"><br>
                                    <button type="button" class="btn btn-success stuffing" data-id="{{$cont->TCONTAINER_PK}}">Upload</button>
                                    @else
                                    <button type="button" class="btn btn-success stuffing" data-id="{{$cont->TCONTAINER_PK}}">Upload</button>
                                    @endif
                                </td>
                                <td>
                                @if($cont->photo_get_out != NULL)
                                    <img src="{{ asset('/uploads/photos/export/container/' . $cont->photo_get_out) }}" alt=""  width="70" height="70"><br>
                                    <button type="button" class="btn btn-success gateOut" data-id="{{$cont->TCONTAINER_PK}}">Upload</i></button>
                                    @else
                                    <button type="button" class="btn btn-success gateOut" data-id="{{$cont->TCONTAINER_PK}}">Upload</i></button>
                                    @endif
                                </td> -->
                               
                               
                                <td>{{$cont->TGLENTRY}}</td>
                                <td>{{$cont->last_update}}</td>
                                <td>{{$cont->UID}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">

                </div>
            </div>
                
        </div>
    </div>
</div>


<!-- Gate In -->
<div id="uploadPhoto" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upload Photo</h4>
            </div>
         
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Container</label>
                                <div class="col-sm-8">
                                    <input type="file" id="photo" class="form-control" require> 
                                    <input type="hidden" id="keterangan" class="form-control" > 
                                    <input type="hidden" id="TCONTAINER_PK" class="form-control" > 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary UploadPhoto">Upload</button>
                </div>
           
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('custom_css')

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script type="text/javascript">
    $('.select2').select2();
//  $('.gateIn'|| '.stuffing' || '.gateOut').on("click", function(){
//         $('#uploadPhoto').modal('show');
//     });
    
</script>

<script>
  $(function() {
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

//    Gate In
   $(document).on('click', '.gateIn', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('exp-container-photo-id', ['id' => '']) }}/" + id,
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            $('#uploadPhoto').modal('show');
            // $('#edit #cont').val(response.data.container_no);
            // $('#edit #contKey').val(response.data.container_key);
         
            $('#uploadPhoto #keterangan').val('gateIn');
            $('#uploadPhoto #TCONTAINER_PK').val(response.data.TCONTAINER_PK);
            

        
         },
         error: function(data) {
            console.log('error:', data);
         }
      });
   });

//    Gate Out
   $(document).on('click', '.gateOut', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('exp-container-photo-id', ['id' => '']) }}/" + id,
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            $('#uploadPhoto').modal('show');
            // $('#edit #cont').val(response.data.container_no);
            // $('#edit #contKey').val(response.data.container_key);
           
            $('#uploadPhoto #keterangan').val('gateOut');
            $('#uploadPhoto #TCONTAINER_PK').val(response.data.TCONTAINER_PK);
            

        
         },
         error: function(data) {
            console.log('error:', data);
         }
      });
   });

//    Stuffing
   $(document).on('click', '.stuffing', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('exp-container-photo-id', ['id' => '']) }}/" + id,
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            $('#uploadPhoto').modal('show');
            // $('#edit #cont').val(response.data.container_no);
            // $('#edit #contKey').val(response.data.container_key);
           
            $('#uploadPhoto #keterangan').val('stuffing');
            $('#uploadPhoto #TCONTAINER_PK').val(response.data.TCONTAINER_PK);
            

        
         },
         error: function(data) {
            console.log('error:', data);
         }
      });
   });
});

</script>

<script>
  $(document).on('click', '.UploadPhoto', function(e) {
    e.preventDefault();
    var formData = new FormData();
    formData.append('photo', $('#photo')[0].files[0]);
    formData.append('TCONTAINER_PK', $('#TCONTAINER_PK').val());
    formData.append('keterangan', $('#keterangan').val());

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Change With New Data ? ",
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
          url: "{{ route('exp-container-photo-upload') }}",
          data: formData,
          cache: false,
          processData: false,  // Set to false when sending FormData
    contentType: false,
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