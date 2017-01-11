<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2017-01-11
 * Time: 13:35
 */

Route::match(['get', 'post'], 'user/login', ['uses' => 'UserController@login']);
Route::resource('user', 'UserController');