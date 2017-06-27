<?php
Route::get('work-flow/pagination', ['uses' => 'WorkFlowController@pagination']);
Route::post('work-flow/set-default-approver/{id}', ['uses' => 'WorkFlowController@setDefaultApprover']);
Route::resource('work-flow', 'WorkFlowController');