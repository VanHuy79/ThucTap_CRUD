<?php

namespace App\Helper\Redis;

use Illuminate\Support\Facades\Redis;
use App\Helper\Redis\RedisConnect;
class RedisHelper
{
    public static function getRedis($user_id)
    {
        $redis = RedisConnect::redisConnect();

        $redisToken = $redis->get($user_id);

        return $redisToken;
    }

    public static function setRedis($user_id, $token)
    {
        $redis = RedisConnect::redisConnect();

        $redisUser = $redis->set($user_id, $token);

        return $redisUser;
    }
}
