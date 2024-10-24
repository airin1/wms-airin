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

<div style="width: 700px;height: 850px;border: 1px solid transparent;padding: 30px;">
    <div style="float:left;font-size: 10px;">PRINT TIME {{ date('d/m/Y H:i')}}</div> 
     <!--<div style="width: 100%;height: 80px;border: 1px solid transparent;display: relative;">-->

    <div style="margin-left: -5px;width: 100%;height: 200px;border: 1px solid transparent;">
      <div style="margin-left:1; width: 100%;height: 100px;border: 1px solid transparent;">       
	   <table width="100%">
            <tr>
                <td style="width: 75%;">
                    <table>
                        <tr>
                            <td style="width: 100px;"></td>
                            <td><b>{{$container->NOCONTAINER}}</b>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->SIZE.' DRY / MTY'}}&nbsp;</td>
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
                            <td>{{$container->NAMACONSOLIDATOR}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->TUJUAN_MTY}}</td>
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
                            <td>{{$container->NOMBL}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{$container->NOMBL}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td>TANGGAL MASUK</td>
                            <td>{{date('d-M-y', strtotime($container->TGLMASUK))}}&nbsp;</td>
                        </tr>
                        <tr>
                            <td>PUKUL</td>
                            <td>{{date('H:i', strtotime($container->JAMMASUK))}}</td>
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
                    <td colspan="3" style="height: 190px;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" style="display: block;">REZA FACHREVY</td>
                    <td></td>
                    <td align="center">KELIK PRAWOTO</td>
                </tr>
            </table>
        </div>
    </div>
    
</div>
 <div style="display:block; page-break-before:always;"></div>

   
        
@stop