<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Helpers\PublicHelper;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Redis;
use App\Helper\Redis\RedisHelper;

class CheckLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $redis = Redis::connection();
        $publicHelper = new PublicHelper();
        $jwt = $request->header('Authorization');

        if (!$jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 400);
        }

        $jwt = str_replace('Bearer ', '', $jwt);
        try {
            $decoded = $publicHelper->decodeJWT($jwt);
        } catch (ExpiredException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã hết hạn'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy token'
            ], 400);
        }

        $user_id = $decoded->sub;

        // $redis = Redis::connection();
        // Lấy token ra
        $redisToken = RedisHelper::getRedis($user_id);
        // dd($redisToken);

        if ($redisToken != $jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã được đăng nhập trên thiết bị khác'
            ], 401);
        }
        return $next($request);
    }
}
