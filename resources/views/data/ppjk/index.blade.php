@extends('layout')

@section('content')

<script>
    function gridCompleteEvent()
    {
        var ids = jQuery("#ppjkGrid").jqGrid('getDataIDs'),
            edt = '',
            del = ''; 
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            var rowdata = $('#ppjkGrid').getRowData(cl);
            var dataid = rowdata.ppjk_id;

            edt = '<a href="{{ route("ppjk-edit",'') }}/'+dataid+'"><i class="fa fa-pencil"></i></a> ';
            del = '<a href="{{ route("ppjk-delete",'') }}/'+dataid+'" onclick="if (confirm(\'Are You Sure ?\')){return true; }else{return false; };"><i class="fa fa-close"></i></a>';
            jQuery("#ppjkGrid").jqGrid('setRowData',ids[i],{action:edt+' '+del}); 
        } 
    }
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">PPJK</h3>
<!--        <div class="box-tools">
            <a href="{{ route('ppjk-create') }}" type="button" class="btn btn-block btn-info btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>-->
    </div>
    <div class="box-body table-responsive">
            {{
                GridRender::setGridId("ppjkGrid")
                ->enableFilterToolbar()
                ->setGridOption('url', URL::to('/ppjk/grid-data'))
                ->setGridOption('editurl',URL::to('/ppjk/crud'))
                ->setGridOption('rowNum', 20)
                ->setGridOption('shrinkToFit', true)
                ->setGridOption('sortname','id')
                ->setGridOption('rownumbers', true)
                ->setGridOption('height', '295')
                ->setGridOption('rowList',array(20,50,100))
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
                ->addColumn(array('label'=>'Name','index'=>'name','width'=>150,'editable' => true, 'editrules' => array('required' => true)))
                ->addColumn(array('label'=>'Phone','index'=>'phone', 'width'=>150,'editable' => true, 'editrules' => array('required' => true) ))
                ->addColumn(array('label'=>'Created','index'=>'created_at', 'width'=>150, 'search'=>false))
                ->addColumn(array('label'=>'Updated','index'=>'updated_at', 'width'=>150, 'search'=>false))
                ->renderGrid()
            }}
    </div>
    
    
</div>
    
@endsection