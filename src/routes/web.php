<?php

Route::group(array('namespace' => 'Codificar\Toll\Http\Controllers'), function() {

    Route::post('/api/lib/toll/import', 'TollController@importTolls');
});