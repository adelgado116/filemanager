<?php

/*
echo $_REQUEST['del_2'];

$return_arr = array();
$return_arr["status"] = 0;

echo json_encode($return_arr);
*/


if ( strchr( $_SERVER['HTTP_REFERER'], "http://freja/webapps/file_manager/page2.php" ) ) {
	$return_to_page = "page2.php";
} else {
	$return_to_page = "page2_2.php";
}



$imo = $_REQUEST['IMO_NUMBER'];
$order = $_REQUEST['ORDER_NO'];
$tabNumber = $_REQUEST['TAB'];

#
#  delete the file indicated by "del" variable coming from page2.php
#
if ( isset($_REQUEST['del']) ) {
	
	if ( file_exists($_REQUEST['del']) ) {
	
		unlink ($_REQUEST['del']);
		$success = TRUE;
	} else {
	}
}

header("Location: ".$return_to_page."?IMO_NUMBER=$imo&ORDER_NO=$order#tabs-$tabNumber");



?>
