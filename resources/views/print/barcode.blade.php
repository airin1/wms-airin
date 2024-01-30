@foreach($barcodes as $barcode)
    
    @if($barcode->ref_type == 'Manifest')        
	    <div style="margin: 20px 0">
            <div style="text-align: center;margin: 0 auto;">
                <span style="font-size:12px;">{{strtoupper($barcode->ref_action).' - '.date('d/m/Y H:i')}}</span>
                <h3 style="margin: 10px;">GATE PASS</h3>
                
                @if($custom_location != '')
                    @if($custom_location == 'ARN1')
                        <h5 style="margin: 10px;">TPS AIRIN (Utara)</h5>
                    @else
                        <h5 style="margin: 10px;">TPS AIRIN (Barat)</h5>
                    @endif
                @else               
                    @if($barcode->LOKASI_GUDANG == 'ARN1')
                        <h5 style="margin: 10px;">TPS AIRIN (Utara)</h5>
                    @else
                        <h5 style="margin: 10px;">TPS AIRIN (Barat)</h5>
                    @endif
                @endif
                
                {!!QrCode::margin(0)->size(80)->generate($barcode->barcode)!!}
                <p style="font-size: 10px;margin: 0;padding: 0;">{{$barcode->barcode}}</p>
                <p style="font-size: 13px;font-weight: bold;">
                    {{$barcode->NOHBL}}<br />
                    {{$barcode->CONSIGNEE}}                   
                </p>
                <p style="font-size: 13px;">
                    NO. DOC {{$barcode->NO_SPPB}}<br />
				    JNS. DOC {{$barcode->KODE_DOKUMEN}}<br /> 
                    TGL. DOC {{date('d/m/Y', strtotime($barcode->TGL_SPPB))}}<br /><br />
                    Lokasi : {{$barcode->location_name}}
                </p>
                <!--<span style="font-size:10px;">{{'EXPIRED - '.date('d/m/Y', strtotime($barcode->expired))}}</span>-->
            </div>
        </div>
        <div style="display:block; page-break-before:always;"></div>
        
        @elseif($barcode->ref_type == 'Manifesteks')  
    <div style="margin: 20px 0">
        <div style="text-align: center;margin: 0 auto;">
            
        <span style="font-size:12px;">{{strtoupper($barcode->ref_action).' - '.date('d/m/Y H:i')}}</span>
        <span style="font-size:12px;">Manifest Export</span>
                <h3 style="margin: 10px;">GATE PASS</h3>
            
          
            
            {!!QrCode::margin(0)->size(80)->generate($barcode->barcode)!!}
            <p style="font-size: 10px;margin: 0;padding: 0;">{{$barcode->barcode}}</p>
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;">
                    NO. PACK {{$barcode->manifest->NO_PACK}}<br /> 
                    TGL. PACK {{date('d/m/Y', strtotime($barcode->manifest->TGL_PACK))}}<br /><br />
                    Customer : {{$barcode->manifest->CONSIGNEE}}
                </p>
                <br>
                <p style="font-size: 13px;">
                @if($barcode->manifest->KODE_DOKUMEN == '6')
                    Dokumen : NPE
                @elseif($barcode->manifest->KODE_DOKUMEN == '37')
                    Dokumen ATA CARNET Ekspor
                @else
                    Dokumen CPD CARNET Ekspor
                @endif
                <br />
                    No Dokumen : {{$barcode->manifest->NO_NPE}}<br />
                    Tgl. Dokumen : {{$barcode->manifest->CONSIGNEE}}
                </p>
            
            <!--<span style="font-size:10px;">{{'EXPIRED - '.date('d/m/Y', strtotime($barcode->expired))}}</span>-->
        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>
    @elseif($barcode->ref_type == 'LCLEKS')  
    <div style="margin: 20px 0">
        <div style="text-align: center;margin: 0 auto;">
            
        <span style="font-size:12px;">{{strtoupper($barcode->ref_action).' - '.date('d/m/Y H:i')}}</span>
        <span style="font-size:12px;">Container Export Gate-IN</span>
                <h3 style="margin: 10px;">GATE PASS</h3>
            
          
            
            {!!QrCode::margin(0)->size(80)->generate($barcode->barcode)!!}
            <p style="font-size: 10px;margin: 0;padding: 0;">{{$barcode->barcode}}</p>
            <p style="font-size: 13px;font-weight: bold">
                                  
            </p>
            <p style="font-size: 13px;">
                    NO. Container    {{$barcode->container->NOCONTAINER}}<br /> 
                    NO. BOOKING      {{$barcode->container->NOBOOKING}}<br /> 
                    TGL. Booking        {{date('d/m/Y', strtotime($barcode->container->TGL_BOOKING))}}<br /><br />
                    Customer : {{$barcode->container->NAMACONSOLIDATOR}}
                </p>
                @if($barcode->container->KD_DOKUMEN != NULL)
                <p style="font-size: 13px;">
                     @if($barcode->container->KODE_DOKUMEN == '6')
                         Dokumen : NPE
                     @else
                         Dokumen : PKBE
                     @endif
                <br />
                    No Dokumen : {{$barcode->container->NO_PKBE}}<br />
                    Tgl. Dokumen : {{$barcode->container->TGL_PKBE}}
                </p>
                @endif
            
            <!--<span style="font-size:10px;">{{'EXPIRED - '.date('d/m/Y', strtotime($barcode->expired))}}</span>-->
        </div>
    </div>
    <div style="display:block; page-break-before:always;"></div>

    @else
        <div style="margin: 20px 0">
            <div style="text-align: center;margin: 0 auto;">
                <span style="font-size:12px;">{{strtoupper($barcode->ref_action).' - '.date('d/m/Y H:i')}}</span>
                <h3 style="margin: 10px;">GATE PASS</h3>
                
                @if($custom_location != '')
                    @if($custom_location == 'ARN1')
                        <h5 style="margin: 10px;">TPS AIRIN (Utara)</h5>
                    @else
                        <h5 style="margin: 10px;">TPS AIRIN (Barat)</h5>
                    @endif
                @else
                    @if(isset($barcode->LOKASI_GUDANG))
                        @if($barcode->LOKASI_GUDANG == 'ARN1')
                            <h5 style="margin: 10px;">TPS AIRIN (Utara)</h5>
                        @else
                            <h5 style="margin: 10px;">TPS AIRIN (Barat)</h5>
                        @endif
                    @else
                        @if($barcode->KODE_GUDANG == 'ARN1')
                            <h5 style="margin: 10px;">TPS AIRIN (Utara)</h5>
                        @else
                            <h5 style="margin: 10px;">TPS AIRIN (Barat)</h5>
                        @endif
                    @endif 
                @endif
              
                {!!QrCode::margin(0)->size(80)->generate($barcode->barcode)!!}
                <p style="font-size: 10px;margin: 0;padding: 0;">{{$barcode->barcode}}</p>
                <p style="font-size: 13px;font-weight: bold;">
                    {{$barcode->NOCONTAINER}}<br />
                    {{strtoupper($barcode->ref_type).' '.$barcode->SIZE."'"}} - {{$barcode->KD_TPS_ASAL}}<br />
                    {{$barcode->NO_SEAL}}
                </p>
                <p style="font-size: 13px;">
                    {{$barcode->VESSEL}} - VOYAGE {{$barcode->VOY}}
                </p>                 
				<p style="font-size: 13px;">
				@if(strtoupper($barcode->ref_action) != 'RELEASE')
                    NO. PLP {{$barcode->NO_PLP}}<br />
                    TGL. PLP {{date('d/m/Y', strtotime($barcode->TGL_PLP))}}<br /><br />
                    Lokasi : {{$barcode->location_name}}
				@else
				    NO. DOC {{$barcode->NO_SPPB}}<br />
				    JNS. DOC {{$barcode->KODE_DOKUMEN}}<br /> 
                    TGL. DOC {{date('d/m/Y', strtotime($barcode->TGL_SPPB))}}<br /><br />
                    Lokasi : {{$barcode->location_name}}
			
				@endif	
                </p>
								
                <!--<span style="font-size:10px;">{{'EXPIRED - '.date('d/m/Y', strtotime($barcode->expired))}}</span>-->
            </div>
        </div>
        <div style="display:block; page-break-before:always;"></div>
    @endif
@endforeach
