@extends('print-with-noheader')

@section('title')
    
@stop

@section('content')

<div class="row">
    <div class="col-xs-8 table-responsive">
        <table class="table" style="font-size: 14px;">
            <tbody>
                <tr>
                    <td style="width: 150px;">No Daftar</td>
                    <td> : </td>
                    <td>{{ $npe->NO_DAFTAR }}</td>
                </tr>
                <tr>
                    <td>No. NPE</td>
                    <td> : </td>
                    <td>{{ $npe->NONPE }}</td>
                </tr>
                <tr>
                    <td>Tgl. Daftar</td>
                    <td> : </td>
                    <td>{{ $npe->TGL_DAFTAR }}</td>
                </tr>
                <tr>
                    <td>Tgl. NPE</td>
                    <td> : </td>
                    <td>{{ $npe->TGLNPE }}</td>
                </tr>
                <tr>
                    <td>Kode Kantor </td>
                    <td> : </td>
                    <td>{{ $npe->KD_KANTOR }}</td>
                </tr>
                <tr>
                    <td>NPWP Eksportir</td>
                    <td> : </td>
                    <td>{{ $npe->NPWP_EKS }}</td>
                </tr>
                <tr>
                    <td>Nama Eksportir</td>
                    <td> : </td>
                    <td>{{ $npe->NAMA_EKS }}</td>
                </tr>
            </tbody>
        </table>
        	<br />
			<br /><br /><br />
    </div>
</div>
 
 <div class="row" >
        <div class="col-xs-12 table-responsive">
           <caption>CONTAINER</caption>
            <table class="table" border="1" width="300px">
                <thead>
                    <tr>
                        <th>NO CONTAINER</th>
                        <th>SIZE</th>
                        <th>FL Segel</th>
                        
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($con as $p)
                    <tr>
                        
                        <td style="text-align: center;">{{ $p->NO_CONT }}</td>
                        <td style="text-align: center;">{{ $p->SIZE }}</td>
                        <td style="text-align: center;">{{ $p->FL_SEGEL }}</td>
                    
                      
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
			<br />
			<br /><br /><br />
        </div>
    </div>

	
	
     <div class="row" >
        <div>
		 <caption>KEMASAN</caption>
            <table class="table" border="1" width="300px">
                <thead>
                    <tr>
                        <th with="100px">JENIS KMS</th>
                        <th with="100px">MERK KMS</th>
                        <th with="100px">JML KMS</th>
                        
                    </tr>
                </thead>
                <tbody>
                   
                @foreach($con as $p)
                    <tr>
                        
                        <td style="text-align: center;">{{ $p->JNS_KMS }}</td>
                        <td style="text-align: center;">{{ $p->MRK_KMS }}</td>
                        <td style="text-align: center;">{{ $p->JML_KMS }}</td>
                    
                      
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
			 <br />
        <p>Jakarta, {{date('d F Y')}}</p>
        <br /><br /><br />
        <p>{{ \Auth::getUser()->name }}</p>
        </div>
    </div>
        
@stop

