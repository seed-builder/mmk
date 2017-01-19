<?php

Route::get('visit_line_store/pagination', ['uses' => 'VisitLineStoreController@pagination']);
Route::get('visit_line_store/index', ['uses' => 'VisitLineStoreController@index']);
Route::resource('visit_line_store', 'VisitLineStoreController');