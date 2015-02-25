<?php
/**
 * A Simple Skip32 php implementation
 * 32-bit block cipher based on Skipjack
 *
 * @example
 *
 *   $key = '0123456789abcdef0123'; // 10 bytes key
 *   $int = 4294967295; // 4 bytes integer
 *
 *   $encrypted = Skip32::encrypt($key, $int);
 *   $decrypted = Skip32::decrypt($key, $encrypted);
 *
 *   printf("%d encrypted to %d\n", $int, $encrypted);
 *   printf("%d decrypted to %d\n", $encrypted, $decrypted);
 *
 * This will display (on 64-bit architecture) :
 *
 *   4294967295 encrypted to 572455217
 *   572455217 decrypted to 4294967295
 *
 * @author Nicolas Lenepveu <n.lenepveu@gmail.com>
 */
class Skip32
{
    const DEFAULT_KEY_BASE = 16;

    const DEFAULT_BLOCK_BASE = 10;

    private $_cipher;

    /**
     * Simple way to encrypt a 4 bytes long ASCII string
     *
     * @param string $key  ASCII representation of a 10 bytes long key
     * @param int    $data 4 bytes block integer
     *
     * @return string
     */
    public static function encrypt($key, $data)
    {
        $simple = new self($key);
        return $simple->enc($data);
    }

    /**
     * Simple way to decrypt a 4 bytes long ASCII string
     *
     * @param string $key  ASCII representation of a 10 bytes long key
     * @param int    $data 4 bytes block integer
     *
     * @return string
     */
    public static function decrypt($key, $data)
    {
        $simple = new self($key);
        return $simple->dec($data);
    }

    /**
     * Cipher constructor
     *
     * @param string $key ASCII representation of a 10 bytes long key
     */
    public function __construct($key)
    {
        $key = $this->_binarize($key, self::DEFAULT_KEY_BASE, Skip32Cipher::KEY_SIZE);
        $this->_cipher = new Skip32Cipher($key);
    }

    /**
     * Encrypt a 4 bytes long ASCII string
     *
     * @param string $data ASCII representation of a 4 bytes block
     *
     * @return string
     */
    public function enc($data)
    {
        return $this->_simplify('encrypt', $data);
    }

    /**
     * Decrypt a 4 bytes long ASCII string
     *
     * @param string $data ASCII representation of a 4 bytes block
     *
     * @return string
     */
    public function dec($data)
    {
        return $this->_simplify('decrypt', $data);
    }

    /**
     * Simplify the use of Skip32 Cipher
     *
     * @param string $method Method of the Cipher (encrypt|decrypt)
     * @param string $data   ASCII representation of a 4 bytes block
     *
     * @return string
     */
    private function _simplify($method, $data)
    {
        $data = $this->_binarize($data, self::DEFAULT_BLOCK_BASE, Skip32Cipher::BLOCK_SIZE);

        $data = $this->_cipher->$method($data);

        $data = current(unpack("H8", $data));
        $data = base_convert($data, 16, self::DEFAULT_BLOCK_BASE);

        return $data;
    }

    /**
     * Binarize an ASCII representation of bytes
     *
     * @param string $data ASCII representation of bytes
     * @param int    $n    number of bytes expected
     *
     * @return string
     */
    private function _binarize($data, $base, $n)
    {
        if ($base != 16) {
            $data = base_convert($data, $base, 16);
        }

        $len = $n * 2;
        $hex = sprintf("%0{$len}s", $data);
        return pack("H{$len}", $hex);
    }

}

