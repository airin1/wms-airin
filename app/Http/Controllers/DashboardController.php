<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Container as DBContainer;
use App\Models\Containercy as DBContainercy;
use App\Models\Manifest as DBManifest;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();   
    }
    
    public function index()
    {
        $data['page_title'] = "Welcome to Dashboard";
        $data['page_description'] = "This is Admin Page WIS PT.AIRIN!";
        
        $day = 23;
        $month = 05;
        $year = date('Y');
        
        // FCL DASHBOARD       
        $jict = \App\Models\Containercy::where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGL_PLP) = '.date('m'))->whereRaw('YEAR(TGL_PLP) = '.date('Y'))->count();
        $koja = \App\Models\Containercy::where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGL_PLP) = '.date('m'))->whereRaw('YEAR(TGL_PLP) = '.date('Y'))->count();
        $mal = \App\Models\Containercy::where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGL_PLP) = '.date('m'))->whereRaw('YEAR(TGL_PLP) = '.date('Y'))->count();
        $nct1 = \App\Models\Containercy::where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGL_PLP) = '.date('m'))->whereRaw('YEAR(TGL_PLP) = '.date('Y'))->count();
        $pldc = \App\Models\Containercy::where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGL_PLP) = '.date('m'))->whereRaw('YEAR(TGL_PLP) = '.date('Y'))->count();
        
        $jictg = \App\Models\Containercy::where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGLMASUK) = '.date('m'))->whereRaw('YEAR(TGLMASUK) = '.date('Y'))->count();
        $kojag = \App\Models\Containercy::where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGLMASUK) = '.date('m'))->whereRaw('YEAR(TGLMASUK) = '.date('Y'))->count();
        $malg = \App\Models\Containercy::where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGLMASUK) = '.date('m'))->whereRaw('YEAR(TGLMASUK) = '.date('Y'))->count();
        $nct1g = \App\Models\Containercy::where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGLMASUK) = '.date('m'))->whereRaw('YEAR(TGLMASUK) = '.date('Y'))->count();
        $pldcg = \App\Models\Containercy::where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGLMASUK) = '.date('m'))->whereRaw('YEAR(TGLMASUK) = '.date('Y'))->count();
        $data['countbytps'] = array('JICT' => array($jict, $jictg), 'KOJA' => array($koja, $kojag), 'MAL0' => array($mal, $malg), 'NCT1' => array($nct1, $nct1g), 'PLDC' => array($pldc, $pldcg));
        
        // BY DOKUMEN
        $bc20 = \App\Models\Containercy::where('KD_DOK_INOUT', 1)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
        $bc23 = \App\Models\Containercy::where('KD_DOK_INOUT', 2)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
        $bc12 = \App\Models\Containercy::where('KD_DOK_INOUT', 4)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
        $bc15 = \App\Models\Containercy::where('KD_DOK_INOUT', 9)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
        $bc11 = \App\Models\Containercy::where('KD_DOK_INOUT', 20)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
        $bcf26 = \App\Models\Containercy::where('KD_DOK_INOUT', 5)->whereRaw('MONTH(TGLRELEASE) = '.date('m'))->whereRaw('YEAR(TGLRELEASE) = '.date('Y'))->count();
//        $data['countbydoc'] = array('BC 2.0' => $bc20, 'BC 2.3' => $bc23, 'BC 1.2' => $bc12, 'BC 1.5' => $bc15, 'BC 1.1' => $bc11, 'BCF 2.6' => $bcf26);
        $data['countbydoc'] = array('BC 2.0' => $bc20, 'BC 2.3' => $bc23, 'Lain-lain' => $bc12+$bc15+$bc11+$bcf26);
        
        $data['totcounttpsp'] = array_sum(array($jict,$koja,$mal,$nct1,$pldc));
        $data['totcounttpsg'] = array_sum(array($jictg,$kojag,$malg,$nct1g,$pldcg));
        
//        $data['countfclcont'] = \App\Models\Containercy::whereNotNull('TGLMASUK')->whereNull('TGLRELEASE')->count();
        
        $data['key_graph'] = json_encode(array('JICT', 'KOJA', 'MAL0', 'NCT1', 'PLDC'));
        $data['val_graph'] = json_encode(array($jict, $koja, $mal, $nct1, $pldc));
        
        
        // LCL DASHBOARD       
        $jictlcl = DBContainer::where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $kojalcl = DBContainer::where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $mallcl = DBContainer::where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $nct1lcl = DBContainer::where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $pldclcl = DBContainer::where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
              
        $jictlclg = DBContainer::where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $kojalclg = DBContainer::where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $mallclg = DBContainer::where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $nct1lclg = DBContainer::where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $pldclclg = DBContainer::where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        
        $data['countbytpslcl'] = array('JICT' => array($jictlcl, $jictlclg), 'KOJA' => array($kojalcl, $kojalclg), 'MAL0' => array($mallcl, $mallclg), 'NCT1' => array($nct1lcl, $nct1lclg), 'PLDC' => array($pldclcl, $pldclclg));

        $data['totcounttpsplcl'] = array_sum(array($jictlcl,$kojalcl,$mallcl,$nct1lcl,$pldclcl));
        $data['totcounttpsglcl'] = array_sum(array($jictlclg,$kojalclg,$mallclg,$nct1lclg,$pldclclg));
        
        // BY DOKUMEN
        $bc20lcl = DBManifest::where('KD_DOK_INOUT', 1)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $bc23lcl = DBManifest::where('KD_DOK_INOUT', 2)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $bc12lcl = DBManifest::where('KD_DOK_INOUT', 4)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $bc15lcl = DBManifest::where('KD_DOK_INOUT', 9)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $bc11lcl = DBManifest::where('KD_DOK_INOUT', 20)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $bcf26lcl = DBManifest::where('KD_DOK_INOUT', 5)->whereRaw('MONTH(tglrelease) = '.$month)->whereRaw('YEAR(tglrelease) = '.$year)->count();
        $data['countbydoclcl'] = array('BC 2.0' => $bc20lcl, 'BC 2.3' => $bc23lcl, 'Lain-lain' => $bc12lcl+$bc12lcl+$bc15lcl+$bc11lcl+$bcf26lcl);
        
//        $data['countlclmanifest'] = \App\Models\Manifest::whereNotNull('tglmasuk')->whereNotNull('tglstripping')->whereNull('tglrelease')->count();
        
//        $data['sor'] = \App\Models\SorYor::where('type', 'sor')->first();
        $data['sor'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'sor')
            ->first();
//        $data['yor'] = \App\Models\SorYor::where('type', 'yor')->first();
        $data['yor'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'yor')
            ->first();
        
        // Laporan YOR NPCT
        $data['yornpct'] = \App\Models\NpctYor::whereRaw('DAY(created_at) = '.$day)->whereRaw('MONTH(created_at) = '.$month)->whereRaw('YEAR(created_at) = '.$year)->get();
        
        return view('welcome')->with($data);
    }
}
