<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Helpers\PublicHelper;
use Illuminate\Http\Response;
use Firebase\JWT\ExpiredException;
use Illuminate\Auth\AuthenticationException;

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
        $publicHelper = new PublicHelper();
        $jwt = $request->header('Authorization');

        if (!$jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $jwt = str_replace('Bearer ', '', $jwt);
        try {
            $decoded = $publicHelper->decodeJWT($jwt);
            // dd($decoded);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy token'
            ], 401);
        }
        // if ($decoded->exp <= now()) {
        //     return response()->json([
        //         'message' => 'Token này đã quá hạn',
        //     ], 401);
        // }

        $user = User::find($decoded->sub);

        if ($user->device != md5($_SERVER['HTTP_USER_AGENT'])) {
            return response()->json([
                'message' => 'Token này đã có trên thiết bị khác'
            ], 401);
        }
        return $next($request);

        // dd($user);


    }
}
