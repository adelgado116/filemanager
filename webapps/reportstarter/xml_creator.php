<?php


require_once('functions_hssiso.php');
include('dbConnect_hssiso.inc');


if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}


$serviceOrder = $_REQUEST['serviceOrder'];


# get list of email addresses from techs
$result = mysql_query( "SELECT * FROM employees_tbl", $link_id );
$table = get_table( $result );



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
$customer_order = $table_row[0]['REQUISNUMBER'];
$type_of_service = $table_row[0]['SERVICE_TYPE'];
$equipment_name = $table_row[0]['MANUF_NAME'].' - '.$table_row[0]['EQUIP_TYPE'].' - '.$table_row[0]['EQUIP_MODEL'];
$request = $table_row[0]['REQUEST'];



# get spare parts list from "report_partslist" table
$sql = "
		SELECT * FROM report_partslist
		WHERE serviceOrder = '$serviceOrder'
		";
		
$result1 = mysql_query($sql) or die('Query failed [getting particulars]: ' . mysql_error());

$table1_row = array();
$table1_row = get_table($result1);




$doc = new DOMDocument('1.0', 'ISO-8859-1');
$doc->formatOutput = true;

$report = $doc->createElement( "report" );
$doc->appendChild( $report );

$orderNumber = $doc->createElement( "orderNumber" );
$orderNumber->appendChild( $doc->createTextNode( $serviceOrder ) );
$report->appendChild( $orderNumber );

$producer = $doc->createElement( "producer" );
$report->appendChild( $producer );  // empty node

$editor = $doc->createElement( "editor" );
$report->appendChild( $editor );

$vesselName = $doc->createElement( "vesselName" );
$enc_vesselName = utf8_encode( $vessel );
$vesselName->appendChild( $doc->createTextNode( "$enc_vesselName" ) );
$report->appendChild( $vesselName );

$imoNumber = $doc->createElement( "imoNumber" );
$imoNumber->appendChild( $doc->createTextNode( $imo ) );
$report->appendChild( $imoNumber );

$mmsiNumber = $doc->createElement( "mmsiNumber" );
$report->appendChild( $mmsiNumber );

$callSign = $doc->createElement( "callSign" );
$report->appendChild( $callSign );

$vesselOwner = $doc->createElement( "vesselOwner" );
$report->appendChild( $vesselOwner );

$satcomNumber = $doc->createElement( "satcomNumber" );
$report->appendChild( $satcomNumber );

$portPlace = $doc->createElement( "portPlace" );
$enc_place = utf8_encode( $place );
$portPlace->appendChild( $doc->createTextNode( "$enc_place" ) );
$report->appendChild( $portPlace );

$shipAgent = $doc->createElement( "shipAgent" );
$enc_agent = utf8_encode( $agent );
$shipAgent->appendChild( $doc->createTextNode( "$enc_agent" ) );
$report->appendChild( $shipAgent );

$requestedBy = $doc->createElement( "requestedBy" );
$report->appendChild( $requestedBy );

$customerOrder = $doc->createElement( "customerOrder" );
$enc_customer_order = utf8_encode( $customer_order );
$customerOrder->appendChild( $doc->createTextNode( "$enc_customer_order" ) );
$report->appendChild( $customerOrder );

$typeOfService = $doc->createElement( "typeOfService" );
$typeOfService->appendChild( $doc->createTextNode( $type_of_service ) );
$report->appendChild( $typeOfService );

$followUp = $doc->createElement( "followUp" );
$followUp->appendChild( $doc->createTextNode( "NO" ) );
$report->appendChild( $followUp );

$equipment = $doc->createElement( "equipment" );
$equipment->appendChild( $doc->createTextNode( $equipment_name ) );
$report->appendChild( $equipment );

$serialNumber = $doc->createElement( "serialNumber" );
$report->appendChild( $serialNumber );

$hardwareVersion = $doc->createElement( "hardwareVersion" );
$report->appendChild( $hardwareVersion );

$softwareVersionFound = $doc->createElement( "softwareVersionFound" );
$report->appendChild( $softwareVersionFound );

$softwareVersionUpdated = $doc->createElement( "softwareVersionUpdated" );
$report->appendChild( $softwareVersionUpdated );

$serviceRequest = $doc->createElement( "serviceRequest" );
$enc_request = utf8_encode( $request );
$serviceRequest->appendChild( $doc->createTextNode( "$enc_request" ) );
$report->appendChild( $serviceRequest );

$actionsTaken = $doc->createElement( "actionsTaken" );
$report->appendChild( $actionsTaken );

$finalStatus = $doc->createElement( "finalStatus" );
$report->appendChild( $finalStatus );

$remarks = $doc->createElement( "remarks" );
$report->appendChild( $remarks );

$abroad = $doc->createElement( "abroad" );
$report->appendChild( $abroad );
  
  
  
$spareParts = $doc->createElement( "spareParts" );
  
if ( sizeof( $table1_row ) < 1 ) {

	$item = $doc->createElement( "item" );
	
	$partUsed = $doc->createElement( "partUsed" );
	$partUsed->appendChild( $doc->createTextNode( "false" ) );
	$item->appendChild( $partUsed );
	
	$quantity = $doc->createElement( "quantity" );
	$quantity->appendChild( $doc->createTextNode( "0" ) );
	$item->appendChild( $quantity );
	
	$description = $doc->createElement( "description" );
	$item->appendChild( $description );
	
	$partNumber = $doc->createElement( "partNumber" );
	$item->appendChild( $partNumber );
	
	$snNew = $doc->createElement( "snNew" );
	$item->appendChild( $snNew );
	
	$snDefective = $doc->createElement( "snDefective" );
	$item->appendChild( $snDefective );
	
	$partLeftOnboard = $doc->createElement( "partLeftOnboard" );
	$partLeftOnboard->appendChild( $doc->createTextNode( "false" ) );
	$item->appendChild( $partLeftOnboard );
	
	$spareParts->appendChild( $item );
	
} else {

	for ( $i = 0; $i <= ( sizeof( $table1_row ) - 1 ); $i++ ) {
	
		$item = $doc->createElement( "item" );
	
		$partUsed = $doc->createElement( "partUsed" );
		$partUsed->appendChild( $doc->createTextNode( "false" ) );
		$item->appendChild( $partUsed );
		
		$quantity = $doc->createElement( "quantity" );
		$quantity->appendChild( $doc->createTextNode( $table1_row[$i]['quantity'] ) );
		$item->appendChild( $quantity );
		
		$description = $doc->createElement( "description" );
		$description->appendChild( $doc->createTextNode( $table1_row[$i]['description'] ) );
		$item->appendChild( $description );
		
		$partNumber = $doc->createElement( "partNumber" );
		$partNumber->appendChild( $doc->createTextNode( $table1_row[$i]['partNumber'] ) );
		$item->appendChild( $partNumber );
		
		$snNew = $doc->createElement( "snNew" );
		$snNew->appendChild( $doc->createTextNode( $table1_row[$i]['serialNumber'] ) );
		$item->appendChild( $snNew );
		
		$snDefective = $doc->createElement( "snDefective" );
		$item->appendChild( $snDefective );
		
		$partLeftOnboard = $doc->createElement( "partLeftOnboard" );
		$partLeftOnboard->appendChild( $doc->createTextNode( "false" ) );
		$item->appendChild( $partLeftOnboard );
		
		$spareParts->appendChild( $item );
	}
}

$report->appendChild( $spareParts );


$techs = $doc->createElement( "techs" );
$tech = $doc->createElement( "tech" );

$date = $doc->createElement( "date" );
$date->appendChild( $doc->createTextNode( date("d.m.Y") ) );
$tech->appendChild( $date );

$techName = $doc->createElement( "techName" );
$tech->appendChild( $techName );

$travel_1_Start = $doc->createElement( "travel_1_Start" );
$tech->appendChild( $travel_1_Start );

$travel_1_End = $doc->createElement( "travel_1_End" );
$tech->appendChild( $travel_1_End );

$workStart = $doc->createElement( "workStart" );
$tech->appendChild( $workStart );

$workEnd = $doc->createElement( "workEnd" );
$tech->appendChild( $workEnd );

$travel_2_Start = $doc->createElement( "travel_2_Start" );
$tech->appendChild( $travel_2_Start );

$travel_2_End = $doc->createElement( "travel_2_End" );
$tech->appendChild( $travel_2_End );

$waiting = $doc->createElement( "waiting" );
$waiting->appendChild( $doc->createTextNode( "0" ) );
$tech->appendChild( $waiting );

$comment = $doc->createElement( "comment" );
$tech->appendChild( $comment );

$techs->appendChild( $tech );
$report->appendChild( $techs );


//echo $doc->saveXML();
$path = '../../knowledgebase/'.$imo.'/'.$serviceOrder.'/worksheet/';

if ( $doc->save( $path.$serviceOrder.".xml" ) == false ) {

	echo "<br/><br/> error creating XML file.<br/>contact administrator.";
	exit();
	
} else {

	// ZIP the resulting xml file.
	
}


# show page with download option and field to send automatic attachment to several email addresses
# |
# |
# X
# |
# |

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>High Sea Support - Service Report Tool </title>
	<link href="css/dashboard.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
	
<div id="content"> 

<!--
<div id="title">
	
</div>
-->

  <form name="form" action="send_xml.php" method="post" target="iframe2">
    <div id="left"> 
      <div class="font9"> 
        
		<table border="0">
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td colspan="2"><h2>An XML report file has been created for:</h2></td>
			
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td>Service Order:</td>
			<td>
				<?php echo $serviceOrder; ?>
				<input type="hidden"
					   name="serviceOrder"
					   value="<?php echo $serviceOrder; ?>" />
					   
				<input type="hidden"
					   name="path"
					   value="<?php echo $path; ?>" />	   
			</td>
		</tr>
		<tr>
			<td>Vessel:</td>
			<td>
				<?php echo $vessel; ?>
				<input type="hidden"
					   name="vesselName"
					   value="<?php echo $vessel; ?>" />
			</td>
		</tr>
		<tr>
			<td>IMO:</td>
			<td><?php echo $imo; ?></td>
		</tr>
		<tr>
			<td>Type of Service:</td>
			<td><?php echo $type_of_service; ?></td>
		</tr>
		<tr>
			<td>Equipment:</td>
			<td><?php echo $equipment_name; ?></td>
		</tr>
				
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td>SAVE XML file to:</td>
			<td><a href="<?php echo $path.$serviceOrder.'.xml' ?>" ><?php echo $serviceOrder.'.xml'; ?></a> &nbsp; [Right-click and Save As...]</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td>SEND XML file to:</td>
			<td>
				<select name="select_tech1">
					
					<option value="empty"></option>
				<?php
				for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
				
					?>
					<option value="<?php echo $table[$i]['email']; ?>"><?php echo $table[$i]['emp_login'] ?></option>
					<?php
				}
				?>
				</select>
				
				<select name="select_tech2">
				
					<option value="empty"></option>
				<?php
				for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
				
					?>
					<option value="<?php echo $table[$i]['email']; ?>"><?php echo $table[$i]['emp_login'] ?></option>
					<?php
				}
				?>
				</select>
				
				<select name="select_tech3">
				
					<option value="empty"></option>
				<?php
				for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
				
					?>
					<option value="<?php echo $table[$i]['email']; ?>"><?php echo $table[$i]['emp_login'] ?></option>
					<?php
				}
				?>
				</select>
				
				<select name="select_tech4">
				
					<option value="empty"></option>
				<?php
				for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
				
					?>
					<option value="<?php echo $table[$i]['email']; ?>"><?php echo $table[$i]['emp_login'] ?></option>
					<?php
				}
				?>
				</select>  
				
			</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><button class="button" type="submit" name="send" id="send" value="send">send file</button></td>
		</tr>
		</table>
      </div>
      <!-- <div class="font9"> -->
    </div>
    <!-- <div id="left"> -->
        
  </form>
</div>
<!-- <div id="content">  -->
		
</body>

</html>
