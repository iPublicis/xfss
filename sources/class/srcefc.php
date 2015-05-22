<?php 
// $Id: srcefc.php,v 1.0.1 2009/02/12 03:00:18 humaneasy Exp $
/** 
 * @file 
 * Test file used by index.php. 
 * Read it to see how to use the Class to retrieve encrypted files.
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

     // You need to define the protected directory path BEFORE including
     // the class. You could move this to your config file.
     // This DIR must be a FULL PATH starting from ROOT DIR
     // Protect this directory from ANY WEB ACCESS with an .htaccess
     // if you are using Apache Server. Must advisable.
     // Use the .htaccess included in the package if you wich.
     define("__SECURE_PATH__", $_SERVER['DOCUMENT_ROOT'].'/testando/efc/secured/', TRUE);

     // Include the Class
     require_once('efc.class.php');

     // Instantiate your new class
     $crypt_class = new easyfilecrypt();

     /*
        The $my_* vars could be retrieved from a DB like the below one:
        
             CREATE TABLE <prefix>_efc_files (
                 fid int(11) unsigned NOT NULL default '0',
                 name varchar(50) NOT NULL default '',
                 type varchar(30) NOT NULL default '',
                 ext varchar(13) NOT NULL default '',
                 size int(11) unsigned NOT NULL default '0',
                 crc varchar(32) NOT NULL default '',
                 key varchar(50) NOT NULL default '',
                 cipher varchar(50) NOT NULL default 'twofish',
                 KEY fid (fid)
             ) TYPE=MyISAM;

        You will keep values in the DB and call then through SQL.

        So you could use it more like  <img src="srcefc.php?fid=1" />
        When $my_type is an image/* mime-type and outputs imediately the
        decrypted contents.
        
        Or more like: <a href="srcefc.php?fid=1" target="_blank">Get it!</a>
        When $my_type is of another kind and starts the download of a file like
        an Adobe Acrobat PDF or something else when clicked.
     */
     
     // Now you only need to add the necessary stuff
     $crypt_class->efc['name']  = $my_name;
     $crypt_class->efc['type']  = $my_type;
     $crypt_class->efc['ext']   = $my_ext;
     $crypt_class->efc['size']  = $my_size;
     $crypt_class->efc['crc']   = $my_crc;
     $crypt_class->efc['key']   = $my_key;
     $crypt_class->efc['cipher']= $my_cipher;
     $crypt_class->efc['mode']  = $my_mode;

/**
     while(list($key,$value) = each($crypt_class->efc))
        echo "$key => $value<br>\n";
     exit;
**/

     // Decrypt the file
     $contents = $crypt_class->decryptfile();

     // ... prepare some more vars...
     $tmpfname = md5(time() . getmypid()) . ".$my_ext";
     $tmplengh = strlen($contents);

/**/
     // ... and output contents directly.
     header("Cache-Control: no-cache, must-revalidate");
     header("Pragma: no cache");
     header("Expires: Mon, 26 Jan 1970 00:00:00 GMT");
     header("Last-Modified: Mon, 21 May 2003 16:52:00 GMT");
     header("Content-Type: $my_type");
     header("Content-Length: $tmplengh");
     header("Content-Disposition: inline; filename=$tmpfname");
     print $contents;
/**/

/**
     // ... and output contents to a file and link.
     $dest_fp = fopen($_SERVER['DOCUMENT_ROOT']."/testando/efc/$tmpfname", w);
     fwrite($dest_fp, $contents);
     fclose($dest_fp);
     
     echo "<a href=http://www.sitaar.com/testando/efc/$tmpfname>download</a>";
**/

     exit;
?>