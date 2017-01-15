<?php
Route::get('app-upgrade/pagination', ['uses' => 'AppUpgradeController@pagination']);
Route::resource('app-upgrade', 'AppUpgradeController');