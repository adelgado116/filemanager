<?php
//BindEvents Method @1-8F5FC413
function BindEvents()
{
    global $service_tbl;
    $service_tbl->CCSEvents["BeforeShow"] = "service_tbl_BeforeShow";
}
//End BindEvents Method

//service_tbl_BeforeShow @23-FB3BE187
function service_tbl_BeforeShow(& $sender)
{
    $service_tbl_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $service_tbl; //Compatibility
//End service_tbl_BeforeShow

//Custom Code @47-2A29BDB7
// -------------------------
    
	$_SESSION['ORDER'] = $_REQUEST['ORDER_NO'];  // used for identification throughout the application steps
	$_SESSION['IMO'] = $_REQUEST['IMO_NUMBER'];
	$_SESSION['SHIPNAME'] = $_REQUEST['SHIPNAME'];
	
	$order = $_SESSION['ORDER'];

 
	require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


    	if ( strchr( $_SERVER['HTTP_REFERER'], "http://freja/webapps/worksheet/page1.php" ) ) {

		$imo = $_REQUEST['IMO_NUMBER'];
		$ship = $_REQUEST['SHIPNAME'];

		$debtor = $_REQUEST['SALESNAME'];
		$requisition = $_REQUEST['REQUISNUMBER'];
		$account = $_REQUEST['DEBTORACCOUNT'];

		$sql = "UPDATE service_tbl
				SET DEBTOR='$debtor', REQUISNUMBER='$requisition', DEBTORACCOUNT='$account'
				WHERE ORDER_NO='$order'";
		$result_2 = $db->query($sql);


		////////////////////////////////////////////////////////////////////////////////
		// check if the ship exists in local database
		// if not, add it to ships_tbl or update the existing data.
		////////////////////////////////////////////////////////////////////////////////
		$path_suffix = "../../knowledgebase/$imo";
		
		$sql = "SELECT * FROM ships_tbl WHERE IMO_NUMBER='$imo'";
		$res1 = $db->query($sql);
		
		if ( $res1->size() != 1 ) {
		    $sql = "INSERT INTO ships_tbl ( IMO_NUMBER, SHIP_NAME, location_in_server ) VALUES ( '$imo', '$ship', '$path_suffix' )";
		    $res2 = $db->query($sql);
		} else if ( $res1->size() == 1 ) {
		    $sql = "UPDATE ships_tbl SET SHIP_NAME='$ship' WHERE IMO_NUMBER='$imo'";
		    $res2 = $db->query($sql);
		}
	

		# check if the <imo>/ folders structure exists		
		if ( !file_exists( $path_suffix ) ) {
		
			mkdir( $path_suffix, 0777 );
			mkdir( $path_suffix."/".$_REQUEST['ORDER_NO'], 0777 );
			mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/worksheet", 0777 );
			mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/service_report", 0777 );
			mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/additional_docs", 0777 );
			mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/pictures", 0777 );
			
			mkdir( $path_suffix."/GENERAL_INFO", 0777 );
			mkdir( $path_suffix."/GENERAL_INFO/drawings", 0777 );
			mkdir( $path_suffix."/GENERAL_INFO/others", 0777 );
			mkdir( $path_suffix."/GENERAL_INFO/pictures", 0777 );
			
			
		} else {
	
			if ( !file_exists( $path_suffix."/".$_REQUEST['ORDER_NO'] ) ) {

				mkdir( $path_suffix."/".$_REQUEST['ORDER_NO'], 0777 );
				mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/worksheet", 0777 );
				mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/service_report", 0777 );
				mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/additional_docs", 0777 );
				mkdir( $path_suffix."/".$_REQUEST['ORDER_NO']."/pictures", 0777 );
			}
		}

	}	// end of:   if ( $_SERVER['HTTP_REFERRER'] == "page1.php" ) {



	/////////////////////////////////////////////////////////////
	// check if this worksheet (order) is already opened
	/////////////////////////////////////////////////////////////

	$sql = "SELECT * FROM service_tbl WHERE ORDER_NO='$order'";
	$result = $db->query($sql);
	
	if ( $result->size() == 1 ) {

		$row = $result->fetch();

		if ( $row['STATUS_ID'] == 1 ) {

			header("Location: page5.php");

		} else if ( $row['STATUS_ID'] == 2 || $row['STATUS_ID'] == 3 ) {

			//header("Location: page5_2.php");
			header("Location: page5.php");
		}

	}

// -------------------------
//End Custom Code

//Close service_tbl_BeforeShow @23-703537D9
    return $service_tbl_BeforeShow;
}
//End Close service_tbl_BeforeShow


?>
