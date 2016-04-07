<?php namespace Cartalyst\Sentry\Hashing;
/**
 * Part of the Sentry package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class Pbkdf2_Sha256Hasher extends BaseHasher implements HasherInterface {

	/**
	 * Salt Length
	 *
	 * @var int
	 */
	public $saltLength = 16;

	/**
	 * Hash string.
	 *
	 * @param  string  $string
	 * @return string
	 */
	public function hash($string)
	{
		// Create salt
		$salt = $this->createSalt();


		$hash = $this->pbkdf2($string, $salt, 12000, 32);
        $hash2 = base64_encode($hash);
        $hashed = 'pbkdf2_sha256$12000$'.$salt.'$'.$hash2;
        return  $hashed;
	}

	/**
	 * Check string against hashed string.
	 *
	 * @param  string  $string
	 * @param  string  $hashedString
	 * @return bool
	 */
	//public function checkhash($string, $hashedString)
    public function checkhash($string, $hashedString){
        //$hashedString = 'pbkdf2_sha256$12000$sISLZL4fiqDX$RByE+rrWa89cOwuVqedK7abA3dj52i5XLCJp0DexZh4=';
        $list = explode('$',$hashedString);
        $salt = $list[2];
        $iterate = intval($list[1]);

        $hash = $this->pbkdf2($string, $salt, $iterate, 32,$algo = 'sha256');
        $hash2 = base64_encode($hash);
        $raw_encoded = 'pbkdf2_sha256$'.strval($iterate).'$'.$salt.'$'.$hash2;
        //echo $hash2;
        if ($raw_encoded == $hashedString) {
            return 1;
        }else{
            return 0;
        }
    }

	private function pbkdf2($p, $s, $c, $dk_len, $algo = 'sha256') {

    	// experimentally determine h_len for the algorithm in question
    	static $lengths;
    	if (!isset($lengths[$algo])) { $lengths[$algo] = strlen(hash($algo, null, true)); }    
    	$h_len = $lengths[$algo];
    
    	if ($dk_len > (pow(2, 32) - 1) * $h_len) {
        	return false; // derived key is too long
    	} else {
        	$l = ceil($dk_len / $h_len); // number of derived key blocks to compute
        	$t = null;
        	for ($i = 1; $i <= $l; $i++) {
            	$f = $u = hash_hmac($algo, $s . pack('N', $i), $p, true); // first iterate
            	for ($j = 1; $j < $c; $j++) {
                	$f ^= ($u = hash_hmac($algo, $u, $p, true)); // xor each iterate
            	}
            	$t .= $f; // concatenate blocks of the derived key
        	}
        	return substr($t, 0, $dk_len); // return the derived key of correct length
    	}
	}



}

