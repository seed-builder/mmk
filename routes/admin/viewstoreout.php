<?php
Route::get('view-store-out/pagination', ['uses' => 'ViewStoreOutController@pagination']);
Route::resource('view-store-out', 'ViewStoreOutController');