<?php

declare(strict_types=1);

namespace app\core\classes;

class hash
{

	const secretKey  = "123asdqweasdqezz";
	
	const CipherAlgo = "aes-256-cbc";


	public static function encrypt(string $text)
	{
		if ($text !== null) {
			return self::encode(openssl_encrypt((string)$text, self::CipherAlgo, self::secretKey, 0, substr(self::secretKey, 0, 16)));
		} else {
			return false;
		}
	}


	public static function decrypt(string $text)
	{
		$decrypted = openssl_decrypt(self::decode($text), self::CipherAlgo, self::secretKey, 0, substr(self::secretKey, 0, 16));
		return $decrypted ?? false;
	}




	private static function encode($data)
	{
		return str_replace(['+', '/', '='], ['!',  '/', ''], base64_encode($data . "::Salted"));
	}

	private static function decode($base64)
	{
		return substr(str_replace(['!', '/', ''], ['+', '/', '='], base64_decode($base64)), 0, -8);
	}
}
