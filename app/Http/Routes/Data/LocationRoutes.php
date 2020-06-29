<?php

Route::group(['prefix' => 'location', 'namespace' => 'Data'], function(){
    
    Route::get('/', [
        'as' => 'location-index',
        'uses' => 'LocationController@index'
    ]);
    Route::get('/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\Location()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/crud', function()
    {
        $Eloquent = new \App\Models\Eloquent\EloquentLocation();

        switch (Illuminate\Support\Facades\Request::get('oper'))
        {
          case 'add':
            return $Eloquent->create(Illuminate\Support\Facades\Request::except('id', 'oper'));
            break;
          case 'edit':
            return $Eloquent->update(Illuminate\Support\Facades\Request::get('id'), Illuminate\Support\Facades\Request::except('id', 'oper'));
            break;
          case 'del':
            return  $Eloquent->delete(Illuminate\Support\Facades\Request::get('id'));
            break;
        }
    });
    Route::get('/view/{id}', [
        'as' => 'location-view',
        'uses' => 'LocationController@show'
    ]);
    Route::get('/create', [
        'as' => 'location-create',
        'uses' => 'LocationController@create'
    ]);
    Route::get('/edit/{id}', [
        'as' => 'location-edit',
        'uses' => 'LocationController@edit'
    ]);
    Route::get('/delete/{id}', [
        'as' => 'location-delete',
        'uses' => 'LocationController@destroy'
    ]);
    Route::post('/store', [
        'as' => 'location-store',
        'uses' => 'LocationController@store'
    ]);
    Route::post('/update/{id}', [
        'as' => 'location-update',
        'uses' => 'LocationController@update'
    ]); 
});