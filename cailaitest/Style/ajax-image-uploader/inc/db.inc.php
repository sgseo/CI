<?php

$username = "root";
$password = "RTX@twkj001";
$hostname = "localhost";	
$database = "cailai";

mysql_connect($hostname, $username, $password) or die(mysql_error());
mysql_select_db($database) or die(mysql_error()); 

?>
