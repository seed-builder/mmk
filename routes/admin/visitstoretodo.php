<?php
Route::get('visit-store-todo/pagination', ['uses' => 'VisitStoreTodoController@pagination']);
Route::resource('visit-store-todo', 'VisitStoreTodoController');