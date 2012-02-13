<?php

$int = (PHP_INT_SIZE == 4) ? PHP_INT_MAX : 4294967295; // 4 bytes integer

require_once 'Skip32Cipher.php';

$key = pack('H20', '0123456789abcdef0123'); // 10 bytes key
$cipher = new Skip32Cipher($key);

$bin = pack('N', $int);
$encrypted = $cipher->encrypt($bin);
list(, $h, $l) = unpack('n*', $encrypted); // works on 32-bit architecture
$encryptedInt = $l + ($h * 0x010000);

printf("%s encrypted to %s\n", $int, $encryptedInt);

$bin = pack('N', $encryptedInt);
$decrypted = $cipher->decrypt($bin);
list(, $decryptedInt) = unpack('N', $decrypted);

printf("%s decrypted to %s\n", $encryptedInt, $decryptedInt);

require_once 'Skip32.php';

$key = '0123456789abcdef0123'; // 10 bytes key

$encrypted = Skip32::encrypt($key, $int);
$decrypted = Skip32::decrypt($key, $encrypted);

printf("%s encrypted to %s\n", $int, $encrypted);
printf("%s decrypted to %s\n", $encrypted, $decrypted);

$cipher = new Skip32($key);
$encrypted = $cipher->enc($int);
$decrypted = $cipher->dec($encrypted);

printf("%s encrypted to %s\n", $int, $encrypted);
printf("%s decrypted to %s\n", $encrypted, $decrypted);

