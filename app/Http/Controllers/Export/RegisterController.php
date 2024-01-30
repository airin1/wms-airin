<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Models\JoborderExp as DBJoborder;
use App\Models\Consolidator as DBConsolidator;
use App\Models\ConsolidatorTarif as DBConsolidatorTarif;
use App\Models\Perusahaan as DBPerusahaan;
use App\Models\Negara as DBNegara;
use App\Models\Pelabuhan as DBPelabuhan;
use App\Models\Vessel as DBVessel;
use App\Models\Shippingline as DBShippingline;
use App\Models\Lokasisandar as DBLokasisandar;
use App\Models\ContainerExp as DBContainer;
use App\Models\Eseal as DBEseal;
use App\Models\Depomty as DBDepomty;
use App\Models\Manifest as DBManifest;
use App\Models\Barcode as DBGate;

use App\Models\TpsCoariCont as DBCoari;
use App\Models\TpsCoariContDetail as DBCoariDetail;


class RegisterController extends Controller
{
    public function registerIndex()
    {
        if ( !$this->access->can('show.exp.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Export Register', 'slug' => 'show.exp.register.index', 'description' => ''));
        
        $data['page_title'] = "Export Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Register'
            ]
        ];        
        // $view = DBJoborder::orderBy('TGL_BOOKING', 'desc')->get();

        $view = DBJoborder::leftJoin('tcontainereks', 'tjobordereks.TJOBORDER_PK', '=', 'tcontainereks.TJOBORDER_FK')
        ->orderBy('tjobordereks.TGL_BOOKING', 'desc')
        ->select('tjobordereks.*', 'tcontainereks.TCONTAINER_PK AS CONTAINER_ID', 'tcontainereks.NOCONTAINER')
        ->get();

        
        return view('export.register.main', compact('view'))->with($data);
    }
    public function registerCreate()
    {
        if ( !$this->access->can('show.lcl.register.create') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Create LCL Register', 'slug' => 'show.lcl.register.create', 'description' => ''));
        
        $data['page_title'] = "Create EXPORT Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('lcl-register-index'),
                'title' => 'Export Register'
            ],
            [
                'action' => '',
                'title' => 'Create'
            ]
        ]; 
        
        $spk_last_id = DBJoborder::select('TJOBORDER_PK as id')->orderBy('TJOBORDER_PK', 'DESC')->first();  
//        $spk_last_id = $this->getSpkNumber();
        $regID = str_pad(intval((isset($spk_last_id->id) ? $spk_last_id->id : 0)+1), 4, '0', STR_PAD_LEFT);
        
        $data['spk_number'] = 'AIRNG'.$regID.'/'.date('y');
        $data['consolidators'] = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        $data['countries'] = DBNegara::select('TNEGARA_PK as id','NAMANEGARA as name')->get();
        $data['pelabuhans'] = array();
//        $data['pelabuhans'] = DBPelabuhan::select('TPELABUHAN_PK as id','NAMAPELABUHAN as name','KODEPELABUHAN as code')->limit(300)->get();
        $data['vessels'] = DBVessel::select('tvessel_pk as id','vesselname as name','vesselcode as code','callsign')->get();
        $data['shippinglines'] = DBShippingline::select('TSHIPPINGLINE_PK as id','SHIPPINGLINE as name')->get();
        $data['lokasisandars'] = DBLokasisandar::select('TLOKASISANDAR_PK as id','NAMALOKASISANDAR as name')->get();

       
        
        return view('export.register.create')->with($data);
    }

    public function registerStore(Request $request)
    {
        
        if ( !$this->access->can('store.lcl.register.create') ) {
            return view('errors.no-access');
        }
        
        $validator = \Validator::make($request->all(), [
            'NOJOBORDER' => 'required|unique:tjobordereks',
            'NOBOOKING' => 'required|unique:tjobordereks',
            'TGL_BOOKING' => 'required',
//            'TCONSOLIDATOR_FK' => 'required',
//            'PARTY' => 'required',
//            'TNEGARA_FK' => 'required',
//            'TPELABUHAN_FK' => 'required',
//            'VESSEL' => 'required',
//            'VOY' => 'required',
//            'CALLSIGN' => 'required',
//            'ETA' => 'required',
//            'ETD' => 'required',
//            'TLOKASISANDAR_FK' => 'required',
//            'KODE_GUDANG' => 'required',
//            'GUDANG_TUJUAN' => 'required',
//            'JENISKEGIATAN' => 'required',
//            'GROSSWEIGHT' => 'required',
//            'JUMLAHHBL' => 'required',
//            'MEASUREMENT' => 'required',
//            'ISO_CODE' => 'required',
//            'PEL_MUAT' => 'required',
//            'PEL_TRANSIT' => 'required',
//            'PEL_BONGKAR' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $data = $request->except(['_token']); 
        $data['TGLENTRY'] = date('Y-m-d');
        $data['TGL_BOOKING'] = (!empty($data['TGL_BOOKING']) ? date('Y-m-d', strtotime($data['TGL_BOOKING'])) : null);
        $data['ETA'] = (!empty($data['ETA']) ? date('Y-m-d', strtotime($data['ETA'])) : null );
        $data['ETD'] = (!empty($data['ETD']) ? date('Y-m-d', strtotime($data['ETD'])) : null );
        $data['TTGL_BC11'] = (!empty($data['TTGL_BC11']) ? date('Y-m-d', strtotime($data['TTGL_BC11'])) : null );
        $data['TTGL_PLP'] = (!empty($data['TTGL_PLP']) ? date('Y-m-d', strtotime($data['TTGL_PLP'])) : null );
        $namaconsolidator = DBConsolidator::select('NAMACONSOLIDATOR','NPWP')->where('TCONSOLIDATOR_PK',$data['TCONSOLIDATOR_FK'])->first();
        $data['NAMACONSOLIDATOR'] = $namaconsolidator->NAMACONSOLIDATOR;
        $data['ID_CONSOLIDATOR'] = str_replace(array('.','-'),array('',''),$namaconsolidator->NPWP);
        $namanegara = DBNegara::select('NAMANEGARA')->where('TNEGARA_PK',$data['TNEGARA_FK'])->first();
        if($namanegara){
            $data['NAMANEGARA'] = $namanegara->NAMANEGARA;
        }
        $namapelabuhan = DBPelabuhan::select('NAMAPELABUHAN')->where('TPELABUHAN_PK',$data['TPELABUHAN_FK'])->first();
        if($namapelabuhan){
            $data['NAMAPELABUHAN'] = $namapelabuhan->NAMAPELABUHAN;
        } 
        $namalokasisandar = DBLokasisandar::select('NAMALOKASISANDAR','KD_TPS_ASAL')->where('TLOKASISANDAR_PK',$data['TLOKASISANDAR_FK'])->first();
        if($namalokasisandar){
            $data['NAMALOKASISANDAR'] = $namalokasisandar->NAMALOKASISANDAR;
            $data['KD_TPS_ASAL'] = $namalokasisandar->KD_TPS_ASAL;
        }
        if($data['TSHIPPINGLINE_FK']){
            $namashippingline = DBShippingline::select('SHIPPINGLINE')->where('TSHIPPINGLINE_PK',$data['TSHIPPINGLINE_FK'])->first();
            $data['SHIPPINGLINE'] = $namashippingline->SHIPPINGLINE;
        }
        $data['UID'] = \Auth::getUser()->name;
        
        $insert_id = DBJoborder::insertGetId($data);
        
        if($insert_id){
            
            // COPY JOBORDER
            $joborder = DBJoborder::findOrFail($insert_id);
            
            $data = array();
            
            $data['TJOBORDER_FK'] = $joborder->TJOBORDER_PK;
            $data['NoJob'] = $joborder->NOJOBORDER;
            $data['NOSPK'] = $joborder->NOSPK;
            $data['NO_BC11'] = $joborder->TNO_BC11;
            $data['TGL_BC11'] = $joborder->TTGL_BC11;
            $data['NO_PLP'] = $joborder->NO_PLP;
            $data['TGL_PLP'] = $joborder->TGL_PLP;
            $data['TCONSOLIDATOR_FK'] = $joborder->TCONSOLIDATOR_FK;
            $data['NAMACONSOLIDATOR'] = $joborder->NAMACONSOLIDATOR;
            $data['TLOKASISANDAR_FK'] = $joborder->TLOKASISANDAR_FK;
            $data['ETA'] = $joborder->ETA;
            $data['ETD'] = $joborder->ETD;
            $data['VESSEL'] = $joborder->VESSEL;
            $data['VOY'] = $joborder->VOY;
            $data['TPELABUHAN_FK'] = $joborder->TPELABUHAN_FK;
            $data['NAMAPELABUHAN'] = $joborder->NAMAPELABUHAN;
            $data['PEL_MUAT'] = $joborder->PEL_MUAT;
            $data['PEL_BONGKAR'] = $joborder->PEL_BONGKAR;
            $data['PEL_TRANSIT'] = $joborder->PEL_TRANSIT;
            $data['NOBOOKING'] = $joborder->NOBOOKING;
            $data['TGL_BOOKING'] = $joborder->TGL_BOOKING;
            $data['KD_TPS_ASAL'] = $joborder->KD_TPS_ASAL;
            $data['KD_TPS_TUJUAN'] = 'AIRN';
            $data['LOKASI_GUDANG'] = $joborder->GUDANG_TUJUAN;
         
            
            // dd($data);

            
            return redirect()->route('exp-register-edit', ['id' => $insert_id])->with('success', 'Export Register has been added.');
        }
        
        return back()->withInput();
    }

    public function barcode(Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont) {
            $gate = DBGate::where('ref_id', $id)->where('ref_type', 'LCLEKS')->where('ref_action', 'get')->first();
            $today = time();
            
            if (!$gate) {
                $today = time(); // Mendapatkan waktu saat ini dalam format UNIX timestamp
                $expired = date('Y-m-d', strtotime('+3 days', $today));

                $gate = DBGate::create([
                    'ref_type'=> 'LCLEKS',
                    'ref_id'=>$id ,
                    'ref_action'=> 'get',
                    'ref_number' => $cont->NOCONTAINER,
                    'expired' => $expired,
                    'status' => 'active',
                    'barcode'=> str_random(20),
                    'UID' => \Auth::getUser()->name,
                ]);
            }elseif ($gate->expired > $today && $gate->time_in == NULL) {
                $today = time();
                $expired = date('Y-m-d', strtotime('+3 days', $today));
                $gate->update([
                    'expired' => $expired,
                ]);
            }
            return response()->json(['success' => true, 'message' => '', 'barcode' => $gate]);
            
        }else {
            return response()->json(['success' => false, 'message' => 'Data Container Belum Tersedia']);
        }        
    }

    public function registerEdit($id)
    {
        if ( !$this->access->can('show.lcl.register.edit') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Edit Export Register', 'slug' => 'show.lcl.register.edit', 'description' => ''));
        
        $data['page_title'] = "Edit Export Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('lcl-register-index'),
                'title' => 'LCL Register'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];
        
        $data['consolidators'] = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        $data['countries'] = DBNegara::select('TNEGARA_PK as id','NAMANEGARA as name')->get();
        $data['pelabuhans'] = array();
//        $data['pelabuhans'] = DBPelabuhan::select('TPELABUHAN_PK as id','NAMAPELABUHAN as name','KODEPELABUHAN as code')->limit(300)->get();
        $data['vessels'] = DBVessel::select('tvessel_pk as id','vesselname as name','vesselcode as code','callsign')->get();
        $data['shippinglines'] = DBShippingline::select('TSHIPPINGLINE_PK as id','SHIPPINGLINE as name')->get();
        $data['lokasisandars'] = DBLokasisandar::select('TLOKASISANDAR_PK as id','NAMALOKASISANDAR as name')->get();
        
        // $jobid = DBContainer::select('TJOBORDER_FK as id')->where('TCONTAINER_PK',$id)->first();
        
        $data['joborder'] = DBJoborder::where('TJOBORDER_PK', $id)->first();
        // dd($data);

        $data['jmlhCont'] = DBContainer::where('TJOBORDER_FK', $id)->count();

        $data['conts'] = DBContainer::where('TJOBORDER_FK', $id)->get();
        
        return view('export.register.edit')->with($data);
    }

    public function registerUpdate($id, Request $request)
    {
        $update = DBJoborder::where('TJOBORDER_PK', $id)->first();
        if ($update) {
            $update->update([
                'NoJob' => $request->NOJOBORDER,
                'NOSPK' => $request->NOSPK,
                'NO_BC11' => $request->TNO_BC11,
                'TGL_BC11' => $request->TTGL_BC11,
                'NO_PLP' => $request->NO_PLP,
                'TGL_PLP' => $request->TGL_PLP,
                'TCONSOLIDATOR_FK' => $request->TCONSOLIDATOR_FK,
                'NAMACONSOLIDATOR' => $request->NAMACONSOLIDATOR,
                'TLOKASISANDAR_FK' => $request->TLOKASISANDAR_FK,
                'ETA' => $request->ETA,
                'ETD' => $request->ETD,
                'VESSEL' => $request->VESSEL,
                'VOY' => $request->VOY,
                'TPELABUHAN_FK' => $request->TPELABUHAN_FK,
                'NAMAPELABUHAN' => $request->NAMAPELABUHAN,
                'PEL_MUAT' => $request->PEL_MUAT,
                'PEL_BONGKAR' => $request->PEL_BONGKAR,
                'PEL_TRANSIT' => $request->PEL_TRANSIT,
                'NOBOOKING' => $request->NOBOOKING,
                'TGL_BOOKING' => $request->TGL_BOOKING,
                'KD_TPS_ASAL' => "ARN1",
                'LOKASI_GUDANG' =>$request->GUDANG_TUJUAN,
                'KD_TPS_TUJUAN' =>$request->KD_GUDANG ,
                'CALL_SIGN' => $request->CALLSIGN,
                'JUMLAHHBL' => $request->JUMLAHHBL,
            ]);
            return back()->with('success', 'Export Register has been Update.');
        }
        else {
            return back()->with('error', 'Somethings Wrong.');
        }
    }
    
    public function containerManual(Request $request)
    {
        $id = $request->id;

        $size = $request->SIZE;
        if ($size == '20') {
            $TEUS = '1';
        }else {
            $TEUS = '2';
        }

        $job = DBJoborder::where('TJOBORDER_PK', $id)->first();
        if ($job) {

            $waktuSekarang = time(); // Mendapatkan timestamp sekarang

            // Format waktu untuk kolom 'TGLENTRY' dan 'JAMENTRY'
            $tglEntry = date('Y-m-d H:i:s', $waktuSekarang); // Format tanggal (YYYY-MM-DD)
            $jamEntry = date('H:i:s', $waktuSekarang); // Format jam (HH:MM:SS)
            $name = \Auth::getUser()->name;
            $cont = DBContainer::create([
                'NOCONTAINER' =>$request->NOCONTAINER,
                'SIZE' =>$request->SIZE,
                'MEAS'=>$request->MEAS,
                'CTR_STATUS' =>$request->CTR_STATUS,
                'TEUS' =>$TEUS,
                'WEIGHT' =>$request->WEIGHT,
                'NO_SEAL' =>$request->NO_SEAL,
                'TJOBORDER_FK' =>$request->id,
                'NoJob' =>$job->NOJOBORDER,
                'NOSPK' =>$job->NOSPK,
                'TCONSOLIDATOR_FK' =>$job->TCONSOLIDATOR_FK,
                'NAMACONSOLIDATOR' =>$job->NAMACONSOLIDATOR,
                'TLOKASISANDAR_FK' =>$job->TLOKASISANDAR_FK,
                'ETA' =>$job->ETA,
                'ETD' =>$job->ETD,
                'VESSEL' =>$job->VESSEL,
                'VOY' =>$job->VOY,
                'TPELABUHAN_FK' =>$job->TPELABUHAN_FK,
                'NAMAPELABUHAN' =>$job->NAMAPELABUHAN,
                'PEL_MUAT' =>$job->PEL_MUAT,
                'PEL_BONGKAR' =>$job->PEL_BONGKAR,
                'PEL_TRANSIT' =>$job->PEL_TRANSIT,
                'NOBOOKING' =>$job->NOBOOKING,
                'TGL_BOOKING' =>$job->TGL_BOOKING,
                'KD_TPS_ASAL' =>$job->KD_TPS_ASAL,
                'KD_TPS_TUJUAN' =>$job->KD_TPS_TUJUAN,
                'LOKASI_GUDANG' =>$job->LOKASI_GUDANG,
                'CALL_SIGN' =>$job->CALL_SIGN,
                'UID' => \Auth::getUser()->name,
                'TGLENTRY' => $tglEntry,
                'JAMENTRY' => $jamEntry,
 
            ]);
            // dd($cont);

            return back()->with('success', 'Container has been added.');
        }
        else {
            return back()->with('eror', 'Something Wrong');
        }
    }

    public function containerEdit($id, Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont) {
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'cont'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak Ditemukan']);
        }
    }

    public function updateContainer(Request $request)
    {
        $id = $request->TCONTAINER_PK;

        $size = $request->SIZE;
        if ($size == '20') {
            $TEUS = '1';
        }else {
            $TEUS = '2';
        }
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();
        if ($cont) {
            $cont->update([
                'NOCONTAINER' =>$request->NOCONTAINER,
                'TCONTAINER_PK' =>$request->TCONTAINER_PK,
                'SIZE' =>$request->SIZE,
                'WEIGHT' =>$request->WEIGHT,
                'NO_SEAL' =>$request->NO_SEAL,
                'MEAS' =>$request->MEAS,
                'CTR_STATUS' =>$request->CTR_STATUS,
                'TEUS'=>$TEUS,
            ]);
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'cont'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak Ditemukan']);
        }

    }

    public function deleteContainer(Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();
        if ($cont) {
            $cont->delete();
            return response()->json(['success' => true, 'message' => 'Sukses Menghapus']);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak Ditemukan']);
            
        }
    }



    // gate
    public function gateIn()
    {
        if ( !$this->access->can('show.exp.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Export Register', 'slug' => 'show.exp.register.index', 'description' => ''));
        
        $data['page_title'] = "Export || Gate In Container";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Gate In Container'
            ]
        ];        

        $data['gate'] = DBGate::where('ref_type', 'LCLEKS')->where('time_out', NULL)->get();

        return view('export.register.gate-in')->with($data);
    }

    public function gateInApprove($id, Request $request)
    {
        $id = $request->id;
        $gate =  DBGate::where('id', $id)->first();
        if ($gate) {
            $gate->update([

            ]);
            $cont = DBContainer::where('TCONTAINER_PK', $gate->ref_id)->first();
            if ($cont) {
                # code...
            }else {
                return response()->json(['success' => false, 'message' => 'Data Tidak ditemukan']);
            }
            
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$gate, 'cont'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak ditemukan']);
        }

    }

    public function gateInApprovePost(Request $request)
    {
        $idCont = $request->idCont;
        $idGATE = $request->idGate;

        $masuk = $request->TGLMASUK;

        $pol = $request->NOPOL_MASUK;
        // var_dump($idGATE);
        // die();
        $gate = DBGate::where('id', $idGATE)->first();

        if ($gate->expired >= $masuk) {
            $cont = DBContainer::where('TCONTAINER_PK', $idCont)->first();
            if ($cont) {
                $cont->update([
                    'status_bc' => 'HOLD',
                    'TGLMASUK' => $request->TGLMASUK,
                    'JAMMASUK' => $request->JAMMASUK,
                    'NOPOL_MASUK' => $pol,
                    'UIDMASUK' => $request->UIDMASUK,
                    'WEIGHT' => $request->WEIGHT,
                ]);
            //     $gate = DBGate::where('id', $idCont)->first();
            //    $gate->update([
            //     'time_in' => $request->TGLMASUK,
            //    ]);

            // var_dump($gate, $cont);
            // die();
               return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$gate, 'cont'=>$cont]);
            }else {
                return response()->json(['success' => false, 'message' => 'Data Tidak ditemukan']);
            }
        }else {
            return response()->json(['success' => false, 'message' => 'Barcode Kasaluarsa!!']);
        }       
    }

    public function TPS(Request $request)
    {
        $id = $request->idCont;
        
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();
        if ($cont) {
         
                if ($cont->KD_DOKUMEN != NULL || $cont->KD_DOKUMEN != "") {
                    $waktuSekarang = time(); // Mendapatkan timestamp sekarang

                    // Format waktu untuk kolom 'TGLENTRY' dan 'JAMENTRY'
                    
                    $tglEntry = date('Y-m-d', $waktuSekarang); // Format tanggal (YYYY-MM-DD)
                    $tglRef = date('md', $waktuSekarang); // Format tanggal (YYYY-MM-DD)
                    $jamEntry = date('H:i:s', $waktuSekarang); // Format jam (HH:MM:SS)

                    $last = DBCoari::where('TGL_ENTRY', $tglEntry)->count();

                  
                    $next = $last + 1;
                    $ref = str_pad($next, 4, '0', STR_PAD_LEFT);
                    $lastTwoDigitsOfYear = substr(date('y'), -2);
                   
                    $refNumber = "AIRN{$lastTwoDigitsOfYear}{$tglRef}{$ref}";

                    // var_dump($refNumber);
                    // die();
                
                    $coari = DBCoari::create([
                        'REF_NUMBER' => $refNumber,
                        'TGL_ENTRY' => $tglEntry,
                        'JAM_ENTRY' => $jamEntry,
                        'UID'  => \Auth::getUser()->name,
                    ]);

                    $detail = DBCoariDetail::create([
                        'TPSCOARICONTXML_FK'=> $coari->TPSCOARICONTXML_PK, 
                        'REF_NUMBER'=> $refNumber , 
                        'KD_DOK'=> $cont->KD_DOKUMEN , 
                        'KD_TPS'=> $cont->KD_TPS_TUJUAN, 
                        'NO_VOY_FLIGHT'=> $cont->VOY , 
                        'TGL_TIBA'=> $cont->TGLMASUK , 
                        'NO_CONT'=> $cont->NOCONTAINER , 
                        'UK_CONT'=> $cont->SIZE , 
                        'NO_SEGEL'=> $cont->NO_SEAL , 
                        'JNS_CONT'=> $cont->TYPE , 
                        'ID_CONSIGNEE'=> $cont->TCONSOLIDATOR_FK , 
                        'CONSIGNEE'=> $cont->NAMACONSOLIDATOR , 
                        'BRUTO'=> $cont->WEIGHT , 
                        'KD_DOK_INOUT'=> $cont->KD_DOKUMEN , 
                        'NO_DOK_INOUT'=> $cont->NO_PKBE , 
                        'TGL_DOK_INOUT'=> $cont->TGL_PKBE , 
                        'NO_POL'=> $cont->NOPOL_MASUK , 
                        'PEL_MUAT'=> $cont->PEL_MUAT , 
                        'PEL_TRANSIT'=> $cont->PEL_TRANSIT , 
                        'PEL_BONGKAR'=> $cont->PEL_BONGKAR , 
                        'UID'=> \Auth::getUser()->name , 
                        'KD_TPS_ASAL'=> $cont->KD_TPS_ASAL , 
                        'TGL_ENTRY'=> $tglEntry , 
                        'JAM_ENTRY'=> $jamEntry , 
                    ]);

                    $cont->update([
                        'REF_NUMBER_IN'=> $refNumber,
                    ]);





                    return response()->json(['success' => true]);
                }else {
                    return response()->json(['success' => false, 'message' => 'Dokumen masih kosong!']);
                }
         
          
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong!!']);
        }
       
    }

}
