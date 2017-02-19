<?php
Route::get('display-policy/pagination', ['uses' => 'DisplayPolicyController@pagination']);
Route::get('display-policy/index', ['uses' => 'DisplayPolicyController@index']);
Route::resource('display-policy', 'DisplayPolicyController');