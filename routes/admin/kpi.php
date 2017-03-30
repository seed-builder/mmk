<?php
Route::get('kpi/pagination', ['uses' => 'KpiController@pagination']);
Route::resource('kpi', 'KpiController');