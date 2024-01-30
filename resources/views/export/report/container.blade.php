@extends('layout')

@section('custom_css')
<link href="{{ asset('bower_components/AdminLTE/plugins/flatpickr/flatpickr.min.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')

<div class="box">
    <div class="box-body table-responsive">
        <div class="row">

            <div class="col-xs-3">
                <label for="">Select Date</label>
            </div>

            <div class="col-xs-3">
                <label for="">Select CTR Status</label>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control flatpickr-range mb-3"  id="tgl" placeholder="Select date..">
                </div>
            </div>

            <div class="col-xs-3">
                <select class="form-control select2" id="status"  style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option value="1">All</option>
                    <option value="LCL">LCL</option>
                    <option value="FCL">FCL</option>
                </select>
            </div>

            <div class="col-xs-3">
                <button class="btn btn-success gas"> <i class="fa fa-search"></i></button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-warning clear"> Clear</i></button>
            </div>

        </div>
   
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Report Pemasukan</h3>
            <div class="float-right">
                <form action="{{ route('exp-report-contMasuk') }}" method="GET">
                    <input type="hidden" id="start" name="start">
                    <input type="hidden" id="end" name="end">
                    <input type="hidden" id="statusLap" name = "status">
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-download"></i> Download Excel
                </button>
                </form>
            </div>
    </div>
    <div class="box-body table-responsive">    
   
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                          <th>No Joborder</th>
                          <th>No Container</th>
                          <th>Status BC</th>
                          <th>Size</th>
                          <th>Weight</th>
                          <th>Status</th>
                          <th>Jenis Dokumen</th>
                          <th>No Dokumen</th>
                          <th>Tgl. Dokumen</th>
                          <th>No. Truck Masuk</th>
                          <th>Tanggal Masuk</th>
                          <th>Jam Masuk</th>
                          <th>No. Truck Keluar</th>
                          <th>Tanggal Keluar</th>
                          <th>Jam Keluar</th>
                          <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($container as $cont)
                    <tr>
                        <td>{{$cont->NoJob}}</td>
                        <td>{{$cont->NOCONTAINER}}</td>
                        <td>{{$cont->status_bc}}</td>
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
                        <td>{{$cont->NOPOL_MASUK}}</td>
                        <td>{{$cont->TGLMASUK}}</td>
                        <td>{{$cont->JAMMASUK}}</td>
                        <td>{{$cont->NOPOL_KELUAR}}</td>
                        <td>{{$cont->TGLKELUAR}}</td>
                        <td>{{$cont->JAMKELUAR}}</td>
                        <td>{{$cont->UID}}</td>
                    </tr>
                     @endforeach
                    </tbody>
                </table>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Report Pengeluaran</h3>
        <div class="float-right">
                <form action="{{ route('exp-report-contkeluar') }}" method="GET">
                    <input type="hidden" id="startKeluar" name="start">
                    <input type="hidden" id="endKeluar" name="end">
                    <input type="hidden" id="statusKeluar" name = "status">
                <button class="btn btn-success" type="submit">
                    <i class="fa fa-download"></i> Download Excel
                </button>
                </form>
            </div>
    </div>
    <div class="box-body table-responsive">    
   
            <table id="example3" class="table table-bordered table-striped">
            <thead>
                      <tr>
                          <th>No Joborder</th>
                          <th>No Container</th>
                          <th>Status BC</th>
                          <th>Size</th>
                          <th>Weight</th>
                          <th>Status</th>
                          <th>Jenis Dokumen</th>
                          <th>No Dokumen</th>
                          <th>Tgl. Dokumen</th>
                          <th>No. Truck Masuk</th>
                          <th>Tanggal Masuk</th>
                          <th>Jam Masuk</th>
                          <th>No. Truck Keluar</th>
                          <th>Tanggal Keluar</th>
                          <th>Jam Keluar</th>
                          <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($container as $cont)
                    <tr>
                        <td>{{$cont->NoJob}}</td>
                        <td>{{$cont->NOCONTAINER}}</td>
                        <td>{{$cont->status_bc}}</td>
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
                        <td>{{$cont->NOPOL_MASUK}}</td>
                        <td>{{$cont->TGLMASUK}}</td>
                        <td>{{$cont->JAMMASUK}}</td>
                        <td>{{$cont->NOPOL_KELUAR}}</td>
                        <td>{{$cont->TGLKELUAR}}</td>
                        <td>{{$cont->JAMKELUAR}}</td>
                        <td>{{$cont->UID}}</td>
                    </tr>
                     @endforeach
                    </tbody>
            </table>
    </div>
</div>


@endsection

@section('custom_js')
<script src="{{ asset ('bower_components/AdminLTE/plugins/flatpickr/flatpickr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset ('bower_components/AdminLTE/dist/js/pages/date-picker.js') }}" type="text/javascript"></script>
<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

<script>
    $(document).ready(function () {
        // Event listener for the Clear button
        $('.clear').on('click', function () {
            // You can perform actions here to clear/reset the form or refresh the page
            // For example, to refresh the page:
            location.reload();
        });
    });
</script>
<script>
  $(document).on('click', '.gas', function(e) {
    e.preventDefault();
    var tgl = $('#tgl').val();
    var status = $('#status').val();
   

    var data = {
      'tgl' : $('#tgl').val(),
      'status' : $('#status').val(),


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Apakah Tanggal dan Status Container Sudah Benar ?",
      icon: 'warning',
      showDenyButton: false,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Confirm',
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {


        $.ajax({
          type: 'get',
          url: "{{ route('exp-report-contData') }}",
          data: data,
          cache: false,
          dataType: 'json',
          success: function(response) {
            console.log(response);
                        if (response.success) {
                            Swal.fire('Saved!', '', 'success')
                            .then(() => {
                                $('#start').val(response.start);
                                $('#end').val(response.end);
                                $('#statusLap').val(response.status);
                                $('#startKeluar').val(response.start);
                                $('#endKeluar').val(response.end);
                                $('#statusKeluar').val(response.status);
                                updateTableMasuk(response.masuk);
                                updateTableKeluar(response.keluar);
                               
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

  function updateTableMasuk(data) {
    var table = $('#example1').DataTable();

// Destroy the existing DataTable instance
table.destroy();

// Clear the tbody content
var tbody = $('#example1 tbody');
tbody.empty();

    data.forEach(function(cont) {
        var row = $('<tr>');
        row.append('<td>' + cont.NoJob + '</td>');
        row.append('<td>' + cont.NOCONTAINER + '</td>');
        row.append('<td>' + cont.status_bc + '</td>');
        row.append('<td>' + cont.SIZE + '</td>');
        row.append('<td>' + cont.WEIGHT + '</td>');
        row.append('<td>' + cont.CTR_STATUS + '</td>');
        row.append('<td>' + (cont.KD_DOKUMEN == '6' ? 'NPE' : (cont.KD_DOKUMEN == '7' ? 'PKBE' : 'Belum Ada Dokumen')) + '</td>');
        row.append('<td>' + cont.NO_PKBE + '</td>');
        row.append('<td>' + cont.TGL_PKBE + '</td>');
        row.append('<td>' + cont.NOPOL_MASUK + '</td>');
        row.append('<td>' + cont.TGLMASUK + '</td>');
        row.append('<td>' + cont.JAMMASUK + '</td>');
        row.append('<td>' + cont.NOPOL_KELUAR + '</td>');
        row.append('<td>' + cont.TGLKELUAR + '</td>');
        row.append('<td>' + cont.JAMKELUAR + '</td>');
        row.append('<td>' + cont.UID + '</td>');

        tbody.append(row);
    });
    $('#example1').DataTable();
}

function updateTableKeluar(data) {
    var table = $('#example3').DataTable();

// Destroy the existing DataTable instance
table.destroy();

// Clear the tbody content
var tbody = $('#example3 tbody');
tbody.empty();

    data.forEach(function(cont) {
        var row = $('<tr>');
        row.append('<td>' + cont.NoJob + '</td>');
        row.append('<td>' + cont.NOCONTAINER + '</td>');
        row.append('<td>' + cont.status_bc + '</td>');
        row.append('<td>' + cont.SIZE + '</td>');
        row.append('<td>' + cont.WEIGHT + '</td>');
        row.append('<td>' + cont.CTR_STATUS + '</td>');
        row.append('<td>' + (cont.KD_DOKUMEN == '6' ? 'NPE' : (cont.KD_DOKUMEN == '7' ? 'PKBE' : 'Belum Ada Dokumen')) + '</td>');
        row.append('<td>' + cont.NO_PKBE + '</td>');
        row.append('<td>' + cont.TGL_PKBE + '</td>');
        row.append('<td>' + cont.NOPOL_MASUK + '</td>');
        row.append('<td>' + cont.TGLMASUK + '</td>');
        row.append('<td>' + cont.JAMMASUK + '</td>');
        row.append('<td>' + cont.NOPOL_KELUAR + '</td>');
        row.append('<td>' + cont.TGLKELUAR + '</td>');
        row.append('<td>' + cont.JAMKELUAR + '</td>');
        row.append('<td>' + cont.UID + '</td>');

        tbody.append(row);
    });
    $('#example3').DataTable();
}
</script>
@endsection