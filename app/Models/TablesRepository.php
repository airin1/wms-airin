<?php
namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
 
class TablesRepository extends EloquentRepositoryAbstract {
 
    public function __construct(Model $Model, $request = null)
    {
        $Columns = array('*');
        
        if($Model->getMorphClass() == 'App\Models\Consolidator'){
            
            $Model = \DB::table('tconsolidator');
//                    ->leftjoin('tconsolidator_tarif', 'tconsolidator.TCONSOLIDATOR_PK', '=', 'tconsolidator_tarif.TCONSOLIDATOR_FK');
            
        }elseif($Model->getMorphClass() == 'App\User'){
            
            $Model = \DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->join('roles', 'role_user.role_id', '=', 'roles.id');
            
            $Columns = array('users.*','roles.name as roles.name');
            
        }elseif($Model->getMorphClass() == 'App\Models\Container'){
            if(isset($request['jobid'])){
                
                $Model = \DB::table('tcontainer')
//                        ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ->where('TJOBORDER_FK', $request['jobid']);
                
            }elseif(isset($request['startdate']) || isset($request['enddate'])){
                
                $Model = \DB::table('tcontainer')
                        ->where('LOKASI_GUDANG', 'like', $request['gd'])
//                        ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ->where('TGLENTRY', '>=',date('Y-m-d 00:00:00',strtotime($request['startdate'])))
                        ->where('TGLENTRY', '<=',date('Y-m-d 23:59:59',strtotime($request['enddate'])));
                
            }elseif(isset($request['module'])){
                
                switch ($request['module']) {
                    case 'gatein':
                        $Model = \DB::table('tcontainer')
//                            ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('NO_BC11')
                            ->whereNotNull('TGL_BC11')
                            ->whereNotNull('NO_PLP')
                            ->whereNotNull('TGL_PLP');
                    break;
                    case 'stripping':
                        $Model = \DB::table('tcontainer')
//                            ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                    case 'buangmty':
                        $Model = \DB::table('tcontainer')
//                            ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('TGLSTRIPPING')
                            ->whereNotNull('JAMSTRIPPING');
                    break;
                    case 'release-invoice':
                        $Model = \DB::table('tcontainer')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                    case 'photo':
                        $Model = \DB::table('tcontainer')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                }
                
            }else{
                $Model = \DB::table('tcontainer')
                        ->where('LOKASI_GUDANG', 'like', $request['gd'])
//                        ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ;
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\ContainerExp'){
            if(isset($request['jobid'])){
                
                $Model = \DB::table('tcontainereks')
//                        ->leftjoin('tdepomty', 'tcontainer.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ->where('TJOBORDER_FK', $request['jobid']);
                
            }elseif(isset($request['startdate']) || isset($request['enddate'])){
                
                $Model = \DB::table('tcontainereks')
                        ->where('LOKASI_GUDANG', 'like', $request['gd'])
//                        ->leftjoin('tdepomty', 'tcontainereks.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ->where('TGLENTRY', '>=',date('Y-m-d 00:00:00',strtotime($request['startdate'])))
                        ->where('TGLENTRY', '<=',date('Y-m-d 23:59:59',strtotime($request['enddate'])));
                
            }elseif(isset($request['module'])){
                
                switch ($request['module']) {
                    case 'gatein':
                        $Model = \DB::table('tcontainereks')
//                            ->leftjoin('tdepomty', 'tcontainereks.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('NO_BC11')
                            ->whereNotNull('TGL_BC11')
                            ->whereNotNull('NO_PLP')
                            ->whereNotNull('TGL_PLP');
                    break;
                    case 'stuffing':
                        $Model = \DB::table('tcontainereks')
//                            ->leftjoin('tdepomty', 'tcontainereks.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                    case 'buangmty':
                        $Model = \DB::table('tcontainereks')
//                            ->leftjoin('tdepomty', 'tcontainereks.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                            ->whereNotNull('TGLSTRIPPING')
                            ->whereNotNull('JAMSTRIPPING');
                    break;
                    case 'release-invoice':
                        $Model = \DB::table('tcontainereks')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                    case 'photo':
                        $Model = \DB::table('tcontainereks')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                    break;
                }
                
            }else{
                $Model = \DB::table('tcontainereks')
                        ->where('LOKASI_GUDANG', 'like', $request['gd'])
//                        ->leftjoin('tdepomty', 'tcontainereks.TUJUAN_MTY', '=', 'tdepomty.TDEPOMTY_PK')
                        ;
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\Containercy'){
            
            if(isset($request['jobid'])){
                
                $Model = \DB::table('tcontainercy')
                        ->where('TJOBORDER_FK', $request['jobid']);
                
            }elseif(isset($request['module'])){
                
                switch ($request['module']) {
                    case 'status_behandle':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
//                            ->where('BEHANDLE', 'Y')
//                            ->whereNull('TGLBEHANDLE')
                            ->whereIn('status_behandle',array('Ready','Checking'))
//                            ->where('flag_bc','N')
//                            ->orWhere('alasan_segel', 'IKP / Temuan Lapangan')
                            ->orWhere(function($query)
                            {
                                $query->where("flag_bc","Y")
                                      ->where("alasan_segel","IKP / Temuan Lapangan");
                            })
                            ;
                    break;
                    case 'finish_behandle':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
                            ->whereNotNull('TGLBEHANDLE')
                            ->where('status_behandle','Finish');
                    break;
                    case 'behandle':
                        
                    break;
                    case 'fiatmuat':
//                        $Model = \DB::table('tcontainercy');
//                            ->select('tmanifest.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
//                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifest.TCONSIGNEE_FK')
//                            ->whereNotNull('NO_SPJM')
//                            ->whereNotNull('TGL_SPJM');
                    break;
                    case 'suratjalan':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('NO_SPPB')
                            ->whereNotNull('TGL_SPPB');
                    break;
                    case 'release':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK')
                            ;
                    break;
                    case 'release-invoice':
                        $Model = \DB::table('tcontainercy')
                            ->whereIn('KD_TPS_ASAL', array('NCT1','NPCT1','KOJA','MAL0','JICT','PLDC'))
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK')
//                            ->whereNotNull('TGLRELEASE')
//                            ->whereNotNull('JAMRELEASE')
                            ;
                    break;
                    case 'hold':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
                                ->where('status_bc','HOLD')
                                ->where($request['by'], '>=',$start_date)
                                ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
                                ->where('status_bc','HOLD');
                        }
                    break;
                    case 'segel':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
//                                ->whereNotNull('TGLMASUK')
                                ->whereNull('TGLRELEASE')
//                                ->orWhere('TGL_DISPATCHE','!=',NULL)
                                ->where(function($query)
                                {
                                    $query->whereNotNull("TGLMASUK")
                                          ->orWhere('TGL_DISPATCHE','!=',NULL);
                                })
                                ->where($request['by'], '>=',$start_date)
                                ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
//                                ->whereNotNull('TGLMASUK')
                                ->whereNull('TGLRELEASE')
//                                ->orWhere('TGL_DISPATCHE','!=',NULL)
                                ->where(function($query)
                                {
                                    $query->whereNotNull("TGLMASUK")
                                          ->orWhere('TGL_DISPATCHE','!=',NULL);
                                })
                                ;
                        }
                    break;
                    case 'segel_report':
                        $Model = \DB::table('tcontainercy')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
                            ->whereNotNull('no_unflag_bc')
                            ->whereNotNull('alasan_lepas_segel');
                    break;
                    case 'release_movement':
                        $Model = \DB::table('tcontainercy')
                            ->where('KD_TPS_ASAL', 'NCT1')
                            ->whereNotNull('TGLMASUK')
                            ->whereNotNull('JAMMASUK');
                            //->whereNotNull('TGLKELUAR_TPK')
                            //->whereNotNull('JAMKELUAR_TPK')
                            //->whereNotNull('TGLRELEASE')
                            //->whereNotNull('JAMRELEASE');
                    break;
                    case 'longstay':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
                                ->where('KODE_GUDANG', 'like', $request['gd'])
    //                            ->whereRaw('tmanifest.tglmasuk < DATE_SUB(now(), INTERVAL 1 MONTH)')
                                ->whereNotNull('TGLMASUK')
                                ->whereNull('TGLRELEASE')
//                                ->orWhere('tglrelease','0000-00-00')
                                ->where($request['by'], '>=',$start_date)
                                ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tcontainercy')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'))
                                ->where('KODE_GUDANG', 'like', $request['gd'])
    //                            ->whereRaw('tcontainercy.TGLMASUK < DATE_SUB(now(), INTERVAL 1 MONTH)')
                                ->whereNotNull('TGLMASUK')
                                ->whereNull('TGLRELEASE');
//                                ->orWhere('TGLRELEASE','0000-00-00');
                        }
                    break;
                    case 'gatein':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('NO_BC11')
                            ->whereNotNull('TGL_BC11')
                            ->whereNotNull('NO_PLP')
                            ->whereNotNull('TGL_PLP');
                    break;
					case 'release-log':
                        $Model = \DB::table('tcontainercy')
                            ->whereNotNull('release_bc_date')
                            ->whereNotNull('release_bc_uid')
                            ;
                    break;
                }
                
            }elseif(isset($request['report'])){
                if(isset($request['date'])){
                    if($request['type'] == 'in'){
                $Model = \DB::table('tcontainercy')
                            ->where('KODE_GUDANG', 'like', $request['gd'])
                            ->where('TGLMASUK', $request['date']);
                    }elseif($request['type'] == 'out'){
                        $Model = \DB::table('tcontainercy')
                            ->where('KODE_GUDANG', 'like', $request['gd'])
                            ->where('TGLRELEASE', $request['date']);
                    } 
                }else{
                    $Model = \DB::table('tcontainercy')
                        ->where('KODE_GUDANG', 'like', $request['gd'])    
                        ->select(\DB::raw('*, timestampdiff(DAY, now(), TGLMASUK) as timeSinceUpdate'));
                }
            }else{
                
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\Joborder'){
            
            if(isset($request['startdate']) || isset($request['enddate'])){
                
                $Model = \DB::table('tjoborder')->join('tcontainer', 'tjoborder.TJOBORDER_PK', '=', 'tcontainer.TJOBORDER_FK')
                        ->select('tjoborder.*','tcontainer.NOMBL as tcontainer.NOMBL','tcontainer.TGL_MASTER_BL as tcontainer.TGL_MASTER_BL','tcontainer.NOSPK as tcontainer.NOSPK','tjoborder.NAMACONSOLIDATOR as tjoborder.NAMACONSOLIDATOR','tcontainer.*')
                        ->where('tcontainer.TGLENTRY', '>=',date('Y-m-d 00:00:00',strtotime($request['startdate'])))
                        ->where('tcontainer.TGLENTRY', '<=',date('Y-m-d 23:59:59',strtotime($request['enddate'])));
                
            }else{
                $Model = \DB::table('tjoborder')
                        ->select('tjoborder.*','tcontainer.NOMBL as tcontainer.NOMBL','tcontainer.TGL_MASTER_BL as tcontainer.TGL_MASTER_BL','tcontainer.NOSPK as tcontainer.NOSPK','tjoborder.NAMACONSOLIDATOR as tjoborder.NAMACONSOLIDATOR','tcontainer.*')
                        ->join('tcontainer', 'tjoborder.TJOBORDER_PK', '=', 'tcontainer.TJOBORDER_FK');
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\Jobordercy'){
            
            if(isset($request['jobid'])){
                
                $Model = \DB::table('tjobordercy')->join('tcontainercy', 'tjobordercy.TJOBORDER_PK', '=', 'tcontainercy.TJOBORDER_FK')
                        ->where('TJOBORDER_PK', $request['jobid']);
                
            }elseif(isset($request['startdate']) || isset($request['enddate'])){
                
//                $Model = \DB::table('tjobordercy')->join('tcontainercy', 'tjobordercy.TJOBORDER_PK', '=', 'tcontainercy.TJOBORDER_FK')
//                        ->select('tjobordercy.*','tcontainercy.*','tcontainercy.CONSIGNEE as tcontainercy.CONSIGNEE','tcontainercy.NOSPK as tcontainercy.NOSPK')
                    $Model =\DB::table('tcontainercy')
                        ->where('tcontainercy.TGLMASUK', '>=',date('Y-m-d 00:00:00',strtotime($request['startdate'])))
                        ->where('tcontainercy.TGLMASUK', '<=',date('Y-m-d 23:59:59',strtotime($request['enddate'])));
                
            }else{
                $Model = \DB::table('tcontainercy');
//                        ->select('tjobordercy.*','tcontainercy.*','tcontainercy.CONSIGNEE as tcontainercy.CONSIGNEE','tcontainercy.NOSPK as tcontainercy.NOSPK')
//                        ->join('tcontainercy', 'tjobordercy.TJOBORDER_PK', '=', 'tcontainercy.TJOBORDER_FK');
            }
            
        } elseif($Model->getMorphClass() == 'App\Models\JoborderExp'){
            
            if(isset($request['startdate']) || isset($request['enddate'])){
                
                $Model = \DB::table('tjobordereks')->join('tcontainereks', 'tjobordereks.TJOBORDER_PK', '=', 'tcontainer.TJOBORDER_FK')
                        ->select('tjobordereks.*','tcontainereks.NOMBL as tcontainereks.NOMBL','tcontainereks.TGL_MASTER_BL as tcontainereks.TGL_MASTER_BL','tcontainereks.NOSPK as tcontainereks.NOSPK','tjobordereks.NAMACONSOLIDATOR as tjobordereks.NAMACONSOLIDATOR','tcontainereks.*')
                        ->where('tcontainereks.TGLENTRY', '>=',date('Y-m-d 00:00:00',strtotime($request['startdate'])))
                        ->where('tcontainereks.TGLENTRY', '<=',date('Y-m-d 23:59:59',strtotime($request['enddate'])));
                
            }else{
                $Model = \DB::table('tjobordereks')
                        ->select('tjobordereks.*','tcontainereks.NOMBL as tcontainereks.NOMBL','tcontainereks.TGL_MASTER_BL as tcontainereks.TGL_MASTER_BL','tcontainereks.NOSPK as tcontainereks.NOSPK','tjobordereks.NAMACONSOLIDATOR as tjobordereks.NAMACONSOLIDATOR','tcontainereks.*')
                        ->join('tcontainereks', 'tjobordereks.TJOBORDER_PK', '=', 'tcontainereks.TJOBORDER_FK');
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\Manifest'){
            
            if(isset($request['containerid'])){
                
                $Model = \DB::table('tmanifest')
                        ->where('TCONTAINER_FK', $request['containerid']);

            }elseif(isset($request['module'])){
                
                switch ($request['module']) {
                    case 'status_behandle':
                        $Model = \DB::table('tmanifest')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
//                            ->where('BEHANDLE', 'Y')
//                            ->whereNull('tglbehandle')
                            ->whereIn('status_behandle',array('Ready','Checking'))
//                            ->where('flag_bc','N')
//                            ->orWhere('alasan_segel', 'IKP / Temuan Lapangan')
                            ->orWhere(function($query)
                            {
                                $query->where("flag_bc","Y")
                                      ->where("alasan_segel","IKP / Temuan Lapangan");
                            })
                            ;
                    break;
                    case 'finish_behandle':
                        $Model = \DB::table('tmanifest')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
                            ->whereNotNull('tglbehandle')
                            ->where('status_behandle','Finish');
                    break;
                    case 'behandle':
                        
                    break;
                    case 'fiatmuat':
                        $Model = \DB::table('tmanifest')
                            ->select('tmanifest.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifest.TCONSIGNEE_FK');
//                            ->whereNotNull('tmanifest.NO_SPJM')
//                            ->whereNotNull('tmanifest.TGL_SPJM');
                    break;
                    case 'suratjalan':
                        $Model = \DB::table('tmanifest')
                            ->whereNotNull('NO_SPPB')
                            ->whereNotNull('TGL_SPPB');
                    break;
                    case 'release':
                        $Model = \DB::table('tmanifest')
//                            ->select('tmanifest.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
//                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifest.TCONSIGNEE_FK');
//                        $Model = \DB::table('tmanifest')
//                            ->whereNotNull('TGLSURATJALAN')
//                            ->whereNotNull('JAMSURATJALAN');
                            ->where('VALIDASI', 'Y');
                    break;
                    case 'hold':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifest')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->where('status_bc', 'HOLD')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifest')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                                ->where('status_bc', 'HOLD');
                        }
                    break;
                    case 'segel':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifest')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping')
                            ->whereNull('tglrelease')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifest')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                                ->whereNotNull('tglmasuk')
                                ->whereNotNull('tglstripping')
                                ->whereNull('tglrelease');
                        }
                    break;
                    case 'segel_report':
                        $Model = \DB::table('tmanifest')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->whereNotNull('no_unflag_bc')
                            ->whereNotNull('alasan_lepas_segel');
                    break;
                    case 'longstay':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifest')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
//                            ->whereRaw('tmanifest.tglmasuk < DATE_SUB(now(), INTERVAL 1 MONTH)')
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping')
                            ->whereNull('tglrelease')
                            ->where('LOKASI_TUJUAN', 'like', $request['gd'])
//                            ->orWhere('tglrelease','0000-00-00')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifest')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
    //                            ->whereRaw('tmanifest.tglmasuk < DATE_SUB(now(), INTERVAL 1 MONTH)')
                                ->whereNotNull('tglmasuk')
                                ->whereNotNull('tglstripping')
                                ->whereNull('tglrelease')
                                ->where('LOKASI_TUJUAN', 'like', $request['gd'])
    //                            ->orWhere('tglrelease','0000-00-00')
                                    ;
                        }
                    break;
                    case 'release-invoice':
                        $Model = \DB::table('tmanifest')
//                            ->select('tmanifest.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
//                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifest.TCONSIGNEE_FK');
//                        $Model = \DB::table('tmanifest')
                            ->whereNotNull('tglrelease')
                            ->whereNotNull('jamrelease');
                    break;
                }
                
            }if(isset($request['startdate']) || isset($request['enddate'])){
                
                $start_date = date('Y-m-d',strtotime($request['startdate']));
                $end_date = date('Y-m-d',strtotime($request['enddate']));      
                
                $Model = \DB::table('tmanifest')
                        ->where($request['by'], '>=',$start_date)
                        ->where($request['by'], '<=',$end_date);
                
            }elseif(isset($request['report'])){
                if(isset($request['date'])){
                    if($request['type'] == 'in'){
                $Model = \DB::table('tmanifest')
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->where('tglstripping', $request['date']);
                    }elseif($request['type'] == 'out'){
                        $Model = \DB::table('tmanifest')
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->where('tglrelease', $request['date']);
                    } 
            }else{
                    $Model = \DB::table('tmanifest')
    //                        ->leftjoin('billing_invoice', 'billing_invoice.manifest_id','=','tmanifest.TMANIFEST_PK')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping');   
                }
            }else{
                
            }
            
        }elseif($Model->getMorphClass() == 'App\Models\ManifestExp'){
            
            if(isset($request['containerid'])){
                
                $Model = \DB::table('tmanifesteks')
                        ->where('TCONTAINER_FK', $request['containerid']);

            }elseif(isset($request['module'])){
                
                switch ($request['module']) {
                    case 'status_behandle':
                        $Model = \DB::table('tmanifesteks')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
//                            ->where('BEHANDLE', 'Y')
//                            ->whereNull('tglbehandle')
                            ->whereIn('status_behandle',array('Ready','Checking'))
//                            ->where('flag_bc','N')
//                            ->orWhere('alasan_segel', 'IKP / Temuan Lapangan')
                            ->orWhere(function($query)
                            {
                                $query->where("flag_bc","Y")
                                      ->where("alasan_segel","IKP / Temuan Lapangan");
                            })
                            ;
                    break;
                    case 'finish_behandle':
                        $Model = \DB::table('tmanifesteks')
                            ->whereNotNull('NO_SPJM')
                            ->whereNotNull('TGL_SPJM')
                            ->whereNotNull('tglbehandle')
                            ->where('status_behandle','Finish');
                    break;
                    case 'behandle':
                        
                    break;
                    case 'fiatmuat':
                        $Model = \DB::table('tmanifesteks')
                            ->select('tmanifesteks.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifesteks.TCONSIGNEE_FK');
//                            ->whereNotNull('tmanifesteks.NO_SPJM')
//                            ->whereNotNull('tmanifesteks.TGL_SPJM');
                    break;
                    case 'suratjalan':
                        $Model = \DB::table('tmanifesteks')
                            ->whereNotNull('NO_SPPB')
                            ->whereNotNull('TGL_SPPB');
                    break;
                    case 'release':
                        $Model = \DB::table('tmanifesteks')
//                            ->select('tmanifesteks.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
//                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifesteks.TCONSIGNEE_FK');
//                        $Model = \DB::table('tmanifesteks')
//                            ->whereNotNull('TGLSURATJALAN')
//                            ->whereNotNull('JAMSURATJALAN');
                            ->where('VALIDASI', 'Y');
                    break;
                    case 'hold':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifesteks')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->where('status_bc', 'HOLD')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifesteks')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                                ->where('status_bc', 'HOLD');
                        }
                    break;
                    case 'segel':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifesteks')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping')
                            ->whereNull('tglrelease')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifesteks')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                                ->whereNotNull('tglmasuk')
                                ->whereNotNull('tglstripping')
                                ->whereNull('tglrelease');
                        }
                    break;
                    case 'segel_report':
                        $Model = \DB::table('tmanifesteks')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
                            ->whereNotNull('no_unflag_bc')
                            ->whereNotNull('alasan_lepas_segel');
                    break;
                    case 'longstay':
                        if(isset($request['startdate']) || isset($request['enddate'])){
                            $start_date = date('Y-m-d',strtotime($request['startdate']));
                            $end_date = date('Y-m-d',strtotime($request['enddate']));  
                            
                            $Model = \DB::table('tmanifesteks')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
//                            ->whereRaw('tmanifesteks.tglmasuk < DATE_SUB(now(), INTERVAL 1 MONTH)')
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping')
                            ->whereNull('tglrelease')
                            ->where('LOKASI_TUJUAN', 'like', $request['gd'])
//                            ->orWhere('tglrelease','0000-00-00')
                            ->where($request['by'], '>=',$start_date)
                            ->where($request['by'], '<=',$end_date);
                        }else{
                            $Model = \DB::table('tmanifesteks')
                                ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
    //                            ->whereRaw('tmanifesteks.tglmasuk < DATE_SUB(now(), INTERVAL 1 MONTH)')
                                ->whereNotNull('tglmasuk')
                                ->whereNotNull('tglstripping')
                                ->whereNull('tglrelease')
                                ->where('LOKASI_TUJUAN', 'like', $request['gd'])
    //                            ->orWhere('tglrelease','0000-00-00')
                                    ;
                        }
                    break;
                    case 'release-invoice':
                        $Model = \DB::table('tmanifesteks')
//                            ->select('tmanifesteks.*','tperusahaan.NPWP as NPWP_CONSIGNEE')
//                            ->join('tperusahaan', 'tperusahaan.TPERUSAHAAN_PK', '=', 'tmanifesteks.TCONSIGNEE_FK');
//                        $Model = \DB::table('tmanifesteks')
                            ->whereNotNull('tglrelease')
                            ->whereNotNull('jamrelease');
                    break;
                }
                
            }if(isset($request['startdate']) || isset($request['enddate'])){
                
                $start_date = date('Y-m-d',strtotime($request['startdate']));
                $end_date = date('Y-m-d',strtotime($request['enddate']));      
                
                $Model = \DB::table('tmanifesteks')
                        ->where($request['by'], '>=',$start_date)
                        ->where($request['by'], '<=',$end_date);
                
            }elseif(isset($request['report'])){
                if(isset($request['date'])){
                    if($request['type'] == 'in'){
                $Model = \DB::table('tmanifesteks')
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->where('tglstripping', $request['date']);
                    }elseif($request['type'] == 'out'){
                        $Model = \DB::table('tmanifesteks')
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->where('tglrelease', $request['date']);
                    } 
            }else{
                    $Model = \DB::table('tmanifesteks')
    //                        ->leftjoin('billing_invoice', 'billing_invoice.manifest_id','=','tmanifesteks.TMANIFESTeks_PK')
                            ->select(\DB::raw('*, timestampdiff(DAY, now(), tglmasuk) as timeSinceUpdate'))
//                            ->where('LOKASI_GUDANG', 'like', $request['gd'])
                            ->where(function ($query) use ($request) {
                                $query->where('LOKASI_GUDANG', 'like', $request['gd'])
                                ->whereNull('LOKASI_TUJUAN')
                                ->orWhere('LOKASI_TUJUAN', 'like', $request['gd']);
                            })
                            ->whereNotNull('tglmasuk')
                            ->whereNotNull('tglstripping');   
                }
            }else{
                
            }
            
        }
       
        
        $this->Database = $Model;        
        $this->visibleColumns = $Columns; 
        $this->orderBy = array(array('id', 'asc'), array('name'));
    }
}