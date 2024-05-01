<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeImmutable;
use UnexpectedValueException;
use Firebase\JWT\ExpiredException;
use App\Controllers\Exceptions\Http401Exception;

class JWTUtil
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
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array) $decoded;
        } catch (ExpiredException | UnexpectedValueException $e) {
            throw new Http401Exception("Invalid JWT.");
        }
    }
}
