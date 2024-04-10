<?php

namespace App\Infrastructure\Adapter\Helper;

use App\Domain\Security\Entity\UserEntityInterface;
use App\Domain\Security\Exception\ExpiredTokenException;
use App\Domain\Security\Exception\InvalidTokenException;
use App\Domain\Shared\Helper\TokenHelperInterface;

readonly class JWTToken implements TokenHelperInterface
{
    public function __construct(private string $jwtSecret)
    {
    }

    public function generateUserToken(UserEntityInterface $user, int $lifetime = 3600): string
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'user_id' => $user->getId(),
            'user_email' => $user->getEmail(),
        ];

        return $this->generate($header, $payload, $lifetime);
    }

    public function verifyToken(string $token): array
    {
        if (!$this->isValid($token)) {
            throw new InvalidTokenException();
        }

        $header = $this->getData($token, 0);
        $payload = $this->getData($token, 1);
        $verifyToken = $this->generate($header, $payload, 0);

        if ($verifyToken !== $token) {
            throw new InvalidTokenException();
        }

        if ($this->isExpired($token)) {
            throw new ExpiredTokenException();
        }

        return $payload;
    }

    public function generate(array $header, array $payload, int $lifetime): string
    {
        if ($lifetime > 0) {
            $now = new \DateTimeImmutable();
            $exp = $now->getTimestamp() + $lifetime;

            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $exp;
        }

        $secret = base64_encode($this->jwtSecret);

        $encodeHeader = $this->encodeData($header);
        $encodePayload = $this->encodeData($payload);

        $signature = hash_hmac('sha256', $encodeHeader . '.' . $encodePayload, $secret, true);
        $encodeSignature = $this->encodeData($signature);

        return $encodeHeader . '.' . $encodePayload . '.' . $encodeSignature;
    }

    private function isValid(string $token): bool
    {
        return preg_match('/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/', $token) === 1;
    }

    private function isExpired(string $token): bool
    {
        $payload = $this->getData($token, 1);

        $now = new \DateTimeImmutable();

        return $payload['exp'] < $now->getTimestamp();
    }

    private function getData(string $token, int $index): array
    {
        $data = explode('.', $token)[$index];

        return json_decode(base64_decode($data, true), true);
    }

    private function encodeData($data): string
    {
        if (\is_array($data)) {
            $data = json_encode($data);
        }

        $encodedData = base64_encode($data);

        return str_replace(['+', '/', '='], ['-', '_', ''], $encodedData);
    }
}
