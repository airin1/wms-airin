@extends('print')

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
  font-weight: bold;
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
    <p><b>NO. SPK : {{ $invoice->no_spk }}</b></p>
    <div class="row invoice-info" style="border-top: 2px solid;">
        <div class="col-xs-12 margin-bottom">
            <h3><b>NOTA DAN PERHITUNGAN PELAYANAN JASA :</b><span style="font-weight: lighter;">&nbsp;&nbsp;PENUMPUKAN DAN GERAKAN EKSTRA</span></h3>
        </div>
        <div class="col-sm-4 invoice-col">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="width: 60%;vertical-align: top;">
                        <table border="0" cellspacing="0" cellpadding="0" style="margin: 0;">
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>Perusahaan</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;"><b>{{ $invoice->consignee }}</b></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>Alamat</b></td>
                                <td style="width: 20px;vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ $invoice->alamat }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>Kapal / Voy</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ $invoice->vessel.' / '.$invoice->voy }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>Jenis Container</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ $invoice->jenis_container }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>No Container</b></td>
                                <td style="width: 20px;vertical-align: top;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;width: 50px;">{{ $invoice->no_container }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 100px;"><b>Party</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">
                                    <?php $party = @unserialize($invoice->party);?>
                                    @if(is_array($party))
                                      @foreach($party as $pry)
                                       {{ $pry."' CONTAINER FULL" }}<br />
                                      @endforeach
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: top;">
                        <table border="0" cellspacing="0" cellpadding="0" style="margin: 0;">
                            <tr>
                                <td style="vertical-align: top;width: 110px;"><b>Nomor Faktur</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;"><b>{{ $invoice->no_invoice }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 110px;"><b>Tanggal DO</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ date("d/m/Y", strtotime($invoice->tgl_do)) }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 110px;"><b>Nomor B/L</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ $invoice->no_bl }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 110px;"><b>ETA</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ date("d/m/Y", strtotime($invoice->eta)) }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 110px;display: block;"><b>Gate Out Terminal</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ date("d/m/Y", strtotime($invoice->gateout_terminal)) }}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;width: 110px;"><b>Gate Out TPS</b></td>
                                <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                <td style="vertical-align: top;">{{ date("d/m/Y", strtotime($invoice->gateout_tps)) }}</td>
                            </tr>
                            @if($invoice->renew == 'Y')
                                <tr>
                                  <td colspan="3">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3"><b>PERPANJANGAN FAKTUR NO. {{$invoice->no_faktur_renew}}</b></td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: top;width: 110px;"><b>Tgl. Perpanjang</b></td>
                                    <td style="width: 20px;">&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                    <td style="vertical-align: top;">{{ date("d/m/Y", strtotime($invoice->renew_date)) }}</td>
                                </tr>
                            @endif
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row invoice-info" style="border-top: 2px solid;">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>LOKASI</th>
                        <th>SIZE</th>
                        <th>LAMA TIMBUN</th>
                        <th>JUMLAH</th>
                        <th>TARIF DASAR</th>
                        <th>MASA I</th>
                        <th>MASA II</th>
                        <th>MASA III</th>
                        <th>MASA IV</th>
                        <th>TOTAL SEWA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $grand_total_p = 0;?>
                    @foreach($penumpukan as $p)
                    <tr>
                        <td>{{ $p->lokasi_sandar }}</td>
                        <td style="text-align: center;">{{ $p->size }}</td>
                        <td>({{ date("d/m/Y", strtotime($p->startdate)).' - '.date("d/m/Y", strtotime($p->enddate)) }}) {{ $p->lama_timbun }} hari</td>
                        <td style="text-align: center;">{{ $p->qty }}</td>
                        <td style="text-align: center;">{{ number_format($p->tarif_dasar) }}</td>
                        <td style="text-align: right;">{{ number_format($p->masa1) }}</td>
                        <td style="text-align: right;">{{ number_format($p->masa2) }}</td>
                        <td style="text-align: right;">{{ number_format($p->masa3) }}</td>
                        <td style="text-align: right;">{{ number_format($p->masa4) }}</td>
                        <td style="text-align: right;">{{ number_format($p->total) }}</td>
                        <?php $grand_total_p += $p->total;?>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="10"><div style="border-top:1px dashed !important;width: 100%;height: 1px;">&nbsp;</div></td>
                    </tr>
                    <tr>
                        <th style="text-align: left;" colspan="8">PENUMPUKAN</th>
                        <th style="text-align: right;"><b>Rp.</b></th>
                        <th style="text-align: right;"><b>{{ number_format($grand_total_p) }}</b></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row invoice-info" style="border-top: 2px solid;">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>LOKASI</th>
                    <th>SIZE</th>
                    <th>JENIS GERAKAN</th>
                    <th>JUMLAH</th>
                    <th>TARIF DASAR</th>
<!--                    <th>JML SHIFT</th>
                    <th>START/STOP PLUGGING</th>-->
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>BIAYA</th>
                </tr>
                <?php $grand_total_g = 0;?>
                @foreach($gerakan as $g)
                <tr>
                    <td>{{ $g->lokasi_sandar }}</td>
                    <td style="text-align: center;">{{ $g->size }}</td>
                    <td>{{ $g->jenis_gerakan }}</td>
                    <td style="text-align: center;">{{ $g->qty }}</td>
                    <td style="text-align: right;">{{ number_format($g->tarif_dasar) }}</td>
<!--                    <td style="text-align: center;">{{ number_format($g->jumlah_shift) }}</td>
                    <td style="text-align: center;">{{ number_format($g->start_stop_plugging) }}</td>-->
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td style="text-align: right;">{{ number_format($g->total) }}</td>
                </tr>
                <?php $grand_total_g += $g->total;?>
                @endforeach
                <tr>
                    <td colspan="8"><div style="border-top:1px dashed !important;width: 100%;height: 1px;">&nbsp;</div></td>
                </tr>
                <tr>
                    <th style="text-align: left;" colspan="6">SUB JUMLAH GERAKAN</th>
                    <th style="text-align: right;"><b>Rp.</b></th>
                    <th style="text-align: right;"><b>{{ number_format($grand_total_g) }}</b></th>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row invoice-info" style="border-top: 2px solid;">
        <div class="col-xs-12 table-responsive">
            <table class="table">
                @if($invoice->dg_surcharge)
                <tr>
                    <td style="text-align: right;">Surcharge {{$invoice->surcharge.'%'}} (AIRIN)</td>
                    <td style="width: 50px;text-align: right;">= Rp.</td>
                    <td style="width: 100px;text-align: right;">{{ number_format($invoice->dg_surcharge) }}</td>
                </tr>
                @endif
                <tr>
                    <td style="text-align: right;">Administrasi</td>
                    <td style="width: 50px;text-align: right;">= Rp.</td>
                    <td style="width: 100px;text-align: right;">{{ number_format($invoice->administrasi) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">Jumlah Sebelum PPN</td>
                    <td style="text-align: right;">= Rp.</td>
                    <td  style="text-align: right;">{{ number_format($invoice->total_non_ppn) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">PPN 10%</td>
                    <td style="text-align: right;">= Rp.</td>
                    <td  style="text-align: right;">{{ number_format($invoice->ppn) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;">Materai</td>
                    <td style="text-align: right;">= Rp.</td>
                    <td  style="text-align: right;">{{ number_format($invoice->materai) }}</td>
                </tr>
                <tr>
                    <td style="text-align: right;"><b>Jumlah Dibayarkan</b></td>
                    <td style="text-align: right;"><b>= Rp.</b></td>
                    <td  style="text-align: right;"><b>{{ number_format($invoice->total) }}</b></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row invoice-info">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped">
                <tr>
                    <td style="width: 80px;"><i>TERBILANG</i></td>
                    <td style="width: 30px;">&nbsp;&nbsp;=&nbsp;&nbsp;</td>
                    <td><i>{{ $terbilang }}</i></td>
                </tr>
                <tr>
                    <td><b>TPS</b></td>
                    <td><b>&nbsp;&nbsp;=&nbsp;&nbsp;</b></td>
                    <td><b>PT. AIRIN ({{$invoice->kd_gudang}})</b></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row invoice-info" style="border-top: 2px solid;">
        <div class="col-xs-12 table-responsive">
            <table class="table">
                <tr>
                    <td>Pengajuan Keberatan :</td>
                    <td style="text-align: center;">{{ date("l, d F Y") }}</td>
                </tr>
                <tr>
                    <td>
                        <p>
                            Jika Terdapat kekeliruan<br />	
                            Agar diajukan dalam batas waktu 4 X 24 Jam (4 Hari)<br />
                            Lewat batas waktu tersebut tidak dilayani<br />	
                            <b>16.49.41</b><br />	
                            <b>E-Mail Faktur pajak albarmau@gmail.com</b>
                        </p>
                    </td>
                    <td style="vertical-align: top;text-align: center;">PT. AIRIN</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <!--<td style="text-align: center;"><b>SIGIT MARET HARYADI</b><br />Manager TPS</td>-->
                    <td style="text-align: center;"><b>YANUAR ANDRES SUSILO</b><br />Plt Manager TPS</td>
                </tr>
            </table>
        </div>
    </div>
</div>
        
@stop