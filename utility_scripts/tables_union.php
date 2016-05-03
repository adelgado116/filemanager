<?php

#
#  Import to MySQL
#
require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


//$sql = "SELECT * FROM sales_table_hss UNION SELECT * FROM sales_table_11";
$sql = "INSERT INTO sales_table_11 SELECT * FROM sales_table_hss";
$res = $db->query($sql);

echo "<br/>done<br/>";




?>
