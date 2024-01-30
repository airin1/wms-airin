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
    <form class="form-horizontal" action="{{ route('exp-register-update', $joborder->TJOBORDER_PK) }}" method="POST">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-6">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Job Order</label>
                        <div class="col-sm-8">
                            <input type="text" name="NOJOBORDER" class="form-control" value="{{ $joborder->NOJOBORDER }}" readonly >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. SPK</label>
                        <div class="col-sm-8">
                            <input type="text" name="NOSPK" class="form-control" value="{{ $joborder->NOSPK }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="NOMBL" class="col-sm-3 control-label">No. Booking</label>
                        <div class="col-sm-8">
                            <input type="text" name="NOBOOKING" class="form-control"  value="{{ $joborder->NOBOOKING }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. Booking</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="TGL_BOOKING" class="form-control pull-right datepicker" value="{{ $joborder->TGL_BOOKING }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Consolidator</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="TCONSOLIDATOR_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Consolidator</option>
                                @foreach($consolidators as $consolidator)
                                    <option value="{{ $consolidator->id }}" @if($consolidator->id == $joborder->TCONSOLIDATOR_FK){{ "selected" }}@endif>{{ $consolidator->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>            
                    <div class="form-group" style="display: none;">
                      <label for="PARTY" class="col-sm-3 control-label">Party</label>
                      <div class="col-sm-8">
                          <input type="text" name="PARTY" class="form-control"  value="{{ $joborder->PARTY }}"> 
                      </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Country</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="TNEGARA_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" @if($country->id == $joborder->TNEGARA_FK){{ "selected" }}@endif>{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Port of Loading</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="TPELABUHAN_FK" name="TPELABUHAN_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Port of Loading</option>
                                @if($joborder->TPELABUHAN_FK)
                                    <option value="{{$joborder->TPELABUHAN_FK}}" selected="selected">{{$joborder->NAMAPELABUHAN}}</option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Vessel</label>
                        <div class="col-sm-8">
                            <!--<input type="text" name="VESSEL" class="form-control"  value="{{ $joborder->VESSEL }}">-->
                            <select class="form-control select2" id="vessel" name="VESSEL" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Vessel</option>
                                @foreach($vessels as $vessel)
                                    <option value="{{ $vessel->name }}" data-code="{{ $vessel->code }}" data-callsign="{{ $vessel->callsign }}" @if($vessel->name == $joborder->VESSEL){{ "selected" }}@endif>{{ $vessel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Voy</label>
                        <div class="col-sm-3">
                            <input type="text" name="VOY" class="form-control"  value="{{ $joborder->VOY }}">
                        </div>
                        <label class="col-sm-2 control-label">Callsign</label>
                        <div class="col-sm-3">
                            <input type="text" name="CALLSIGN" class="form-control"  readonly value="{{ $joborder->CALLSIGN }}">
                        </div>
                    </div>             
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. ETA</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="ETA" class="form-control pull-right datepicker"  value="{{ $joborder->ETA }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Shipping Line</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="TSHIPPINGLINE_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Shipping Line</option>
                                @foreach($shippinglines as $shippingline)
                                    <option value="{{ $shippingline->id }}" @if($shippingline->id == $joborder->TSHIPPINGLINE_FK){{ "selected" }}@endif>{{ $shippingline->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Tgl. ETD</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="ETD" class="form-control pull-right datepicker"  value="{{ $joborder->ETD }}">
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lokasi Sandar</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" name="TLOKASISANDAR_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Lokasi Sandar</option>
                                @foreach($lokasisandars as $lokasisandar)
                                    <option value="{{ $lokasisandar->id }}" @if($lokasisandar->id == $joborder->TLOKASISANDAR_FK){{ "selected" }}@endif>{{ $lokasisandar->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6"> 
                    <div class="form-group">                       
                        <label class="col-sm-3 control-label">Kode Gudang</label>
                        <div class="col-sm-3">
                            <input type="text" name="KODE_GUDANG" value="{{ $joborder->KODE_GUDANG }}" class="form-control">
                        </div>
                        <label class="col-sm-2 control-label">Tujuan</label>
                        <div class="col-sm-3">
                            <input type="text" name="GUDANG_TUJUAN" value="{{ $joborder->GUDANG_TUJUAN }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jenis Kegiatan</label>
                        <div class="col-sm-8">
                            <input type="text" name="JENISKEGIATAN" value="{{ $joborder->JENISKEGIATAN }}" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Gross Weight</label>
                        <div class="col-sm-3">
                            <input type="text" name="GROSSWEIGHT" class="form-control"  value="{{ $joborder->GROSSWEIGHT }}">
                        </div>
                        
                    </div> 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Total Booking</label>
                        <div class="col-sm-8">
                            <input type="number" name="JUMLAHHBL" class="form-control"  value="{{ $joborder->JUMLAHHBL }}">
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Measurment</label>
                        <div class="col-sm-3">
                            <input type="text" name="MEASUREMENT" class="form-control"  value="{{ $joborder->MEASUREMENT }}">
                        </div>
                        <label class="col-sm-2 control-label">ISO Code</label>
                        <div class="col-sm-3">
                            <input type="text" name="ISO_CODE" class="form-control"  value="{{ $joborder->ISO_CODE }}">
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Description</label>
                      <div class="col-sm-8">
                          <textarea class="form-control" name="KETERANGAN" rows="3" placeholder="Description...">{{ $joborder->KETERANGAN }}</textarea>
                      </div>
                    </div>
                 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pel. Muat</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_MUAT" name="PEL_MUAT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Pelabuhan Muat</option>
                                @if($joborder->PEL_MUAT)
                                    <option value="{{$joborder->PEL_MUAT}}" selected="selected">{{$joborder->PEL_MUAT}}</option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label">Pel. Transit</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_TRANSIT" name="PEL_TRANSIT" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Pelabuhan Transit</option>
                                @if($joborder->PEL_TRANSIT)
                                    <option value="{{$joborder->PEL_TRANSIT}}" selected="selected">{{$joborder->PEL_TRANSIT}}</option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Pel. Bongkar</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="PEL_BONGKAR" name="PEL_BONGKAR" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Pelabuhan Bongkar</option>
                                @if($joborder->PEL_BONGKAR)
                                    <option value="{{$joborder->PEL_BONGKAR}}" selected="selected">{{$joborder->PEL_BONGKAR}}</option>
                                @endif

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('exp-register-index') }}" class="btn btn-danger pull-right" style="margin-right: 10px;"><i class="fa fa-close"></i> Keluar</a>
        </div>
        <!-- /.box-footer -->
    </form>
</div>

<script>
    function onSelectRowEvent(rowid, status, e)
    {
        $('#cetak-permohonan').prop("disabled",false);
    }
</script>

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Form Container</h3>
      <div class="box-tools pull-right">
      </div>
    </div>
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
                            @foreach($conts as $cont)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-warning editCont" data-id="{{$cont->TCONTAINER_PK}}"><i class="fa fa-pencil"></i></button>
                                    <button type="button" class="btn btn-danger deletedCont" data-id="{{$cont->TCONTAINER_PK}}"><i class="fa fa-trash"></i></button>
                                </td>
                                <td>{{$cont->NOCONTAINER}}</td>
                                <td>{{$cont->SIZE}}</td>
                                <td>{{$cont->CTR_STATUS}}</td>
                                <td>{{$cont->TEUS}}</td>
                                <td>{{$cont->NO_SEAL}}</td>
                                <td>{{$cont->WEIGHT}}</td>
                                <td>{{$cont->MEAS}}</td>
                                <td>{{$cont->TGLENTRY}}</td>
                                <td>{{$cont->last_update}}</td>
                                <td>{{$cont->UID}}</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <button id="addContainer" type="button" class="btn btn-sm"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="col-md-12">

                </div>
            </div>
                
        </div>
    </div>
</div>




<!-- Modal Conts-->
<div id="addCont" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add Container</h4>
            </div>
            <form class="form-horizontal" action="{{ route('create-register-cont') }}" method="POST">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Container</label>
                                <div class="col-sm-8">
                                    <input type="text" name="NOCONTAINER" class="form-control" > 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Size</label>
                                <div class="col-sm-8">
                                    <select name="SIZE" id="" class="form-control">
                                        <option value="20">20</option>
                                        <option value="40">40</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="CTR_STATUS" id="" class="form-control">
                                        <option value="LCL">LCL</option>
                                        <option value="FCL">FCL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Seal</label>
                                <div class="col-sm-8">
                                    <input type="text" name="NO_SEAL" class="form-control" > 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Weight</label>
                                <div class="col-sm-8">
                                    <input type="text" name="WEIGHT" class="form-control" > 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Measurment</label>
                                <div class="col-sm-8">
                                    <input type="text" name="MEAS" class="form-control" > 
                                </div>
                                <input type="hidden" name="id" class="form-control" value="{{$joborder->TJOBORDER_PK}}"> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="EditCont" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Container</h4>
            </div>
         
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Container</label>
                                <div class="col-sm-8">
                                    <input type="text" id="NOCONTAINER_EDIT" name="NOCONTAINER" class="form-control" > 
                                    <input type="hidden" id="TCONTAINER_PK_EDIT" name="TCONTAINER_PK" class="form-control" > 
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Size</label>
                                <div class="col-sm-8">
                                    <select name="SIZE" id="SIZE_EDIT" class="form-control">
                                        <option value="20">20</option>
                                        <option value="40">40</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="CTR_STATUS" id="CTR_STATUS_EDIT" class="form-control">
                                        <option value="LCL">LCL</option>
                                        <option value="FCL">FCL</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No Seal</label>
                                <div class="col-sm-8">
                                    <input type="text" id="NO_SEAL_EDIT" name="NO_SEAL" class="form-control" > 
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Weight</label>
                                <div class="col-sm-8">
                                    <input type="text" id="WEIGHT_EDIT" name="WEIGHT" class="form-control" > 
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Measurment</label>
                                <div class="col-sm-8">
                                    <input type="text" name="MEAS" id="MEAS_EDIT" class="form-control" > 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary UpdateCont">Edit</button>
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
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd' 
    });
    $('#vessel').on("change", function (e) { 
        $('input[name="CALLSIGN"]').val($(this).find(":selected").data("callsign"));
    });
    $('#cetak-permohonan').click(function()
    {
        //Gets the selected row id.
        var rowid = $('#containerGrid').jqGrid('getGridParam', 'selrow'),
            rowdata = $('#containerGrid').getRowData(rowid);
        
        if(rowid){
            $('#cetak-permohonan-modal').modal('show');
            $("#container_id").val(rowid);
        }else{
            alert('Please Select Container.');
        }
    });
    $('#upload-file').on("click", function(){
        $('#upload-file-modal').modal('show');
    });
    $('#addContainer').on("click", function(){
        $('#addCont').modal('show');
    });
    $('#upload-xls-file').on("click", function(){
        $('#upload-xls-file-modal').modal('show');
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
        minimumInputLength: 3,
//        templateResult: formatRepo, // omitted for brevity, see the source of this page
//        templateSelection: formatRepoSelection // omitted for brevity, see the source of this page
    });
</script>
<script>
  $(function() {
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $(document).on('click', '.editCont', function() {
      let id = $(this).data('id');
      $.ajax({
         type: 'GET',
         url: "{{ route('edit-register-cont', ['id' => '']) }}/" + id,
         cache: false,
         data: {
            id: id
         },
         dataType: 'json',
         success: function(response) {
            console.log(response);
            $('#EditCont').modal('show');
            // $('#edit #cont').val(response.data.container_no);
            // $('#edit #contKey').val(response.data.container_key);
            $('#EditCont #NOCONTAINER_EDIT').val(response.cont.NOCONTAINER);
            $('#EditCont #TCONTAINER_PK_EDIT').val(response.cont.TCONTAINER_PK);
            $('#EditCont #SIZE_EDIT').val(response.cont.SIZE);
            $('#EditCont #WEIGHT_EDIT').val(response.cont.WEIGHT);
            $('#EditCont #NO_SEAL_EDIT').val(response.cont.NO_SEAL);
            $('#EditCont #MEAS_EDIT').val(response.cont.MEAS);
            $('#EditCont #CTR_STATUS_EDIT').val(response.cont.CTR_STATUS);

        
         },
         error: function(data) {
            console.log('error:', data);
         }
      });
   });

   $(document).on('click', '.deletedCont', function(e) {
        e.preventDefault();
        var containerId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'Anda yakin ingin menghapus container?',
            icon: 'warning',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Hapus',
        }).then((result) => {
            if (result.isConfirmed) {
                // Lakukan penghapusan container melalui AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('delete-container-register') }}", // Ganti dengan URL yang sesuai
                    data: { id: containerId },
                    cache: false,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success')
                                .then(() => {
                                    // Refresh halaman setelah berhasil menghapus container
                                    window.location.reload();
                                });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(response) {
                        Swal.fire('Error', 'Gagal menghubungi server.', 'error');
                    },
                });
            }
        });
    });

});

</script>

<script>
  $(document).on('click', '.UpdateCont', function(e) {
    e.preventDefault();
    var NOCONTAINER = $('#NOCONTAINER_EDIT').val();
    var TCONTAINER_PK = $('#TCONTAINER_PK_EDIT').val();
    var SIZE = $('#SIZE_EDIT').val();
    var WEIGHT = $('#WEIGHT_EDIT').val();
    var NO_SEAL = $('#NO_SEAL_EDIT').val();
    var MEAS = $('#MEAS_EDIT').val();
   
    var data = {
      'NOCONTAINER' : $('#NOCONTAINER_EDIT').val(),
      'TCONTAINER_PK' : $('#TCONTAINER_PK_EDIT').val(),
      'SIZE' : $('#SIZE_EDIT').val(),
      'WEIGHT' : $('#WEIGHT_EDIT').val(),
      'NO_SEAL' : $('#NO_SEAL_EDIT').val(),
      'MEAS' : $('#MEAS_EDIT').val(),
      'CTR_STATUS' : $('#CTR_STATUS_EDIT').val(),
     


    }
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Are you Sure?',
      text: "Change " + NOCONTAINER + " With New Data ? ",
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
          url: "{{ route('udpate-container-register') }}",
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