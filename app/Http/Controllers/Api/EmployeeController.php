<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Busi\Employee as Entity;
use Hash;
use App\Http\Requests\StoreEmployeeRequest;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $page = $request->input('page', 1);
        $pageSize = $request->input('pageSize', 10);
        $sort = $request->input('sort', 'id asc');
        $count = Entity::count();
        $data = Entity::orderBy($sort)->take($page)->skip(($page-1)*$pageSize)->get();
        return response(['count' => $count, 'list' => $data, 'page' => $page, 'pageSize' => $pageSize], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        //
        $data = $request->all();
        unset($data['_sign']);
        $entity = Entity::create($data);
        $re = $entity->save();
        $status = $re ? 200 : 400;
        return response(['success' => $re], $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
