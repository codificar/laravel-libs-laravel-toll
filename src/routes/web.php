<?php

Route::group(array('namespace' => 'Codificar\Toll\Http\Controllers'), function() {

    Route::get('/admin/toll/list', 'TollController@tollList');
    Route::post('/api/lib/toll/import', 'TollController@importTolls');
    Route::post('/api/lib/toll/fetch', 'TollController@fetchTolls');
    Route::post('/api/lib/toll/delete/{id}', 'TollController@delete');

    Route::get('/admin/toll_category/list', array('as' => 'TollCategoryList', 'uses' => 'TollCategoryController@list'));
    Route::post('/api/lib/toll_category/fetch', array('as' => 'TollCategoryFetch', 'uses'=>'TollCategoryController@fetch'));
    Route::resource('/api/lib/toll_categories', 'TollCategoryController');
});

/**
 * Rota para permitir utilizar arquivos de traducao do laravel (dessa lib) no vue js
 */
Route::get('/toll/lang.trans/{file}', function () {
    $fileNames = explode(',', Request::segment(3));
    $lang = config('app.locale');
    $files = array();
    foreach ($fileNames as $fileName) {
        array_push($files, __DIR__.'/../resources/lang/' . $lang . '/' . $fileName . '.php');
    }
    $strings = [];
    foreach ($files as $file) {
        $name = basename($file, '.php');
        $strings[$name] = require $file;
    }

    header('Content-Type: text/javascript');
    return ('window.lang = ' . json_encode($strings) . ';');
    exit();
})->name('assets.lang');