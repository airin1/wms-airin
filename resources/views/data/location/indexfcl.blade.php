@extends('layout')

@section('content')

<script>
    function gridCompleteEvent()
    {
        var ids = jQuery("#locationfclGrid").jqGrid('getDataIDs'),
            edt = '',
            del = ''; 
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            var rowdata = $('#locationfclGrid').getRowData(cl);
            var dataid = rowdata.locationfcl_id;

            edt = '<a href="{{ route("locationfcl-edit",'') }}/'+dataid+'"><i class="fa fa-pencil"></i></a> ';
            del = '<a href="{{ route("locationfcl-delete",'') }}/'+dataid+'" onclick="if (confirm(\'Are You Sure ?\')){return true; }else{return false; };"><i class="fa fa-close"></i></a>';
            jQuery("#locationfclGrid").jqGrid('setRowData',ids[i],{action:edt+' '+del}); 
        } 
    }
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Location FCL</h3>
<!--        <div class="box-tools">
            <a href="{{ route('locationfcl-create') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>-->
    </div>
    <div class="box-body table-responsive">
            {{
                GridRender::setGridId("locationfclGrid")
                ->enableFilterToolbar()
                ->setGridOption('url', URL::to('/locationfcl/grid-data'))
                ->setGridOption('editurl',URL::to('/locationfcl/crud'))
                ->setGridOption('rowNum', 100)
                ->setGridOption('shrinkToFit', true)
                ->setGridOption('sortname','id')
                ->setGridOption('rownumbers', true)
                ->setGridOption('height', '390')
                ->setGridOption('rowList',array(100,200,300))
                ->setGridOption('emptyrecords','Nothing to display')
                ->setGridOption('useColSpanStyle', true)
                ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
                ->setNavigatorOptions('view',array('closeOnEscape'=>false))
                ->setNavigatorOptions('navigator', array('add' => true, 'edit' => true, 'del' => true, 'view' => false, 'refresh' => false))
                ->setNavigatorOptions('add', array('closeAfterAdd' => true))
                ->setNavigatorEvent('add', 'afterSubmit', 'afterSubmitEvent')
                ->setNavigatorOptions('edit', array('closeAfterEdit' => true))
                ->setNavigatorEvent('edit', 'afterSubmit', 'afterSubmitEvent')
                ->setNavigatorEvent('del', 'afterSubmit', 'afterSubmitEvent')
                ->setFilterToolbarOptions(array('autosearch'=>true))
                ->setGridEvent('gridComplete', 'gridCompleteEvent')
                ->addColumn(array('key'=>true,'index'=>'id','hidden'=>true))
                ->addColumn(array('label'=>'Name','index'=>'name','width'=>450,'editable' => true, 'editrules' => array('required' => true)))
                ->addColumn(array('label'=>'Type','index'=>'type', 'width'=>150,'editable' => true, 'align'=>'center', 'editrules' => array('required' => true) ))
                ->addColumn(array('label'=>'UID','index'=>'uid', 'width'=>150, 'search'=>false, 'align'=>'center'))
                ->addColumn(array('label'=>'Created','index'=>'created_at', 'width'=>150, 'search'=>false, 'align'=>'center'))
                ->addColumn(array('label'=>'Updated','index'=>'updated_at', 'width'=>150, 'search'=>false, 'align'=>'center'))
                ->renderGrid()
            }}
    </div>
    
    
</div>
    
@endsection