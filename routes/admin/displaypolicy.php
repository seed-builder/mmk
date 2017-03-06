<?php
Route::get('display-policy/pagination', ['uses' => 'DisplayPolicyController@pagination']);
Route::get('display-policy/check', ['uses' => 'DisplayPolicyController@check']);
Route::get('display-policy/uncheck', ['uses' => 'DisplayPolicyController@unCheck']);
Route::resource('display-policy', 'DisplayPolicyController');