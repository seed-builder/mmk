<?php
Route::get('price-group/pagination', ['uses' => 'PriceGroupController@pagination']);
Route::resource('price-group', 'PriceGroupController');