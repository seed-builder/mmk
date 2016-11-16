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

    public function sendData($table, $op, $data){
        $arr = ['parameters' => [$table, $op, json_encode($data)]];
        return $this->post($this->dataUrl, $arr);
    }

    public function sync($table, $op, $data){
        $this->login();
        $result = $this->sendData($table, $op, $data);
        return json_decode($result, true);
    }

    public static function add($table, $data){
        $sync = new KingdeeSyncData();
        return $sync->sync($table, 0, $data);
    }

    public static function update($table, $data){
        $sync = new KingdeeSyncData();
        return $sync->sync($table, 1, $data);
    }

    public static function delete($table, $data){
        $sync = new KingdeeSyncData();
        return $sync->sync($table, 2, $data);
    }

}