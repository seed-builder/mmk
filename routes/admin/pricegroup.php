<?php
Route::get('price-group/pagination', ['uses' => 'PriceGroupController@pagination']);
Route::get('price-group/{id}/store-pagination', ['uses' => 'PriceGroupController@storePagination']);
Route::get('price-group/{id}/customer-pagination', ['uses' => 'PriceGroupController@customerPagination']);
Route::get('price-group/{id}/choose-store', ['uses' => 'PriceGroupController@chooseStore']);
Route::post('price-group/{id}/attach-store', ['uses' => 'PriceGroupController@attachStore']);
Route::post('price-group/{id}/detach-store', ['uses' => 'PriceGroupController@detachStore']);
Route::get('price-group/{id}/choose-customer', ['uses' => 'PriceGroupController@chooseCustomer']);
Route::post('price-group/{id}/attach-customer', ['uses' => 'PriceGroupController@attachCustomer']);
Route::post('price-group/{id}/detach-customer', ['uses' => 'PriceGroupController@detachCustomer']);
Route::get('price-group/check', ['uses' => 'PriceGroupController@check']);
Route::get('price-group/uncheck', ['uses' => 'PriceGroupController@uncheck']);
Route::resource('price-group', 'PriceGroupController');