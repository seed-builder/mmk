<?php
Route::get('visit-line-store/pagination', ['uses' => 'VisitLineStoreController@pagination']);
Route::resource('visit-line-store', 'VisitLineStoreController');