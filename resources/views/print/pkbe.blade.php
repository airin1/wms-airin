@extends('print-with-noheader')

@section('title')
    
@stop

@section('content')

<div class="row">
    <div class="col-xs-8 table-responsive">
        <table class="table" style="font-size: 14px;">
            <tbody>
                <tr>
                    <td style="width: 150px;">CAR</td>
                    <td> : </td>
                    <td>{{ $pkbe->CAR }}</td>
                </tr>
                <tr>
                    <td>No. PKBE</td>
                    <td> : </td>
                    <td>{{ $pkbe->NOPKBE }}</td>
                </tr>
                <tr>
                    <td>Tgl. PKBE</td>
                    <td> : </td>
                    <td>{{ $pkbe->TGLPKBE }}</td>
                </tr>
                <tr>
                    <td>Kode Kantor </td>
                    <td> : </td>
                    <td>{{ $pkbe->KD_KANTOR }}</td>
                </tr>
                <tr>
                    <td>NPWP Eksportir</td>
                    <td> : </td>
                    <td>{{ $pkbe->NPWP_EKS }}</td>
                </tr>
                <tr>
                    <td>Nama Eksportir</td>
                    <td> : </td>
                    <td>{{ $pkbe->NAMA_EKS }}</td>
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
                        
                    </tr>
                </thead>
                <tbody>
                   
                    @foreach($con as $p)
                    <tr>
                        
                        <td style="text-align: center;">{{ $p->NO_CONT }}</td>
                        <td style="text-align: center;">{{ $p->SIZE }}</td>
         
                    
                      
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
                   
         
                    
                </tbody>
            </table>
			 <br />
        <p>Jakarta, {{date('d F Y')}}</p>
        <br /><br /><br />
        <p>{{ \Auth::getUser()->name }}</p>
        </div>
    </div>
        
@stop

