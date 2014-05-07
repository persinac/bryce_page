<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_brycConn = "127.0.0.1";
$database_brycConn = "cbox";
$username_brycConn = "root";
$password_brycConn = "password!";
$brycConn = mysql_pconnect($hostname_brycConn, $username_brycConn, $password_brycConn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>