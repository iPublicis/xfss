<?php 
// $Id: cleanex.php,v 1.0.1 2009/02/12 03:00:21 humaneasy Exp $
/** 
 * @file 
 * Small utility to clean up your test SECURED directory. 
 * Don't use it in a production environment without caution.
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
       <title>Directory Cleanex!</title>
</head>
<body>
  <h1>Directory Cleanex!</h1>

<?php
    define("__SECURE_PATH__", $_SERVER['DOCUMENT_ROOT'].'/testando/efc/secured/', TRUE);
?>

  <ul>
    <li>Starting cleaning <b><?php echo __SECURE_PATH__; ?></b><br>
      <ol>
<?php

    @chmod(__SECURE_PATH__, 0777);
    if (@is_dir(__SECURE_PATH__)) {
       $handle = @opendir(__SECURE_PATH__);
       while($filename = @readdir($handle)) {
           if ($filename != "." && $filename != ".." && $filename != ".htaccess"
               && $filename != ".htaccess.safe" && $filename != ".efc.config.php" ) {
               print "      <li>Removing <i><u>".$filename."</u></i> ...</li>\n";
               unlink(__SECURE_PATH__.$filename);
               flush();
           }
       }
       closedir($handle);
    }

    print "      </ol>\n    </li>\n    <li>Done! Redirecting...</li>\n  <ul>\n";
//    print "<script language=javascript>top.location = 'http://www.sitaar.com/testando/efc/secured';</script>";
    print "<script language=javascript>\n\n  top.location = 'http://www.sitaar.com/testando/efc/';\n\n</script>\n\n";
    exit;
?>
</body>
</html>
<!--
 EFC/XFSS - Extended File Stealth System
 Copyright (C) 2003-2009 Humaneasy, brainVentures Network. 
 Licensed under GNU Lesser General Public License 3 or above.
 Please visit http://www.gnu.org to now more about it.
//-->