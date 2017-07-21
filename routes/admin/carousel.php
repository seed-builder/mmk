<?php
Route::get('carousel/pagination', ['uses' => 'CarouselController@pagination']);
Route::resource('carousel', 'CarouselController');