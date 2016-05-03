<?php


#
#  connect to database
#
include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

#
#  check if service Order exists on service_tbl
#
$serviceOrder = $_REQUEST['serviceOrder'];

$sql = "SELECT * FROM service_tbl WHERE ORDER_NO='$serviceOrder'";
$res1 = mysql_query($sql) or die('Query failed [check for existing service order]: ' . mysql_error());

if ( mysql_num_rows($res1) == 1 ) {

	echo "one record found";
			
	$sql = "
			SELECT service_tbl.IMO_NUMBER, service_tbl.REQUISNUMBER, ships_tbl.SHIP_NAME, ports_tbl.PORT_NAME, agents_tbl.AGENT_NAME,
					equipment_model_tbl.EQUIP_MODEL, equipment_manufacturer_tbl.MANUF_NAME, equipment_type_tbl.EQUIP_TYPE, service_items_tbl.REQUEST
			FROM service_tbl, ships_tbl, ports_tbl, agents_tbl, service_items_tbl, equipment_model_tbl, equipment_manufacturer_tbl, equipment_type_tbl
			WHERE service_tbl.ORDER_NO = '$serviceOrder'
			AND ships_tbl.IMO_NUMBER = service_tbl.IMO_NUMBER
			AND ports_tbl.PORT_ID = service_tbl.PORT_ID
			AND agents_tbl.AGENT_ID = service_tbl.AGENT_ID
			AND service_items_tbl.ORDER_NO = service_tbl.ORDER_NO
			AND equipment_model_tbl.EQUIP_ID = service_items_tbl.EQUIP_ID
			AND equipment_manufacturer_tbl.MANUF_ID = equipment_model_tbl.MANUF_ID
			AND equipment_type_tbl.EQUIP_TYPE_ID = equipment_model_tbl.EQUIP_TYPE_ID
			";
	
} else {

	echo "no records found";
}


?>

