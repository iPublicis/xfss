# xfss
The main idea behind "EFC/XFSS - Enhanced File Crypt/Extended File Stealth System" is to have your uploaded files safe in the server in a way that, even if someone can get them, no one can read them without knowing a few details to decrypt the files.

The class uses a random trick to select the encryption method that is used. This will always generate diferent encrypted files.

The file names are also obfuscated, so a sneaker will not know what the original format was.

This class was mainly developed to be used with GPL'ed Care2002 Medical Information System (www.care2x.org). However, its use was postponed because most of the files uploaded were images and most of them do not have any personal identifiable info on them.

This class, in a broader sense, has yet a long way to go. For now it is simply a sub-class of part of the RC4Crypt class. It allows an easy process of encryption and decryption of uploaded files. It requires libmcrypt support and, when possible, an SSL internet connection to be used.


The class needs mcrypt PHP functions. The next challenge will be to encrypt and decrypt the files at client side, perhaps with Javascript, for those that cannot have an SSL connection, and also the creation of a replacement class for those that do not have the possibility to use libmcrypt.

The only files that you need to look at into are index.php, srcefc.php, mkconfig.php and .htaccess (the last one to use in the secured directory for strict security if you can not put it outside Web document tree).

The documentation is inside these PHP scripts.

You also need to search for the definition of __SECURE_PATH__, and modify the path in the above PHP files.

The class is also available at http://www.phpclasses.org/efc_xfss
