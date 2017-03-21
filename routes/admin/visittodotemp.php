<?php
Route::get('visit-todo-temp/pagination', ['uses' => 'VisitTodoTempController@pagination']);
Route::resource('visit-todo-temp', 'VisitTodoTempController');