<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
ini_set('default_socket_timeout', 60);
//Route::group(['middleware' => ['web']], function(){

    if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
        // Ignores notices and reports all other kinds... and warnings
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
    }
    
    Route::group(['middleware' => ['web']], function(){
        
        // EasyGo Routes
        require_once 'Routes/RoutesEasyGo.php';
        
        Route::group(['namespace' => 'Web', 'prefix' => 'website'], function(){
        
            // Website Routes
//            require_once 'Routes/RoutesWebsite.php';
        
        });

    });

    Route::group(['middleware' => ['guest'], 'namespace' => 'Auth'], function(){
        
        // Login Routes
        Route::get('/login', [
            'as' => 'login',
            'uses' => 'AuthController@getLogin'
        ]);
        Route::post('/login', [
            'as' => 'login',
            'uses' => 'AuthController@postLogin'
        ]);
        
    });
    
    Route::group(['middleware' => ['auth']/*, 'prefix' => 'wms', 'domain' => 'wms.prjp.co.id'*/], function(){
        
        // Dashboard Routes
        Route::get('/', [
            'as' => 'index',
            'uses' => 'DashboardController@index'
        ]);
		
		Route::get('/export', [
            'as' => 'export_excel',
            'uses' => 'DashboardController@export_excel'
        ]);		
		
		
        // Logout Routes
        Route::get('/logout', [
            'as' => 'logout',
            'uses' => 'Auth\AuthController@logout'
        ]);
        
        // User Routes
        require_once 'Routes/RoutesUser.php';
        
        // Data Routes
        require_once 'Routes/RoutesData.php';
        
        // Import Routes
        require_once 'Routes/RoutesImport.php';
        
        // TPS Online Routes
        require_once 'Routes/RoutesTpsonline.php';
        
        // Invoice Routes
        require_once 'Routes/RoutesInvoice.php';
        
        // Payment Routes
        require_once 'Routes/RoutesPayment.php';
        
        // Barcode Routes
        require_once 'Routes/RoutesBarcode.php';
        
        // NPCT1 Routes
        require_once 'Routes/RoutesNpct.php';
        
        // Export
        require_once 'Routes/RoutesExport.php';

        // GLOBAL Routes
        Route::get('/getDataPelabuhan', [
            'as' => 'getDataPelabuhan',
            'uses' => 'Controller@getDataPelabuhan'
        ]);
        Route::get('/getDataCodePelabuhan', [
            'as' => 'getDataCodePelabuhan',
            'uses' => 'Controller@getDataCodePelabuhan'
        ]);
        Route::get('/getDataPerusahaan', [
            'as' => 'getDataPerusahaan',
            'uses' => 'Controller@getDataPerusahaan'
        ]);
        Route::get('/getSingleDataPerusahaan', [
            'as' => 'getSingleDataPerusahaan',
            'uses' => 'Controller@getSingleDataPerusahaan'
        ]);
		//get cek invoice 
		Route::get('/getCekInvoice', [
            'as' => 'getCekInvoice',
            'uses' => 'Controller@getCekInvoice'
        ]);
    });
    
    Route::get('/demo', ['as' => 'demo', 'uses' => 'Tps\SoapController@demo']);
    
//});

// FlatFIle
Route::get('/flat', [
    'uses' => 'DefaultController@getFlatFile',
    'as' => 'flat-file'
]);



// Auto Gate
//Route::get('/autogate/notification/{barcode}', [
//    'uses' => 'BarcodeController@autogateNotification',
//    'as' => 'autogate-notification'
//]);
Route::post('/autogate/notification', [
    'uses' => 'BarcodeController@autogateNotification',
    'as' => 'autogate-notification'
]);

Route::get('/autogate/npctmovementcreate', [
    'uses' => 'BarcodeController@AutoMovementContainer',
    'as' => 'autogate-npctmovementcreate'
    ]);
	
Route::get('/autogate/npctmovementcreatemanual', [
    'uses' => 'BarcodeController@ManualMovementContainer',
    'as' => 'autogate-npctmovementcreatemanual'
    ]);	
	
Route::get('/autogate/npctmovementcreatemanualLCL', [
    'uses' => 'BarcodeController@ManualMovementContainerLCL',
    'as' => 'autogate-npctmovementcreatemanualLCL'
    ]);		

Route::get('/autogate/npctmovementupload', [
    'uses' => 'BarcodeController@AutomovementUpload',
    'as' => 'autogate-npctmovementupload'
    ]);	

Route::group(['namespace' => 'Payment'], function(){
    // BNI Notification
    Route::post('payment/bni/notification', [
        'as' => 'payment-bni-notification',
        'uses' => 'PaymentController@bniNotification'
    ]);
});

// IP Camera
Route::get('/capture/camera1', [
    'uses' => 'DefaultController@captureIpCamera',
    'as' => 'capture-camera1'
]);


Route::get('/update-stock', [
    'uses' => 'DefaultController@stockUpdate',
    'as' => 'update-stock'
]);