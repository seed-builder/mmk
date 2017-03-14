<?php
Route::get('display-policy/pagination', ['uses' => 'DisplayPolicyController@pagination']);
Route::resource('display-policy', 'DisplayPolicyController');