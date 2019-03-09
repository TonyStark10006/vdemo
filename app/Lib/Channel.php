<?php
namespace App\Lib;

class Channel
{
    protected $pool;

    public function getPool()
    {
        return $this->pool;
    }

    public function connect($size = 1)
    {
        $this->pool = new \Swoole\Coroutine\Channel($size);
    }

    public function get()
    {
        return $this->pool->pop();
    }

    public function put($data) : void
    {
        $this->pool->push($data);
    }

    public function close(): void
    {
        $this->pool->close();
        $this->pool = null;
    }
}
