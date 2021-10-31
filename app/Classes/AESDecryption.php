<?php
namespace App\Classes;

class AESDecryption {
     //Decryption Method for AES Algorithm Starts

    public static function decrypt($code) {

        $key = config('knet.termResourceKey');
        $code =  self::hex2ByteArray(trim($code));
        $code= self::byteArray2String($code);
        $iv = $key; 
        $code = base64_encode($code);
        $decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        return self::pkcs5_unpad($decrypted);
    }
        
    private static function hex2ByteArray($hexString) {
        $string = hex2bin($hexString);
        return unpack('C*', $string);
    }
    
    
    private static function byteArray2String($byteArray) {
        $chars = array_map("chr", $byteArray);
        return join($chars);
    }
    
    
    private static  function pkcs5_unpad($text) {
        $pad = ord($text[strlen($text)-1]);
        if ($pad > strlen($text)) {
        return false;	
    }
    if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
        return false;
    }
     return substr($text, 0, -1 * $pad);
    }
        
    //Decryption Method for AES Algorithm Ends
}