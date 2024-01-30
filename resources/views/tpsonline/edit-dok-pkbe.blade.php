@extends('layout')

@section('content')

@include('partials.form-alert')

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Edit TPS NPE</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <form class="form-horizontal" action="{{ route('tps-pkbe-update', $npe->TPS_DOKNPE_PK) }}" method="POST">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-6">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">CAR</label>
                        <div class="col-sm-8">
                            <input type="text" name="CAR" class="form-control"  value="{{ $pkbe->CAR }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. PKBE</label>
                        <div class="col-sm-8">
                            <input type="text" name="NOPKBE" class="form-control"  value="{{ $pkbe->NOPKBE }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. PKBE</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="TGL_NPE" class="form-control pull-right datepicker" required value="{{ date('Y-m-d',strtotime($pkbe->TGLPKBE)) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Kantor</label>
                        <div class="col-sm-8">
                            <input type="text" name="KD_KANTOR" class="form-control"  value="{{ $pkbe->KD_KANTOR }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NPWP Eksportir</label>
                        <div class="col-sm-8">
                            <input type="text" name="NPWP_EKS" class="form-control"  value="{{ $pkbe->NPWP_EKS }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Eksportir</label>
                        <div class="col-sm-8">
                            <input type="text" name="NAMA_EKS" class="form-control"  value="{{ $pkbe->NAMA_EKS }}" required>
                        </div>
                    </div>
                   
                   
                    
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-warning pull-left" id="print-sppb"><i class="fa fa-print"></i> Cetak</button>
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('tps-dokPKBE-index') }}" class="btn btn-danger pull-right" style="margin-right: 10px;"><i class="fa fa-close"></i> Keluar</a>
        </div>
        <!-- /.box-footer -->
    </form>
</div>

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Lists Container</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="form-horizontal">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-12">
                    {{
                        GridRender::setGridId("tpstpsPKBEGrid")
                        ->enableFilterToolbar()
                        ->setGridOption('mtype', 'POST')
                        ->setGridOption('url', URL::to('/tpsonline/penerimaan/dok-pkbe/grid-data-detail?type=cont&TPS_DOKPKBE_PK='.$npe->TPS_DOKPKBE_PK.'&_token='.csrf_token()))
                        ->setGridOption('rowNum', 10)
                        ->setGridOption('shrinkToFit', true)
                        ->setGridOption('sortname','TPS_DOKPKBE_PK')
                        ->setGridOption('rownumbers', true)
                        ->setGridOption('height', '150')
                        ->setGridOption('rowList',array(10,20,50))
                        ->setGridOption('useColSpanStyle', true)
                        ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
                        ->setNavigatorOptions('view',array('closeOnEscape'=>false))
                        ->setNavigatorOptions('navigator', array('add' => false, 'edit' => false, 'del' => false, 'view' => true, 'refresh' => false))
                        ->setNavigatorOptions('add', array('closeAfterAdd' => true))
                        ->setNavigatorEvent('add', 'afterSubmit', 'afterSubmitEvent')
                        ->setNavigatorOptions('edit', array('closeAfterEdit' => true))
                        ->setNavigatorEvent('edit', 'afterSubmit', 'afterSubmitEvent')
                        ->setNavigatorEvent('del', 'afterSubmit', 'afterSubmitEvent')
                        ->setFilterToolbarOptions(array('autosearch'=>true))
                        ->addColumn(array('key'=>true,'index'=>'TPS_DOKPKBE_PK','hidden'=>true))
                        ->addColumn(array('label'=>'No. Container','index'=>'NO_CONT','width'=>300,'editable' => true, 'editrules' => array('' => true)))
                        ->addColumn(array('label'=>'Ukuran','index'=>'SIZE', 'width'=>250,'align'=>'center','editable' => true, 'editrules' => array('' => true,'number'=>true),'edittype'=>'select','editoptions'=>array('value'=>"20:20;40:40")))
                        ->renderGrid()
                    }}
                </div>
            </div>               
        </div>
    </div>
</div>

<div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">Lists Kemasan</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="form-horizontal">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-12">
                    {{
                        GridRender::setGridId("tpsNPEGrid")
                        ->enableFilterToolbar()
                        ->setGridOption('mtype', 'POST')
                        ->setGridOption('url', URL::to('/tpsonline/penerimaan/dok-npe/grid-data'.$npe->TPS_DOKNPE_PK.'&_token='.csrf_token()))
                        ->setGridOption('rowNum', 10)
                        ->setGridOption('shrinkToFit', true)
                        ->setGridOption('sortname','TPS_DOKNPE_PK')
                        ->setGridOption('rownumbers', true)
                        ->setGridOption('height', '150')
                        ->setGridOption('rowList',array(10,20,50))
                        ->setGridOption('useColSpanStyle', true)
                        ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
                        ->setNavigatorOptions('view',array('closeOnEscape'=>false))
                        ->setNavigatorOptions('navigator', array('add' => false, 'edit' => false, 'del' => false, 'view' => true, 'refresh' => false))
                        ->setNavigatorOptions('add', array('closeAfterAdd' => true))
                        ->setNavigatorEvent('add', 'afterSubmit', 'afterSubmitEvent')
                        ->setNavigatorOptions('edit', array('closeAfterEdit' => true))
                        ->setNavigatorEvent('edit', 'afterSubmit', 'afterSubmitEvent')
                        ->setNavigatorEvent('del', 'afterSubmit', 'afterSubmitEvent')
                        ->setFilterToolbarOptions(array('autosearch'=>true))
                        ->addColumn(array('key'=>true,'index'=>'TPS_DOKNPE_PK','hidden'=>true))
                        ->addColumn(array('label'=>'Jenis KMS','index'=>'JNS_KMS','width'=>250,'editable' => true, 'editrules' => array('' => true)))
                        ->addColumn(array('label'=>'Merk KMS','index'=>'MERK_KMS', 'width'=>250,'align'=>'center','editable' => true))
                        ->addColumn(array('label'=>'Jumlah KMS','index'=>'JML_KMS', 'width'=>250,'editable' => true, 'align'=>'center'))
                        ->renderGrid()
                    }}
                </div>
                
            </div>
                
        </div>
    </div>
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
    
    $(document).ready(function(){

        $('#print-sppb').on("click", function(){
            window.open("{{route('tps-pkbe-print',$pkbe->TPS_DOKPKBE_PK)}}","preview","width=600,height=600,menubar=no,status=no,scrollbars=yes");    
        });
    });
    
</script>

@endsection