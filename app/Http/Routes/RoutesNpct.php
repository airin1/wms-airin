<?php

Route::group(['prefix' => 'npct', 'namespace' => 'Tps'], function(){
    
    Route::get('/yor', [
        'as' => 'yor-index',
        'uses' => 'NpctController@yorIndex'
    ]);
    Route::post('/yor/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\NpctTablesRepository(new App\Models\NpctYor(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/yor/create-report',[
        'as' => 'yor-create-report',
        'uses' => 'NpctController@yorCreateReport'
    ]);
    Route::get('/yor/upload/{id}',[
        'as' => 'yor-upload',
        'uses' => 'NpctController@yorUpload'
    ]);
    
    Route::get('/movement', [
        'as' => 'movement-index',
        'uses' => 'NpctController@MovementIndex'
    ]);
    Route::post('/movement/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\NpctTablesRepository(new App\Models\NpctMovement(),Illuminate\Support\Facades\Request::all()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/movement/upload',[
        'as' => 'movement-upload',
        'uses' => 'NpctController@movementUpload'
    ]);
    Route::get('/movement/container', [
        'as' => 'movement-container-index',
        'uses' => 'NpctController@MovementContainerIndex'
    ]);
    Route::post('/movement/container/create', [
        'as' => 'movement-container-create',
        'uses' => 'NpctController@MovementContainerCreate'
    ]);

});