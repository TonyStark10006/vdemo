<?php

namespace App\Lib;


abstract class V2RayGRPCAbstract implements GRPCInterface
{

    protected static $connection;
    /**
     * @var
     */
    protected static $instance;

    /**
     * @param string $className
     * @param string $serverName
     * @return object
     * 手动新建gRPC客户端
     */
    public function reconnect(string $className, string $serverName)
    {
        return new $className(env($serverName), []);
    }

    /**
     *  手动关闭gRPC连接
     */
    public function disconnect(): void
    {
        static::$connection->close();
        static::$connection = null;
    }

    /**
     * @param $className
     * @param string $serverName
     * @return mixed
     */
//    public static function init(string $className, string $serverName)
//    {
//        if (!static::$connection) {
//            static::$connection = new $className(env($serverName), []);
//            return static::$instance = new static();
//        } else {
//            return static::$instance;
//        }
//    }

    /**
     *  启动v2ray gRPC客户端
     */
    public static function start() : void
    {
        static::$connection->isRunning() ?: static::$connection->start();
    }

    /**
     *  停止v2ray gRPC客户端
     */
    public static function stop() : void
    {
        if (static::$connection->isRunning()) static::$connection->stop();
    }
}
