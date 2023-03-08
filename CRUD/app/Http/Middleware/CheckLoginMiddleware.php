<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Token;
use Illuminate\Http\Request;
use App\Helpers\PublicHelper;
use Firebase\JWT\ExpiredException;

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
        }catch (ExpiredException $ex) {
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
        // Check token đầu tiên # với token truyền vào qua header thì hiện thị thông báo
        if ($tokens[0]->token != $jwt) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã được đăng nhập trên thiết bị khác'
            ], 401);
        }

        return $next($request);
    }
}
