<?php
namespace App\Services;
/**
 * Created by PhpStorm.
 * User: john
 * Date: 2016/8/26
 * Time: 15:38
 */
use Monolog\Registry;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\MongoDBHandler;

class LogSvr {

    public static function init($name) {
        if(!Registry::hasLogger($name)) {
            $fileHandler = new RotatingFileHandler(app()->storagePath() . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . $name . '.log', 30);
            $logger = new Logger($name, [$fileHandler]);
            Registry::addLogger($logger, $name, false);
        }
    }

    public static function test(){
        return 'test';
    }

    public static function __callStatic($name, $arguments){
        self::init($name);
        return Registry::getInstance($name);
    }

}