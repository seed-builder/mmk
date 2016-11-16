<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ModelMap;
use App\Services\KingdeeSyncData;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
//        $this->visit('http://laradock')
//             ->see('Laravel');
//        $map = new ModelMap;
//        $map->model = 'User';
//        $map->table = 'sys_user';
//        $re = $map->save();
        $sync = new KingdeeSyncData();
        //$re = $sync->login();
        $re = $sync->sync('T_BD_EmpInfo', '0', ['id'=>10,'name'=>'xx2']);
        var_dump($re);
        $this->assertTrue($re);
    }
}
