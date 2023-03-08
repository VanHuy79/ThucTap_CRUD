<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Token;
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
        }catch (ExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã hết hạn'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy token'
            ], 401);
        }
        
        $user_id = $decoded->sub;
        // Lấy user_id từ Token
        $tokens = Token::where('user_id', $user_id)->get();
        // dd($tokens[0]->token);
        // dd($jwt);

        // Check số lượng token khác 1 khác cái số lượng
        if ($tokens[0]->token != $jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã được đăng nhập trên thiết bị khác'
            ], 401);
        }

        return $next($request);
    }
}
