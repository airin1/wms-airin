@extends('layout')

@section('content')
<style>
    .datepicker.dropdown-menu {
        z-index: 100 !important;
    }
</style>


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Register Lists</h3>
        <div class="box-tools">
            <a href="{{ route('exp-register-create') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
   
   <div class="box-body">       
        <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                    <th>Action</th>
                    <th>No Job Order</th>
                    <th>No Container</th>
                    <th>No SPK</th>
                    <th>NO Booking</th>
                    <th>Tgl Booking</th>
                    <th>UID</th>
                    <th>Tgl Entry</th>
                </tr>
              </thead>
              <tbody>
                @foreach($view as $job)
                <tr>
                  <td> <a class="btn btn-outline-warning btn-sm" href="{{ route('exp-register-edit', $job->TJOBORDER_PK) }}"><i class="fa fa-pencil"></i></a>
                  <button type="button"  data-id="{{$job->CONTAINER_ID}}" class="btn btn-danger btn-sm Barcode" style="margin: 10px;"><i class="fa fa-print"></i></button>
                </td>
                  <td>{{$job->NOJOBORDER}}</td>
                  <td>{{$job->NOCONTAINER}}</td>
                  <td>{{$job->NOSPK}}</td>
                  <td>{{$job->NOBOOKING}}</td>
                  <td>{{$job->TGL_BOOKING}}</td>
                  <td>{{$job->UID}}</td>
                  <td>{{$job->TGLENTRY}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            </div>
    

</div>

@endsection

@section('custom_css')

<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        zIndex: 99
    });
    
    $('#searchByDateBtn').on("click", function(){
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        jQuery("#lclRegisterGrid").jqGrid('setGridParam',{url:"{{URL::to('/lcl/joborder/grid-data')}}?startdate="+startdate+"&enddate="+enddate}).trigger("reloadGrid");
        return false;
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
              url: "{{ route('show-barcode-register') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                    window.open("{{URL::to('/barcode/export/print')}}/"+response.barcode.id,"preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes"); 
                           
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