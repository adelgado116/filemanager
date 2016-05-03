<?php
//BindEvents Method @1-F5E07FD6
function BindEvents()
{
    global $Link2;
    global $CCSEvents;
    $Link2->CCSEvents["BeforeShow"] = "Link2_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Link2_BeforeShow @2-F04391AF
function Link2_BeforeShow(& $sender)
{
    $Link2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Link2; //Compatibility
//End Link2_BeforeShow

//Custom Code @3-2A29BDB7
// -------------------------
    // Write your own code here.
// -------------------------
//End Custom Code

//Close Link2_BeforeShow @2-4AE96129
    return $Link2_BeforeShow;
}
//End Close Link2_BeforeShow

//Page_BeforeShow @1-F916E340
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page7; //Compatibility
//End Page_BeforeShow

//Custom Code @88-2A29BDB7
// -------------------------
    
	// verify if data has been imported from tech's laptop.

	if ( strchr( $_SERVER['HTTP_REFERER'], "http://odin/webapps/worksheet/page5.php" ) ) {

		$order = $_REQUEST['ORDER_NO'];
		$item = $_REQUEST['ITEM_NO'];

		require_once('Database/MySQL.php');
		$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


		$sql = "SELECT * FROM service_done_by_tbl WHERE ORDER_NO='$order' AND ITEM_NO='$item'";
		$res_1 = $db->query($sql);
	

		if ( $res_1->size() >= 1 ) {

			;

		} else {
		
			

			header("Location: no_after_service_msg.html");

			exit();
		}
	}


// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
