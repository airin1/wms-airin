<?php

namespace App\Http\Controllers\Import;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Jobordercy as DBJoborder;
use App\Models\Consolidator as DBConsolidator;
use App\Models\Perusahaan as DBPerusahaan;
use App\Models\Negara as DBNegara;
use App\Models\Pelabuhan as DBPelabuhan;
use App\Models\Vessel as DBVessel;
use App\Models\Shippingline as DBShippingline;
use App\Models\Lokasisandar as DBLokasisandar;
use App\Models\Containercy as DBContainer;
use App\Models\Eseal as DBEseal;
use App\Models\ReportGateoutFcl as DBReportGateoutFcl;

class FclController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function registerIndex()
    {
        if ( !$this->access->can('show.fcl.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Register', 'slug' => 'show.fcl.register.index', 'description' => ''));
        
        $data['page_title'] = "FCL Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Register'
            ]
        ];        
        
        $data['rfids'] = \DB::table('trfid')->get();
        
        return view('import.fcl.index-register')->with($data);
    }
    
    public function gateinIndex()
    {
        if ( !$this->access->can('show.fcl.getin.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL GateIn', 'slug' => 'show.fcl.getin.index', 'description' => ''));
        
        $data['page_title'] = "FCL Realisasi Masuk / Gate In";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Realisasi Masuk / Gate In'
            ]
        ];        
        
        $data['eseals'] = DBEseal::select('eseal_id as id','esealcode as code')->get();
        $data['consolidators'] = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        $data['locations'] = \DB::table('location_fcl')->get();
        
        return view('import.fcl.index-gatein')->with($data);
    }
    
    public function statusBehandleIndex()
    {
        $data['page_title'] = "FCL Status Behandle";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Status Behandle'
            ]
        ];        
        
        return view('import.fcl.index-status-behandle')->with($data);
    }
    
    public function statusBehandleFinish()
    {
        $data['page_title'] = "FCL Status Behandle Finish";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Status Behandle Finish'
            ]
        ];        
        
        return view('import.fcl.finish-status-behandle')->with($data);
    }

    public function behandleIndex()
    {
        if ( !$this->access->can('show.fcl.behandle.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Behandle', 'slug' => 'show.fcl.behandle.index', 'description' => ''));
        
        $data['page_title'] = "FCL Delivery Behandle";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Delivery Behandle'
            ]
        ];        
        
        return view('import.fcl.index-behandle')->with($data);
    }
    
    public function fiatmuatIndex()
    {
        if ( !$this->access->can('show.fcl.fiatmuat.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Fiatmuat', 'slug' => 'show.fcl.fiatmuat.index', 'description' => ''));
        
        $data['page_title'] = "FCL Delivery Fiat Muat";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Delivery Fiat Muat'
            ]
        ];        
        
        $data['kode_doks'] = \App\Models\KodeDok::get(); 
        
        return view('import.fcl.index-fiatmuat')->with($data);
    }
    
    public function suratjalanIndex()
    {
        if ( !$this->access->can('show.fcl.suratjalan.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Surat Jalan', 'slug' => 'show.fcl.suratjalan.index', 'description' => ''));
        
        $data['page_title'] = "FCL Delivery Surat Jalan";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Delivery Surat Jalan'
            ]
        ];        
        
        return view('import.fcl.index-suratjalan')->with($data);
    }
    
    public function releaseIndex()
    {
        if ( !$this->access->can('show.fcl.release.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Release', 'slug' => 'show.fcl.release.index', 'description' => ''));
        
        $data['page_title'] = "FCL Delivery Release";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Delivery Release'
            ]
        ];        
        
        $data['kode_doks'] = \App\Models\KodeDok::get(); 
//        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id', 'NAMAPERUSAHAAN as name')->get();
        $data['shippinglines'] = DBShippingline::select('TSHIPPINGLINE_PK as id','SHIPPINGLINE as name')->get();
        $data['ppjk'] = \DB::table('tppjk')->get();
        
        return view('import.fcl.index-release')->with($data);
    }
    
    public function dispatcheIndex()
    {
        if ( !$this->access->can('show.fcl.dispatche.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index FCL Dispatche', 'slug' => 'show.fcl.dispatche.index', 'description' => ''));
        
        $data['page_title'] = "FCL Dispatche E-Seal";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Dispatche E-Seal'
            ]
        ];        
        
        $data['eseals'] = DBEseal::select('eseal_id as id','esealcode as code')->get();
        
        return view('import.fcl.index-dispatche')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function registerCreate()
    {
        if ( !$this->access->can('show.fcl.register.create') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Create FCL Register', 'slug' => 'show.fcl.register.create', 'description' => ''));
        
        $data['page_title'] = "Create FCL Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('fcl-register-index'),
                'title' => 'FCL Register'
            ],
            [
                'action' => '',
                'title' => 'Create'
            ]
        ]; 
        
        $spk_last_id = DBJoborder::select('TJOBORDER_PK as id')->orderBy('TJOBORDER_PK', 'DESC')->first(); 
//        $spk_last_id = $this->getSpkNumber();
        $regID = str_pad(intval((isset($spk_last_id->id) ? $spk_last_id->id : 0)+1), 4, '0', STR_PAD_LEFT);
        
        $data['spk_number'] = 'AIRNL'.$regID.'/'.date('y');
        $data['consolidators'] = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        $data['countries'] = DBNegara::select('TNEGARA_PK as id','NAMANEGARA as name')->get();
        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id','NAMAPERUSAHAAN as name')->get();
        $data['pelabuhans'] = array();
//        $data['pelabuhans'] = DBPelabuhan::select('TPELABUHAN_PK as id','NAMAPELABUHAN as name','KODEPELABUHAN as code')->limit(300)->get();
        $data['vessels'] = DBVessel::select('tvessel_pk as id','vesselname as name','vesselcode as code','callsign')->get();
        $data['shippinglines'] = DBShippingline::select('TSHIPPINGLINE_PK as id','SHIPPINGLINE as name')->get();
        $data['lokasisandars'] = DBLokasisandar::select('TLOKASISANDAR_PK as id','NAMALOKASISANDAR as name')->get();
        $data['ppjk'] = \DB::table('tppjk')->get();
        
        return view('import.fcl.create-register')->with($data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $request->all();
    }
    
    public function registerStore(Request $request)
    {
        
        if ( !$this->access->can('store.fcl.register.create') ) {
            return view('errors.no-access');
        }
        
        $validator = \Validator::make($request->all(), [
            'NOJOBORDER' => 'required|unique:tjoborder',
//            'NOMBL' => 'required|unique:tjoborder',
//            'TGLMBL' => 'required',
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
        
        //sng:20210705
        $telp_ppjk = $request['telp_ppjk'];
        //-_-
        
        $data = $request->except(['_token','telp_ppjk']); 
        $data['TGLENTRY'] = date('Y-m-d');
        $data['TGLMBL'] = (!empty($data['TGLMBL'])) ? date('Y-m-d', strtotime($data['TGLMBL'])) : '0000-00-00';
        $data['ETA'] = (!empty($data['ETA'])) ? date('Y-m-d', strtotime($data['ETA'])) : '0000-00-00';
        $data['ETD'] = (!empty($data['ETD'])) ? date('Y-m-d', strtotime($data['ETD'])) : '0000-00-00';
        $data['TGL_BC11'] = (!empty($data['TGL_BC11'])) ? date('Y-m-d', strtotime($data['TGL_BC11'])) : '0000-00-00';
        $data['TTGL_PLP'] = (!empty($data['TTGL_PLP'])) ? date('Y-m-d', strtotime($data['TTGL_PLP'])) : '0000-00-00';
        $namaconsolidator = DBConsolidator::select('NAMACONSOLIDATOR','NPWP')->where('TCONSOLIDATOR_PK',$data['TCONSOLIDATOR_FK'])->first();
        $lokasisandar = DBLokasisandar::where('TLOKASISANDAR_PK',$data['TCONSOLIDATOR_FK'])->first();
        if($namaconsolidator) {
            $data['NAMACONSOLIDATOR'] = $namaconsolidator->NAMACONSOLIDATOR;
            $data['ID_CONSOLIDATOR'] = str_replace(array('.','-'),array('',''),$namaconsolidator->NPWP);
        }elseif($lokasisandar) {
            $data['NAMACONSOLIDATOR'] = $lokasisandar->NAMALOKASISANDAR;
        }       
        $namanegara = DBNegara::select('NAMANEGARA')->where('TNEGARA_PK',$data['TNEGARA_FK'])->first();
        if($namanegara) {
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
        $namaconsignee = DBPerusahaan::select('NAMAPERUSAHAAN','NPWP')->where('TPERUSAHAAN_PK',$data['TCONSIGNEE_FK'])->first();
        if($namaconsignee){
            $data['CONSIGNEE'] = $namaconsignee->NAMAPERUSAHAAN;
            $data['ID_CONSIGNEE'] = str_replace(array('.','-'),array('',''),$namaconsignee->NPWP);
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
            $data['NOMBL'] = $joborder->NOMBL;
            $data['TGLMBL'] = $joborder->TGLMBL;
            $data['NO_BC11'] = $joborder->NO_BC11;
            $data['TGL_BC11'] = $joborder->TGL_BC11;
            $data['NO_POS_BC11'] = $joborder->NO_POS_BC11;
            $data['NO_PLP'] = $joborder->TNO_PLP;
            $data['TGL_PLP'] = $joborder->TTGL_PLP;
            $data['TCONSOLIDATOR_FK'] = $joborder->TCONSOLIDATOR_FK;
            $data['NAMACONSOLIDATOR'] = $joborder->NAMACONSOLIDATOR;
            $data['TCONSIGNEE_FK'] = $joborder->TCONSIGNEE_FK;
            $data['CONSIGNEE'] = $joborder->CONSIGNEE;
            $data['ID_CONSIGNEE'] = $joborder->ID_CONSIGNEE;
    //        $data['TLOKASISANDAR_FK'] = $joborder->TLOKASISANDAR_FK;
            $data['TSHIPPINGLINE_FK'] = $joborder->TSHIPPINGLINE_FK;
            $data['SHIPPINGLINE'] = $joborder->SHIPPINGLINE;
            $data['ETA'] = $joborder->ETA;
            $data['ETD'] = $joborder->ETD;
            $data['VESSEL'] = $joborder->VESSEL;
            $data['VOY'] = $joborder->VOY;
    //        $data['TPELABUHAN_FK'] = $joborder->TPELABUHAN_FK;
    //        $data['NAMAPELABUHAN'] = $joborder->NAMAPELABUHAN;
            $data['PEL_MUAT'] = $joborder->PEL_MUAT;
            $data['PEL_BONGKAR'] = $joborder->PEL_BONGKAR;
            $data['PEL_TRANSIT'] = $joborder->PEL_TRANSIT;
            $data['KD_TPS_ASAL'] = $joborder->KD_TPS_ASAL;
            $data['GUDANG_TUJUAN'] = $joborder->GUDANG_TUJUAN;
            $data['CALLSIGN'] = $joborder->CALLSIGN;
            $data['UID'] = \Auth::getUser()->name;
            //sng:20210705
            $data['telp_ppjk'] = $telp_ppjk;
            //-_-
            
            $container_insert_id = DBContainer::insertGetId($data);
            
            return redirect()->route('fcl-register-edit',$container_insert_id)->with('success', 'FCL Register has been added.');
        }
        
        return back()->withInput();
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    
    public function registerEdit($id)
    {
        if ( !$this->access->can('show.fcl.register.edit') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Edit FCL Register', 'slug' => 'show.fcl.register.edit', 'description' => ''));
        
        $data['page_title'] = "Edit FCL Register";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('fcl-register-index'),
                'title' => 'FCL Register'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];
        
        $data['consolidators'] = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        $data['countries'] = DBNegara::select('TNEGARA_PK as id','NAMANEGARA as name')->get();
        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id','NAMAPERUSAHAAN as name')->get();
        $data['pelabuhans'] = array();
//        $data['pelabuhans'] = DBPelabuhan::select('TPELABUHAN_PK as id','NAMAPELABUHAN as name','KODEPELABUHAN as code')->limit(300)->get();
        $data['vessels'] = DBVessel::select('tvessel_pk as id','vesselname as name','vesselcode as code','callsign')->get();
        $data['shippinglines'] = DBShippingline::select('TSHIPPINGLINE_PK as id','SHIPPINGLINE as name')->get();
        $data['lokasisandars'] = DBLokasisandar::select('TLOKASISANDAR_PK as id','NAMALOKASISANDAR as name')->get();
        
        $jobid = DBContainer::select('TJOBORDER_FK as id')->where('TCONTAINER_PK',$id)->first();
        
        $data['joborder'] = DBJoborder::find($jobid->id);
        //sng:20210720
        $data['ppjk'] = \DB::table('tppjk')->get();
        //-_-
        
        return view('import.fcl.edit-register')->with($data);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
             
    }
    
	  public function registercosolidatorlist()
    {
     
      $consolidators = DBConsolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
       return response()->json($consolidators);       
	 
    }
    

	
	
	public function registerEditcontainerPLP(Request $request)
    {
      $container_id= explode(',',$request->containerId);
	  
	  $nospk= $request->NOSPK;
	  $consolidatorNM= $request->TCONSOLIDATOR_FK;
	  	  
	  $consolidator = DBConsolidator::where('NAMACONSOLIDATOR', $consolidatorNM)->first();
 	  $consolidatorname=$consolidator->NAMACONSOLIDATOR;
      $consolidatorId=$consolidator->TCONSOLIDATOR_PK; 	 
	 $container =  DBContainer::whereIn('TCONTAINER_PK', $container_id)->get();

	  
	  foreach ($container as $t40) :
            //$data['TJOBORDER_FK'] = $joborder->TJOBORDER_PK;
           // $data['NoJob'] = $joborder->NOJOBORDER;
            $data['NOSPK'] = $nospk;           
            $data['ID_CONSOLIDATOR'] =  $consolidatorId;
			$data['TCONSOLIDATOR_FK'] =  $consolidatorId;			
            $data['NAMACONSOLIDATOR'] = $consolidatorname;
	         
			$updateContainer = DBContainer::where('TCONTAINER_PK', $t40->TCONTAINER_PK)
                    ->update($data);
	        if($updateContainer){
               $updatejob = DBJoborder::where('TJOBORDER_PK', $t40->TJOBORDER_FK)
              ->update($data);    
            }
		 
	 
	  endforeach;
	            
                return back()->with('success', 'FCL Register has been updated.');                   
            
	  
    }
    public function registerUpdate(Request $request, $id)
    {
        if ( !$this->access->can('update.fcl.register.edit') ) {
            return view('errors.no-access');
        }
        
        //sng:20210705
        $telp_ppjk = $request['telp_ppjk'];
        //-_-
        
        $data = $request->except(['_token','telp_ppjk']);
        $data['TGLMBL'] = (!empty($data['TGLMBL'])) ? date('Y-m-d', strtotime($data['TGLMBL'])) : '0000-00-00';
        $data['ETA'] = (!empty($data['ETA'])) ? date('Y-m-d', strtotime($data['ETA'])) : '0000-00-00';
        $data['ETD'] = (!empty($data['ETD'])) ? date('Y-m-d', strtotime($data['ETD'])) : '0000-00-00';
        $data['TGL_BC11'] = (!empty($data['TGL_BC11'])) ? date('Y-m-d', strtotime($data['TGL_BC11'])) : '0000-00-00';
        $data['TTGL_PLP'] = (!empty($data['TTGL_PLP'])) ? date('Y-m-d', strtotime($data['TTGL_PLP'])) : '0000-00-00';
        $namaconsolidator = DBConsolidator::select('NAMACONSOLIDATOR','NPWP')->where('TCONSOLIDATOR_PK',$data['TCONSOLIDATOR_FK'])->first();
        $lokasisandar = DBLokasisandar::where('TLOKASISANDAR_PK',$data['TCONSOLIDATOR_FK'])->first();
        if($namaconsolidator) {
            $data['NAMACONSOLIDATOR'] = $namaconsolidator->NAMACONSOLIDATOR;
            $data['ID_CONSOLIDATOR'] = str_replace(array('.','-'),array('',''),$namaconsolidator->NPWP);
        }elseif($lokasisandar) {
            $data['NAMACONSOLIDATOR'] = $lokasisandar->NAMALOKASISANDAR;
        }       
        $namanegara = DBNegara::select('NAMANEGARA')->where('TNEGARA_PK',$data['TNEGARA_FK'])->first();
        if($namanegara) {
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
        $namaconsignee = DBPerusahaan::select('NAMAPERUSAHAAN','NPWP')->where('TPERUSAHAAN_PK',$data['TCONSIGNEE_FK'])->first();
        if($namaconsignee){
            $data['CONSIGNEE'] = $namaconsignee->NAMAPERUSAHAAN;
            $data['ID_CONSIGNEE'] = str_replace(array('.','-'),array('',''),$namaconsignee->NPWP);
        }
        $data['UID'] = \Auth::getUser()->name;
        
        $update = DBJoborder::where('TJOBORDER_PK', $id)
            ->update($data);

        if($update){
            
            //UPDATE CONTAINER
            $joborder = DBJoborder::findOrFail($id);
            $data = array();
            
            $data['TJOBORDER_FK'] = $joborder->TJOBORDER_PK;
            $data['NoJob'] = $joborder->NOJOBORDER;
            $data['NOSPK'] = $joborder->NOSPK;
            $data['NOMBL'] = $joborder->NOMBL;
            $data['TGLMBL'] = $joborder->TGLMBL;
            $data['NO_BC11'] = $joborder->NO_BC11;
            $data['TGL_BC11'] = $joborder->TGL_BC11;
            $data['NO_POS_BC11'] = $joborder->NO_POS_BC11;
            $data['NO_PLP'] = $joborder->TNO_PLP;
            $data['TGL_PLP'] = $joborder->TTGL_PLP;
            $data['TCONSOLIDATOR_FK'] = $joborder->TCONSOLIDATOR_FK;
            $data['NAMACONSOLIDATOR'] = $joborder->NAMACONSOLIDATOR;
            $data['ID_CONSIGNEE'] = $joborder->ID_CONSIGNEE;
            $data['TCONSIGNEE_FK'] = $joborder->TCONSIGNEE_FK;
            $data['CONSIGNEE'] = $joborder->CONSIGNEE;
            $data['TSHIPPINGLINE_FK'] = $joborder->TSHIPPINGLINE_FK;
            $data['SHIPPINGLINE'] = $joborder->SHIPPINGLINE;
            $data['TLOKASISANDAR_FK'] = $joborder->TLOKASISANDAR_FK;
            $data['ETA'] = $joborder->ETA;
            $data['ETD'] = $joborder->ETD;
            $data['VESSEL'] = $joborder->VESSEL;
            $data['VOY'] = $joborder->VOY;
    //        $data['TPELABUHAN_FK'] = $joborder->TPELABUHAN_FK;
    //        $data['NAMAPELABUHAN'] = $joborder->NAMAPELABUHAN;
            $data['PEL_MUAT'] = $joborder->PEL_MUAT;
            $data['PEL_BONGKAR'] = $joborder->PEL_BONGKAR;
            $data['PEL_TRANSIT'] = $joborder->PEL_TRANSIT;
            $data['KD_TPS_ASAL'] = $joborder->KD_TPS_ASAL;
            $data['GUDANG_TUJUAN'] = $joborder->GUDANG_TUJUAN;
            $data['CALLSIGN'] = $joborder->CALLSIGN;           
            
            //sng:20210705
            $data['telp_ppjk'] = $telp_ppjk;
            //-_-
            
            $updateContainer = DBContainer::where('TJOBORDER_FK', $id)
                    ->update($data);
            
            if($updateContainer){
                
                return back()->with('success', 'FCL Register has been updated.');                   
            }
            
            return back()->with('success', 'FCL Register has been updated, but container not updated.');
        }
        
        return back()->with('error', 'FCL Register cannot update, please try again.')->withInput();
    }
    
    public function gateinUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        $delete_photo = $data['delete_photo'];
        unset($data['TCONTAINER_PK'], $data['delete_photo'], $data['_token'], $data['undefined']);
        
        if(empty($data['TGLMASUK']) || $data['TGLMASUK'] == '0000-00-00'){
            $data['TGLMASUK'] = NULL;
            $data['JAMMASUK'] = NULL;
        }
        
        if($delete_photo == 'Y'){
            $data['photo_gatein_extra'] = '';
        }
        
        $namaconsolidator = DBConsolidator::select('NAMACONSOLIDATOR','NPWP')->where('TCONSOLIDATOR_PK',$data['TCONSOLIDATOR_FK'])->first();
        if($namaconsolidator) {
            $data['NAMACONSOLIDATOR'] = $namaconsolidator->NAMACONSOLIDATOR;
            $data['ID_CONSOLIDATOR'] = str_replace(array('.','-'),array('',''),$namaconsolidator->NPWP);
        }
        
//        $location = \DB::table('location_fcl')->find($data['location_id']);
//        if($location){
//            $data['location_id'] = $location->id;
//            $data['location_name'] = $location->name;
//        }
        
        $locations = \DB::table('location_fcl')->whereIn('id', $data['location_id'])->pluck('name');
        
        if($locations){
            $data['location_id'] = implode(',', $data['location_id']);
            $data['location_name'] = implode(',', $locations);
        }
        
//        $teus = DBContainer::select('TEUS')->where('TCONTAINER_PK', $id)->first();

        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            $cont = DBContainer::find($id);
            if($cont->yor_update == 0){
//                $yor = $this->updateYor('gatein', $teus->TEUS);
                $this->updateYorByTeus();
                $cont->yor_update = 1;
                $cont->save();
            }
            
//            $dataManifest['tglmasuk'] = $data['tglmasuk'];
//            $dataManifest['Jammasuk'] = $data['JAMMASUK'];  
//            $dataManifest['NOPOL_MASUK'] = $data['NOPOL']; 
//            
//            $updateManifest = DBManifest::where('TCONTAINER_FK', $id)
//                    ->update($dataManifest);
            
//            if($updateManifest){
                return json_encode(array('success' => true, 'message' => 'Gate IN successfully updated!'));
//            }
            
//            return json_encode(array('success' => true, 'message' => 'Container successfully updated, but Manifest not updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));

    }
    
    public function strippingUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        $dataupdate = array();
//        unset($data['TCONTAINER_PK'], $data['working_hours'], $data['_token']);
        
        $dataupdate['STARTSTRIPPING'] = $data['STARTSTRIPPING'].' '.$data['JAMSTARTSTRIPPING'];
        $dataupdate['ENDSTRIPPING'] = $data['ENDSTRIPPING'].' '.$data['JAMENDSTRIPPING'];
        $dataupdate['TGLSTRIPPING'] = $data['ENDSTRIPPING'];
        $dataupdate['JAMSTRIPPING'] = $data['JAMENDSTRIPPING'];
        $dataupdate['UIDSTRIPPING'] = $data['UIDSTRIPPING'];
        $dataupdate['coordinator_stripping'] = $data['coordinator_stripping'];
        $dataupdate['keterangan'] = $data['keterangan'];
        $dataupdate['mulai_tunda'] = $data['mulai_tunda'];
        $dataupdate['selesai_tunda'] = $data['selesai_tunda'];
        $dataupdate['operator_forklif'] = $data['operator_forklif'];
        
        // Calculate Working Hours
        $date_start_stripping = strtotime($dataupdate['STARTSTRIPPING']);
        $date_end_stripping = strtotime($dataupdate['ENDSTRIPPING']);
        $stripping = abs($date_start_stripping - $date_end_stripping);
        
        $date_start_tunda = strtotime($dataupdate['mulai_tunda']);
        $date_end_tunda = strtotime($dataupdate['selesai_tunda']);
        $tunda = abs($date_start_tunda - $date_end_tunda);
        
        $working_hours = date('H:i', abs($stripping - $tunda));
        $dataupdate['working_hours'] = $working_hours;
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($dataupdate);
        
        if($update){
            
//            $dataManifest['tglstripping'] = $data['ENDSTRIPPING'];
//            $dataManifest['jamstripping'] = $data['JAMENDSTRIPPING'];  
//            $dataManifest['STARTSTRIPPING'] = $data['STARTSTRIPPING'].' '.$data['JAMSTARTSTRIPPING'];
//            $dataManifest['ENDSTRIPPING'] = $data['ENDSTRIPPING'].' '.$data['JAMENDSTRIPPING'];
//            
//            $updateManifest = DBManifest::where('TCONTAINER_FK', $id)
//                    ->update($dataManifest);
            
//            if($updateManifest){
                return json_encode(array('success' => true, 'message' => 'Stripping successfully updated!'));
//            }
            
//            return json_encode(array('success' => true, 'message' => 'Container successfully updated, but Manifest not updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }
    
    public function buangmtyUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['_token']);
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            
//            $dataManifest['tglbuangmty'] = $data['TGLBUANGMTY'];
//            $dataManifest['jambuangmty'] = $data['JAMBUANGMTY'];  
//            $dataManifest['NOPOL_MTY'] = $data['NOPOL_MTY'];
//            
//            $updateManifest = DBManifest::where('TCONTAINER_FK', $id)
//                    ->update($dataManifest);
            
//            if($updateManifest){
                return json_encode(array('success' => true, 'message' => 'Buang MTY successfully updated!'));
//            }
            
//            return json_encode(array('success' => true, 'message' => 'Container successfully updated, but Manifest not updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function behandleUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        $delete_photo = $data['delete_photo'];
        unset($data['TCONTAINER_PK'], $data['delete_photo'], $data['_token']);
        
        $data['BEHANDLE'] = 'Y';
        
        if($delete_photo == 'Y'){
            $data['photo_behandle'] = '';
        }
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Behandle successfully updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function behandleReady(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['_token']);

        $data['date_ready_behandle'] = date('Y-m-d H:i:s');        
        $data['status_behandle'] = 'Ready';
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Behandle successfully updated to Ready!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function fiatmuatUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['_token']);

        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Fiat Muat successfully updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function suratjalanUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['TGLFIAT'], $data['_token']);
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Surat Jalan successfully updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function releaseUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['_token']);
        
        $container = DBContainer::find($id);
        $kd_dok = \App\Models\KodeDok::find($data['KD_DOK_INOUT']);
        if($kd_dok):
            $data['KODE_DOKUMEN'] = $kd_dok->name;
        endif;
        if($data['TSHIPPINGLINE_FK']){
            $namashippingline = DBShippingline::select('SHIPPINGLINE')->where('TSHIPPINGLINE_PK',$data['TSHIPPINGLINE_FK'])->first();
            $data['SHIPPINGLINE'] = $namashippingline->SHIPPINGLINE;
        }
        
        if(empty($data['TGLRELEASE']) || $data['TGLRELEASE'] == '0000-00-00'){
            $data['TGLRELEASE'] = NULL;
            $data['JAMRELEASE'] = NULL;
        }
        
        if($container->release_bc == 'Y'){
//            $data['status_bc'] = 'RELEASE';
            $data['status_bc'] = '';
            $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'active');
        }else{
            if($data['KD_DOK_INOUT'] > 1){
                $data['status_bc'] = 'HOLD';
                $data['TGLRELEASE'] = NULL;
                $data['JAMRELEASE'] = NULL;
                $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'hold');
            }else{
                if($container->flag_bc == 'Y'){
                    $data['status_bc'] = 'SEGEL';
                    $data['TGLRELEASE'] = NULL;
                    $data['JAMRELEASE'] = NULL;
                    $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'hold');
                }else{
//                    $data['status_bc'] = 'RELEASE';
                    $data['status_bc'] = '';
                    $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'active');
                }
            }
        }
        
        $data['TGLFIAT'] = $data['TGLRELEASE'];
        $data['JAMFIAT'] = $data['JAMRELEASE'];
        $data['TGLSURATJALAN'] = $data['TGLRELEASE'];
        $data['JAMSURATJALAN'] = $data['JAMRELEASE'];
        $data['NAMAEMKL'] = '';
//        $data['NOPOL'] = $data['NOPOL_OUT'];
        $data['ID_CONSIGNEE'] = str_replace(array('.','-'), array('',''), $data['ID_CONSIGNEE']);

        if($data['TGLRELEASE']){
            $data['status_bc'] = 'RELEASE';
        }
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            $cont = DBContainer::find($id);
            if($cont->yor_update == 1){
//                $yor = $this->updateYor('release', $container->TEUS);
                $this->updateYorByTeus();
                $cont->yor_update = 2;
                $cont->save();
            }
            
            // Update container dengan nomor bl yg sama.
//            DBContainer::where(array('NO_BL_AWB' => $cont->NO_BL_AWB, 'TGL_BL_AWB' => $cont->TGL_BL_AWB))->update(
//                        [
//                            'KODE_DOKUMEN' => $cont->KODE_DOKUMEN, 
//                            'KD_DOK_INOUT' => $cont->KD_DOK_INOUT,
//                            'NO_SPPB' => $cont->NO_SPPB,
//                            'TGL_SPPB' => $cont->TGL_SPPB
//                        ]
//                    );
            
            return json_encode(array('success' => true, 'message' => 'Release successfully updated!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function dispatcheUpdateByRegister(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['_token'], $data['container_type']);
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Container successfully updated.'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function dispatcheUpdate(Request $request, $id)
    {
        $data = $request->json()->all(); 
        unset($data['TCONTAINER_PK'], $data['_token'], $data['container_type']);
        
        $update = DBContainer::where('TCONTAINER_PK', $id)
            ->update($data);
        
        if($update){
            return json_encode(array('success' => true, 'message' => 'Container successfully updated.'));
        }
        
//        $insert = new \App\Models\Easygo;
//        $insert->ESEALCODE = $data['ESEALCODE'];
//	$insert->TGL_PLP = $data['TGL_PLP'];
//	$insert->NO_PLP = $data['NO_PLP'];
//        $insert->KD_TPS_ASAL = $data['KD_TPS_ASAL'];
//        $insert->KD_TPS_TUJUAN = 'AIRN';
//        $insert->NOCONTAINER = $data['NO_CONT'];
//        $insert->SIZE = $data['UK_CONT'];
//        $insert->TYPE = $data['TYPE'];
//        $insert->NOPOL = $data['NOPOL'];
//        $insert->OB_ID = $id;
//        
//        if($insert->save()){
//            
//            $updateOB = \App\Models\TpsOb::where('TPSOBXML_PK', $id)->update(['STATUS_DISPATCHE' => 'S']);
//            
//            // Update Container
//            $container = DBContainer::where(array('NOCONTAINER' => $data['NO_CONT'], 'NO_PLP' => $data['NO_PLP']))->first(); 
//            if($container){
//                $container->NOPOL = $data['NOPOL'];
//                $container->WEIGHT = $data['WEIGHT'];
//                $container->ESEALCODE = $data['ESEALCODE'];
//                $container->save();
//            }
//            
//            return json_encode(array('success' => true, 'message' => 'Container successfully updated.'));
//        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $container = DBContainer::find($id);
        if($container){
            // Delete Container
            DBContainer::where('TJOBORDER_FK', $container->TJOBORDER_FK)->delete();
            // Delete Joborder
            DBJoborder::where('TJOBORDER_PK', $container->TJOBORDER_FK)->delete();
            
            return back()->with('success', 'FCL Register has been deleted.'); 
        }
        
        return back()->with('error', 'Error delete FCL register, please try again.'); 
    }
    
    public function registerPrintPermohonan(Request $request)
    {
        $data = $request->except(['_token']);
        $container = DBContainer::find($data['container_id']);
        $lokasisandar = DBLokasisandar::find($container->TLOKASISANDAR_FK);
        
        $result['info'] = $data;
        $result['container'] = $container;
        $result['lokasisandar'] = $lokasisandar;
        
        $pdf = \PDF::loadView('print.permohonan', $result);
        return $pdf->download('Permohonan-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
        
//        return view('print.permohonan', $result);
    }
    
    public function buangmtyCetak($id, $type)
    {
        $container = DBContainer::find($id);
        $data['container'] = $container;
//        return view('print.bon-muat', $container);
        
        switch ($type){
            case 'bon-muat':
                $pdf = \PDF::loadView('print.bon-muat', $data);        
                break;
            case 'surat-jalan':
                $pdf = \PDF::loadView('print.surat-jalan', $data);
                break;
        }
        
        return $pdf->stream(ucfirst($type).'-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
    }
    
    public function behandleCetak($id)
    {
        $container = DBContainer::find($id);
        $data['container'] = $container;
//        return view('print.fcl-behandle', $data);
        $pdf = \PDF::loadView('print.fcl-behandle', $data); 
        return $pdf->stream('FCL-Behandle-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
    }
    
    public function fiatmuatCetak($id)
    {
        $container = DBContainer::find($id);
        $joborder = DBJoborder::where('TJOBORDER_PK', $container->TJOBORDER_FK);
        $data['container'] = $container;
        $data['joborder'] = $joborder;
//        return view('print.fcl-fiatmuat', $data);
        $pdf = \PDF::loadView('print.fcl-fiatmuat', $data); 
        return $pdf->stream('FCL-FiatMuat-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
    }
    
    public function suratjalanCetak($id,$date)
    {
        //$container = DBContainer::find($id);
		//$container = DBContainer::whereIn(TCONTAINER_FK,$id);
	    $ids = explode(',', $id);
	    $container = \App\Models\Containercy::whereIn('TCONTAINER_PK', $ids)->get();
        $data['container1'] = $container;
        $data['pay_date'] = $date;
        return view('print.fcl-surat-jalan', $data);
        $pdf = \PDF::loadView('print.fcl-surat-jalan', $data); 
        return $pdf->stream('Delivery-SuratJalan-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
    }
    
    // REPORT
    public function reportHarian(Request $request)
    {
        if ( !$this->access->can('show.fcl.report.harian') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Report Harian FCL', 'slug' => 'show.fcl.report.harian', 'description' => ''));
        
        $data['page_title'] = "FCL Laporan Harian";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Laporan Harian'
            ]
        ];        
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
        if($request->date){
            $data['date'] = $request->date;
        }else{
            $data['date'] = date('Y-m-d');
        }
        
        // BY PLP
        $byplps = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLMASUK', $data['date'])
                ->groupBy('NO_PLP')
                ->get();
        $cont_in = 0;
        
        foreach ($byplps as $byplp):
            $cont_in += $byplp->total;
        endforeach;
         
        $data['countbyplp'] = array(count($byplps), $cont_in);

        // BY DOKUMEN
        $bc23 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 2)->where('TGLRELEASE', $data['date'])->count();
        $dok23 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 2)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
        $bc12 = DBContainer::where('KODE_GUDANG', 'like', $gd)->whereIn('KD_DOK_INOUT',[ 4,28,34])->where('TGLRELEASE', $data['date'])->count();
        $dok12 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->whereIn('KD_DOK_INOUT',[ 4,28,34])
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
        $pprp = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 14)->where('TGLRELEASE', $data['date'])->count();
        $dokpprp = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 14)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
        $bc15 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 9)->where('TGLRELEASE', $data['date'])->count();
        $dok15 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 9)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
        $bc11 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 41)->where('TGLRELEASE', $data['date'])->count();
        $dok11 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 41)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
        $bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->where('TGLRELEASE', $data['date'])->count();
        $dok20 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 1)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();
				
		$bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->where('TGLRELEASE', $data['date'])->count();
        $dok20 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 1)
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();		
				
		//$bc58 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 58)->where('TGLRELEASE', $data['date'])->count();
        //$dok58 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
        //        ->where('KODE_GUDANG', 'like', $gd)
        //        ->where('KD_DOK_INOUT', 58)
        //        ->where('TGLRELEASE', $data['date'])
         //       ->groupBy('NO_SPPB')
        //        ->get();	
         
		$lain = DBContainer::where('KODE_GUDANG', 'like', $gd)->whereNotIn('KD_DOK_INOUT',[ 2,14,9,41,1,58,4,28,34])->where('TGLRELEASE', $data['date'])->count();
        $doklain = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->whereNotIn('KD_DOK_INOUT',[ 2,14,9,41,1,4,28,34])
                ->where('TGLRELEASE', $data['date'])
                ->groupBy('NO_SPPB')
                ->get();

         				
				

        $data['countbydoc'] = array(
            'BC 1.2' => array('dok' => count($dok12), 'box' => $bc12),
            'BC 1.5' => array('dok' => count($dok15), 'box' => $bc15),
            'BC 1.6' => array('dok' => count($dok11), 'box' => $bc11), 
            'BC 2.0' => array('dok' => count($dok20), 'box' => $bc20),
            'BC 2.3' => array('dok' => count($dok23), 'box' => $bc23), 
            'PPRP' => array('dok' => count($dokpprp), 'box' => $pprp),
			'LAIN-LAIN' => array('dok' => count($doklain), 'box' => $lain)
        );
        
        // YOR
        $awal = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('TGLMASUK', '<', $data['date'])
                ->where(function($query) use ($data){
                    $query->whereNull('TGLRELEASE')
                        ->orWhere('TGLRELEASE','>=', $data['date']);
                })
                ->where(function($query) use ($gd){
                    $query->whereNotNull('KODE_GUDANG')
                        ->where('KODE_GUDANG', 'like', $gd);
                })
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $masuk = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLMASUK', $data['date'])
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $keluar = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLRELEASE', $data['date'])
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $data['stok'] = array(
            'awal' => $awal,
            'masuk' => $masuk,
            'keluar' => $keluar
        );
//        return $data['stok'];
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                \DB::raw('SUM(total) as total'))
                ->where('type', 'yor')
                ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }       
        
        $data['gd'] = $gd;
        
        return view('import.fcl.report-harian')->with($data);
    }
    
    public function reportHarianCetak($date, $type, $gd)
    {
        if($gd == 'all'){
            $gd = '%';
        } 
        
        // MASUK
        $data['in'] = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('TGLMASUK', $date)->orderBy('JAMMASUK', 'DESC')->get();
        
        // KELUAR
        $data['out'] = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('TGLRELEASE', $date)->orderBy('JAMRELEASE', 'DESC')->get();  
        
        // BY PLP
        $byplps = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLMASUK', $date)
                ->groupBy('NO_PLP')
                ->get();
        $cont_in = 0;
        
        foreach ($byplps as $byplp):
            $cont_in += $byplp->total;
        endforeach;
         
        $data['countbyplp'] = array(count($byplps), $cont_in);
        
        // BY DOKUMEN
        $bc23 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 2)->where('TGLRELEASE', $date)->count();
        $dok23 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 2)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
        $bc12 = DBContainer::where('KODE_GUDANG', 'like', $gd)->whereIn('KD_DOK_INOUT',[ 4,28,34])->where('TGLRELEASE', $date)->count();
        $dok12 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->whereIn('KD_DOK_INOUT', [ 4,28,34])
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
        $pprp = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 14)->where('TGLRELEASE', $date)->count();
        $dokpprp = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 14)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
        $bc15 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 9)->where('TGLRELEASE', $date)->count();
        $dok15 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 9)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
        $bc11 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 41)->where('TGLRELEASE', $date)->count();
        $dok11 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 41)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
        $bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->where('TGLRELEASE', $date)->count();
        $dok20 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 1)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();
					
	    $bc58 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 58)->where('TGLRELEASE', $date)->count();
        $dok58 = DBContainer::select('NO_SPPB', 'KD_DOK_INOUT', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('KD_DOK_INOUT', 58)
                ->where('TGLRELEASE', $date)
                ->groupBy('NO_SPPB')
                ->get();

        $data['countbydoc'] = array(
            'BC 1.2' => array('dok' => count($dok12), 'box' => $bc12),
            'BC 1.5' => array('dok' => count($dok15), 'box' => $bc15),
            'BC 1.6' => array('dok' => count($dok11), 'box' => $bc11), 
            'BC 2.0' => array('dok' => count($dok20), 'box' => $bc20),
            'BC 2.3' => array('dok' => count($dok23), 'box' => $bc23), 
			'Kementrian' => array('dok' => count($dok58), 'box' => $bc58),
            'PPRP' => array('dok' => count($dokpprp), 'box' => $pprp)
        );
        
        // YOR
        $awal = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)
                ->where('TGLMASUK', '<', $date)
                ->where(function($query) use ($date){
                    $query->whereNull('TGLRELEASE')
                        ->orWhere('TGLRELEASE','>=', $date)
                            ;
                })
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $masuk = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLMASUK', $date)
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $keluar = DBContainer::select('SIZE', \DB::raw('count(*) as total'))
                ->where('KODE_GUDANG', 'like', $gd)->where('TGLRELEASE', $date)
                ->groupBy('SIZE')
                ->orderBy('SIZE','ASC')
                ->get();

        $data['stok'] = array(
            'awal' => $awal,
            'masuk' => $masuk,
            'keluar' => $keluar
        );
        
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                \DB::raw('SUM(total) as total'))
                ->where('type', 'yor')
                ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }   
        
        $data['date'] = $date;
        $data['type'] = $type;
        $data['gd'] = $gd;
        
        return view('print.fcl-report-harian')->with($data);
    }
    
    public function reportRekap(Request $request)
    {
        if ( !$this->access->can('show.fcl.report.rekap') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Report Rekap FCL', 'slug' => 'show.fcl.report.rekap', 'description' => ''));
        
        $data['page_title'] = "FCL Report Container";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Container'
            ]
        ];        
             
        
        if($request->month && $request->year) {
            $month = $request->month;
            $year = $request->year;
        } else {
            $month = date('m');
            $year = date('Y');
        }
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
//        BY PLP
        $twenty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $fourty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $teus = ($twenty*1)+($fourty*2);
        $data['countbysize'] = array('twenty' => $twenty, 'fourty' => $fourty, 'total' => $twenty+$fourty, 'teus' => $teus);
        
        $jict = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $koja = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $mal = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $nct1 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $pldc = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        
        
//        BY GATEIN
        $twentyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $fourtyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $teusg = ($twentyg*1)+($fourtyg*2);
        $data['countbysizegatein'] = array('twenty' => $twentyg, 'fourty' => $fourtyg, 'total' => $twentyg+$fourtyg, 'teus' => $teusg);
        
        $jictg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $kojag = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $malg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $nct1g = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $pldcg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbytps'] = array('JICT' => array($jict, $jictg), 'KOJA' => array($koja, $kojag), 'MAL0' => array($mal, $malg), 'NCT1' => array($nct1, $nct1g), 'PLDC' => array($pldc, $pldcg));
        
//        BY DOKUMEN
        $bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc23 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 2)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc12 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 4)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc15 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 9)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc11 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bcf26 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 5)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbydoc'] = array('BC 2.0' => $bc20, 'BC 2.3' => $bc23, 'BC 1.2' => $bc12, 'BC 1.5' => $bc15, 'BC 1.1' => $bc11, 'BCF 2.6' => $bcf26);
        
        
        $data['totcounttpsp'] = array_sum(array($jict,$koja,$mal,$nct1,$pldc));
        $data['totcounttpsg'] = array_sum(array($jictg,$kojag,$malg,$nct1g,$pldcg));
//        $fc = DBContainer::whereIn('TCONSOLIDATOR_FK', array(1,4))->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
//        $me = DBContainer::whereIn('TCONSOLIDATOR_FK', array(13,16))->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
//        $ap = DBContainer::whereIn('TCONSOLIDATOR_FK', array(10,12))->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
//        $data['countbyconsolidator'] = array('FBI/CPL' => $fc, 'MKT/ECU' => $me, 'ARJAKA/PELOPOR' => $ap);
        
        $data['month'] = $month;
        $data['year'] = $year;
        $data['gd'] = $gd;
        
        $this->updateYorByTeus();
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                    \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                    \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                    \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                    \DB::raw('SUM(total) as total'))
                    ->where('type', 'yor')
                    ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }
        
        
        return view('import.fcl.report-rekap')->with($data);
    }
    
    public function reportRekapViewPhoto($containerID)
    {
        $container = DBContainer::find($containerID);
        
        return json_encode(array('success' => true, 'data' => $container));
    }
    
    public function reportRekapSend(Request $request)
    {
        $selected_id = $request->get('id');
        $shippingline_id = $request->get('shippingline_id');
        $subject = $request->get('subject');
        $tgl_laporan = $request->get('tgl_laporan');
        
        $shippingline = DBShippingline::find($shippingline_id);
        
        if($shippingline){
            $cont_id = explode(',', $selected_id);
            $containers = DBContainer::whereIn('TCONTAINER_PK',$cont_id)->get();

            $dataGateOut = new DBReportGateoutFcl;
            $dataGateOut->container_id = @serialize($cont_id);
            $dataGateOut->shippingline_id = $shippingline->tshippingline_pk;
            $dataGateOut->shippingline = $shippingline->shippingline;
            $dataGateOut->email = $shippingline->email;
            $dataGateOut->subject = $subject;
            $dataGateOut->tgl_laporan = $tgl_laporan;
            $dataGateOut->uid = \Auth::getUser()->name;
            
//            return \View('emails.report-gateout-fcl', array('containers' => $containers, 'data' => $dataGateOut));
            
            if($dataGateOut->save()){
                $send_email = \Mail::send('emails.report-gateout-fcl', array('containers' => $containers, 'data' => $dataGateOut), function($message) use($subject, $dataGateOut) {
                    $message->from('tps@airin.co.id', 'PT. AIRIN');
                    $message->sender('tps@airin.co.id');
                    $message->subject($subject);
//                    $message->to('reethree269@gmail.com');
                    $message->to($dataGateOut->email, $dataGateOut->shippingline);
//                    $message->cc('busdev@jict.co.id');
                });
                
                if($send_email){
                    return back()->with('success', 'Report has been success sent to '.$dataGateOut->email.' & busdev@jict.co.id');
                }else{
                    return back()->with('error', 'Cannot send email, please try again later.');
                }

            }

        }else{
            return back()->with('error', 'Please input Shipping Line.');
        }
        
        return back()->with('error', 'Something went wrong, please try again later.');
    }
    
    public function reportRekapSendNpct(Request $request)
    {
        $selected_id = $request->get('id');
        $shippingline_id = $request->get('shippingline_id');
        $subject = $request->get('subject');
//        $type = $request->get('type');
        
        $shippingline = DBShippingline::find($shippingline_id);
        
        $cont_id = explode(',', $selected_id);
        $containers = DBContainer::whereIn('TCONTAINER_PK',$cont_id)->get();

        $dataTxtIn = '';
        $dataTxtOut = '';
        foreach ($containers as $cont):
            $dateIn = date('YmdHi', strtotime($cont->TGLMASUK.' '.$cont->JAMMASUK));
            $dateOut = date('YmdHi', strtotime($cont->TGLRELEASE.' '.$cont->JAMRELEASE));
            
            $dataTxtIn .= "UNB+UNOA:1+AIRIN004+HLC+170913:1341+1709131341'
UNH+1709130001+CODECO:D:95B:UN:ITG12'
BGM+34+000001+9'
TDT+20++1++HLC:172:166+++:::'
NAD+MS+AIRIN004'
NAD+CF+HLC:160:166'
EQD+CN+".$cont->NOCONTAINER."+++3+5'
RFF+BM:".$cont->NO_BL_AWB."'
DTM+7:".$dateIn.":203'
LOC+165+IDJKT+AIRIN004'
CNT+16:1'
UNT+11+1709130001'
UNZ+1+1709131341'\n";
            
            $dataTxtOut .= "UNB+UNOA:1+AIRIN004+HLC+170913:1341+1709131341'
UNH+1709130001+CODECO:D:95B:UN:ITG12'
BGM+36+000001+9'
TDT+20++1++HLC:172:166+++:::'
NAD+MS+AIRIN004'
NAD+CF+HLC:160:166'
EQD+CN+".$cont->NOCONTAINER."+++3+5'
RFF+BM:".$cont->NO_BL_AWB."'
DTM+7:".$dateOut.":203'
LOC+165+IDJKT+AIRIN004'
CNT+16:1'
UNT+11+1709130001'
UNZ+1+1709131341'\n";
        endforeach;
        
        $fileIn = strtoupper(str_slug($shippingline->shippingline,'-')).'_CODECO-IN_'.time() .rand().'.txt';
        $fileOut = strtoupper(str_slug($shippingline->shippingline,'-')).'_CODECO-OUT_'.time() .rand().'.txt';
//        $destinationPath = public_path()."/uploads/txt/";
        
        $send_email = \Mail::send('emails.report-txt', array(), function($message) use($subject,$dataTxtIn,$dataTxtOut,$fileIn,$fileOut,$shippingline) {
            $message->from('tps@airin.co.id', 'PT. AIRIN');
            $message->sender('tps@airin.co.id');
            $message->subject($subject);
            $message->to($shippingline->email, $shippingline->shippingline);
            $message->cc($shippingline->cc_email);
            $message->bcc('yanu@airin.co.id');
            $message->attachData($dataTxtIn, $fileIn);
            $message->attachData($dataTxtOut, $fileOut);
        });

        if($send_email){
            return back()->with('success', 'Email report has been sent.');
        }else{
            return back()->with('error', 'Cannot send email, please try again later.');
        }

//        \File::put($destinationPath.$file,$dataTxt);
//        return response()->download($destinationPath.$file);

    }
    
    public function reportStock()
    {
        
    }
    
    public function reportLongstay(Request $request)
    {
        if ( !$this->access->can('show.fcl.report.longstay') ) {
            return view('errors.no-access');
        }
         
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Report Longstay Stock', 'slug' => 'show.fcl.report.longstay', 'description' => ''));
        
        $data['page_title'] = "FCL Report Stock";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Stock'
            ]
        ]; 
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
        $this->updateYorByTeus();
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                    \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                    \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                    \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                    \DB::raw('SUM(total) as total'))
                    ->where('type', 'yor')
                    ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }
        $data['gd'] = $gd;
        
        return view('import.fcl.report-longstay')->with($data);
    }
    
    // TPS ONLINE
    public function gateinUpload(Request $request)
    {
        $container_id = $request->id; 
        $container = DBContainer::where('TCONTAINER_PK', $container_id)->first();
        
        // Check data xml
        $check = \App\Models\TpsCoariContDetail::where('NO_CONT', $container->NOCONTAINER)->count();
        
//        if($check > 0){
//            return json_encode(array('success' => false, 'message' => 'No. Container '.$container->NOCONTAINER.' sudah di upload.'));
//        }
        
        // Reff Number
        $reff_number = $this->getReffNumber();  
        
        if($reff_number){
            $coaricont = new \App\Models\TpsCoariCont;
            $coaricont->REF_NUMBER = $reff_number;
            $coaricont->TGL_ENTRY = date('Y-m-d');
            $coaricont->JAM_ENTRY = date('H:i:s');
            $coaricont->UID = \Auth::getUser()->name;
            
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
                $coaricontdetail->ID_CONSIGNEE = $container->ID_CONSIGNEE;
                $coaricontdetail->CONSIGNEE = $container->CONSIGNEE;
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
                $coaricontdetail->UID = \Auth::getUser()->name;
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
                    
                    // Create XML
                    return json_encode(array('insert_id' => $coaricont->TPSCOARICONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                }
                
            }
        } else {
            return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
        }
              
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }
    
    public function releaseUpload(Request $request)
    {
        $container_id = $request->id; 
        $container = DBContainer::where('TCONTAINER_PK', $container_id)->first();
        
        // Check data xml
        $check = \App\Models\TpsCodecoContFclDetail::where(array('NO_CONT' => $container->NOCONTAINER, 'JNS_CONT' => 'F'))->count();
        
//        if($check > 0){
//            return json_encode(array('success' => false, 'message' => 'No. Container '.$container->NOCONTAINER.' sudah di upload.'));
//        }
        
        // Reff Number
        $reff_number = $this->getReffNumber();   
        if($reff_number){
            
            $codecocont = new \App\Models\TpsCodecoContFcl();
            $codecocont->NOJOBORDER = $container->NoJob;
            $codecocont->REF_NUMBER = $reff_number;
            $codecocont->TGL_ENTRY = date('Y-m-d');
            $codecocont->JAM_ENTRY = date('H:i:s');
            $codecocont->UID = \Auth::getUser()->name;
            
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
                $codecocontdetail->UID = \Auth::getUser()->name;
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
                    
                    return json_encode(array('insert_id' => $codecocont->TPSCODECOCONTXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                }
            }
            
        } else {
            return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
        }
              
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
 
    }
    
    public function releaseCreateInvoice(Request $request)
    {
        $ids = explode(',', $request->id);
        
        // Update Perusahaan
        DBPerusahaan::where('TPERUSAHAAN_PK',$request->consignee_id)->update(['ALAMAT' => $request->alamat]);
        
//        array jenis container
        $std = array(
            'DRY'
        );
        $low = array(
            'Class BB Standar 3',
            'Class BB Standar 8',
            'Class BB Standar 9',
            'Class BB Standar 4,1',
			'Class BB Standar 4,2',
			'Class BB Standar 4,3',
            'Class BB Standar 6',
            'Class BB Standar 2,2',
			 'Class BB Standar 2,3'
        );
        $high = array(
            "Class BB High Class 2,1",
            "Class BB High Class 5,1",
            "Class BB High Class 6,1",
            "Class BB High Class 5,2"
        );
        $reffer = array(
            'REFFER RF',
            'REFFER RECOOLING',
            'REEFER RF',
            'REEFER RECOOLING'
        );
        
		$refferlow = array(
            'REEFER RECOOLING BB 2.2',
			'REEFER RECOOLING BB 4.1',
			'REEFER RECOOLING BB 4.2',
			'REEFER RECOOLING BB 4.3',
			'REEFER RECOOLING BB 6',
			'REEFER RECOOLING BB 3',
			'REEFER RECOOLING BB 8',
			'REEFER RECOOLING BB 9',
        );
	
		$refferhigh = array(
            'REEFER RECOOLING BB 2.1',
			'REEFER RECOOLING BB 5.1',
			'REEFER RECOOLING BB 5.2',
			'REEFER RECOOLING BB 6.1',
       );
	
		
        $ft = array(
		    'OH',
            'OPEN TOP',
            'FLAT TRACK RF',
            'FLAT TRACK OH',
            'FLAT TRACK OW',
            'FLAT TRACK OL'
        );
        
		//sort by tgl masuk asc
        $container20 = DBContainer::where('size', 20)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        $container40 = DBContainer::where('size', 40)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        $container45 = DBContainer::where('size', 45)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        
        if($container20 || $container40 || $container45) {
            
            if(count($container20) > 0){
                $data = $container20['0'];
            }elseif(count($container40) > 0){
                $data = $container40['0'];
            }else{
                $data = $container45['0'];
            }
            
//            $tgl_release = $data['TGLRELEASE'];
            $tgl_release = $request->tgl_release;
			//$jam_reefer = $request->JAMRFR;
            
//            $data = (count($container20) > 0 ? $container20['0'] : $container40['0']);
//            $consignee = DBPerusahaan::where('TPERUSAHAAN_PK', $data['TCONSIGNEE_FK'])->first();
            
//            Detect Jenis Container
            $tps_asal = ($data['KD_TPS_ASAL'] == 'NCT1') ? 'NPCT1' : $data['KD_TPS_ASAL'];
            $jenis_cont = $data['jenis_container'];
            
            if(in_array($jenis_cont, $std)){
                $type = 'Standar';
            }else if(in_array($jenis_cont, $low)){
                $type = 'Low';
            }else if(in_array($jenis_cont, $high)){
                $type = 'High';
            }else if(in_array($jenis_cont, $reffer)){
                $type = 'Reffer';
			}else if(in_array($jenis_cont, $refferlow)){
                $type = 'RefferLow';
			}else if(in_array($jenis_cont, $refferhigh)){
                $type = 'RefferHigh';	
            }else if(in_array($jenis_cont, $ft)){
                $type = 'Flatrack';
            }else{
                return back()->with('error', 'Container type '.$jenis_cont.' not detected.');
            }
            
            $no_faktur = $request->no_invoice.'/FKT/IMS/TPS/'.$this->romawi(date('n')).'/'.date('Y');
            
            // Create Invoice Header
            $invoice_nct = new \App\Models\InvoiceNct;
//            $invoice_nct->container_id
//            $invoice_nct->no_container	
            $invoice_nct->no_spk = $data['NOSPK'];
            $invoice_nct->jenis_container = $jenis_cont;
            $invoice_nct->kd_gudang = $data['GUDANG_TUJUAN'];
            $invoice_nct->no_invoice = $no_faktur;	
//            $invoice_nct->no_pajak = $request->no_pajak;	
            $invoice_nct->consignee = $request->consignee;	
            $invoice_nct->npwp = $request->npwp;
            $invoice_nct->alamat = $request->alamat;	
            $invoice_nct->consignee_id = $request->consignee_id;	
            $invoice_nct->vessel = $data['VESSEL'];	
            $invoice_nct->voy = $data['VOY'];	
//            $invoice_nct->no_do = $request->no_do;	
            $invoice_nct->tgl_do = $request->tgl_do;
            $invoice_nct->no_bl = $request->no_bl;	
            $invoice_nct->eta = $data['ETA'];	
            $invoice_nct->gateout_terminal = $data['TGLMASUK'];	
            $invoice_nct->gateout_tps = $tgl_release;	
            $invoice_nct->uid = \Auth::getUser()->name;	
            
            if($invoice_nct->save()) {
                 
                // Insert Invoice Detail
                if(count($container20) > 0) {
                    
					//cek berlaku tarif 
                    if($data['ETA']<'2021-04-15'){
					  $tarif20 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 20))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                      $hr4=9;
					}
					else
					{
					  $tarif20 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 20))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
	                  $hr4=6;
					}

				   foreach ($tarif20 as $t20) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;                      

                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t20->lokasi_sandar;
                        $invoice_penumpukan->size = 20;
                        $invoice_penumpukan->qty = count($container20);
                        
                        if($t20->lokasi_sandar == $tps_asal) {
                            
                            // GERAKAN
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                            $invoice_gerakan->size = 20;
                            $invoice_gerakan->qty = count($container20); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t20->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t20->lift_on;
                            $invoice_gerakan->save();
                            
                           //kalkulasi Reefer Shif
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;
						

						   if($t20->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
								$invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t20->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t20->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t20->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->monitoring;
                                $invoice_gerakan->save();
                            }

                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t20->masa2;
                            
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa2 * $t20->masa1) * count($container20);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t20->masa2 * 3) * count($container20);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t20->masa3 * 6) * count($container20);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t20->masa4 * $hr4) * count($container20);
                            
                        } elseif($t20->lokasi_sandar == 'AIRIN') {
                            
                            // GERAKAN
                            // Check Behandle
                            $count_behandle = 0;
                            foreach ($container20 as $c_20):
                                if($c_20->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
							if($tps_asal == 'KOJA'){
							  if($t20->type == 'Reffer' || $t20->type == 'RefferLow' || $t20->type == 'RefferHigh'){
                                $paket_plp=1100000;  
							  }else{$paket_plp=$t20->paket_plp;  }
							}else{$paket_plp=$t20->paket_plp;}	
                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' =>$paket_plp,'Behandle' => $t20->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' => $paket_plp);
                            }
                              
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container20)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container20);
                                } 
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
							
							
							//kalkulasi Reefer AIRN Shif
						     
							 //$daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));                            
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;
							
                            
                            if($t20->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20) *$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t20->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t20->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t20->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->monitoring;
                                $invoice_gerakan->save();
                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
							//$date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                            //$invoice_penumpukan->startdate = $data['TGLMASUK'];
							$invoice_penumpukan->startdate = $date1;
                            $invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;        
                            $invoice_penumpukan->tarif_dasar = $t20->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t20->masa1 * 2) * count($container20);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t20->masa2 * 3) * count($container20);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t20->masa3) * count($container20);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t20->masa4) * count($container20);
                        }
 
                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 

                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
                if(count($container40) > 0) {
                    
					$data = $container40['0'];
					$jenis_cont = $data['jenis_container'];
            
					if(in_array($jenis_cont, $std)){
						$type = 'Standar';
					}else if(in_array($jenis_cont, $low)){
						$type = 'Low';
					}else if(in_array($jenis_cont, $high)){
						$type = 'High';
					}else if(in_array($jenis_cont, $reffer)){
						$type = 'Reffer';
					}else if(in_array($jenis_cont, $refferlow)){
						$type = 'RefferLow';
					}else if(in_array($jenis_cont, $refferhigh)){
						$type = 'RefferHigh';	
					}else if(in_array($jenis_cont, $ft)){
						$type = 'Flatrack';
					}else{
						return back()->with('error', 'Container type '.$jenis_cont.' not detected.');
					}
					
					
					//cek tarif 40
					if($data['ETA']<'2021-04-15'){
                     $tarif40 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 40))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                     $hr4=9;
					}
					else
					{
					 $tarif40 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 40))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                     $hr4=6;

					}
					 
                    foreach ($tarif40 as $t40) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                        
                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t40->lokasi_sandar;
                        $invoice_penumpukan->size = 40;
                        $invoice_penumpukan->qty = count($container40);
                        
                        if($t40->lokasi_sandar == $tps_asal) {
                            // GERAKAN
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                            $invoice_gerakan->size = 40;
                            $invoice_gerakan->qty = count($container40); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t40->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t40->lift_on;
                            $invoice_gerakan->save();

                           	//kalkulasi Reefer Shif
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;				



						   if($t40->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t40->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->recooling;
                                $invoice_gerakan->save();
                            }
							
						
                            
                            if($t40->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t40->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->monitoring;
                                $invoice_gerakan->save();
                            }

                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t40->masa2;
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t40->masa1) * count($container40);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t40->masa2 * 3) * count($container40);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t40->masa3 * 6) * count($container40);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t40->masa4 * $hr4) * count($container40);
                            
                        } elseif($t40->lokasi_sandar == 'AIRIN') {
                            // GERAKAN
//                          // Check Behandle
                            $count_behandle = 0;
                            foreach ($container40 as $c_40):
                                if($c_40->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
	
							if($tps_asal == 'KOJA'){
							  if($t40->type == 'Reffer' || $t40->type == 'RefferLow' || $t40->type == 'RefferHigh'){
                                $paket_plp=1600000;  
							  }else{$paket_plp=$t40->paket_plp;  }
							}else{$paket_plp=$t40->paket_plp;}	

                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $paket_plp,'Behandle' => $t40->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $paket_plp);
                            }
                            
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container40)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container40);
                                }
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
							
							//kalkulasi Reefer AIRN Shif
							//$daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));
                            $daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
							$daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;

                            
                            if($t40->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t40->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t40->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t40->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->monitoring;
                                $invoice_gerakan->save();
                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                        
							//$date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                            //$invoice_penumpukan->startdate = $data['TGLMASUK'];
                            $invoice_penumpukan->startdate = $date1;
							$invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t40->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t40->masa1 * 2) * count($container40);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t40->masa2 * 3) * count($container40);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t40->masa3) * count($container40);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t40->masa4) * count($container40);
                        }

                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 
                        
                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
                if(count($container45) > 0) {
                    
					//cek tarif 45
					if($data['ETA']<'2021-04-15'){
						$tarif45 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 45))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
					    $hr4=9;
					}
					else
					{
						$tarif45 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 45))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
					    $hr4=6;
					}
                    foreach ($tarif45 as $t45) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                        
                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t45->lokasi_sandar;
                        $invoice_penumpukan->size = 45;
                        $invoice_penumpukan->qty = count($container45);
                        
                        if($t45->lokasi_sandar == $tps_asal) {
                            // GERAKAN
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                            $invoice_gerakan->size = 45;
                            $invoice_gerakan->qty = count($container45); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t45->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t45->lift_on;
                            $invoice_gerakan->save();

							//kalkulasi Reefer Shif
							$daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;
							
                            if($t45->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t45->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t45->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t45->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->monitoring;
                                $invoice_gerakan->save();
                            }

                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t45->masa2;
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t45->masa1) * count($container45);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t45->masa2 * 3) * count($container45);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t45->masa3 * 6) * count($container45);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t45->masa4 * $hr4) * count($container45);
                            
                        } elseif($t45->lokasi_sandar == 'AIRIN') {
                            // GERAKAN
                            $count_behandle = 0;
                            foreach ($container45 as $c_45):
                                if($c_45->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp,'Behandle' => $t45->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp);
                            }
                            
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container45)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container45);
                                }
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
                         
  						    //kalkulasi Reefer AIRN Shif
							//$daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));
                            $daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
							$daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;

                            if($t45->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t45->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t45->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t45->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->monitoring;
                                $invoice_gerakan->save();
                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
							//$date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                           // $invoice_penumpukan->startdate = $data['TGLMASUK'];
		                   $invoice_penumpukan->startdate = $date1;
		                    $invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t45->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t45->masa1 * 2) * count($container45);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t45->masa2 * 3) * count($container45);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t45->masa3) * count($container45);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t45->masa4) * count($container45);
                        }

                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 
                        
                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
            }
            //cek tarif 45
		    if($data['ETA']<'2021-04-15'){
              $nct_gerakan = array('Pas Truck' => 9091, 'Gate Pass Admin' => 20000, 'Cost Recovery' => 75000);
            }
		    else{
			  //today  > '2024-10-15'	
              	$nct_gerakan = array('Pas Truck' => 12162, 'Gate Pass Admin' => 20000);	
			}	
			
            foreach($nct_gerakan as $key=>$value):
                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                $invoice_gerakan->lokasi_sandar = $tps_asal;
                $invoice_gerakan->size = 0;
                $invoice_gerakan->qty = count($container20)+count($container40)+count($container45); 
                $invoice_gerakan->jenis_gerakan = $key;
                $invoice_gerakan->tarif_dasar = $value;
                $invoice_gerakan->total = (count($container20)+count($container40)+count($container45)) * $value;

                $invoice_gerakan->save();
            endforeach;
//            
            $update_nct = \App\Models\InvoiceNct::find($invoice_nct->id);
            
            $total_penumpukan = \App\Models\InvoiceNctPenumpukan::where('invoice_nct_id', $invoice_nct->id)->sum('total');
            $total_gerakan = \App\Models\InvoiceNctGerakan::where('invoice_nct_id', $invoice_nct->id)->sum('total');
            
            $no_container = array();
            $party = array();
            if(count($container20) > 0){
                foreach ($container20 as $c20):
                    $no_container[] = $c20->NOCONTAINER;
                endforeach;
                $party[] = count($container20).' X 20';
            }
            if(count($container40) > 0){
                foreach ($container40 as $c40):
                    $no_container[] = $c40->NOCONTAINER;
                endforeach;
                $party[] = count($container40).' X 40';
            }
            if(count($container45) > 0){
                foreach ($container45 as $c45):
                    $no_container[] = $c45->NOCONTAINER;
                endforeach;
                $party[] = count($container45).' X 45';
            }
            
            $update_nct->container_id = $request->id;
            $update_nct->no_container = implode(', ', $no_container);
            $update_nct->party = @serialize($party);
            
            $total_penumpukan_tps = \App\Models\InvoiceNctPenumpukan::where(array('invoice_nct_id' => $invoice_nct->id, 'lokasi_sandar' => 'AIRIN'))->sum('total');
            $total_gerakan_tps = \App\Models\InvoiceNctGerakan::where(array('invoice_nct_id' => $invoice_nct->id, 'lokasi_sandar' => 'AIRIN'))->sum('total');
            if($type == 'Reffer'){
                $update_nct->dg_surcharge = ($total_penumpukan_tps + $total_gerakan_tps)*15/100;
                $update_nct->surcharge = 15;
            }elseif($type == 'Low' || $type == 'High' || $type == 'RefferLow' || $type == 'RefferHigh'){
                $update_nct->dg_surcharge = ($total_penumpukan_tps + $total_gerakan_tps)*25/100;
                $update_nct->surcharge = 25;
            }else{
                $update_nct->dg_surcharge = 0;
                $update_nct->surcharge = 0;
            }
            
            $update_nct->administrasi = (count($container20)+count($container40)+count($container45)) * 100000;
            $update_nct->total_non_ppn = $total_penumpukan + $total_gerakan + $update_nct->dg_surcharge + $update_nct->administrasi;	
           if(date('Y-m-d')<'2022-04-01'){           
		   		   $update_nct->ppn = $update_nct->total_non_ppn * 10/100;	
			}else{
				 $update_nct->ppn = round($update_nct->total_non_ppn * 11/100);	
			}
		   if(($update_nct->total_non_ppn+$update_nct->ppn) >= 5000000){
                $materai = 10000;
//            }elseif(($update_nct->total_non_ppn+$update_nct->ppn) < 300000) {
//                $materai = 0;
            }else{
                $materai = 0;
            }
            $update_nct->materai = $materai;	
            $update_nct->total = $update_nct->total_non_ppn+$update_nct->ppn+$update_nct->materai;	
            
            $update_nct->save();
            
            return back()->with('success', 'Invoice berhasih dibuat.');
//            return json_encode(array('success' => true, 'message' => 'Invoice berhasih dibuat.'));
            
        }
        
//        return $container;
        return back()->with('error', 'Something went wrong, please try again later.');
//        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
  
  //Relasde Invoice TPP
   public function releaseCreateInvoicetpp(Request $request)
    {
        $ids = explode(',', $request->id);
        
		$jenis_tpp = $request->jenis_tpp;
        // Update Perusahaan
        DBPerusahaan::where('TPERUSAHAAN_PK',$request->consignee_id)->update(['ALAMAT' => $request->alamat]);
        
//        array jenis container
        $std = array(
            'DRY'
        );
        $low = array(
            'Class BB Standar 3',
            'Class BB Standar 8',
            'Class BB Standar 9',
            'Class BB Standar 4,1',
			'Class BB Standar 4,2',
			'Class BB Standar 4,3',
            'Class BB Standar 6',
            'Class BB Standar 2,2'
        );
        $high = array(
            "Class BB High Class 2,1",
            "Class BB High Class 5,1",
            "Class BB High Class 6,1",
            "Class BB High Class 5,2"
        );
        $reffer = array(
            'REFFER RF',
            'REFFER RECOOLING',
            'REEFER RF',
            'REEFER RECOOLING'
        );
        
		$refferlow = array(
            'REEFER RECOOLING BB 2.2',
			'REEFER RECOOLING BB 4.1',
			'REEFER RECOOLING BB 4.2',
			'REEFER RECOOLING BB 4.3',
			'REEFER RECOOLING BB 6',
			'REEFER RECOOLING BB 3',
			'REEFER RECOOLING BB 8',
			'REEFER RECOOLING BB 9',
        );
	
		$refferhigh = array(
            'REEFER RECOOLING BB 2.1',
			'REEFER RECOOLING BB 5.1',
			'REEFER RECOOLING BB 5.2',
			'REEFER RECOOLING BB 6.1',
       );
	
		
        $ft = array(
            'OPEN TOP',
            'FLAT TRACK RF',
            'FLAT TRACK OH',
            'FLAT TRACK OW',
            'FLAT TRACK OL'
        );
        
		//sort by tgl masuk asc
        $container20 = DBContainer::where('size', 20)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        $container40 = DBContainer::where('size', 40)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        $container45 = DBContainer::where('size', 45)->whereIn('TCONTAINER_PK', $ids)->orderBy('TGLMASUK','DESC')->get();
        
        if($container20 || $container40 || $container45) {
            
            if(count($container20) > 0){
                $data = $container20['0'];
            }elseif(count($container40) > 0){
                $data = $container40['0'];
            }else{
                $data = $container45['0'];
            }
            
//            $tgl_release = $data['TGLRELEASE'];
            $tgl_release = $request->tgl_release;
			//$jam_reefer = $request->JAMRFR;
            
//            $data = (count($container20) > 0 ? $container20['0'] : $container40['0']);
//            $consignee = DBPerusahaan::where('TPERUSAHAAN_PK', $data['TCONSIGNEE_FK'])->first();
            
//            Detect Jenis Container
            $tps_asal = ($data['KD_TPS_ASAL'] == 'NCT1') ? 'NPCT1' : $data['KD_TPS_ASAL'];
            $jenis_cont = $data['jenis_container'];
            
            if(in_array($jenis_cont, $std)){
                $type = 'Standar';
            }else if(in_array($jenis_cont, $low)){
                $type = 'Low';
            }else if(in_array($jenis_cont, $high)){
                $type = 'High';
            }else if(in_array($jenis_cont, $reffer)){
                $type = 'Reffer';
			}else if(in_array($jenis_cont, $refferlow)){
                $type = 'RefferLow';
			}else if(in_array($jenis_cont, $refferhigh)){
                $type = 'RefferHigh';	
            }else if(in_array($jenis_cont, $ft)){
                $type = 'Flatrack';
            }else{
                return back()->with('error', 'Container type '.$jenis_cont.' not detected.');
            }
            
            $no_faktur = $request->no_invoice.'/FKT/IMS/TPS/'.$this->romawi(date('n')).'/'.date('Y');
            
            // Create Invoice Header
            $invoice_nct = new \App\Models\InvoiceNct;
//            $invoice_nct->container_id
//            $invoice_nct->no_container	
            $invoice_nct->no_spk = $data['NOSPK'];
            $invoice_nct->jenis_container = $jenis_cont;
            $invoice_nct->kd_gudang = $data['GUDANG_TUJUAN'];
            $invoice_nct->no_invoice = $no_faktur;	
//            $invoice_nct->no_pajak = $request->no_pajak;	
            $invoice_nct->consignee = $request->consignee;	
            $invoice_nct->npwp = $request->npwp;
            $invoice_nct->alamat = $request->alamat;	
            $invoice_nct->consignee_id = $request->consignee_id;	
            $invoice_nct->vessel = $data['VESSEL'];	
            $invoice_nct->voy = $data['VOY'];	
//            $invoice_nct->no_do = $request->no_do;	
            $invoice_nct->tgl_do = $request->tgl_do;
            $invoice_nct->no_bl = $request->no_bl;	
            $invoice_nct->eta = $data['ETA'];	
            $invoice_nct->gateout_terminal = $data['TGLMASUK'];	
            $invoice_nct->gateout_tps = $tgl_release;	
            $invoice_nct->uid = \Auth::getUser()->name;	
            
            if($invoice_nct->save()) {
                 
                // Insert Invoice Detail
                if(count($container20) > 0) {
                    
					//cek berlaku tarif 
                    if($data['ETA']<'2021-04-15'){
					  $tarif20 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 20))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                      $hr4=9;
					}
					else
					{
					  $tarif20 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 20))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
	                  $hr4=6;
					}

				   foreach ($tarif20 as $t20) :
  
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;                      
                         if($t20->lokasi_sandar == $tps_asal) {
                          if($jenis_tpp=='Keluar TPS AIRIN') {
   
							// GERAKAN
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                            $invoice_gerakan->size = 20;
                            $invoice_gerakan->qty = count($container20); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t20->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t20->lift_on;
                            $invoice_gerakan->save();
                            
                           //kalkulasi Reefer Shif
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;
						

						   if($t20->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
								$invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t20->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t20->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t20->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->monitoring;
                                $invoice_gerakan->save();
                            }
						  }
						   if($jenis_tpp=='Keluar TPS TPP') {
							
							$invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
							$invoice_penumpukan->lokasi_sandar = $t20->lokasi_sandar;
							$invoice_penumpukan->size = 20;
							$invoice_penumpukan->qty = count($container20);

                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t20->masa2;
                            
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa2 * $t20->masa1) * count($container20);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t20->masa2 * 3) * count($container20);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t20->masa3 * 6) * count($container20);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t20->masa4 * $hr4) * count($container20);
						  }   
                        
						} elseif($t20->lokasi_sandar == 'AIRIN') {
                          
						  if($jenis_tpp=='Keluar TPS AIRIN') {
                            // GERAKAN
                            // Check Behandle
                            $count_behandle = 0;
                            foreach ($container20 as $c_20):
                                if($c_20->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' => $t20->paket_plp,'Behandle' => $t20->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' => $t20->paket_plp);
                            }
                              
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container20)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container20);
                                } 
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
							
							
							//kalkulasi Reefer AIRN Shif
						  
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;
							
                            
                            if($t20->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20) *$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t20->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t20->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
                                $invoice_gerakan->size = 20;
                                $invoice_gerakan->qty = count($container20)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t20->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->monitoring;
                                $invoice_gerakan->save();
                            }
                          }
						  if($jenis_tpp=='Keluar TPS TPP') {
						    $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                            $invoice_penumpukan->lokasi_sandar = $t20->lokasi_sandar;
							$invoice_penumpukan->size = 20;
							$invoice_penumpukan->qty = count($container20);

						  
                            // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLMASUK'];
                            $invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;        
                            $invoice_penumpukan->tarif_dasar = $t20->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t20->masa1 * 2) * count($container20);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t20->masa2 * 3) * count($container20);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t20->masa3) * count($container20);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t20->masa4) * count($container20);
                        }
					}
 
                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 

                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
                if(count($container40) > 0) {
                    
					//cek tarif 40
					if($data['ETA']<'2021-04-15'){
                     $tarif40 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 40))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                     $hr4=9;
					}
					else
					{
					 $tarif40 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 40))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
                     $hr4=6;

					}
					 
                    foreach ($tarif40 as $t40) :
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                         if($t40->lokasi_sandar == $tps_asal) {
						  if($jenis_tpp=='Keluar TPS AIRIN') {
	
						 
                            // GERAKAN
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                            $invoice_gerakan->size = 40;
                            $invoice_gerakan->qty = count($container40); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t40->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t40->lift_on;
                            $invoice_gerakan->save();

                           	//kalkulasi Reefer Shif
						    $daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;				



						   if($t40->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t40->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->recooling;
                                $invoice_gerakan->save();
                            }
							
						
                            
                            if($t40->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t40->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->monitoring;
                                $invoice_gerakan->save();
                            }
						  }
						  if($jenis_tpp=='Keluar TPS TPP') {
							$invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
							$invoice_penumpukan->lokasi_sandar = $t40->lokasi_sandar;
							$invoice_penumpukan->size = 40;
							$invoice_penumpukan->qty = count($container40);


                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t40->masa2;
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t40->masa1) * count($container40);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t40->masa2 * 3) * count($container40);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t40->masa3 * 6) * count($container40);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t40->masa4 * $hr4) * count($container40);
                          }  
                        } elseif($t40->lokasi_sandar == 'AIRIN') {
                            if($jenis_tpp=='Keluar TPS AIRIN') {
							
							// GERAKAN
//                          // Check Behandle
                            $count_behandle = 0;
                            foreach ($container40 as $c_40):
                                if($c_40->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $t40->paket_plp,'Behandle' => $t40->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $t40->paket_plp);
                            }
                            
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container40)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container40);
                                }
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
							
							//kalkulasi Reefer AIRN Shif
							$daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;

                            
                            if($t40->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t40->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t40->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
                                $invoice_gerakan->size = 40;
                                $invoice_gerakan->qty = count($container40)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t40->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->monitoring;
                                $invoice_gerakan->save();
                            }
						   }
						   
						  if($jenis_tpp=='Keluar TPS TPP') {
                                $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
								$invoice_penumpukan->lokasi_sandar = $t40->lokasi_sandar;
								$invoice_penumpukan->size = 40;
								$invoice_penumpukan->qty = count($container40);


						   // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLMASUK'];
                            $invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t40->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t40->masa1 * 2) * count($container40);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t40->masa2 * 3) * count($container40);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t40->masa3) * count($container40);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t40->masa4) * count($container40);
                         }
						} 

                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 
                        
                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
                if(count($container45) > 0) {
                    
					//cek tarif 45
					if($data['ETA']<'2021-04-15'){
						$tarif45 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 45))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
					    $hr4=9;
					}
					else
					{
						$tarif45 = \App\Models\InvoiceTarifNctNew::where(array('type' => $type, 'size' => 45))->whereIn('lokasi_sandar', array($tps_asal,'AIRIN'))->get();
					    $hr4=6;
					}
                    foreach ($tarif45 as $t45) :                 
					  $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                        if($t45->lokasi_sandar == $tps_asal) {
                          if($jenis_tpp=='Keluar TPS AIRIN') {

						  // GERAKAN
							
						
                            $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                            $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                            $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                            $invoice_gerakan->size = 45;
                            $invoice_gerakan->qty = count($container45); 
                            $invoice_gerakan->jenis_gerakan = 'Lift On Terminal';
                            $invoice_gerakan->tarif_dasar = $t45->lift_on;
                            $invoice_gerakan->total = $invoice_gerakan->qty * $t45->lift_on;
                            $invoice_gerakan->save();

							//kalkulasi Reefer Shif
							$daterfr1 = date_create(date('Y-m-d',strtotime($data['ETA'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = ($diffrfr->format("%a") * 24)/8;
							
                            if($t45->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t45->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t45->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)*$harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t45->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->monitoring;
                                $invoice_gerakan->save();
                            }

						  }
						   if($jenis_tpp=='Keluar TPS TPP') {
							$invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
							$invoice_penumpukan->lokasi_sandar = $t45->lokasi_sandar;
							$invoice_penumpukan->size = 45;
							$invoice_penumpukan->qty = count($container45);

                            // PENUMPUKAN
                            $date1 = date_create($data['ETA']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            $invoice_penumpukan->startdate = $data['ETA'];
                            $invoice_penumpukan->enddate = $data['TGLMASUK'];
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t45->masa2;
                            $invoice_penumpukan->hari_masa1 = ($hari > 0) ? 1 : 0;
                            $invoice_penumpukan->hari_masa2 = ($hari > 1) ? 1 : 0;
                            $invoice_penumpukan->hari_masa3 = ($hari > 2) ? 1 : 0;
                            $invoice_penumpukan->hari_masa4 = ($hari > 3) ? $hari - 3 : 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t45->masa1) * count($container45);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t45->masa2 * 3) * count($container45);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t45->masa3 * 6) * count($container45);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t45->masa4 * $hr4) * count($container45);
                          }  
                        } elseif($t45->lokasi_sandar == 'AIRIN') {
                           if($jenis_tpp=='Keluar TPS AIRIN') {
							
							// GERAKAN
                            $count_behandle = 0;
                            foreach ($container45 as $c_45):
                                if($c_45->BEHANDLE == 'Y'){
                                    $count_behandle++;
                                }
                            endforeach;
//                            if($request->behandle) {
                            if($count_behandle > 0){
                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp,'Behandle' => $t45->behandle);
                            }else{
                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp);
                            }
                            
                            foreach ($jenis as $key=>$value):
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                if($key == 'Lift On/Off'){
                                    $invoice_gerakan->qty = count($container45)*2;
                                }elseif($key == 'Behandle'){
                                    $invoice_gerakan->qty = $count_behandle;
                                }else{
                                    $invoice_gerakan->qty = count($container45);
                                }
                                $invoice_gerakan->jenis_gerakan = $key;
                                $invoice_gerakan->tarif_dasar = $value;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
                                
                                $invoice_gerakan->save();
                            endforeach;
                         
  						    //kalkulasi Reefer AIRN Shif
							$daterfr1 = date_create(date('Y-m-d',strtotime($data['TGLMASUK'])));
                            $daterfr2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));                          
							$diffrfr = date_diff($daterfr1 , $daterfr2);
						    $harirfr = (($diffrfr->format("%a") * 24)/8)-1;

                            if($t45->recooling){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Recooling';
                                $invoice_gerakan->tarif_dasar = $t45->recooling;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->recooling;
                                $invoice_gerakan->save();
                            }
                            
                            if($t45->monitoring){
                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
                                $invoice_gerakan->size = 45;
                                $invoice_gerakan->qty = count($container45)* $harirfr; 
                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
                                $invoice_gerakan->tarif_dasar = $t45->monitoring;
                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->monitoring;
                                $invoice_gerakan->save();
                            }
						   }
						   
						   if($jenis_tpp=='Keluar TPS TPP') {
							   
							    $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
								$invoice_penumpukan->lokasi_sandar = $t45->lokasi_sandar;
								$invoice_penumpukan->size = 45;
								$invoice_penumpukan->qty = count($container45);
   
							   
                            // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($tgl_release. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // Perhitungan Masa 1
                            if($hari_terminal >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-$hari_terminal),$hari);
                            }
                            
                            $hari_masa2 = abs($hari - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLMASUK'];
                            $invoice_penumpukan->enddate = $tgl_release;
                            $invoice_penumpukan->lama_timbun = $hari;
                            $invoice_penumpukan->tarif_dasar = $t45->masa1;
                            $invoice_penumpukan->hari_masa1 = $hari_masa1;
                            $invoice_penumpukan->hari_masa2 = $hari_masa2;
                            $invoice_penumpukan->hari_masa3 = 0;
                            $invoice_penumpukan->hari_masa4 = 0;
                            
                            $invoice_penumpukan->masa1 = ($invoice_penumpukan->hari_masa1 * $t45->masa1 * 2) * count($container45);
                            $invoice_penumpukan->masa2 = ($invoice_penumpukan->hari_masa2 * $t45->masa2 * 3) * count($container45);
                            $invoice_penumpukan->masa3 = ($invoice_penumpukan->hari_masa3 * $t45->masa3) * count($container45);
                            $invoice_penumpukan->masa4 = ($invoice_penumpukan->hari_masa4 * $t45->masa4) * count($container45);
                         }
						}

                        $invoice_penumpukan->total = array_sum(array($invoice_penumpukan->masa1,$invoice_penumpukan->masa2,$invoice_penumpukan->masa3,$invoice_penumpukan->masa4)); 
                        
                        $invoice_penumpukan->save();
                        
                    endforeach;
                    
                }
                
            }
            //cek tarif 45
		    if($data['ETA']<'2021-04-15'){
              $nct_gerakan = array('Pas Truck' => 9091, 'Gate Pass Admin' => 20000, 'Cost Recovery' => 75000);
            }
			else
			{
				//today >=' 2024-10-15' 
				//$nct_gerakan = array('Pas Truck' => 9091, 'Gate Pass Admin' => 20000, 'Cost Recovery' => 0);
				$nct_gerakan = array('Pas Truck' => 12162, 'Gate Pass Admin' => 20000);
			}	
		  if($jenis_tpp=='Keluar TPS AIRIN') {
            foreach($nct_gerakan as $key=>$value):
                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
                        
                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
                $invoice_gerakan->lokasi_sandar = $tps_asal;
                $invoice_gerakan->size = 0;
                $invoice_gerakan->qty = count($container20)+count($container40)+count($container45); 
                $invoice_gerakan->jenis_gerakan = $key;
                $invoice_gerakan->tarif_dasar = $value;
                $invoice_gerakan->total = (count($container20)+count($container40)+count($container45)) * $value;

                $invoice_gerakan->save();
            endforeach;
		  }
//            
            $update_nct = \App\Models\InvoiceNct::find($invoice_nct->id);
            
            $total_penumpukan = \App\Models\InvoiceNctPenumpukan::where('invoice_nct_id', $invoice_nct->id)->sum('total');
            $total_gerakan = \App\Models\InvoiceNctGerakan::where('invoice_nct_id', $invoice_nct->id)->sum('total');
            
            $no_container = array();
            $party = array();
            if(count($container20) > 0){
                foreach ($container20 as $c20):
                    $no_container[] = $c20->NOCONTAINER;
                endforeach;
                $party[] = count($container20).' X 20';
            }
            if(count($container40) > 0){
                foreach ($container40 as $c40):
                    $no_container[] = $c40->NOCONTAINER;
                endforeach;
                $party[] = count($container40).' X 40';
            }
            if(count($container45) > 0){
                foreach ($container45 as $c45):
                    $no_container[] = $c45->NOCONTAINER;
                endforeach;
                $party[] = count($container45).' X 45';
            }
            
            $update_nct->container_id = $request->id;
            $update_nct->no_container = implode(', ', $no_container);
            $update_nct->party = @serialize($party);
            
            $total_penumpukan_tps = \App\Models\InvoiceNctPenumpukan::where(array('invoice_nct_id' => $invoice_nct->id, 'lokasi_sandar' => 'AIRIN'))->sum('total');
            $total_gerakan_tps = \App\Models\InvoiceNctGerakan::where(array('invoice_nct_id' => $invoice_nct->id, 'lokasi_sandar' => 'AIRIN'))->sum('total');
            if($type == 'Reffer'){
                $update_nct->dg_surcharge = ($total_penumpukan_tps + $total_gerakan_tps)*15/100;
                $update_nct->surcharge = 15;
            }elseif($type == 'Low' || $type == 'High' || $type == 'RefferLow' || $type == 'RefferHigh'){
                $update_nct->dg_surcharge = ($total_penumpukan_tps + $total_gerakan_tps)*25/100;
                $update_nct->surcharge = 25;
            }else{
                $update_nct->dg_surcharge = 0;
                $update_nct->surcharge = 0;
            }
            
            $update_nct->administrasi = (count($container20)+count($container40)+count($container45)) * 100000;
            $update_nct->total_non_ppn = $total_penumpukan + $total_gerakan + $update_nct->dg_surcharge + $update_nct->administrasi;	
            if(date('Y-m-d')<'2022-04-01'){  
				$update_nct->ppn = $update_nct->total_non_ppn * 10/100;	
            }else{
				$update_nct->ppn = round($update_nct->total_non_ppn * 11/100);	
			}
			if(($update_nct->total_non_ppn+$update_nct->ppn) >= 5000000){
                $materai = 10000;
//            }elseif(($update_nct->total_non_ppn+$update_nct->ppn) < 300000) {
//                $materai = 0;
            }else{
                $materai = 0;
            }
            $update_nct->materai = $materai;	
            $update_nct->total = $update_nct->total_non_ppn+$update_nct->ppn+$update_nct->materai;	
            
            $update_nct->save();
            
            return back()->with('success', 'Invoice berhasih dibuat.');
//            return json_encode(array('success' => true, 'message' => 'Invoice berhasih dibuat.'));
            
        }
        
//        return $container;
        return back()->with('error', 'Something went wrong, please try again later.');
//        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }

  
  
  
  
  
  
  
    public function reportRealisasiPlp($container_id)
    {
        $container = DBContainer::whereIn('TCONTAINER_PK', explode(',',$container_id))->get();

        $tanggal = array();
        $kapal = array();
        $eta = array();
        $box20 = 0;$box40 = 0;$box45 = 0;
        
        foreach ($container as $cont):
            if(!in_array($cont->TGLMASUK, $tanggal)):
                $tanggal[] = $cont->TGLMASUK;
            endif;
            if(!in_array(date('d F Y', strtotime($cont->ETA)), $eta)):
                $eta[] = date('d F Y', strtotime($cont->ETA));
            endif;
            $exkapal = $cont->VESSEL.' V. '.$cont->VOY;
            if(!in_array($exkapal, $kapal)):
                $kapal[] = $exkapal;
            endif;
            
            $box20 = ($cont->SIZE == 20) ? $box20+1 : $box20;
            $box40 = ($cont->SIZE == 40) ? $box40+1 : $box40;
            $box45 = ($cont->SIZE == 45) ? $box45+1 : $box45;
            
            $no_surat = \App\Models\TpsResponPlp::where('NO_PLP', $cont->NO_PLP)->value('NO_SURAT');
            array_add($cont, 'NO_SURAT', $no_surat);
            
        endforeach;
        
        usort($tanggal, function($a, $b) {
            $dateTimestamp1 = strtotime($a);
            $dateTimestamp2 = strtotime($b);

            return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
        });
        
        $min_date = $tanggal[0];
        $max_date = $tanggal[count($tanggal) - 1];
            
        if($max_date && $min_date != $max_date):
            $tgl = date('d F Y', strtotime($min_date)).' s/d '.date('d F Y', strtotime($max_date));
        else:
            $tgl = date('d F Y', strtotime($min_date));
        endif;
        
        $header = array(
            'tpk' => ($container[0]->KD_TPS_ASAL == 'NCT1') ? 'NPCT1' : $container[0]->KD_TPS_ASAL,
            'lokasi' => ($container[0]->GUDANG_TUJUAN == 'ARN1') ? 'BARAT' : 'UTARA',
            'jenis' => $container[0]->jenis_container,
            'consignee' => $container[0]->CONSIGNEE,
            'tanggal' => $tgl,
            'kapal' => implode(', ', $kapal),
            'eta' => implode(', ', $eta),
            'spk' => $container[0]->NOSPK,
        );
        
        $footer = array(
            'box20' => $box20,
            'box40' => $box40,
            'box45' => $box45,
            'jumlah' => $box20+$box40+$box45
        );
        
        $data['header'] = $header;
        $data['footer'] = $footer;
        $data['containers'] = $container;
        
        return view('print.realisasi-plp')->with($data);
        $pdf = \PDF::loadView('print.invoice', $data)->setPaper('a4');
        
        return $pdf->stream($data['invoice']->no_invoice.'-'.date('dmy').'.pdf');
    }
	
	  public function reportRekapRealisasiPlp(Request $request)
    {
 
		//$tglmulai = date_create(date('Y-m-d',strtotime($request->tgl_masuk_start)));
		//$tglakhir = date_create(date('Y-m-d',strtotime($request->tgl_masuk_start)));
		
		$tglmulai = $request->tgl_masuk_start;
		$tglakhir = $request->tgl_masuk_akhir;
		
		$lokasi_gudang=$request->lokasi_gudang;
		$tps_asal=$request->tps_asal;
		
	    $dry = array(
            'DRY',
            'OPEN TOP',
            'FLAT TRACK RF',
            'FLAT TRACK OH',
            'FLAT TRACK OW',
            'FLAT TRACK OL'
        );			
			
    
        $bb = array(
            'Class BB Standar 3',
            'Class BB Standar 8',
            'Class BB Standar 9',
            'Class BB Standar 4,1',
			'Class BB Standar 4,2',
			'Class BB Standar 4,3',
            'Class BB Standar 6',
            'Class BB Standar 2,2',
            "Class BB High Class 2,1",
            "Class BB High Class 5,1",
            "Class BB High Class 6,1",
            "Class BB High Class 5,2"
        );
		
        $reefer = array(
            'REFFER RF',
            'REFFER RECOOLING',
            'REEFER RF',
            'REEFER RECOOLING',
            'REEFER RECOOLING BB 2.2',
			'REEFER RECOOLING BB 4.1',
			'REEFER RECOOLING BB 4.2',
			'REEFER RECOOLING BB 4.3',
			'REEFER RECOOLING BB 6',
			'REEFER RECOOLING BB 3',
			'REEFER RECOOLING BB 8',
			'REEFER RECOOLING BB 9',
            'REEFER RECOOLING BB 2.1',
			'REEFER RECOOLING BB 5.1',
			'REEFER RECOOLING BB 5.2',
			'REEFER RECOOLING BB 6.1'
        );
	
			
	       $container = DBContainer::select(\DB::raw('MONTH(TGL_PLP) as bulan') ,'jenis_container','GUDANG_TUJUAN', 'size',   \DB::raw('count(*) as jumlah'))
				 ->where('TGL_PLP','>=',$tglmulai)->where('TGL_PLP','<=',$tglakhir)
                 ->groupBy(\DB::raw('MONTH(TGL_PLP)'),'jenis_container','GUDANG_TUJUAN', 'size')
                 ->get();

         

        
        $arn120dry=array();
	
        foreach ($container as $cont):
           $bulan = $cont->bulan;
		   for ($x = 1; $x <= 12; $x++) {
	//		 $jmlbulan=x$;  
            if(  $cont->bulan==$x){
            	if(	 $cont->GUDANG_TUJUAN=='ARN1'){
					if($cont->size==20){
					  if(in_array($cont->jenis_container, $dry)){
						$arn120dry[$x] = $arn120dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn120bb[$x] = $arn120bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn120reefer[$x] = $arn120reefer[$x]+$cont->jumlah;
					  }
					}  
					if($cont->size==40){
					  if(in_array($cont->jenis_container, $dry)){
						$arn140dry[$x] = $arn140dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn140bb[$x] = $arn140bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn140reefer[$x] = $arn140reefer[$x]+$cont->jumlah;
					  }
					}
					if($cont->size==45){
					  if(in_array($cont->jenis_container, $dry)){
						$arn140dry[$x] = $arn140dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn140bb[$x] = $arn140bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn140reefer[$x] = $arn140reefer[$x]+$cont->jumlah;
					  }
					}  					
				}
            	if(	 $cont->GUDANG_TUJUAN=='ARN3'){
					if($cont->size==20){
					  if(in_array($cont->jenis_container, $dry)){
						$arn320dry[$x] = $arn320dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn320bb[$x] = $arn320bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn320reefer[$x] = $arn320reefer[$x]+$cont->jumlah;
					  }
					}  
					if($cont->size==40){
					  if(in_array($cont->jenis_container, $dry)){
						$arn340dry[$x] = $arn340dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn340bb[$x] = $arn340bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn340reefer[$x] = $arn340reefer[$x]+$cont->jumlah;
					  }
					}
					if($cont->size==45){
					  if(in_array($cont->jenis_container, $dry)){
						$arn340dry[$x] = $arn340dry[$x]+$cont->jumlah;
					  }
					  if(in_array($cont->jenis_container, $bb)){
						$arn340bb[$x] = $arn340bb[$x]+$cont->jumlah;
					  }
					   if(in_array($cont->jenis_container, $reefer)){
						$arn340reefer[$x] = $arn340reefer[$x]+$cont->jumlah;
					  }
					}  					
				}				
				
			$box20arn1dry = $box20arn1dry+$arn120dry[$x];
			$box20arn3dry = $box20arn3dry+$arn320dry[$x];
            $box40arn1dry = $box40arn1dry+$arn140dry[$x];
			$box40arn3dry = $box40arn3dry+$arn340dry[$x];
            $box20arn1bb = $box20arn1bb+$arn120bb[$x];
            $box40arn1bb = $box40arn1bb+$arn140bb[$x];
			$box20arn3bb = $box20arn3bb+$arn320bb[$x];
            $box40arn3bb = $box40arn3bb+$arn340bb[$x];
			$box20arn1reefer = $box20arn1reefer+$arn120reefer[$x];
            $box40arn1reefer = $box40arn1reefer+$arn140reefer[$x];
			$box20arn3reefer = $box20arn3reefer+$arn320reefer[$x];
            $box40arn3reefer = $box40arn3reefer+$arn340reefer[$x];
			}                		  
           }


		  
           
           
            
           // $no_surat = \App\Models\TpsResponPlp::where('NO_PLP', $cont->NO_PLP)->value('NO_SURAT');
           // array_add($cont, 'NO_SURAT', $no_surat);
            
        endforeach;
       //$bulan= array('bulan'=>$bulan);	   
        	
	   $detils =  array(
            'arn120dry' => $arn120dry,
            'arn320dry' => $arn320dry,
            'arn140dry' => $arn140dry,
            'arn340dry' => $arn340dry		
        );
        
        $header = array(
            'tpk' 			=> $tps_asal,
            'lokasi' 		=> $lokasi_gudang,           
            'tanggalmulai' 	=> $tglmulai,
            'tanggalakhir' 	=> $tglakhir
   
        );
        
        $footer = array(
            'box20arn1dry' => $box20arn1dry,
            'box20arn3dry' => $box20arn3dry,
            'box40arn1dry' => $box40arn1dry,
            'box40arn3dry' => $box40arn3dry,
			'box20arn1bb' => $box20arn1bb,
            'box40arn1bb' => $box40arn1bb,
			'box20arn3bb' => $box20arn3bb,
            'box40arn3bb' => $box40arn3bb,
            'box20arn1reefer' => $box20arn1reefer,
            'box40arn1reefer' => $box40arn1reefer,
			'box20arn3reefer' => $box20arn3reefer,
            'box40arn3reefer' => $box40arn3reefer
        );
        
        $data['header'] = $header;
        $data['footer'] = $footer;
        //$data['containers'] = $container;
		$data['containers'] = $detils;
		//$data['bulan'] = $jmlbulan;
        
        return view('print.realisasi-rekap-plp')->with($data);
        $pdf = \PDF::loadView('print.invoice', $data)->setPaper('a4');
        
        return $pdf->stream($data['invoice']->no_invoice.'-'.date('dmy').'.pdf');
    }
	
	
	
    
    public function releaseGetDataSppb(Request $request)
    {
        $container_id = $request->id;  
        $kd_dok = $request->kd_dok;
        $container = DBContainer::find($container_id);
	      
        $sppb = '';
        $sppbcont='';
		$nopib='';
		$tglpib='';
        if($kd_dok == 1){
			
            $sppb = \App\Models\TpsSppbPib::where(array('NO_BL_AWB' => $container->NO_BL_AWB))
                    ->orWhere('NO_MASTER_BL_AWB', $container->NO_BL_AWB)
                    ->first();
					
			if($sppb){
			$sppbcont= \App\Models\TpsSppbPibCont::where('CAR',$sppb->CAR)
			->where('NO_CONT', $container->NOCONTAINER)
			->first();  	
						
            $nopib= $sppb->NO_PIB;
			$tglpib= date('Y-m-d', strtotime($sppb->TGL_PIB));
			
			if($sppb->NO_BL_AWB !=''){
				$nobl=$sppb->NO_BL_AWB ;
			}else{$nobl=$sppb->NO_MASTER_BL_AWB;} 	
				
			
			//update BL party continercy with dok sppb 
		    $sppbcontupd = \App\Models\TpsSppbPibCont::where('CAR',$sppb->CAR)->get();  
	        foreach ($sppbcontupd  as $contupd) :
     		//	
                  $sppbcont=array();
				  
				  $sppbcont['NO_SPPB'] = $sppb->NO_SPPB;
                  $sppbcont['TGL_SPPB'] = date('Y-m-d', strtotime($sppb->TGL_SPPB));
				  $sppbcont['NO_DAFTAR_PABEAN'] = $nopib;
				  $sppbcont['TGL_DAFTAR_PABEAN'] = $tglpib;
				  $sppbcont['ID_CONSIGNEE'] = $sppb->NPWP_IMP;
				  $sppbcont['KD_DOK_INOUT'] = $kd_dok ;
				  $sppbcont['KODE_DOKUMEN'] = 'SPPB BC 2.0';
      
       	         $update= DBContainer::where('NO_BL_AWB',$nobl)
				   ->where('NOCONTAINER',$contupd->NO_CONT) ->update($sppbcont);
	
			
            endforeach ;
			
			
			
		    }
        }elseif($kd_dok == 2){
            $sppb = \App\Models\TpsSppbBc::where(array('NO_BL_AWB' => $container->NO_BL_AWB))
                    ->orWhere('NO_MASTER_BL_AWB', $container->NO_BL_AWB)
                    ->first();
					
			if($sppb){
			$sppbcont= \App\Models\TpsSppbBcCont::where('CAR',$sppb->CAR)
			->where('NO_CONT', $container->NOCONTAINER)
			->first();  
			
            $nopib= $sppb->NO_PIB;
			$tglpib= date('Y-m-d', strtotime($sppb->TGL_PIB));		
			
			if($sppb->NO_BL_AWB !=''){
				$nobl=$sppb->NO_BL_AWB ;
			}else{$nobl=$sppb->NO_MASTER_BL_AWB;} 	
			
			
				//update BL party continercy with dok sppb 
		    $sppbcontupd = \App\Models\TpsSppbBcCont::where('CAR',$sppb->CAR)->get();  
	        foreach ($sppbcontupd  as $contupd) :
     		//	
                  $sppbcont=array();
				  
				  $sppbcont['NO_SPPB'] = $sppb->NO_SPPB;
                  $sppbcont['TGL_SPPB'] = date('Y-m-d', strtotime($sppb->TGL_SPPB));
				  $sppbcont['NO_DAFTAR_PABEAN'] = $nopib;
				  $sppbcont['TGL_DAFTAR_PABEAN'] = $tglpib;
				  $sppbcont['ID_CONSIGNEE'] = $sppb->NPWP_IMP;
				  $sppbcont['KD_DOK_INOUT'] = $kd_dok ;
				  $sppbcont['KODE_DOKUMEN'] = 'SPPB BC 2.3';
				  //if($contupd->status_bc==''){
				  $sppbcont['status_bc'] = 'HOLD';
				  //}
      
       	         $update= DBContainer::where('NO_BL_AWB',$nobl) ->where('release_bc','N')
				   ->where('NOCONTAINER',$contupd->NO_CONT) ->update($sppbcont);
	
			
            endforeach ;

			
			
			
			
			
			}
        }elseif($kd_dok == 41||$kd_dok == 44||$kd_dok == 56){
            $sppb = \App\Models\TpsDokPabean::select('NO_DOK_INOUT as NO_SPPB','TGL_DOK_INOUT as TGL_SPPB','NPWP_IMP','NO_BL_AWB as NO_BL_AWB','NO_MASTER_BL_AWB as NO_MASTER_BL_AWB','CAR')
                    ->where(array('KD_DOK_INOUT' => $kd_dok, 'NO_BL_AWB' => $container->NO_BL_AWB))
                    ->first();
			
			if($sppb){
			$sppbcont= \App\Models\TpsDokPabeanCont::where('CAR',$sppb->CAR)
			->where('NO_CONT', $container->NOCONTAINER)
			->first();  		
             
			$arraysppb = explode('/', $sppb->NO_SPPB);
			$nopib= $arraysppb[0];
			$tglpib= date('Y-m-d', strtotime($sppb->TGL_SPPB));
			}
			
			if($sppb->NO_BL_AWB !=''){
				$nobl=$sppb->NO_BL_AWB ;
			}else{$nobl=$sppb->NO_MASTER_BL_AWB;} 	
			
			$nama_kd_dok = \App\Models\KodeDok::find($kd_dok);
            $nama_dok = $nama_kd_dok->name;
			
			//update BL party continercy with dok sppb 
			$sppbcontupd = \App\Models\TpsDokPabeanCont::where('CAR',$sppb->CAR)->get();  
	        foreach ($sppbcontupd  as $contupd) :
     		//	
                  $sppbcont=array();
				  
				  $sppbcont['NO_SPPB'] = $sppb->NO_SPPB;
                  $sppbcont['TGL_SPPB'] = date('Y-m-d', strtotime($sppb->TGL_SPPB));
				  $sppbcont['NO_DAFTAR_PABEAN'] = $nopib;
				  $sppbcont['TGL_DAFTAR_PABEAN'] = $tglpib;
				  $sppbcont['ID_CONSIGNEE'] = $sppb->NPWP_IMP;
				  $sppbcont['KD_DOK_INOUT'] = $kd_dok ;
				  $sppbcont['KODE_DOKUMEN'] = $nama_dok;
				  //if($contupd->status_bc==''){
				  $sppbcont['status_bc'] = 'HOLD';
				  //}
      
       	         $update= DBContainer::where('NO_BL_AWB',$nobl) ->where('release_bc','N')
				   ->where('NOCONTAINER',$contupd->NO_CONT) ->update($sppbcont);
	
			
            endforeach ;
			
        }else{
            $sppb = \App\Models\TpsDokManual::select('NO_DOK_INOUT as NO_SPPB','TGL_DOK_INOUT as TGL_SPPB','ID_CONSIGNEE as NPWP_IMP','CONSIGNEE as CONSIGNEE' , 'NO_BL_AWB as NO_BL_AWB', 'ID')
                    ->where(array('KD_DOK_INOUT' => $kd_dok, 'NO_BL_AWB' => $container->NO_BL_AWB))
                    ->first();
					
			if($sppb){
			$sppbcont= \App\Models\TpsDokManualCont::where('ID',$sppb->ID)
			->where('NO_CONT', $container->NOCONTAINER)
			->first();  		
		    }
			
            if($sppb){
                $tgl_sppb = explode('/', $sppb->TGL_SPPB);
                $sppb->TGL_SPPB = $tgl_sppb[2].'-'.$tgl_sppb[1].'-'.$tgl_sppb[0];
            
			
			$arraysppb = explode('/', $sppb->NO_SPPB);
			$nopib= $arraysppb[0];
			$tglpib= date('Y-m-d', strtotime($sppb->TGL_SPPB));
			}
			
			if($sppb->NO_BL_AWB !=''){
				$nobl=$sppb->NO_BL_AWB ;
			}else{$nobl='';} 	
			
			$nama_kd_dok = \App\Models\KodeDok::find($kd_dok);
            $nama_dok = $nama_kd_dok->name;
			
			//update BL party continercy with dok sppb 
			$sppbcontupd = \App\Models\TpsDokManualCont::where('ID',$sppb->ID)->get();  
	        foreach ($sppbcontupd  as $contupd) :
     		//	
                  $sppbcont=array();
				  
				  $sppbcont['NO_SPPB'] = $sppb->NO_SPPB;
                  $sppbcont['TGL_SPPB'] = date('Y-m-d', strtotime($sppb->TGL_SPPB));
				  $sppbcont['NO_DAFTAR_PABEAN'] = $nopib;
				  $sppbcont['TGL_DAFTAR_PABEAN'] = $tglpib;
				  $sppbcont['ID_CONSIGNEE'] = $sppb->NPWP_IMP;
				  $sppbcont['KD_DOK_INOUT'] = $kd_dok ;
				  $sppbcont['KODE_DOKUMEN'] = $nama_dok;
				  //if($contupd->status_bc==''){
				  $sppbcont['status_bc'] = 'HOLD';
				  //}				  
				  if($kd_dok =='9'){
				   $sppbcont['bcf_consignee'] = $sppb->CONSIGNEE;
				  }
				  
      
       	         $update= DBContainer::where('NO_BL_AWB',$nobl) ->where('release_bc','N')
				   ->where('NOCONTAINER',$contupd->NO_CONT) ->update($sppbcont);
	
			
            endforeach ;
		
        }
        
        if($sppb){
			if($kd_dok =='9'){
				   $bcf_consignee = $sppb->CONSIGNEE;
		    }else{
				 $bcf_consignee ='';
			}
			
		   if($sppbcont){
            $arraysppb = explode('/', $sppb->NO_SPPB);
            $datasppb = array(
//                'NO_SPPB' => $arraysppb[0],
                'NO_SPPB' => $sppb->NO_SPPB,
                'TGL_SPPB' => date('Y-m-d', strtotime($sppb->TGL_SPPB)),
				'NO_PIB' => $nopib,
                'TGL_PIB' => $tglpib,
                'NPWP' => $sppb->NPWP_IMP,
				'bcf_consignee' =>$bcf_consignee
            );
			
            return json_encode(array('success' => true, 'message' => 'Get Data SPPB has been success.', 'data' => $datasppb));
           }else{
			    return json_encode(array('success' => false, 'message' => 'No container Beda dangan SPPB.'));
		   }
		}else{
            return json_encode(array('success' => false, 'message' => 'Data SPPB Tidak ditemukan.'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function gateinUploadPhoto(Request $request)
    {
        $picture = array();
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            $destinationPath = base_path() . '/public/uploads/photos/container/fcl/'.$request->no_cont;
            if (!\File::isDirectory($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            $i = 1;
            foreach($files as $file){
//                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
//                $img = \Image::make($file)->orientate();
//                $img->resize(500, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
                $filename = date('dmyHis').'_'.str_slug($request->no_cont).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
//                $img->save($destinationPath.'/'.$filename);
                $i++;
            }
            // update to Database
            $container = DBContainer::find($request->id_cont);
            $oldJson = json_decode($container->photo_gatein_extra);
            $newJson = array_collapse([$oldJson,$picture]);
            $container->photo_gatein_extra = json_encode($newJson);
            if($container->save()){
                return back()->with('success', 'Photo for Container '. $request->no_cont .' has been uploaded.');
            }else{
                return back()->with('error', 'Photo uploaded, but not save in Database.');
            }
            
        } else {
            return back()->with('error', 'Something wrong!!! Can\'t upload photo, please try again.');
        }
    }
    
    public function releaseUploadPhoto(Request $request)
    {
        $picture = array();
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            $destinationPath = base_path() . '/public/uploads/photos/container/fcl/'.$request->no_cont;
            if (!\File::isDirectory($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            $i = 1;
            foreach($files as $file){
//                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
//                $img = \Image::make($file)->orientate();
//                $img->resize(500, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
                $filename = date('dmyHis').'_'.str_slug($request->no_cont).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
//                $img->save($destinationPath.'/'.$filename);
                $i++;
            }
            // update to Database
            $container = DBContainer::find($request->id_cont);
            $oldJson = json_decode($container->photo_release_extra);
            $newJson = array_collapse([$oldJson,$picture]);
            $container->photo_release_extra = json_encode($newJson);
            if($container->save()){
                return back()->with('success', 'Photo for Container '. $request->no_cont .' has been uploaded.');
            }else{
                return back()->with('error', 'Photo uploaded, but not save in Database.');
            }
            
        } else {
            return back()->with('error', 'Something wrong!!! Can\'t upload photo, please try again.');
        }
    }
    
        public function behandleUploadPhoto(Request $request)
    {
        $picture = array();
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            $destinationPath = base_path() . '/public/uploads/photos/container/fcl/'.$request->no_cont;
            if (!\File::isDirectory($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }
            $i = 1;
            foreach($files as $file){
//                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
//                $img = \Image::make($file)->orientate();
//                $img->resize(500, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                });
                $filename = date('dmyHis').'_'.str_slug($request->no_cont).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
//                $img->save($destinationPath.'/'.$filename);
                $i++;
            }
            // update to Database
            $container = DBContainer::find($request->id_cont);
            $oldJson = json_decode($container->photo_behandle);
            $newJson = array_collapse([$oldJson,$picture]);
            $container->photo_behandle = json_encode($newJson);
            if($container->save()){
                return back()->with('success', 'Photo for Container '. $request->no_cont .' has been uploaded.');
            }else{
                return back()->with('error', 'Photo uploaded, but not save in Database.');
            }
            
        } else {
            return back()->with('error', 'Something wrong!!! Can\'t upload photo, please try again.');
        }
    }
    
    public function changeStatusBc($id)
    { 
        $container = DBContainer::find($id);
//        $container->status_bc = 'RELEASE';
        $container->status_bc = '';
        $container->release_bc = 'Y';
        $container->release_bc_date = date('Y-m-d H:i:s');
        $container->release_bc_uid = \Auth::getUser()->name;     
		
        if($container->save()){
            $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'active');
            return json_encode(array('success' => true, 'message' => 'Status has been Change!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function changeStatusFlag($id)
    {
        $container = DBContainer::find($id);
        $container->flag_bc = 'N';
              
        if($container->save()){

            return json_encode(array('success' => true, 'message' => 'Status has been Change!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function lockFlag(Request $request)
    {
        $container_id = $request->id;
        $alasan = $request->alasan_segel;
//        $lainnya = $request->alasan_lainnya;
        
//        return $request->all();
        
        $picture = array();
        if ($request->hasFile('photos_flag')) {
            $files = $request->file('photos_flag');
            $destinationPath = base_path() . '/public/uploads/photos/flag/fcl';
            $i = 1;
            foreach($files as $file){
//                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                $filename = date('dmyHis').'_'.str_slug($request->no_flag_bc).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
                $i++;
            } 
        }
        
        $container = DBContainer::find($container_id);
        $container->flag_bc = 'Y';
        $container->status_bc = 'SEGEL';
        $container->no_flag_bc = $request->no_flag_bc;
        $container->description_flag_bc = $request->description_flag_bc;
//        if($alasan == 'Lainnya' && !empty($lainnya)){
//            $container->alasan_segel = $lainnya;
//        }else{
            $container->alasan_segel = $alasan;
//        }
        $container->photo_lock = json_encode($picture);
            
        if($alasan == 'IKP / Temuan Lapangan'){
            $container->BEHANDLE = 'Y';
            $container->status_behandle = 'New';
        }
        
        if($container->save()){
            // Save to log
            $datalog = array(
                'ref_id' => $container_id,
                'ref_type' => 'fcl',
                'no_segel'=> $container->no_flag_bc,
                'alasan' => $container->alasan_segel,
                'keterangan' => $container->description_flag_bc,
                'photo' => $container->photo_lock,
                'action' => 'lock',
                'uid' => \Auth::getUser()->name
            );
            $this->addLogSegel($datalog);
            
            $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'hold');
            
            return back()->with('success', 'Flag has been locked.')->withInput();
        }
        
        return back()->with('error', 'Something wrong, please try again.')->withInput();
    }
    
    public function unlockFlag(Request $request)
    {
        $container_id = $request->id;
        $alasan = $request->alasan_lepas_segel;
        
        $picture = array();
        if ($request->hasFile('photos_unflag')) {
            $files = $request->file('photos_unflag');
            $destinationPath = base_path() . '/public/uploads/photos/unflag/fcl';
            $i = 1;
            foreach($files as $file){
//                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                $filename = date('dmyHis').'_'.str_slug($request->no_unflag_bc).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
                $i++;
            } 
        }
        
        $container = DBContainer::find($container_id);
        $container->flag_bc = 'N';
        if($container->release_bc == 'Y'){
//            $container->status_bc = 'RELEASE';
            $container->status_bc = '';
        }else{
            if($container->KD_DOK_INOUT > 1){
                $container->status_bc = 'HOLD';
                $container->TGLRELEASE = NULL;
                $container->JAMRELEASE = NULL;
                $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'hold');
            }else{
//                $container->status_bc = 'RELEASE';
                $container->status_bc = '';
                $this->changeBarcodeStatus($container->TCONTAINER_PK, $container->NOCONTAINER, 'Fcl', 'active');
            }
        }
        
        $container->no_unflag_bc = $request->no_unflag_bc;
        $container->description_unflag_bc = $request->description_unflag_bc;
        $container->alasan_lepas_segel = $alasan;
        $container->photo_unlock = json_encode($picture);
        
        if($container->save()){
            // Save to log
            $datalog = array(
                'ref_id' => $container_id,
                'ref_type' => 'fcl',
                'no_segel'=> $container->no_unflag_bc,
                'alasan' => $container->alasan_lepas_segel,
                'keterangan' => $container->description_unflag_bc,
                'photo' => $container->photo_unlock,
                'action' => 'unlock',
                'uid' => \Auth::getUser()->name
            );
            $this->addLogSegel($datalog);
            
            return back()->with('success', 'Flag has been unlocked.')->withInput();
        }
        
        return back()->with('error', 'Something wrong, please try again.')->withInput();
    }
    
    public function viewFlagInfo($container_id)
    {
        $container = DBContainer::find($container_id);
        $data = \DB::table('log_segel')->where(array('ref_id' => $container_id,'ref_type' => 'fcl'))->get();
        return json_encode(array('success' => true, 'data' => $data, 'NOCONTAINER' => $container->NOCONTAINER, 'container' => $container));
    }
    
    public function changeStatusBehandle(Request $request)
    {
        $container_id = $request->id;
        $desc = $request->desc;
        $status = $request->status_behandle;
        
        $container = DBContainer::find($container_id);
        $container->status_behandle = $status;
        if($status == 'Checking'){
            $container->date_check_behandle = date('Y-m-d H:i:s');
            $container->desc_check_behandle = $desc;
        }else{
            $container->date_finish_behandle = date('Y-m-d H:i:s');
            $container->desc_finish_behandle = $desc;
            $container->TGLBEHANDLE = date('Y-m-d');
            $container->JAMBEHANDLE = date('H:i:s');
}

        if($container->save()){
            return back()->with('success', 'Status Behandle has been change.')->withInput();
        }
        
        return back()->with('error', 'Something wrong, please try again.')->withInput();

    }
    
    public function holdIndex()
    {
        $data['page_title'] = "FCL Dokumen HOLD";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Dokumen HOLD'
            ]
        ];        
        
        return view('import.fcl.bc-hold')->with($data);
    }
    
    public function segelIndex()
    {
        $data['page_title'] = "FCL Segel Merah";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Segel Merah'
            ]
        ];        
        
        $data['segel'] = \DB::table('alasan_segel')->get();
        
        return view('import.fcl.bc-segel')->with($data);
    }
	
	  public function lainIndex()
    {
        $data['page_title'] = "FCL Hold Lainnya";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Hold Lainnya'
            ]
        ];        
        
        $data['segel'] = \DB::table('alasan_segel')->get();
        
        return view('import.fcl.bc-lain')->with($data);
    }
    
    public function segelReport()
    {
        $data['page_title'] = "FCL Report Segel Merah";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Segel Merah'
            ]
        ];        
        
        return view('import.fcl.bc-segel-report')->with($data);
    }
    
    public function reportContainerIndex(Request $request)
    {
        $data['page_title'] = "FCL Report Container";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Container'
            ]
        ];   
        
        if($request->month && $request->year) {
            $month = $request->month;
            $year = $request->year;
        } else {
            $month = date('m');
            $year = date('Y');
        }
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
//        BY PLP
        $twenty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $fourty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $teus = ($twenty*1)+($fourty*2);
        $data['countbysize'] = array('twenty' => $twenty, 'fourty' => $fourty, 'total' => $twenty+$fourty, 'teus' => $teus);
        
        $jict = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $koja = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $mal = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $nct1 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $pldc = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        
        
//        BY GATEIN
        $twentyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $fourtyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $teusg = ($twentyg*1)+($fourtyg*2);
        $data['countbysizegatein'] = array('twenty' => $twentyg, 'fourty' => $fourtyg, 'total' => $twentyg+$fourtyg, 'teus' => $teusg);
        
        $jictg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $kojag = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $malg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $nct1g = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $pldcg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbytps'] = array('JICT' => array($jict, $jictg), 'KOJA' => array($koja, $kojag), 'MAL0' => array($mal, $malg), 'NCT1' => array($nct1, $nct1g), 'PLDC' => array($pldc, $pldcg));
        
//        BY DOKUMEN
        $bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc23 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 2)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc12 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 4)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc15 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 9)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc11 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bcf26 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 5)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbydoc'] = array('BC 2.0' => $bc20, 'BC 2.3' => $bc23, 'BC 1.2' => $bc12, 'BC 1.5' => $bc15, 'BC 1.1' => $bc11, 'BCF 2.6' => $bcf26);
        
        
        $data['totcounttpsp'] = array_sum(array($jict,$koja,$mal,$nct1,$pldc));
        $data['totcounttpsg'] = array_sum(array($jictg,$kojag,$malg,$nct1g,$pldcg));
        
        $data['month'] = $month;
        $data['year'] = $year;
        $data['gd'] = $gd;
        
        $this->updateYorByTeus();
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                    \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                    \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                    \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                    \DB::raw('SUM(total) as total'))
                    ->where('type', 'yor')
                    ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }
        
        return view('import.fcl.bc-report-container')->with($data);
    }
    
	   public function reportlogReleaseDokIndex(Request $request)
    {
        $data['page_title'] = "FCL Report Log Release Dok";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Lg Release Dok'
            ]
        ];   
        
        if($request->month && $request->year) {
            $month = $request->month;
            $year = $request->year;
        } else {
            $month = date('m');
            $year = date('Y');
        }
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
//        BY PLP
        $twenty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $fourty = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $teus = ($twenty*1)+($fourty*2);
        $data['countbysize'] = array('twenty' => $twenty, 'fourty' => $fourty, 'total' => $twenty+$fourty, 'teus' => $teus);
        
        $jict = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $koja = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $mal = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $nct1 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        $pldc = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGL_PLP) = '.$month)->whereRaw('YEAR(TGL_PLP) = '.$year)->count();
        
        
//        BY GATEIN
        $twentyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $fourtyg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('SIZE', 40)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $teusg = ($twentyg*1)+($fourtyg*2);
        $data['countbysizegatein'] = array('twenty' => $twentyg, 'fourty' => $fourtyg, 'total' => $twentyg+$fourtyg, 'teus' => $teusg);
        
        $jictg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'JICT')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $kojag = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'KOJA')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $malg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'MAL0')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $nct1g = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'NCT1')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $pldcg = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_TPS_ASAL', 'PLDC')->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbytps'] = array('JICT' => array($jict, $jictg), 'KOJA' => array($koja, $kojag), 'MAL0' => array($mal, $malg), 'NCT1' => array($nct1, $nct1g), 'PLDC' => array($pldc, $pldcg));
        
//        BY DOKUMEN
        $bc20 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 1)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc23 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 2)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc12 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 4)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc15 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 9)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bc11 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 20)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $bcf26 = DBContainer::where('KODE_GUDANG', 'like', $gd)->where('KD_DOK_INOUT', 5)->whereRaw('MONTH(TGLMASUK) = '.$month)->whereRaw('YEAR(TGLMASUK) = '.$year)->count();
        $data['countbydoc'] = array('BC 2.0' => $bc20, 'BC 2.3' => $bc23, 'BC 1.2' => $bc12, 'BC 1.5' => $bc15, 'BC 1.1' => $bc11, 'BCF 2.6' => $bcf26);
        
        
        $data['totcounttpsp'] = array_sum(array($jict,$koja,$mal,$nct1,$pldc));
        $data['totcounttpsg'] = array_sum(array($jictg,$kojag,$malg,$nct1g,$pldcg));
        
        $data['month'] = $month;
        $data['year'] = $year;
        $data['gd'] = $gd;
        
        $this->updateYorByTeus();
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                    \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                    \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                    \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                    \DB::raw('SUM(total) as total'))
                    ->where('type', 'yor')
                    ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }
        
        return view('import.fcl.bc-report-logreleasedok')->with($data);
    }
	
    public function reportInventoryIndex(Request $request)
    {
        $data['page_title'] = "FCL Report Stock";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'FCL Report Stock'
            ]
        ];        
        
        if($request->gd) {
            $gd = $request->gd;
        } else {
            $gd = '%';
        }
        
        $this->updateYorByTeus();
        if($gd == '%'){
            $data['yor'] = \App\Models\SorYor::select(
                    \DB::raw('SUM(kapasitas_default) as kapasitas_default'),
                    \DB::raw('SUM(kapasitas_terisi) as kapasitas_terisi'),
                    \DB::raw('SUM(kapasitas_kosong) as kapasitas_kosong'),
                    \DB::raw('SUM(total) as total'))
                    ->where('type', 'yor')
                    ->first();
        }else{
            $data['yor'] = \App\Models\SorYor::where('type', 'yor')->where('gudang', $gd)->first();
        }
        $data['gd'] = $gd;
        
        return view('import.fcl.bc-inventory')->with($data);
    }
    
    public function releaseVerify($id, $no)
    {
        $cont = DBContainer::find($id);
        
        // Verify Container
        if($cont->NOCONTAINER == $no){
            return json_encode(array('success' => true, 'message' => 'Nomor Kontainer Sesuai!'));
        }else{
            return json_encode(array('success' => false, 'message' => 'Nomor Kontainer TIDAK Sesuai, silahkan periksa kembali!!!'));
        }
    }
}
