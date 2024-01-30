<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;

use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;

use App\Models\ManifestExp as DBManifest;
use App\Models\ContainerExp as DBContainer;
use App\Models\Perusahaan as DBPerusahaan;
use App\Models\Packing as DBPacking;
use App\Models\TpsDokNPE as DBNpe;
use App\Models\Perusahaan as DBConsignee;
use App\Models\Packing as DBPack;
use App\Models\Barcode as DBGate;
use App\Models\TpsDokPKBE as DBpkbe;

use App\Models\TpsCodecoCont as DBCodeco;
use App\Models\TpsCodecoContDetail as DBCodecoDetail;

class DeliveryController extends Controller
{


    public function gateOut()
    {

        if ( !$this->access->can('show.exp.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Export Register', 'slug' => 'show.exp.register.index', 'description' => ''));
        
        $data['page_title'] = "Export Gate Out";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Gate Out'
            ]
        ];        
        $data['container'] = DBContainer::whereNotNull('TGLMASUK')->get();



        
        return view('export.delivery.gateOut')->with($data);
    }

    public function barcode(Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont->status_bc == 'HOLD') {
            return response()->json(['success' => false, 'message' => 'Status Maih HOLD']);
        }elseif($cont->status_bc == 'RELEASE') {
            $gate = DBGate::where('ref_id', $id)->where('ref_type', 'LCLEKS')->where('ref_action', 'release')->first();
            
            if (!$gate) {
                $today = time(); // Mendapatkan waktu saat ini dalam format UNIX timestamp
                $expired = date('Y-m-d', strtotime('+3 days', $today));

                $gate = DBGate::create([
                    'ref_type'=> 'LCLEKS',
                    'ref_id'=>$id ,
                    'ref_action'=> 'release',
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

    public function getData(Request $request)
    {
        $id = $request->id;
        $cont =  DBContainer::where('TCONTAINER_PK', $id)->first();
        if ($cont) {
            
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Data Tidak ditemukan']);
        }

    }

    public function pkbe(Request $request)
    {
        $id = $request->NO_PKBE;
        $size = $request->SIZE;
        $cont = $request->NOCONTAINER;
        $idCon = $request->id;
        // var_dump($size, $cont);
        // die();
        $status = DBContainer::where('TCONTAINER_PK', $idCon)->first();
        if ($status->CTR_STATUS == 'LCL') {
            $pkbe = DBpkbe::where('NOPKBE', $id)->where('NO_CONT', $cont)->first();
            if ($pkbe) {
                if ($pkbe->SIZE != $size) {
                    return response()->json(['success' => false, 'message' => 'Ukuran Container Berbeda']);
                }elseif($pkbe->SIZE == $size) {
                    return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data'=>$pkbe]);
                }else {
                    return response()->json(['success' => false, 'message' => 'Dokumen atau Container Tidak ada']);
                }
            }else {
                return response()->json(['success' => false, 'message' => 'Dokumen atau Container Tidak ada']);
            }
           
        }elseif ($status->CTR_STATUS == 'FCL') {
            $npe = DBNpe::where('NONPE', $id)->where('NO_CONT', $cont)->first();
            if ($npe) {
                if ($npe->SIZE != $size) {
                    return response()->json(['success' => false, 'message' => 'Container Berbeda dengan Dokumen']);
                }elseif($npe->SIZE == $size) {
                    return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data'=>$npe]);
                }else {
                    return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
                }
            }else {
                return response()->json(['success' => false, 'message' => 'Dokumen atau Container Tidak ada']);
            }
           
        }else {
            return response()->json(['success' => false, 'message' => 'Status Container Belum Diketahui']);
        }    
    }

    public function update(Request $request)
    {
        $id = $request->idCont;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont->CTR_STATUS == 'LCL') {
            $kdDok = '7';
        }elseif ($cont->CTR_STATUS == 'FCL') {
            $kdDok ='6';
        }else {
            $kdDok ='';
        }

        $tgl = $request->TGL_PKBE;
        $timestamp = strtotime($tgl);

        // Format the timestamp as needed using date
        $formattedDate = date('Y-m-d', $timestamp);
        
        if ($cont) {
            if ($cont->status_bc != 'RELEASE') {
                $cont->update([
                    'status_bc' => 'HOLD',
                    'WEIGHT'=>$request->WEIGHT,
                    'KD_DOKUMEN'=>$kdDok,
                    'TGLKELUAR'=>$request->TGLKELUAR,
                    'JAMKELUAR'=>$request->JAMKELUAR,
                    'NOPOL_KELUAR'=>$request->NOPOL_KELUAR,
                    'NO_PKBE'=>$request->NO_PKBE,
                    'TGL_PKBE'=>$formattedDate,
                    'UID_KELUAR' => \Auth::getUser()->name,
                    'NO_SEAL'=>$request->NO_SEAL,
                ]);
            }else {
                $cont->update([
                    'WEIGHT'=>$request->WEIGHT,
                    'KD_DOKUMEN'=>$kdDok,
                    'TGLKELUAR'=>$request->TGLKELUAR,
                    'JAMKELUAR'=>$request->JAMKELUAR,
                    'NOPOL_KELUAR'=>$request->NOPOL_KELUAR,
                    'NO_PKBE'=>$request->NO_PKBE,
                    'TGL_PKBE'=>$formattedDate,
                    'UID_KELUAR' => \Auth::getUser()->name,
                    'NO_SEAL'=>$request->NO_SEAL,
                ]);
            }
          
            return response()->json(['success' => true, 'message' => 'Data Ditemukan', 'data'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Somethig Wrong']);
        }
    }

    public function bcIndex()
    {
        
        if ( !$this->access->can('show.exp.register.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Export Register', 'slug' => 'show.exp.register.index', 'description' => ''));
        
        $data['page_title'] = "Export Dokumen Hold";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Dokumen Hold'
            ]
        ];        
        $data['container'] = DBContainer::where('status_bc', 'HOLD')->get();



        
        return view('export.delivery.bcIndex')->with($data);
    }

    public function Release(Request $request)
    {
        $id = $request->id;
        $cont =DBContainer::where('TCONTAINER_PK', $id)->first();
        
        if ($cont->KD_DOKUMEN != NULL && $cont->NO_SEAL != (NULL || '') ) {
            $cont->update([
                'status_bc' => 'RELEASE',
                'release_bc_uid' =>  \Auth::getUser()->name,
                'release_bc_date' => date('Y-m-d H:i:s'),
                'release_bc' => 'Y',
            ]);

            return response()->json(['success' => true, 'message' => 'Container Has Been Release', 'data'=>$cont]);
        }elseif ($cont->NO_SEAL == (NULL || '')) {
            return response()->json(['success' => false, 'message' => 'Nomor Seal Kosong', 'data'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Dokumen Belum Ada', 'data'=>$cont]);
        }
    }

    public function photo(Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

       if ($cont) {
            return response()->json(['success' => true, 'message' => '', 'data' => $cont]);
       }else {
            return response()->json(['success' => false, 'message' => 'Data Container Belum Tersedia']);
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

                    $last = DBCodeco::where('TGL_ENTRY', $tglEntry)->count();

                  
                    $next = $last + 1;
                    $ref = str_pad($next, 4, '0', STR_PAD_LEFT);
                    $lastTwoDigitsOfYear = substr(date('y'), -2);
                   
                    $refNumber = "AIRN{$lastTwoDigitsOfYear}{$tglRef}{$ref}";

                    // var_dump($refNumber);
                    // die();
                
                    $codeco = DBCodeco::create([
                        'REF_NUMBER' => $refNumber,
                        'TGL_ENTRY' => $tglEntry,
                        'JAM_ENTRY' => $jamEntry,
                        'UID'  => \Auth::getUser()->name,
                    ]);

                    $detail = DBCodecoDetail::create([
                        'TPSCODECOCONTXML_FK'=> $codeco->TPSCODECOCONTXML_PK, 
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
                        'REF_NUMBER_OUT'=> $refNumber,
                    ]);





                    return response()->json(['success' => true]);
                }else {
                    return response()->json(['success' => false, 'message' => 'Dokumen masih kosong!']);
                }
         
          
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong!!']);
        }
       
    }

    public function SuratJalan(Request $request)
    {
        $id = $request->id;
        $cont = DBContainer::where('TCONTAINER_PK', $id)->first();

        if ($cont) {
            return response()->json(['success' => true, 'data'=>$cont]);
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong!!']);
        }
    }

    public function viewSuratJalan($id)
    {
        $data['cont'] = DBContainer::where('TCONTAINER_PK', $id)->first();
        $data['time'] = date('Y-m-d');
        // dd($barcode);
        return view('print.suratJalanExport')->with($data);
    }

}