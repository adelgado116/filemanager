<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


include('functions.php');
include('dbConnect_i.php');




$sql = "SELECT * FROM MEF_forms";
$result = mysqli_query($link_id, $sql);
$table = get_table($result);

echo(json_encode($table));


?>