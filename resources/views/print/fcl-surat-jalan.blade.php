@extends('print')

@section('title')
    {{ 'Surat Jalan' }}
@stop

@section('content')
<style>
    body {
        font-family: Tahoma, Geneva, sans-serif;
    }
    table{
        font-size: 14px;
    }
    @media print {
        body {
            color: #000;
            background: #fff;
        }
        @page {
            color: #000;
            background: #fff;
            font-weight: 800;
        }
        .print-btn {
            display: none;
        }
    }
</style>
<a href="#" class="print-btn" type="button" onclick="window.print();">PRINT</a> 
@foreach($container1 as $container)
   
<div style="width: 700px;height: 850px;border: 1px solid transparent;padding: 30px;">
    <div style="float:left;font-size: 10px;">PRINT TIME {{ date('d/m/Y H:i')}}</div>
    <!--<div style="width: 100%;height: 80px;border: 1px solid transparent;display: relative;">-->
        
        <div style="float: right;margin-top: 90px;margin-bottom: 20px;">
            <table>
                <tr>
                    <td align="right">{{$container->KODE_DOKUMEN}}</td>
                    <td align="left" style="width: 80px;">{{$container->NO_SPPB}}</td>
                    <td align="right">{{date('d-M-Y', strtotime($container->TGL_SPPB))}}</td>
                </tr>
                <tr>
                    <td align="right">PIB</td>
                    <td align="left">{{$container->NO_DAFTAR_PABEAN}}</td>
                    <td align="right">{{($container->TGL_DAFTAR_PABEAN != '0000-00-00') ? date('d-M-Y', strtotime($container->TGL_DAFTAR_PABEAN)) : ''}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">POS</td>
                    <td align="center">{{$container->NO_POS_BC11}}</td>
                </tr>
            </table>
        </div>
    <!--</div>-->
    <br />
    <div style="width: 100%;height: 200px;border: 1px solid transparent;">
        <table width="100%">
            <tr>
                <td style="width: 65%;">
                    <table>
                        <tr>
                            <td style="width: 100px;"></td>
                            <td><b>{{$container->NOCONTAINER}}</b>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->SIZE.' FULL / "'.$container->jenis_container}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->VESSEL.' V.'.$container->VOY}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->SHIPPINGLINE}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{($container->KODE_GUDANG == 'ARN3') ? 'PT. AIRIN (BARAT)' : 'PT. AIRIN (UTARA)'}}&nbsp;{{$container->location_name}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->CONSIGNEE}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->bcf_consignee}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->NOPOL_OUT}}&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 35%;vertical-align: top;">
                    <table>
                        <tr>
                            <td style="width: 50px;"></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{date('d-M-y', strtotime($container->ETA))}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->NO_BL_AWB}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->NO_BL_AWB}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{date('d-M-y', strtotime($container->ETA))}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{date('d-M-y', strtotime($pay_date))}}&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <div style="width: 100%;height: 100px;border: 1px solid transparent;">
            <table width="100%">
                <tr>
                    <td style="width: 30%;"></td>
                    <td style="width: 30%;"></td>
                    <td style="width: 30%;" align="center"></td>
                </tr>
                <tr>
                    <td colspan="3" style="height: 70px;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" style="display: block;">{{($container->KODE_GUDANG == 'ARN3') ? 'INDRA' : 'WATMASDEL'}}</td>
                    <td></td>
                    <td align="center">TONY NOVRIADI BUDIHARJO</td>
                </tr>
            </table>
        </div>
    </div>
    
</div>
 <div style="display:block; page-break-before:always;"></div>

@endforeach   
        
@stop