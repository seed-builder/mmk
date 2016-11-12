<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee;
use Hash;

class EmployeeController extends Controller
{
    //
    public function login(Request $request){
        $this->validate($request, [
            'phone' => 'required',
            'pwd' => 'required'
        ]);
        $emp = Employee::where('fphone', $request->input('phone'))->first();
        $pwd = $request->input('pwd');
        if(Hash::check($pwd, $emp->password)){
            return response($emp, 200);
        }else{
            return response('wrong!', 401);
        }
    }
}
