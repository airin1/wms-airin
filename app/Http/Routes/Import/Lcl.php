<?php

Route::group(['prefix' => 'lcl', 'namespace' => 'Import'], function(){
    
    Route::get('/register', [
        'as' => 'lcl-register-index',
        'uses' => 'LclController@registerIndex'
    ]);
    Route::post('/joborder/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\Joborder(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/register/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\Container(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::get('/register/create', [
        'as' => 'lcl-register-create',
        'uses' => 'LclController@registerCreate'
    ]);
    Route::post('/register/create', [
        'as' => 'lcl-register-store',
        'uses' => 'LclController@registerStore'
    ]);
    Route::get('/register/edit/{id}', [
        'as' => 'lcl-register-edit',
        'uses' => 'LclController@registerEdit'
    ]);
    Route::post('/register/edit/{id}', [
        'as' => 'lcl-register-update',
        'uses' => 'LclController@registerUpdate'
    ]);
    Route::get('/register/delete/{id}', [
        'as' => 'lcl-register-delete',
        'uses' => 'LclController@destroy'
    ]);
    
    Route::post('/register/print-permohonan', [
        'as' => 'lcl-register-print-permohonan',
        'uses' => 'LclController@registerPrintPermohonan'
    ]);
    
    Route::post('/register/upload-file', [
        'as' => 'lcl-register-upload-file',
        'uses' => 'LclController@uploadTxtFile'
    ]); 
    
    Route::post('/register/upload-xls-file', [
        'as' => 'lcl-register-upload-xls-file',
        'uses' => 'LclController@uploadXlsFile'
    ]); 
    
    Route::get('/dispatche', [
        'as' => 'lcl-dispatche-index',
        'uses' => 'LclController@dispatcheIndex'
    ]);
    Route::post('/dispatche/edit/{id}', [
        'as' => 'lcl-dispatche-update',
        'uses' => 'LclController@dispatcheUpdate'
    ]);
    
    Route::get('/status-behandle', [
        'as' => 'lcl-behandle-index',
        'uses' => 'LclController@statusBehandleIndex'
    ]);
    Route::get('/status-behandle/finish', [
        'as' => 'lcl-behandle-finish',
        'uses' => 'LclController@statusBehandleFinish'
    ]);
    Route::post('/status-behandle/checking', [
        'as' => 'lcl-change-status-behandle',
        'uses' => 'LclController@changeStatusBehandle'
    ]);
    
    // REPORT
    Route::get('/report/inout', [
        'as' => 'lcl-report-inout',
        'uses' => 'LclController@reportInout'
    ]);
    Route::get('/report/inout/view-photo/{id}', [
        'as' => 'lcl-report-inout-view-photo',
        'uses' => 'LclController@reportInoutViewPhoto'
    ]);	
	Route::get('/report/inout/view-photo-empty/{id}', [
        'as' => 'lcl-report-inout-view-photo-empty',
        'uses' => 'LclController@reportInoutViewPhotoEmpty'
    ]);
    Route::get('/report/container', [
        'as' => 'lcl-report-container',
        'uses' => 'LclController@reportContainer'
    ]);
    Route::get('/report/container/view-photo/{id}', [
        'as' => 'lcl-report-container-view-photo',
        'uses' => 'LclController@reportContainerViewPhoto'
    ]);
    Route::get('/report/harian', [
        'as' => 'lcl-report-harian',
        'uses' => 'LclController@reportHarian'
    ]);
    Route::get('/report/harian/cetak/{date}/{type}/{gd}', [
        'as' => 'lcl-report-harian-cetak',
        'uses' => 'LclController@reportHarianCetak'
    ]);
    Route::get('/report/rekap', [
        'as' => 'lcl-report-rekap',
        'uses' => 'LclController@reportRekap'
    ]);
    Route::get('/report/stock', [
        'as' => 'lcl-report-stock',
        'uses' => 'LclController@reportStock'
    ]);
    Route::get('/report/longstay', [
        'as' => 'lcl-report-longstay',
        'uses' => 'LclController@reportLongstay'
    ]);
    Route::get('/report/longstay/view-flag-info/{id}', [
        'as' => 'lcl-view-info-flag',
        'uses' => 'LclController@viewFlagInfo'
    ]);
    Route::get('/report/longstay/change-status/{id}', [
        'as' => 'lcl-change-status',
        'uses' => 'LclController@changeStatusBc'
    ]);
	Route::get('/report/longstay/change-status-mty/{id}', [
        'as' => 'lcl-change-status-mty',
        'uses' => 'LclController@changeStatusBcmty'
    ]);
	
	
    Route::get('/report/longstay/change-status-flag/{id}', [
        'as' => 'lcl-change-status-flag',
        'uses' => 'LclController@changeStatusFlag'
    ]);
    Route::post('/report/longstay/lock-flag', [
        'as' => 'lcl-lock-flag',
        'uses' => 'LclController@lockFlag'
    ]);
    Route::post('/report/longstay/unlock-flag', [
        'as' => 'lcl-unlock-flag',
        'uses' => 'LclController@unlockFlag'
    ]);
    
    // Menu BC
    Route::get('/bc/hold', [
        'as' => 'lcl-hold-index',
        'uses' => 'LclController@holdIndex'
    ]);
	
	 Route::get('/bc/mtyhold', [
        'as' => 'lcl-mtyhold-index',
        'uses' => 'LclController@mtyholdIndex'
    ]);
    Route::get('/bc/segel', [
        'as' => 'lcl-segel-index',
        'uses' => 'LclController@segelIndex'
    ]);
	Route::get('/bc/lain', [
        'as' => 'lcl-lain-index',
        'uses' => 'LclController@lainIndex'
    ]);

    Route::get('/bc/segel/report', [
        'as' => 'lcl-segel-report',
        'uses' => 'LclController@segelReport'
    ]);
    Route::get('/bc/report-container', [
        'as' => 'lcl-bc-report-container',
        'uses' => 'LclController@reportContainerIndex'
    ]);
    Route::get('/bc/report-stock', [
        'as' => 'lcl-bc-report-stock',
        'uses' => 'LclController@reportStockIndex'
    ]);
    Route::get('/bc/inventory', [
        'as' => 'lcl-bc-report-inventory',
        'uses' => 'LclController@reportInventoryIndex'
    ]);
    
    // Menu Photo
    Route::get('/photo/container', [
        'as' => 'lcl-photo-container-index',
        'uses' => 'PhotoController@lclPhotoContainerIndex'
    ]);
    Route::get('/photo/cargo', [
        'as' => 'lcl-photo-cargo-index',
        'uses' => 'PhotoController@lclPhotoCargoIndex'
    ]);
    // UPLOAD PHOTO
    Route::post('/photo/container/upload', [
        'as' => 'lcl-container-upload-photo',
        'uses' => 'PhotoController@containerUploadPhoto'
    ]);
    Route::post('/photo/cargo/upload', [
        'as' => 'lcl-cargo-upload-photo',
        'uses' => 'PhotoController@cargoUploadPhoto'
    ]);
});
