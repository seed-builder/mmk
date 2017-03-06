<?php
Route::get('display-policy-store/pagination', ['uses' => 'DisplayPolicyStoreController@pagination']);
Route::get('display-policy-store/check', ['uses' => 'DisplayPolicyStoreController@check']);
Route::get('display-policy-store/uncheck', ['uses' => 'DisplayPolicyStoreController@unCheck']);
Route::resource('display-policy-store', 'DisplayPolicyStoreController');