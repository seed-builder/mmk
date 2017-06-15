<?php
Route::get('fin-statement/pagination', ['uses' => 'FinStatementController@pagination']);
Route::get('fin-statement/get-cust-amount', ['uses' => 'FinStatementController@getCustAmount']);
Route::resource('fin-statement', 'FinStatementController');