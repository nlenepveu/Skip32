Skip32 php implementation
=========================

32-bit block cipher based on Skipjack

This cipher can be handy for scrambling small (32-bit) values when you would like to obscure them while keeping the encrypted output size small (also only 32 bits).

Skip32.php
----------

Simple API to encrypt/decrypt values using the Skip32 cipher

Example :

  $key = '0123456789abcdef0123'; // 10 bytes key
  $int = 4294967295; // 4 bytes integer

  $encrypted = Skip32::encrypt($key, $int);
  $decrypted = Skip32::decrypt($key, $encrypted);

  printf("%d encrypted to %d\n", $int, $encrypted);
  printf("%d decrypted to %d\n", $encrypted, $decrypted);

 This will display (on 64-bit architecture) :

  4294967295 encrypted to 572455217
  572455217 decrypted to 4294967295

Skip32Cipher.php
----------------

Adaptation of a direct Perl translation of the SKIP32 C implementation
http://search.cpan.org/~esh/Crypt-Skip32/lib/Crypt/Skip32.pm
http://www.qualcomm.com.au/PublicationsDocs/skip32.c

Example :

  $key = pack('H20', '0123456789abcdef0123'); // 10 bytes key
  $cipher = new Skip32Cipher($key);

  $int = 4294967295; // 4 bytes integer

  $bin = pack('N', $int);
  $encrypted = $cipher->encrypt($bin);
  list(, $encryptedInt) = unpack('N', $encrypted);

  printf("%d encrypted to %d\n", $int, $encryptedInt);

  $bin = pack('N', $encryptedInt);
  $decrypted = $cipher->decrypt($bin);
  list(, $decryptedInt) = unpack('N', $decrypted);

  printf("%d decrypted to %d\n", $encryptedInt, $decryptedInt);

 This will display (on 64-bit architecture) :

  4294967295 encrypted to 572455217
  572455217 decrypted to 4294967295

Performed by Nicolas Lenepveu <n.lenepveu@gmail.com>
