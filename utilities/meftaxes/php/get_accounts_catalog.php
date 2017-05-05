<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


include('functions.php');
include('dbConnect_i.php');




$sql = "SELECT AcctCode, AcctName FROM sapbo_oact WHERE CHAR_LENGTH(AcctCode) = 2 ORDER BY AcctCode ASC";
$res_loads = mysqli_query($link_id, $sql);
$table = get_table($res_loads);

echo(json_encode($table));

?>