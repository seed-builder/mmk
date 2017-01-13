<?php

Route::get('visit_store_calendar/pagination', ['uses' => 'VisitStoreCalendarController@pagination']);
Route::get('visit_store_calendar/index', ['uses' => 'VisitStoreCalendarController@index']);
Route::resource('visit_store_calendar', 'VisitStoreCalendarController');