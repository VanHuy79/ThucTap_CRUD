<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Carbon\Carbon;
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
        $jwt = $request->input('token');

        if (!$jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        try {
            $decoded = $publicHelper->decodeJWT($jwt);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy token'
            ], 401);
        }

        // Pass user ID to controller
        $request->attributes->add(['user_id' => $decoded->sub]);
        return $next($request);
    }
}
