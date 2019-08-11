@extends('layout')

@section('content')
<style>
    .bootstrap-timepicker-widget {
        left: 27%;
    }
</style>
<script>
    
    function onSelectRowEvent()
    {
        $('#btn-group-4').enableButtonGroup();
        
        rowid = $('#lclReleaseGrid').jqGrid('getGridParam', 'selrow');
        rowdata = $('#lclReleaseGrid').getRowData(rowid);

        $("#container_id").val(rowdata.TCONTAINER_PK);
    }
    
    $(document).ready(function()
    {
        $('#release-form').disabledFormGroup();
        $('#btn-toolbar').disabledButtonGroup();
        
        
        $('#btn-invoice').on("click", function(){
            $('#create-invoice-modal').modal('show');
        });
        
        $('#create-invoice-form').on("submit", function(){
            if(!confirm('Apakah anda yakin?')){return false;}
            
            //Gets the selected row id.
            rowid = $('#lclReleaseGrid').jqGrid('getGridParam', 'selrow');
            rowdata = $('#lclReleaseGrid').getRowData(rowid);
            
//            if(rowdata.INVOICE == ''){
//                alert('Please Select Type of Invoice');
//                return false;
//            }
        });
        
//        $('#btn-invoice').click(function() {
//            if(!confirm('Apakah anda yakin?')){return false;}
//            
//            //Gets the selected row id.
//            rowid = $('#lclReleaseGrid').jqGrid('getGridParam', 'selrow');
//            rowdata = $('#lclReleaseGrid').getRowData(rowid);
//            
//            if(rowdata.INVOICE == ''){
//                alert('Please Select Type of Invoice');
//                return false;
//            }
//            
//            var manifestId = rowdata.TMANIFEST_PK;
//            var url = '{{ route("lcl-delivery-release-invoice") }}';
//            
//            $.ajax({
//                type: 'POST',
//                data: 
//                {
//                    'id' : manifestId,
//                    '_token' : '{{ csrf_token() }}'
//                },
//                dataType : 'json',
//                url: url,
//                error: function (jqXHR, textStatus, errorThrown)
//                {
//                    alert('Something went wrong, please try again later.');
//                },
//                beforeSend:function()
//                {
//
//                },
//                success:function(json)
//                {
//                    console.log(json);
//
//                    if(json.success) {
//                      $('#alert-message').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
//                    } else {
//                      $('#alert-message').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
//                    }
//
//                    //Triggers the "Close" button funcionality.
//                    $('#btn-refresh').click();
//                }
//            });
//            
//        });
        
    });
    
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">LCL Delivery Release</h3>
        <div class="box-tools" id="btn-toolbar">
            <div id="btn-group-4">
                <button class="btn btn-info btn-sm" id="btn-invoice"><i class="fa fa-print"></i> Create Invoice</button>
            </div>
        </div>
    </div>
    <div class="box-body">
        <div id="alert-message"></div>
        <div class="row">
            <div class="col-md-12"> 
                {{
                    GridRender::setGridId("lclReleaseGrid")
                    ->enableFilterToolbar()
                    ->setGridOption('mtype', 'POST')
                    ->setGridOption('url', URL::to('/container/grid-data?module=release-invoice&_token='.csrf_token()))
                    ->setGridOption('rowNum', 20)
                    ->setGridOption('shrinkToFit', true)
                    ->setGridOption('sortname','TCONTAINER_PK')
                    ->setGridOption('sortorder','DESC')
                    ->setGridOption('rownumbers', true)
                    ->setGridOption('height', '395')
                    ->setGridOption('rowList',array(20,50,100))
                    ->setGridOption('useColSpanStyle', true)
                    ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
                    ->setNavigatorOptions('view',array('closeOnEscape'=>false))
                    ->setFilterToolbarOptions(array('autosearch'=>true))
                    ->setGridEvent('onSelectRow', 'onSelectRowEvent')
                    ->addColumn(array('key'=>true,'index'=>'TCONTAINER_PK','hidden'=>true))
        //            ->addColumn(array('label'=>'Status','index'=>'VALIDASI','width'=>80, 'align'=>'center'))
                    ->addColumn(array('label'=>'No. Joborder','index'=>'NoJob', 'width'=>150))
                    ->addColumn(array('label'=>'Nama Angkut','index'=>'VESSEL','width'=>160))
                    ->addColumn(array('label'=>'VOY','index'=>'VOY','width'=>100,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'No. Container','index'=>'NOCONTAINER', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Size','index'=>'SIZE', 'width'=>100,'align'=>'center'))
                    ->addColumn(array('label'=>'Jumlah BL','index'=>'jumlah_bl', 'width'=>100,'align'=>'center'))
                    ->addColumn(array('label'=>'Teus','index'=>'TEUS', 'width'=>100,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'ETA','index'=>'ETA', 'width'=>120,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'TPS Asal','index'=>'KD_TPS_ASAL', 'width'=>100,'align'=>'center'))
                    ->addColumn(array('label'=>'Gudang','index'=>'LOKASI_GUDANG', 'width'=>100,'align'=>'center'))
                    ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>250))
                    ->addColumn(array('label'=>'No.PLP','index'=>'NO_PLP', 'width'=>150,'align'=>'center'))                
                    ->addColumn(array('label'=>'Tgl.PLP','index'=>'TGL_PLP', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'No.BC 1.1','index'=>'NO_BC11', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl.BC 1.1','index'=>'TGL_BC11', 'width'=>150,'align'=>'center'))
//                    ->addColumn(array('label'=>'No.POS BC11','index'=>'NO_POS_BC11', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Gate In','index'=>'TGLMASUK', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Gate In','index'=>'JAMMASUK', 'width'=>100,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Stripping','index'=>'TGLSTRIPPING', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Stripping','index'=>'JAMSTRIPPING', 'width'=>100,'align'=>'center'))
//                    ->addColumn(array('label'=>'Tgl. Buang MTY','index'=>'TGLBUANGMTY', 'width'=>120,'align'=>'center'))
//                    ->addColumn(array('label'=>'Jam. Buang MTY','index'=>'JAMBUANGMTY', 'width'=>100,'align'=>'center'))
//                    ->addColumn(array('label'=>'Tujuan MTY','index'=>'NAMADEPOMTY', 'width'=>200,'align'=>'left'))
//                    ->addColumn(array('label'=>'Tgl. Release','index'=>'tglrelease', 'width'=>120,'align'=>'center'))
//                    ->addColumn(array('label'=>'Jam. Release','index'=>'jamrelease', 'width'=>100,'align'=>'center'))
        //            ->addColumn(array('label'=>'Kode Dokumen','index'=>'KODE_DOKUMEN', 'width'=>150))
        //            ->addColumn(array('label'=>'No. SPPB','index'=>'NO_SPPB', 'width'=>150))
        //            ->addColumn(array('label'=>'Tgl. SPPB','index'=>'TGL_SPPB', 'width'=>150))
        //            ->addColumn(array('label'=>'No. SPJM','index'=>'NO_SPJM', 'width'=>150))
        //            ->addColumn(array('label'=>'Tgl. SPJM','index'=>'TGL_SPJM', 'width'=>150))
        //            ->addColumn(array('label'=>'No. POL','index'=>'NOPOL', 'width'=>120,'align'=>'center'))
        //            ->addColumn(array('label'=>'Kode Dokumen','index'=>'KODE_DOKUMEN', 'width'=>150))
        //            ->addColumn(array('label'=>'Shipper','index'=>'SHIPPER','width'=>160))
        //            ->addColumn(array('label'=>'Consignee','index'=>'CONSIGNEE','width'=>160))
        //            ->addColumn(array('label'=>'Notify Party','index'=>'NOTIFYPARTY','width'=>160))            
        //            ->addColumn(array('label'=>'NPWP Consignee','index'=>'NPWP_CONSIGNEE', 'width'=>150))
        //            ->addColumn(array('label'=>'Marking','index'=>'MARKING', 'width'=>150)) 
        //            ->addColumn(array('label'=>'Desc of Goods','index'=>'DESCOFGOODS', 'width'=>150))              
        //            ->addColumn(array('label'=>'Tgl.Behandle','index'=>'tglbehandle', 'width'=>150)) 
        //            ->addColumn(array('label'=>'Surcharge (DG)','index'=>'DG_SURCHARGE', 'width'=>150))
        //            ->addColumn(array('label'=>'Surcharge (Weight)','index'=>'WEIGHT_SURCHARGE', 'width'=>150)) 
        //            ->addColumn(array('label'=>'Tgl. Surat Jalan','index'=>'TGLSURATJALAN', 'width'=>120))
        //            ->addColumn(array('label'=>'Jam. Surat Jalan','index'=>'JAMSURATJALAN', 'width'=>70))
        //            ->addColumn(array('label'=>'Tgl. Fiat Muat','index'=>'tglfiat', 'width'=>120))
        //            ->addColumn(array('label'=>'Jam. Fiat Muat','index'=>'jamfiat', 'width'=>70))
        //            ->addColumn(array('label'=>'Tgl. Entry','index'=>'tglentry', 'width'=>120))
        //            ->addColumn(array('label'=>'Jam. Entry','index'=>'jamentry', 'width'=>70,'hidden'=>true))
        //            ->addColumn(array('label'=>'Updated','index'=>'last_update', 'width'=>150, 'search'=>false))
                    ->renderGrid()
                }}
                
                <div id="btn-toolbar" class="section-header btn-toolbar" role="toolbar" style="margin: 10px 0;">

                </div>
            </div>
            
        </div>
    </div>
</div>

<div id="create-invoice-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Please Insert Invoice Number</h4>
            </div>
            <form id="create-invoice-form" class="form-horizontal" action="{{ route("lcl-delivery-release-invoice") }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}" />
                            <input name="id" type="hidden" id="container_id" />
                            <div class="form-group">
                                <label class="col-sm-3 control-label">No. Faktur</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="no_invoice" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Forwarder</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="forwarder" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tgl. Cetak</label>
                                <div class="col-sm-8">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" name="tgl_cetak" class="form-control pull-right datepicker" required>
                                    </div>
                                </div>
                            </div>
                            
<!--                            <div class="form-group">
                                <label class="col-sm-3 control-label">Free Surcharge</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" name="free_surcharge" value="1" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Behandle</label>
                                <div class="col-sm-5">
                                    <input type="checkbox" name="behandle" value="1" />
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                  <button type="submit" class="btn btn-primary">Create Invoice</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('custom_css')

<!-- Bootstrap Switch -->
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-switch/bootstrap-switch.min.css") }}">

<!--<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />-->
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">
<!--<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css") }}">-->

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset("/bower_components/AdminLTE/plugins/bootstrap-switch/bootstrap-switch.min.js") }}"></script>
<script type="text/javascript">
    
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd',
        zIndex: 99
    });
    
//    $.fn.bootstrapSwitch.defaults.size = 'mini';
    $.fn.bootstrapSwitch.defaults.onColor = 'danger';
    $.fn.bootstrapSwitch.defaults.onText = 'Yes';
    $.fn.bootstrapSwitch.defaults.offText = 'No';
    $("input[type='checkbox']").bootstrapSwitch();
</script>

@endsection