@extends('layout')

@section('content')
<style>
    .datepicker.dropdown-menu {
        z-index: 100 !important;
    }
</style>
<script>
 
    function gridCompleteEvent()
    {
        var ids = jQuery("#fclRegisterGrid").jqGrid('getDataIDs'),
            edt = '',
            del = ''; 
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            
            edt = '<a href="{{ route("fcl-register-edit",'') }}/'+cl+'"><i class="fa fa-pencil"></i></a> ';
            del = '<a href="{{ route("fcl-register-delete",'') }}/'+cl+'" onclick="if (confirm(\'Apakah anda yakin akan menghapus data register ? Semua Container di dalamnya akan ikut terhapus.\')){return true; }else{return false; };"><i class="fa fa-close"></i></a>';
            jQuery("#fclRegisterGrid").jqGrid('setRowData',ids[i],{action:edt+' '+del}); 
        } 
    }
    
    function onSelectRowEvent()
    {
        rowid = $('#fclRegisterGrid').jqGrid('getGridParam', 'selrow');
        rowdata = $('#fclRegisterGrid').getRowData(rowid);

        $("#refid").val(rowdata.TCONTAINER_PK);
        $("#nocont").html(rowdata.NOCONTAINER);      
    }
    
    $(document).ready(function(){

        $('#print-barcode-btn').on("click", function(){

            var $grid = $("#fclRegisterGrid"), selIds = $grid.jqGrid("getGridParam", "selarrrow"), i, n,
                cellValues = [];
            for (i = 0, n = selIds.length; i < n; i++) {
                cellValues.push($grid.jqGrid("getCell", selIds[i], "TCONTAINER_PK"));
            }
            
            var containerId = cellValues.join(",");
            
            if(!containerId) {alert('Silahkan pilih kontainer terlebih dahulu!');return false;}               
            if(!confirm('Apakah anda yakin akan melakukan print barcode? Anda telah memilih '+cellValues.length+' kontainer!')){return false;}    
            
//            console.log(containerId);
            window.open("{{ route('cetak-barcode', array('','','')) }}/"+containerId+"/fcl/get","preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes");    
        });
        
        $("#rfid-btn").on("click", function(){
            if($("#refid").val() != ''){
                $('#rfid-modal').modal('show');
                $('#code').focus();
            }else{
                alert('Silahkan pilih kontainer terlebih dahulu!');
                return false;
            }
        });
        
        $('#rfid-modal').on('shown.bs.modal', function () {
            $('#code').focus();
        });  
        
        $('#code').on('input', function(){
//            delay(function(){
                if ($("#code").val().length == 10) {
                    $('#create-rfid-form').submit();
                }
//             }, 20 );           
        });
    });
    
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">FCL Register Lists</h3>
        <div class="box-tools">
            <a href="{{ route('fcl-register-create') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="box-body table-responsive">
        <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-md-6">
                <div class="col-xs-12">Search By Date</div>
                <div class="col-xs-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" id="startdate" class="form-control pull-right datepicker">
                    </div>
                </div>
                <div class="col-xs-1">
                    s/d
                </div>
                <div class="col-xs-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" id="enddate" class="form-control pull-right datepicker">
                    </div>
                </div>
                <div class="col-xs-2">
                    <button id="searchByDateBtn" class="btn btn-default">Search</button>
                </div>
            </div>
        </div>
        {{
            GridRender::setGridId("fclRegisterGrid")
            ->enableFilterToolbar()
            ->setGridOption('mtype', 'POST')
            ->setGridOption('url', URL::to('/fcl/joborder/grid-data?_token='.csrf_token()))
            ->setGridOption('rowNum', 50)
            ->setGridOption('shrinkToFit', true)
            ->setGridOption('sortname','TCONTAINER_PK')
            ->setGridOption('sortorder','DESC') 
            ->setGridOption('rownumbers', true)
            ->setGridOption('rownumWidth', 50)
            ->setGridOption('height', '295')
            ->setGridOption('multiselect', true)
            ->setGridOption('rowList',array(50,100,200,500))
            ->setGridOption('useColSpanStyle', true)
            ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
            ->setNavigatorOptions('view',array('closeOnEscape'=>false))
            ->setFilterToolbarOptions(array('autosearch'=>true))
            ->setGridEvent('gridComplete', 'gridCompleteEvent')
            ->setGridEvent('onSelectRow', 'onSelectRowEvent')
            ->addColumn(array('label'=>'Action','index'=>'action', 'width'=>80, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
//            ->addColumn(array('key'=>true,'index'=>'TJOBORDER_PK','hidden'=>true))  
            ->addColumn(array('key'=>true,'index'=>'TCONTAINER_PK','hidden'=>true))
//            ->addColumn(array('index'=>'TCONSIGNEE_FK','hidden'=>true))  
            ->addColumn(array('label'=>'No. Job Order','index'=>'NOJOBORDER','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'No. SPK','index'=>'NOSPK','width'=>160))
            ->addColumn(array('label'=>'No. MBL','index'=>'NOMBL','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Tgl. MBL','index'=>'TGLMBL','width'=>150,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>250,'hidden'=>true))
            ->addColumn(array('label'=>'No. Container','index'=>'NOCONTAINER','width'=>160,'hidden'=>false))           
            ->addColumn(array('label'=>'Consignee','index'=>'CONSIGNEE','width'=>250,'hidden'=>false))
            ->addColumn(array('label'=>'No. BC11','index'=>'NO_BC11','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. BC11','index'=>'TGL_BC11','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. POS BC11','index'=>'NO_POS_BC11','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'No. PLP','index'=>'NO_PLP','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. PLP','index'=>'TGL_PLP','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'ETA','index'=>'ETA', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'ETD','index'=>'ETD', 'width'=>150,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'Vessel','index'=>'VESSEL', 'width'=>150))
            ->addColumn(array('label'=>'Callsign','index'=>'CALLSIGN', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Voy','index'=>'VOY','width'=>80,'align'=>'center'))
            ->addColumn(array('label'=>'Teus','index'=>'TEUS', 'width'=>80,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'No. Seal','index'=>'NO_SEAL', 'width'=>120,'align'=>'right','hidden'=>true))
            ->addColumn(array('label'=>'Layout','index'=>'layout','width'=>80,'align'=>'center','hidden'=>true,'hidden'=>true))
            ->addColumn(array('label'=>'UID','index'=>'UID', 'width'=>150,'align'=>'right','align'=>'center'))
//            ->addColumn(array('label'=>'Tgl. Entry','index'=>'TGLENTRY', 'width'=>150,'align'=>'center'))
//            ->addColumn(array('label'=>'Updated','index'=>'last_update', 'width'=>150, 'search'=>false))
            ->renderGrid()
        }}
    </div>
    <button type="button" id="print-barcode-btn" class="btn btn-danger" style="margin: 10px;"><i class="fa fa-print"></i> Print Barcode</button>
    <button type="button" id="rfid-btn" class="btn btn-warning pull-right" style="margin: 10px;"><i class="fa fa-credit-card"></i> Set RFID</button>
</div>

<div id="rfid-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">RFID For <span id="nocont"></span></h4>
            </div>
            <form id="create-rfid-form" class="form-horizontal" action="{{route('set-rfid')}}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                            <input name="refid" type="hidden" id="refid" />
                            <input name="action" type="hidden" value="get" />
                            <input name="type" type="hidden" value="fcl" />
<!--                            <div class="form-group">
                                <label class="col-sm-3 control-label">RFID</label>
                                <div class="col-sm-8">
                                    <select class="form-control select2 select2-hidden-accessible" name="code" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                        <option value="">Choose RFID Card</option>
                                        @foreach($rfids as $rfid)
                                            <option value="{{ $rfid->code }}">{{ $rfid->code }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">RFID Code</label>
                                <div class="col-sm-8">
                                    <input type="text" id="code" name="code" class="form-control" onblur="this.focus()" autofocus placeholder="Scan RFID Card" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        zIndex: 99
    });
    
    $('#searchByDateBtn').on("click", function(){
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        jQuery("#fclRegisterGrid").jqGrid('setGridParam',{url:"{{URL::to('/fcl/joborder/grid-data')}}?startdate="+startdate+"&enddate="+enddate}).trigger("reloadGrid");
        return false;
    });
</script>

@endsection