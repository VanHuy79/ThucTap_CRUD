<?php

namespace App\Helper\Redis;

use Illuminate\Support\Facades\Redis;
use App\Helper\Redis\RedisConnect;

class RedisHelper
{
    public static function getRedis($user_id)
    {
        $redis = RedisConnect::redisConnect('token');
        // dd($redis);
        $redisToken = $redis->get($user_id);
        // dd($redisToken);
        return $redisToken;
    }

    public static function setRedis($user_id, $token)
    {
        $redis = RedisConnect::redisConnect('user');

        $redisUser = $redis->set($user_id, $token);
        // dd($redisUser);
        return $redisUser;
    }
}
