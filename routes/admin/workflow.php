<?php
Route::get('work-flow/pagination', ['uses' => 'WorkFlowController@pagination']);
Route::resource('work-flow', 'WorkFlowController');