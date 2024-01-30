<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ContainerExp as DBContainer;
use App\Models\JoborderExp as DBJoborder;
use App\Models\ManifestExp as DBManifest;

use App\Models\TpsCodecoKMS as DBCodeco;
use App\Models\TpsCodecoKMSDetail as DBCodecoDetail;


class StufingController extends Controller
{
    public function index()
    {   
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Stuffing', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Export Stuffing";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Stuffing'
            ]
        ];        

        $data['barang'] = DBManifest::where('sor_update', '1')->where('tglstufing', NULL)->orderBy('tglmasuk', 'desc')->get();
        $data['container'] = DBContainer::where('TGLMASUK','!=', NULL)->orderBy('TGLMASUK', 'desc')->orderBy('jammasuk', 'desc')->get();

        return view('export.stuffing.main')->with($data);
    }

    public function Stuffing($id)
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Stuffing', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        $container = DBContainer::where('TCONTAINER_PK', $id)->first();
        $data['page_title'] = "Export Stuffing |" .$container->NOCONTAINER;
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Export Stuffing'
            ]
        ];        

        $data['container'] = DBContainer::where('TCONTAINER_PK', $id)->first();
        $data['barang'] = DBManifest::where('sor_update', '1')->where('tglstufing', NULL)->get();
        $data['Listbarang'] = DBManifest::where('TCONTAINER_FK', $id)->orderBy('tglstufing', 'desc')->get();
        return view('export.stuffing.stuffing')->with($data);
    }

    public function StuffingProses(Request $request)
    {
        $id = $request->id;
        // var_dump($id);
        // die();
        $cont = DBContainer::where('TCONTAINER_PK',$id)->first();

        $barang = $request->TMANIFEST_PK;

        foreach ($barang as $manifestId) {
            $manifest = DBManifest::where('TMANIFEST_PK', $manifestId)->first();
    
            if ($manifest) {
               $manifest->update([
                'NOJOBORDER' => $cont->NoJob,
                'TCONTAINER_FK' => $id,
                'NOCONTAINER' => $cont->NOCONTAINER,
                'SIZE' => $cont->SIZE,
                'tglstufing' => $request->tglstufing,
                'jamstufing' => $request->jamstufing,
                'sor_update'=> '2',
                'NOJOBORDER'=> $cont->NoJob,
               ]);
            }

            // var_dump($manifest);
            // die();
        }
    //    dd($barang);
    return response()->json(['success' => true, 'message' => 'Proses Stuffing Telah Di Batalkan', 'data'=>$manifest]);
    }

    public function cancel(Request $request)
    {
        $id = $request->id;

        

        $manifest = DBManifest::where('TMANIFEST_PK', $id)->first();
        if ($manifest) {
            $manifest->update([
                'NOJOBORDER' => NULL,
                'NOCONTAINER' => NULL,
                'SIZE' => NULL,
                'tglstufing' => NULL,
                'jamstufing' => NULL,
                'sor_update'=> '1',
                'TCONTAINER_FK' => NULL,
            ]);
        //     var_dump($manifest);
        // die();
            return response()->json(['success' => true, 'message' => 'Proses Stuffing Telah Di Batalkan', 'data'=>$manifest]);
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong', 'data'=>$manifest]);
        }
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

                    $last = DBCodeco::where('TGL_ENTRY', $tglEntry)->count();

                  
                    $next = $last + 1;
                    $ref = str_pad($next, 4, '0', STR_PAD_LEFT);
                    $lastTwoDigitsOfYear = substr(date('y'), -2);
                   
                    $refNumber = "AIRN{$lastTwoDigitsOfYear}{$tglRef}{$ref}";

                    // var_dump($refNumber);
                    // die();
                
                    $coari = DBCodeco::create([
                        'REF_NUMBER' => $refNumber,
                        'TGL_ENTRY' => $tglEntry,
                        'JAM_ENTRY' => $jamEntry,
                        'UID'  => \Auth::getUser()->name,
                    ]);

                    $detail = DBCodecoDetail::create([
                        'TPSCODECOKMSXML_FK' => $coari->TPSCODECOKMSXML_PK,
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
                        'CONT_ASAL'=> $manifest->TCONTAINER_FK , 
                        'NOJOBORDER'=> $manifest->NOJOBORDER , 
                    ]);

                    $manifest->update([
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
}
