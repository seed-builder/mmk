<?php
Route::get('visit-todo-group/pagination', ['uses' => 'VisitTodoGroupController@pagination']);
Route::get('visit-todo-group/todoGroupTree', ['uses' => 'VisitTodoGroupController@todoGroupTree']);
Route::get('visit-todo-group/config', ['uses' => 'VisitTodoGroupController@config']);
Route::get('visit-todo-group/todoGroupTree', ['uses' => 'VisitTodoGroupController@todoGroupTree']);
Route::get('visit-todo-group/addTodo', ['uses' => 'VisitTodoGroupController@addTodo']);
Route::get('visit-todo-group/removeTodo', ['uses' => 'VisitTodoGroupController@removeTodo']);
Route::get('visit-todo-group/makeTodoByGroup', ['uses' => 'VisitTodoGroupController@makeTodoByGroup']);
Route::resource('visit-todo-group', 'VisitTodoGroupController');