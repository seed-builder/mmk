<?php
Route::get('fin-statement/pagination', ['uses' => 'FinStatementController@pagination']);
Route::resource('fin-statement', 'FinStatementController');