<?php
Route::get('price-group/pagination', ['uses' => 'PriceGroupController@pagination']);
Route::get('price-group/{id}/store-pagination', ['uses' => 'PriceGroupController@storePagination']);
Route::get('price-group/{id}/customer-pagination', ['uses' => 'PriceGroupController@customerPagination']);
Route::get('price-group/check', ['uses' => 'PriceGroupController@check']);
Route::get('price-group/uncheck', ['uses' => 'PriceGroupController@uncheck']);
Route::resource('price-group', 'PriceGroupController');