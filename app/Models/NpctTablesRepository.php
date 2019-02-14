<?php

namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
 
class NpctTablesRepository extends EloquentRepositoryAbstract {
 
    public function __construct(Model $Model, $request = null)
    {
        $Columns = array('*');
        
        if($Model->getMorphClass() == 'App\Models\NpctYor'){
        
            if(isset($request['responid'])){
//                $Model = \DB::table('tps_responplptujuandetailxml')
//                        ->where('tps_responplptujuanxml_fk', $request['responid']);
            }else{
                
            }
        }elseif($Model->getMorphClass() == 'App\Models\TpsResponPlp'){   
            if(isset($request['startdate']) && isset($request['enddate'])){
                if($request['by'] == 'TGL_UPLOAD') {
                    $start_date = date('Y-m-d 00:00:00',strtotime($request['startdate']));
                    $end_date = date('Y-m-d 23:59:59',strtotime($request['enddate']));
                }else{
                    $start_date = date('Ymd',strtotime($request['startdate']));
                    $end_date = date('Ymd',strtotime($request['enddate']));      
                }
                $Model = \DB::table('tps_responplptujuanxml')
                        ->where($request['by'], '>=', $start_date)
                        ->where($request['by'], '<=', $end_date);
            }else{
                
            }
        }else{
                        
        }
        
        $this->Database = $Model;        
        $this->visibleColumns = $Columns; 
        $this->orderBy = array(array('id', 'asc'), array('name'));
    }
}