<?php
Route::get('view-revisit/pagination', ['uses' => 'ViewRevisitController@pagination']);
Route::resource('view-revisit', 'ViewRevisitController');