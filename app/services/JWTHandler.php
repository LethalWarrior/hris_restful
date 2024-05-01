<?php

namespace App\Services;

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    protected $secretKey;
    protected $issuer;
    protected $expiredAt;

    public function __construct(array $descriptor)
    {
        $this->secretKey = $descriptor["secretKey"];
        $this->issuer = $descriptor["issuer"];
        $this->expiredAt = $descriptor["expiredAt"];
    }

    public function issueToken(int $userId, string $role)
    {
        $now = new DateTimeImmutable();
        $payload = [
            "iss" => $this->issuer,
            "aud" => $this->issuer,
            "iat" => $now->getTimestamp(),
            "exp" => $now->modify("+" . $this->expiredAt . " minutes")->getTimestamp(),
            "id" => $userId,
            "role" => $role,
        ];
        $token = JWT::encode($payload, $this->secretKey, 'HS256');
        return $token;
    }

    public function decodeToken(string $token)
    {
        $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
        return (array) $decoded;
    }
}
