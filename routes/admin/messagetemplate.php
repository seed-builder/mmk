<?php
Route::get('message-template/pagination', ['uses' => 'MessageTemplateController@pagination']);
Route::resource('message-template', 'MessageTemplateController');