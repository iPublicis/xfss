<?php 
// $Id: index.php,v 1.0.1 2009/02/12 03:00:20 humaneasy Exp $
/** 
 * @file 
 * Test file. Read it to see how to use the Class.
 * @Version: 1.0.1
 * @Released: 05/27/03
 * @Donation: http://smsh.me/7kit 
 *
 * Copyright (C) 2003-2009 Humaneasy, brainVentures Network. 
 * Licensed under GNU Lesser General Public License 3 or above.
 * Please visit http://www.gnu.org to now more about it.
 *
 * THIS SOFTWARE IS PROVIDED BY THE PROJECT AND CONTRIBUTORS ``AS IS'' AND
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 * 
 * 3. Neither the name of the project nor the names of its contributors
 *    may be used to endorse or promote products derived from this software
 *    without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE PROJECT AND CONTRIBUTORS ``AS IS'' AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR 
 * PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE PROJECT OR CONTRIBUTORS 
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR 
 * BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, 
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR 
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF 
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */ 
?><!doctype html public "-//W3C//DTD HTML 4.0 //EN">
<html>
<head>
       <title>EFC/XFSS - Enhanced File Crypto/Extended File Stealth System!</title>

       <!-- START: Browser Icon -->
       <link REL="icon" TYPE="image/gif" HREF="icon_logo.gif">
       <!-- ENDED: Browser Icon -->

</head>
<body>
<table cellpadding=0 cellspacing=0 width="100%" height="100%"><tr><td height="95%">
<img src=efc_logo.gif alt=efc align=right valign=top>
<p><h3>Directions:</h3></p>
<blockquote><p>
<ol>
<li>Select the file to encrypt
<li>Click Do It To It
<li>Click UnDo It To It
<li>Click <a href=cleanex.php>HERE</a> to empty secured directory
<li>Download it <a href="http://www.phpclasses.org/efc_xfss">HERE</a>.<br>
    The only files that you must look into are INDEX.PHP, SRCEFC.PHP,<br>
    MKCONFIG.PHP and .HTACCESS (the last one to use in the 'SECURED' directory).<br>
    Search and modify <i>define("__SECURE_PATH__"</i> in the above PHP files.
</ol>
</p></blockquote>
<hr>
<FORM method="post" action="<?php print $_SERVER['PHP_SELF']; ?>" ENCTYPE="multipart/form-data">
<table cellspacing="2" cellpadding="2">
<tr>
   <td><b>File:</b></td><td><input type="file" size="60" name="userfile"></td>
</tr>
</table>
<p align="center"><input type="submit" name="submit" value="Do It To It!"></p>
</form>

<?php
   if (isset($_POST['submit'])) {

     // You need to define the protected directory path BEFORE including
     // the class. You could move this to your config file.
     // This DIR must be a FULL PATH starting from ROOT DIR
     // Protect this directory from ANY WEB ACCESS with an .htaccess
     // if you are using Apache Server. Must advisable.
     define("__SECURE_PATH__", $_SERVER['DOCUMENT_ROOT'].'/testando/efc/secured/', TRUE);

      // Include the Class
      require_once('efc.class.php');

      // Instantiate your new class
      $crypt_class = new easyfilecrypt();

      // Encrypt It
      $crypt_class->encryptfile($_FILES['userfile']);

?>

<hr>
<table cellspacing="2" cellpadding="2">
<tr><td><b>Original File:</b></td><td> </td><td><? echo $_FILES['userfile']['name']; ?></td></tr>
<tr><td><b>Temp File:</b></td><td> </td><td><? echo $_FILES['userfile']['tmp_name']; ?></td></tr>
<tr><td bgcolor="navy" colspan=3></td></tr>
<tr><td colspan=3>This is the data that must be saved somewhere to allow future file retrieval.</td></tr>
<tr><td bgcolor="navy" colspan=3></td></tr>
<tr><td><b>New File:</b></td><td> </td><td><? echo $crypt_class->efc['name']; ?></td></tr>
<tr><td><b>Located at:</b></td><td> </td><td><? echo __SECURE_PATH__; ?></td></tr>
<tr><td><b>Extension:</b></td><td> </td><td><? echo $crypt_class->efc['ext']; ?></td></tr>
<tr><td><b>Mime Type:</b></td><td> </td><td><? echo $crypt_class->efc['type']; ?></td></tr>
<tr><td><b>Size:</b></td><td> </td><td><? echo $crypt_class->efc['size']; ?></td></tr>
<tr><td><b>CRC:</b></td><td> </td><td><? echo $crypt_class->efc['crc']; ?></td></tr>
<tr><td><b>Enc. Key:</b></td><td> </td><td><? echo $crypt_class->efc['key']; ?></td></tr>
<tr><td><b>Cipher Style:</b></td><td> </td><td><? echo $crypt_class->efc['cipher']; ?></td></tr>
<tr><td><b>Cipher Mode:</b></td><td> </td><td><? echo $crypt_class->efc['mode']; ?> (cbc is better for files)</td></tr>
</table>
<FORM method="post" action="srcefc.php" target="_blank">
<p align="center"><input type="submit" name="submit" value="UnDo It To It!"></p>
<input type="hidden" name="my_name" value="<? echo $crypt_class->efc['name']; ?>">
<input type="hidden" name="my_ext" value="<? echo $crypt_class->efc['ext']; ?>">
<input type="hidden" name="my_type" value="<? echo $crypt_class->efc['type']; ?>">
<input type="hidden" name="my_size" value="<? echo $crypt_class->efc['size']; ?>">
<input type="hidden" name="my_crc" value="<? echo $crypt_class->efc['crc']; ?>">
<input type="hidden" name="my_key" value="<? echo $crypt_class->efc['key']; ?>">
<input type="hidden" name="my_cipher" value="<? echo $crypt_class->efc['cipher']; ?>">
<input type="hidden" name="my_mode" value="<? echo $crypt_class->efc['mode']; ?>">
</form>

<?php
   } else {
?>

</td></tr><tr><td height=150>&nbsp;

<?php
   } 
?>

</td></tr><tr><td height=8 bgcolor=navy align=right><font face=arial,sans-serif size=1 color=white>EFC/XFSS - Extended File Stealth System &copy; 2003-2009 Humaneasy, brainVentures Network. Licensed under GNU Lesser General Public License 3 or above. All Rights Reserved.&nbsp;&nbsp;&nbsp;</font></td></tr><tr><td height=8 bgcolor=navy align=right><font face=arial,sans-serif size=1 color=white>Help us with our free work. <a href="http://smsh.me/7kit">Donate at Paypal</a>. Thanks!&nbsp;&nbsp;&nbsp;</font></td></tr></table>
</body>
</html>