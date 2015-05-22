<?php 
// $Id: cleanex.php,v 1.0.1 2009/02/12 03:00:21 humaneasy Exp $
/** 
 * @file 
 * Generates config for test program.
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

       <meta HTTP-EQUIV="Cache-Control" value="no-cache, must-revalidate">
       <meta HTTP-EQUIV="~Pragma" value="no cache">
       <meta HTTP-EQUIV="Expires" value="Mon, 26 Jan 1970 00:00:00 GMT">
       <meta HTTP-EQUIV="Last-Modified" value="Mon, 21 May 2003 16:52:00 GMT">

   </head>
   <body>
   <table cellpadding=0 cellspacing=0 width="100%" height="100%"><tr><td height="95%">
       <img src=efc_logo.gif alt=efc align=right valign=top>

<?php

   // make sure we can use mcrypt_generic_init
   if (!function_exists(mcrypt_generic_init)) {
?>

       <h5>libmcrypt not available</h5>
       <p>In order to use crypt class you must have libmcrypt >= 2.4.x installed and
          PHP must be compiled with --with-mcrypt, if you don't know what this means
          please contact your hosting provider or system admin.</p>

<?php
     exit;
   }

   // Define mandatory variable
   if (!defined("__SECURE_PATH__"))
       define("__SECURE_PATH__", "{$_SERVER['DOCUMENT_ROOT']}/efc/secured/", TRUE);

   // Set a temporary $key and $data for encryption tests
   $key = md5(time() . getmypid());
   $data = @file_get_contents('efc.class.php');

   // Get and sort available cipher methods
   $ciphers = mcrypt_list_algorithms();
   natsort($ciphers);

   // Get and sort available cipher modes
   $modes = mcrypt_list_modes();
   natsort($modes);
   
   print "       <h3>Tests to installed libmcrypt ciphers/modes</h3>\n";
   print "       <ol>\n";

   foreach ($ciphers as $cipher) {

       print "         <li>Cipher: $cipher\n";
       print "           <ul>\n";

       foreach ($modes as $mode) {

           // Not Compatible
           $result = 'false';

           // open encryption module
           $td = @mcrypt_module_open($cipher, '', $mode, '');

           // if we could open the cipher
           if ($td) {

               // try to generate the iv
               $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);

               // if we could generate the iv
               if ($iv) {

                  // initialize encryption
                  @mcrypt_generic_init ($td, $key, $iv);

                  // encrypt data
                  $encrypted_data = mcrypt_generic($td, $data);

                  // cleanup
                  mcrypt_generic_deinit($td);

                  // No error issued
                  $result = 'true';
               }

               // close
               @mcrypt_module_close($td);

           }

           print "             <li>Mode <i>$mode</i> is <b>$result</b>.</li>\n";
           if ($result == "true")
              $available["$cipher"][] = $mode;

       }
       print "           </ul>\n";
       print "         </li>\n";
   }
?>
       </ol>
<?php
   if (count($available) > 0) {
      print "       <font size=3>Saving config file...</font>\n";

       // Set destination file name
      $dst_filename = __SECURE_PATH__.".efc.config.php";

      // touch destination file so it will exist when we check for it
      @touch($dst_filename);

      // can we write to it
      $msg = "configuration: cannot open ".$dst_filename." ";
      if (!is_writable($dst_filename))
          trigger_error($msg, E_USER_ERROR);

       // open the destionation file for writing
       $dest_fp = fopen($dst_filename, w);

       // return false if unable to open file
       $msg = "configuration: cannot open ".$dst_filename." ";
       if (!$dest_fp) trigger_error($msg, E_USER_ERROR);

       // write encrypted data to file
       $strAv  = "<?php\n\n";
       $strAv .= "/**\n";
       $strAv .= "  Copyright (C) 2003 HumanEasy, Lda. <humaneasy@sitaar.com>.\n";
       $strAv .= "  All rights reserved.\n\n";
       $strAv .= "  This file is licensed under GNU GPL version 2 or above.\n";
       $strAv .= "  Please visit http:\/\/www.gnu.org to now more about it.\n\n";
       $strAv .= " ----------------------------------------------------------------\n\n";
       $strAv .= "   Name: EasyFileCrypt Extending Crypt Class\n";
       $strAv .= "   Version: 1.0\n\n";
       $strAv .= "   Created: ".date("r")."\n";
       $strAv .= "   Ciphers Installed on this system: ".count($ciphers)."\n\n";
       $strAv .= "**/\n\n";
       $strAv .= "    \$xfss = Array ( ";

       foreach ($ciphers as $avCipher) {

           $v = "";
           if (count($available["$avCipher"]) > 0) {
              foreach ($available["$avCipher"] as $avMode)
                  $v .= " '".$avMode."', ";

                  $i = strlen($v) - 2;
                  if ($v[$i] == ",")
                    $v = substr($v, 2, $i - 3);
           }
           if (!empty($v)) $v = " '".$v."' ";
           $strAv .= "'".$avCipher."' => Array (".$v."),\n                    ";
       }
       $strAv = rtrim($strAv);
       if ($strAv[strlen($strAv) - 1] == ",")
          $strAv = substr($strAv, 0, strlen($strAv) - 1);
       $strAv .= " );\n\n";
       $strAv .= "?>";

       fwrite($dest_fp, $strAv);

       // close encrypted file pointer
       fclose($dest_fp);
   }
?>
       <h1>Done!</h1>
     </td></tr>
     <tr><td height=8 bgcolor=navy align=right><font face=arial,sans-serif size=1 color=white>EFC/XFSS - Extended File Stealth System © 2003 HumanEasy, Lda. Licensed under GNU General Public License 2 or above. All Rights Reserved.&nbsp;&nbsp;&nbsp;</font></td>
     </tr>
   </table>
  </body>
</html>