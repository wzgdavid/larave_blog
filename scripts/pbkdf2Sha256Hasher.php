<?php
/*
*
*pbkdf2_sha256 is the hasher of shanghaiexpat(django) using.
*
**/


function pbkdf2($p, $s, $c, $dk_len, $algo = 'sha1') {

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



//$hash = hash_pbkdf2("sha256", 'password', 'salt', 12000); // not same with from django.utils.crypto import pbkdf2
$hash = pbkdf2('password', 'salt', 12000, 32,$algo = 'sha256');
$hash2 = base64_encode($hash); // == base64.b64encode() in python
//echo $hash.'   ';
//echo $hash2;
/*
 in python
import base64
from django.utils.crypto import pbkdf2
hash = pbkdf2('password', 'salt', 12000, digest=hashlib.sha256)
#hash2 = base64.strip()
#hash2 = base64.b64encode(hash).strip()
base64.b64encode(hash)
*/

//echo base64_decode('aa7U0bCjl2wAHO25dVA32XP25TvLGnDAOoKaWWNcn2k=');


$encoded = 'pbkdf2_sha256$12000$sISLZL4fiqDX$RByE+rrWa89cOwuVqedK7abA3dj52i5XLCJp0DexZh4=';
//$hello = explode('$',$encoded);
$list = explode('$',$encoded);
$salt = $list[2];
$iterate = intval($list[1]);
//echo $hello[2];
#echo $salt,$iterate;
$hash = pbkdf2('SheX_500$', $salt, $iterate, 32,$algo = 'sha256');
$hash2 = base64_encode($hash);
//"%s$%d$%s$%s" % (self.algorithm, iterations, salt, hash)
//echo 'pbkdf2_sha256$'.strval($iterate).'$'.$salt.'$'.$hash2;


    function check_password($raw_password, $encoded){
        //$encoded = 'pbkdf2_sha256$12000$sISLZL4fiqDX$RByE+rrWa89cOwuVqedK7abA3dj52i5XLCJp0DexZh4=';
        $list = explode('$',$encoded);
        $salt = $list[2];
        $iterate = intval($list[1]);

        $hash = pbkdf2($raw_password, $salt, $iterate, 32,$algo = 'sha256');
        $hash2 = base64_encode($hash);
        $raw_encoded = 'pbkdf2_sha256$'.strval($iterate).'$'.$salt.'$'.$hash2;
        //echo $hash2;
        if ($raw_encoded == $encoded) {
            return 1;
        }else{
            return 0;
        }
    }

//echo check_password('SheX_500$', $encoded);






//test 

class Pbkdf2Sha256Hasher{

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
        $salt = 'salt';


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

$a = new Pbkdf2Sha256Hasher();
echo $a->hash('2222');
$hashed = $a->hash('2222');
echo $a->checkhash('2223', $hashed);