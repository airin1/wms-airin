@extends('layout')

@section('content')
<style>
    .bootstrap-timepicker-widget {
        left: 27%;
    }
</style>
<script>
    
    function gridCompleteEvent()
    {
        var ids = jQuery("#fclReleaseGrid").jqGrid('getDataIDs');   
            
        for(var i=0;i < ids.length;i++){ 
            var cl = ids[i];
            var vi = '';
            
            rowdata = $('#fclReleaseGrid').getRowData(cl);
            if(rowdata.VALIDASI == 'Y') {
                $("#" + cl).find("td").css("color", "#666");
            }
            if(rowdata.flag_bc == 'Y') {
                $("#" + cl).find("td").css("background-color", "#FF0000");
            }
            if(rowdata.status_bc == 'HOLD') {
                $("#" + cl).find("td").css("background-color", "#ffe500");
            }
            
            if(rowdata.photo_release_extra != ''){
                vi = '<button style="margin:5px;" class="btn btn-default btn-xs approve-manifest-btn" data-id="'+cl+'" onclick="viewPhoto('+cl+')"><i class="fa fa-photo"></i> View Photo</button>';
            }else{
                vi = '<button style="margin:5px;" class="btn btn-default btn-xs approve-manifest-btn" disabled><i class="fa fa-photo"></i> Not Found</button>';
            } 
            
            jQuery("#fclReleaseGrid").jqGrid('setRowData',ids[i],{action:vi}); 
        } 
    }
    
    function viewPhoto(containerID)
    {       
        $.ajax({
            type: 'GET',
            dataType : 'json',
            url: '{{route("fcl-report-rekap-view-photo","")}}/'+containerID,
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Something went wrong, please try again later.');
            },
            beforeSend:function()
            {
                $('#container-photo').html('');
            },
            success:function(json)
            {
                var html_container = '';
                
                if(json.data.photo_release_extra){
                    var photos_container = $.parseJSON(json.data.photo_release_extra);
                    var html_container = '';
                    $.each(photos_container, function(i, item) {
                        /// do stuff
                        html_container += '<img src="{{url("uploads/photos/container/fcl")}}/'+json.data.NOCONTAINER+'/'+item+'" style="width: 200px;padding:5px;" />';

                    });
                    $('#container-photo').html(html_container);
                }
            }
        });
        
        $('#view-photo-modal').modal('show');
    }
    
    function onSelectRowEvent()
    {
        $('#btn-group-1,#btn-group-6').enableButtonGroup();
    }
    
    $(document).ready(function()
    {
        $('#release-form').disabledFormGroup();
        $('#btn-toolbar,#btn-sppb,#btn-photo,#btn-ppjk,#NOPOL_OUT').disabledButtonGroup();
        $('#btn-group-3').enableButtonGroup();
        $(".hide-kddoc").hide();
        $('#release_lokasi').removeAttr('disabled');
        
        $("#KD_DOK_INOUT").on("change", function(){
            var $this = $(this).val();
            
            $('#NO_SPPB').val("");
            $('#TGL_SPPB').val("");
            
            if($this == 9){
                $(".select-bcf-consignee").show();
            }else{
                $(".select-bcf-consignee").hide();
            }
            if($this){
                $(".hide-kddoc").show();
            }else{
                $(".hide-kddoc").hide();
            }
//            if($this == 1){
//                @role('super-admin')
//                    
//                @else
//                    $('#NO_SPPB').attr('disabled','disabled');
//                    $('#TGL_SPPB').attr('disabled','disabled');
//                @endrole
//            }else{
//                if($this == ''){
//                    $('#NO_SPPB').attr('disabled','disabled');
//                    $('#TGL_SPPB').attr('disabled','disabled');
//                }else{
//                    $('#NO_SPPB').removeAttr('disabled');
//                    $('#TGL_SPPB').removeAttr('disabled');
//                }
//            }
                @role('super-admin')
                    $('#NO_SPPB').removeAttr('disabled');
                    $('#TGL_SPPB').removeAttr('disabled');
                @else
                    $('#NO_SPPB').attr('disabled','disabled');
                    $('#TGL_SPPB').attr('disabled','disabled');
                @endrole
        });
        
        $('#get-sppb-btn').click(function(){
     
            if(!confirm('Apakah anda yakin?')){return false;}
            
            var kd_dok = $("#KD_DOK_INOUT").val();
            if(kd_dok == ''){
                alert('Kode Dokumen masih kosong!!!');
                return false;
            }
            
            $this = $(this);
            $this.html('<i class="fa fa-spin fa-spinner"></i> Please wait...');
            $this.attr('disabled','disabled');
            
            var url = '{{ route("fcl-delivery-release-getdatasppb") }}';

            $.ajax({
                type: 'POST',
                data: 
                {
                    'id' : $('#TCONTAINER_PK').val(),
                    'kd_dok' : kd_dok,
                    '_token' : '{{ csrf_token() }}'
                },
                dataType : 'json',
                url: url,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Something went wrong, please try again later.');
                    $this.html('<i class="fa fa-download"></i> Get Data');
                    $this.removeAttr('disabled');
                },
                beforeSend:function()
                {

                },
                success:function(json)
                {
                    console.log(json);

                    if(json.success) {
                        $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                        
                        var datasppb = json.data; 
                        $('#NO_SPPB').val(datasppb.NO_SPPB);
                        $('#TGL_SPPB').val(datasppb.TGL_SPPB);
						$('#NO_DAFTAR_PABEAN').val(datasppb.NO_PIB);
                        $('#TGL_DAFTAR_PABEAN').val(datasppb.TGL_PIB);
                        $('#ID_CONSIGNEE').val(datasppb.NPWP);
						$('#bcf_consignee').val(datasppb.bcf_consignee);
                    } else {
                      $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                    }
                    
                    $this.html('<i class="fa fa-download"></i> Get Data');
                    $this.removeAttr('disabled');

                }
            });
        });
        
        $('#btn-edit').click(function() {
            //Gets the selected row id.
            rowid = $('#fclReleaseGrid').jqGrid('getGridParam', 'selrow');
            rowdata = $('#fclReleaseGrid').getRowData(rowid);

            if(!rowid) {alert('Please Select Row');return false;} 
            
            populateFormFields(rowdata, '');
            $('#TCONTAINER_PK').val(rowid);
            $('#NOJOBORDER').val(rowdata.NoJob);
            $('#NO_BC11').val(rowdata.NO_BC11);
            $('#TGL_BC11').val(rowdata.TGL_BC11);
            $('#NO_PLP').val(rowdata.NO_PLP);
            $('#TGL_PLP').val(rowdata.TGL_PLP);
            $('#NO_POS_BC11').val(rowdata.NO_POS_BC11);
            $('#NO_SPJM').val(rowdata.NO_SPJM);
            $('#TGL_SPJM').val(rowdata.TGL_SPJM);
            $('#NAMA_IMP').val(rowdata.NAMA_IMP);
            $('#NPWP_IMP').val(rowdata.NPWP_IMP);
            $('#telp_ppjk').val(rowdata.telp_ppjk);
            
            $('#NO_BL_AWB').val(rowdata.NO_BL_AWB);
            $('#TGL_BL_AWB').val(rowdata.TGL_BL_AWB);
            $('#NO_DAFTAR_PABEAN').val(rowdata.NO_DAFTAR_PABEAN);
            $('#TGL_DAFTAR_PABEAN').val(rowdata.TGL_DAFTAR_PABEAN);
            $('#TGLSURATJALAN').val(rowdata.TGLSURATJALAN+' '+rowdata.JAMSURATJALAN);
            $('#NOPOL_OUT').val(rowdata.NOPOL_OUT);
            $('#REF_NUMBER_OUT').val(rowdata.REF_NUMBER_OUT);
            $('#ID_CONSIGNEE').val(rowdata.ID_CONSIGNEE);
            $('#KD_DOK_INOUT').val(rowdata.KD_DOK_INOUT).trigger('change');
            $('#bcf_consignee').val(rowdata.bcf_consignee).trigger('change');
            $('#KD_TPS_ASAL').val(rowdata.KD_TPS_ASAL);
            $('#TSHIPPINGLINE_FK').val(rowdata.TSHIPPINGLINE_FK).trigger('change');
            $('#telp_ppjk').val(rowdata.telp_ppjk).trigger('change');
            $('#keterangan_release').val(rowdata.keterangan_release);
//            $("#telp_ppjk").append('<option value="'+rowdata.telp_ppjk+'" selected="selected">'+rowdata.telp_ppjk+'</option>').trigger('change');
            
            $('#NO_SPPB').val(rowdata.NO_SPPB);
            $('#TGL_SPPB').val(rowdata.TGL_SPPB);

            $('#upload-title').html('Upload Photo for '+rowdata.NOCONTAINER);
            $('#no_cont').val(rowdata.NOCONTAINER);
            $('#id_cont').val(rowdata.TCONTAINER_PK);
            $('#load_photos').html('');
            $('#delete_photo').val('N');
            
            if(rowdata.photo_release_extra){
                var html = '';
                var photos = $.parseJSON(rowdata.photo_release_extra);
                $.each(photos, function(i, item) {
                    /// do stuff
                    html += '<img src="{{url("uploads/photos/container/fcl/")}}/'+rowdata.NOCONTAINER+'/'+item+'" style="width: 200px;padding:5px;" />';
                });
                $('#load_photos').html(html);
            }
            @role('upload-fcl')
                $('#btn-group-2,#btn-photo').enableButtonGroup();
            @else
                $('#btn-group-2,#btn-sppb,#btn-photo,#btn-ppjk,#NOPOL_OUT').enableButtonGroup();
                $('#release-form').enableFormGroup();
                $('#btn-group-4').enableButtonGroup();
                $('#btn-group-5').enableButtonGroup();
            @endrole

//            if(rowdata.KD_DOK_INOUT == 1){
                @role('super-admin')
                    $('#NO_SPPB').removeAttr('disabled');
                    $('#TGL_SPPB').removeAttr('disabled');
                @else
                    $('#NO_SPPB').attr('disabled','disabled');
                    $('#TGL_SPPB').attr('disabled','disabled');
                @endrole
//            }
            
            if(!rowdata.TGLRELEASE && !rowdata.JAMRELEASE) {
                
            }else{
                @role('super-admin')
                    $('#TGLRELEASE').removeAttr('disabled');
                    $('#JAMRELEASE').removeAttr('disabled');
                    $('#NOPOL_OUT').removeAttr('disabled');
                @else
                    $('#TGLRELEASE').attr('disabled','disabled');
                    $('#JAMRELEASE').attr('disabled','disabled');
                @endrole
            }
            
            if(rowdata.status_bc == 'HOLD'){
                @role('super-admin')
                    $('#TGLRELEASE').removeAttr('disabled');
                    $('#JAMRELEASE').removeAttr('disabled');
                    $('#NOPOL_OUT').removeAttr('disabled');
                @else
                    $('#TGLRELEASE').attr('disabled','disabled');
                    $('#JAMRELEASE').attr('disabled','disabled');
                    $('#NOPOL_OUT').attr('disabled','disabled');
                @endrole
                
            }else{
//                $('#TGLRELEASE').removeAttr('disabled');
//                $('#JAMRELEASE').removeAttr('disabled');
//                $('#NOPOL_OUT').removeAttr('disabled');
            } 
            
            if(rowdata.flag_bc == 'Y'){
                $('#btn-group-4').disabledButtonGroup();
                $('#btn-group-5').disabledButtonGroup();
                $('#btn-sppb,#btn-photo').disabledButtonGroup();
                $('#release-form').disabledFormGroup();
//                $('#btn-group-2').disabledFormGroup();
                
            }
            
            $('#telp_ppjk,#NOPOL_OUT').removeAttr('disabled');
            $('#add-ppjk-btn').removeAttr('disabled');
            $('#NO_BL_AWB').removeAttr('disabled');
                  
        });
        
        $('#btn-print-sj').click(function() {
           
         var $grid = $("#fclReleaseGrid"), selIds = $grid.jqGrid("getGridParam", "selarrrow"), i, n,
                cellValues = [];
            for (i = 0, n = selIds.length; i < n; i++) {
                var check_sppb = $grid.jqGrid("getCell", selIds[i], "NO_SPPB");
                
                if(check_sppb == ''){
                    alert('Silahkan masukan No. SPPB terlebih dahulu!!!');
                    return false;
                }
				
			var id = $grid.jqGrid("getCell", selIds[i], "TCONTAINER_PK");
			var no_cont = $grid.jqGrid("getCell", selIds[i], "NOCONTAINER");
			var nospk = $grid.jqGrid("getCell", selIds[i], "NOSPK");
            var url = '{{route("getCekInvoice")}}';
           // alert (no_cont);
           
            
			
			$.ajax({
                type: 'GET',
                data: 
                {
                    'no_cont' : no_cont,
					'nospk' : nospk
					
                },
                dataType : 'json',
                url: url,
                error: function (jqXHR, textStatus, errorThrown)
                {
                     alert('Something went wrong, please try again later.');
					 return false;
                },
                success:function(json)
                {    
                         
                     if(json.status){						 
					 // $('#datepick-inv').val('0');
					  // alert (json.data.no_spk);
					 }
					 else
					 {

					  //alert('Invoice Untuk Container '+no_cont +'  belum terbit.' );
					  alert('Invoice Untuk Container '+ json.data  +'  belum terbit.' );
					  //$('#datepick-modal').modal('hide');
					 // return false;
					
					 }
					
                }
            });
				
				
			
				
				
                cellValues.push($grid.jqGrid("getCell", selIds[i], "TCONTAINER_PK"));
            }
			
				
		
            
            var manifestId = cellValues.join(",");




		   //var id = $('#fclReleaseGrid').jqGrid('getGridParam', 'selrow');
      
			   $('#datepick-contid').val(manifestId);
               $('#datepick-modal').modal('show');
                   
//            $.ajax({
//                type: 'GET',
//                dataType : 'json',
//                url: '{{route("fcl-report-rekap-view-photo","")}}/'+id,
//                error: function (jqXHR, textStatus, errorThrown)
//                {
//                    alert('Something went wrong, please try again later.');
//                },
//                beforeSend:function()
//                {
//                    $('#verify-photo').html('');
//                },
//                success:function(json)
//                {
//                    var html_container = '';
//
//                    if(json.data.photo_release_extra){
//                        var photos_container = $.parseJSON(json.data.photo_release_extra);
//                        var html_container = '';
//                        $.each(photos_container, function(i, item) {
//                            html_container += '<img src="{{url("uploads/photos/container/fcl")}}/'+json.data.NOCONTAINER+'/'+item+'" style="width: 200px;padding:5px;" />';
//                        });
//                        $('#verify-photo').html(html_container);
//                        $('#verify-contid').val(id);
//        
//                        $('#verify-modal').modal('show');
//                    }else{
//                        alert('Silahkan upload photo kontainer terlebih dahulu!');
//                        return false;
//                    }
//                }
//            });
            
//            window.open("{{ route('fcl-delivery-suratjalan-cetak', '') }}/"+id,"preview surat jalan fcl","width=815,height=600,menubar=no,status=no,scrollbars=yes");
        });
        
        $("#datepick-form").submit(function(event){
            event.preventDefault();
            
            var cont_id = $('#datepick-contid').val();
            var date = $('#payment_date').val();
            
            if(date == ''){
                return false;
            }
            
            window.open("{{ route('fcl-delivery-suratjalan-cetak', array('','')) }}/"+cont_id+"/"+date,"preview surat jalan fcl","width=815,height=600,menubar=no,status=no,scrollbars=yes");
            $('#datepick-modal').modal('hide');
        });
        
        $("#verify-form").submit(function(event){
            event.preventDefault();
//            var post_url = $(this).attr("action");
//            var request_method = $(this).attr("method");
//            var form_data = new FormData(this);
            var cont_id = $('#verify-contid').val();
            var cont_no = $('#verify-contno').val();
            
            if(cont_no == ''){
                return false;
            }
            
            $.ajax({
                url : '{{route("fcl-release-verify",array("",""))}}/'+cont_id+'/'+cont_no,
                type: 'GET',
                dataType : 'json',
                cache: false,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Something went wrong, please try again later.');
                },
                beforeSend:function()
                {
                    $('#verify-modal').modal('hide');
                },
                success:function(json)
                {
                    console.log(json);
                    if(json.success) {
                      $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                      window.open("{{ route('fcl-delivery-suratjalan-cetak', '') }}/"+cont_id,"preview wo fiat muat","width=600,height=600,menubar=no,status=no,scrollbars=yes");
                    } else {
                      $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                    }
                }
            });
        });
        
        $('#btn-print-wo').click(function() {
            var id = $('#fclReleaseGrid').jqGrid('getGridParam', 'selrow');
            window.open("{{ route('fcl-delivery-fiatmuat-cetak', '') }}/"+id,"preview wo fiat muat","width=600,height=600,menubar=no,status=no,scrollbars=yes");   
        });

        $('#btn-save').click(function() {
        						
            if(!confirm('Apakah anda yakin?')){return false;}
			
			if($('#TGLRELEASE').val() != ''){
                 if($('#NOPOL_OUT').val() == "")
			   {
				alert('Silahkan masukan No. Mobil terlebih dahulu!!!');
                return false;
			   }	
            }
			
			
            
            rowid = $('#fclReleaseGrid').jqGrid('getGridParam', 'selrow');
            rowdata = $('#fclReleaseGrid').getRowData(rowid);
            
            var nosppb = $('#NO_SPPB').val();
            var tglsppb = $('#TGL_SPPB').val();
            
//            if(nosppb && tglsppb){
            
                var manifestId = $('#TCONTAINER_PK').val();
                var url = "{{route('fcl-delivery-release-update','')}}/"+manifestId;

                $.ajax({
                    type: 'POST',
                    data: JSON.stringify($('#release-form').formToObject('')),
                    dataType : 'json',
                    url: url,
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Something went wrong, please try again later.');
                    },
                    beforeSend:function()
                    {

                    },
                    success:function(json)
                    {
                        console.log(json);
                        if(json.success) {
                          $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                        } else {
                          $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                        }

                        //Triggers the "Close" button funcionality.
                        $('#btn-refresh').click();
                    }
                });
                
//            }else{
//                $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', 'NO. SPPB & TGL. SPPB Belum diisi.', 5000);
//                return false;
//            }
        });
        
        $('#btn-cancel').click(function() {
            $('#btn-refresh').click();
        });
        
        $('#btn-refresh').click(function() {
            $('#fclReleaseGrid').jqGrid().trigger("reloadGrid");
            $('#release-form').disabledFormGroup();
            $('#btn-toolbar,#btn-sppb, #btn-photo,#btn-ppjk').disabledButtonGroup();
            $('#btn-group-3').enableButtonGroup();
            
            $('#release-form')[0].reset();
            $('.select2').val(null).trigger("change");
            $('#TCONTAINER_PK').val("");
        });
        
        $('#btn-print-barcode').click(function() {

            var $grid = $("#fclReleaseGrid"), selIds = $grid.jqGrid("getGridParam", "selarrrow"), i, n,
                cellValues = [];
            for (i = 0, n = selIds.length; i < n; i++) {
                var check_sppb = $grid.jqGrid("getCell", selIds[i], "NO_SPPB");
                
                if(check_sppb == ''){
                    alert('Silahkan masukan No. SPPB terlebih dahulu!!!');
                    return false;
                }
                cellValues.push($grid.jqGrid("getCell", selIds[i], "TCONTAINER_PK"));
            }
            
            var manifestId = cellValues.join(",");
            
            if(!manifestId) {alert('Please Select Row');return false;}               
//            if(!confirm('Apakah anda yakin?')){return false;}    
            
//            if(cellValues.length > 1){
                if(!confirm('Apakah anda yakin?')){return false;}   
                window.open("{{ route('cetak-barcode', array('','','')) }}/"+manifestId+"/fcl/release","preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes");
//            }else{
//                var rowdata = $('#fclReleaseGrid').getRowData(manifestId);
//                $('#barcode_no_cont').html(rowdata.NOCONTAINER);
//                $('#id_cont_barcode').val(rowdata.TCONTAINER_PK);
//                if(rowdata.LOKASI_TUJUAN){
//                    $('#release_lokasi').val(rowdata.GUDANG_TUJUAN).trigger("change");
//                }
//                $('#print-barcode-modal').modal('show');
//            }
            
//            console.log(manifestId);
//            window.open("{{ route('cetak-barcode', array('','','')) }}/"+manifestId+"/fcl/release","preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes");
        });
        
        $('#print-barcode-single').click(function(){
            var manifestId = $("#id_cont_barcode").val();
            var lokasi = $("#release_lokasi").val();
            $('#print-barcode-modal').modal('hide');
            
            window.open("{{ route('cetak-barcode', array('','','')) }}/"+manifestId+"/fcl/release/1/"+lokasi,"preview barcode","width=305,height=600,menubar=no,status=no,scrollbars=yes");
        });
        
        $('#btn-upload').click(function() {
            
            if(!confirm('Apakah anda yakin?')){return false;}
            
            if($('#NAMACONSOLIDATOR').val() == ''){
                alert('Consolidator masih kosong!');
                return false;
            }
            if($('#TGLRELEASE').val() == ''){
                alert('Tgl Release masih kosong!');
                return false;
            }
            
            var url = '{{ route("fcl-delivery-release-upload") }}';

            $.ajax({
                type: 'POST',
                data: 
                {
                    'id' : $('#TCONTAINER_PK').val(),
                    '_token' : '{{ csrf_token() }}'
                },
                dataType : 'json',
                url: url,
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Something went wrong, please try again later.');
                },
                beforeSend:function()
                {

                },
                success:function(json)
                {
//                    console.log(json);

                    if(json.success) {
                        $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                    } else {
                        $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                    }

                    //Triggers the "Close" button funcionality.
                    $('#btn-refresh').click();
                    
                    $('#tpsonline-modal-text').html(json.message+', Apakah anda ingin mengirimkan CODECO Kontainer XML data sekarang?');
                    $("#tpsonline-send-btn").attr("href", "{{ route('tps-codecoContFcl-upload','') }}/"+json.insert_id);
                    
                    $('#tpsonline-modal').modal('show');
                }
            });
            
        });
        
    });
    
</script>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">FCL Delivery Release</h3>
    </div>
    <div class="box-body">
        @role('bea-cukai')
        <div class="row">
            <div class="col-md-12"> 
                {{
                    GridRender::setGridId("fclReleaseGrid")
                    ->enableFilterToolbar()
                    ->setGridOption('mtype', 'POST')
                    ->setGridOption('url', URL::to('/container/grid-data-cy?module=release&_token='.csrf_token()))
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
                    ->setGridEvent('onSelectRow', 'onSelectRowEvent')
                    ->setGridEvent('gridComplete', 'gridCompleteEvent')
                    ->addColumn(array('key'=>true,'index'=>'TCONTAINER_PK','hidden'=>true))
                    ->addColumn(array('index'=>'TSHIPPINGLINE_FK','hidden'=>true))
                    ->addColumn(array('label'=>'Photo','index'=>'action', 'width'=>120, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
                    ->addColumn(array('label'=>'Status BC','index'=>'status_bc','width'=>100, 'align'=>'center'))
                    ->addColumn(array('label'=>'Segel','index'=>'flag_bc','width'=>80, 'align'=>'center'))
                    ->addColumn(array('label'=>'No. SPK','index'=>'NoJob','width'=>160))
                    ->addColumn(array('label'=>'No. Container','index'=>'NOCONTAINER','width'=>160,'editable' => true, 'editrules' => array('required' => true)))
                    ->addColumn(array('label'=>'Size','index'=>'SIZE', 'width'=>80,'align'=>'center','editable' => true, 'editrules' => array('required' => true,'number'=>true),'edittype'=>'select','editoptions'=>array('value'=>"20:20;40:40")))
                    ->addColumn(array('label'=>'Vessel','index'=>'VESSEL','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'TPS Asal','index'=>'KD_TPS_ASAL','width'=>80,'align'=>'center'))
                    ->addColumn(array('label'=>'ETA','index'=>'ETA', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Consignee','index'=>'CONSIGNEE','width'=>250))
                    ->addColumn(array('label'=>'NPWP Consignee','index'=>'ID_CONSIGNEE','width'=>160,'align'=>'center'))
                    ->addColumn(array('label'=>'No. BC11','index'=>'NO_BC11','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. BC11','index'=>'TGL_BC11','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. POS BC11','index'=>'NO_POS_BC11','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'No. PLP','index'=>'NO_PLP','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. PLP','index'=>'TGL_PLP','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'No. Pabean','index'=>'NO_DAFTAR_PABEAN', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Pabean','index'=>'TGL_DAFTAR_PABEAN', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'No. SPPB','index'=>'NO_SPPB', 'width'=>120,'hidden'=>false,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. SPPB','index'=>'TGL_SPPB', 'width'=>120,'hidden'=>false,'align'=>'center'))
                    ->addColumn(array('label'=>'Kode Dokumen','index'=>'KD_DOK_INOUT','align'=>'center', 'width'=>100,'hidden'=>false))
                    ->addColumn(array('label'=>'Nama Dokumen','index'=>'KODE_DOKUMEN','align'=>'center', 'width'=>120,'hidden'=>false))                   
                    ->addColumn(array('label'=>'Tgl. Masuk','index'=>'TGLMASUK','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam Masuk','index'=>'JAMMASUK','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Release','index'=>'TGLRELEASE','width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Release','index'=>'JAMRELEASE', 'width'=>120,'align'=>'center'))
                    ->addColumn(array('label'=>'Alasan Segel','index'=>'alasan_segel','width'=>150,'align'=>'center'))
                    
                    ->addColumn(array('label'=>'No. MBL','index'=>'NOMBL','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. MBL','index'=>'TGLMBL','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>250,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Behandle','index'=>'TGLBEHANDLE','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Behandle','index'=>'JAMBEHANDLE', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Fiat','index'=>'TGLFIAT','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Fiat','index'=>'JAMFIAT', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Surat Jalan','index'=>'TGLSURATJALAN','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Surat Jalan','index'=>'JAMSURATJALAN', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Kode Kuitansi','index'=>'NO_KUITANSI', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'No. BL/AWB','index'=>'NO_BL_AWB', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. BL/AWB','index'=>'TGL_BL_AWB', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Importir','index'=>'NAMA_IMP','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'NPWP Importir','index'=>'NPWP_IMP','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'Teus','index'=>'TEUS', 'width'=>80,'align'=>'center','editable' => false,'hidden'=>true))
                    ->addColumn(array('label'=>'No. Seal','index'=>'NOSEGEL', 'width'=>120,'editable' => true, 'align'=>'right','hidden'=>true))
                    ->addColumn(array('label'=>'Weight','index'=>'WEIGHT', 'width'=>120,'editable' => true, 'align'=>'right','editrules' => array('required' => true),'hidden'=>true))
                    ->addColumn(array('label'=>'Measurment','index'=>'MEAS', 'width'=>120,'editable' => true, 'align'=>'right','editrules' => array('required' => true),'hidden'=>true))
                    ->addColumn(array('label'=>'Layout','index'=>'layout', 'width'=>80,'editable' => true,'align'=>'center','editoptions'=>array('defaultValue'=>"C-1"),'hidden'=>true))
                    ->addColumn(array('label'=>'BCF Consignee','index'=>'bcf_consignee', 'width'=>70,'hidden'=>true))
                    ->addColumn(array('label'=>'Nama EMKL','index'=>'NAMAEMKL', 'width'=>150,'hidden'=>true)) 
                    ->addColumn(array('label'=>'Telp. EMKL','index'=>'TELPEMKL', 'width'=>150,'hidden'=>true)) 
                    ->addColumn(array('label'=>'Telp. PPJK','index'=>'telp_ppjk', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'No. Truck','index'=>'NOPOL', 'width'=>150,'hidden'=>true)) 
                    ->addColumn(array('label'=>'No. POL','index'=>'NOPOLCIROUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'No. POL Out','index'=>'NOPOL_OUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'Photo Extra','index'=>'photo_release_extra', 'width'=>70,'hidden'=>true))
                    ->addColumn(array('label'=>'Ref. Number Out','index'=>'REF_NUMBER_OUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'Keterangan','index'=>'keterangan_release', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'UID','index'=>'UID', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Entry','index'=>'TGLENTRY', 'width'=>150, 'search'=>false,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Entry','index'=>'JAMENTRY', 'width'=>150, 'search'=>false, 'hidden'=>true))
                    ->addColumn(array('label'=>'Updated','index'=>'last_update', 'width'=>150, 'search'=>false,'hidden'=>true))
                    ->renderGrid()
                }}
            </div>
        </div>
        @else
        <div class="row" style="margin-bottom: 30px;">
             <div class="row" style="margin-bottom: 30px;margin-right: 0;">
            <div class="col-md-8">
                <div class="col-xs-12">Search By Date</div>
                <div class="col-xs-12">&nbsp;</div>
                <div class="col-xs-3">
                    <select class="form-control" id="by" name="by" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        <option value="TGL_PLP">Tgl. PLP</option>
                        <option value="TGLRELEASE">Tgl. Release</option>
                       
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
			
			
			<div class="col-md-12"> 
                {{
                    GridRender::setGridId("fclReleaseGrid")
                    ->enableFilterToolbar()
                    ->setGridOption('mtype', 'POST')
                    ->setGridOption('url', URL::to('/container/grid-data-cy?module=release&_token='.csrf_token()))
                    ->setGridOption('rowNum', 20)
                    ->setGridOption('shrinkToFit', true)
                    ->setGridOption('multiselect', true)
                    ->setGridOption('sortname','TCONTAINER_PK')
                    ->setGridOption('rownumbers', true)
                    ->setGridOption('rownumWidth', 50)
                    ->setGridOption('height', '300')
                    ->setGridOption('rowList',array(20,50,100))
                    ->setGridOption('useColSpanStyle', true)
                    ->setNavigatorOptions('navigator', array('viewtext'=>'view'))
                    ->setNavigatorOptions('view',array('closeOnEscape'=>false))
                    ->setFilterToolbarOptions(array('autosearch'=>true))
                    ->setGridEvent('onSelectRow', 'onSelectRowEvent')
                    ->setGridEvent('gridComplete', 'gridCompleteEvent')
                    ->addColumn(array('key'=>true,'index'=>'TCONTAINER_PK','hidden'=>true))
                    ->addColumn(array('index'=>'TSHIPPINGLINE_FK','hidden'=>true))
                    ->addColumn(array('label'=>'Photo','index'=>'action', 'width'=>120, 'search'=>false, 'sortable'=>false, 'align'=>'center'))
                    ->addColumn(array('label'=>'Status BC','index'=>'status_bc','width'=>100, 'align'=>'center'))

                    ->addColumn(array('label'=>'No. Container','index'=>'NOCONTAINER','width'=>160,'editable' => true, 'editrules' => array('required' => true)))                   
                    ->addColumn(array('label'=>'No. BL/AWB','index'=>'NO_BL_AWB', 'width'=>150))
                    ->addColumn(array('label'=>'Tgl. BL/AWB','index'=>'TGL_BL_AWB', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Consignee','index'=>'CONSIGNEE','width'=>160))
                    ->addColumn(array('label'=>'No. SPPB','index'=>'NO_SPPB', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. SPPB','index'=>'TGL_SPPB', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Nama Dokumen','index'=>'KODE_DOKUMEN','align'=>'center', 'width'=>120,'hidden'=>false))
                    ->addColumn(array('label'=>'Kode Dokumen','index'=>'KD_DOK_INOUT','align'=>'center', 'width'=>120,'hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Release','index'=>'TGLRELEASE','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Release','index'=>'JAMRELEASE', 'width'=>150,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'PPJK','index'=>'telp_ppjk', 'width'=>150,'hidden'=>false))
                    ->addColumn(array('label'=>'TPS Asal','index'=>'KD_TPS_ASAL','width'=>80,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Masuk','index'=>'TGLMASUK','width'=>150,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'Jam. Masuk','index'=>'JAMMASUK', 'width'=>150,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'No. SPK','index'=>'NOSPK','width'=>160,'align'=>'center','hidden'=>false))
                    ->addColumn(array('label'=>'Consolidator','index'=>'NAMACONSOLIDATOR','width'=>250,'align'=>'center'))
                    ->addColumn(array('label'=>'Tujuan','index'=>'GUDANG_TUJUAN', 'width'=>80,'align'=>'center'))
                    ->addColumn(array('label'=>'Lokasi','index'=>'KODE_GUDANG', 'width'=>80,'align'=>'center'))
                    ->addColumn(array('label'=>'NPWP Consignee','index'=>'ID_CONSIGNEE','width'=>160,'hidden'=>true))
                    
                    ->addColumn(array('label'=>'No. MBL','index'=>'NOMBL','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. MBL','index'=>'TGLMBL','width'=>150,'align'=>'center','hidden'=>true))
                    
                    ->addColumn(array('label'=>'Tgl. Behandle','index'=>'TGLBEHANDLE','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Behandle','index'=>'JAMBEHANDLE', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Fiat','index'=>'TGLFIAT','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Fiat','index'=>'JAMFIAT', 'width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Tgl. Surat Jalan','index'=>'TGLSURATJALAN','width'=>150,'align'=>'center','hidden'=>true))
                    ->addColumn(array('label'=>'Jam. Surat Jalan','index'=>'JAMSURATJALAN', 'width'=>150,'align'=>'center','hidden'=>true))
                    
                    ->addColumn(array('label'=>'No. BC11','index'=>'NO_BC11','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. BC11','index'=>'TGL_BC11','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. POS BC11','index'=>'NO_POS_BC11','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'No. PLP','index'=>'NO_PLP','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. PLP','index'=>'TGL_PLP','width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'No. SPJM','index'=>'NO_SPJM', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. SPJM','index'=>'TGL_SPJM', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Segel Merah','index'=>'flag_bc','width'=>80, 'align'=>'center'))
                    ->addColumn(array('label'=>'Kode Kuitansi','index'=>'NO_KUITANSI', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'No. D.Pabean','index'=>'NO_DAFTAR_PABEAN', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. D.Pabean','index'=>'TGL_DAFTAR_PABEAN', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Importir','index'=>'NAMA_IMP','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'NPWP Importir','index'=>'NPWP_IMP','width'=>160,'hidden'=>true))
                    ->addColumn(array('label'=>'ETA','index'=>'ETA', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Size','index'=>'SIZE', 'width'=>80,'align'=>'center','editable' => true, 'editrules' => array('required' => true,'number'=>true),'edittype'=>'select','editoptions'=>array('value'=>"20:20;40:40")))
                    ->addColumn(array('label'=>'Teus','index'=>'TEUS', 'width'=>80,'align'=>'center','editable' => false,'hidden'=>true))
                    ->addColumn(array('label'=>'No. Seal','index'=>'NOSEGEL', 'width'=>120,'editable' => true, 'align'=>'right'))
                    ->addColumn(array('label'=>'Weight','index'=>'WEIGHT', 'width'=>120,'editable' => true, 'align'=>'right','hidden'=>true,'editrules' => array('required' => true)))
                    ->addColumn(array('label'=>'Measurment','index'=>'MEAS', 'width'=>120,'editable' => true, 'align'=>'right','hidden'=>true,'editrules' => array('required' => true)))
                    ->addColumn(array('label'=>'Layout','index'=>'layout', 'width'=>80,'hidden'=>true,'editable' => true,'align'=>'center','editoptions'=>array('defaultValue'=>"C-1")))
                    ->addColumn(array('label'=>'BCF Consignee','index'=>'bcf_consignee', 'width'=>70,'hidden'=>true))
                    ->addColumn(array('label'=>'Nama EMKL','index'=>'NAMAEMKL', 'width'=>150,'hidden'=>true)) 
                    ->addColumn(array('label'=>'Telp. EMKL','index'=>'TELPEMKL', 'width'=>150,'hidden'=>true)) 
                    
                    ->addColumn(array('label'=>'No. Truck','index'=>'NOPOL', 'width'=>150,'hidden'=>true)) 
                    ->addColumn(array('label'=>'No. POL','index'=>'NOPOLCIROUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'No. POL Out','index'=>'NOPOL_OUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'Photo Extra','index'=>'photo_release_extra', 'width'=>70,'hidden'=>true))
                    ->addColumn(array('label'=>'Ref. Number Out','index'=>'REF_NUMBER_OUT', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'Keterangan','index'=>'keterangan_release', 'width'=>150,'hidden'=>true))
                    ->addColumn(array('label'=>'UID','index'=>'UID', 'width'=>150,'align'=>'center'))
                    ->addColumn(array('label'=>'Tgl. Entry','index'=>'TGLENTRY', 'width'=>150, 'search'=>false,'align'=>'center'))
                    ->addColumn(array('label'=>'Jam. Entry','index'=>'JAMENTRY', 'width'=>150, 'search'=>false, 'hidden'=>true))
                    ->addColumn(array('label'=>'Updated','index'=>'last_update', 'width'=>150, 'search'=>false,'hidden'=>true))
                    ->renderGrid()
                }}
                
                <div id="btn-toolbar" class="section-header btn-toolbar" role="toolbar" style="margin: 10px 0;">
                    <div id="btn-group-3" class="btn-group">
                        <button class="btn btn-default" id="btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
                    </div>
                    <div id="btn-group-1" class="btn-group">
                        <button class="btn btn-default" id="btn-edit"><i class="fa fa-edit"></i> Edit</button>
                    </div>
                    <div id="btn-group-2" class="btn-group toolbar-block">
                        <button class="btn btn-default" id="btn-save"><i class="fa fa-save"></i> Save</button>
                        <button class="btn btn-default" id="btn-cancel"><i class="fa fa-close"></i> Cancel</button>
                    </div>  
                    <div id="btn-group-4" class="btn-group">
                        <button class="btn btn-default" id="btn-print-wo"><i class="fa fa-print"></i> Cetak WO</button>
                        <button class="btn btn-default" id="btn-print-sj"><i class="fa fa-print"></i> Cetak Surat Jalan</button>
                    </div>
                    <div id="btn-group-6" class="btn-group">
                        <button class="btn btn-danger" id="btn-print-barcode"><i class="fa fa-print"></i> Print Barcode</button>
                    </div>
                    <div id="btn-group-5" class="btn-group pull-right">
                        <button class="btn btn-warning" id="btn-upload"><i class="fa fa-upload"></i> Upload TPS Online</button>
                    </div>
                </div>
            </div>
            
        </div>
        <form class="form-horizontal" id="release-form" action="{{ route('fcl-delivery-release-index') }}" method="POST">
            <div class="row">
                <div class="col-md-6">
                    
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input id="TCONTAINER_PK" name="TCONTAINER_PK" type="hidden">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. SPK</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOJOBORDER" name="NOJOBORDER" class="form-control" readonly>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. MBL</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOMBL" name="NOMBL" class="form-control" readonly>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Container</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOCONTAINER" name="NOCONTAINER" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Size</label>
                        <div class="col-sm-3">
                            <input type="text" id="SIZE" name="SIZE" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">TPS Asal</label>
                        <div class="col-sm-3">
                            <input type="text" id="KD_TPS_ASAL" name="KD_TPS_ASAL" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Shipping Line</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="TSHIPPINGLINE_FK" name="TSHIPPINGLINE_FK" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose Shipping Line</option>
                                @foreach($shippinglines as $shippingline)
                                    <option value="{{ $shippingline->id }}">{{ $shippingline->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Consolidator</label>
                        <div class="col-sm-8">
                            <input type="text" id="NAMACONSOLIDATOR" name="NAMACONSOLIDATOR" class="form-control" readonly>
                        </div>
                    </div>-->
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Dokumen</label>
                        <div class="col-sm-8">
                            <input type="text" id="KD_DOK_INOUT" name="KD_DOK_INOUT" class="form-control" readonly>
                        </div>
                    </div>-->
                    

                </div>
                <div class="col-md-6">
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.SPPB</label>
                        <div class="col-sm-3">
                            <input type="text" id="NO_SPPB" name="NO_SPPB" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">Tgl.SPPB</label>
                        <div class="col-sm-3">
                            <input type="text" id="TGL_SPPB" name="TGL_SPPB" class="form-control" readonly>
                        </div>
                    </div>-->
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.SPJM</label>
                        <div class="col-sm-3">
                            <input type="text" id="NO_SPJM" name="NO_SPJM" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">Tgl.SPJM</label>
                        <div class="col-sm-3">
                            <input type="text" id="TGL_SPJM" name="TGL_SPJM" class="form-control" readonly>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.BC11</label>
                        <div class="col-sm-3">
                            <input type="text" id="NO_BC11" name="NO_BC11" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">Tgl.BC11</label>
                        <div class="col-sm-3">
                            <input type="text" id="TGL_BC11" name="TGL_BC11" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.PLP</label>
                        <div class="col-sm-3">
                            <input type="text" id="NO_PLP" name="NO_PLP" class="form-control" readonly>
                        </div>
                        <label class="col-sm-2 control-label">Tgl.PLP</label>
                        <div class="col-sm-3">
                            <input type="text" id="TGL_PLP" name="TGL_PLP" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Consignee</label>
                        <div class="col-sm-8">
                            <input type="text" id="CONSIGNEE" name="CONSIGNEE" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">NPWP Consignee</label>
                        <div class="col-sm-8">
                            <input type="text" id="ID_CONSIGNEE" name="ID_CONSIGNEE" class="form-control">
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Telp. PPJK</label>
                        <div class="col-sm-8">
                            <input type="text" id="telp_ppjk" name="telp_ppjk" class="form-control">
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label class="col-sm-3 control-label">PPJK</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" id="telp_ppjk" name="telp_ppjk" style="width: 100%;" tabindex="-1" aria-hidden="true" >
                                <option value="">Choose PPJK</option>
                                @foreach($ppjk as $p)
                                    <option value="{{ $p->name }} {{ $p->phone }}">{{ $p->name }} {{ $p->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2" id="btn-ppjk">
                            <button type="button" class="btn btn-info" id="add-ppjk-btn">Add PPJK</button>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tgl. Surat Jalan</label>
                        <div class="col-sm-8">
                            <input type="text" id="TGLSURATJALAN" name="TGLSURATJALAN" class="form-control" readonly>
                        </div>
                    </div>-->
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jam Surat Jalan</label>
                        <div class="col-sm-8">
                            <input type="text" id="JAMSURATJALAN" name="JAMSURATJALAN" class="form-control" readonly>
                        </div>
                    </div>-->
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Kode Dokumen</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="KD_DOK_INOUT" name="KD_DOK_INOUT" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="">Choose Document</option>
                                @foreach($kode_doks as $kode)
                                    <option value="{{ $kode->kode }}">({{$kode->kode}}) {{ $kode->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <div class="col-sm-11" id="btn-sppb">
                            <button type="button" class="btn btn-info pull-right" id="get-sppb-btn"><i class="fa fa-download"></i> Get Data</button>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">No. SPPB</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_SPPB" name="NO_SPPB" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Tgl. SPPB</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="TGL_SPPB" name="TGL_SPPB" class="form-control pull-right datepicker" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group select-bcf-consignee" style="display:none;">
                        <label class="col-sm-3 control-label">BCF 1.5 Consignee</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="bcf_consignee" name="bcf_consignee" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                                <option value="">Choose Consignee</option>
                                <option value="PT. LAYANAN LANCAR LINTAS LOGISTINDO">PT. LAYANAN LANCAR LINTAS LOGISTINDO</option>
                                <option value="PT. MULTI SEJAHTERA ABADI">PT. MULTI SEJAHTERA ABADI</option>
                                <option value="PT. TRANSCON INDONESIA">PT. TRANSCON INDONESIA</option>
                                <option value="PT. TRI PANDU PELITA">PT. TRI PANDU PELITA</option>
                            </select>
                        </div>
                    </div>
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">No. Kuitansi</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_KUITANSI" name="NO_KUITANSI" class="form-control" required>
                        </div>
                    </div>-->
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">No. B/L AWB</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_BL_AWB" name="NO_BL_AWB" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Tgl. B/L AWB</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="TGL_BL_AWB" name="TGL_BL_AWB" class="form-control pull-right datepicker" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Ref. Number</label>
                        <div class="col-sm-8">
                            <input type="text" id="REF_NUMBER_OUT" name="REF_NUMBER_OUT" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="keterangan_release" name="keterangan_release"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">No. Pabean</label>
                        <div class="col-sm-8">
                            <input type="text" id="NO_DAFTAR_PABEAN" name="NO_DAFTAR_PABEAN" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Tgl. Pabean</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="TGL_DAFTAR_PABEAN" name="TGL_DAFTAR_PABEAN" class="form-control pull-right datepicker" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">Tgl. Release</label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="TGLRELEASE" name="TGLRELEASE" class="form-control pull-right datepicker">
                            </div>
                        </div>
                    </div>
                    
                    <div class="bootstrap-timepicker hide-kddoc">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jam Release</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="JAMRELEASE" name="JAMRELEASE" class="form-control timepicker">
                                    <div class="input-group-addon">
                                          <i class="fa fa-clock-o"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group hide-kddoc">
                        <label class="col-sm-3 control-label">No. POL</label>
                        <div class="col-sm-8">
                            <input type="text" id="NOPOL_OUT" name="NOPOL_OUT" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group hide-kddoc" id="btn-photo">
                        <label class="col-sm-3 control-label">Photo</label>
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-warning" id="upload-photo-btn">Upload Photo</button>
                            <button type="button" class="btn btn-danger" id="delete-photo-btn">Delete Photo</button>
                        </div>
                    </div>
                    <div class="form-group hide-kddoc">
                        <div class="col-sm-12">
                            <div id="load_photos" style="text-align: center;"></div>
                </div>
                    </div>
                </div>
                <!--<div class="col-md-6">--> 
                                     
<!--                    <div class="form-group">
                        <label class="col-sm-3 control-label">Petugas</label>
                        <div class="col-sm-8">
                            <input type="text" id="UIDSURATJALAN" name="UIDSURATJALAN" class="form-control" required>
                        </div>
                    </div>-->
                    
                <!--</div>-->
            </div>
        </form>  
        @endrole
    </div>
</div>
<div id="photo-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="modal">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="upload-title"></h4>
            </div>
            <form class="form-horizontal" id="upload-photo-form" action="{{ route('fcl-release-upload-photo') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_cont" name="id_cont" required>   
                            <input type="hidden" id="no_cont" name="no_cont" required>    
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Photo</label>
                                <div class="col-sm-8">
                                    <input type="file" name="photos[]" class="form-control" multiple="true" required>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="view-photo-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Photo</h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-md-12">
                        <h3>CONTAINER</h3>
                        <div id="container-photo"></div>
                    </div>
                </div>
            </div>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="verify-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Verification Container</h4>
            </div>
            <form class="form-horizontal" id="verify-form">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <div id="verify-photo"></div>
                        </div>
                        
                        <div class="col-md-12">
                            <hr />
                            <input type="hidden" id="verify-contid" name="verify_contid" required> 
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Please Insert No. Container</label>
                                <div class="col-sm-7">
                                    <input type="text" id="verify-contno" name="verify_contno" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Verify</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="datepick-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Please Choose Payment Date</h4>
            </div>
            <form class="form-horizontal" id="datepick-form">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="datepick-contid" name="datepick_contid" required> 
							<input type="hidden" id="datepick-inv" name="datepick_inv" required>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Pembayaran s/d Tanggal</label>
                                <div class="col-sm-7">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" id="payment_date" name="payment_date" class="form-control pull-right datepicker" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Print</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="print-barcode-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="title-photo">Print Barcode <span id="barcode_no_cont"></span></h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <input type="hidden" id="id_cont_barcode" required>   
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Lokasi Gudang</label>
                        <div class="col-sm-8">
                            <select class="form-control select2" id="release_lokasi" name="lokasi_gudang" style="width: 100%;" tabindex="-1" aria-hidden="true" required disabled="false">
                                <option value="ARN1" selected>ARN1 (Utara)</option>
                                <option value="ARN3">ARN3 (Barat)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" id="print-barcode-single" class="btn btn-primary">Create</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="ppjk-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="modal">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Add New PPJK</h4>
            </div>
            <form class="form-horizontal" id="create-ppjk-form" action="{{ route('ppjk-store') }}" method="POST">
                <div class="modal-body"> 
                    <div class="row">
                        <div class="col-md-12">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nama</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" class="form-control" required /> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Telepon</label>
                                <div class="col-sm-8">
                                    <input type="tel" name="phone" class="form-control" required /> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('custom_css')

<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/datepicker/datepicker3.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css") }}">

@endsection

@section('custom_js')

<script src="{{ asset("/bower_components/AdminLTE/plugins/datepicker/bootstrap-datepicker.js") }}"></script>
<script src="{{ asset("/bower_components/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js") }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<script type="text/javascript">
    $('.select2').select2();
    $('#ID_CONSIGNEE').mask("99.999.999.9-999.999");
    
    $("#upload-photo-btn").on("click", function(e){
        e.preventDefault();
        $("#photo-modal").modal('show');
        return false;
    });
    
    $("#delete-photo-btn").on("click", function(e){
        if(!confirm('Apakah anda yakin akan menghapus photo?')){return false;}
        
        $('#load_photos').html('');
        $('#delete_photo').val('Y');
    });
    
    $('.datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd' 
    });
    $('.timepicker').timepicker({ 
        showMeridian: false,
        showInputs: false,
        showSeconds: true,
        minuteStep: 1,
        secondStep: 1
    });
    $(".timepicker").mask("99:99:99");
    $(".datepicker").mask("9999-99-99");
    
    $("#add-ppjk-btn").on("click", function(e){
        e.preventDefault();
        $("#ppjk-modal").modal('show');
        return false;
    });
    
    $("#create-ppjk-form").on("submit", function(){
        console.log(JSON.stringify($(this).formToObject('')));
        var url = $(this).attr('action');

        $.ajax({
            type: 'POST',
            data: JSON.stringify($(this).formToObject('')),
            dataType : 'json',
            url: url,
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Something went wrong, please try again later.');
            },
            beforeSend:function()
            {

            },
            success:function(json)
            {
//                console.log(json);

                if(json.success) {
                    $('#btn-toolbar').showAlertAfterElement('alert-success alert-custom', json.message, 5000);
                    $("#telp_ppjk").append('<option value="'+json.data.name+' '+json.data.phone+'" selected="selected">'+json.data.name+' '+json.data.phone+'</option>');
                    $("#telp_ppjk").trigger('change');
                    $("#ppjk-modal").modal('hide');
                } else {
                    $('#btn-toolbar').showAlertAfterElement('alert-danger alert-custom', json.message, 5000);
                }
//                
//                //Triggers the "Close" button funcionality.
//                $('#btn-refresh').click();
            }
        });
        
        return false;
    });
</script>
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

        var current_filters = jQuery("#fclReleaseGrid").getGridParam("postData").filters;
        
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

        jQuery("#fclReleaseGrid").jqGrid("setGridParam", { postData: {filters} }).trigger("reloadGrid");
        
        return false;
    });
</script>
@endsection
