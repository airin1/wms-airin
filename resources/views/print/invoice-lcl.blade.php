@extends('print-with-noheader')

@section('title')
    {{ 'Invoice '.$invoice->no_invoice }}
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
  border-bottom: 1px solid #000;
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
  border-left: 6px solid #000;
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
  border-color: #000;
}

table th,
table td {
  padding: 2px 0;
/*  background: #EEEEEE;*/
  /*text-align: center;*/
  /*border-bottom: 1px solid #FFFFFF;*/
}
table.table td {
    border-bottom: 1px solid #000;
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
  border-top: 1px solid #000; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #000; 

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
  border-left: 6px solid #000;  
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
  border-top: 1px solid #000;
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
    <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
            <p style="max-width: 300px;font-size: 12px;">
                Kepada Yth :<br /><br />
                <b>{{$consolidator->NAMACONSOLIDATOR}}</b><br />
                {{$consolidator->ALAMAT}}
            </p>
      </div>
        <div class="col-xs-12 text-center margin-bottom">
            <h3 style="text-decoration: underline;">FAKTUR</h3>
            <p style="font-size: 12px;">No : {{$invoice->no_invoice}}<br />{{$invoice->no_spk}}</p>
        </div>
      <div class="col-sm-4 invoice-col">
          <table>
              <tr>
                  <td style="width: 120px;"><b>FORWARDER</b></td>
                  <td  style="width: 5px;">:</td>
                  <td><b>{{ $invoice->forwarder }}</b></td>
              </tr>
              <tr>
                  <td><b>D/O - B/L NO</b></td>
                    <td  style="width: 5px;">:</td>
                  <td>{{ $invoice->no_mbl }}</td>
              </tr>
              <tr>
                  <td><b>CONTAINER NO</b></td>
                    <td  style="width: 5px;">:</td>
                  <td>{{ $container->NOCONTAINER .' / '. $container->SIZE."'" }}</td>
              </tr>
              <tr>
                  <td><b>JUMLAH B/L</b></td>
                    <td  style="width: 5px;">:</td>
                  <td>{{ $invoice->jumlah_hbl .' BL'}}</td>
              </tr>
          </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    <br />
    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-striped" border="1" cellspacing="0" cellpadding="0">
          <thead>
          <tr>
              <th><b>NO</b></th>
            <th><b>JENIS JASA</b></th>
            <th><b>SATUAN</b></th>     
            <th class="text-center" colspan="2"><b>TARIF</b></th>
            <th class="text-center" colspan="2"><b>JUMLAH BIAYA</b></th>
          </tr>
          </thead>
          <tbody>

          <tr>
            <td class="text-center">1</td>           
            <td>Kontribusi RDM ({{$container->SIZE."'"}})</td>
            <td class="text-center">1 x {{ $container->SIZE }} M3/Ton</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->rdm_20) : number_format($tarif->rdm_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->rdm) }}</td>
          </tr>
        <tr>
            <td class="text-center">2</td>           
            <td>LIFT ON/OFF FULL ({{$container->SIZE."'"}})</td>
            <td class="text-center">1</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->lift_full_20) : number_format($tarif->lift_full_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->lift_full) }}</td>
          </tr>
        <tr>
            <td class="text-center">3</td>           
            <td>LIFT ON/OFF MTY ({{$container->SIZE."'"}})</td>
            <td class="text-center">1</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->lift_mty_20) : number_format($tarif->lift_mty_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->lift_mty) }}</td>
          </tr>
        <tr>
            <td class="text-center">4</td>           
            <td>STORAGE EMPTY ({{$container->SIZE."'"}})</td>
            <td class="text-center">0</td>
            <td align="right">Rp.</td>
            <td align="right">{{ ($container->SIZE == 20) ? number_format($tarif->storage_mty_20) : number_format($tarif->storage_mty_40)  }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->storage_mty) }}</td>
          </tr>
        <tr>
            <td colspan="5"><b>SUBTOTAL</b></td>           
            <td align="right"><b>Rp.</b></td>
            <td align="right"><b>{{ number_format($invoice->subtotal) }}</b></td>
          </tr>
          <tr>
            <td class="text-center">5</td>           
            <td>PPN </td>
            <td class="text-center">10%</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->subtotal) }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->ppn) }}</td>
          </tr>
        <tr>
            <td class="text-center">6</td>           
            <td>ADMINISTRASI</td>
            <td class="text-center">{{$invoice->jumlah_hbl.' B/L'}}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($tarif->adm) }}</td>
            <td align="right">Rp.</td>
            <td align="right">{{ number_format($invoice->adm) }}</td>
          </tr>
            <tr>
              <th colspan="5" align="right">MATERAI</th>
              <td align="right">Rp.</td>
              <td align="right">{{ number_format($invoice->materai) }}</td>
            </tr>
            <tr>
              <th colspan="5" align="right">TOTAL PEMBAYARAN</th>
              <td align="right"><b>Rp.</b></td>
              <td align="right"><b>{{ number_format($invoice->total) }}</b></td>
            </tr>
          </tbody>
        </table>
          <p style="font-size: 12px;"><b>
              Terbilang : <br />
              {{$terbilang}}
              </b>
          </p>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

 
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Jakarta, {{ ($invoice->tgl_cetak != "") ? date("d F Y", strtotime($invoice->tgl_cetak)) : date("d F Y") }}<br /><b>PT. AIRIN</b></td>
        </tr>
        <tr><td height="30" style="font-size: 30px;line-height: 0;">&nbsp;</td></tr>
        <tr>
            <td width='50%'>
                <p style="font-size: 10px;">
                    Pengajuan keberatan : <br />
                    Jika terdapat kekeliruan, agar dapat diajukan dalam batas waktu 4 x 24 Jam (4 Hari). Lewat batas waktu tersebut tidak dilayani.</li>
                </p>
            </td>
            <td width='20%'>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><b>SIGIT MARET HARYADI</b><br />Manager TPS</td>
        </tr>
    </table>
    </div>
@stop