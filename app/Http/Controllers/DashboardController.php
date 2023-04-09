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
        
        //$day = 23;
        //$month = 05;
        $day = date('d');
		$month = date('m');
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
			
	    $data['sorarn1'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'sor')->where('GUDANG', 'ARN1')
            ->first();
		 
		$data['sorarn3'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'sor')->where('GUDANG', 'ARN3')
            ->first();	
			
		$data['yorarn1'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'yor')->where('GUDANG', 'ARN1')
            ->first();
				
		  $data['yorarn3'] = \App\Models\SorYor::select(
            \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
            \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
            \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
            \DB::raw('SUM(total) as total'))
            ->where('type', 'yor')->where('GUDANG', 'ARN3')
            ->first();	
        
        // Laporan YOR NPCT
        $data['yornpct'] = \App\Models\NpctYor::whereRaw('DAY(created_at) = '.$day)->whereRaw('MONTH(created_at) = '.$month)->whereRaw('YEAR(created_at) = '.$year)->get();
        
		
		
		// FCL YOR ARN1    AIRIN UTARA
        
		$drykaparn1=1036;	
		$rfrkaparn1=150;		
		$dgkaparn1=75;	
        $dry20arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', '=','DRY')->count();
        $dry40arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', '=','DRY')->count();
        $rfr20arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $rfr40arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $dg20arn1  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','CLASS%%')->count();
		$dg40arn1  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','CLASS%%')->count();

		$dryarn1=($dry20arn1 +(2*$dry40arn1));
		$rfrarn1=($rfr20arn1 +(2*$rfr40arn1));
		$dgarn1=($dg20arn1 +(2*$dg40arn1));
		$drykapsisaarn1 = $drykaparn1 -$dryarn1;
		$rfrkapsisaarn1 = $rfrkaparn1 -$rfrarn1;
		$dgkapsisaarn1 = $dgarn1;
		$dryyorarn1 =($dryarn1/$drykaparn1)*100;
		$rfryorarn1 =($rfrarn1/$rfrkaparn1)*100;
		$dgyorarn1 =($dgarn1/$dgkaparn1)*100;
		$data['yarn1'] = array(
							'drykaparn1' 	=> $drykaparn1, 
							'rfrkaparn1' 	=> $rfrkaparn1,
							'dgkaparn1' 	=> $dgkaparn1,
							'dryarn1' 		=> $dryarn1,
							'rfrarn1' 		=> $rfrarn1,
							'dgarn1' 		=> $dgarn1,
							'drykapsisaarn1'=> $drykapsisaarn1,
							'rfrkapsisaarn1'=> $rfrkapsisaarn1,
							'dgkapsisaarn1' => $dgkapsisaarn1,
							'dryyorarn1' 	=> $dryyorarn1,
							'rfryorarn1' 	=> $rfryorarn1,
							'dgyorarn1' 	=> $dgyorarn1
						);

		 // FCL YOR ARN3    AIRIN BARAT
        $drykaparn3=1179;	
		$rfrkaparn3=50;		
		$dgkaparn3=150;	
        $dry20arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', '=','DRY')->count();
        $dry40arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', '=','DRY')->count();
        $rfr20arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $rfr40arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $dg20arn3  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','CLASS%%')->count();
		$dg40arn3  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','CLASS%%')->count();

		$dryarn3=($dry20arn3 +(2*$dry40arn3));
		$rfrarn3=($rfr20arn3 +(2*$rfr40arn3));
		$dgarn3=($dg20arn3 +(2*$dg40arn3));
		$drykapsisaarn3 = $drykaparn3 -$dryarn3;
		$rfrkapsisaarn3 = $rfrkaparn3 -$rfrarn3;
		$dgkapsisaarn3 = $dgarn3;
		$dryyorarn3 =($dryarn3/$drykaparn3)*100;
		$rfryorarn3 =($rfrarn3/$rfrkaparn3)*100;
		$dgyorarn3 =($dgarn3/$dgkaparn3)*100;
		$data['yarn3'] = array(
							'drykaparn3' 	=> $drykaparn3, 
							'rfrkaparn3' 	=> $rfrkaparn3,
							'dgkaparn3' 	=> $dgkaparn3,
							'dryarn3' 		=> $dryarn3,
							'rfrarn3' 		=> $rfrarn3,
							'dgarn3' 		=> $dgarn3,
							'drykapsisaarn3'=> $drykapsisaarn3,
							'rfrkapsisaarn3'=> $rfrkapsisaarn3,
							'dgkapsisaarn3' => $dgkapsisaarn3,
							'dryyorarn3' 	=> $dryyorarn3,
							'rfryorarn3' 	=> $rfryorarn3,
							'dgyorarn3' 	=> $dgyorarn3
							);
		
		
		
		
		
		
		
        return view('welcome')->with($data);
		
    }
	public function export_excel()
	{
	  
	// FCL YOR ARN1    AIRIN UTARA
        
		$drykaparn1=1036;	
		$rfrkaparn1=150;		
		$dgkaparn1=75;	
        $dry20arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', '=','DRY')->count();
        $dry40arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', '=','DRY')->count();
        $rfr20arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $rfr40arn1 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $dg20arn1  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','CLASS%%')->count();
		$dg40arn1  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN1')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','CLASS%%')->count();

		$dryarn1=($dry20arn1 +(2*$dry40arn1));
		$rfrarn1=($rfr20arn1 +(2*$rfr40arn1));
		$dgarn1=($dg20arn1 +(2*$dg40arn1));
		$drykapsisaarn1 = $drykaparn1 -$dryarn1;
		$rfrkapsisaarn1 = $rfrkaparn1 -$rfrarn1;
		$dgkapsisaarn1 = $dgarn1;
		$dryyorarn1 =($dryarn1/$drykaparn1)*100;
		$rfryorarn1 =($rfrarn1/$rfrkaparn1)*100;
		$dgyorarn1 =($dgarn1/$dgkaparn1)*100;
		$data['yarn1'] = array(
							'drykaparn1' 	=> $drykaparn1, 
							'rfrkaparn1' 	=> $rfrkaparn1,
							'dgkaparn1' 	=> $dgkaparn1,
							'dryarn1' 		=> $dryarn1,
							'rfrarn1' 		=> $rfrarn1,
							'dgarn1' 		=> $dgarn1,
							'drykapsisaarn1'=> $drykapsisaarn1,
							'rfrkapsisaarn1'=> $rfrkapsisaarn1,
							'dgkapsisaarn1' => $dgkapsisaarn1,
							'dryyorarn1' 	=> $dryyorarn1,
							'rfryorarn1' 	=> $rfryorarn1,
							'dgyorarn1' 	=> $dgyorarn1
						);

		 // FCL YOR ARN3    AIRIN BARAT
        $drykaparn3=1179;	
		$rfrkaparn3=50;		
		$dgkaparn3=150;	
        $dry20arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', '=','DRY')->count();
        $dry40arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', '=','DRY')->count();
        $rfr20arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $rfr40arn3 = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','REEFER%%')->count();
        $dg20arn3  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE', '=','20')->where('jenis_container', 'LIKE','CLASS%%')->count();
		$dg40arn3  = \App\Models\Containercy::whereNull('TGLRELEASE')->whereNotNull('TGLMASUK')->where('GUDANG_TUJUAN','=','ARN3')->where('SIZE','>=','40')->where('jenis_container', 'LIKE','CLASS%%')->count();

		$dryarn3=($dry20arn3 +(2*$dry40arn3));
		$rfrarn3=($rfr20arn3 +(2*$rfr40arn3));
		$dgarn3=($dg20arn3 +(2*$dg40arn3));
		$drykapsisaarn3 = $drykaparn3 -$dryarn3;
		$rfrkapsisaarn3 = $rfrkaparn3 -$rfrarn3;
		$dgkapsisaarn3 = $dgarn3;
		$dryyorarn3 =($dryarn3/$drykaparn3)*100;
		$rfryorarn3 =($rfrarn3/$rfrkaparn3)*100;
		$dgyorarn3 =($dgarn3/$dgkaparn3)*100;
		$data['yarn3'] = array(
							'drykaparn3' 	=> $drykaparn3, 
							'rfrkaparn3' 	=> $rfrkaparn3,
							'dgkaparn3' 	=> $dgkaparn3,
							'dryarn3' 		=> $dryarn3,
							'rfrarn3' 		=> $rfrarn3,
							'dgarn3' 		=> $dgarn3,
							'drykapsisaarn3'=> $drykapsisaarn3,
							'rfrkapsisaarn3'=> $rfrkapsisaarn3,
							'dgkapsisaarn3' => $dgkapsisaarn3,
							'dryyorarn3' 	=> $dryyorarn3,
							'rfryorarn3' 	=> $rfryorarn3,
							'dgyorarn3' 	=> $dgyorarn3
							);


	  return view('yor')->with($data);

	}
	
}
