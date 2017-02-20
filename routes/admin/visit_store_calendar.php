<?php

Route::get('visit_store_calendar/pagination', ['uses' => 'VisitStoreCalendarController@pagination']);
Route::get('visit_store_calendar/index', ['uses' => 'VisitStoreCalendarController@index']);
Route::get('visit_store_calendar/visitStoreCalendarInfo/{id}', ['uses' => 'VisitStoreCalendarController@visitStoreCalendarInfo']);
Route::resource('visit_store_calendar', 'VisitStoreCalendarController');