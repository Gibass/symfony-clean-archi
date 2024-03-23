<?php

namespace App\Tests\Common\Helper;

class TokenHelper
{
    public const JWT_SECRET = 'test-secret';

    public static function generateTestToken(
        array $payload,
        int $lifetime,
        string $secret = self::JWT_SECRET,
        \DateTimeImmutable $iat = null
    ): string {
        $header = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9';

        $payload['iat'] = ($iat ?? (new \DateTimeImmutable()))->getTimestamp();
        $payload['exp'] = $payload['iat'] + $lifetime;

        $encodedPayload = base64_encode(json_encode($payload));
        $encodedPayload = str_replace(['+', '/', '='], ['-', '_', ''], $encodedPayload);

        $key = base64_encode($secret);
        $signature = hash_hmac('sha256', $header . '.' . $encodedPayload, $key, true);

        $signatureEncoded = base64_encode($signature);
        $signatureEncoded = str_replace(['+', '/', '='], ['-', '_', ''], $signatureEncoded);

        return $header . '.' . $encodedPayload . '.' . $signatureEncoded;
    }
}
