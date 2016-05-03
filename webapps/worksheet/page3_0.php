<?php

$equip_model = $_REQUEST['EQUIP_MODEL'];
$order = $_REQUEST['ORDER_NO'];
$equip_id = $_REQUEST['EQUIP_ID'];


$special_equipments = array('1', '3', '29', '39', '42', '48', '62', '90', '147');
// 1 = ssas, 3 = mer-vdr, 29 = std4, 39 = debeg4300, 42 = std20, 48 = std22, 62 = std14, 90 = debeg4310, 147 = gyrostar2

for ( $i = 0; $i <= ( sizeof( $special_equipments ) - 1); $i++ ) {

	if ( $equip_id == $special_equipments[ $i ] ) {
	
		header("Location: page3_0_1.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id");
		exit();
		
	}
}

// no matches, continue as normal
header("Location: page4.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id");


/*
if ( ($equip_id == '1') || ($equip_id == '29') ) {

	header("Location: page3_0_1.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id");
	
} else {

	header("Location: page4.php?EQUIP_MODEL=$equip_model&ORDER_NO=$order&EQUIP_ID=$equip_id");
}
*/

?>