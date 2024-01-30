<?php

Route::group(['prefix' => 'exp', 'namespace' => 'Export'], function(){

    Route::get('/stuffing', [
        'as' => 'exp-stuffing-index',
        'uses' => 'StufingController@Index'
    ]);

    Route::get('/stuffing-{id}', [
        'as' => 'exp-stuffing',
        'uses' => 'StufingController@Stuffing'
    ]);

    Route::post('/stuffing-prosses', [
        'as' => 'stuffing-prosses',
        'uses' => 'StufingController@StuffingProses'
    ]);
    Route::post('/stuffing/cancel', [
        'as' => 'stuffing-cancel',
        'uses' => 'StufingController@cancel'
    ]);

    Route::post('/stuffing/upload-TPS', [
        'as' => 'upload-TPS-Stuffing',
        'uses' => 'StufingController@TPS'
    ]);
});