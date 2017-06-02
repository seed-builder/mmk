<?php

namespace App\Http\Controllers\Customer;

use App\Models\Busi\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/customer';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest', ['except' => 'logout']);
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm()
	{
		return view('customer.login.show');
	}

	public function username()
	{
		return 'name';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return redirect('/customer/login');
	}

	protected function validateLogin(Request $request)
	{
		$this->validate($request, [
			$this->username() => 'required', 'password' => 'required',
		]);
		$user = User::where('name', $request->input('name'))
			->where('reference_type', 'customer')
			->first();
		if(empty($user)){
			throw new ValidationException(null, redirect('/customer/login')->withErrors(['该用户非经销商, 禁止登陆']));
		}
		if($user->status == 0){
			throw new ValidationException(null, redirect('/customer/login')->withErrors(['该用户已经被禁用, 请联系管理员']));
		}
	}

	protected function attemptLogin(Request $request)
	{
		$data =  $this->credentials($request);
		$user = User::where('name', $data['name'])->where('password', md5($data['password']))->first();
		if(!empty($user)){
			$this->guard()->login($user, $request->has('remember'));
			return true;
		}else{
			return false;
		}
	}

}
