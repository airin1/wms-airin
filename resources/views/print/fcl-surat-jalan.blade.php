@extends('print')

@section('title')
    {{ 'Surat Jalan' }}
@stop

@section('content')
<style>
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
            font-weight: bold;
        }
        .print-btn {
            display: none;
        }
    }
</style>
<a href="#" class="print-btn" type="button" onclick="window.print();">PRINT</a>    
<div style="width: 700px;height: 1058px;border: 1px solid transparent;padding: 30px;">
    
    <div style="width: 100%;height: 100px;border: 1px solid transparent;">
        
        <div style="float: right;margin-top: 100px;">
            <table>
                <tr>
                    <td align="right">SPPB</td>
                    <td align="left" style="width: 80px;">{{$container->NO_SPPB}}</td>
                    <td align="right">{{date('d-M-Y', strtotime($container->TGL_SPPB))}}</td>
                </tr>
                <tr>
                    <td align="right">PIB</td>
                    <td align="left">{{$container->NO_SPJM}}</td>
                    <td align="right">{{($container->TGL_SPJM != NULL) ? date('d-M-Y', strtotime($container->TGL_SPJM)) : ''}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">POS</td>
                    <td align="center">{{$container->NO_POS_BC11}}</td>
                </tr>
            </table>
        </div>
    </div>
    <br />
    <div style="width: 100%;height: 200px;border: 1px solid transparent;">
        <table width="100%">
            <tr>
                <td style="width: 60%;">
                    <table>
                        <tr>
                            <td style="width: 100px;"></td>
                            <td><b>{{$container->NOCONTAINER}}</b>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->SIZE.' FULL'}}&nbsp;</td>
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
                            <td>{{($container->KODE_GUDANG == 'ARN3') ? 'PT. AIRIN (BARAT)' : 'PT. AIRIN (UTARA)'}}&nbsp;</td>
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
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->NOPOL_OUT}}&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 40%;vertical-align: top;">
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
                            <td>{{date('d-M-y', strtotime($container->ETA.' +6 Day'))}}&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <br />
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
                    <td align="center">DWI JULIANTORO</td>
                    <td></td>
                    <td align="center">YANUAR ANDRES SUSILO</td>
                </tr>
            </table>
        </div>
    </div>
    
</div>
    
        
@stop