@extends('layout')

@section('content')
<style>
    .datepicker.dropdown-menu {
        z-index: 110 !important;
    }
</style>

<style>
    .footer {
        text-align: right;
    }
</style>

@include('partials.form-alert')

<div class="box">
    <div class="box-body">

    <!-- if not approve -->
@if($manifest->sor_update == '0')
    <form class="form-horizontal" id="manifest-form" action="{{ route('update-manifest', ['id' => $manifest->TMANIFEST_PK]) }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">No. Pack</label>
                            <div class="col-sm-8">
                                <input type="text" id="NOHBL" name="NO_PACK" class="form-control" value="{{$manifest->NO_PACK}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tgl. Pack</label>
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="TGL_HBL" name="TGL_PACK" class="form-control pull-right datepicker" value="{{$manifest->TGL_PACK}}" required>
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Consignee</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="TCONSIGNEE_FK" name="TCONSIGNEE_FK" value="{{$manifest->TCONSIGNEE_FK}}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="{{ $manifest->TCONSIGNEE_FK }}" selected>{{ $manifest->CONSIGNEE }}</option>
                                </select>
                            </div>
                       
                        </div>
                     
                        

                        <div class="form-group">
                                <label class="col-sm-3 control-label">Jenis Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <select class="form-control select2" id="KODE_DOKUMEN" name="KODE_DOKUMEN" style="width: 200%;" tabindex="-1" aria-hidden="true">
                             
                                    <option value="" disabeled>Pilih Satu</option>
                                    <option value="6" >NPE</option>
                                    <option value="37" >ATA CERNET Expor</option>
                                    <option value="38" >CPD CERNET Expor</option>
                                   
                                    </select>
                                </div>
                            </div>
                         </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="npe" name="NO_NPE" class="form-control" value="{{$manifest->NO_NPE}}">
                                            <input type="hidden" id="idMan" name="" class="form-control" value="{{$manifest->TMANIFEST_PK}}">
                                            <button class="btn btn-info btn-sm DokNpe" type="button">Search</button>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tgl Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                       
                                            <input type="text" id="" name="TGL_NPE" class="form-control" value="{{$manifest->TGL_NPE}}" readonly>
                                        </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Exportir</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="" name="TGL_NPE" class="form-control" value="{{$manifest->NAMA_IMP}}" readonly>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NPWP Eksportir</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="" name="" class="form-control" value="{{$manifest->NPWP_IMP}}" readonly>
                                      
                                    </div>
                                </div>
                            </div>


                        <div class="form-group" id="btn-photo">
                          <label class="col-sm-3 control-label">Photo</label>
                          <div class="col-sm-8">
                              <button type="button" class="btn btn-warning" id="upload-photo-btn">Upload Photo</button>
                              <button type="button" class="btn btn-danger" id="delete-photo-btn">Delete Photo</button>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-12">
                              <div id="load_photos" style="text-align: center;"></div>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6"> 
                       
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Desc of Goods</label>
                          <div class="col-sm-8">
                              <textarea class="form-control" id="DESCOFGOODS" name="DESCOFGOODS" rows="3"> {{ old('DESCOFGOODS', $manifest->DESCOFGOODS) }}</textarea>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">QTY</label>
                            <div class="col-sm-2">
                                <input type="number" id="QUANTITY" name="QUANTITY" class="form-control" value="{{$manifest->QUANTITY}}">
                            </div>
                            <label class="col-sm-2 control-label">Packing</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="TPACKING_FK" name="TPACKING_FK"  style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                    @foreach($packings as $packing)                                               
                                        <option value="{{ $packing->TPACKING_PK }}" {{ $packing->TPACKING_PK == $manifest->TPACKING_FK ? 'selected' : '' }}>
                                             {{ $packing->NAMAPACKING }}
                                         </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Weight</label>
                            <div class="col-sm-3">
                                <input type="text" id="WEIGHT" name="WEIGHT" value="{{$manifest->WEIGHT}}" class="form-control" >
                            </div>
                            <label class="col-sm-2 control-label">Meas</label>
                            <div class="col-sm-3">
                                <input type="text" id="MEAS" name="MEAS" value="{{$manifest->MEAS}}" class="form-control" >
                            </div>
                        </div>
                        
                        <div class="form-group">
                     
                        <div class="form-group">
                            <label class="col-sm-3 control-label">QTY Tally</label>
                            <div class="col-sm-8">
                                <input type="number" id="final_qty" name="final_qty" value="{{$manifest->final_qty}}" class="form-control" >
                            </div>
                        </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Muat</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_MUAT" name="PEL_MUAT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                        <option value="">Choose Pelabuhan Muat</option>
                                        @if($manifest->PEL_MUAT)
                                            <option value="{{$manifest->PEL_MUAT}}" selected="selected">{{$manifest->PEL_MUAT}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Transit</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_TRANSIT" name="PEL_TRANSIT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                        <option value="">Choose Pelabuhan Transit</option>
                                        @if($manifest->PEL_TRANSIT)
                                            <option value="{{$manifest->PEL_TRANSIT}}" selected="selected">{{$manifest->PEL_TRANSIT}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Bongkar</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_BONGKAR" name="PEL_BONGKAR" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                        <option value="">Choose Pelabuhan Bongkar</option>
                                        @if($manifest->PEL_BONGKAR)
                                            <option value="{{$manifest->PEL_BONGKAR}}" selected="selected">{{$manifest->PEL_BONGKAR}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>        
                    </div>
                </div>
                </div>
                <div class="footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('exp-manifest-index') }}" class="btn btn-danger">Back</a>
                </div>
            </form>

            <!-- Where was Approve -->
            @else
            <form class="form-horizontal" id="manifest-form" action="{{ route('update-manifest', ['id' => $manifest->TMANIFEST_PK]) }}" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <input name="_token" type="hidden" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">No. Pack</label>
                            <div class="col-sm-8">
                                <input type="text" id="NOHBL" name="NO_PACK" class="form-control" value="{{$manifest->NO_PACK}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tgl. Pack</label>
                            <div class="col-sm-8">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" id="TGL_HBL" name="TGL_PACK" class="form-control pull-right datepicker" value="{{$manifest->TGL_PACK}}" disabled>
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Consignee</label>
                            <div class="col-sm-6">
                                <select class="form-control select2" id="TCONSIGNEE_FK" name="TCONSIGNEE_FK" value="{{$manifest->TCONSIGNEE_FK}}" style="width: 100%;" tabindex="-1" aria-hidden="true" disabled>
                                <option value="{{ $manifest->TCONSIGNEE_FK }}" selected>{{ $manifest->CONSIGNEE }}</option>
                                </select>
                            </div>
                          
                        </div>
                     
                      

                        <div class="form-group">
                                <label class="col-sm-3 control-label">Jenis Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                    <select class="form-control select2" id="KODE_DOKUMEN" name="KODE_DOKUMEN" style="width: 200%;" tabindex="-1" aria-hidden="true" disabled>
                                    <!--<option value="">Choose Location</option>-->
                                    <option value="" disabeled>Pilih Satu</option>
                                    <option value="6" >NPE</option>
                                    <option value="37" >ATA CERNET Expor</option>
                                    <option value="38" >CPD CERNET Expor</option>
                                   
                                    </select>
                                </div>
                            </div>
                         </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="npe" name="NO_NPE" class="form-control" value="{{$manifest->NO_NPE}}" disabled>
                                            <input type="hidden" id="idMan" name="" class="form-control" value="{{$manifest->TMANIFEST_PK}}">
                                            <button class="btn btn-info btn-sm DokNpe" type="button">Search</button>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tgl Dokumen</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                       
                                            <input type="text" id="" name="TGL_NPE" class="form-control" value="{{$manifest->TGL_NPE}}" readonly>
                                        </div>
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama Exportir</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="" name="TGL_NPE" class="form-control" value="{{$manifest->NAMA_IMP}}" readonly>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">NPWP Eksportir</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        
                                            <input type="text" id="" name="" class="form-control" value="{{$manifest->NPWP_IMP}}" readonly>
                                      
                                    </div>
                                </div>
                            </div>


                      
                    </div>
                    <div class="col-md-6"> 
                       
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Desc of Goods</label>
                          <div class="col-sm-8">
                              <textarea class="form-control" id="DESCOFGOODS" name="DESCOFGOODS" rows="3" disabled> {{ old('DESCOFGOODS', $manifest->DESCOFGOODS) }}</textarea>
                          </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">QTY</label>
                            <div class="col-sm-2">
                                <input type="number" id="QUANTITY" name="QUANTITY" class="form-control" value="{{$manifest->QUANTITY}}" disabled>
                            </div>
                            <label class="col-sm-2 control-label">Packing</label>
                            <div class="col-sm-4">
                                <select class="form-control select2" id="TPACKING_FK" name="TPACKING_FK"  style="width: 100%;" tabindex="-1" aria-hidden="true" disabled>
                                    @foreach($packings as $packing)                                               
                                        <option value="{{ $packing->TPACKING_PK }}" {{ $packing->TPACKING_PK == $manifest->TPACKING_FK ? 'selected' : '' }}>
                                             {{ $packing->NAMAPACKING }}
                                         </option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Weight</label>
                            <div class="col-sm-3">
                                <input type="text" id="WEIGHT" name="WEIGHT" value="{{$manifest->WEIGHT}}" class="form-control" disabled>
                            </div>
                            <label class="col-sm-2 control-label">Meas</label>
                            <div class="col-sm-3">
                                <input type="text" id="MEAS" name="MEAS" value="{{$manifest->MEAS}}" class="form-control" disabled>
                            </div>
                        </div>
                        
                        <div class="form-group">
                       
                        <div class="form-group">
                            <label class="col-sm-3 control-label">QTY Tally</label>
                            <div class="col-sm-8">
                                <input type="number" id="final_qty" name="final_qty" value="{{$manifest->final_qty}}" class="form-control" disabled>
                            </div>
                        </div> 
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Muat</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_MUAT" name="PEL_MUAT" style="width: 100%;" tabindex="-1" aria-hidden="true" disabled>
                                        <option value="">Choose Pelabuhan Muat</option>
                                        @if($manifest->PEL_MUAT)
                                            <option value="{{$manifest->PEL_MUAT}}" selected="selected">{{$manifest->PEL_MUAT}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Transit</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_TRANSIT" name="PEL_TRANSIT" style="width: 100%;" tabindex="-1" aria-hidden="true" disabled>
                                        <option value="">Choose Pelabuhan Transit</option>
                                        @if($manifest->PEL_TRANSIT)
                                            <option value="{{$manifest->PEL_TRANSIT}}" selected="selected">{{$manifest->PEL_TRANSIT}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Pel. Bongkar</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2" id="PEL_BONGKAR" name="PEL_BONGKAR" style="width: 100%;" tabindex="-1" aria-hidden="true" disabled>
                                        <option value="">Choose Pelabuhan Bongkar</option>
                                        @if($manifest->PEL_BONGKAR)
                                            <option value="{{$manifest->PEL_BONGKAR}}" selected="selected">{{$manifest->PEL_BONGKAR}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>        
                    </div>
                </div>
                </div>
                <div class="footer">
                  
                    <a href="{{ route('exp-manifest-index') }}" class="btn btn-danger">Back</a>
                </div>
            </form>
            @endif
    </div>
</div>

<div id="photo-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="modal">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="upload-title"></h4>
            </div>
            <form class="form-horizontal" id="upload-photo-form" action="{{ route('lcl-manifest-upload-photo','photo_stripping') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_hbl" name="id_hbl" required>   
                            <input type="hidden" id="no_hbl" name="no_hbl" required>    
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

@endsection

@section('custom_css')


<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>

<script type="text/javascript">
    $('select').select2();
  
    $('#npwp').mask("99.999.999.9-999.999");
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd' 
    });
    $('.approve-manifest-btn').on('click', function() {
        console.log('ok');
        console.log($(this).data('id'));
    });
    
    $("#add-consignee-btn").on("click", function(e){
        e.preventDefault();
        $("#consignee-modal").modal('show');
        return false;
    });
    
    $("#upload-photo-btn").on("click", function(e){
        e.preventDefault();
        $("#photo-modal").modal('show');
        return false;
    });
    
    $("#delete-photo-btn").on("click", function(e){
        if(!confirm('Apakah anda yakin akan menghapus photo?')){return false;}
        
        $('#load_photos').html('');
        $('#delete_photo').val('Y');
    });
    
    $("#create-consignee-form").on("submit", function(){
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
                console.log(json);

                if(json.success) {
                    $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                    $("#TCONSIGNEE_FK").append('<option value="'+json.data.id+'" selected="selected">'+json.data.NAMAPERUSAHAAN+'</option>');
                    $("#TCONSIGNEE_FK").trigger('change');
                    $("#consignee-modal").modal('hide');
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
        minimumInputLength: 3,
//        templateResult: formatRepo, // omitted for brevity, see the source of this page
//        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
    
</script>

<script>
$(document).on('click', '.DokNpe', function(e) {
    e.preventDefault();
    var KODE_DOKUMEN = $('#KODE_DOKUMEN').val();
    var NO_NPE = $('#npe').val();
    var id = $('#idMan').val();
    var data = {
        'KODE_DOKUMEN' :$('#KODE_DOKUMEN').val(),
        'NO_NPE' :$('#npe').val(),
        'id' : $('#idMan').val(),
   
    }

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: "{{ route('cari-npe') }}", // Sesuaikan dengan alias rute yang benar
        method: "POST",
        data: data,
        success: function(response) {
            if (response.success) {
                alert("Data ditemukan: " + response.message);
                window.location.reload();

            } else {
                alert("Error: " + response.message);
                $("#npe").val('');
            }
        },
        error: function(xhr, status, error) {
            console.error("Request failed: " + status + ", " + error);
        }
    });

});
</script>

@endsection