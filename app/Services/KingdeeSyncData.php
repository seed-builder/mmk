<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-11-16
 * Time: 15:07
 */

namespace App\Services;
use  GuzzleHttp\Client;

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
        $data = env('KINGDEE_HOST_LOGIN_DATA');
        return $this->post($this->loginUrl, $data, 1, $cookie_jar);
    }

    public function sendData($table, $op, $data, $cookie_jar = null){
        $arr = ['parameters' => [$table, $op, json_encode($data)]];
        //var_dump(json_encode($arr));
        return $this->post($this->dataUrl, $arr, 0, $cookie_jar);
    }

    public function sync($table, $op, $data){
        $cookie_jar = tempnam('./tmp','CloudSession');
        $re = $this->login($cookie_jar);

        $result = $this->sendData($table, $op, $data, $cookie_jar);
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