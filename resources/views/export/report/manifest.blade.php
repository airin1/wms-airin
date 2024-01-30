@extends('layout')

@section('custom_css')
<link href="{{ asset('bower_components/AdminLTE/plugins/flatpickr/flatpickr.min.css')}}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">
@endsection

@section('content')

<div class="box">
    <div class="box-body table-responsive">
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Report Stuffing</h3>
        <br>
        <br>
        <div class="row">

            <div class="col-xs-3">
                <label for="">Select Date</label>
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

            <div class="col-xs-2">
                <button class="btn btn-success gas"> <i class="fa fa-search"></i></button>
            </div>
            <div class="col-xs-3">
                <button class="btn btn-warning clear"> Clear</i></button>
            </div>
            <br>

        </div>
    </div>
    <div class="box-body table-responsive">   
            <form action="{{ route('exp-report-laporan-Stuffing') }}" method="GET">
                        <input type="hidden" id="start" name="start">
                        <input type="hidden" id="end" name="end">
                    <button class="btn btn-success" type="submit">
                        <i class="fa fa-download"></i> Download Excel
                    </button>
                </form> 
   <br>
    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No Pack</th>
                        <th>Tgl Packing</th>
                        <th>Qty</th>
                        <th>Kode Dokumen</th>
                        <th>Nomor Dokumen</th>
                        <th>Tanggal Dokumen</th>
                        <th>Tgl. Stuffing</th>
                        <th>Jam Stuffing</th>
                        <th>No Container</th>
                        <th>Pelabuhan Bongkar</th>
                        <th>Consignee</th>
                        <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($manifest as $man)
                    <tr>
                    <td>{{$man->NO_PACK}}</td>
                      <td>{{$man->TGL_PACK}}</td>
                      <td>{{$man->QUANTITY}}</td>

                      @if($man->KODE_DOKUMEN == '6')
                      <td>NPE</td>
                      @elseif($man->KODE_DOKUMEN == '37')
                      <td>ATA CARNET Ekspor</td>
                      @elseif($man->KODE_DOKUMEN == '38')
                      <td>CPD CARNET Ekspor</td>
                      @else
                      <td>Dokumen Belum Tersedia</td>
                      @endif
                      <td>{{$man->NO_NPE}}</td>
                      <td>{{$man->TGL_NPE}}</td>
                      <td>{{$man->tglstufing}}</td>
                      <td>{{$man->jamstufing}}</td>
                      <td>{{$man->NOCONTAINER}}</td>
                      <td>{{$man->PEL_BONGKAR}}</td>
                      <td>{{$man->CONSIGNEE}}</td>
                      <td>{{$man->UID}}</td>
                    </tr>
                     @endforeach
                    </tbody>
                </table>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Report Manifest Belum Stuffing</h3>
        <br>
        <div class="float-right">
            <a  class="btn btn-success excelMasuk"  href="{{ route('exp-report-laporan-belumStuffing') }}"> <i class="fa fa-download"></i>Download</a>
            </div>
    </div>
    <div class="box-body table-responsive">    
   
        <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>No Pack</th>
                        <th>Tgl Packing</th>
                        <th>Qty</th>
                        <th>Kode Dokumen</th>
                        <th>Nomor Dokumen</th>
                        <th>Tanggal Dokumen</th>
                        <th>Pelabuhan Bongkar</th>
                        <th>Consignee</th>
                        <th>UID</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($manifestNotStuffing as $man)
                    <tr>
                    <td>{{$man->NO_PACK}}</td>
                      <td>{{$man->TGL_PACK}}</td>
                      <td>{{$man->QUANTITY}}</td>

                      @if($man->KODE_DOKUMEN == '6')
                      <td>NPE</td>
                      @elseif($man->KODE_DOKUMEN == '37')
                      <td>ATA CARNET Ekspor</td>
                      @elseif($man->KODE_DOKUMEN == '38')
                      <td>CPD CARNET Ekspor</td>
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
          url: "{{ route('exp-report-manifestData') }}",
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
                                updateTableMasuk(response.data);
                               
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

    data.forEach(function(man) {
        var row = $('<tr>');
        row.append('<td>' + man.NO_PACK + '</td>');
        row.append('<td>' + man.TGL_PACK + '</td>');
        row.append('<td>' + man.QUANTITY + '</td>');
        row.append('<td>' + (man.KODE_DOKUMEN == '6' ? 'NPE' : (man.KODE_DOKUMEN == '37' ? 'ATA CARNET Ekspor' : (man.KODE_DOKUMEN == '38' ? 'CPD CARNET Ekspor' : 'Dokumen Belum Tersedia'))) + '</td>');
        row.append('<td>' + man.NO_NPE + '</td>');
        row.append('<td>' + man.TGL_NPE + '</td>');
        row.append('<td>' + man.tglstufing + '</td>');
        row.append('<td>' + man.jamstufing + '</td>');
        row.append('<td>' + man.NOCONTAINER + '</td>');
        row.append('<td>' + man.PEL_BONGKAR + '</td>');
        row.append('<td>' + man.CONSIGNEE + '</td>');
        row.append('<td>' + man.UID + '</td>');

        tbody.append(row);
    });
    $('#example1').DataTable();
}
</script>
@endsection