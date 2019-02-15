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

//        $this->wsdl = 'https://api.npct1.co.id/services/index.php/line2dev?wsdl';
        $this->wsdl = 'https://api.npct1.co.id/services/index.php/Line2?wsdl';
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
        
        return view('npct.index-movement')->with($data);
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
    
    public function yorUpload1($id)
    {
        $data = \App\Models\NpctYor::find($id);
        
        $arrContextOptions = array("ssl"=>array( "verify_peer"=>false, "verify_peer_name"=>false,'allow_self_signed' => true));
        
        $options = array(
            'exceptions'=>true,
            'trace'=>1,
            'cache_wsdl'=>WSDL_CACHE_NONE,
            "soap_version" => SOAP_1_1,
            'style'=> SOAP_DOCUMENT,
            'use'=> SOAP_LITERAL, 
            'stream_context' => stream_context_create($arrContextOptions)
        );
        
        $client = new \SoapClient($this->wsdl, $options); 
        
        $params = array(
            'username' => $this->user, 
            'Password' => $this->password,
            'warehouse_code' => $data->warehouse_code,
            'yor' => 10000,
            'capacity' => 20000
        );
        
        try {
            
            $versionResponse = $client->yor();
//            var_dump($client);
            print_r($versionResponse);
//            var_dump($client->__getFunctions());
//            $result = $client->__soapCall("yor",$params);        
//            var_dump($result);
        } catch (SoapFault $exception) {
            echo $exception;      
        } 
        
//        var_dump($client->__getFunctions());
        
        
    }
    
    public function yorUpload($id)
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
                    ]),
                    'soap_version' => SOAP_1_1
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
//            var_dump($service->getFunctions());
//            var_dump($service->call('yor', [$reqData])->yorResponse);
            $this->response = $service->call('yor', $reqData)->yorResponse;      
        });
        
        $update = \App\Models\NpctYor::where('id', $id)->update(['status' => 1, 'response' => $this->response]);       
        
        if ($update){
            return back()->with('success', 'Laporan YOR berhasil dikirim.');
        }
        
        var_dump($this->response);
    }
    
}
