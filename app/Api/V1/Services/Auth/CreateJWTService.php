<?php declare(strict_types=1);

namespace App\Api\V1\Services\Auth;

use Carbon\Carbon;

class CreateJWTService
{
    const SECRET_KEY = '20-s3cr3t_KeY-21';

    public function create(array $userData): string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode(['user_id' => $userData['id'], 'exp' => Carbon::now()->addMinutes(10)->unix()]);
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::SECRET_KEY, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    public function expired(string $token): bool
    {
        $split = explode('.', $token);
        $payload = base64_decode($split[1]);

        $expiryTime = Carbon::createFromTimestamp(json_decode($payload)->exp);

        return Carbon::now()->diffInSeconds($expiryTime, false) < 0;
    }

    public function valid(string $token): bool
    {
        $split = explode('.', $token);
        $header = base64_decode($split[0]);
        $payload = base64_decode($split[1]);
        $signature = $split[2];

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $comparisonSignature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, self::SECRET_KEY, true);
        $base64UrlSignature = $this->base64UrlEncode($comparisonSignature);

        return $signature === $base64UrlSignature && !$this->expired($token);
    }

    public function base64UrlEncode($text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}
