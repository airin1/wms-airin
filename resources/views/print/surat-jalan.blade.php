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
@foreach($container as $container1)
   
<div style="width: 700px;height: 850px;border: 1px solid transparent;padding: 30px;">
    <div style="float:left;font-size: 10px;">PRINT TIME {{ date('d/m/Y H:i')}}</div> 
     <!--<div style="width: 100%;height: 80px;border: 1px solid transparent;display: relative;">-->
        
        <div style="float: right;margin-top: 90px;margin-bottom: 20px;">
            <table>
                <tr>
                    <td align="right">{{$container1->KODE_DOKUMEN}}</td>
                    <td align="left" style="width: 80px;">{{$container1->NO_SPPB}}</td>
                    <td align="right">{{date('d-M-Y', strtotime($container1->TGL_SPPB))}}</td>
                </tr>
                <tr>
                    <td align="right">PIB</td>
                    <td align="left">{{$container1->NO_DAFTAR_PABEAN}}</td>
                    <td align="right">{{($container1->TGL_DAFTAR_PABEAN != '0000-00-00') ? date('d-M-Y', strtotime($container1->TGL_DAFTAR_PABEAN)) : ''}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td align="right">POS</td>
                    <td align="center">{{$container1->NO_POS_BC11}}</td>
                </tr>
            </table>
        </div>
    <!--</div>-->
    <br />
    <div style="margin-left: -5px;width: 100%;height: 200px;border: 1px solid transparent;">
      <div style="margin-left:1; width: 100%;height: 100px;border: 1px solid transparent;">       
	   <table width="100%">
            <tr>
                <td style="width: 65%;">
                    <table>
                        <tr>
                            <td style="width: 100px;"></td>
                            <td><b>{{$container1->NOCONTAINER}}</b>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->SIZE.' FULL / "'.$container1->jenis_container}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->VESSEL.' V.'.$container1->VOY}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->SHIPPINGLINE}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{($container1->KODE_GUDANG == 'ARN3') ? 'PT. AIRIN (BARAT)' : 'PT. AIRIN (UTARA)'}}&nbsp;{{$container1->location_name}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->CONSIGNEE}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->bcf_consignee}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->NOPOL_OUT}}&nbsp;</td>
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
                            <td>{{date('d-M-y', strtotime($container1->ETA))}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->NO_BL_AWB}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container1->NO_BL_AWB}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{date('d-M-y', strtotime($container1->ETA))}}&nbsp;</td>
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
		</div>
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
                    <td align="left" style="display: block;">{{($container1->KODE_GUDANG == 'ARN3') ? 'INDRA' : 'WATMASDEL'}}</td>
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