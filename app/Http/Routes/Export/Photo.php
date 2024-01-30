<?php

Route::group(['prefix' => 'export', 'namespace' => 'Export'], function(){

    Route::get('/photo/container', [
        'as' => 'exp-container-photo',
        'uses' => 'PhotoController@IndexContainer'
    ]);

    Route::get('/photo/manfest', [
        'as' => 'exp-manifest-photo',
        'uses' => 'PhotoController@IndexManifest'
    ]);

    Route::get('/photo/container/{id}', [
        'as' => 'exp-container-photo-id',
        'uses' => 'PhotoController@getContainer'
    ]);

    Route::post('/photo/container/upload', [
        'as' => 'exp-container-photo-upload',
        'uses' => 'PhotoController@PhotoContainer'
    ]);

    Route::get('/photo/manifest/{id}', [
        'as' => 'exp-manifest-photo-id',
        'uses' => 'PhotoController@getManifest'
    ]);

    Route::post('/photo/manifest/upload', [
        'as' => 'exp-manifest-photo-upload',
        'uses' => 'PhotoController@PhotoManifest'
    ]);

    Route::get('/photo/print/{id}', [
        'as' => 'cetak-photo-export',
        'uses' => 'PhotoController@printPhoto'
    ]);

    Route::get('/photo/upload-cont/{id}', [
        'as' => 'exp-uploadPhoto-cont',
        'uses' => 'PhotoController@PhotoCont'
    ]);

    Route::get('/photo/upload-manifest/{id}', [
        'as' => 'exp-uploadPhoto-manifest',
        'uses' => 'PhotoController@PhotoManifestView'
    ]);

    Route::post('/photo/delete', [
        'as' => 'exp-dedetePhoto',
        'uses' => 'PhotoController@destroy'
    ]);
});
