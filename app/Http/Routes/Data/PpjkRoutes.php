<?php

Route::group(['prefix' => 'ppjk', 'namespace' => 'Data'], function(){
    
    Route::get('/', [
        'as' => 'ppjk-index',
        'uses' => 'PpjkController@index'
    ]);
    Route::get('/grid-data', function()
    {
        GridEncoder::encodeRequestedData(new \App\Models\TablesRepository(new App\Models\Ppjk()) ,Illuminate\Support\Facades\Request::all());
    });
    Route::post('/crud', function()
    {
        $Eloquent = new \App\Models\Eloquent\EloquentPpjk();

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
        'as' => 'ppjk-view',
        'uses' => 'PpjkController@show'
    ]);
    Route::get('/create', [
        'as' => 'ppjk-create',
        'uses' => 'PpjkController@create'
    ]);
    Route::get('/edit/{id}', [
        'as' => 'ppjk-edit',
        'uses' => 'PpjkController@edit'
    ]);
    Route::get('/delete/{id}', [
        'as' => 'ppjk-delete',
        'uses' => 'PpjkController@destroy'
    ]);
    Route::post('/store', [
        'as' => 'ppjk-store',
        'uses' => 'PpjkController@store'
    ]);
    Route::post('/update/{id}', [
        'as' => 'ppjk-update',
        'uses' => 'PpjkController@update'
    ]); 
});