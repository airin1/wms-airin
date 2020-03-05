@extends('print-with-noheader')

@section('title')
    
@stop

@section('content')

<div class="row">
    <div class="col-xs-8 table-responsive">
        <table class="table" style="font-size: 14px;">
            <tbody>
                <tr>
                    <td style="width: 150px;">CAR</td>
                    <td> : </td>
                    <td>{{ $sppb->CAR }}</td>
                </tr>
                <tr>
                    <td>No. SPPB</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_SPPB }}</td>
                </tr>
                <tr>
                    <td>Tgl. SPPB</td>
                    <td> : </td>
                    <td>{{ $sppb->TGL_SPPB }}</td>
                </tr>
                <tr>
                    <td>No. SPK</td>
                    <td> : </td>
                    <td>{{ $sppb->NOJOBORDER }}</td>
                </tr>
                <tr>
                    <td>Kode KPBC</td>
                    <td> : </td>
                    <td>{{ $sppb->KD_KPBC }}</td>
                </tr>
                <tr>
                    <td>No. PIB</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_PIB }}</td>
                </tr>
                <tr>
                    <td>Tgl. PIB</td>
                    <td> : </td>
                    <td>{{ $sppb->TGL_PIB }}</td>
                </tr>
                <tr>
                    <td>Nama Importir</td>
                    <td> : </td>
                    <td>{{ $sppb->NAMA_IMP }}</td>
                </tr>
                <tr>
                    <td>NPWP Importir</td>
                    <td> : </td>
                    <td>{{ $sppb->NPWP_IMP }}</td>
                </tr>
                <tr>
                    <td>Alamat Importir</td>
                    <td> : </td>
                    <td>{{ $sppb->ALAMAT_IMP }}</td>
                </tr>
                <tr>
                    <td>Nama PPJK</td>
                    <td> : </td>
                    <td>{{ $sppb->NAMA_PPJK }}</td>
                </tr>
                <tr>
                    <td>NPWP PPJK</td>
                    <td> : </td>
                    <td>{{ $sppb->NPWP_PPJK }}</td>
                </tr>
                <tr>
                    <td>Alamat PPJK</td>
                    <td> : </td>
                    <td>{{ $sppb->ALAMAT_PPJK }}</td>
                </tr>   
                
                <tr>
                    <td>Nama Angkut</td>
                    <td> : </td>
                    <td>{{ $sppb->NM_ANGKUT }}</td>
                </tr>
                <tr>
                    <td>No. VOY Flight</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_VOY_FLIGHT }}</td>
                </tr>
                <tr>
                    <td>Bruto</td>
                    <td> : </td>
                    <td>{{ $sppb->BRUTO }}</td>
                </tr>
                <tr>
                    <td>Netto</td>
                    <td> : </td>
                    <td>{{ $sppb->NETTO }}</td>
                </tr>
                <tr>
                    <td>Gudang</td>
                    <td> : </td>
                    <td>{{ $sppb->GUDANG }}</td>
                </tr>
                <tr>
                    <td>Status Jalur</td>
                    <td> : </td>
                    <td>{{ $sppb->STATUS_JALUR }}</td>
                </tr>
                <tr>
                    <td>Jumlah Kontainer</td>
                    <td> : </td>
                    <td>{{ $sppb->JML_CONT }}</td>
                </tr>
                <tr>
                    <td>No. BC11</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_BC11 }}</td>
                </tr>
                <tr>
                    <td>Tgl. BC11</td>
                    <td> : </td>
                    <td>{{ $sppb->TGL_BC11 }}</td>
                </tr>
                <tr>
                    <td>No. POS BC11</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_POS_BC11 }}</td>
                </tr>
                <tr>
                    <td>No. BL AWB</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_BL_AWB }}</td>
                </tr>
                <tr>
                    <td>Tgl. BL AWB</td>
                    <td> : </td>
                    <td>{{ $sppb->TGL_BL_AWB }}</td>
                </tr>
                <tr>
                    <td>No. MBL AWB</td>
                    <td> : </td>
                    <td>{{ $sppb->NO_MASTER_BL_AWB }}</td>
                </tr>
                <tr>
                    <td>Tgl. MBL AWB</td>
                    <td> : </td>
                    <td>{{ $sppb->TGL_MASTER_BL_AWB }}</td>
                </tr>
            </tbody>
        </table>
        <br />
        <p>Jakarta, {{date('d F Y')}}</p>
        <br /><br /><br />
        <p>{{ \Auth::getUser()->name }}</p>
    </div>
</div>
    
        
@stop