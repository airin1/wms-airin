<?php
namespace App\Models;

use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;
use Mgallegos\LaravelJqgrid\Repositories\EloquentRepositoryAbstract;
 
class InvoiceTablesRepository extends EloquentRepositoryAbstract {
 
    public function __construct($ModelRef, $request = null)
    {
        $Columns = array('*');

//        if(isset($request['tarif_id'])){
//            $Model = \DB::table($ModelRef)->where('tarif_id', $request['tarif_id']);
//        }else{
//            $Model = \DB::table($ModelRef);
//        }
        
        if($ModelRef == 'invoice_lcl'){
            $Model = \DB::table($ModelRef)
                    ->join('tcontainer', 'invoice_lcl.container_id', '=', 'tcontainer.TCONTAINER_PK');
        }elseif($ModelRef == 'invoice_tarif_consolidator'){
            $Model = \DB::table($ModelRef)
                    ->join('tconsolidator', 'invoice_tarif_consolidator.consolidator_id', '=', 'tconsolidator.TCONSOLIDATOR_PK');
        }elseif($ModelRef == 'invoice_tarif_npct'){
            $Model = InvoiceTarifNct::select('*');
        }elseif($ModelRef == 'invoice_nct'){
            $Model = InvoiceNct::select('*');
        }
        
        $this->Database = $Model;        
        $this->visibleColumns = $Columns; 
        $this->orderBy = array(array('id', 'asc'), array('name'));
    }
}