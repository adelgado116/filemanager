<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-5E225448
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page1; //Compatibility
//End Page_BeforeShow

//Custom Code @45-2A29BDB7
// -------------------------
    
	switch ( $_REQUEST['ORDER_NO'] ) {
	case 'SD_rec':
		$record_id = $_REQUEST['record_id'];
		header( "Location: page2.php?record_id=$record_id" );
		break;
	case 'TO_SK':
		$record_id = $_REQUEST['record_id'];
		header( "Location: page3.php?record_id=$record_id" );
		break;
	}
	/*
	if ( $_REQUEST['ORDER_NO'] == 'TO_SK' ) {

		$record_id = $_REQUEST['record_id'];
		header( "Location: page3.php?record_id=$record_id" );
		exit();
	}
	*/
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
