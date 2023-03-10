<?php

namespace App\Helpers;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class PublicHelper
{
    public static function decodeJWT($jwt)
    {
        $secretKey = config('jwt.key');
        try {
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
        return $decoded;
    }
    public static function encodeJWT($user)
    {
        $secretKey = config('jwt.key');
        $tokenId    = base64_encode(random_bytes(16));
        $payload = [
            'sub' => $user->id, // id của user
            'jti'  => $tokenId,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24),
        ];
        // dd($payload);
        $token = JWT::encode($payload, $secretKey, 'HS256');
        return $token;
    }
}
