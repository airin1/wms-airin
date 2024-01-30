<?php
Route::group(['prefix' => 'export', 'namespace' => 'Export'], function(){

    Route::get('/release', [
        'as' => 'exp-release-gateOut',
        'uses' => 'DeliveryController@gateOut'
    ]);

    Route::post('/release/barcode', [
        'as' => 'exp-release-barcode',
        'uses' => 'DeliveryController@barcode'
    ]);

    Route::get('/delivery/gateOut', [
        'as' => 'exp-getData-gateOut',
        'uses' => 'DeliveryController@getData'
    ]);

    Route::get('/search/pkbe', [
        'as' => 'exp-getData-pkbe',
        'uses' => 'DeliveryController@pkbe'
    ]);

    Route::post('/release/updateGateOut', [
        'as' => 'exp-realisasi-gateOut-update',
        'uses' => 'DeliveryController@update'
    ]);

    Route::get('/release/hold/bc', [
        'as' => 'exp-release-HoldBC',
        'uses' => 'DeliveryController@bcIndex'
    ]);

    Route::post('/release/bcCONT', [
        'as' => 'exp-release-ContRelease',
        'uses' => 'DeliveryController@Release'
    ]);

    Route::get('/release/photo', [
        'as' => 'exp-release-photo',
        'uses' => 'DeliveryController@photo'
    ]);

    Route::post('/release/gateOut/TPS', [
        'as' => 'exp-UploadTPS-codeco-cont',
        'uses' => 'DeliveryController@TPS'
    ]);

    Route::get('/release/suratJalan', [
        'as' => 'exp-release-SuratJalan',
        'uses' => 'DeliveryController@SuratJalan'
    ]);

    Route::get('/release/suratJalan/{id}', [
        'as' => 'exp-cetak-suratJalan',
        'uses' => 'DeliveryController@viewSuratJalan'
    ]);
});