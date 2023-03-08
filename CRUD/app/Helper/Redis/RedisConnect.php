<?php

namespace App\Helper\Redis;

use Illuminate\Support\Facades\Redis;

class RedisConnect
{
    public static function redisConnect()
    {
        return Redis::connection();
    }
}
