<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        //
        return response('1231 user',200);
    }

    //
    public function login(){
        $data = [
            "id" => 0,
            "name" => "test",
            "email" => "test",
            "password" => "123456"
        ];
        return response($data, 200);
    }
}
