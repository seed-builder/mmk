<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016-11-16
 * Time: 15:07
 */

namespace App\Services;


class KingdeeSyncData extends SyncData
{
    protected $loginUrl = 'http://117.28.234.39:81/k3cloud/Kingdee.BOS.WebApi.ServicesStub.AuthService.ValidateUser.common.kdsvc';
    protected $dataUrl = 'http://117.28.234.39:81/k3cloud/CYD.ApiService.ServicesStub.CustomBusinessService.Syncdb.common.kdsvc';

    public function login(){
        $data = '{ "parameters": "[\"5826e02fe123a9\",\"Administrator\",\"888888\",2052]" }';
        return $this->post($this->loginUrl, $data);
    }

//    public function sendData($table, $op, $data){
//        $arr = ['parameters' => [$table, $op, json_encode($data)]];
//        //var_dump(json_encode($arr));
//        return $this->post($this->dataUrl, $arr);
//    }

    public function sendData($table, $op, $data){
        $header = ['Content-Type: application/json'];
        $login_data = '{ "parameters": "[\"5826e02fe123a9\",\"Administrator\",\"888888\",2052]" }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->loginUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $login_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_exec($ch); //登陆
        //发送数据
        curl_setopt($ch, CURLOPT_URL, $this->dataUrl);
        $content_data = ['parameters' => [$table, $op, json_encode($data)]];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content_data));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    public function sync($table, $op, $data){
        //$this->login();
        $result = $this->sendData($table, $op, $data);
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