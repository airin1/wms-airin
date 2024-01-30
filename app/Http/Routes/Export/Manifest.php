<?php

Route::group(['prefix' => 'export', 'namespace' => 'Export'], function(){
    
    Route::get('/manifest', [
        'as' => 'exp-manifest-index',
        'uses' => 'ManifestController@Index'
    ]);
    Route::post('/manifest/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\ManifestExp(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
	Route::post('/manifest/grid-data-mty', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\Container(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
	
    Route::post('/manifest/upload-xls-file', [
        'as' => 'create-manifest-excel-export',
        'uses' => 'ManifestController@uploadXlsManifest'
    ]);

    Route::get('/manifest/addManual', [
        'as' => 'create-manifest-manualForExport',
        'uses' => 'ManifestController@addManual'
    ]);

    Route::post('/manifest/create/manual', [
        'as' => 'create-manifest-manual',
        'uses' => 'ManifestController@createManual'
    ]);

    Route::post('/manifest/update/{id}',[
        'as' => 'update-manifest',
        'uses' => 'ManifestController@update',
    ]);
   
    Route::post('/search/npe',[
        'as' => 'cari-npe',
        'uses' => 'ManifestController@NPE',
    ]);
    Route::post('/manifest/approve',[
        'as' => 'approve-manifest',
        'uses' => 'ManifestController@approve',
    ]);

    Route::post('/manifest/barcode', [
        'as' => 'show-barcode-manifest',
        'uses' => 'ManifestController@barcode'
    ]);

    Route::get('/manifest/gateIn', [
        'as' => 'exp-manifest-gateIn',
        'uses' => 'ManifestController@gateIn'
    ]);

    Route::get('/manifest/gateIn/{id}', [
        'as' => 'exp-manifest-gateIn-Approve',
        'uses' => 'ManifestController@gateInApprove'
    ]);
    Route::post('/manifest/gateIn/approve', [
        'as' => 'exp-manifest-gateIn-Approve-masuk',
        'uses' => 'ManifestController@gateInApprovePost'
    ]);

    
    Route::get('/manifest/edit/{id}', [
        'as' => 'exp-manifest-edit',
        'uses' => 'ManifestController@edit'
    ]);
    
});