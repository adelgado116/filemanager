<?php



require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');



$sql = "UPDATE service_items_tbl SET coord_id='13'";
$res = $db->query($sql);





?>

