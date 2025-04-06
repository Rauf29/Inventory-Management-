<?php
namespace App\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {
    public static function CreateToken( $UserEmail, $UserId ) {
        $key = env( 'JWT_KEY' );
        $payload = [
            'iss'       => 'Laravel-Token',
            'iat'       => time(),
            'exp'       => time() + 60 * 60 * 24,
            'userEmail' => $UserEmail,
            'userId'    => $UserId,
        ];
        return JWT::encode( $payload, $key, 'HS256' );
    }

    public static function VerifyToken( $token ) {
        try {
            if ( $token == null ) {
                return 'unauthorized';
            } else {
                $key = env( 'JWT_KEY' );
                $decoded = JWT::decode( $token, new Key( $key, 'HS256' ) );
                return $decoded;
            }
        } catch ( \Exception $e ) {
            return 'unauthorized';
        }
    }

    public static function CreateTokenForSetPassword( $UserEmail ) {
        $key = env( 'JWT_KEY' );
        $payload = [
            'iss'       => 'Laravel-Token',
            'iat'       => time(),
            'exp'       => time() + 60 * 60 * 24,
            'userEmail' => $UserEmail,
            'userId'    => 0,
        ];
        return JWT::encode( $payload, $key, 'HS256' );
    }
}
