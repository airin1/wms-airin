@extends('print-with-noheader')

@section('title')
    {{ 'Laporan Harian LCL' }}
@stop

@section('content')
<style>
    body {
        color: #000;
        background: #fff;
        font-size: 11px;
    }
    table, th, tr, td {
        font-size: 10px;
    }
    @media print {
        body {
            color: #000;
            background: #fff;
            font-size: 11px;
        }
        table, th, tr, td {
            font-size: 10px;
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
<?php 
    $nmgd = '';
    if($gd !== '%'){
        if($gd == 'ARN1'){
            $nmgd = ' (UTARA)';
        }else{
            $nmgd = ' (BARAT)';
        }
    }
?>
<a href="#" class="print-btn" type="button" onclick="window.print();">PRINT</a>
<div id="details" class="clearfix">
    <div id="lap-masuk" @if($type == 'out') style="display: none;" @endif>
        <div class="row invoice-info">
            <div style="text-align: center;">
                <h3 style="margin-bottom: 0;">LAPORAN PEMASUKAN CARGO GUDANG LCL IMPOR</h3>
                <h4 style="margin-bottom: 0;margin-top: 0;">GUDANG TPS PT. AIRIN{{$nmgd}}</h4>
                <p style="margin-top: 0;font-size: 14px;">Tanggal {{date('d F Y', strtotime($date))}}</p>
            </div>
        </div>

        <div class="row">
          <div class="col-xs-12 table-responsive">
              <table border="1" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr>
                        <th rowspan="2">NO.</th>
                        <th rowspan="2">EX<br />CONTAINER</th>
                        <th rowspan="2">EX-KAPAL</th>
                        <th colspan="2">TANGGAL</th> 
                        <th rowspan="2">CONSIGNEE</th>
                        <th colspan="4">PARTY</th>
                        <th rowspan="2">NO. B/L</th>
                        <th rowspan="2">TGL. B/L</th>
                        <th rowspan="2">TPS ASAL</th>
                        <th colspan="2">BC 1.1</th>
                        <th rowspan="2">NO. POS</th>
                    </tr>
                    <tr>
                        <th>TIBA</th>
                        <th>OB</th>
                        <th>JML</th>
                        <th>PACKING</th>
                        <th>KGS</th>
                        <th>M3</th>
                        <th>NO</th>
                        <th>TGL</th>
                    </tr>

                  </thead>
                  <tbody>
                      <?php $i = 1;?>
                      @foreach($in as $masuk)
                      <tr>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $i }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $masuk->NOCONTAINER }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $masuk->VESSEL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($masuk->ETA)) }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($masuk->tglmasuk)) }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $masuk->CONSIGNEE }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->QUANTITY }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->NAMAPACKING }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->WEIGHT }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->MEAS }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $masuk->NOHBL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($masuk->TGL_HBL)) }}</td>                      
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->KD_TPS_ASAL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->NO_BC11 }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($masuk->TGL_BC11)) }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $masuk->NO_POS_BC11 }}</td>
                      </tr>
                      <?php $i++;?>
                      @endforeach
                  </tbody>
              </table>
          </div>
            <div class="col-xs-4 table-responsive" style="max-width: 300px;">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <th style="border-top: none;border-bottom: none;">Jumlah B/L</th>
                            <td align="center" style="border-top: none;border-bottom: none;text-align: center;">{{ $bl_in[0]->Jumlah }}</td>
                        </tr>
                        <tr>
                            <th style="border-top: none;border-bottom: none;">Quantity</th>
                            <td align="center" style="border-top: none;border-bottom: none;text-align: center;">{{ $bl_in[0]->Quantity }}</td>
                        </tr>
                        <tr>
                            <th style="border-top: none;border-bottom: none;">Weight</th>
                            <td align="center" style="border-top: none;border-bottom: none;text-align: center;">{{ $bl_in[0]->Weight }}</td>
                        </tr>
                        <tr>
                            <th style="border-top: none;border-bottom: none;">Measurement</th>
                            <td align="center" style="border-top: none;border-bottom: none;text-align: center;">{{ $bl_in[0]->Meas }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div id="lap-keluar" @if($type == 'in') style="display: none;" @endif>
        <div class="row invoice-info">
            <div style="text-align: center;">
                <h3 style="margin-bottom: 0;">LAPORAN PENGELUARAN CARGO GUDANG LCL IMPOR</h3>
                <h4 style="margin-bottom: 0;margin-top: 0;">GUDANG TPS PT. AIRIN{{$nmgd}}</h4>
                <p style="margin-top: 0;font-size: 14px;">Tanggal {{date('d F Y', strtotime($date))}}</p>
            </div>
        </div>

        <div class="row">
          <div class="col-xs-12 table-responsive">
              <table border="1" cellspacing="0" cellpadding="0">
                  <thead>
                    <tr>
                        <th rowspan="2">NO.</th>
                        <th rowspan="2">EX<br />CONTAINER</th>
                        <th rowspan="2">EX-KAPAL</th>
                        <th colspan="2">TANGGAL</th> 
                        <th rowspan="2">CONSIGNEE</th>
                        <th colspan="4">PARTY</th>
                        <th rowspan="2">NO. B/L</th>
                        <th colspan="3">DOKUMEN</th>
                        <th rowspan="2">TPS ASAL</th>
                        <th colspan="2">BC 1.1</th>
                        <th rowspan="2">NO. POS</th>
                    </tr>
                    <tr>
                        <th>TIBA</th>
                        <th>OB</th>
                        <th>JML</th>
                        <th>PACKING</th>
                        <th>KGS</th>
                        <th>M3</th>
                        <th>KODE</th>
                        <th>NO</th>
                        <th>TGL</th>
                        <th>NO</th>
                        <th>TGL</th>
                    </tr>

                  </thead>
                  <tbody>
                      <?php $i = 1;?>
                      @foreach($out as $keluar)
                      <tr>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $i }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $keluar->NOCONTAINER }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $keluar->VESSEL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($keluar->ETA)) }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($keluar->tglmasuk)) }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $keluar->CONSIGNEE }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->QUANTITY }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->NAMAPACKING }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->WEIGHT }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->MEAS }}</td>
                          <td style="text-align: left;border-top: none;border-bottom: none;">{{ $keluar->NOHBL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->KODE_DOKUMEN }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->NO_SPPB }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($keluar->TGL_SPPB)) }}</td>                      
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->KD_TPS_ASAL }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->NO_BC11 }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ date('d-M-y',strtotime($keluar->TGL_BC11)) }}</td>
                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $keluar->NO_POS_BC11 }}</td>
                      </tr>
                      <?php $i++;?>
                      @endforeach
                  </tbody>
              </table>
          </div>

        </div>

        <div class="row">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <div class="col-xs-4 table-responsive">
                            <table border="1" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <thead>
                                        <tr>
                                            <th>Keterangan</th>
                                            <th>Jumlah</th>
                                            <th>Quantity</th>
                                            <th>Weight</th>
                                            <th>Measurement</th>
                                            <th>SOR %</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        <?php 
                                            $meas_count = $bl_awal[0]->Meas+$bl_in[0]->Meas-$bl_out[0]->Meas;
                                            $k_trisi = $meas_count*1000;     
                                            $tot_sor = ($k_trisi / ($sor->kapasitas_default*1000)) * 100;
                                        ?>
                                        <tr>
                                            <th>Stok Awal</th>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Jumlah }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Quantity }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Weight }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Meas }}</td>
                                            <td rowspan="4" style="text-align: center;vertical-align: middle;">{{ number_format($tot_sor,'2',',','.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Masuk</th>
                                            <td style="text-align: center;">{{ $bl_in[0]->Jumlah }}</td>
                                            <td style="text-align: center;">{{ $bl_in[0]->Quantity }}</td>
                                            <td style="text-align: center;">{{ $bl_in[0]->Weight }}</td>
                                            <td style="text-align: center;">{{ $bl_in[0]->Meas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Keluar</th>
                                            <td style="text-align: center;">{{ $bl_out[0]->Jumlah }}</td>
                                            <td style="text-align: center;">{{ $bl_out[0]->Quantity }}</td>
                                            <td style="text-align: center;">{{ $bl_out[0]->Weight }}</td>
                                            <td style="text-align: center;">{{ $bl_out[0]->Meas }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok Akhir</th>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Jumlah+$bl_in[0]->Jumlah-$bl_out[0]->Jumlah }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Quantity+$bl_in[0]->Quantity-$bl_out[0]->Quantity }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Weight+$bl_in[0]->Weight-$bl_out[0]->Weight }}</td>
                                            <td style="text-align: center;">{{ $bl_awal[0]->Meas+$bl_in[0]->Meas-$bl_out[0]->Meas }}</td>
                                        </tr>
                                    </tbody>
                                </tbody>
                            </table>
                        </div>
                    </td>
                    <td>
                        <div class="col-xs-4 table-responsive">
                            <p>RINCIAN JENIS DOKUMEN PENGELUARAN</p>
                            <table border="1" cellspacing="0" cellpadding="0">
                                <thead>
                                    <tr>
                                      <th>No.</th>
                                      <th>Jenis Dokumen</th>
                                      <th>Jumlah</th>
                                    </tr>
                                      <?php $sumdoc = 0;$i = 1;?>
                                      @foreach($countbydoc as $key=>$value)
                                      <tr>
                                          <td style="text-align: center;border-top: none;border-bottom: none;">{{$i}}</td>
                                          <td style="border-top: none;border-bottom: none;">{{ $key }}</td>
                                          <td style="text-align: center;border-top: none;border-bottom: none;">{{ $value }}</td>
                                      </tr>
                                      <?php $sumdoc += $value;$i++;?>
                                      @endforeach
                                      <tr>
                                          <th colspan="2">Jumlah Total</th>
                                          <th align="center" style="text-align: center;">{{$sumdoc}}</th>
                                      </tr>
                                </thead>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="row">
        <div class="table-responsive">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td style="text-align: center;">Mengetahui,</td>
                    <td style="text-align: center;">Jakarta, {{ date('d F Y', strtotime($date)) }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align: center;"><b>YANUAR ANDRES SUSILO</b><br />Manager TPS</td>
                    <td style="text-align: center;"><b>RINI ELVIRA</b><br />Staf Adm. Lapangan TPS</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@stop