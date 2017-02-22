<?php
Route::get('leave/pagination', ['uses' => 'LeaveController@pagination']);
Route::resource('leave', 'LeaveController');