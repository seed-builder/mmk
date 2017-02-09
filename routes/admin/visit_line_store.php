<?php

Route::get('visit_line_store/pagination', ['uses' => 'VisitLineStoreController@pagination']);
Route::get('visit_line_store/destroy/{id}', ['uses' => 'VisitLineStoreController@destroy']);
Route::post('visit_line_store/destroyAll', ['uses' => 'VisitLineStoreController@destroyAll']);
Route::get('visit_line_store/index', ['uses' => 'VisitLineStoreController@index']);
Route::post('visit_line_store/storeLineIml', ['uses' => 'VisitLineStoreController@storeLineIml']);
Route::get('visit_line_store/makeEmpAllLine', ['uses' => 'VisitLineStoreController@makeEmpAllLine']);
Route::resource('visit_line_store', 'VisitLineStoreController');