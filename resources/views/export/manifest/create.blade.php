@extends('layout')

@section('content')

@include('partials.form-alert')

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Form Register Export</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <form class="form-horizontal " style="border: 2px solid red; padding: 15px;" action="{{ route('create-manifest-manual') }}" method="POST" enctype="multipart/form-data">
       
       <div class="row">
           <div class="col-md-6">
           <input name="_token" type="hidden" value="{{ csrf_token() }}">
               <div class="form-group">
                   <label for="NO_PACK" class="col-sm-3 control-label">No Pack</label>
                   <div class="col-sm-8">
                       <input type="text" class="form-control" name="NO_PACK" id="NO_PACK" required/>
                   </div>
               </div>
               <div class="form-group">
                   <label for="TGL_PACK" class="col-sm-3 control-label">Tgl. Pack</label>
                   <div class="col-sm-8">
                       <input type="date" class="form-control" name="TGL_PACK" id="TGL_PACK" />
                   </div>
               </div>
               <div class="form-group">
                   <label for="DESCOFGOODS" class="col-sm-3 control-label">Uraian Barang</label>
                   <div class="col-sm-8">
                       <textarea class="form-control" id="DESCOFGOODS" name="DESCOFGOODS" rows="3"></textarea>
                   </div>
               </div>
               <div class="form-group">
                   <label for="TPACKING_FK" class="col-sm-3 control-label">Packing</label>
                   <div class="col-sm-8">
                       <select class="form-control select2" id="TPACKING_FK" name="TPACKING_FK" style="width: 100%;" tabindex="-1" aria-hidden="true">
                             @foreach($packings as $packing)                                               
                                   <option value="{{ $packing->TPACKING_PK }}">{{ $packing->NAMAPACKING }}</option>
                               @endforeach
                       </select>
                   </div>
               </div>
               <div class="form-group">
                   <label for="TCONSIGNEE_FK" class="col-sm-3 control-label">Consignee</label>
                   <div class="col-sm-8">
                       <select class="form-control select2" id="TCONSIGNEE_FK" name="TCONSIGNEE_FK" style="width: 100%;" tabindex="-1" aria-hidden="true">
                           <option value="" disabled selected>Select Consignee</option>
                       </select>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                   <label for="NAMA_IMP" class="col-sm-3 control-label">Nama Eksportir</label>
                   <div class="col-sm-8">
                       <input type="text" class="form-control" name="NAMA_IMP" id="NAMA_IMP" />
                   </div>
               </div>
               <div class="form-group">
                   <label for="NAMA_IMP" class="col-sm-3 control-label">Alamat Eksportir</label>
                   <div class="col-sm-8">
                       <input type="text" class="form-control" name="ALAMAT_IMP"  />
                   </div>
               </div>
               <div class="form-group">
                        <label class="col-sm-3 control-label">Pel. Muat</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_MUAT" name="PEL_MUAT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                

                            </select>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label class="col-sm-3 control-label">Pel. Transit</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_TRANSIT" name="PEL_TRANSIT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Pelabuhan Transit</option>
                              

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pel. Bongkar</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_BONGKAR" name="PEL_BONGKAR" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Pelabuhan Bongkar</option>
                             

                            </select>
                        </div>
                    </div>
               <div class="form-group">
                   <label for="WEIGHT" class="col-sm-3 control-label">Weight</label>
                   <div class="col-sm-8">
                       <input type="number" class="form-control" name="WEIGHT" id="WEIGHT" />
                   </div>
               </div>
               <div class="form-group">
                   <label for="MEAS" class="col-sm-3 control-label">Volume</label>
                   <div class="col-sm-8">
                       <input type="number" class="form-control" name="MEAS" id="MEAS" />
                   </div>
               </div>
               <div class="form-group">
                   <label for="MEAS" class="col-sm-3 control-label">Quantity</label>
                   <div class="col-sm-8">
                       <input type="number" class="form-control" name="QUANTITY" id="QUANTITY" />
                   </div>
               </div>
           </div>
       </div>
       <div class="modal-footer">
           <button type="submit" class="btn btn-success"> <i class="fa fa-plus"></i>| Add Manifest</button>
       </div>
   </form>
</div>


@endsection

@section('custom_css')

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script type="text/javascript">
    $('select').select2();
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd' 
    });
    $('#vessel').on("change", function (e) { 
        $('input[name="CALLSIGN"]').val($(this).find(":selected").data("callsign"));
    });
    $("#TPELABUHAN_FK").select2({
        ajax: {
          url: "{{ route('getDataPelabuhan') }}",
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
    $("#PEL_MUAT, #PEL_TRANSIT, #PEL_BONGKAR").select2({
        ajax: {
          url: "{{ route('getDataCodePelabuhan') }}",
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
        minimumInputLength: 3
//        templateResult: formatRepo, // omitted for brevity, see the source of this page
//        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
    
    $("#PEL_BONGKAR").append('<option value="IDTPP" selected="selected">IDTPP</option>');
    $("#PEL_BONGKAR").trigger('change');

    $("#add-vessel-btn").on("click", function(e){
        e.preventDefault();
        $("#vessel-modal").modal('show');
        return false;
    });
    
    $("#create-vessel-form").on("submit", function(){
        console.log(JSON.stringify($(this).formToObject('')));
        var url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            data: JSON.stringify($(this).formToObject('')),
            dataType : 'json',
            url: url,
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Something went wrong, please try again later.');
            },
            beforeSend:function()
            {

            },
            success:function(json)
            {
//                console.log(json);

                if(json.success) {
                    $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                    $("#vessel").append('<option value="'+json.data.vesselname+'" selected="selected">'+json.data.vesselname+'</option>');
                    $("#vessel").trigger('change');
                    $('input[name="CALLSIGN"]').val(json.data.callsign);
                    $("#vessel-modal").modal('hide');
                } else {
                    $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                }
//                
//                //Triggers the "Close" button funcionality.
//                $('#btn-refresh').click();
            }
        });
        
        return false;
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
//          
            params.page = params.page || 1;

            return {
              results: data.items,
//            
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3,
//       
    });
  });
</script>

@endsection