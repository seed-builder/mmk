<?php

Route::post('/upload-image', ['uses' => 'UtlController@uploadImage']);
Route::get('/show-image', ['uses' => 'UtlController@showImage']);
Route::post('/sync-db', ['uses' => 'UtlController@syncDB']);
Route::post('/upload-file', ['uses' => 'UtlController@uploadFile']);
Route::get('/download-file', ['uses' => 'UtlController@downloadFile']);
Route::post('/fake-delete', function (){
    return response()->json([
        'data' => []
    ]);
});
Route::post('/send-data', ['uses' => 'UtlController@sendData']);
