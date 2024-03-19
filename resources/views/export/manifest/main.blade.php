@extends('layout')
@section('custom_css')


@endsection
@section('content')


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Export Manifest Lists</h3>
        <div class="box-tools pull-right">


          <button id="upload-xls-file" type="button" class="btn btn-warning btn-sm"><i class="fa fa-plus"></i> Upload XLS File</button>
          <a href="{{ route('create-manifest-manualForExport') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Manual</a>

      </div>

    </div>
    <div class="box-body table-responsive">       
            <div class="table-container">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th width="185px">Action</th>
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
                    @foreach($manifest as $man)
                    <tr>
       
                    </td>
                      <td>
                      @if($man->sor_update == '0')
                      <a class="btn btn-outline-warning btn-xs" href="{{ route('exp-manifest-edit', $man->TMANIFEST_PK) }}"><i class="fa fa-pencil"></i></a>
                     <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-outline-warning btn-xs Delete" style="margin: 10px;"><i class="fa fa-cut"></i></button>
     		         <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-success btn-xs Approve" style="margin: 10px;">Approve</button>
                      
					  @else
                      <a class="btn btn-outline-warning btn-xs" href="{{ route('exp-manifest-edit', $man->TMANIFEST_PK) }}"><i class="fa fa-eye"></i></a>
                      <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-success btn-xs Approve" style="margin: 10px;" disabled>Approve</button>
                      @endif
                      <button type="button" data-id="{{$man->TMANIFEST_PK}}" class="btn btn-danger btn-xs Barcode" style="margin: 10px;"><i class="fa fa-print"></i></button>
                      </td>
                      <td>{{$man->NO_PACK}}</td>
                      <td>{{$man->TGL_PACK}}</td>
                      <td>{{$man->QUANTITY}}</td>

                      @if($man->KODE_DOKUMEN == '6')
                      <td>NPE</td>
                      @elseif($man->KODE_DOKUMEN == '37')
                      <td>ATA CARNET Ekspor</td>
                      @elseif($man->KODE_DOKUMEN == '38')
                      <td>CPD CARNET Ekspor</td>
					   @elseif($man->KODE_DOKUMEN == '5')
                      <td>SPPF</td>
					   @elseif($man->KODE_DOKUMEN == '45')
                      <td>NPP3BET</td>
					   @elseif($man->KODE_DOKUMEN == '28')
                      <td>BC 1.2</td>
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
            <br>
            <div class="row">
  
</div>

    </div>
</div>

<div id="upload-xls-file-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upload XLS File</h4>
            </div>
            <form class="form-horizontal" action="{{ route('create-manifest-excel-export') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">File</label>
                                <div class="col-sm-8">
                                    <input type="file" id="file-txt-input" name="filexls" />
                                </div>
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal -->
<div id="addManual" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Barang</h4>
            </div>
           
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@section('custom_js')




<script>
 $(document).ready(function () {
        $('.select2').select2();
    });
$('#addManual').on('shown.bs.modal', function () {
        $('.select2').select2();
    });
$('#upload-xls-file').on("click", function(){
    $('#upload-xls-file-modal').modal('show');
});

$('#addBarang').on("click", function(){
    $('#addManual').modal('show');
});
</script>
<script>
  $(document).ready(function() {
  
   $("#TSHIPPER_FK,#TCONSIGNEE_FK,#TNOTIFYPARTY_FK").select2({
        ajax: {
          url: "{{ route('getDataPerusahaan') }}",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
//              page: params.page
            };
          },
          processResults: function (data, params) {
//              console.log(data);
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;

            return {
              results: data.items,
//              pagination: {
//                more: (params.page * 30) < data.total_count
//              }
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3,
//        templateResult: formatRepo, // omitted for brevity, see the source of this page
//        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
  });
</script>

<script>
     $(document).on('click', '.Approve', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        Swal.fire({
          title: 'Are you Sure?',
          text: "?",
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
              url: "{{ route('approve-manifest') }}",
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
              url: "{{ route('show-barcode-manifest') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                    // window.location.href = '/barcode/export/print/' + response.barcode.id;
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

<script>

   $(document).on('click', '.Delete', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
		//alert(id);
        Swal.fire({
          title: 'Are you Sure?',
          text: "Yakin anda akan hapus data manifest?",
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
              url: "{{ route('exp-manifest-delete') }}",
              data: { id: id },
              cache: false,
              dataType: 'json',
              success: function(response) {
                console.log(response);
                if (response.success) {
                  Swal.fire('Saved!', response.message, 'success')
                  .then(() => {
                    // window.location.href = '/barcode/export/print/' + response.barcode.id;
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