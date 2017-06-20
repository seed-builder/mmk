<?php
Route::get('fin-statement/pagination', ['uses' => 'FinStatementController@pagination']);
Route::get('fin-statement/get-cust-amount', ['uses' => 'FinStatementController@getCustAmount']);
Route::get('fin-statement/print', ['uses' => 'FinStatementController@print']);
Route::resource('fin-statement', 'FinStatementController');