<?php
Route::get('visit-store-todo/pagination', ['uses' => 'VisitStoreTodoController@pagination']);
Route::get('visit-store-todo/todoTree', ['uses' => 'VisitStoreTodoController@todoTree']);
Route::post('visit-store-todo/save', ['uses' => 'VisitStoreTodoController@save']);
Route::get('visit-store-todo/delete/{id}', ['uses' => 'VisitStoreTodoController@delete']);
Route::resource('visit-store-todo', 'VisitStoreTodoController');