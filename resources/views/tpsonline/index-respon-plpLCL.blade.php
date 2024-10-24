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
        var ids = jQuery("#tpsResponPlpGrid").jqGrid('getDataIDs'),
            edt = '',
            del = ''; 
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            
            edt = '<a href="{{ route("tps-responPlp-edit",'') }}/'+cl+'"><i class="fa fa-pencil"></i></a> ';
//            del = '<a href="{{ route("lcl-register-delete",'') }}/'+cl+'" onclick="if (confirm(\'Are You Sure ?\')){return true; }else{return false; };"><i class="fa fa-close"></i></a>';
            jQuery("#tpsResponPlpGrid").jqGrid('setRowData',ids[i],{action:edt}); 
        } 
    }
    
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">TPS Respon PLP</h3>
        <div class="box-tools">
            <a href="{{ route('tps-responPlp-get') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Get Data</a>
        </div>
    </div>
    <div class="box-body table-responsive">
        <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-md-8">
                <div class="col-xs-12">Search By Date</div>
                <div class="col-xs-12">&nbsp;</div>
                <div class="col-xs-3">
                    <select class="form-control select2" id="by" name="by" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="TGL_UPLOAD">Tgl. Upload</option>
                        <option value="TGL_PLP">Tgl. PLP</option>
                        <option value="TGL_SURAT">Tgl. Surat</option>
                        <option value="TGL_BC11">Tgl. BC11</option>
                        <option value="TGL_TIBA">Tgl. Tiba</option>                       
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
            GridRender::setGridId("tpsResponPlpGrid")
            ->enableFilterToolbar()
            ->setGridOption('mtype', 'POST')
            ->setGridOption('url', URL::to('/tpsonline/penerimaan/respon-plp/grid-data?jenis=lcl&_token='.csrf_token()))
            ->setGridOption('rowNum', 20)
            ->setGridOption('shrinkToFit', true)
            ->setGridOption('sortname','tps_responplptujuanxml_pk')
			->setGridOption('sortorder','DESC')
            ->setGridOption('rownumbers', true)
            ->setGridOption('height', '295')
            ->setGridOption('rowList',array(20,50,100))
            ->setGridOption('useColSpanStyle', true)
            ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
            ->setNavigatorOptions('view',array('closeOnEscape'=>false))
            ->setFilterToolbarOptions(array('autosearch'=>true))
            ->setGridEvent('gridComplete', 'gridCompleteEvent')
            ->addColumn(array('label'=>'Action','index'=>'action', 'width'=>80, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
            ->addColumn(array('key'=>true,'index'=>'tps_responplptujuanxml_pk','hidden'=>true))
            ->addColumn(array('label'=>'No. Surat PLP','index'=>'NO_SURAT','width'=>250,'align'=>'left','hidden'=>false))
            ->addColumn(array('label'=>'Tgl. Surat PLP','index'=>'TGL_SURAT','width'=>160,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'No. PLP','index'=>'NO_PLP','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. PLP','index'=>'TGL_PLP','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Call Sign','index'=>'CALL_SIGN','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Nama Angkut','index'=>'NM_ANGKUT','width'=>160))
            ->addColumn(array('label'=>'No. Voy Flight','index'=>'NO_VOY_FLIGHT','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. Tiba','index'=>'TGL_TIBA','width'=>160,'align'=>'center'))	
            ->addColumn(array('label'=>'No. BC11','index'=>'NO_BC11','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. BC11','index'=>'TGL_BC11','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Kode Kantor','index'=>'KD_KANTOR','width'=>160,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'Kode TPS','index'=>'KD_TPS_TUJUAN','width'=>160,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'TPS Asal','index'=>'KD_TPS_ASAL','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Gudang Tujuan','index'=>'GUDANG_TUJUAN','width'=>160,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'Gudang Asal','index'=>'GUDANG_ASAL','width'=>160,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'Jenis','index'=>'JNS_CONT','width'=>100,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'Updated','index'=>'LASTUPDATE','width'=>160,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'UID','index'=>'UID','width'=>160,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'YOR TPS Asal','index'=>'YOR_TPS_ASAL','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'YOR TPS Tujuan','index'=>'YOR_TPS_TUJUAN','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Alasan Reject','index'=>'ALASAN_REJECT','width'=>250,'hidden'=>false))
            ->addColumn(array('label'=>'Lampiran','index'=>'LAMPIRAN','width'=>160,'hidden'=>true))          
            ->addColumn(array('label'=>'Flag SPK','index'=>'FLAG_SPK','width'=>160,'hidden'=>true))
            ->addColumn(array('index'=>'TCONSOLIDATOR_FK','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Alasan Pindah','index'=>'APL','width'=>160,'hidden'=>true))
            ->addColumn(array('label'=>'Tgl. Upload','index'=>'TGL_UPLOAD','width'=>160,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. Upload','index'=>'UPLOAD_DATE','width'=>160,'align'=>'center','hidden'=>true))	
            ->addColumn(array('label'=>'Jam Upload','index'=>'UPLOAD_TIME','width'=>160,'align'=>'center','hidden'=>true))
            ->renderGrid()
        }}
        <div class="row" style="margin: 30px 0 0;">
            <button class="btn btn-info" id="upload-plp-btn"><i class="fa fa-upload"></i> On Demand</button>
        </div>
    </div>
</div>

<div id="upload-plp-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Get Respon PLP On Demand</h4>
            </div>
            <form class="form-horizontal" action="{{ route('tps-responPlp-onDemand') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
							<label class="col-sm-3 control-label">Lokasi Gudang</label>
							  <div class="col-sm-8">
							   <select class="form-control select2" id="KODE_GUDANG" name="KODE_GUDANG" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                 <option value="">Choose Lokasi Gudang</option>
                                 <option value="ARN1">ARN1</option>
                                 <option value="ARN3">ARN3</option>
                               </select>
                              </div>
                            </div>							
							<div class="form-group">
                                <label class="col-sm-3 control-label">NO. PLP</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="no_plp" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tgl. PLP</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="tgl_plp" class="form-control pull-right datepicker" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Ref Number</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="refnumber" />
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
    
    $('#searchByDateBtn').on("click", function(){
        var by = $("#by").val();
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        console.log(by);
        jQuery("#tpsResponPlpGrid").jqGrid('setGridParam',{url:"{{URL::to('/tpsonline/penerimaan/respon-plp/grid-data')}}?jenis=fcl&jenis=lcl&startdate="+startdate+"&enddate="+enddate+"&by="+by}).trigger("reloadGrid");
        return false;
    });
    
    $('#upload-plp-btn').on("click", function(){
        $('#upload-plp-modal').modal('show');
    });
</script>

@endsection