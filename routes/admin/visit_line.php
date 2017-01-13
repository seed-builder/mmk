<?php

Route::get('visit_line/pagination', ['uses' => 'VisitLineController@pagination']);
Route::get('visit_line/index', ['uses' => 'VisitLineController@index']);
Route::resource('visit_line', 'VisitLineController');