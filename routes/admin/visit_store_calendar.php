<?php

Route::get('visit_store_calendar/pagination', ['uses' => 'VisitStoreCalendarController@pagination']);
Route::get('visit_store_calendar/index', ['uses' => 'VisitStoreCalendarController@index']);
Route::get('visit_store_calendar/all', ['uses' => 'VisitStoreCalendarController@all']);
Route::get('visit_store_calendar/revisit', ['uses' => 'VisitStoreCalendarController@revisit']);
Route::get('visit_store_calendar/pics/{id}', ['uses' => 'VisitStoreCalendarController@pics']);
Route::get('visit_store_calendar/visitStoreCalendarInfo/{id}', ['uses' => 'VisitStoreCalendarController@visitStoreCalendarInfo']);
Route::resource('visit_store_calendar', 'VisitStoreCalendarController');