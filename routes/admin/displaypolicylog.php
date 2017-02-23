<?php
Route::get('display-policy-log/pagination', ['uses' => 'DisplayPolicyLogController@pagination']);
Route::resource('display-policy-log', 'DisplayPolicyLogController');