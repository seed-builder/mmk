<?php
Route::get('view-customer-stock-statistic/pagination', ['uses' => 'ViewCustomerStockStatisticController@pagination']);
Route::resource('view-customer-stock-statistic', 'ViewCustomerStockStatisticController');