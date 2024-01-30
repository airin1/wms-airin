<?php

Route::group(['prefix' => 'exp', 'namespace' => 'Export'], function(){
    
    Route::get('/register', [
        'as' => 'exp-register-index',
        'uses' => 'RegisterController@registerIndex'
    ]);
    Route::post('/joborder/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\JoborderExp(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/register/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\ContainerExp(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::get('/register/create', [
        'as' => 'exp-register-create',
        'uses' => 'RegisterController@registerCreate'
    ]);
    Route::post('/register/post', [
        'as' => 'exp-register-store',
        'uses' => 'RegisterController@registerStore'
    ]);
    Route::get('/register/edit/{id}', [
        'as' => 'exp-register-edit',
        'uses' => 'RegisterController@registerEdit'
    ]);
    Route::post('/register/update/{id}', [
        'as' => 'exp-register-update',
        'uses' => 'RegisterController@registerUpdate'
    ]);
    // Route::get('/register/delete/{id}', [
    //     'as' => 'lcl-register-delete',
    //     'uses' => 'LclController@destroy'
    // ]);

    Route::post('/register/create/cont', [
        'as' => 'create-register-cont',
        'uses' => 'RegisterController@containerManual'
    ]);

    Route::get('/register/container-edit/{id}', [
        'as' => 'edit-register-cont',
        'uses' => 'RegisterController@containerEdit'
    ]);

    Route::post('/register/container/update', [
        'as' => 'udpate-container-register',
        'uses' => 'RegisterController@updateContainer'
    ]);

    Route::post('/register/container-delete', [
        'as' => 'delete-container-register',
        'uses' => 'RegisterController@deleteContainer'
    ]);

    Route::post('/register/barcode', [
        'as' => 'show-barcode-register',
        'uses' => 'RegisterController@barcode'
    ]);

    Route::get('/register/gateIn', [
        'as' => 'exp-register-gateIn',
        'uses' => 'RegisterController@gateIn'
    ]);

    Route::get('/register/gateIn/{id}', [
        'as' => 'exp-register-gateIn-Approve',
        'uses' => 'RegisterController@gateInApprove'
    ]);

    Route::post('/register/gateIn/approve', [
        'as' => 'exp-register-gateIn-Approve-masuk',
        'uses' => 'RegisterController@gateInApprovePost'
    ]);

    Route::post('/register/gateIn/TPS', [
        'as' => 'exp-register-UploadTPS-cont',
        'uses' => 'RegisterController@TPS'
    ]);
    
 
    
    
});
