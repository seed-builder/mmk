<?php
Route::get('work-flow-instance/pagination', ['uses' => 'WorkFlowInstanceController@pagination']);
Route::get('work-flow-instance/my-pagination', ['uses' => 'WorkFlowInstanceController@myPagination']);
Route::get('work-flow-instance/my', ['uses' => 'WorkFlowInstanceController@my']);
Route::post('work-flow-instance/dismiss/{id}', ['uses' => 'WorkFlowInstanceController@dismiss']);
Route::resource('work-flow-instance', 'WorkFlowInstanceController');