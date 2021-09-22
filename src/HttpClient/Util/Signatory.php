<?php

declare(strict_types=1);

namespace RegistruCentras\OneSign\HttpClient\Util;

use RegistruCentras\OneSign\Exception\ValidationFailedException;

final class Signatory
{
    public static function sign(string $content, string $privateKey, string $passphrase = ''): string
    {
        $sign = '';
        
        $key = \openssl_get_privatekey($privateKey, $passphrase);
        
        \openssl_sign($content, $sign, $key);
        
        return $sign;
    }
    
    public static function validate(string $publicKey, string $content, string $signature): void
    {
        $publicKeyId = \openssl_pkey_get_public($publicKey);
        
        $ok = \openssl_verify($content, $signature, $publicKeyId);
        
        if ($ok === 0) {
            throw new ValidationFailedException((string)\openssl_error_string());
        }
    }
}
