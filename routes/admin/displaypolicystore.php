<?php
Route::get('display-policy-store/pagination', ['uses' => 'DisplayPolicyStoreController@pagination']);
Route::resource('display-policy-store', 'DisplayPolicyStoreController');