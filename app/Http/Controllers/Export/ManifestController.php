<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Models\ManifestExp as DBManifest;
use App\Models\ContainerExp as DBContainer;
use App\Models\Perusahaan as DBPerusahaan;
use App\Models\Packing as DBPacking;
use App\Models\TpsDokNPE as DBNpe;
use App\Models\Perusahaan as DBConsignee;
use App\Models\Packing as DBPack;
use App\Models\Barcode as DBGate;
use App\Models\TpsDokManual as DBManual;
use App\Models\TpsDokManualKms as DBManualKms;

use App\Models\TpsCoariKms as DBCoari;
use App\Models\TpsCoariKmsDetail as DBCoariDetail;

class ManifestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Export Manifest";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Manifest'
            ]
        ];        
        
        $data['manifest'] = DBManifest::orderBy('sor_update', 'desc')->orderBy('TGL_PACK', 'desc')->get();
        $data['packings'] = DBPacking::get();

        return view('export.manifest.main')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function uploadXlsManifest(Request $request)
     {
         $path = $request->file('filexls')->getRealPath();
         $data = Excel::load($path)->get();
     
         if ($data->count()) {
             foreach ($data as $key => $value) {

                $tglEntryArray = explode(' ', $value->{'tgl_entry'});
                $perusahaan = DBConsignee::where('NAMAPERUSAHAAN', $value->{'nama_consignee'})->where('NPWP', $value->{'npwp_consignee'})->first();
                $packing = DBPack::where(function($query) use ($value) {
                    $query->where('NAMAPACKING', $value->{'merk_kemasan'})
                          ->orWhere('KODEPACKING', $value->{'jenis_kemasan'});
                })
                ->first();
                if (!$perusahaan) {
                    $perusahaan = DBConsignee::create([
                        'NAMAPERUSAHAAN' => $value->{'nama_consignee'},
                        'NPWP' => $value->{'npwp_consignee'},
                        'UID'=>\Auth::getUser()->name,
                        // tambahkan kolom sesuai kebutuhan
                    ]);
                }

                if (!$packing) {
                    $packing = DBPack::create([
                        'NAMAPACKING' => $value->{'merk_kemasan'},
                        'KODEPACKING' => $value->{'jenis_kemasan'},
                        'UID'=>\Auth::getUser()->name,
                    ]);
                }
                $manifest = DBManifest::create([
                    'NO_PACK' => $value->{'no_packing_list'},
                    'TGL_PACK' => $value->{'tgl_packing_list'},
                    'DESCOFGOODS' => $value->{'ur_barang'},
                    'CONSIGNEE'  => $value->{'nama_consignee'},
                    'NPWP_CONSIGNEE'  => $value->{'npwp_consignee'},
                    'TCONSIGNEE_FK' => $perusahaan->TPERUSAHAAN_PK,
                    'NAMA_IMP'  => $value->{'nama_penerima'},
                    'ALAMAT_IMP'  => $value->{'almt_penerima'},
                    'PEL_MUAT' =>$value->{'pelabuhan_asal'},
                    'PEL_BONGKAR' =>$value->{'pelabuhan_bongkar'},
                    'PEL_TRANSIT' =>$value->{'pelabuhan_transit'},
                    'TPACKING_FK'=>$packing->TPACKING_PK,
                    'KODE_KEMAS' =>$value->{'jenis_kemasan'},
                    'NAMAPACKING' =>$value->{'merk_kemasan'},
                    'QUANTITY' =>$value->{'jumlah_kemasan'},
                    'WEIGHT' =>$value->{'bruto'},
                    'MEAS' =>$value->{'volume'},
                    'UID'=>\Auth::getUser()->name,
       
                    // tambahkan kolom sesuai kebutuhan
                ]);
             }
            //  dd($data);
     
             return back()->with('success', 'Data imported successfully!');
         }
     
         return back()->with('error', 'Error in data file.');
     }
    public function create()
    {
        //
    }

    public function createManual(Request $request)
    {

        $idPerusahaan = $request->TCONSIGNEE_FK;
        $consignee = DBConsignee::where('TPERUSAHAAN_PK', $idPerusahaan)->first();

        $idPack = $request->TPACKING_FK;
        $pack = DBpack::where('TPACKING_PK', $idPack)->first();

        $noPack = $request->NO_PACK;
        $TGLPack = $request->TGL_PACK;
        if ($TGLPack == NULL || $noPack == NULL) {
            return back()->with('error', 'Form Not Completed');
        }

        // dd($idPerusahaan, $idPack);
        $manifest = DBManifest::create([
            'NO_PACK'=> $request->NO_PACK,
            'TGL_PACK'=> $request->TGL_PACK,
            'DESCOFGOODS'=> $request->DESCOFGOODS,
            'CONSIGNEE'=> $consignee->NAMAPERUSAHAAN,
            'NPWP_CONSIGNEE'=> $consignee->NPWP,
            'TCONSIGNEE_FK'=> $idPerusahaan,
            'NAMA_IMP'=> $request->NAMA_IMP,
            'ALAMAT_IMP'=> $request->ALAMAT_IMP,
            'PEL_MUAT' => $request->PEL_MUAT,
            'PEL_BONGKAR' => $request->PEL_BONGKAR,
            'PEL_TRANSIT' => $request->PEL_TRANSIT,
            'TPACKING_FK'=> $idPack,
            'KODE_KEMAS'=> $pack->KODEPACKING,
            'NAMAPACKING'=> $pack->NAMAPACKING,
            'QUANTITY'=> $request->QUANTITY,
            'WEIGHT'=> $request->WEIGHT,
            'MEAS'=> $request->MEAS,
            'QUANTITY' =>$request->QUANTITY,
            'UID'=> \Auth::getUser()->name,
        ]);
        
        return redirect()->route('exp-manifest-index')->with('success', 'Data imported successfully!');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->json()->all(); 
        unset($data['id'], $data['delete_photo'], $data['_token'], $data['undefined']);
        
        $container = DBContainer::find($data['TCONTAINER_FK']);  
        
        
        $num = 0; 
//        $manifestID = DBManifest::select('NOTALLY')->where('TJOBORDER_FK',$container->TJOBORDER_FK)->count();
        $manifestID = DBManifest::select('NOTALLY')->where('TJOBORDER_FK',$container->TJOBORDER_FK)->orderBy('TMANIFEST_PK', 'DESC')->first();
        if($manifestID){
            $tally = explode('.', $manifestID->NOTALLY);
            $num = intval($tally[1]);    
        }
//        $regID = str_pad(intval(($manifestID > 0 ? $manifestID : 0)+1), 3, '0', STR_PAD_LEFT);
        $regID = str_pad(intval(($num > 0 ? $num : 0)+1), 3, '0', STR_PAD_LEFT);
 
        $data['NOTALLY'] = $container->NoJob.'.'.$regID; 
        $data['TJOBORDER_FK'] = $container->TJOBORDER_FK;
            $packing = DBPacking::find($data['TPACKING_FK']);
        if($packing){
            $data['KODE_KEMAS'] = $packing->KODEPACKING;
            $data['NAMAPACKING'] = $packing->NAMAPACKING;
        }
        $data['NOJOBORDER'] = $container->NoJob;
        $data['NOCONTAINER'] = $container->NOCONTAINER;
        $data['TCONSOLIDATOR_FK'] = $container->TCONSOLIDATOR_FK;
        $data['NAMACONSOLIDATOR'] = $container->NAMACONSOLIDATOR;
        $data['TLOKASISANDAR_FK'] = $container->TLOKASISANDAR_FK;
        $data['KD_TPS_ASAL'] = $container->KD_TPS_ASAL;
        $data['KD_TPS_TUJUAN'] = $container->KD_TPS_TUJUAN;
        $data['SIZE'] = $container->SIZE;
        $data['ETA'] = $container->ETA;
        $data['ETD'] = $container->ETD;
        $data['VESSEL'] = $container->VESSEL;
        $data['VOY'] = $container->VOY;
        $data['CALL_SIGN'] = $container->CALL_SIGN;
        $data['TPELABUHAN_FK'] = $container->TPELABUHAN_FK;     
        $data['NAMAPELABUHAN'] = $container->NAMAPELABUHAN;
        $data['PEL_MUAT'] = $container->PEL_MUAT;
        $data['PEL_BONGKAR'] = $container->PEL_BONGKAR;
        $data['PEL_TRANSIT'] = $container->PEL_TRANSIT;
        $data['NOMBL'] = $container->NOMBL;  
        $data['TGL_MASTER_BL'] = $container->TGL_MASTER_BL;
        $data['LOKASI_GUDANG'] = $container->LOKASI_GUDANG;
        $data['LOKASI_TUJUAN'] = $container->LOKASI_GUDANG;
        $data['NO_BC11'] = $container->NO_BC11;
        $data['TGL_BC11'] = $container->TGL_BC11;
        $data['NO_PLP'] = $container->NO_PLP;
        $data['TGL_PLP'] = $container->TGL_PLP;
        if($data['TSHIPPER_FK']){
            $data['SHIPPER'] = DBPerusahaan::getNameById($data['TSHIPPER_FK']);
        }
        if($data['TCONSIGNEE_FK']){
            $data['CONSIGNEE'] = DBPerusahaan::getNameById($data['TCONSIGNEE_FK']);
            $data['ID_CONSIGNEE'] = DBPerusahaan::getNpwpById($data['TCONSIGNEE_FK']);
        }
        $data['VALIDASI'] = 'N';
        if(is_numeric($data['TNOTIFYPARTY_FK'])) {
            $data['NOTIFYPARTY'] = DBPerusahaan::getNameById($data['TNOTIFYPARTY_FK']);
        }else{
            $data['NOTIFYPARTY'] = $data['TNOTIFYPARTY_FK'];
            unset($data['TNOTIFYPARTY_FK']);
        }
        $data['tglmasuk'] = $container->TGLMASUK;
        $data['jammasuk'] = $container->JAMMASUK;
        $data['tglentry'] = date('Y-m-d');
        $data['jamentry'] = date('H:i:s');
        $data['UID'] = $data['UID'] = \Auth::getUser()->name;
        
        $insert_id = DBManifest::insertGetId($data);
        
        if($insert_id){
            // Update Jumlah BL
            $countbl = DBManifest::where('TCONTAINER_FK', $data['TCONTAINER_FK'])->count();
            
            // Update Meas Wight           
            $sum_weight_manifest = DBManifest::select('WEIGHT')->where('TCONTAINER_FK', $data['TCONTAINER_FK'])->sum('WEIGHT');
            $sum_meas_marnifest = DBManifest::select('MEAS')->where('TCONTAINER_FK', $data['TCONTAINER_FK'])->sum('MEAS');         
            $container->MEAS = $sum_meas_marnifest;
            $container->WEIGHT = $sum_weight_manifest;
            $container->jumlah_bl = $countbl;
            
            if($container->save()){
                
                $sum_weight = DBContainer::select('WEIGHT')->where('TJOBORDER_FK', $container->TJOBORDER_FK)->sum('WEIGHT');
                $sum_meas = DBContainer::select('MEAS')->where('TJOBORDER_FK', $container->TJOBORDER_FK)->sum('MEAS');         
                \App\Models\Joborder::where('TJOBORDER_PK', $container->TJOBORDER_FK)
                        ->update(['MEASUREMENT' => $sum_meas, 'GROSSWEIGHT' => $sum_weight]);
                
            }

            return json_encode(array('success' => true, 'message' => 'Manifest successfully saved!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
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

    public function edit($id)
    {
        if ( !$this->access->can('show.lcl.manifest.edit') ) {
            return view('errors.no-access');
        }
        
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Edit LCL Manifest', 'slug' => 'show.lcl.manifest.edit', 'description' => ''));
        
        
        $data['page_title'] = "Edit Export Manifest";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('lcl-manifest-index'),
                'title' => 'Export Manifest'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];
        $data['manifest'] = DBManifest::where('TMANIFEST_PK', $id)->first();
        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id', 'NAMAPERUSAHAAN as name')->get();
        $data['packings'] = DBPacking::get();

        return view('export.manifest.edit')->with($data);
    }

    public function NPE(Request $request)
    {
        $KODE_DOKUMEN = $request->KODE_DOKUMEN;
        if ($KODE_DOKUMEN == NULL) {
            return response()->json(['success' => false, 'message' => 'Pilih Kode Dokumen Terlebih Dahulu']);
        }elseif ($KODE_DOKUMEN == '6') {
            $id = $request->id;
            $mani = DBManifest::where('TMANIFEST_PK', $id)->first();
            if ($mani) {
                $noNPE = $request->NO_NPE;
         
            $result = DBNpe::where('NONPE', $noNPE)->first();
            if ($result) {
                if ($result->JML_KMS == $mani->QUANTITY) {
                    $manifest = DBManifest::where('TMANIFEST_PK', $id)->update([
                        'KODE_DOKUMEN' =>'6',
                        'NO_NPE' => $noNPE,
                        'TGL_NPE' => $result->TGLNPE,
                        'NAMA_IMP' =>$result->NAMA_EKS,
                        'NPWP_IMP' =>$result->NPWP_EKS
                    ]);
                    return response()->json(['success' => true, 'message' => 'Data ditemukan', 'DATA'=>$manifest]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Nomor dokumen tidak ditemukan atau Berbeda', 'DATA'=>$manifest]);
                }
            }else {
                return response()->json(['success' => false, 'message' => 'Data Tidak Ditemukan']);
            }
            
          
            }else {
                return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
            }
        }elseif ($KODE_DOKUMEN == '37' || $KODE_DOKUMEN =='38' || $KODE_DOKUMEN =='8' || $KODE_DOKUMEN =='5' || $KODE_DOKUMEN =='45') {
            $id = $request->id;
            $mani = DBManifest::where('TMANIFEST_PK', $id)->first();
            if ($mani) {
                $noNPE = $request->NO_NPE;
                $result = DBManual::where('KD_DOK_INOUT', $KODE_DOKUMEN)->where('NO_DOK_INOUT', $noNPE)->first();
                if ($result) {
                    $qty = DBManualKms::where('TPS_DOKMANUALXML_FK', $result->TPS_DOKMANUALXML_PK)->first();
                    if ($qty->JML_KMS == $mani->QUANTITY) {
                        $manifest = DBManifest::where('TMANIFEST_PK', $id)->update([
                            'KODE_DOKUMEN' =>$request->KODE_DOKUMEN,
                            'NO_NPE' => $noNPE,
                            'TGL_NPE' => $result->TGL_DOK_INOUT,
                            'NAMA_IMP' =>$result->CONSIGNEE,
                            'NPWP_IMP' =>$result->ID_CONSIGNEE
                        ]);
                        return response()->json(['success' => true, 'message' => 'Data ditemukan', 'DATA'=>$manifest]);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Nomor dokumen tidak ditemukan atau Berbeda']);
                    }
                }else {
                    return response()->json(['success' => false, 'message' => 'Dokumen Tidak Ditemukan']);
                }
            }else {
                return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
            }
        }else {
            return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
        }
    }

    public function update($id, Request $request)
    {
        $consignee = $request->TCONSIGNEE_FK;
        $perusahaan = DBConsignee::where('TPERUSAHAAN_PK', $consignee)->first();

        $pack = $request->TPACKING_FK;
        $packings = DBPacking::where('TPACKING_PK', $pack)->first();
        $manifest = DBManifest::where('TMANIFEST_PK', $id)->update([
            'NO_PACK' =>$request->NO_PACK,
            'TGL_PACK' =>$request->TGL_PACK,
            'DESCOFGOODS' =>$request->DESCOFGOODS,
            'CONSIGNEE' =>$perusahaan->NAMAPERUSAHAAN,
            'NPWP_CONSIGNEE' =>$perusahaan->NPWP,
            'TCONSIGNEE_FK' =>$request->TCONSIGNEE_FK,
            'TPACKING_FK' =>$request->TPACKING_FK,
            'NAMAPACKING' =>$packings->NAMAPACKING,
            'QUANTITY' =>$request->QUANTITY,
            'WEIGHT' =>$request->WEIGHT,
            'MEAS' =>$request->MEAS,
            'PEL_MUAT' => $request->PEL_MUAT,
            'PEL_BONGKAR' => $request->PEL_BONGKAR,
            'PEL_TRANSIT' => $request->PEL_TRANSIT,
    
        ]);
        // dd($packings);
        return back()->with('success', 'Data imported successfully!');
    }

    public function approve(Request $request)
    {
        $id = $request->id;
        $manifest = DBManifest::where('TMANIFEST_PK', $id)->first();
        
        if ($manifest) {
            if ($manifest->NO_NPE != NULL && $manifest->tglmasuk != NULL) {
                $manifest = DBManifest::where('TMANIFEST_PK', $id)->update([
                    'sor_update' => '1',
                ]);
                return response()->json(['success' => true, 'message' => 'Proses Stuffing Data Dilakukan', 'DATA'=>$manifest]);
            }else {
                return response()->json(['success' => false, 'message' => 'Dokumen Belum Lengkap!!', 'DATA'=>$manifest]);
            }
        }else {
            return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
        }

    }


    public function barcode(Request $request)
    {
        $id = $request->id;
        $barang = DBManifest::where('TMANIFEST_PK', $id)->first();

        if ($barang->NO_NPE != NULL) {
            $gate = DBGate::where('ref_id', $id)->where('ref_type', 'Manifesteks')->first();
            $today = time();
            
            if (!$gate) {
                $today = time(); // Mendapatkan waktu saat ini dalam format UNIX timestamp
                $expired = date('Y-m-d', strtotime('+3 days', $today));

                $gate = DBGate::create([
                    'ref_type'=> 'Manifesteks',
                    'ref_id'=>$id ,
                    'ref_action'=> 'get',
                    'ref_number' => $barang->NO_PACK,
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
            
        }elseif ($barang->NO_NPE == NULL) {
            return response()->json(['success' => false, 'message' => 'Dokumen belum ada']);
        }
        else {
            return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
        }        
    }

    public function gateIn()
    {
        if ( !$this->access->can('show.exp.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Export Register', 'slug' => 'show.exp.register.index', 'description' => ''));
        
        $data['page_title'] = "Export || Gate In Manifest";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Gate In Manifest'
            ]
        ];        

        $data['gate'] = DBGate::where('ref_type', 'Manifesteks')->where('time_out', NULL)->get();

        return view('export.manifest.gate-in')->with($data);
    }

   public function deleteManifest(Request $request)
    {
        $id = $request->id;
        $cont = DBManifest::where('TMANIFEST_PK', $id)->first();
        if ($cont) {
            $cont->delete();
			//$gate = DBGate::where('ref_id', $id)->where('ref_type', 'Manifesteks')->first();
            //$gate->delete();
            return response()->json(['success' => true, 'message' => 'Sukses Menghapus']);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak Ditemukan']);
            
        }
    }
 


    public function gateInApprove($id, Request $request)
    {
        $id = $request->id;
        $gate =  DBGate::where('id', $id)->first();
        if ($gate) {
            $gate->update([

            ]);
            $cont = DBManifest::where('TMANIFEST_PK', $gate->ref_id)->first();
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
            $cont = DBManifest::where('TMANIFEST_PK', $idCont)->first();
            if ($cont) {
                $cont->update([
                    'tglmasuk' => $request->TGLMASUK,
                    'jammasuk' => $request->JAMMASUK,
                    'NOPOL_MASUK' => $pol,
                    // 'UIDMASUK' => $request->UIDMASUK,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function edit($id)
//     {
//         if ( !$this->access->can('show.lcl.manifest.edit') ) {
//             return view('errors.no-access');
//         }
        
        
//         // Create Roles Access
//         $this->insertRoleAccess(array('name' => 'Edit LCL Manifest', 'slug' => 'show.lcl.manifest.edit', 'description' => ''));
        
        
//         $data['page_title'] = "Edit LCL Manifest";
//         $data['page_description'] = "";
//         $data['breadcrumbs'] = [
//             [
//                 'action' => route('lcl-manifest-index'),
//                 'title' => 'LCL Manifest'
//             ],
//             [
//                 'action' => '',
//                 'title' => 'Edit'
//             ]
//         ];
        
// //        $num = 0;
        
// //        $manifestID = DBManifest::select('NOTALLY')->orderBy('TMANIFEST_PK', 'DESC')->first();
// //        if(count($manifestID) > 0){
// //            $tally = explode('.', $manifestID->NOTALLY);
// //            $num = intval($tally[1]);    
// //        }
// //        
// //        $regID = str_pad(intval((isset($num) ? $num : 0)+1), 3, '0', STR_PAD_LEFT);
        
//         $container = DBContainer::find($id);
        
//         $data['container'] = $container;
// //        $data['tally_number'] = $container->NoJob.'.'.$regID;
//         $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id', 'NAMAPERUSAHAAN as name')->get();
//         $data['packings'] = DBPacking::select('TPACKING_PK as id', 'KODEPACKING as code', 'NAMAPACKING as name')->get();
//         $data['locations'] = \DB::table('location')->get();
        
//         return view('import.lcl.edit-manifest')->with($data);
//     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function update(Request $request, $id)
//     {
//         $data = $request->json()->all(); 
//         $delete_photo = $data['delete_photo'];
//         unset($data['id'], $data['delete_photo'], $data['_token'], $data['undefined']);
        
//         $container = DBContainer::find($data['TCONTAINER_FK']); 
//         $packing = DBPacking::find($data['TPACKING_FK']);
        
//         $data['NO_BC11'] = $container->NO_BC11;
//         $data['TGL_BC11'] = $container->TGL_BC11;
//         $data['NO_PLP'] = $container->NO_PLP;
//         $data['TGL_PLP'] = $container->TGL_PLP;
//         $data['SIZE'] = $container->SIZE;
//         $data['KODE_KEMAS'] = $packing->KODEPACKING;
//         $data['NAMAPACKING'] = $packing->NAMAPACKING;  
//         $data['SHIPPER'] = DBPerusahaan::getNameById($data['TSHIPPER_FK']);
//         $data['CONSIGNEE'] = DBPerusahaan::getNameById($data['TCONSIGNEE_FK']);
//         $data['ID_CONSIGNEE'] = DBPerusahaan::getNpwpById($data['TCONSIGNEE_FK']);
//         $data['VALIDASI'] = 'N';
//         if(is_numeric($data['TNOTIFYPARTY_FK'])) {
//             $data['NOTIFYPARTY'] = DBPerusahaan::getNameById($data['TNOTIFYPARTY_FK']);
//         }else{
//             $data['NOTIFYPARTY'] = $data['TNOTIFYPARTY_FK'];
//             unset($data['TNOTIFYPARTY_FK']);
//         }
        
//         $data['tglmasuk'] = $container->TGLMASUK;
//         $data['jammasuk'] = $container->JAMMASUK;
        
// //        if(empty($data['perubahan_hbl']) || $data['perubahan_hbl'] == 'N'){
// //            $data['alasan_perubahan'] = '';
// //        }
        
//         if($data['final_qty'] != $data['QUANTITY'] || $data['packing_tally'] != $packing->NAMAPACKING){
//             $data['perubahan_hbl'] = 'Y';
//         }else{
//             $data['perubahan_hbl'] = 'N';
//         }
        
//         if($delete_photo == 'Y'){
//             $data['photo_stripping'] = '';
//         }
        
//         $locations = \DB::table('location')->whereIn('id', $data['location_id'])->pluck('name');
        
//         if($locations){
//             $data['location_id'] = implode(',', $data['location_id']);
//             $data['location_name'] = implode(',', $locations);
//         }
        
// //        $location = \DB::table('location')->find($data['location_id']);
// //        if($location){
// //            $data['location_id'] = $location->id;
// //            $data['location_name'] = $location->name;
// //        }
        
//         $update = DBManifest::where('TMANIFEST_PK', $id)
//             ->update($data);
        
//         if($update){
            
//             // Update Meas Wight           
//             $sum_weight_manifest = DBManifest::select('WEIGHT')->where('TCONTAINER_FK', $data['TCONTAINER_FK'])->sum('WEIGHT');
//             $sum_meas_marnifest = DBManifest::select('MEAS')->where('TCONTAINER_FK', $data['TCONTAINER_FK'])->sum('MEAS');         
//             $container->MEAS = $sum_meas_marnifest;
//             $container->WEIGHT = $sum_weight_manifest;
            
//             if($container->save()){
                
//                 $sum_weight = DBContainer::select('WEIGHT')->where('TJOBORDER_FK', $container->TJOBORDER_FK)->sum('WEIGHT');
//                 $sum_meas = DBContainer::select('MEAS')->where('TJOBORDER_FK', $container->TJOBORDER_FK)->sum('MEAS');         
//                 \App\Models\Joborder::where('TJOBORDER_PK', $container->TJOBORDER_FK)
//                         ->update(['MEASUREMENT' => $sum_meas, 'GROSSWEIGHT' => $sum_weight]);
                
//             }
            
//             return json_encode(array('success' => true, 'message' => 'Manifest successfully saved!'));
//         }
        
//         return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
//     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      try
      {
            $manifest = DBManifest::findOrFail($id);

          // Update Jumlah BL
            $countbl = DBManifest::where('TCONTAINER_FK', $manifest->TCONTAINER_FK)->count();
            DBContainer::where('TCONTAINER_PK', $manifest->TCONTAINER_FK)
                ->update(['jumlah_bl' => $countbl]);
                  
            DBManifest::destroy($id);
      }
      catch (Exception $e)
      {
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
      }
 
      return json_encode(array('success' => true, 'message' => 'Manifest successfully deleted!'));
    }
    
//     public function approve($id)
//     {
        
//         $manifest = DBManifest::find($id);

//         if(empty($manifest->tglstripping) || $manifest->tglstripping == '0000-00-00' || $manifest->tglstripping == '01-01-1970'){
//             return json_encode(array('success' => false, 'message' => 'HBL ini belum melakukan stripping!'));
//         }
        
//         $update = DBManifest::where('TMANIFEST_PK', $id)
//             ->update(array('VALIDASI'=>'Y'));
        
//         if($update){
//             $manifest = DBManifest::find($id);
//             if($manifest->sor_update == 0){
// //                $sor = $this->updateSor('approve', $meas->MEAS);
//                 $this->updateSorByMeas();
//                 $manifest->sor_update = 1;
//                 $manifest->save();
//             }

//             return json_encode(array('success' => true, 'message' => 'Manifest successfully approved!'));
//         }
        
//         return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
//     }
    
    public function approveAll($container_id)
    {
        
        $container = DBContainer::find($container_id)->first();
        
        if(empty($container->TGLSTRIPPING) || $container->TGLSTRIPPING == '0000-00-00' || $container->TGLSTRIPPING == '01-01-1970'){
            return json_encode(array('success' => false, 'message' => 'Kontainer ini belum melakukan stripping!'));
        }

        $update = DBManifest::where('TCONTAINER_FK', $container_id)
            ->update(array('VALIDASI'=>'Y'));
        
        if($update){
            
            $manifest = DBManifest::where('TCONTAINER_FK', $container_id)->get();
            foreach ($manifest as $mfs):
                if($mfs->sor_update == 0){
//                    $sor = $this->updateSor('approve', $mfs->MEAS);
                    $this->updateSorByMeas();
                    DBManifest::where('TMANIFEST_PK', $mfs->TMANIFEST_PK)->update(array('sor_update'=>1));
                }
            endforeach;
            
            return json_encode(array('success' => true, 'message' => 'All Manifest successfully approved!'));
        }
        
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function cetak($id, $type)
    {
        $container = DBContainer::find($id);
        $manifests = DBManifest::where('TCONTAINER_FK', $id)->get();
        
        $data['container'] = $container;
        $data['manifests'] = $manifests;
//        return view('print.tally-sheet', $container);
        
        switch ($type){
            case 'tally':
                return view('print.tally-sheet', $data);
//                $pdf = \PDF::loadView('print.tally-sheet', $data);        
                break;
            case 'log':
                $pdf = \PDF::loadView('print.log-stripping', $data);
                break;
        }
        
        return $pdf->stream(ucfirst($type).'-'.$container->NOCONTAINER.'-'.date('dmy').'.pdf');
    }
    
    public function upload(Request $request)
    {
        $container_id = $request->container_id;
        $container = DBContainer::where('TCONTAINER_PK', $container_id)->first();
        
        // Check data xml
        $check = \App\Models\TpsCoariKmsDetail::where('CONT_ASAL', $container->NOCONTAINER)->count();
        
//        if($check > 0){
//            return json_encode(array('success' => false, 'message' => 'No. Container '.$container->NOCONTAINER.' sudah di upload.'));
//        }
        
        // Reff Number
        $reff_number = $this->getReffNumber();
        
        if($reff_number){
            $coarikms = new \App\Models\TpsCoariKms;
            $coarikms->REF_NUMBER = $reff_number;
            $coarikms->TGL_ENTRY = date('Y-m-d');
            $coarikms->JAM_ENTRY = date('H:i:s');
            $coarikms->UID = \Auth::getUser()->name;
            
            if($coarikms->save()){
                $manifest = DBManifest::where(array('TCONTAINER_FK' => $container->TCONTAINER_PK, 'TJOBORDER_FK' => $container->TJOBORDER_FK, 'VALIDASI' => 'Y'))
                        ->get();
                
                $nourut = 0;
                foreach ($manifest as $data):
                    $coarikmsdetail = new \App\Models\TpsCoariKmsDetail;
                    $coarikmsdetail->TPSCOARIKMSXML_FK = $coarikms->TPSCOARIKMSXML_PK;
                    $coarikmsdetail->REF_NUMBER = $reff_number;
                    $coarikmsdetail->NOTALLY = $data->NOTALLY;
                    $coarikmsdetail->KD_DOK = 5;
                    $coarikmsdetail->KD_TPS = 'AIRN';
                    $coarikmsdetail->NM_ANGKUT = $data->VESSEL;
                    $coarikmsdetail->NO_VOY_FLIGHT = $data->VOY;
                    $coarikmsdetail->CALL_SIGN = $data->CALL_SIGN;
                    $coarikmsdetail->TGL_TIBA = (!empty($data->ETA) ? date('Ymd', strtotime($data->ETA)) : '');
                    $coarikmsdetail->KD_GUDANG = $data->LOKASI_GUDANG;
                    $coarikmsdetail->NO_BL_AWB = $data->NOHBL;
                    $coarikmsdetail->TGL_BL_AWB = (!empty($data->TGL_HBL) ? date('Ymd', strtotime($data->TGL_HBL)) : '');
                    $coarikmsdetail->NO_MASTER_BL_AWB = $data->NOMBL;
                    $coarikmsdetail->TGL_MASTER_BL_AWB = (!empty($data->TGL_MASTER_BL) ? date('Ymd', strtotime($data->TGL_MASTER_BL)) : '');
                    $coarikmsdetail->ID_CONSIGNEE = str_replace(array('.','-'), array(''),$data->ID_CONSIGNEE);
                    $coarikmsdetail->CONSIGNEE = trim($data->CONSIGNEE);
                    $coarikmsdetail->BRUTO = $data->WEIGHT;
                    $coarikmsdetail->NO_BC11 = $data->NO_BC11;
                    $coarikmsdetail->TGL_BC11 = (!empty($data->TGL_BC11) ? date('Ymd', strtotime($data->TGL_BC11)) : '');
                    $coarikmsdetail->NO_POS_BC11 = $data->NO_POS_BC11;
                    $coarikmsdetail->CONT_ASAL = $data->NOCONTAINER;
                    $coarikmsdetail->SERI_KEMAS = 1;
                    $coarikmsdetail->KD_KEMAS = $data->KODE_KEMAS;
                    $coarikmsdetail->JML_KEMAS = (!empty($data->QUANTITY) ? $data->QUANTITY : 0);
                    $coarikmsdetail->KD_TIMBUN = 'GD';
                    $coarikmsdetail->KD_DOK_INOUT = 3;
                    $coarikmsdetail->NO_DOK_INOUT = (!empty($data->NO_PLP) ? $data->NO_PLP : '');
                    $coarikmsdetail->TGL_DOK_INOUT = (!empty($data->TGL_PLP) ? date('Ymd', strtotime($data->TGL_PLP)) : '');
                    $coarikmsdetail->WK_INOUT = date('Ymd', strtotime($data->tglstripping)).date('His', strtotime($data->jamstripping));
                    $coarikmsdetail->KD_SAR_ANGKUT_INOUT = 1;
                    $coarikmsdetail->NO_POL = $data->NOPOL_MASUK;
                    $coarikmsdetail->PEL_MUAT = $data->PEL_MUAT;
                    $coarikmsdetail->PEL_TRANSIT = $data->PEL_TRANSIT;
                    $coarikmsdetail->PEL_BONGKAR = $data->PEL_BONGKAR;
                    $coarikmsdetail->GUDANG_TUJUAN = $data->LOKASI_GUDANG;
                    $coarikmsdetail->UID = \Auth::getUser()->name;
                    $coarikmsdetail->RESPONSE = '';
                    $coarikmsdetail->STATUS_TPS = 1;
                    $coarikmsdetail->NOURUT = $nourut;
                    $coarikmsdetail->KODE_KANTOR = '040300';
                    $coarikmsdetail->NO_DAFTAR_PABEAN = '';
                    $coarikmsdetail->TGL_DAFTAR_PABEAN = '';
                    $coarikmsdetail->NO_SEGEL_BC = '';
                    $coarikmsdetail->TGL_SEGEL_BC = '';
                    $coarikmsdetail->NO_IJIN_TPS = '';
                    $coarikmsdetail->TGL_IJIN_TPS = '';
                    $coarikmsdetail->RESPONSE_IPC = '';
                    $coarikmsdetail->STATUS_TPS_IPC = '';
                    $coarikmsdetail->KD_TPS_ASAL = '';
                    $coarikmsdetail->TGL_ENTRY = date('Y-m-d');
                    $coarikmsdetail->JAM_ENTRY = date('H:i:s');
                    
                    if($coarikmsdetail->save()){
                        
                        DBManifest::where('TMANIFEST_PK', $data->TMANIFEST_PK)->update(['REF_NUMBER' => $reff_number]);
                        
                        $nourut++;
                    }
 
                endforeach;
                
                return json_encode(array('insert_id' => $coarikms->TPSCOARIKMSXML_PK, 'ref_number' => $reff_number, 'success' => true, 'message' => 'No. Container '.$container->NOCONTAINER.' berhasil di simpan. Reff Number : '.$reff_number));
                    
            }
            
        } else {
            return json_encode(array('success' => false, 'message' => 'Cannot create Reff Number, please try again later.'));
        }
              
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
    }
    
    public function uploadPhoto(Request $request, $ref)
    {
        $picture = array();
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');
            $destinationPath = base_path() . '/public/uploads/photos/manifest';
            
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
                $filename = date('dmyHis').'_'.str_slug($request->no_hbl).'_'.$i.'.'.$extension;
                $picture[] = $filename;
                $file->move($destinationPath, $filename);
//                $img->save($destinationPath.'/'.$filename);
                $i++;
            }
            // update to Database
            $manifest = DBManifest::find($request->id_hbl);
            $manifest->$ref = json_encode($picture);
            if($manifest->save()){
                return back()->with('success', 'Photo for Manifest '. $request->no_hbl .' has been uploaded.');
            }else{
                return back()->with('error', 'Photo uploaded, but not save in Database.');
            }
            
        } else {
            return back()->with('error', 'Something wrong!!! Can\'t upload photo, please try again.');
        }
    }
    
    public function getNopos($id)
    {
        $container = DBContainer::find($id);
        $manifests = DBManifest::where('TCONTAINER_FK',$container->TCONTAINER_PK)->get();
        
        $plp = \App\Models\TpsResponPlpDetail::where(array('NO_CONT'=>$container->NOCONTAINER,'UK_CONT'=>$container->SIZE))->get();
        
        if($plp){
            // UPDATE NO.POS
            $i = 0;
            foreach ($manifests as $manifest):
                $plpdetail = \App\Models\TpsResponPlpDetail::where(
                        array(
                            'NO_CONT'=>$manifest->NOCONTAINER,
                            'UK_CONT'=>$manifest->SIZE,
                            'NO_BL_AWB'=>$manifest->NOHBL,
                            'TGL_BL_AWB'=>date('Ymd', strtotime($manifest->TGL_HBL))
                            )
                        )->first();
                if($plpdetail) {
                    // Check Manifest Nopos
                    if($manifest->NO_POS_BC11 == ''){
                        DBManifest::where('TMANIFEST_PK', $manifest->TMANIFEST_PK)->update(['NO_POS_BC11'=>$plpdetail->NO_POS_BC11]);
                        $i++;
                    }
                }
            endforeach;
            
            return json_encode(array('success' => true, 'message' => $i. ' Data No.POS BC11 berhasil di update.'));
            
        }else{
            return json_encode(array('success' => false, 'message' => 'Data Respon PLP tidak ditemukan untuk container ini.'));
        }
              
        return json_encode(array('success' => false, 'message' => 'Something went wrong, please try again later.'));
        
    }

    public function addManual()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Create Manifest";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Create Manifest'
            ]
        ];        
        $data['packings'] = DBPacking::get();
        return view('export.manifest.create')->with($data);
    }

    public function TPS(Request $request)
    {
        $id = $request->id;
        // var_dump($id);
        // die();
        
        $manifest = DBManifest::where('TMANIFEST_PK', $id)->first();
        if ($manifest) {
         
                if ($manifest->KODE_DOKUMEN != NULL || $manifest->KODE_DOKUMEN != "") {
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
                        'TPSCOARIKMSXML_FK' => $coari->TPSCOARIKMSXML_PK,
                        'REF_NUMBER' => $refNumber,
                        'NOTALLY' => $manifest->NOTALLY,
                        'KD_DOK' => $manifest->KODE_DOKUMEN,
                        'KD_TPS'=> $manifest->KD_TPS_TUJUAN,
                        'NO_VOY_FLIGHT' =>$manifest->VOY,
                        'CALL_SIGN' => $manifest->CALL_SIGN,
                        'TGL_TIBA' => $manifest->tglmasuk,
                        'ID_CONSIGNEE' =>$manifest->TCONSOLIDATOR_FK,
                        'CONSIGNEE' =>$manifest->NAMACONSOLIDATOR,
                        'BRUTO'=> $manifest->WEIGHT,
                        'SERI_KEMAS' => $manifest->NAMAPACKING,
                        'KD_KEMAS' => $manifest->KODE_KEMAS,
                        'JML_KEMAS' => $manifest->QUANTITY,
                        'KD_DOK_INOUT' => $manifest->KODE_DOKUMEN,
                        'NO_DOK_INOUT' =>$manifest->NO_NPE,
                        'TGL_DOK_INOUT' =>$manifest->TGL_NPE,
                        'NO_POL' =>$manifest->NOPOL_MASUK,
                        'PEL_MUAT'=> $manifest->PEL_MUAT , 
                        'PEL_TRANSIT'=> $manifest->PEL_TRANSIT , 
                        'PEL_BONGKAR'=> $manifest->PEL_BONGKAR , 
                        'UID'=> \Auth::getUser()->name ,
                        'KD_TPS_ASAL' => 'AIRN',
                        'TGL_ENTRY'=> $tglEntry , 
                        'JAM_ENTRY'=> $jamEntry , 
                    ]);

                    $manifest->update([
                        'REF_NUMBER'=> $refNumber,
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
