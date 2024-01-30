<?php

namespace App\Http\Controllers\Export;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContainerExport;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ContainerExp as DBContainer;
use App\Models\ManifestExp as DBManifest;

class ReportController extends Controller
{
    public function contIndex()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Report Container Export";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Report Container Export'
            ]
        ];        

        $data['container'] = DBContainer::all();

        return view('export.report.container')->with($data);
    }

    public function contData(Request $request)
    {
        $tgl = $request->tgl;
        $status = $request->status;

        $date_range = explode(' to ', $tgl);

     
        if (count($date_range) >= 2) {
           $start = date('Y-m-d', strtotime($date_range[0]));
           $end = date('Y-m-d', strtotime($date_range[1]));
       } else {
           $start = date('Y-m-d', strtotime($date_range[0]));
           $end = $start;
       }

        // var_dump($start, $end);
        // die();

        if ($status == '1') {
            $contMasuk = DBContainer::where('TGLMASUK', '>=', $start)->where('TGLMASUK', '<=', $end)->get();
            $contKeluar = DBContainer::where('TGLKELUAR', '>=', $start)->where('TGLKELUAR', '<=', $end)->get();
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'masuk'=>$contMasuk, 'keluar'=>$contKeluar, 'start'=>$start, 'end'=>$end, 'status'=>$status]);
        }elseif ($status != '1') {
            $contMasuk = DBContainer::where('CTR_STATUS', $status)->where('TGLMASUK', '>=', $start)->where('TGLMASUK', '<=', $end)->get();
            $contKeluar = DBContainer::where('CTR_STATUS', $status)->where('TGLKELUAR', '>=', $start)->where('TGLKELUAR', '<=', $end)->get();
            return response()->json(['success' => true, 'message' => 'Data ditemukan', 'masuk'=>$contMasuk, 'keluar'=>$contKeluar, 'start'=>$start, 'end'=>$end, 'status'=>$status]);
        }else {
            return response()->json(['success' => false, 'message' => 'Something Wrong']);
        }
    }

    public function exportMasuk(Request $request)
    {
 
       $start = $request->start;
       $end = $request->end;
        $status = $request->status;

        if ($status == null && $start == null && $end == null) {
            $contMasuk = DBContainer::select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')
            ->get();
            
            return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                    $sheet->fromArray($contMasuk);
                });
            })->download('xls');
         }elseif ($status == '1') {
                $contMasuk = DBContainer::where('TGLMASUK', '>=', $start)
                ->where('TGLMASUK', '<=', $end)
                ->select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')
                ->get();
                
                return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                    $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                        $sheet->fromArray($contMasuk);
                    });
                })->download('xls');
               
             }elseif ($status != '1') {
                 $contMasuk = DBContainer::where('CTR_STATUS', $status)->where('TGLMASUK', '>=', $start)->where('TGLMASUK', '<=', $end) ->select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')->get();
                
                 return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                    $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                        $sheet->fromArray($contMasuk);
                    });
                })->download('xls');
             }else {
                 return back()->with('eror', 'Something Wrong');
             }
    }

    public function exportKeluar(Request $request)
    {
 
       $start = $request->start;
       $end = $request->end;
        $status = $request->status;
        if ($status == null && $start == null && $end == null) {
            $contMasuk = DBContainer::select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')
            ->get();
            
            return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                    $sheet->fromArray($contMasuk);
                });
            })->download('xls');
         }elseif ($status == '1') {
                $contMasuk = DBContainer::where('TGLKELUAR', '>=', $start)
                ->where('TGLKELUAR', '<=', $end)
                ->select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')
                ->get();
                
                return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                    $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                        $sheet->fromArray($contMasuk);
                    });
                })->download('xls');
               
             }elseif ($status != '1') {
                 $contMasuk = DBContainer::where('CTR_STATUS', $status)->where('TGLKELUAR', '>=', $start)->where('TGLKELUAR', '<=', $end) ->select('NoJob', 'NOCONTAINER', 'status_bc', 'SIZE', 'WEIGHT', 'CTR_STATUS', 'KD_DOKUMEN', 'NO_PKBE', 'TGL_PKBE', 'NOPOL_MASUK', 'TGLMASUK', 'JAMMASUK', 'NOPOL_KELUAR', 'TGLKELUAR', 'JAMKELUAR', 'UID')->get();
                
                 return Excel::create('laporan_masuk', function ($excel) use ($contMasuk) {
                    $excel->sheet('mysheet', function ($sheet) use ($contMasuk) {
                        $sheet->fromArray($contMasuk);
                    });
                })->download('xls');
             }else {
                 return back()->with('eror', 'Something Wrong');
             }
    }


    public function maniIndex()
    {
        if ( !$this->access->can('show.lcl.manifest.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index EXP Manifest', 'slug' => 'show.lcl.manifest.index', 'description' => ''));
        
        $data['page_title'] = "Report Manifest Export";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Report Manifest Export'
            ]
        ];       
        
        $data['manifest'] = DBManifest::whereNotNull('tglstufing')->get();
        $data['manifestNotStuffing'] = DBManifest::where('tglstufing', null)->get();


        return view('export.report.manifest')->with($data);
    }

    public function manifestData(Request $request)
    {
        $tgl = $request->tgl;

        $date_range = explode(' to ', $tgl);

     
        if (count($date_range) >= 2) {
           $start = date('Y-m-d', strtotime($date_range[0]));
           $end = date('Y-m-d', strtotime($date_range[1]));
       } else {
           $start = date('Y-m-d', strtotime($date_range[0]));
           $end = $start;
       }      
            $stuffing = DBManifest::where('tglstufing', '>=', $start)->where('tglstufing', '<=', $end)->get();
            if ($stuffing) {
                return response()->json(['success' => true, 'message' => 'Data ditemukan', 'data'=>$stuffing, 'start'=>$start, 'end'=>$end]);
            }else {
                return response()->json(['success' => false, 'message' => 'Something Wrong']);
            }
            
       
    }

    public function NotStuffing()
    {
        $manifestData = DBManifest::where('tglstufing', null)->select('NO_PACK', 'TGL_PACK','DESCOFGOODS', 'QUANTITY', 'WEIGHT', 'KODE_DOKUMEN', 'NO_NPE', 'TGL_NPE', 'PEL_BONGKAR', 'CONSIGNEE', 'UID')
        ->get();

        return Excel::create('laporan_belum_stuffing', function ($excel) use ($manifestData) {
            $excel->sheet('mysheet', function ($sheet) use ($manifestData) {
                $sheet->fromArray($manifestData);
            });
        })->download('xls');
    }

    public function LaporanStuffing(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        if ($start != NULL && $end != NULL) {
            $manifestData = DBManifest::where('tglstufing', '>=', $start)->where('tglstufing', '<=', $end)->select('NO_PACK', 'TGL_PACK', 'QUANTITY', 'KODE_DOKUMEN', 'NO_NPE', 'TGL_NPE', 'tglstufing', 'jamstufing', 'NOCONTAINER', 'PEL_BONGKAR', 'CONSIGNEE', 'UID')
            ->get();
            if ($manifestData) {
                return Excel::create('laporan_stuffing', function ($excel) use ($manifestData) {
                    $excel->sheet('mysheet', function ($sheet) use ($manifestData) {
                        $sheet->fromArray($manifestData);
                    });
                })->download('xls');
            }else {
                return back()->with('error', 'Something Wrong');
            }
        }else {
            $manifestData = DBManifest::whereNotNull('tglstufing')->select('NO_PACK', 'TGL_PACK', 'QUANTITY', 'KODE_DOKUMEN', 'NO_NPE', 'TGL_NPE', 'tglstufing', 'jamstufing', 'NOCONTAINER', 'PEL_BONGKAR', 'CONSIGNEE', 'UID')
            ->get();
            if ($manifestData) {
                return Excel::create('laporan_stuffing', function ($excel) use ($manifestData) {
                    $excel->sheet('mysheet', function ($sheet) use ($manifestData) {
                        $sheet->fromArray($manifestData);
                    });
                })->download('xls');
            }else {
                return back()->with('error', 'Something Wrong');
            }
        }
       
    }
}
