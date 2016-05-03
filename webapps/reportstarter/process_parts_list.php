<?php


# DO NOT DISPLAY ERRORS, WARNINGS OR NOTICES.
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

require_once('functions_hssiso.php');
include('dbConnect_hssiso.inc');


if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}


$serviceOrder = strtoupper($_REQUEST['serviceOrder']);


############################
#  PROCESS SUBMITTED DATA  #
############################

# CHECK IF THERE IS A RECORD FOR THIS SERVICE ORDER IN report_starter TABLE

$sql = "SELECT * FROM report_starter WHERE serviceOrder = '$serviceOrder'";

$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
$rowsQty = mysql_num_rows($result);

if ( $rowsQty == 1 ) {

	# UPDATE SERVICE PARTICULARS (CHANGES APPLIED TO WORKSHEET)
	# get particulars from Worksheet data
	$sql = "
			SELECT service_tbl.IMO_NUMBER, service_tbl.REQUISNUMBER, ships_tbl.SHIP_NAME, ports_tbl.PORT_NAME, agents_tbl.AGENT_NAME,
					equipment_model_tbl.EQUIP_MODEL, equipment_manufacturer_tbl.MANUF_NAME, equipment_type_tbl.EQUIP_TYPE, service_items_tbl.REQUEST,
					service_type_tbl.SERVICE_TYPE
			FROM service_tbl, ships_tbl, ports_tbl, agents_tbl, service_items_tbl, equipment_model_tbl, equipment_manufacturer_tbl, equipment_type_tbl,
				 service_type_tbl
			WHERE service_tbl.ORDER_NO = '$serviceOrder'
			AND ships_tbl.IMO_NUMBER = service_tbl.IMO_NUMBER
			AND ports_tbl.PORT_ID = service_tbl.PORT_ID
			AND agents_tbl.AGENT_ID = service_tbl.AGENT_ID
			AND service_items_tbl.ORDER_NO = service_tbl.ORDER_NO
			AND equipment_model_tbl.EQUIP_ID = service_items_tbl.EQUIP_ID
			AND equipment_manufacturer_tbl.MANUF_ID = equipment_model_tbl.MANUF_ID
			AND equipment_type_tbl.EQUIP_TYPE_ID = equipment_model_tbl.EQUIP_TYPE_ID
			AND service_type_tbl.SERVICE_TYPE_ID = service_items_tbl.SERVICE_TYPE_ID
			";
			
	$result0 = mysql_query($sql) or die('Query failed [getting particulars]: ' . mysql_error());
	
	$table_row = array();
	$table_row = get_table($result0);
	
	
	$vessel = $table_row[0]['SHIP_NAME'];
	$imo = $table_row[0]['IMO_NUMBER'];
	$place = $table_row[0]['PORT_NAME'];
	$agent = $table_row[0]['AGENT_NAME'];
	$customerOrder = $table_row[0]['REQUISNUMBER'];
	$typeOfService = $table_row[0]['SERVICE_TYPE'];
	$equipment = $table_row[0]['MANUF_NAME'].' - '.$table_row[0]['EQUIP_TYPE'].' - '.$table_row[0]['EQUIP_MODEL'];
	$request = $table_row[0]['REQUEST'];
	
	# update possible changes for this order in report_starter  -- (changes made to the worksheet)
	$sql = "UPDATE report_starter
			SET vesselName = '$vessel', imo = '$imo', place = '$place', agent = '$agent',
				customerOrder = '$customerOrder', typeOfService = '$typeOfService', equipment = '$equipment', serviceRequest = '$request'
				WHERE serviceOrder = '$serviceOrder'";
	$result05 = mysql_query($sql) or die('Query failed [inserting new report]: ' . mysql_error());



	# apply changes into corresponding tables
	for ( $rowNumb = 0; $rowNumb <= 24; $rowNumb++ ) {
		
		$rec_id = $_REQUEST['record_id'.$rowNumb];
		$qty = $_REQUEST['quantity'.$rowNumb];
		$partNo = strtoupper( $_REQUEST['partNumber'.$rowNumb] );
		$sn = strtoupper( $_REQUEST['serialNumber'.$rowNumb] );
		$desc = strtoupper( $_REQUEST['partDescription'.$rowNumb] );
		
		
		if ( $rec_id == "" ) {   // this means row remained empty after data retrieval from "report_partslist", try to create new record
		
			
			// check all fields looking for values and save them if present
			if ( $qty != "" || $qty != 0 ) {
			
				if ( $partNo != "" ) {
				
					if ( $sn != "" || $sn == $partNo ) {
					
						if ( $desc != "" ) {
						
							$sql = "INSERT INTO report_partslist (serviceOrder, quantity, partNumber, serialNumber, description)
									VALUES ('$serviceOrder', '$qty', '$partNo', '$sn', '$desc')";
							$result3 = mysql_query($sql) or die('Query failed [inserting new part]: ' . mysql_error());
						}
					}
				}
			}
			
			
		} else {
		
			$sql = "SELECT * FROM report_partslist WHERE record_id = '$rec_id'";
			$result1 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
			$rowsQty1 = mysql_num_rows($result);
			
			if ( $rowsQty1 == 1 ) {  // record_id exists
				
			
				if ( $_REQUEST['delete'.$rowNumb] == 1 ) {  // delete this record if requested
				
					$sql = "DELETE FROM report_partslist
							WHERE record_id = '$rec_id'";
							
					mysql_query($sql) or die('Query 2 failed: ' . mysql_error());
					
				} else {   // UPDATE this record data
					
					$sql = "UPDATE report_partslist
							SET quantity='$qty', partNumber='$partNo', serialNumber='$sn', description='$desc'
							WHERE record_id='$rec_id'";
				
					$result2 = mysql_query($sql) or die('Query failed [updating existing part]: ' . mysql_error());
				}
				
			}	
		}
	}
	
	$status = 'Report Updated successfully !';
	
} else {   // report does not exist
	
	# get particulars from Worksheet data
	$sql = "
			SELECT service_tbl.IMO_NUMBER, service_tbl.REQUISNUMBER, ships_tbl.SHIP_NAME, ports_tbl.PORT_NAME, agents_tbl.AGENT_NAME,
					equipment_model_tbl.EQUIP_MODEL, equipment_manufacturer_tbl.MANUF_NAME, equipment_type_tbl.EQUIP_TYPE, service_items_tbl.REQUEST,
					service_type_tbl.SERVICE_TYPE
			FROM service_tbl, ships_tbl, ports_tbl, agents_tbl, service_items_tbl, equipment_model_tbl, equipment_manufacturer_tbl, equipment_type_tbl,
				 service_type_tbl
			WHERE service_tbl.ORDER_NO = '$serviceOrder'
			AND ships_tbl.IMO_NUMBER = service_tbl.IMO_NUMBER
			AND ports_tbl.PORT_ID = service_tbl.PORT_ID
			AND agents_tbl.AGENT_ID = service_tbl.AGENT_ID
			AND service_items_tbl.ORDER_NO = service_tbl.ORDER_NO
			AND equipment_model_tbl.EQUIP_ID = service_items_tbl.EQUIP_ID
			AND equipment_manufacturer_tbl.MANUF_ID = equipment_model_tbl.MANUF_ID
			AND equipment_type_tbl.EQUIP_TYPE_ID = equipment_model_tbl.EQUIP_TYPE_ID
			AND service_type_tbl.SERVICE_TYPE_ID = service_items_tbl.SERVICE_TYPE_ID
			";
			
	$result4 = mysql_query($sql) or die('Query failed [getting particulars]: ' . mysql_error());
	
	$table_row = array();
	$table_row = get_table($result4);
	
	
	$vessel = $table_row[0]['SHIP_NAME'];
	$imo = $table_row[0]['IMO_NUMBER'];
	$place = $table_row[0]['PORT_NAME'];
	$agent = $table_row[0]['AGENT_NAME'];
	$customerOrder = $table_row[0]['REQUISNUMBER'];
	$typeOfService = $table_row[0]['SERVICE_TYPE'];
	$equipment = $table_row[0]['MANUF_NAME'].' - '.$table_row[0]['EQUIP_TYPE'].' - '.$table_row[0]['EQUIP_MODEL'];
	$request = $table_row[0]['REQUEST'];
	
	
	
	
	# create new record for this order in report_starter
	$sql = "INSERT INTO report_starter (serviceOrder, vesselName, imo, place, agent, customerOrder, typeOfService, equipment, serviceRequest)
			VALUES ('$serviceOrder', '$vessel', '$imo', '$place', '$agent', '$customerOrder', '$typeOfService', '$equipment', '$request' )";
	$result5 = mysql_query($sql) or die('Query failed [inserting new report]: ' . mysql_error());
	
	# insert parts data into report_parts_list
	for ( $rowNumb = 0; $rowNumb <= 19; $rowNumb++ ) {
		
		if ( $_REQUEST['quantity'.$rowNumb] == '' || $_REQUEST['quantity'.$rowNumb] == 0 ) {
		
			; // do nothing
			
		} else {
		
		
			$qty = $_REQUEST['quantity'.$rowNumb];
			$partNo = strtoupper( $_REQUEST['partNumber'.$rowNumb] );
			$sn = strtoupper( $_REQUEST['serialNumber'.$rowNumb] );
			$desc = strtoupper( $_REQUEST['partDescription'.$rowNumb] );
			
			$sql = "INSERT INTO report_partslist (serviceOrder, quantity, partNumber, serialNumber, description) VALUES ('$serviceOrder', '$qty', '$partNo', '$sn', '$desc')";
			$result6 = mysql_query($sql) or die('Query failed [inserting new part]: ' . mysql_error());
		}
	}
	
	$status = 'New Report created<br/>on Database';
}


# display the same page once again with new values from database
header( 'Location: parts_list.php?serviceOrder='.$_REQUEST['serviceOrder'].'&status='.$status );

