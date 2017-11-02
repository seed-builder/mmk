<?php

namespace App\Http\Middleware;

use App\Services\LogSvr;
use Closure;

/**
 * api接口的签名验证
 * Class VerifyApiSign
 * @package App\Http\Middleware
 */
class VerifyApiSign
{
	protected $except = [
		//
		'/api/fin-statement/customer/*',
		'/api/fin-statement/pagination',
		'/api/utl/customer-dd-return/*'
	];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	if($this->inExceptArray($request)){
		    return $next($request);
	    }
	    $p = $request->decodedPath();
        $data = $request->except(['nsukey']);
        if(empty($data['_sign'])){
            return response('Fail: the sign is empty! path=' . $p , 401);
        }
        $_sign = $data['_sign'];
        $sign = api_sign($data, $request);// md5($str);
        if($_sign == $sign) {
            LogSvr::api()->info("path = {$p}, parameters: " . json_encode($data));
            return $next($request);
        }else{
            return response('Fail: the sign is wrong!  the correct sign is: '.$sign, 401);
        }

    }

	/**
	 * Determine if the request has a URI that should pass through CSRF verification.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	protected function inExceptArray($request)
	{
		foreach ($this->except as $except) {
			if ($except !== '/') {
				$except = trim($except, '/');
			}

			if ($request->is($except)) {
				return true;
			}
		}
		return false;
	}

}
