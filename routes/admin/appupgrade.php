<?php
Route::get('app-upgrade/pagination', ['uses' => 'AppUpgradeController@pagination']);
Route::post('app-upgrade/upload', ['uses' => 'AppUpgradeController@upload']);
Route::resource('app-upgrade', 'AppUpgradeController');