<?php
Route::get('view-visit-kpi/pagination', ['uses' => 'ViewVisitKpiController@pagination']);
Route::resource('view-visit-kpi', 'ViewVisitKpiController');