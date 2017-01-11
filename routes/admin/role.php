<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-11
 * Time: 13:35
 */

Route::get('role/pagination', ['uses' => 'RoleController@pagination']);
Route::resource('role', 'RoleController');