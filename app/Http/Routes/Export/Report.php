<?php
Route::group(['prefix' => 'export', 'namespace' => 'Export'], function(){

    Route::get('/report/container', [
        'as' => 'exp-report-cont',
        'uses' => 'ReportController@contIndex'
    ]);

    Route::get('/report/containerData', [
        'as' => 'exp-report-contData',
        'uses' => 'ReportController@contData'
    ]);

    Route::get('/report/container/masuk', [
        'as' => 'exp-report-contMasuk',
        'uses' => 'ReportController@exportMasuk'
    ]);

    Route::get('/report/container/keluar', [
        'as' => 'exp-report-contkeluar',
        'uses' => 'ReportController@exportKeluar'
    ]);

    Route::get('/report/manifest', [
        'as' => 'exp-report-mani',
        'uses' => 'ReportController@maniIndex'
    ]);

    Route::get('/report/manifestData', [
        'as' => 'exp-report-manifestData',
        'uses' => 'ReportController@manifestData'
    ]);

    Route::get('/report/manifest/belumStuffing', [
        'as' => 'exp-report-laporan-belumStuffing',
        'uses' => 'ReportController@NotStuffing'
    ]);

    Route::get('/report/manifest/stuffing', [
        'as' => 'exp-report-laporan-Stuffing',
        'uses' => 'ReportController@LaporanStuffing'
    ]);

});