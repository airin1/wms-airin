@extends('print')

@section('title')
    {{ 'Delivery Surat Jalan' }}
@stop

@section('content')
<style>
    body {
        font-size: 14px;
        color: #000;
        background: #FFF;
    }
    td {
        vertical-align: top;
    }
    @media print {
        body {
            background: #FFF;
            color: #000;
        }
        @page {
            size: auto;   /* auto is the initial value */
/*            margin-top: 114px;
            margin-bottom: 90px;
            margin-left: 38px;
            margin-right: 75px;*/
            font-weight: bold;
            background: #FFF;
            color: #000;
        }
        .print-btn {
            display: none;
        }
    }
</style>
<a href="#" class="print-btn" type="button" onclick="window.print();">PRINT</a>
<div id="details" class="clearfix" style="width: 605px;height: 794px;">
        <?php 
            $array_bulan = array("I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
            $romawi_bulan = $array_bulan[date('n')-1];
        ?>
        <div style="margin-left: 33%;">{{$romawi_bulan.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date('Y')}}<br /><br /><br /></div>
        <table border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 0;width:100%">
            <tr>
                <td width='56%'>
                    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 13px;margin-bottom: 0;">
                        <tr>
                            <td style="color: transparent; width: 130px;">Kepada Yth.</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <!--<td>{{ $manifest->NAMACONSOLIDATOR }}</td>-->
                            <td style="color: transparent;">PT. AIRIN</td>
                        </tr>
                        <tr>
                            <td style="color: transparent;">Ex. Kapal/Voy</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="padding-bottom: 10px;">{{ $manifest->VESSEL.' V.'.$manifest->VOY }}</td>
                        </tr>
                        <tr>
                            <td style="color: transparent;">Tanggal Tiba </td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="padding-bottom: 10px;">{{ date("d-m-Y", strtotime($manifest->ETA)) }}</td>
                        </tr>
                        
                        <tr>
                            <td style="color: transparent;">Truk No. Pol</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="padding-bottom: 10px;">{{ $manifest->NOPOL }}</td>
                        </tr>
                        <tr>
                            <td style="color: transparent;">No. Container</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="padding-bottom: 10px;">{{ $manifest->NOCONTAINER.' / '.$manifest->SIZE }}</td>
                        </tr>
<!--                        <tr>
                            <td style="color: transparent;">No. DO</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td></td>
                        </tr>-->
                        <tr>
                            <td style="color: transparent;">No. BL</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="padding-bottom: 10px;">{{ $manifest->NOHBL }}</td>
                        </tr>
                        <tr>
                            <td style="color: transparent;">Party</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td>{{ $manifest->QUANTITY }}/{{ $manifest->NAMAPACKING }}</td>
                        </tr>

                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table border="0" cellspacing="0" cellpadding="0" style="font-size: 13px;margin-bottom: 0;">
                        <tr>
                            <td style="color: transparent;">No. Bea Cukai</td>
                            <td class="padding-10 text-center" style="color: transparent;">:</td>
                            <td style="color: transparent;">{{ $manifest->NO_SPPB }}</td>
                        </tr>
<!--                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>-->
                        <tr>
                            <td colspan="3">{{ $manifest->CONSIGNEE }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <br /><br /><br /><br />
        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 12px;">
            <thead>
                <tr>
                    <th rowspan="3" style="color: transparent;">NO</th>
                    <th rowspan="3" style="color: transparent;">MERK</th>
                    <th rowspan="3" style="color: transparent;">JENIS BARANG</th>
                    <th rowspan="3" style="color: transparent;">JUMLAH BARANG</th>
                    <th rowspan="3" style="color: transparent;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width='20%' style="text-align: left;color: transparent;">{{ $manifest->MARKING }}</td>
                    <td width='20%' style="text-align: left;">{{ str_limit($manifest->DESCOFGOODS, 150) }}</td>
                    <td width='15%' style="text-align: center;">{{ $manifest->QUANTITY }}/{{ $manifest->NAMAPACKING }}</td>
                    <td width='15%' style="text-align: center;">{{ $manifest->WEIGHT.' KGS' }}<br />{{ $manifest->MEAS.' CBM' }}</td>
                    <td width='30%'>&nbsp;</td>    
                </tr>
            </tbody>
        </table>
        
        <!--<div style="position: absolute; bottom: 50px;right: 20px;">{{ date('d F Y') }}</div>-->
        
<!--        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td colspan="50"></td>
            </tr>
        </table>
        
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td style="border: 1px solid;">&nbsp;&nbsp;</td>
                <td>Barang dalam keadaan baik, lengkap dan sesuai DO.</td>
            </tr>
            <tr><td style="border-bottom: 1px solid;"></td><td></td></tr>
            <tr>
                <td style="border: 1px solid;">&nbsp;&nbsp;</td>
                <td>Barang dalam keadaan rusak/cacat/tidak lengkap (Lampiran berita acara)</td>
            </tr>
        </table>
        
-->        
<!--        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>Tanjung Priok, {{ date('d-m-Y H:i:s') }}</td>
            </tr>
        </table>-->
        <!--<div style="page-break-after: always;"></div>-->
<!--        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>Penerima</td>
                <td>Sopir Truck</td>
                <td>Petugas APW</td>
                <td class="text-center" style="border: 1px solid;">Custodian</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td height="70" style="font-size: 70px;line-height: 0;border: 1px solid;"></td>
            </tr>
            <tr>
                <td>(..................)</td>
                <td>(..................)</td>
                <td>(..................)</td>
                <td>&nbsp;</td>
            </tr>
        </table>-->
    </div>
        
@stop