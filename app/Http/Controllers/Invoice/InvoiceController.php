<?php

namespace App\Http\Controllers\Invoice;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Containercy as DBContainer;

class InvoiceController extends Controller
{
    
    public function invoiceIndex()
    {
        if ( !$this->access->can('show.invoice.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Invoice";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Invoice'
            ]
        ];        
        
        $data['consolidators'] = \App\Models\Consolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        
        return view('invoice.index-invoice')->with($data);
    }
    
    public function releaseIndex()
    {
        if ( !$this->access->can('show.invoice.release.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Invoice Release', 'slug' => 'show.invoice.release.index', 'description' => ''));
        
        $data['page_title'] = "Invoice Release";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Invoice Release'
            ]
        ];        
        
//        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id', 'NAMAPERUSAHAAN as name')->get();
        
        return view('invoice.index-release-lcl')->with($data);
    }
    
    public function invoiceEdit($id)
    {
        
        if ( !$this->access->can('edit.invoice.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Edit Invoice";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-index'),
                'title' => 'Invoice'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];
        
        $data['invoice'] = \DB::table('invoice_lcl')->find($id);
        $data['container'] = \App\Models\Container::find($data['invoice']->container_id);
        $data['consolidator'] = \App\Models\Consolidator::find($data['invoice']->consolidator_id);
        $data['tarif'] = \App\Models\InvoiceTarif::where(array('consolidator_id' => $data['container']->TCONSOLIDATOR_FK))->first();
//        $data['tarif'] = \App\Models\ConsolidatorTarif::where('TCONSOLIDATOR_FK', $data['manifest']->TCONSOLIDATOR_FK)->first();
        $total = $data['invoice']->subtotal + $data['invoice']->ppn + $data['invoice']->adm + $data['invoice']->materai;
        $data['terbilang'] = ucwords($this->terbilang($total))." Rupiah";
        
        return view('invoice.edit-invoice')->with($data);
    }
    
    public function invoiceDestroy($id)
    {
        \DB::table('invoice_import')->where('id', $id)->delete();
        return back()->with('success', 'Invoice has been deleted.'); 
    }
    
    public function invoicePrint($id)
    {
        $data['invoice'] = \DB::table('invoice_lcl')->find($id);
        $data['container'] = \App\Models\Container::find($data['invoice']->container_id);
        $data['consolidator'] = \App\Models\Consolidator::find($data['invoice']->consolidator_id);
        $data['tarif'] = \App\Models\InvoiceTarif::where(array('consolidator_id' => $data['container']->TCONSOLIDATOR_FK))->first();
//        $data['tarif'] = \App\Models\ConsolidatorTarif::where('TCONSOLIDATOR_FK', $data['manifest']->TCONSOLIDATOR_FK)->first();
        $total = $data['invoice']->subtotal + $data['invoice']->ppn + $data['invoice']->adm + $data['invoice']->materai;
        $data['terbilang'] = ucwords($this->terbilang($total))." Rupiah";
        
        
        return view('print.invoice-lcl')->with($data);
        $pdf = \PDF::loadView('print.invoice', $data)->setPaper('a4');
        
        return $pdf->stream($data['invoice']->no_invoice.'-'.date('dmy').'.pdf');
    }
    
    public function invoicePrintRekap(Request $request)
    {
        $consolidator_id = $request->consolidator_id;
        $start = $request->tanggal.' 00:00:00';
        $end = date('Y-m-d', strtotime('+1 Day', strtotime($request->tanggal))).' 00:00:00';
        $type = $request->type;
        
        $data['consolidator'] = \App\Models\Consolidator::find($consolidator_id);
        $data['invoices'] = \App\Models\Invoice::select('*')
                ->join('tmanifest','invoice_import.manifest_id','=','tmanifest.TMANIFEST_PK')
                ->where('tmanifest.TCONSOLIDATOR_FK', $consolidator_id)
                ->where('tmanifest.tglrelease',$request->tanggal)
//                ->where('invoice_import.created_at','>=',$start)
//                ->where('invoice_import.created_at','<',$end)
                ->where('tmanifest.INVOICE', $type)
                ->get();
        
        if(count($data['invoices']) > 0):
            $sum_total = array();
            foreach ($data['invoices'] as $invoice):
                $sum_total[] = $invoice->sub_total;        
            endforeach;
            
            $data['sub_total'] = array_sum($sum_total);
            if(isset($request->free_ppn)):
                $data['ppn'] = 0;
            else:
                $data['ppn'] = $data['sub_total']*10/100;
            endif;
            $data['materai'] = ($data['sub_total'] > 5000000) ? '10000' : '0';
            $data['total'] = $data['sub_total'] + $data['ppn'] + $data['materai'];           
            $data['terbilang'] = ucwords($this->terbilang($data['total']))." Rupiah";

            $pdf = \PDF::loadView('print.invoice-rekap', $data)->setPaper('legal');

            return $pdf->stream('Rekap Invoice '.date('d-m-Y').'-'.$data['consolidator']->NAMACONSOLIDATOR.'.pdf');
            
        endif;
        
        return back()->with('error', 'Data tidak ditemukan.')->withInput();
    }
    
    public function tarifIndex()
    {
        if ( !$this->access->can('show.tarif.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Daftar Tarif";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Daftar Tarif'
            ]
        ];        
        
        return view('invoice.index-tarif')->with($data);
    }
    
    public function tarifCreate()
    {
        if ( !$this->access->can('show.tarif.create') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Create Tarif";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-tarif-index'),
                'title' => 'Daftar Tarif'
            ],
            [
                'action' => '',
                'title' => 'Create'
            ]
        ];         
        
        $data['consolidators'] = \App\Models\Consolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        
        return view('invoice.create-tarif')->with($data);
    }

    public function tarifView($id)
    {
        if ( !$this->access->can('show.tarif.view') ) {
            return view('errors.no-access');
        }
        
        $tarif = \DB::table('invoice_tarif')->find($id);
        
        $data['page_title'] = "Daftar Item Tarif ".$tarif->type;
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-tarif-index'),
                'title' => 'Daftar Tarif'
            ],
            [
                'action' => '',
                'title' => "Daftar Item Tarif ".$tarif->type
            ]
        ];        
        
        $data['tarif'] = $tarif;
        
        return view('invoice.view-tarif')->with($data);
    }
    
    public function tarifEdit($id)
    {
        if ( !$this->access->can('show.tarif.edit') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Edit Tarif";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-tarif-index'),
                'title' => 'Daftar Tarif'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];         
        $data['tarif'] = \App\Models\InvoiceTarif::find($id);
        $data['consolidators'] = \App\Models\Consolidator::select('TCONSOLIDATOR_PK as id','NAMACONSOLIDATOR as name')->get();
        
        return view('invoice.update-tarif')->with($data);
    }
    
    public function tarifStore(Request $request)
    {
        if ( !$this->access->can('store.tarif.create') ) {
            return view('errors.no-access');
        }
        
        $validator = \Validator::make($request->all(), [
            'consolidator_id' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $data = $request->except(['_token']);
        $data['UID'] = \Auth::getUser()->name;
        
        $insert_id = \App\Models\InvoiceTarif::insertGetId($data);
        
        if($insert_id){
            return redirect()->route('invoice-tarif-index')->with('success', 'Tarif has been created.');
        }
        
        return back()->with('error', 'Tarif cannot create, please try again.')->withInput();
    }
    
    public function tarifUpdate(Request $request, $id)
    {
        if ( !$this->access->can('show.tarif.edit') ) {
            return view('errors.no-access');
        }
        
        $validator = \Validator::make($request->all(), [
            'consolidator_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $data = $request->except(['_token']);
        if(!isset($data['surcharge'])) { $data['surcharge'] = 0; }
        if(!isset($data['cbm'])) { $data['cbm'] = 0; }
        if(!isset($data['pembulatan'])) { $data['pembulatan'] = 0; }

        $update = \App\Models\InvoiceTarif::where('id', $id)->update($data);
        
        if($update){
            return redirect()->route('invoice-tarif-index')->with('success', 'Tarif has been updated.');
        }
        
        return back()->with('error', 'Tarif cannot update, please try again.')->withInput();
    }
    
    public function tarifDestroy($id)
    {
        \App\Models\InvoiceTarif::where('id', $id)->delete();
        return back()->with('success', 'Invoice tarif has been deleted.'); 
    }
    
    public function tarifItemEdit($id)
    {
        if ( !$this->access->can('show.tarif.item.edit') ) {
            return view('errors.no-access');
        }
        
        $tarif_item = \DB::table('invoice_tarif_item')->find($id);
        
        $data['page_title'] = "Edit Item Tarif ".$tarif_item->description;
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-tarif-index'),
                'title' => 'Daftar Tarif'
            ],
            [
                'action' => '',
                'title' => "Edit Item Tarif ".$tarif_item->description
            ]
        ];        
        
        $data['item'] = $tarif_item;
        
        return view('invoice.edit-tarif')->with($data);
    }
    
    public function tarifItemUpdate(Request $request, $id)
    {
        if ( !$this->access->can('update.tarif.item.edit') ) {
            return view('errors.no-access');
        }
        
        unset($request['_token']);
        
        //UPDATE TARIF
        $update = \DB::table('invoice_tarif_item')->where('id', $id)
            ->update($request->all());

        if($update){

            return back()->with('success', 'LCL Register has been updated.');                   
        }
        
        return back()->with('error', 'Something wrong, please try again.')->withInput();
    }
    
    
//    FCL INVOICE
    public function invoiceNctIndex()
    {
        if ( !$this->access->can('show.invoicenct.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Invoice NCT1";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Invoice NCT1'
            ]
        ];        

        return view('invoice.index-invoice-nct')->with($data);
    }
    
    public function invoiceNctEdit($id)
    {
        if ( !$this->access->can('edit.invoiceNct.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Edit Invoice NCT1";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => route('invoice-nct-index'),
                'title' => 'Invoice NCT1'
            ],
            [
                'action' => '',
                'title' => 'Edit'
            ]
        ];
        
        $data['invoice'] = \App\Models\InvoiceNct::find($id);
        $data['penumpukan'] = \App\Models\InvoiceNctPenumpukan::where('invoice_nct_id', $data['invoice']->id)->get();
        $data['gerakan'] = \App\Models\InvoiceNctGerakan::where('invoice_nct_id', $data['invoice']->id)->orderBy('lokasi_sandar', 'ASC')->get();
        $data['tarif'] = \App\Models\InvoiceTarifNct::get();
        $data['terbilang'] = ucwords($this->terbilang($data['invoice']->total))." Rupiah";
        
        return view('invoice.edit-invoice-nct')->with($data);
    }
    
    public function invoiceNctDestroy($id)
    {
        \App\Models\InvoiceNct::where('id', $id)->delete();
        \App\Models\InvoiceNctPenumpukan::where('invoice_nct_id', $id)->delete();
        \App\Models\InvoiceNctGerakan::where('invoice_nct_id', $id)->delete();
        
        return back()->with('success', 'Invoice has been deleted.'); 
    }
    
    public function invoiceNctPrint($id)
    {
        $data['invoice'] = \App\Models\InvoiceNct::find($id);
        $data['penumpukan'] = \App\Models\InvoiceNctPenumpukan::where('invoice_nct_id', $data['invoice']->id)->get();
        $data['gerakan'] = \App\Models\InvoiceNctGerakan::where('invoice_nct_id', $data['invoice']->id)->orderBy('lokasi_sandar', 'ASC')->get();
        $data['tarif'] = \App\Models\InvoiceTarifNct::get();
        $data['terbilang'] = ucwords($this->terbilang($data['invoice']->total))." Rupiah";
        return view('print.invoice-nct')->with($data);
        $pdf = \PDF::loadView('print.invoice-nct', $data)->setPaper('legal');
        
        return $pdf->stream($data['invoice']->no_invoice.'.pdf');
    }
    
    public function tarifNctIndex()
    {
        if ( !$this->access->can('show.tarifnct.index') ) {
            return view('errors.no-access');
        }
        
        $data['page_title'] = "Daftar Tarif";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Daftar Tarif'
            ]
        ];        
        
        return view('invoice.index-tarif-nct')->with($data);
    }
    
    public function releaseNctIndex()
    {
        if ( !$this->access->can('show.invoice.releasenct.index') ) {
            return view('errors.no-access');
        }
        
        // Create Roles Access
        $this->insertRoleAccess(array('name' => 'Index Invoice Release NCT1', 'slug' => 'show.invoice.releasenct.index', 'description' => ''));
        
        $data['page_title'] = "Invoice Release FCL";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Invoice Release FCL'
            ]
        ];        
        
//        $data['perusahaans'] = DBPerusahaan::select('TPERUSAHAAN_PK as id', 'NAMAPERUSAHAAN as name')->get();
        
        return view('invoice.index-release-fcl')->with($data);
    }
    
    public function invoiceNctRenew(Request $request)
    {

        $invoice = \App\Models\InvoiceNct::find($request->invoice_id);
        $no_cont = explode(',', $invoice->no_container);
        
        // array jenis container
        $std = array(
            'DRY'
        );
        $low = array(
            'Class BB Standar 3',
            'Class BB Standar 8',
            'Class BB Standar 9',
            'Class BB Standar 4,1',
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
            'REFFER RECOOLING'
        );
        
        $ft = array(
            'OPEN TOP',
            'FLAT TRACK RF',
            'FLAT TRACK OH',
            'FLAT TRACK OW',
            'FLAT TRACK OL'
        );
        
        $container20 = DBContainer::where('size', 20)->whereIn('NOCONTAINER', $no_cont)->get();
        $container40 = DBContainer::where('size', 40)->whereIn('NOCONTAINER', $no_cont)->get();
        $container45 = DBContainer::where('size', 45)->whereIn('NOCONTAINER', $no_cont)->get();
        
        
        if($container20 || $container40 || $container45) {
            
            $data = (count($container20) > 0 ? $container20['0'] : $container40['0']);
//            $consignee = DBPerusahaan::where('TPERUSAHAAN_PK', $data['TCONSIGNEE_FK'])->first();
            
//            Detect Jenis Container
            $jenis_cont = $data['jenis_container'];
            
            if(in_array($jenis_cont, $std)){
                $type = 'Standar';
            }else if(in_array($jenis_cont, $low)){
                $type = 'Low';
            }else if(in_array($jenis_cont, $high)){
                $type = 'High';
            }else if(in_array($jenis_cont, $reffer)){
                $type = 'Reffer';
            }else if(in_array($jenis_cont, $ft)){
                $type = 'Flatrack';
            }else{
                return back()->with('error', 'Container type '.$jenis_cont.' not detected.');
            }
            
            $no_faktur = '___/FKT/IMS/TPS/'.$this->romawi(date('n')).'/'.date('Y');
            
            // Create Invoice Header
            $invoice_nct = new \App\Models\InvoiceNct;
            $invoice_nct->renew = 'Y';
            $invoice_nct->renew_date = $request->renew_date;	
            $invoice_nct->no_spk = $data['NOSPK'];
            $invoice_nct->jenis_container = $jenis_cont;
            $invoice_nct->kd_gudang = $data['GUDANG_TUJUAN'];
            $invoice_nct->no_invoice = $no_faktur;	
//            $invoice_nct->no_pajak = $request->no_pajak;	
            $invoice_nct->consignee = $invoice->consignee;	
            $invoice_nct->npwp = $invoice->npwp;
            $invoice_nct->alamat = $invoice->alamat;	
            $invoice_nct->consignee_id = $invoice->consignee_id;	
            $invoice_nct->vessel = $data['VESSEL'];	
            $invoice_nct->voy = $data['VOY'];	
//            $invoice_nct->no_do = $request->no_do;	
            $invoice_nct->tgl_do = $invoice->tgl_do;
            $invoice_nct->no_bl = $invoice->no_bl;	
            $invoice_nct->eta = $data['ETA'];	
            $invoice_nct->gateout_terminal = $data['TGLMASUK'];	
            $invoice_nct->gateout_tps = $data['TGLRELEASE'];	
            $invoice_nct->uid = \Auth::getUser()->name;	
            
            if($invoice_nct->save()) {
                 
                // Insert Invoice Detail
                if(count($container20) > 0) {
                    
                    $tarif20 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 20, 'lokasi_sandar' => 'AIRIN'))->get();
                    
                    foreach ($tarif20 as $t20) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;                      

                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t20->lokasi_sandar;
                        $invoice_penumpukan->size = 20;
                        $invoice_penumpukan->qty = count($container20);
                        
                        if($t20->lokasi_sandar == 'AIRIN') {
                            
                            // GERAKAN
//                            if($request->behandle) {
//                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' => $t20->paket_plp,'Behandle' => $t20->behandle);
//                            }else{
//                                $jenis = array('Lift On/Off' => $t20->lift_off,'Paket PLP' => $t20->paket_plp);
//                            }
//                              
//                            foreach ($jenis as $key=>$value):
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                        
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
//                                $invoice_gerakan->size = 20;
//                                if($key == 'Lift On/Off'){
//                                    $invoice_gerakan->qty = count($container20)*2;
//                                }else{
//                                    $invoice_gerakan->qty = count($container20);
//                                } 
//                                $invoice_gerakan->jenis_gerakan = $key;
//                                $invoice_gerakan->tarif_dasar = $value;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
//                                
//                                $invoice_gerakan->save();
//                            endforeach;
//                            
//                            if($t20->recooling){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
//                                $invoice_gerakan->size = 20;
//                                $invoice_gerakan->qty = count($container20); 
//                                $invoice_gerakan->jenis_gerakan = 'Recooling';
//                                $invoice_gerakan->tarif_dasar = $t20->recooling;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->recooling;
//                                $invoice_gerakan->save();
//                            }
//                            
//                            if($t20->monitoring){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t20->lokasi_sandar;
//                                $invoice_gerakan->size = 20;
//                                $invoice_gerakan->qty = count($container20); 
//                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
//                                $invoice_gerakan->tarif_dasar = $t20->monitoring;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t20->monitoring;
//                                $invoice_gerakan->save();
//                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLRELEASE']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // PERPANJANGAN
                            $date1p = date_create($data['TGLRELEASE']);
                            $date2p = date_create(date('Y-m-d',strtotime($request->renew_date. '+1 days')));
                            $diffp = date_diff($date1p, $date2p);
                            $hari_perpanjang = $diffp->format("%a");
                            
                            // Perhitungan Masa 1
                            if(($hari_terminal+$hari) >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-($hari_terminal+$hari)),$hari_perpanjang);
                            }
                            
                            $hari_masa2 = abs($hari_perpanjang - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLRELEASE'];
                            $invoice_penumpukan->enddate = $request->renew_date;
                            $invoice_penumpukan->lama_timbun = $hari_perpanjang;        
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

                    $tarif40 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 40, 'lokasi_sandar' => 'AIRIN'))->get();

                    foreach ($tarif40 as $t40) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                        
                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t40->lokasi_sandar;
                        $invoice_penumpukan->size = 40;
                        $invoice_penumpukan->qty = count($container40);
                        
                        if($t40->lokasi_sandar == 'AIRIN') {
                            // GERAKAN
//                            if($request->behandle) {
//                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $t40->paket_plp,'Behandle' => $t40->behandle);
//                            }else{
//                                $jenis = array('Lift On/Off' => $t40->lift_off,'Paket PLP' => $t40->paket_plp);
//                            }
//                            
//                            foreach ($jenis as $key=>$value):
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                        
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
//                                $invoice_gerakan->size = 40;
//                                if($key == 'Lift On/Off'){
//                                    $invoice_gerakan->qty = count($container40)*2;
//                                }else{
//                                    $invoice_gerakan->qty = count($container40);
//                                }
//                                $invoice_gerakan->jenis_gerakan = $key;
//                                $invoice_gerakan->tarif_dasar = $value;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
//                                
//                                $invoice_gerakan->save();
//                            endforeach;
//                            
//                            if($t40->recooling){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
//                                $invoice_gerakan->size = 40;
//                                $invoice_gerakan->qty = count($container40); 
//                                $invoice_gerakan->jenis_gerakan = 'Recooling';
//                                $invoice_gerakan->tarif_dasar = $t40->recooling;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->recooling;
//                                $invoice_gerakan->save();
//                            }
//                            
//                            if($t40->monitoring){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t40->lokasi_sandar;
//                                $invoice_gerakan->size = 40;
//                                $invoice_gerakan->qty = count($container40); 
//                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
//                                $invoice_gerakan->tarif_dasar = $t40->monitoring;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t40->monitoring;
//                                $invoice_gerakan->save();
//                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLRELEASE']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // PERPANJANGAN
                            $date1p = date_create($data['TGLRELEASE']);
                            $date2p = date_create(date('Y-m-d',strtotime($request->renew_date. '+1 days')));
                            $diffp = date_diff($date1p, $date2p);
                            $hari_perpanjang = $diffp->format("%a");
                            
                            // Perhitungan Masa 1
                            if(($hari_terminal+$hari) >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-($hari_terminal+$hari)),$hari_perpanjang);
                            }
                            
                            $hari_masa2 = abs($hari_perpanjang - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLRELEASE'];
                            $invoice_penumpukan->enddate = $request->renew_date;
                            $invoice_penumpukan->lama_timbun = $hari_perpanjang;  
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

                    $tarif45 = \App\Models\InvoiceTarifNct::where(array('type' => $type, 'size' => 45, 'lokasi_sandar' => 'AIRIN'))->get();

                    foreach ($tarif45 as $t45) :
                        
                        $invoice_penumpukan = new \App\Models\InvoiceNctPenumpukan;
                        
                        $invoice_penumpukan->invoice_nct_id = $invoice_nct->id;
                        $invoice_penumpukan->lokasi_sandar = $t45->lokasi_sandar;
                        $invoice_penumpukan->size = 45;
                        $invoice_penumpukan->qty = count($container45);
                        
                        if($t45->lokasi_sandar == 'AIRIN') {
                            // GERAKAN
//                            if($request->behandle) {
//                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp,'Behandle' => $t45->behandle);
//                            }else{
//                                $jenis = array('Lift On/Off' => $t45->lift_off,'Paket PLP' => $t45->paket_plp);
//                            }
//                            
//                            foreach ($jenis as $key=>$value):
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                        
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
//                                $invoice_gerakan->size = 45;
//                                if($key == 'Lift On/Off'){
//                                    $invoice_gerakan->qty = count($container45)*2;
//                                }else{
//                                    $invoice_gerakan->qty = count($container45);
//                                }
//                                $invoice_gerakan->jenis_gerakan = $key;
//                                $invoice_gerakan->tarif_dasar = $value;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $value;
//                                
//                                $invoice_gerakan->save();
//                            endforeach;
//                            
//                            if($t45->recooling){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
//                                $invoice_gerakan->size = 45;
//                                $invoice_gerakan->qty = count($container45); 
//                                $invoice_gerakan->jenis_gerakan = 'Recooling';
//                                $invoice_gerakan->tarif_dasar = $t45->recooling;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->recooling;
//                                $invoice_gerakan->save();
//                            }
//                            
//                            if($t45->monitoring){
//                                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                                $invoice_gerakan->lokasi_sandar = $t45->lokasi_sandar;
//                                $invoice_gerakan->size = 45;
//                                $invoice_gerakan->qty = count($container45); 
//                                $invoice_gerakan->jenis_gerakan = 'Monitoring';
//                                $invoice_gerakan->tarif_dasar = $t45->monitoring;
//                                $invoice_gerakan->total = $invoice_gerakan->qty * $t45->monitoring;
//                                $invoice_gerakan->save();
//                            }
                            
                            // PENUMPUKAN
                            $date1 = date_create($data['TGLMASUK']);
//                            $date2 = date_create($data['TGLRELEASE']);
                            $date2 = date_create(date('Y-m-d',strtotime($data['TGLRELEASE']. '+1 days')));
                            $diff = date_diff($date1, $date2);
                            $hari = $diff->format("%a");
                            
                            // HARI TERMINAL
                            $date1t = date_create($data['ETA']);
                            $date2t = date_create(date('Y-m-d',strtotime($data['TGLMASUK']. '+1 days')));
                            $difft = date_diff($date1t, $date2t);
                            $hari_terminal = $difft->format("%a");
                            
                            // PERPANJANGAN
                            $date1p = date_create($data['TGLRELEASE']);
                            $date2p = date_create(date('Y-m-d',strtotime($request->renew_date. '+1 days')));
                            $diffp = date_diff($date1p, $date2p);
                            $hari_perpanjang = $diffp->format("%a");
                            
                            // Perhitungan Masa 1
                            if(($hari_terminal+$hari) >= 10){
                                $hari_masa1 = 0;
                            }else{  
                                $hari_masa1 = min(abs(10-($hari_terminal+$hari)),$hari_perpanjang);
                            }
                            
                            $hari_masa2 = abs($hari_perpanjang - $hari_masa1);
                            
                            $invoice_penumpukan->startdate = $data['TGLRELEASE'];
                            $invoice_penumpukan->enddate = $request->renew_date;
                            $invoice_penumpukan->lama_timbun = $hari_perpanjang;  
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
            
//            $nct_gerakan = array('Pas Truck' => 9091, 'Gate Pass Admin' => 20000, 'Cost Recovery' => 75000);
//            
//            foreach($nct_gerakan as $key=>$value):
//                $invoice_gerakan = new \App\Models\InvoiceNctGerakan;
//                        
//                $invoice_gerakan->invoice_nct_id = $invoice_nct->id;
//                $invoice_gerakan->lokasi_sandar = 'NPCT1';
//                $invoice_gerakan->size = 0;
//                $invoice_gerakan->qty = count($container20)+count($container40); 
//                $invoice_gerakan->jenis_gerakan = $key;
//                $invoice_gerakan->tarif_dasar = $value;
//                $invoice_gerakan->total = (count($container20)+count($container40)) * $value;
//
//                $invoice_gerakan->save();
//            endforeach;
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
            }elseif($type == 'Low' || $type == 'High'){
                $update_nct->dg_surcharge = ($total_penumpukan_tps + $total_gerakan_tps)*25/100;
                $update_nct->surcharge = 25;
            }else{
                $update_nct->dg_surcharge = 0;
                $update_nct->surcharge = 0;
            }
            
            $update_nct->administrasi = (count($container20)+count($container40)+count($container45)) * 20000;
            $update_nct->total_non_ppn = $total_penumpukan + $total_gerakan + $update_nct->dg_surcharge + $update_nct->administrasi;	
            $update_nct->ppn = $update_nct->total_non_ppn * 10/100;	
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
    }

}
