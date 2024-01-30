<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use App\Models\Barcode as DBGate;

class BarcodeController extends Controller
{
    
    protected $wsdl;
    protected $user;
    protected $password;
    protected $kode;
    protected $response;
	
    public function __construct() {
        // CHECK STATUS BEHANDLE
        $lcl_sb = \App\Models\Manifest::whereIn('status_behandle',array('Ready','Siap Periksa'))->count();
        $fcl_sb = \App\Models\Containercy::whereIn('status_behandle',array('Ready','Siap Periksa'))->count();
        
        View::share('notif_behandle', array('lcl' => $lcl_sb, 'fcl' => $fcl_sb, 'total' => $lcl_sb+$fcl_sb));
    }
    
    public function index()
    {
        $data['page_title'] = "Gate Pass (Auto Gate)";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Gate Pass (Auto Gate)'
            ]
        ];        
        
        return view('barcode.index')->with($data);
    }

    public function view($id)
    {
        $data['page_title'] = "View Data";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('barcode-index'),
                'title' => 'Gate Pass (Auto Gate)'
            ],
            [
                'action' => '',
                'title' => 'View'
            ]
        ];        
        
        $barcode = \App\Models\Barcode::find($id);
        $model = '';
        
        switch ($barcode->ref_type) {
            case 'Fcl':
                $model = 'tcontainercy';
                break;
            case 'Lcl':
                $model = 'tcontainer';
                break;
            case 'Manifest':
                $model = 'tmanifest';
                break;
			 case 'LCLEKS':
			    $model = 'tcontainereks';   
                break;
			case 'Manifesteks':
			    $model = 'tmanifesteks';
               
                break;		
        }
        
        if($barcode->ref_type == 'Manifest'||$barcode->ref_type == 'Manifesteks'){
            $data_barcode = \App\Models\Barcode::select('*')
                ->join($model, 'barcode_autogate.ref_id', '=', $model.'.TMANIFEST_PK')
                ->where(array('barcode_autogate.ref_type' => ucwords($barcode->ref_type), 'barcode_autogate.ref_action'=>$barcode->ref_action))
                ->where($model.'.TMANIFEST_PK', $barcode->ref_id)
                ->first();
        }else{
            $data_barcode = \App\Models\Barcode::select('*')
                ->join($model, 'barcode_autogate.ref_id', '=', $model.'.TCONTAINER_PK')
                ->where(array('barcode_autogate.ref_type' => ucwords($barcode->ref_type), 'barcode_autogate.ref_action'=>$barcode->ref_action))
                ->where($model.'.TCONTAINER_PK', $barcode->ref_id)
                ->first();
        }
        
//        return json_encode($data_barcode);

        $data['barcode'] = $data_barcode;
        
        return view('barcode.view')->with($data);
    }
    
    public function delete($id)
    {
		$check = \App\Models\Barcode::where('id', $id)->first();               
         if(count($check) > 0){ 		
		                $logbarcode = new \App\Models\LogBarcode();
                        $logbarcode->ref_id =  $check->ref_id ;
                        $logbarcode->ref_type = $check->ref_type;
                        $logbarcode->ref_action = $check->ref_action;
                        $logbarcode->ref_number =  $check->ref_number ;
                        $logbarcode->barcode = $check->barcode;
                        $logbarcode->jenis_tran = 'Delete Barcode';
                        $logbarcode->status = $check->status;
                        $logbarcode->uid = \Auth::getUser()->name;
                        $logbarcode->save();
		 }
        \App\Models\Barcode::where('id', $id)->delete();
        return back()->with('success', 'Gate Pass has been deleted.'); 
    }
    
    public function cancel(Request $request)
    {
        $sid = $request->id;
        $ids = explode(',', $sid);
   
        $barcode = \App\Models\Barcode::find($sid);
		//$ref_id  = $barcode->ref_id;
         
        
       
		
		if($barcode->ref_type=='Fcl'){
			 $container = \App\Models\Containercy::find($barcode->ref_id);
			if($barcode->ref_action == 'get'){			  
	          $container->TGLMASUK = NULL;
			  $container->JAMMASUK = NULL;
			  $container->UIDMASUK = '';
              $container->save();
			}	
			if($barcode->ref_action == 'release'){			  
	          $container->TGLRELEASE = NULL;
			  $container->JAMRELEASE = NULL;			
              $container->save();
			}	
		}	
		$update = \App\Models\Barcode::whereIn('id',$ids)->update(['cancel' => true]);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Gate pass has canceled.'));
        } 
         if($container->save()){
			  return json_encode(array('success' => true, 'message' => 'Gate pass has canceled.'));
		 }	 

		
        return json_encode(array('success' => false, 'message' => 'Something wrong, please try again.'));

    }
    
    public function setRfid(Request $request)
    {
        $model = '';
        $expired = date('Y-m-d', strtotime('+1 day'));
        
        switch ($request->type) {
            case 'fcl':
                $model = 'tcontainercy';
                break;
            case 'lcl':
                $model = 'tcontainer';
                break;
            case 'manifest':
                $model = 'tmanifest';
                break;
			 case 'lcleks':
			    $model = 'tcontainereks';   
                break;
			case 'Manifesteks':
			    $model = 'tmanifesteks';               
                break;			
        }
        
        // Check data
        $ref_number = '';
        if($request->type == 'manifest'){
            $refdata = \App\Models\Manifest::find($request->refid);
            $ref_number = $refdata->NOHBL;
        }elseif($request->type == 'lcl'){
            $refdata = \App\Models\Container::find($request->refid);
            $ref_number = $refdata->NOCONTAINER;
        }elseif($request->type == 'fcl'){
            $refdata = \App\Models\Containercy::find($request->refid);
            $ref_number = $refdata->NOCONTAINER;
            if($request->action == 'get'){
                $expired = date('Y-m-d', strtotime('+3 day'));
            }
        }

        $check = \App\Models\Barcode::where(array('barcode'=>$request->code, 'status'=>'active'))->first();               
        if(count($check) > 0){
//                    continue;
//            $barcode = \App\Models\Barcode::find($check->id);
//            $barcode->expired = $expired;
//            $barcode->status = 'active';
//            $barcode->uid = \Auth::getUser()->name;
//            $barcode->save();
            return back()->with('error', 'RFID No.'.$request->code.' masih di gunakan.'); 
        }else{
            $barcode = new \App\Models\Barcode();
            $barcode->ref_id = $request->refid;
            $barcode->ref_type = ucwords($request->type);
            $barcode->ref_action = $request->action;
            $barcode->ref_number = $ref_number;
            $barcode->barcode = $request->code;
            $barcode->expired = $expired;
            $barcode->status = 'active';
            $barcode->uid = \Auth::getUser()->name;
            
            if($barcode->save()){
                 return back()->with('success', 'RFID No.'.$request->code.' berhasil di gunakan.'); 
            }
        }  
        
        return back()->with('error', 'Something wrong!!!'); 
        
    }
    
    public function printBarcodePreview($id, $type, $action, $car = null, $location = null)
    { 
        $ids = explode(',', $id);
        $model = '';
        $expired = date('Y-m-d', strtotime('+1 day'));
        
        switch ($type) {
            case 'fcl':
                $model = 'tcontainercy';
                break;
            case 'lcl':
                $model = 'tcontainer';
                break;
            case 'manifest':
                $model = 'tmanifest';
                break;
			case 'lcleks':
			    $model = 'tcontainereks';   
                break;
			case 'manifesteks':
			    $model = 'tmanifesteks';               
                break;			
        }
        //Create Barcode If not exist
        if(is_array($ids)){
            foreach ($ids as $ref_id):
                // Check data
                $ref_number = '';
                $ref_status = 'active';
                if($type == 'manifest'){
                    $refdata = \App\Models\Manifest::find($ref_id);
                    $ref_number = $refdata->NOHBL;
                    $ref_status = ($refdata->status_bc == 'HOLD') ? 'hold' : 'active';
                    if($location){
                        $refdata->LOKASI_TUJUAN = $location;
                        $refdata->save();
                    }
                }elseif($type == 'lcl'){
                    $refdata = \App\Models\Container::find($ref_id);
                    $ref_number = $refdata->NOCONTAINER;
					if($action == 'get'){
                        $expired = date('Y-m-d', strtotime('+3 day'));
                    }
                }elseif($type == 'fcl'){
                    $refdata = \App\Models\Containercy::find($ref_id);
                    $ref_number = $refdata->NOCONTAINER;
                    $ref_status = ($refdata->status_bc == 'HOLD') ? 'hold' : 'active';
                    if($action == 'get'){
                        $expired = date('Y-m-d', strtotime('+3 day'));
                    }
                }elseif($type == 'lcleks'){
                    $refdata = \App\Models\ContainerExp::find($ref_id);
                    $ref_number = $refdata->NOCONTAINER;
                    $ref_status = ($refdata->status_bc == 'HOLD') ? 'hold' : 'active';
                    if($action == 'get'){
                        $expired = date('Y-m-d', strtotime('+3 day'));
                    }
                }elseif($type == 'manifesteks'){
                    $refdata = \App\Models\ManifestExp::find($ref_id);
                    $ref_number = $refdata->NO_PACK;
                    $ref_status = ($refdata->status_bc == 'HOLD') ? 'hold' : 'active';
                    if($action == 'get'){
                        $expired = date('Y-m-d', strtotime('+3 day'));
                    }
                }
                
                if($car && $car > 0){
                    for ($i = 0; $i < $car; $i++) { 
                        $barcode = new \App\Models\Barcode();
                        $barcode->ref_id = $ref_id;
                        $barcode->ref_type = ucwords($type);
                        $barcode->ref_action = $action;
                        $barcode->ref_number = $ref_number;
                        $barcode->barcode = str_random(20);
                        $barcode->expired = $expired;
                        $barcode->status = $ref_status;
                        $barcode->uid = \Auth::getUser()->name;
                        $barcode->save();
                    }   
                }else{
                    $check = \App\Models\Barcode::where(array('ref_id'=>$ref_id, 'ref_type'=>ucwords($type), 'ref_action'=>$action))->first();               
                    if(count($check) > 0){
    //                    continue;
                        $barcode = \App\Models\Barcode::find($check->id);
                        $barcode->expired = $expired;
                        $barcode->status = $ref_status;
                        $barcode->uid = \Auth::getUser()->name;
                        $barcode->save();
                    }else{
                        $barcode = new \App\Models\Barcode();
                        $barcode->ref_id = $ref_id;
                        $barcode->ref_type = ucwords($type);
                        $barcode->ref_action = $action;
                        $barcode->ref_number = $ref_number;
                        $barcode->barcode = str_random(20);
                        $barcode->expired = $expired;
                        $barcode->status = $ref_status;
                        $barcode->uid = \Auth::getUser()->name;
                        $barcode->save();
                    }
                }
  
            endforeach;
        }else{
            return $ids;
        }
        
        if($type == 'manifest'||$type == 'manifesteks'){
            $data_barcode = \App\Models\Barcode::select('*')
                ->join($model, 'barcode_autogate.ref_id', '=', $model.'.TMANIFEST_PK')
                ->where(array('ref_type' => ucwords($type), 'ref_action'=>$action))
                ->whereIn($model.'.TMANIFEST_PK', $ids)
                ->get();
        }else{
            $data_barcode = \App\Models\Barcode::select('*')
                ->join($model, 'barcode_autogate.ref_id', '=', $model.'.TCONTAINER_PK')
                ->where(array('ref_type' => ucwords($type), 'ref_action'=>$action))
                ->whereIn($model.'.TCONTAINER_PK', $ids)
                ->get();
        }
        
//        return json_encode($data_barcode);

        $data['barcodes'] = $data_barcode;
        $data['custom_location'] = $location;
//        $data['ref'] = $ref;
        return view('print.barcode', $data);
//        $pdf = \PDF::loadView('print.barcode', $data); 
//        return $pdf->stream('Delivery-Release-Barcode-'.$mainfest->NOHBL.'-'.date('dmy').'.pdf');
    }
    
    public function autogateNotification(Request $request)
    {
        $barcode = $request->barcode;
        $tipe = $request->tipe;
        
        $data_barcode = \App\Models\Barcode::where('barcode', $barcode)->first();
        
        $filename = '';
        if ($request->hasFile('fileKamera')) {
            
            $file = $request->file('fileKamera');
            
//            return $file->getClientOriginalName();
            
            $destinationPath = base_path() . '/public/uploads/photos/autogate';
//            $i = 1;
//            foreach($files as $file){
                $filename = ucwords($data_barcode->ref_type).'_'.ucwords($data_barcode->ref_action).'_'.ucwords($tipe).'_'.$file->getClientOriginalName();
//                $extension = $file->getClientOriginalExtension();
        
//                $filename = date('dmyHis').'_'.$barcode.'_'.ucwords($data_barcode->ref_type).'_'.ucwords($data_barcode->ref_action).'_'.ucwords($tipe).'.'.$extension;
//                $picture[] = $filename;
                $store = $file->move($destinationPath, $filename);
//                $i++;
//            }
                
                if($store){
                if($tipe == 'in'){
                    $data_barcode->photo_in = $filename;
                }else{
                    $data_barcode->photo_out = $filename;
                }
                
                $data_barcode->save();
                }else{
                    
        }
        }
        
        if($data_barcode){
//            return $data_barcode;
            switch ($data_barcode->ref_type) {
                case 'Fcl':
                    $model = \App\Models\Containercy::find($data_barcode->ref_id);
                    $ref_number = $model->REF_NUMBER;
                    $ref_number_out = $model->REF_NUMBER_OUT;
                    break;
                case 'Lcl':
                    $model = \App\Models\Container::find($data_barcode->ref_id);
                    $ref_number = $model->REF_NUMBER_IN;
                    $ref_number_out = $model->REF_NUMBER_OUT;
                    break;
                case 'Manifest':
                    $model = \App\Models\Manifest::find($data_barcode->ref_id);
                    break;
				 case 'LCLEKS':
                    $model = \App\Models\ContainerExp::find($data_barcode->ref_id);
                    break;
				 case 'Manifesteks':
                    $model = \App\Models\ManifestExp::find($data_barcode->ref_id);
                    break;	
            }
            
            if($model){
                
                if($data_barcode->ref_action == 'get'){
//                    if($data_barcode->time_in != NULL){
                        // GATEIN
                        $model->TGLMASUK = date('Y-m-d', strtotime($data_barcode->time_in));
                        $model->JAMMASUK = date('H:i:s', strtotime($data_barcode->time_in));
                        if($tipe == 'in'){
                            $model->photo_get_in = $filename;
                        }else{
                            $model->photo_get_out = $filename;
                        }
                        $model->UIDMASUK = 'Autogate';

                        if($model->save()){
                            // Update Manifest If LCL
                            if($data_barcode->ref_type == 'Lcl'){
                                \App\Models\Manifest::where('TCONTAINER_FK', $model->TCONTAINER_PK)->update(array('tglmasuk' => $model->TGLMASUK, 'jammasuk' => $model->JAMMASUK));
                            }
                            
                            // Upload Coari Container TPS Online
                            // Check Coari Exist
//                            if($ref_number){
                                return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' Updated';
//                            }else{
//                                 $check_coari = \App\Models\TpsCoariCont::where('REF_NUMBER', $ref_number)->count();
//                                 if($check_coari > 0){
//                                     return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' Updated';
//                                 }else{
//                                    $coari_id = $this->uploadTpsOnlineCoariCont($data_barcode->ref_type,$data_barcode->ref_id);
////                                    return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' XML Coari Created';
////                                    return $coari_id;
//                                    return redirect()->route('tps-coariCont-upload', $coari_id);
//                                 }
//                            }
  
                        }else{
                            return 'Something wrong!!! Cannot store to database';
                        }
//                    }else{
//                        return 'Time In is NULL';
//                    }
                }elseif($data_barcode->ref_action == 'release'){
//                    if($data_barcode->time_out != NULL){
                        // RELEASE
                    if($model->status_bc == 'HOLD' || $model->flag_bc == 'Y'):
                        return 'Status BC is HOLD or FLAGING, please unlock!!!';
                    endif;
                        
                        if($data_barcode->cancel == false){
                    
                            if($data_barcode->ref_type == 'Manifest'){
                                if($data_barcode->time_out){
                                $model->tglrelease = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->jamrelease = date('H:i:s', strtotime($data_barcode->time_out));
                                $model->UIDRELEASE = 'Autogate';
                                $model->TGLSURATJALAN = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->JAMSURATJALAN = date('H:i:s', strtotime($data_barcode->time_out));
                                $model->tglfiat = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->jamfiat = date('H:i:s', strtotime($data_barcode->time_out));
                                $model->NAMAEMKL = 'Autogate';
                                $model->UIDSURATJALAN = 'Autogate';
                                }
                                if($tipe == 'in'){
                                    $model->photo_release_in = $filename;
                                }else{
                                    $model->photo_release_out = $filename;
                                }
                                if($model->save()){
                                    return $model->NOHBL.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' Updated';
                                }else{
                                    return 'Something wrong!!! Cannot store to database';
                                }
                            }else{

                                if($data_barcode->time_out){
                                $model->TGLRELEASE = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->JAMRELEASE = date('H:i:s', strtotime($data_barcode->time_out));
                                $model->UIDKELUAR = 'Autogate';
                                $model->TGLFIAT = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->JAMFIAT = date('H:i:s', strtotime($data_barcode->time_out));
                                $model->TGLSURATJALAN = date('Y-m-d', strtotime($data_barcode->time_out));
                                $model->JAMSURATJALAN = date('H:i:s', strtotime($data_barcode->time_out));
                                }
                                if($tipe == 'in'){
                                    $model->photo_release_in = $filename;
                                }else{
                                    $model->photo_release_out = $filename;
                                }
                                if($model->save()){
                                    // Check Coari Exist
    //                                if($ref_number_out){
                                        return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' Updated';
    //                                }else{
    //                                    $codeco_id = $this->uploadTpsOnlineCodecoCont($data_barcode->ref_type,$data_barcode->ref_id);
    ////                                    return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' XML Codeco Created';
    ////                                    return $codeco_id;
    //                                    return redirect()->route('tps-codecoCont-upload', $codeco_id);
    //                                }
                                }else{
                                    return 'Something wrong!!! Cannot store to database';
                                }
                            }
                        }
//                    }else{
//                        return 'Error';
//                    }
                    
                }elseif($data_barcode->ref_action == 'empty'){
//                    if($data_barcode->time_out != NULL){
                        if($data_barcode->time_out){
                        $model->TGLBUANGMTY = date('Y-m-d', strtotime($data_barcode->time_out));
                        $model->JAMBUANGMTY = date('H:i:s', strtotime($data_barcode->time_out));
                        $model->UIDMTY = 'Autogate';
                        }
                        if($tipe == 'in'){
                            $model->photo_empty_in = $filename;
                        }else{
                            $model->photo_empty_out = $filename;
                        }
                        if($model->save()){
                            // Check Coari Exist
//                            if($ref_number_out){
                                return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' Updated';
//                            }else{
//                                $codeco_id = $this->uploadTpsOnlineCodecoCont($data_barcode->ref_type,$data_barcode->ref_id);
////                                return $model->NOCONTAINER.' '.$data_barcode->ref_type.' '.$data_barcode->ref_action.' XML Codeco Created';
//                                return redirect()->route('tps-codecoCont-upload', $codeco_id);
//                            }
                        }else{
                            return 'Something wrong!!! Cannot store to database';
                        }
//                    }else{
//                        
//                    }
                }
                
            }else{
                return 'Something wrong in Model!!!';
            }
        }else{
            return 'Barcode not found!!';
        }
//        return $barcode;
//        app('App\Http\Controllers\PrintReportController')->getPrintReport();
    }
    
    public function uploadTpsOnlineCoariCont($type, $id)
    {
        $container_id = $id; 
        
        // Reff Number
        $reff_number = $this->getReffNumber('Autogate'); 
        
        if($type == 'Fcl'){
            $container = \App\Models\Containercy::where('TCONTAINER_PK', $container_id)->first();
            
            if($reff_number){
                $coaricont = new \App\Models\TpsCoariCont;
                $coaricont->REF_NUMBER = $reff_number;
                $coaricont->TGL_ENTRY = date('Y-m-d');
                $coaricont->JAM_ENTRY = date('H:i:s');
                $coaricont->UID = 'Autogate';

                if($coaricont->save()){
                    $coaricontdetail = new \App\Models\TpsCoariContDetail;
                    $coaricontdetail->TPSCOARICONTXML_FK = $coaricont->TPSCOARICONTXML_PK;
                    $coaricontdetail->REF_NUMBER = $reff_number;
                    $coaricontdetail->KD_DOK = 5;
                    $coaricontdetail->KD_TPS = 'AIRN';
                    $coaricontdetail->NM_ANGKUT = (!empty($container->VESSEL) ? $container->VESSEL : 0);
                    $coaricontdetail->NO_VOY_FLIGHT = (!empty($container->VOY) ? $container->VOY : 0);
                    $coaricontdetail->CALL_SIGN = (!empty($container->CALL_SIGN) ? $container->CALL_SIGN : 0);
                    $coaricontdetail->TGL_TIBA = (!empty($container->ETA) ? date('Ymd', strtotime($container->ETA)) : '');
                    $coaricontdetail->KD_GUDANG = $container->GUDANG_TUJUAN;
                    $coaricontdetail->NO_CONT = $container->NOCONTAINER;
                    $coaricontdetail->UK_CONT = $container->SIZE;
                    $coaricontdetail->NO_SEGEL = $container->NO_SEAL;
                    $coaricontdetail->JNS_CONT = 'F';
                    $coaricontdetail->NO_BL_AWB = $container->NO_BL_AWB;
                    $coaricontdetail->TGL_BL_AWB = (!empty($container->TGL_BL_AWB) ? date('Ymd', strtotime($container->TGL_BL_AWB)) : '');
                    $coaricontdetail->NO_MASTER_BL_AWB = $container->NOMBL;
                    $coaricontdetail->TGL_MASTER_BL_AWB = (!empty($container->TGL_MASTER_BL) ? date('Ymd', strtotime($container->TGL_MASTER_BL)) : '');
                    $coaricontdetail->ID_CONSIGNEE = $container->ID_CONSOLIDATOR;
                    $coaricontdetail->CONSIGNEE = $container->NAMACONSOLIDATOR;
                    $coaricontdetail->BRUTO = (($container->WEIGHT > 0) ? $container->WEIGHT : 20000);
                    $coaricontdetail->NO_BC11 = $container->NO_BC11;
                    $coaricontdetail->TGL_BC11 = (!empty($container->TGL_BC11) ? date('Ymd', strtotime($container->TGL_BC11)) : '');
                    $coaricontdetail->NO_POS_BC11 = '';
                    $coaricontdetail->KD_TIMBUN = 'GD';
                    $coaricontdetail->KD_DOK_INOUT = 3;
                    $coaricontdetail->NO_DOK_INOUT = (!empty($container->NO_PLP) ? $container->NO_PLP : '');
                    $coaricontdetail->TGL_DOK_INOUT = (!empty($container->TGL_PLP) ? date('Ymd', strtotime($container->TGL_PLP)) : '');
                    $coaricontdetail->WK_INOUT = date('Ymd', strtotime($container->TGLMASUK)).date('His', strtotime($container->JAMMASUK));
                    $coaricontdetail->KD_SAR_ANGKUT_INOUT = 1;
                    $coaricontdetail->NO_POL = $container->NOPOL;
                    $coaricontdetail->FL_CONT_KOSONG = 2;
                    $coaricontdetail->ISO_CODE = '';
                    $coaricontdetail->PEL_MUAT = $container->PEL_MUAT;
                    $coaricontdetail->PEL_TRANSIT = $container->PEL_TRANSIT;
                    $coaricontdetail->PEL_BONGKAR = $container->PEL_BONGKAR;
                    $coaricontdetail->GUDANG_TUJUAN = $container->GUDANG_TUJUAN;
                    $coaricontdetail->UID = 'Autogate';
                    $coaricontdetail->NOURUT = 1;
                    $coaricontdetail->RESPONSE = '';
                    $coaricontdetail->STATUS_TPS = 1;
                    $coaricontdetail->KODE_KANTOR = '040300';
                    $coaricontdetail->NO_DAFTAR_PABEAN = $container->NO_DAFTAR_PABEAN;
                    $coaricontdetail->TGL_DAFTAR_PABEAN = (!empty($container->TGL_DAFTAR_PABEAN) ? date('Ymd', strtotime($container->TGL_DAFTAR_PABEAN)) : '');
                    $coaricontdetail->NO_SEGEL_BC = '';
                    $coaricontdetail->TGL_SEGEL_BC = '';
                    $coaricontdetail->NO_IJIN_TPS = '';
                    $coaricontdetail->TGL_IJIN_TPS = '';
                    $coaricontdetail->RESPONSE_IPC = '';
                    $coaricontdetail->STATUS_TPS_IPC = '';
                    $coaricontdetail->NOPLP = '';
                    $coaricontdetail->TGLPLP = '';
                    $coaricontdetail->FLAG_REVISI = '';
                    $coaricontdetail->TGL_REVISI = '';
                    $coaricontdetail->TGL_REVISI_UPDATE = '';
                    $coaricontdetail->KD_TPS_ASAL = $container->KD_TPS_ASAL;
                    $coaricontdetail->FLAG_UPD = '';
                    $coaricontdetail->RESPONSE_MAL0 = '';
                    $coaricontdetail->STATUS_TPS_MAL0 = '';
                    $coaricontdetail->TGL_ENTRY = date('Y-m-d');
                    $coaricontdetail->JAM_ENTRY = date('H:i:s');

                    if($coaricontdetail->save()){

                        $container->REF_NUMBER = $reff_number;
                        $container->save();

                        // Create XML & Send Tps Online
                        return $coaricont->TPSCOARICONTXML_PK;
//                        return redirect()->route('tps-coariCont-upload', $coaricont->TPSCOARICONTXML_PK);
//                        return json_encode(array('insert_id' => $coaricont->TPSCOARICONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                    }

                }
            } else {
                return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
            }
        }elseif($type == 'Lcl'){
            $container = \App\Models\Container::where('TCONTAINER_PK', $container_id)->first();
            
            if($reff_number){
                $coaricont = new \App\Models\TpsCoariCont;
                $coaricont->REF_NUMBER = $reff_number;
                $coaricont->TGL_ENTRY = date('Y-m-d');
                $coaricont->JAM_ENTRY = date('H:i:s');
                $coaricont->UID = 'Autogate';

                if($coaricont->save()){
                    $coaricontdetail = new \App\Models\TpsCoariContDetail;
                    $coaricontdetail->TPSCOARICONTXML_FK = $coaricont->TPSCOARICONTXML_PK;
                    $coaricontdetail->REF_NUMBER = $reff_number;
                    $coaricontdetail->KD_DOK = 5;
                    $coaricontdetail->KD_TPS = 'AIRN';
                    $coaricontdetail->NM_ANGKUT = (!empty($container->VESSEL) ? $container->VESSEL : 0);
                    $coaricontdetail->NO_VOY_FLIGHT = (!empty($container->VOY) ? $container->VOY : 0);
                    $coaricontdetail->CALL_SIGN = (!empty($container->CALL_SIGN) ? $container->CALL_SIGN : 0);
                    $coaricontdetail->TGL_TIBA = (!empty($container->ETA) ? date('Ymd', strtotime($container->ETA)) : '');
                    $coaricontdetail->KD_GUDANG = $container->LOKASI_GUDANG;
                    $coaricontdetail->NO_CONT = $container->NOCONTAINER;
                    $coaricontdetail->UK_CONT = $container->SIZE;
                    $coaricontdetail->NO_SEGEL = $container->NO_SEAL;
                    $coaricontdetail->JNS_CONT = 'L';
                    $coaricontdetail->NO_BL_AWB = '';
                    $coaricontdetail->TGL_BL_AWB = '';
                    $coaricontdetail->NO_MASTER_BL_AWB = $container->NOMBL;
                    $coaricontdetail->TGL_MASTER_BL_AWB = (!empty($container->TGL_MASTER_BL) ? date('Ymd', strtotime($container->TGL_MASTER_BL)) : '');
                    $coaricontdetail->ID_CONSIGNEE = str_replace(array('.','-'), array(''), $container->ID_CONSOLIDATOR);
                    $coaricontdetail->CONSIGNEE = $container->NAMACONSOLIDATOR;
                    $coaricontdetail->BRUTO = (!empty($container->WEIGHT) ? $container->WEIGHT : 0);
                    $coaricontdetail->NO_BC11 = $container->NO_BC11;
                    $coaricontdetail->TGL_BC11 = (!empty($container->TGL_BC11) ? date('Ymd', strtotime($container->TGL_BC11)) : '');
                    $coaricontdetail->NO_POS_BC11 = '';
                    $coaricontdetail->KD_TIMBUN = 'GD';
                    $coaricontdetail->KD_DOK_INOUT = 3;
                    $coaricontdetail->NO_DOK_INOUT = (!empty($container->NO_PLP) ? $container->NO_PLP : '');
                    $coaricontdetail->TGL_DOK_INOUT = (!empty($container->TGL_PLP) ? date('Ymd', strtotime($container->TGL_PLP)) : '');
                    $coaricontdetail->WK_INOUT = date('Ymd', strtotime($container->TGLMASUK)).date('His', strtotime($container->JAMMASUK));
                    $coaricontdetail->KD_SAR_ANGKUT_INOUT = 1;
                    $coaricontdetail->NO_POL = $container->NOPOL;
                    $coaricontdetail->FL_CONT_KOSONG = 2;
                    $coaricontdetail->ISO_CODE = '';
                    $coaricontdetail->PEL_MUAT = $container->PEL_MUAT;
                    $coaricontdetail->PEL_TRANSIT = $container->PEL_TRANSIT;
                    $coaricontdetail->PEL_BONGKAR = $container->PEL_BONGKAR;
                    $coaricontdetail->GUDANG_TUJUAN = $container->LOKASI_GUDANG;
                    $coaricontdetail->UID = 'Autogate';
                    $coaricontdetail->NOURUT = 1;
                    $coaricontdetail->RESPONSE = '';
                    $coaricontdetail->STATUS_TPS = 1;
                    $coaricontdetail->KODE_KANTOR = '040300';
                    $coaricontdetail->NO_DAFTAR_PABEAN = '';
                    $coaricontdetail->TGL_DAFTAR_PABEAN = '';
                    $coaricontdetail->NO_SEGEL_BC = '';
                    $coaricontdetail->TGL_SEGEL_BC = '';
                    $coaricontdetail->NO_IJIN_TPS = '';
                    $coaricontdetail->TGL_IJIN_TPS = '';
                    $coaricontdetail->RESPONSE_IPC = '';
                    $coaricontdetail->STATUS_TPS_IPC = '';
                    $coaricontdetail->NOPLP = $container->NO_PLP;
                    $coaricontdetail->TGLPLP = (!empty($container->TGL_PLP) ? date('Ymd', strtotime($container->TGL_PLP)) : '');
                    $coaricontdetail->FLAG_REVISI = '';
                    $coaricontdetail->TGL_REVISI = '';
                    $coaricontdetail->TGL_REVISI_UPDATE = '';
                    $coaricontdetail->KD_TPS_ASAL = $container->KD_TPS_ASAL;
                    $coaricontdetail->FLAG_UPD = '';
                    $coaricontdetail->RESPONSE_MAL0 = '';
                    $coaricontdetail->STATUS_TPS_MAL0 = '';
                    $coaricontdetail->TGL_ENTRY = date('Y-m-d');
                    $coaricontdetail->JAM_ENTRY = date('H:i:s');

                    if($coaricontdetail->save()){

                        $container->REF_NUMBER_IN = $reff_number;
                        $container->save();                    
                        
                        // Create XML & Send Tps Online
                        return $coaricont->TPSCOARICONTXML_PK;
//                        return redirect()->route('tps-coariCont-upload', $coaricont->TPSCOARICONTXML_PK);
//                        return json_encode(array('insert_id' => $coaricont->TPSCOARICONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                    }

                }

            } else {
                return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
            }
        }else{
            return 'Something wrong, type not found!';
        }
        
    }
    
    public function uploadTpsOnlineCoariKms($id)
    {
        
    }
    
    public function uploadTpsOnlineCodecoCont($type, $id)
    {
        $container_id = $id;
        if($type == 'Fcl'){
            $container = \App\Models\Containercy::where('TCONTAINER_PK', $container_id)->first();
            // Reff Number
            $reff_number = $this->getReffNumber('Autogate');   
            if($reff_number){
        
                $codecocont = new \App\Models\TpsCodecoContFcl();
                $codecocont->NOJOBORDER = $container->NoJob;
                $codecocont->REF_NUMBER = $reff_number;
                $codecocont->TGL_ENTRY = date('Y-m-d');
                $codecocont->JAM_ENTRY = date('H:i:s');
                $codecocont->UID = 'Autogate';

                if($codecocont->save()){
                    $codecocontdetail = new \App\Models\TpsCodecoContFclDetail;
                    $codecocontdetail->TPSCODECOCONTXML_FK = $codecocont->TPSCODECOCONTXML_PK;
                    $codecocontdetail->REF_NUMBER = $reff_number;
                    $codecocontdetail->NOJOBORDER = $container->NoJob;
                    $codecocontdetail->KD_DOK = 6;
                    $codecocontdetail->KD_TPS = 'AIRN';
                    $codecocontdetail->NM_ANGKUT = (!empty($container->VESSEL) ? $container->VESSEL : 0);
                    $codecocontdetail->NO_VOY_FLIGHT = (!empty($container->VOY) ? $container->VOY : 0);
                    $codecocontdetail->CALL_SIGN = (!empty($container->CALLSIGN) ? $container->CALLSIGN : 0);
                    $codecocontdetail->TGL_TIBA = (!empty($container->ETA) ? date('Ymd', strtotime($container->ETA)) : '');
                    $codecocontdetail->KD_GUDANG = $container->GUDANG_TUJUAN;
                    $codecocontdetail->NO_CONT = $container->NOCONTAINER;
                    $codecocontdetail->UK_CONT = $container->SIZE;
                    $codecocontdetail->NO_SEGEL = $container->NOSEGEL;
                    $codecocontdetail->JNS_CONT = 'F';
                    $codecocontdetail->NO_BL_AWB = '';
                    $codecocontdetail->TGL_BL_AWB = '';
                    $codecocontdetail->NO_MASTER_BL_AWB = $container->NOMBL;
                    $codecocontdetail->TGL_MASTER_BL_AWB = (!empty($container->TGLMBL) ? date('Ymd', strtotime($container->TGLMBL)) : '');
    //                $codecocontdetail->ID_CONSIGNEE = $container->NPWP_IMP;
    //                $codecocontdetail->CONSIGNEE = $container->NAMA_IMP;
                    $codecocontdetail->ID_CONSIGNEE = $container->ID_CONSIGNEE;
                    $codecocontdetail->CONSIGNEE = $container->CONSIGNEE;
                    $codecocontdetail->BRUTO = (($container->WEIGHT > 0) ? $container->WEIGHT : 20000);
                    $codecocontdetail->NO_BC11 = $container->NO_BC11;
                    $codecocontdetail->TGL_BC11 = (!empty($container->TGL_BC11) ? date('Ymd', strtotime($container->TGL_BC11)) : '');
                    $codecocontdetail->NO_POS_BC11 = $container->NO_POS_BC11;
                    $codecocontdetail->KD_TIMBUN = 'LAP';
                    $codecocontdetail->KD_DOK_INOUT = (!empty($container->KD_DOK_INOUT) ? $container->KD_DOK_INOUT : 3);
                    $codecocontdetail->NO_DOK_INOUT = (!empty($container->NO_SPPB) ? $container->NO_SPPB : '');
                    $codecocontdetail->TGL_DOK_INOUT = (!empty($container->TGL_SPPB) ? date('Ymd', strtotime($container->TGL_SPPB)) : '');
                    $codecocontdetail->WK_INOUT = date('Ymd', strtotime($container->TGLRELEASE)).date('His', strtotime($container->JAMRELEASE));
                    $codecocontdetail->KD_SAR_ANGKUT_INOUT = 1;
                    $codecocontdetail->NO_POL = $container->NOPOL_OUT;
                    $codecocontdetail->FL_CONT_KOSONG = 2;
                    $codecocontdetail->ISO_CODE = '';
                    $codecocontdetail->PEL_MUAT = $container->PEL_MUAT;
                    $codecocontdetail->PEL_TRANSIT = $container->PEL_TRANSIT;
                    $codecocontdetail->PEL_BONGKAR = $container->PEL_BONGKAR;
                    $codecocontdetail->GUDANG_TUJUAN = $container->GUDANG_TUJUAN;
                    $codecocontdetail->UID = 'Autogate';
                    $codecocontdetail->NOURUT = 1;
                    $codecocontdetail->RESPONSE = '';
                    $codecocontdetail->STATUS_TPS = 1;
                    $codecocontdetail->KODE_KANTOR = '040300';
                    $codecocontdetail->NO_DAFTAR_PABEAN = (!empty($container->NO_PIB) ? $container->NO_PIB : '');
                    $codecocontdetail->TGL_DAFTAR_PABEAN = (!empty($container->TGL_PIB) ? date('Ymd', strtotime($container->TGL_PIB)) : '');
                    $codecocontdetail->NO_SEGEL_BC = '';
                    $codecocontdetail->TGL_SEGEL_BC = '';
                    $codecocontdetail->NO_IJIN_TPS = '';
                    $codecocontdetail->TGL_IJIN_TPS = '';
                    $codecocontdetail->RESPONSE_IPC = '';
                    $codecocontdetail->STATUS_TPS_IPC = '';
                    $codecocontdetail->NOSPPB = '';
                    $codecocontdetail->TGLSPPB = '';
                    $codecocontdetail->FLAG_REVISI = '';
                    $codecocontdetail->TGL_REVISI = '';
                    $codecocontdetail->TGL_REVISI_UPDATE = '';
                    $codecocontdetail->KD_TPS_ASAL = $container->KD_TPS_ASAL;
                    $codecocontdetail->RESPONSE_MAL0 = '';
                    $codecocontdetail->STATUS_TPS_MAL0 = '';
                    $codecocontdetail->TGL_ENTRY = date('Y-m-d');
                    $codecocontdetail->JAM_ENTRY = date('H:i:s');

                    if($codecocontdetail->save()){

                        $container->REF_NUMBER_OUT = $reff_number;
                        $container->save();
                        
                        return $codecocont->TPSCODECOCONTXML_PK;
                        
//                        return json_encode(array('insert_id' => $codecocont->TPSCODECOCONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
    }
                }
    
            } else {
                return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
            }
        }elseif($type == 'Lcl'){
            $container = \App\Models\Container::where('TCONTAINER_PK', $container_id)->first();
            // Reff Number
            $reff_number = $this->getReffNumber('Autogate');   
            if($reff_number){

                $codecocont = new \App\Models\TpsCodecoContFcl();
                $codecocont->NOJOBORDER = $container->NoJob;
                $codecocont->REF_NUMBER = $reff_number;
                $codecocont->TGL_ENTRY = date('Y-m-d');
                $codecocont->JAM_ENTRY = date('H:i:s');
                $codecocont->UID = 'Autogate';

                if($codecocont->save()){
                    $codecocontdetail = new \App\Models\TpsCodecoContFclDetail;
                    $codecocontdetail->TPSCODECOCONTXML_FK = $codecocont->TPSCODECOCONTXML_PK;
                    $codecocontdetail->REF_NUMBER = $reff_number;
                    $codecocontdetail->NOJOBORDER = $container->NoJob;
                    $codecocontdetail->KD_DOK = 6;
                    $codecocontdetail->KD_TPS = 'AIRN';
                    $codecocontdetail->NM_ANGKUT = (!empty($container->VESSEL) ? $container->VESSEL : 0);
                    $codecocontdetail->NO_VOY_FLIGHT = (!empty($container->VOY) ? $container->VOY : 0);
                    $codecocontdetail->CALL_SIGN = (!empty($container->CALL_SIGN) ? $container->CALL_SIGN : 0);
                    $codecocontdetail->TGL_TIBA = (!empty($container->ETA) ? date('Ymd', strtotime($container->ETA)) : '');
                    $codecocontdetail->KD_GUDANG = $container->LOKASI_GUDANG;
                    $codecocontdetail->NO_CONT = $container->NOCONTAINER;
                    $codecocontdetail->UK_CONT = $container->SIZE;
                    $codecocontdetail->NO_SEGEL = $container->NO_SEAL;
                    $codecocontdetail->JNS_CONT = 'L';
                    $codecocontdetail->NO_BL_AWB = '';
                    $codecocontdetail->TGL_BL_AWB = '';
                    $codecocontdetail->NO_MASTER_BL_AWB = $container->NOMBL;
                    $codecocontdetail->TGL_MASTER_BL_AWB = (!empty($container->TGL_MASTER_BL) ? date('Ymd', strtotime($container->TGL_MASTER_BL)) : '');
                    $codecocontdetail->ID_CONSIGNEE = str_replace(array('.','-'), array(''),$container->ID_CONSOLIDATOR);
                    $codecocontdetail->CONSIGNEE = $container->NAMACONSOLIDATOR;
                    $codecocontdetail->BRUTO = (!empty($container->WEIGHT) ? $container->WEIGHT : 0);
                    $codecocontdetail->NO_BC11 = $container->NO_BC11;
                    $codecocontdetail->TGL_BC11 = (!empty($container->TGL_BC11) ? date('Ymd', strtotime($container->TGL_BC11)) : '');
                    $codecocontdetail->NO_POS_BC11 = '';
                    $codecocontdetail->KD_TIMBUN = 'GD';
                    $codecocontdetail->KD_DOK_INOUT = 40;
                    $codecocontdetail->NO_DOK_INOUT = (!empty($container->NO_PLP) ? $container->NO_PLP : '');
                    $codecocontdetail->TGL_DOK_INOUT = (!empty($container->TGL_PLP) ? date('Ymd', strtotime($container->TGL_PLP)) : '');
                    $codecocontdetail->WK_INOUT = date('Ymd', strtotime($container->TGLBUANGMTY)).date('His', strtotime($container->JAMBUANGMTY));
                    $codecocontdetail->KD_SAR_ANGKUT_INOUT = 1;
                    $codecocontdetail->NO_POL = $container->NOPOL_MTY;
                    $codecocontdetail->FL_CONT_KOSONG = 1;
                    $codecocontdetail->ISO_CODE = '';
                    $codecocontdetail->PEL_MUAT = $container->PEL_MUAT;
                    $codecocontdetail->PEL_TRANSIT = $container->PEL_TRANSIT;
                    $codecocontdetail->PEL_BONGKAR = $container->PEL_BONGKAR;
                    $codecocontdetail->GUDANG_TUJUAN = $container->LOKASI_GUDANG;
                    $codecocontdetail->UID = 'Autogate';
                    $codecocontdetail->NOURUT = 1;
                    $codecocontdetail->RESPONSE = '';
                    $codecocontdetail->STATUS_TPS = '';
                    $codecocontdetail->KODE_KANTOR = '040300';
                    $codecocontdetail->NO_DAFTAR_PABEAN = '';
                    $codecocontdetail->TGL_DAFTAR_PABEAN = '';
                    $codecocontdetail->NO_SEGEL_BC = '';
                    $codecocontdetail->TGL_SEGEL_BC = '';
                    $codecocontdetail->NO_IJIN_TPS = '';
                    $codecocontdetail->TGL_IJIN_TPS = '';
                    $codecocontdetail->RESPONSE_IPC = '';
                    $codecocontdetail->STATUS_TPS_IPC = '';
                    $codecocontdetail->NOSPPB = '';
                    $codecocontdetail->TGLSPPB = '';
                    $codecocontdetail->FLAG_REVISI = '';
                    $codecocontdetail->TGL_REVISI = '';
                    $codecocontdetail->TGL_REVISI_UPDATE = '';
                    $codecocontdetail->KD_TPS_ASAL = $container->KD_TPS_ASAL;
                    $codecocontdetail->RESPONSE_MAL0 = '';
                    $codecocontdetail->STATUS_TPS_MAL0 = '';
                    $codecocontdetail->TGL_ENTRY = date('Y-m-d');
                    $codecocontdetail->JAM_ENTRY = date('H:i:s');

                    if($codecocontdetail->save()){
                        
                        $container->REF_NUMBER_OUT = $reff_number;
                        $container->save();
                        
                        return $codecocont->TPSCODECOCONTXML_PK;
//                        return json_encode(array('insert_id' => $codecocont->TPSCODECOCONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                    }
                }

            } else {
                return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
            }
        }else{
            return 'Something wrong, type not found!';
        }
        
        
    }
    
    public function uploadTpsOnlineCodecoKms()
    {
        
    }
     
	 public function AutoMovementContainer()
    {
        //$cont_id = explode(',', $request->container_id);
        //$tgl1='2023-01-01 18:00:00'; 

        //$tgl1='2023-03-10 16:23:00'; 
	    //$tgl2='2023-03-11 16:00:00'; 
	   //$jam1=  substr($tgl1,0,10);
	   //$jam2=  substr($tgl2,0,10);
	
	   $tgl2=date("Y-m-d H:i:s");
	   $tgl=strtotime($tgl2 . "-1 hours");
	   $tgl1= date('Y-m-d H:i:s',$tgl);	
		
	      
		 
		$containers = \App\Models\Containercy::select('tcontainercy.*','barcode_autogate.*')
               ->join('barcode_autogate','tcontainercy.TCONTAINER_PK','=','barcode_autogate.ref_id')
               ->where('barcode_autogate.ref_action', 'get')                
			   ->where('tcontainercy.KD_TPS_ASAL', 'NCT1')
               ->where('barcode_autogate.time_in','>=',$tgl1)
               ->where('barcode_autogate.time_in','<',$tgl2)
			 //   ->wherein('tcontainercy.NOCONTAINER',['DRYU9208045',	'FCIU4746929',	'FTAU1321875',	'GCXU2269584',	'KKTU8212713',	'MRSU6363720',	'MSKU0287072',	'NYKU3533888',	'NYKU3812671',	'NYKU9893217',	'TCLU2223871',	'TCLU5567438',	'TCLU6482037',	'TCLU6517529',	'TCLU6636913',	'TEMU5774520',	'TRHU2990283',	'TRHU4190340',	'TRHU7237673',	'TRLU9269277',	'XINU8041429'])     
 	 	       ->get();

        
	
        foreach ($containers as $container):
            // IN2
            $data[] = array(
                'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->GUDANG_TUJUAN,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'IN2',
                'action_time' => date('YmdHis', strtotime($container->TGLMASUK.' '.$container->JAMMASUK)),
                'uid' => 'System'
            );        
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		$containers = \App\Models\Containercy::select('*')
                ->join('barcode_autogate','tcontainercy.TCONTAINER_PK','=','barcode_autogate.ref_id')
                ->where('barcode_autogate.ref_action', 'release')  
				->where('tcontainercy.KD_TPS_ASAL', 'NCT1')
                ->where('barcode_autogate.time_out','>=',$tgl1)
               ->where('barcode_autogate.time_out','<',$tgl2)
		//		->wherein('tcontainercy.NOCONTAINER',['DRYU9208045',	'FCIU4746929',	'FTAU1321875',	'GCXU2269584',	'KKTU8212713',	'MRSU6363720',	'MSKU0287072',	'NYKU3533888',	'NYKU3812671',	'NYKU9893217',	'TCLU2223871',	'TCLU5567438',	'TCLU6482037',	'TCLU6517529',	'TCLU6636913',	'TEMU5774520',	'TRHU2990283',	'TRHU4190340',	'TRHU7237673',	'TRLU9269277',	'XINU8041429'])     
                ->get();
		
        
		foreach ($containers as $container):
          
            // OUT2
           $data[] = array(
               'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->GUDANG_TUJUAN,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'OUT2',
                'action_time' => date('YmdHis', strtotime($container->TGLRELEASE.' '.$container->JAMRELEASE)),
                'uid' => 'System'
            );
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		
//        return $data;
        
       return json_encode(array('success' => true, 'message' => 'Movement has been created.'));
        
       return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }
	
	
	 public function ManualMovementContainer()
    {
        //$cont_id = explode(',', $request->container_id);
     //   $tgl1='2023-01-01'; 
      //  $tgl2='2023-09-22';
        
		
	   $tgl1='2024-01-07 08:00:00'; 
	    $tgl2='2024-01-26 08:00:00'; 
	   
	   //$jam1=  substr($tgl1,0,10);
	   //$jam2=  substr($tgl2,0,10);
	
	   //$tgl2=date("Y-m-d H:i:s");
	   //$tgl=strtotime($tgl2 . "-1 hours");
	   //$tgl1= date('Y-m-d H:i:s',$tgl);	
		
	      
		 
		$containers = \App\Models\Containercy::select('tcontainercy.*','barcode_autogate.*')
               ->join('barcode_autogate','tcontainercy.TCONTAINER_PK','=','barcode_autogate.ref_id')
               ->where('barcode_autogate.ref_action', 'get')                
			   ->where('tcontainercy.KD_TPS_ASAL', 'NCT1')
               ->where('tcontainercy.TGLMASUK','>=',$tgl1)
               ->where('tcontainercy.TGLMASUK','<',$tgl2)
			  // ->where('barcode_autogate.time_in','>=',$tgl1)
              // ->where('barcode_autogate.time_in','<',$tgl2)
			 //->wherein('tcontainercy.NOCONTAINER',['BSIU3263179',	'CAIU2387890',	'CAIU6643182',	'CXDU1632986',	'CXDU2268945',	'CXTU1152931',	'DRYU2711660',	'DRYU2858075',	'EGHU3321650',	'EGHU3415071',	'EGHU3828218',	'EGHU9219190',	'EGSU3120006',	'EISU2271629',	'EITU3039669',	'EOLU8232226',	'EOLU8243513',	'EOLU8247268',	'EOLU8604982',	'EURU1173628',	'FCIU4467652',	'FCIU6294279',	'GATU1155161',	'GCXU2289615',	'GESU8092604',	'HAMU1053930',	'KKFU7836346',	'KKTU6060210',	'KKTU7731416',	'KKTU7784972',	'MRKU7342436',	'MRKU8938100',	'MSKU0908842',	'MSKU1952243',	'NYKU3783085',	'PONU0072259',	'SEGU1345454',	'SEGU4350650',	'SEGU5853999',	'SEGU8048479',	'STJU2021866',	'SZLU9230394',	'TCLU2886600',	'TCLU3289092',	'TCLU7557110',	'TEMU7712635',	'TGBU5205457',	'TGBU9981335',	'TGHU3326045',	'TLLU5424667',	'TRHU1197927',	'TRHU2442398',	'TRHU2481202',	'TRHU6131558',	'TRLU9063136',	'UACU4105373',	'UACU8490410',	'UETU4132964'])     
 	 	       ->get();

        
	
        foreach ($containers as $container):
            // IN2
            $data[] = array(
                'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->GUDANG_TUJUAN,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'IN2',
                'action_time' => date('YmdHis', strtotime($container->TGLMASUK.' '.$container->JAMMASUK)),
                'uid' => 'System'
            );        
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		$containers = \App\Models\Containercy::select('*')
                ->join('barcode_autogate','tcontainercy.TCONTAINER_PK','=','barcode_autogate.ref_id')
                ->where('barcode_autogate.ref_action', 'release')  
				->where('tcontainercy.KD_TPS_ASAL', 'NCT1')
                ->where('barcode_autogate.time_out','>=',$tgl1)
               ->where('barcode_autogate.time_out','<',$tgl2)
			  //  ->wherein('tcontainercy.NOCONTAINER',['BEAU5752498',	'BSIU3263179',	'CAIU2387890',	'CAIU2462397',	'CAIU6643182',	'CXDU1632986',	'DRYU2573703',	'DRYU2711660',	'DRYU2858075',	'DRYU2984108',	'EGHU3357972',	'EGHU3732420',	'EITU0309837',	'EITU0553550',	'EMCU5806758',	'EMCU5808112',	'EMCU6214537',	'EOLU8270308',	'EOLU8604982',	'EURU1173628',	'FCIU6294279',	'GATU1155161',	'GCXU2289615',	'GLDU9409562',	'HAMU1053930',	'HASU1186030',	'HASU1240620',	'HASU1315570',	'HMCU3090707',	'ISLU2203129',	'ISLU2204059',	'ISLU2206350',	'ISLU2206771',	'KKFU8021749',	'KKTU6060210',	'KKTU7731416',	'KKTU8102608',	'MAGU2467133',	'MNBU4007814',	'MNBU9068854',	'MRKU7966474',	'MRKU7991862',	'MRKU8410704',	'MRKU9167332',	'MRKU9311326',	'MRKU9650124',	'MRSU0113641',	'MRSU3737180',	'MSKU2660800',	'MSKU3574899',	'MSKU3907650',	'MSKU4219409',	'MSKU5173323',	'MSKU5636069',	'MSKU5915680',	'MSKU7255293',	'MSKU7269430',	'MSKU7596068',	'MSKU7686201',	'SEGU5853999',	'STJU2021866',	'SUDU7453219',	'SUDU7787983',	'SUDU8980739',	'SZLU9230394',	'TAHU9080450',	'TAHU9081775',	'TAHU9084497',	'TAHU9085750',	'TCLU2374815',	'TCLU2886600',	'TCLU3289092',	'TCLU3507609',	'TCLU3622958',	'TCLU7388982',	'TCLU7557110',	'TCLU8048082',	'TCNU1723360',	'TCNU2624275',	'TCNU3863253',	'TEMU5391515',	'TEMU7132283',	'TGBU5205457',	'TGBU9981335',	'TGHU1752210',	'TGHU3326045',	'TRHU1197927',	'TRHU1197927',	'TRHU2442398',	'TRLU9258605',	'TTNU1284105',	'TTNU4259240',	'UACU4105373',	'UACU8490410',	'UETU4132964'])     
                ->get();
		
        
		foreach ($containers as $container):
          
            // OUT2
           $data[] = array(
               'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->GUDANG_TUJUAN,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'OUT2',
                'action_time' => date('YmdHis', strtotime($container->TGLRELEASE.' '.$container->JAMRELEASE)),
                'uid' => 'System'
            );
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		
//        return $data;
        
       return json_encode(array('success' => true, 'message' => 'Movement has been created.'));
        
       return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }
	
	 public function ManualMovementContainerLCL()
    {
        //$cont_id = explode(',', $request->container_id);
       //$tgl1='2023-01-01 00:00:00'; 
       //$tgl2='2023-09-22 11:15:00';
        
		
	    $tgl1='2024-01-07 08:00:00'; 
	    $tgl2='2024-01-26 08:00:00'; 
		
	   //$jam1=  substr($tgl1,0,10);
	   //$jam2=  substr($tgl2,0,10);
	
	   //$tgl2=date("Y-m-d H:i:s");
	   //$tgl=strtotime($tgl2 . "-1 hours");
	   //$tgl1= date('Y-m-d H:i:s',$tgl);	
		
	      
		 
		$containers = \App\Models\Container::select('tcontainer.*','barcode_autogate.*')
               ->join('barcode_autogate','tcontainer.TCONTAINER_PK','=','barcode_autogate.ref_id')
               ->where('barcode_autogate.ref_action', 'get')                
			   ->where('tcontainer.KD_TPS_ASAL', 'NCT1')
			   // ->where('tcontainer.TGLMASUK','>=',$tgl1)
               //->where('tcontainer.TGLMASUK','<',$tgl2)
               ->where('barcode_autogate.time_in','>=',$tgl1)
               ->where('barcode_autogate.time_in','<',$tgl2)
			// ->wherein('tcontainer.NOCONTAINER',['TRHU6131558',	'MRKU7342436'])     
 	 	       ->get();

        
	
        foreach ($containers as $container):
            // IN2
            $data[] = array(
                'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->LOKASI_GUDANG,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'IN2',
                'action_time' => date('YmdHis', strtotime($container->TGLMASUK.' '.$container->JAMMASUK)),
                'uid' => 'System'
            );        
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		$containers = \App\Models\Container::select('*')
                ->join('barcode_autogate','tcontainer.TCONTAINER_PK','=','barcode_autogate.ref_id')
                ->where('barcode_autogate.ref_action', 'empty')  
				->where('tcontainer.KD_TPS_ASAL', 'NCT1')
                ->where('barcode_autogate.time_out','>=',$tgl1)
               ->where('barcode_autogate.time_out','<',$tgl2)
			//->wherein('tcontainercy.NOCONTAINER',['AXIU1644920',	'BEAU2176336',	'BMOU1436921',	'CAIU4091530',	'CAIU8880990',	'CXDU1584574',	'EGSU9086676',	'EISU1840736',	'EISU2292600',	'EITU0344036',	'EMCU6232910',	'EOLU8272450',	'FCGU2247950',	'FCLU9407769',	'FDCU0444854',	'FDCU0590519',	'FFAU1199820',	'FFAU3633704',	'FSCU8616408',	'FTAU1596189',	'GLDU9546760',	'GLDU9763391',	'HLBU2351159',	'HLBU9660566',	'HLXU1344640',	'HLXU8108272',	'KKFU7850489',	'KKTU8050989',	'LTIU6040735',	'MCRU2037189',	'MCRU2054421',	'MCRU9009975',	'MNBU0540091',	'MNBU3195126',	'MNBU3407586',	'MNBU9021570',	'MNBU9131999',	'MNBU9138566',	'MOFU0608449',	'MOFU1423460',	'MRKU0185171',	'MRKU0581439',	'MRKU4817456',	'MRKU4876870',	'MRKU6525411',	'MRKU7154850',	'MRKU7495456',	'MRKU8586186',	'MRKU8652420',	'MRKU9422166',	'MRSU3894830',	'MRSU4163635',	'MSKU3725526',	'MSKU5701462',	'MSKU6956370',	'MWCU5305760',	'MWCU5305760',	'NIDU2197918',	'NYKU3697562',	'NYKU4262306',	'NYKU4701986',	'NYKU4893404',	'NYKU5206610',	'SEGU1042972',	'SEGU5072511',	'SUDU9204529',	'SZLU2065338',	'TCLU1815351',	'TCLU1830588',	'TCLU1914077',	'TCLU2420715',	'TCLU3360586',	'TCLU3427972',	'TCLU3798572',	'TCLU7205530',	'TCNU6861167',	'TEMU0176187',	'TEMU0176187',	'TEMU9840677',	'TGCU0026621',	'TRHU7896639',	'UACU8277220'])     
                ->get();
		
        
		foreach ($containers as $container):
          
            // OUT2
           $data[] = array(
               'request_no' => $container->NO_PLP,
                'request_date' => date('Ymd', strtotime($container->TGL_PLP)),
                'warehouse_code' => $container->LOKASI_GUDANG,
                'container_id' => $container->TCONTAINER_PK,
                'container_no' => $container->NOCONTAINER,
                'message_type' => 'OUT2',
                'action_time' => date('YmdHis', strtotime($container->TGLRELEASE.' '.$container->JAMRELEASE)),
                'uid' => 'System'
            );
            
            \App\Models\NpctMovement::insert($data);   
            
            $data = array();
        endforeach;
        
		
		
//        return $data;
        
       return json_encode(array('success' => true, 'message' => 'Movement has been created.'));
        
       return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }
	
	
		
	
	
	
    public function AutomovementUpload()
    {
        $this->wsdl = 'https://api.npct1.co.id/services/index.php/Line2?wsdl';
        $this->user = 'lini2';
        $this->password = 'lini2@2018';
        $this->kode = 'AIRN';
		
		$tgl2=date("Y-m-d H:i:s");
		$tgl=strtotime($tgl2 . "-2 hours");
	    $tgl1= date('Y-m-d H:i:s',$tgl);	
		
		$movements = \App\Models\NpctMovement::where('response',null)->where('created_at','>=', $tgl1)->get();
        //$movements = \App\Models\NpctMovement::where('container_no','KKFU8046536')->get();
		$xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><movement></movement>');       
        $move_id = array();
        foreach ($movements as $move):
            $move_id[]= $move->id;
            $data = $xml->addchild('loop');
            $data->addchild('action', 'CREATE');
            $data->addchild('request_no', $move->request_no);
            $data->addchild('request_date', $move->request_date);
            $data->addchild('warehouse_code', $move->warehouse_code);
            $data->addchild('container_no', $move->container_no);
            $data->addchild('message_type', $move->message_type);
            $data->addchild('action_time', $move->action_time);
            
        endforeach;
        
//        $response = \Response::make($xml->asXML(), 200);
        
//        return $response;
        
        \SoapWrapper::add(function ($service) {
            $service
                ->name('movementRequest')
                ->wsdl($this->wsdl)
                ->trace(true)                                                                                                                                                 
                ->cache(WSDL_CACHE_NONE)                                        
                ->options([
                    'stream_context' => stream_context_create([
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    ]),
                    'soap_version' => SOAP_1_1
                ]);                                                    
        });
        
        $reqData = [
            'username' => $this->user, 
            'Password' => $this->password,
            'data' => $xml->asXML()
        ];
        
        // Using the added service
        try {      
            \SoapWrapper::service('movementRequest', function ($service) use ($reqData) {    
    //            var_dump($service->getFunctions());
//                var_dump($service->call('movement', $reqData));
                $this->response = $service->call('movement', $reqData);      
            });
        } catch (SoapFault $exception) {
            echo $exception;      
        }
        
        $update = \App\Models\NpctMovement::whereIn('id', $move_id)->update(['action' => 'CREATE','response' => $this->response]);       
        
        if ($update){
//            return back()->with('success', 'Laporan Movement berhasil dikirim.');
            return json_encode(array('success' => true, 'message' => 'Laporan Movement berhasil dikirim.'));
        }
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        var_dump($this->response);
    }

	public function print_export($id)
    {
        $barcodes = DBGate::where('id', $id)->get();

        // dd($barcode);
        return view('print.barcode', compact('barcodes'));
    }
	
}


