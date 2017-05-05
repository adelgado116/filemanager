<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


include('functions.php');
include('dbConnect_i.php');



$sql = "SELECT manufacturerId, manufacturerName FROM sap_manufacturers WHERE isActive='1' ORDER BY manufacturerName ASC";
$res_loads = mysqli_query($link_id, $sql);
$table = get_table($res_loads);

echo(json_encode($table));

?>
