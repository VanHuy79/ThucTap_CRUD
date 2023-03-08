<?php

namespace App\Helper\Redis;

use Illuminate\Support\Facades\Redis;

class RedisConnect
{
    public static function redisConnect($cache)
    {
        $redis = Redis::connection($cache);
        return $redis;
    }
}
