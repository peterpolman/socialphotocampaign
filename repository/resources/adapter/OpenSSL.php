<?php 

//WE::include_adapter('SoapServer/Exception');

/**
 * Wrapper implementation for OpenSSL encryption / decryption
 * @author Tim
 */
class OpenSSL {
	
	private static $digest_method = OPENSSL_ALGO_SHA1;
	private static $cipher_method = "AES256";
	
	// Does the application segfault? This is a know bug for selecting
	// a custom cipher method. Set this flag to skip that.
	private static $workAroundBug = true;
	
	/**
	 * Generate a pair of public / private keys
	 * @return array (private key, public key)
	 */
	public static function generateKeys() {
		// Create configuration for certificate
		$config = array(
			'private_key_bits'=>1024,
			'encrypt_key'=>true
		);
		
		// Create the keypair
		$res1=openssl_pkey_new($config);
		
		// Get private key
		openssl_pkey_export($res1, $private);
		
		// Get public key
		$public=openssl_pkey_get_details($res1);
		$public=$public["key"];
		
		openssl_free_key($res1);
		return array($private,$public);
	}
	
	/**
	 * Encrypt a plain text message using someones public key
	 * Then sign the data using your own private key
	 * Then return everything base64 encoded
	 * @param string $plaintext String to encrypt
	 * @param string $public Recipient's public key
	 * @param string $private Your private key
	 * @return array (encrypted message, envelope key, signature)
	 * @throws WE_Exception
	 */
	public static function encrypt($plaintext,$public,$private) {
		if ( self::$workAroundBug ) {
			if ( !openssl_seal($plaintext, $sealed, $ekeys, array($public)) ) {
				throw new Exception("Could not encrypt your plaintext (seal)");
			}
		} else {
			if ( !openssl_seal($plaintext, $sealed, $ekeys, array($public), self::$cipher_method) ) {
				throw new Exception("Could not encrypt your plaintext (seal)");
			}
		}
		$sealed = base64_encode($sealed);
		$ekey = base64_encode($ekeys[0]);
		
		if ( !openssl_sign($plaintext, $signature, $private, self::$digest_method) ) {
			throw new Exception("Could not encrypt your plaintext (sign)");
		}
		$signature = base64_encode($signature);
		
		return array($sealed,$ekey,$signature);
	}
	
	/**
	 * Decode everything from base64
	 * Then decrypt the message using your private key
	 * Then verify the authenticity of the sender using their public key
	 * Finally return the plaintext
	 * @param string $sealed The encrypted message
	 * @param string $ekey The envelope key
	 * @param string $signature The signature
	 * @param string $private Your private key
	 * @param string $public Sender's public key
	 * @return string Plaintext or false on error
	 */
	public static function decrypt($sealed, $ekey, $signature, $private, $public) {
		if ( !openssl_open( base64_decode($sealed), $plaintext, base64_decode($ekey), $private ) ) {
			details("Error: Could not decrypt sealed message");
			return false;
		}
		
		if ( 1 != openssl_verify($plaintext, base64_decode($signature), $public, self::$digest_method) ) {
			details("Error: Signature incorrect or error in authenticity verification");
			return false;
		}
		return $plaintext;
	}
	
}


?>