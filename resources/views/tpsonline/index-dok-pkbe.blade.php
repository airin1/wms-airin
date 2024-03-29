@extends('layout')

@section('content')
<style>
    .datepicker.dropdown-menu {
        /*z-index: 100 !important;*/
    }
    .ui-jqgrid tr.jqgrow td {
        word-wrap: break-word; /* IE 5.5+ and CSS3 */
        white-space: pre-wrap; /* CSS3 */
        white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
        white-space: -pre-wrap; /* Opera 4-6 */
        white-space: -o-pre-wrap; /* Opera 7 */
        overflow: hidden;
        height: auto;
        vertical-align: middle;
        padding-top: 3px;
        padding-bottom: 3px
    }
</style>
<script>
 
    function gridCompleteEvent()
    {
        var ids = jQuery("#tpsDokPKBEGrid").jqGrid('getDataIDs'),
            edt = '',
            del = ''; 
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            
            edt = '<a href="{{ route("tps-dokpkbe-edit",'') }}/'+cl+'"><i class="fa fa-pencil"></i></a> ';
//            del = '<a href="{{ route("lcl-register-delete",'') }}/'+cl+'" onclick="if (confirm(\'Are You Sure ?\')){return true; }else{return false; };"><i class="fa fa-close"></i></a>';
            jQuery("#tpsDokPKBEGrid").jqGrid('setRowData',ids[i],{action:edt}); 
        } 
    }
    
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">TPS Dokumen NPE</h3>
   
    </div>
    <div class="box-body table-responsive">
        <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-md-8">
                <div class="col-xs-12">Search By Date</div>
                <div class="col-xs-12">&nbsp;</div>
                <div class="col-xs-3">
                    <select class="form-control select2" id="by" name="by" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="TGL_UPLOAD">Tgl. Upload</option>
                   </select>
                </div>
                <div class="col-xs-3">
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
                <div class="col-xs-3">
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
            GridRender::setGridId("tpsDokPKBEGrid")
            ->enableFilterToolbar()
          //  ->setGridOption('mtype', 'POST')
            ->setGridOption('url', URL::to('/tpsonline/penerimaan/dok-pkbe/grid-data'))
            ->setGridOption('rowNum', 100)
            ->setGridOption('shrinkToFit', true)
            ->setGridOption('sortname','TPS_DOKPKBE_PK')
            ->setGridOption('rownumbers', true)
            ->setGridOption('height', '295')
            ->setGridOption('rownumWidth', 50)
            ->setGridOption('rowList',array(100,200,500))
            ->setGridOption('useColSpanStyle', true)
            ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
            ->setNavigatorOptions('view',array('closeOnEscape'=>false))
            ->setFilterToolbarOptions(array('autosearch'=>true))
            ->setGridEvent('gridComplete', 'gridCompleteEvent')
            ->addColumn(array('label'=>'Action','index'=>'action', 'width'=>80, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
            ->addColumn(array('key'=>true,'index'=>'TPS_DOKPKBE_PK','hidden'=>true))

            ->addColumn(array('label'=>'Kode Kantor','index'=>'KD_KANTOR','width'=>120,'align'=>'center'))
            ->addColumn(array('label'=>'No PKBE','index'=>'NOPKBE','width'=>200,'align'=>'center'))
            ->addColumn(array('label'=>'CAR','index'=>'CAR','width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. PKBE','index'=>'TGLPKBE','width'=>180,'align'=>'center'))
            ->addColumn(array('index'=>'ID Consigne ','index'=>'NPWP_EKS','width'=>200,'hidden'=>true))
            ->addColumn(array('label'=>'Consignee','index'=>'NAMA_EKS','width'=>350))
            ->addColumn(array('label'=>'No Container','index'=>'NO_CONT','width'=>120,'align'=>'center'))
            ->addColumn(array('label'=>'Size','index'=>'SIZE','width'=>60,'align'=>'center'))
       

            ->renderGrid()
        }}
        
        <div class="row" style="margin: 30px 0 0;">
            <button class="btn btn-info" id="upload-on-demand"><i class="fa fa-upload"></i> Upload On Demand</button>
        </div>
    </div>
</div>
<div id="ondemand-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Upload Dokumen NPE</h4>
            </div>
            <form class="form-horizontal" action="{{ route('tps-dokPKBEOnDemand-get') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. PKBE</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="no_pkbe" />
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">Tgl. PKBE</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="tgl_pkbe" class="form-control pull-right datepicker" required />
                                    </div>
                                </div>
                            </div>
							<div class="form-group">
                                <label class="col-sm-3 control-label">Kode Kantor</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="kd_kantor" value="040300" />
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
        format: 'yyyy-mm-dd',
        zIndex: 99
    });
    
    $('.tgldok_datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'ddmmyyyy',
        zIndex: 999999
    });
    
    $('#searchByDateBtn').on("click", function(){
        var by = $("#by").val();
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        jQuery("#tpsDokPKBEGrid").jqGrid('setGridParam',{url:"{{URL::to('/tpsonline/penerimaan/dok-pkbe/grid-data')}}?startdate="+startdate+"&enddate="+enddate+"&by="+by}).trigger("reloadGrid");
        return false;
    });
    
    $('#upload-on-demand').on("click", function(){
        $('#ondemand-modal').modal('show');
    });
</script>

@endsection