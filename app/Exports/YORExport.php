<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Container as DBContainer;
use App\Models\Containercy as DBContainercy;
use App\Models\Manifest as DBManifest;



class YORExport implements FromView
{
    public function view(): View
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