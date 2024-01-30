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
    <form class="form-horizontal" action="{{ route('tps-sppbBc-update', $npe->TPS_DOKNPE_PK) }}" method="POST">
        <div class="box-body">            
            <div class="row">
                <div class="col-md-6">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No Daftar</label>
                        <div class="col-sm-8">
                            <input type="text" name="NO_DAFTAR" class="form-control"  value="{{ $npe->NO_DAFTAR }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Npe</label>
                        <div class="col-sm-8">
                            <input type="text" name="NONPE" class="form-control"  value="{{ $npe->NONPE }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. Daftar</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="TGL_DAFTAR" class="form-control pull-right datepicker" required value="{{ date('Y-m-d',strtotime($npe->TGL_DAFTAR)) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. NPE</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" name="TGL_NPE" class="form-control pull-right datepicker" required value="{{ date('Y-m-d',strtotime($npe->TGLNPE)) }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Kantor</label>
                        <div class="col-sm-8">
                            <input type="text" name="KD_KANTOR" class="form-control"  value="{{ $npe->KD_KANTOR }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NPWP Eksportir</label>
                        <div class="col-sm-8">
                            <input type="text" name="NPWP_EKS" class="form-control"  value="{{ $npe->NPWP_EKS }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama Eksportir</label>
                        <div class="col-sm-8">
                            <input type="text" name="NAMA_EKS" class="form-control"  value="{{ $npe->NAMA_EKS }}" required>
                        </div>
                    </div>
                   
                   
                    
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button type="button" class="btn btn-warning pull-left" id="print-sppb"><i class="fa fa-print"></i> Cetak</button>
            <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('tps-sppbBc-index') }}" class="btn btn-danger pull-right" style="margin-right: 10px;"><i class="fa fa-close"></i> Keluar</a>
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
                        GridRender::setGridId("tpstpsNPEGrid")
                        ->enableFilterToolbar()
                        ->setGridOption('mtype', 'POST')
                        ->setGridOption('url', URL::to('/tpsonline/penerimaan/dok-npe/grid-data-detail?type=cont&TPS_DOKNPE_PK='.$npe->TPS_DOKNPE_PK.'&_token='.csrf_token()))
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
                        ->addColumn(array('key'=>true,'index'=>'NONPE','hidden'=>true))
                        ->addColumn(array('label'=>'No. Container','index'=>'NO_CONT','width'=>300,'editable' => true, 'editrules' => array('' => true)))
                        ->addColumn(array('label'=>'Ukuran','index'=>'SIZE', 'width'=>250,'align'=>'center','editable' => true, 'editrules' => array('' => true,'number'=>true),'edittype'=>'select','editoptions'=>array('value'=>"20:20;40:40")))
                        ->addColumn(array('label'=>'FL Segel','index'=>'FL_SEGEL', 'width'=>250,'editable' => true, 'align'=>'right'))
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
                        ->setGridOption('url', URL::to('/tpsonline/penerimaan/dok-npe/grid-data-detail?type=cont&TPS_DOKNPE_PK='.$npe->TPS_DOKNPE_PK.'&_token='.csrf_token()))
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
                        ->addColumn(array('key'=>true,'index'=>'NONPE','hidden'=>true))
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
            window.open("{{route('tps-npe-print',$npe->TPS_DOKNPE_PK)}}","preview","width=600,height=600,menubar=no,status=no,scrollbars=yes");    
        });
    });
    
</script>

@endsection