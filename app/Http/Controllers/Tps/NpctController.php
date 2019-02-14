<?php

namespace App\Http\Controllers\Tps;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Artisaninweb\SoapWrapper\Facades\SoapWrapper;

class NpctController extends Controller
{
    protected $wsdl;
    protected $user;
    protected $password;
    protected $kode;
    protected $response;

    public function __construct() {
        
        parent::__construct();

        $this->wsdl = 'https://api.npct1.co.id/services/index.php/line2dev?wsdl';
        $this->user = 'lini2';
        $this->password = 'lini2@2018';
        $this->kode = 'AIRN';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function yorIndex()
    {
        $data['page_title'] = "Laporan Data YOR";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Laporan Data YOR'
            ]
        ];        
        
        return view('npct.index-yor')->with($data);
    }
    
    public function MovementIndex()
    {
        $data['page_title'] = "Laporan Data Movement";
        $data['page_description'] = "";
        $data['breadcrumbs'] = [
            [
                'action' => '',
                'title' => 'Laporan Data Movement'
            ]
        ];        
        
        return view('tpsonline.index-coari-cont')->with($data);
    }
    
    public function yorCreateReport(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'warehouse_code' => 'required',
            'yor' => 'required',
            'capacity' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $data = $request->except(['_token']); 
        $data['status'] = 0;
        $data['uid'] = \Auth::getUser()->name;;
        
        $insert_id = \App\Models\NpctYor::insertGetId($data);
        
        if($insert_id){
            return back()->with('success', 'YOR Report has been created.');
        }
        
        return back()->withInput();
    }
    
    public function yorUpload($id)
    {
        $data = \App\Models\NpctYor::find($id);
        
        $arrContextOptions = array("ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,'allow_self_signed' => true));
        
        $options = array(
            'exceptions'=>true,
            'trace'=>1,
            'cache_wsdl'=>WSDL_CACHE_NONE,
            'stream_context' => stream_context_create($arrContextOptions)
        );
        
        $client = new \SoapClient($this->wsdl, $options); 
        // Call wsdl function 
        $result = $client->yor();
        var_dump($result);
    }
    
    public function yorUpload1($id)
    {
        if(!$id){ return false; }
        
        $data = \App\Models\NpctYor::find($id);

        \SoapWrapper::add(function ($service) {
            $service
                ->name('yorRequest')
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
                    ])
                ]);                                                    
        });
        
        $reqData = [
            'username' => $this->user, 
            'Password' => $this->password,
            'warehouse_code' => $data->warehouse_code,
            'yor' => $data->yor,
            'capacity' => $data->capacity
        ];
        
        // Using the added service
        \SoapWrapper::service('yorRequest', function ($service) use ($reqData) {    
            var_dump($service->getFunctions());
            var_dump($service->call('yor', [$reqData])->yorResponse);
//            $this->response = $service->call('yor', [$reqData])->yorResponse;      
        });
        
        $update = \App\Models\NpctYor::where('id', $id)->update(['status' => 1, 'response' => $this->response]);       
        
//        if ($update){
//            return back()->with('success', 'Laporan YOR berhasil dikirim.');
//        }
        
        var_dump($this->response);
    }
    
}
