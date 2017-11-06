<?php

function connectDB() {
  $mysql_hostname = '127.0.0.1';
  $mysql_username = 'root';
  $mysql_password = '';
  $mysql_dbname = 'sop';

  return new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname;charset=utf8;", $mysql_username, $mysql_password);
}

?>
