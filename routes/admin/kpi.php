<?php
Route::get('kpi/pagination', ['uses' => 'KpiController@pagination']);
Route::post('kpi/store', ['uses' => 'KpiController@store']);
Route::resource('kpi', 'KpiController');