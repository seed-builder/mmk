<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-11
 * Time: 13:35
 */

Route::get('sys-dics/pagination', ['uses' => 'SysDicsController@pagination']);
Route::resource('sys-dics', 'SysDicsController');