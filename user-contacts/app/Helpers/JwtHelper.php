<?php
namespace App\Helpers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtHelper {

    public static function makeToken(User $user): string 
    {
        return JWTAuth::fromUser($user);
    }

    public static function decodeToken(): array
    {
        $token = JWTAuth::getToken();
        return JWTAuth::getPayload($token)->toArray();
    }

    public static function getUserId(): string
    {
        $token = JWTAuth::getToken();
        return JWTAuth::getPayload($token)->toArray()['sub'];
    }
}