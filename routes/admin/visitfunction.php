<?php
Route::get('visit-function/pagination', ['uses' => 'VisitFunctionController@pagination']);
Route::resource('visit-function', 'VisitFunctionController');