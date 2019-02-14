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

});