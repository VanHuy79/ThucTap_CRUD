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
        } catch (ExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token này đã hết hạn',
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 401);
        }

        return (array)$decoded;
    }
    public static function encodeJWT($data)
    {
        $secretKey = config('jwt.key');
        $tokenId    = base64_encode(random_bytes(16));
        $payload = [
            'access_token' => [
                $data,
            ],
            'jti'  => $tokenId,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24 + 3000),
            'token_type' => 'bearer',
        ];
        // dd($payload);

        $token = JWT::encode($payload, $secretKey, 'HS256');
        return $token;
    }
}
