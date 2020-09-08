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
        var ids = jQuery("#fcllongstayGrid").jqGrid('getDataIDs'),
            apv = '';   
            
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            
            rowdata = $('#fcllongstayGrid').getRowData(cl); 
            
            if(rowdata.status_bc == 'HOLD') {
                apv = '<button style="margin:5px;" class="btn btn-danger btn-xs" data-id="'+cl+'" onclick="if (confirm(\'Are You Sure to change status HOLD to RELEASE ?\')){ changeStatus('+cl+'); }else{return false;};"><i class="fa fa-check"></i> RELEASE</button>';
            }else{
                apv = '';
            }
            
            if(rowdata.status_bc == 'HOLD') {
                $("#" + cl).find("td").css("background-color", "#ffe500");
            }
            if(rowdata.flag_bc == 'Y') {
                $("#" + cl).find("td").css("color", "#FF0000");
            }  
            
            jQuery("#fcllongstayGrid").jqGrid('setRowData',ids[i],{action:apv});
            
        } 
    }
    
    function changeStatus($id)
    {
        $.ajax({
            type: 'GET',
            dataType : 'json',
            url: "{{ route('fcl-change-status','') }}/"+$id,
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Something went wrong, please try again later.');
            },
            beforeSend:function()
            {

            },
            success:function(json)
            {
                if(json.success) {
                    $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                    $('#fcllongstayGrid').jqGrid().trigger("reloadGrid");
                } else {
                    $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                }

                //Triggers the "Refresh" button funcionality.
                $('#btn-refresh').click();
            }
        });
    }
</script>
<div class="box">
<!--    <div class="box-header with-border">
        <h3 class="box-title">FCL Stock</h3>
    </div>-->
    <div class="box-body table-responsive">
        <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-md-8">
                <div class="col-xs-12">Search By Date</div>
                <div class="col-xs-12">&nbsp;</div>
                <div class="col-xs-3">
                    <select class="form-control select2" id="by" name="by" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="ETA">Tgl. ETA</option>
                        <option value="TGLMASUK">Tgl. GateIn</option>
                        <option value="TGL_BC11">Tgl. BC1.1</option> 
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
            <div class="col-md-4">
                <div class="col-xs-12" style="padding: 0;">Pilih Gudang</div>
                <div class="col-xs-12">&nbsp;</div>
                <form action="{{ route('fcl-report-longstay') }}" method="GET">
                    <div class="row">
                        <div class="col-md-8">
                            <select class="form-control select2" id="gd" name="gd" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="%" @if($gd == '%') {{ 'selected' }} @endif>Semua Lapangan</option>
                                <option value="ARN1" @if($gd == 'ARN1') {{ 'selected' }} @endif>Lapangan Utara (ARN1)</option>   
                                <option value="ARN3" @if($gd == 'ARN3') {{ 'selected' }} @endif>Lapangan Barat (ARN3)</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="changeWarehouse" class="btn btn-info">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{
            GridRender::setGridId("fcllongstayGrid")
            ->enableFilterToolbar()
            ->setGridOption('mtype', 'POST')
            ->setGridOption('url', URL::to('/container/grid-data-cy?module=longstay&report=1&gd='.$gd.'&_token='.csrf_token()))
            ->setGridOption('rowNum', 20)
            ->setGridOption('shrinkToFit', true)
            ->setGridOption('sortname','TCONTAINER_PK')
            ->setGridOption('sortorder','DESC')
            ->setGridOption('rownumbers', true)
            ->setGridOption('rownumWidth', 50)
            ->setGridOption('height', '395')
            ->setGridOption('rowList',array(20,50,100))
            ->setGridOption('useColSpanStyle', true)
            ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
            ->setNavigatorOptions('view',array('closeOnEscape'=>false))
            ->setFilterToolbarOptions(array('autosearch'=>true))
            ->setGridEvent('gridComplete', 'gridCompleteEvent')
//            ->setGridEvent('onSelectRow', 'onSelectRowEvent')
            ->addColumn(array('key'=>true,'index'=>'TCONTAINER_PK','hidden'=>true))
            ->addColumn(array('label'=>'Action','index'=>'action', 'width'=>100, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
            ->addColumn(array('label'=>'Status BC','index'=>'status_bc','width'=>100, 'align'=>'center'))
            ->addColumn(array('label'=>'Flag','index'=>'flag_bc','width'=>80, 'align'=>'center'))
            ->addColumn(array('label'=>'No. Joborder','index'=>'NoJob', 'width'=>150))
            ->addColumn(array('label'=>'Nama Angkut','index'=>'VESSEL','width'=>160))  
            ->addColumn(array('label'=>'No. Container','index'=>'NOCONTAINER', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'VOY','index'=>'VOY','width'=>100,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'Call Sign','index'=>'CALLSIGN','width'=>100,'align'=>'center','hidden'=>false))
            ->addColumn(array('label'=>'Size','index'=>'SIZE', 'width'=>100,'align'=>'center'))
//            ->addColumn(array('label'=>'Teus','index'=>'TEUS', 'width'=>100,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'ETA','index'=>'ETA', 'width'=>120,'align'=>'center','hidden'=>true))
            ->addColumn(array('label'=>'TPS Asal','index'=>'KD_TPS_ASAL', 'width'=>100,'align'=>'center'))
            ->addColumn(array('label'=>'Kode Gudang','index'=>'GUDANG_TUJUAN', 'width'=>100,'align'=>'center'))
            ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>250,'hidden'=>true))
            ->addColumn(array('label'=>'Consignee','index'=>'CONSIGNEE', 'width'=>250))
            ->addColumn(array('label'=>'No.BC 1.1','index'=>'NO_BC11', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl.BC 1.1','index'=>'TGL_BC11', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'No.POS BC11','index'=>'NO_POS_BC11', 'width'=>150,'align'=>'center'))
            ->addColumn(array('label'=>'Tgl. Gate In','index'=>'TGLMASUK', 'width'=>120,'align'=>'center'))
            ->addColumn(array('label'=>'Jam. Gate In','index'=>'JAMMASUK', 'width'=>100,'align'=>'center'))
            ->addColumn(array('label'=>'Lama Timbun (Hari)','index'=>'timeSinceUpdate', 'width'=>150, 'search'=>false, 'align'=>'center'))
            ->renderGrid()
        }}
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Report YOR ({{ date('d F Y') }})</h3>
    </div>
    <div class="box-body table-responsive">
        <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-sm-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>KAPASITAS TERISI</th>
                            <td align="right">{{ number_format($yor->kapasitas_terisi,'2','.',',') }} TEUS</td>
                        </tr>
                        <tr>
                            <th>KAPASITAS LAPANGAN</th>
                            <td align="right">{{ number_format($yor->kapasitas_default,'2','.',',') }} TEUS</td>
                        </tr>
                        <tr>
                            <th>KAPASITAS KOSONG</th>
                            <td align="right">{{ number_format($yor->kapasitas_kosong,'2','.',',') }} TEUS</td>
                        </tr>
                        <tr>
                            <th>YOR (%)</th>
                            <td align="right">{{ number_format($yor->total,'2','.',',') }} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
        var by = $("#by").val();
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        var string_filters = '';
        var filters = '{"groupOp":"AND","rules":[{"field":"'+by+'","op":"ge","data":"'+startdate+'"},{"field":"'+by+'","op":"le","data":"'+enddate+'"}]}';

        var current_filters = jQuery("#fcllongstayGrid").getGridParam("postData").filters;
        
        if (current_filters) {
            var get_filters = $.parseJSON(current_filters);
            if (get_filters.rules !== undefined && get_filters.rules.length > 0) {

                var tempData = get_filters.rules;
                
                tempData.push( { "field":by,"op":"ge","data":startdate } );
                tempData.push( { "field":by,"op":"le","data":enddate } );
                
                string_filters = JSON.stringify(tempData);
                
                filters = '{"groupOp":"AND","rules":'+string_filters+'}';
            }
        }

        jQuery("#fcllongstayGrid").jqGrid("setGridParam", { postData: {filters} }).trigger("reloadGrid");
        
        return false;
    });
</script>

@endsection