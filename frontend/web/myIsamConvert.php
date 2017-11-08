<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo 'conversion_started<br>';

mysql_connect('localhost', 'root', 'temp123');

mysql_select_db('sgkh');

// Actual code starts here

$sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = 'sgkh' 
        AND ENGINE = 'MyISAM'";

$rs = mysql_query($sql);

while($row = mysql_fetch_array($rs))
{
    $tbl = $row[0];
    $sql = "ALTER TABLE `$tbl` ENGINE=INNODB";
    mysql_query($sql);
}

echo 'converted';
