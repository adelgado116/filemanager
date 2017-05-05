<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


include('functions.php');
include('dbConnect_i.php');



if (isset($_REQUEST['page'])){
	$offset = $_REQUEST['page'] - 1;
}else {
	$offset = '0';
}

$offset*=20;


#
# GET DATA FROM MYSQL DATABASE
#
$sql = "SELECT * FROM sap_stock";
$result1 = $link_id->query($sql);



$sql = "SELECT * FROM sap_stock LIMIT $offset,20";
$result2 = $link_id->query($sql);


$result_to_encode = array();
$result_to_encode['num_rows'] = $result1->num_rows;
$result_to_encode['table'] = get_table( $result2 );

echo( json_encode( $result_to_encode ) );

?>