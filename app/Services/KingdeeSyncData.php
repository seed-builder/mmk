<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-11-16
 * Time: 15:07
 */

namespace App\Services;
use  GuzzleHttp\Client;
use App\Services\LogSvr;

class KingdeeSyncData extends SyncData
{
    protected $loginUrl = '/k3cloud/Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
    protected $dataUrl = '/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.Syncdb.common.kdsvc';


    public function __construct()
    {
        $this->loginUrl = env('KINGDEE_HOST') . $this->loginUrl;
        $this->dataUrl = env('KINGDEE_HOST') . $this->dataUrl;
    }

    public function login($cookie_jar = null){
        //{ "parameters": "[\"5826e02fe123a9\",\"Administrator\",\"888888\",2052]" }
        //5826e02fe123a9,Administrator,888888
        $str = env('KINGDEE_HOST_LOGIN_DATA');
        $arr = explode(',', $str);
        $arr[] = 2052;
        $loginData = ['parameters' => json_encode($arr)];
	    LogSvr::KingdeeSync()->info('login Url : ' . $this->dataUrl);
	    LogSvr::KingdeeSync()->info('login Data : ' . json_encode($loginData));
        return $this->post($this->loginUrl, json_encode($loginData), 1, $cookie_jar);
    }

    public function sendData($table, $op, $data, $cookie_jar = null){
        $arr = ['parameters' => [$table, $op, json_encode($data)]];
        //var_dump(json_encode($arr));
	    LogSvr::KingdeeSync()->info('data Url : ' . $this->dataUrl);
	    LogSvr::KingdeeSync()->info('data : ' . json_encode($arr));
        return $this->post($this->dataUrl, $arr, 0, $cookie_jar);
    }

    public function sync($table, $op, $data){
        $cookie_jar = tempnam('./tmp','CloudSession');
        $re = $this->login($cookie_jar);
	    LogSvr::KingdeeSync()->info('login result : ' . $re);
        $result = $this->sendData($table, $op, $data, $cookie_jar);
	    LogSvr::KingdeeSync()->info('$result  : ' . $result);
        return json_decode($result, true);
    }

    public static function add($table, $data){
        $sync = new static();
        return $sync->sync($table, 0, $data);
    }

    public static function update($table, $data){
        $sync = new static();
        return $sync->sync($table, 1, $data);
    }

    public static function delete($table, $data){
        $sync = new static();
        return $sync->sync($table, 2, $data);
    }

}