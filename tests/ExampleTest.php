<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\ModelMap;

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
        $map = new ModelMap;
        $map->model = 'User';
        $map->table = 'sys_user';
        $re = $map->save();
        $this->assertTrue($re);
    }
}
