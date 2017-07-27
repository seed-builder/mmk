<?php
Route::get('visit-store-todo/pagination', ['uses' => 'VisitStoreTodoController@pagination']);
Route::get('visit-store-todo/todoTree/{fcategory?}', ['uses' => 'VisitStoreTodoController@todoTree']);
Route::post('visit-store-todo/save', ['uses' => 'VisitStoreTodoController@save']);
Route::get('visit-store-todo/delete/{id}', ['uses' => 'VisitStoreTodoController@delete']);
Route::get('visit-store-todo/revisit', ['uses' => 'VisitStoreTodoController@revisit']);
Route::resource('visit-store-todo', 'VisitStoreTodoController');