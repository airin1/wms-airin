@extends('print')

@section('title')
    
@stop

@section('content')
<style>
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

.left {
    float: left;
}

.right {
    float: right;
}

.text-right {
    text-align: right;
}

.text-center {
    text-align: center;
}

.text-left {
    text-align: left;
}

a {
  color: #000;
  text-decoration: none;
}

body {
  position: relative;
  width: 100%;  
  height: 100%; 
  margin: 0 auto; 
  color: #000;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
}

#header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#title {
    font-size: 20px;
    text-align: center;
    margin-bottom: 20px;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  /*margin-bottom: 20px;*/
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
  float: right;
  text-align: right;
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
  font-size: 12px;
}

table th,
table td {
  padding: 2px 0;
/*  background: #EEEEEE;*/
  /*text-align: center;*/
  border-bottom: 0;
  border-top: 0;
  font-size: 10px !important;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
  padding: 5px;
    border-bottom: 1px solid;
    font-weight: bold;
    font-size: 12px;
}

table td {
  text-align: left;
  padding: 3px;
  font-size: 12px;
}

table.grid td {
    border-right: 1px solid;
}

table td.padding-10 {
    padding: 0 10px;
}

table td h3{
  color: #000;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border-bottom: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #000;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

#footer {
  /*color: #777777;*/
  width: 100%;
  /*height: 30px;*/
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

    @media print {
        body {
            color: #000;
            background: #fff;
        }
        @page {
            size: auto;   /* auto is the initial value */
            margin-top: 114px;
            margin-bottom: 90px;
            margin-left: 38px;
            margin-right: 75px;
            font-weight: bold;
        }
        .print-btn {
            display: none;
        }
    }
</style>
<div class="wrapper" style="text-align: center;">
    <h5 style="margin-bottom: 0;font-size: 13px;">LAPORAN REKAP REALISASI PELAKSANAAN PINDAH LOKASI PENIMBUNAN (PLP) DARI TPK {{$header['tpk']}}<br/>
        KE LAPANGAN TPS PT AIRIN - {{$header['lokasi'] .' ('.$header['jenis'].')'}}
    </h5>
    <p style="margin-top: 5px;font-size: 11px;">PELAKSANA PEMINDAHAN: {{$header['consignee']}}<br />
        Tanggal: {{$header['tanggalmulai'].' s/d '.$header['tanggalakhir'] }}<br/>
      
    </p>
</div>
<div id="details" class="clearfix" style="font-weight: bold;">
   
    
    <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">

        <tr>
            <th style="text-align: center;" rowspan="3">NO</th>
			<th style="text-align: center;" rowspan="3">BULAN</th>
			<th style="text-align: center;" rowspan="3">TIPE</th>
            <th style="text-align: center;" colspan="7">RELAISASI(BOX)</th>
            <th style="text-align: center;" colspan="9">REALISASI(TEUS)</th>
			<th style="text-align: center;" rowspan="3">NILAI UUDP</th>
            <th style="text-align: center;" rowspan="3">PENCAPAIAN NILAI RUPIAH</th>
        </tr>
        <tr>
            <th style="text-align: center;" colspan="2">UTARA</th>
            <th style="text-align: center;" rowspan="2">JML</th>
			<th style="text-align: center;" colspan="2">BARAT</th>
			<th style="text-align: center;" rowspan="2">JML</th>
			<th style="text-align: center;" rowspan="2" >TOTAL BOX</th>
			<th style="text-align: center;" colspan="3">UTARA</th>
			<th style="text-align: center;" colspan="3">BARAT</th>
			<th style="text-align: center;" colspan="3">PENCAPAIAN TOTAL</th>
		
        </tr>
		<tr>    
    		<th style="text-align: center;">20'</th>
            <th style="text-align: center;">40'</th>    
			<th style="text-align: center;">20'</th>
            <th style="text-align: center;">40'</th>    
			<th style="text-align: center;">RENC</th>
            <th style="text-align: center;">REAL</th>    
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">RENC</th>
            <th style="text-align: center;">REAL</th>    
			<th style="text-align: center;">%</th>
			<th style="text-align: center;">RENC</th>
            <th style="text-align: center;">REAL</th>    
			<th style="text-align: center;">%</th>
            
        </tr>
        <?php $i = 1;?>
        @foreach($containers as $container)
        <tr>
            <td style="text-align: center;">{{$i}}</td>
            <td style="text-align: center;">{{$container->NO_PLP}}</td>
            <td style="text-align: center;">{{date('d-M-y',strtotime($container->TGL_PLP))}}</td>
            <td>{{$container->NOCONTAINER}}</td>
            <td style="text-align: center;">{{($container->SIZE == 20) ? 1:''}}</td>
            <td style="text-align: center;">{{($container->SIZE == 40) ? 1:''}}</td>
            <td style="text-align: center;">{{($container->SIZE == 45) ? 1:''}}</td>
            <td>{{$container->NO_SURAT}}</td>
            <td style="text-align: center;">{{$container->NOPOL}}</td>
            <td style="text-align: center;">{{$container->KD_TPS_ASAL}}</td>
            <td style="text-align: center;">{{$container->JAMMASUK}}</td>
            <td style="text-align: center;">{{date('d-M-y',strtotime($container->TGLMASUK))}}</td>
        </tr>
        <?php $i++;?>
        @endforeach
        <tr>
            <td colspan="2" style="text-align: center;border-top: 1px solid;"><b>JUMLAH TOTAL</b></td>
			<td style="text-align: center;border-top: 1px solid;"><b>DRY</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box20dry']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box40dry']}}</b></td>
			<td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box20dry']+$footer['box40dry']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box20']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box40']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['jumlah']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['jumlah']}}</b></td>
           
		    <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box20']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box40']}}</b></td>
			<td style="text-align: center;border-top: 1px solid;"><b>{{$footer['jumlah']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box20']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['box40']}}</b></td>
            <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['jumlah']}}</b></td>
	        <td style="text-align: center;border-top: 1px solid;"><b>{{$footer['jumlah']}}</b></td>
			<td colspan="2" style="text -align: center;border-top: 1px solid;"><b>JUMLAH TOTAL</b></td>


        </tr>    
		
    </table>
    
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-bottom: 0;">
        <tr>
            <td style="font-size: 11px;">Mengetahui,</td>
            <td style="text-align: right;font-size: 11px;">Jakarta, {{date('d F Y')}}</td>
        </tr>
        <tr>
            <td style="font-size: 11px;" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11px;" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11px;" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="font-size: 11px;"><b style="text-decoration: underline;">YANUAR ANDRES SUSILO</b><br/>Manager TPS</td>
            <td style="text-align: right;font-size: 11px;"><b style="text-decoration: underline;">RINI ELVIRA</b><br />Kabid. Admin. Lapangan TPS</td>
        </tr>
    </table>
</div>

@stop