<?php
declare(strict_types = 1);

namespace App\Service;

/**
 * Holds services for encrypting/decrypting values
 *
 * @author Cindy Clijsters
 */
class EncryptionService
{
    const SET_PASSWORD = 'BpJDqPgFRuXUDQA84mv4NbpLQpCZEStS';
    const CIPHER       = 'aes-256-cbc'; 
    
    /**
     * Encrypt a value
     * 
     * @param string $value
     * @param string $key
     * 
     * @return string
     */
    public function encrypt(string $value, string $key): string
    {
        $length = openssl_cipher_iv_length(self::CIPHER);
        $iv     = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", $length)), 0, $length);

        $encrypted = openssl_encrypt(
            $value,
            self::CIPHER,
            $key,
            $options = 0,
            $iv
        );
        
        return base64_encode($encrypted . '::' . $iv);        
    }
    
    /**
     * Decrypt a value
     * 
     * @param string $value
     * @param string $key
     * 
     * @return string
     */
    public function decrypt(string $value, string $key): string
    {
        $result        = '';
        $base64Decoded = base64_decode($value);
        $position      = strrpos($base64Decoded, '::');
        
        if ($position !== false) {
            list($encrypted_data, $iv) = explode('::', $base64Decoded, 2);
            
            $result = openssl_decrypt(
                $encrypted_data,
                self::CIPHER,
                $key,
                $options = 0,
                $iv
            );  
        }
        
        return $result;
    }    
}
