<?php
Route::get('work-flow-task/pagination', ['uses' => 'WorkFlowTaskController@pagination']);
Route::get('work-flow-task/todo-pagination', ['uses' => 'WorkFlowTaskController@todoPagination']);
Route::get('work-flow-task/done-pagination', ['uses' => 'WorkFlowTaskController@donePagination']);
Route::get('work-flow-task/suspend-pagination', ['uses' => 'WorkFlowTaskController@suspendPagination']);
Route::get('work-flow-task/todo', ['uses' => 'WorkFlowTaskController@todo']);
Route::get('work-flow-task/done', ['uses' => 'WorkFlowTaskController@done']);
Route::get('work-flow-task/suspend', ['uses' => 'WorkFlowTaskController@suspend']);
Route::post('work-flow-task/{id}/agree', ['as' => 'WorkFlowTask.agree', 'uses' => 'WorkFlowTaskController@agree']);
Route::post('work-flow-task/{id}/against', ['as' => 'WorkFlowTask.against', 'uses' => 'WorkFlowTaskController@against']);
Route::post('work-flow-task/transfer', ['as' => 'WorkFlowTask.transfer', 'uses' => 'WorkFlowTaskController@transfer']);
Route::post('work-flow-task/resume', ['as' => 'WorkFlowTask.resume', 'uses' => 'WorkFlowTaskController@resume']);
Route::resource('work-flow-task', 'WorkFlowTaskController');