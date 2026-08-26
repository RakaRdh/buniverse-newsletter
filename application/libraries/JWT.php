<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JWT {

    /**
     * Decode a JWT string
     *
     * @param string $jwt
     * @param string $key
     * @return object|false
     */
    public function decode($jwt, $key)
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        list($headerB64, $payloadB64, $signatureB64) = $parts;

        $header = json_decode($this->base64UrlDecode($headerB64));
        $payload = json_decode($this->base64UrlDecode($payloadB64));

        if (!$header || !$payload) {
            return false;
        }

        // Verify signature
        $expectedSignature = hash_hmac('sha256', "$headerB64.$payloadB64", $key, true);
        $expectedSignatureB64 = $this->base64UrlEncode($expectedSignature);

        if (!hash_equals($expectedSignatureB64, $signatureB64)) {
            return false;
        }

        // Check expiration
        if (isset($payload->exp) && $payload->exp < time()) {
            return false;
        }

        return $payload;
    }

    /**
     * Encode a payload into a JWT
     *
     * @param array $payload
     * @param string $key
     * @return string
     */
    public function encode($payload, $key)
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $headerB64 = $this->base64UrlEncode(json_encode($header));
        $payloadB64 = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac('sha256', "$headerB64.$payloadB64", $key, true);
        $signatureB64 = $this->base64UrlEncode($signature);

        return "$headerB64.$payloadB64.$signatureB64";
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}
