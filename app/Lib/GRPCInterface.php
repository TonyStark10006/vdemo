<?php
namespace App\Lib;


interface GRPCInterface
{
    public function reconnect(string $className, string $serverName);

    public function disconnect() : void ;

    public static function init();//string ...$name(string $className, string $serverName);

    public static function start() : void ;

    public static function stop() : void ;

}
