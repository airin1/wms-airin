@extends('print')

@section('title')
    {{ 'Delivery Surat Jalan B/L No. '.$manifest->NOHBL }}
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
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 100%;  
  height: 100%; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 14px; 
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
  margin-bottom: 10px;
  font-size: 12px;
}

table th,
table td {
  padding: 2px 0;
/*  background: #EEEEEE;*/
  /*text-align: center;*/
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
  padding: 5px;
    border-bottom: 1px solid;
    font-weight: bold;
}

table td {
  text-align: left;
  padding: 3px;
}

table.grid td {
    border-right: 1px solid;
}

table td.padding-10 {
    padding: 0 10px;
}

table td h3{
  color: #57B223;
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
  color: #57B223;
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
<a href="#" class="print-btn" type="button" onclick="window.print();">PRINT</a>

    <div id="details" class="clearfix">
        <div style="text-align: center;font-size: 16px;margin-bottom: 20px;">
            <div>SURAT JALAN</div>
            <div style="padding-top: 10px;"><span style="border-top: 1px solid;padding-top: 10px;">NO. ............/LCL/SJ/............</span></div>
        </div>
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="width: 70%;">
                    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
                        <tr>
                            <td style="width: 120px;">Dari Gudang / Lap</td>
                            <td class="text-center" style="width: 10px;">:</td>
                            <td>PT. AIRIN</td>
                        </tr>
                        <tr>
                            <td>Ex. Kapal</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->VESSEL }}</td>
                        </tr>
                        <tr>
                            <td>Voy</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->VOY }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Tiba</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->ETA }}</td>
                        </tr>
                        <tr>
                            <td>Truck No.Pol B.K.A</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->NOPOL }}</td>
                        </tr>
                        <tr>
                            <td>Ex. Stripping</td>
                            <td class="text-center">:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>No. D.O/B.L</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->NOHBL }}</td>
                        </tr>
                        <tr>
                            <td>Party</td>
                            <td class="text-center">:</td>
                            <td>{{ $manifest->SIZE.'"' }}</td>
                        </tr>

                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
                        <tr>
                            <td>DIKIRIM KEPADA : </td>
                        </tr>
                        <tr>
                            <td>{{ $manifest->CONSIGNEE }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        
        <table border="1" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th rowspan="2">No./MERK Lain</th>
                    <th rowspan="2">JENIS BARANG</th>
                    <th colspan="2">JUMLAH BARANG</th>
                    <th rowspan="2">KETERANGAN</th>
                </tr>
                <tr>
                    <th>Colly</th>
                    <th class="text-center">Ton</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $manifest->NAMACONSOLIDATOR }}</td>
                    <td>{{ $manifest->MARKING }}</td>
                    <td>{{ $manifest->QUANTITY }}/{{ $manifest->NAMAPACKING }}</td>
                    <td>{{ $manifest->MEAS }}</td>
                    <td>{{ $manifest->DESCOFGOODS }}</td>
                </tr>
            </tbody>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="50"></td>
            </tr>
        </table>
        
<!--        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="border: 1px solid;">&nbsp;&nbsp;</td>
                <td>Barang dalam keadaan baik, lengkap dan sesuai DO.</td>
            </tr>
            <tr><td style="border-bottom: 1px solid;"></td><td></td></tr>
            <tr>
                <td style="border: 1px solid;">&nbsp;&nbsp;</td>
                <td>Barang dalam keadaan rusak/cacat/tidak lengkap (Lampiran berita acara)</td>
            </tr>
        </table>-->
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="text-align: right;">Tanjung Priok, {{ date('d F Y') }}</td>
            </tr>
        </table>
        <!--<div style="page-break-after: always;"></div>-->
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="text-align:center">Penerima</td>
                <td style="text-align:center">Bea & Cukai</td>
                <td style="text-align:center">Gudang</td>
                <!--<td class="text-center" style="border: 1px solid;">.......</td>-->
            </tr>
            <tr>
                <td style="height: 50px;">&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <!--<td height="70" style="font-size: 70px;line-height: 0;border: 1px solid;"></td>-->
            </tr>
            <tr>
                <td style="text-align:center">(.......................)</td>
                <td style="text-align:center">(.......................)</td>
                <td style="text-align:center">(.......................)</td>
                <!--<td>&nbsp;</td>-->
            </tr>
        </table>
    </div>
        
@stop