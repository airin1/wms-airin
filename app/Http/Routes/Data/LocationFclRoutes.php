<?php

Route::group(['prefix' => 'locationfcl', 'namespace' => 'Data'], function(){
    
    Route::get('/', [
        'as' => 'locationfcl-index',
        'uses' => 'LocationFclController@index'
    ]);
    Route::get('/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\LocationFcl()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/crud', function()
    {
        $Eloquent = new \App\Models\Eloquent\EloquentLocationFcl();

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
        'as' => 'locationfcl-view',
        'uses' => 'LocationFclController@show'
    ]);
    Route::get('/create', [
        'as' => 'locationfcl-create',
        'uses' => 'LocationFclController@create'
    ]);
    Route::get('/edit/{id}', [
        'as' => 'locationfcl-edit',
        'uses' => 'LocationFclController@edit'
    ]);
    Route::get('/delete/{id}', [
        'as' => 'locationfcl-delete',
        'uses' => 'LocationFclController@destroy'
    ]);
    Route::post('/store', [
        'as' => 'locationfcl-store',
        'uses' => 'LocationFclController@store'
    ]);
    Route::post('/update/{id}', [
        'as' => 'locationfcl-update',
        'uses' => 'LocationFclController@update'
    ]); 
});