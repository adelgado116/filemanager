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

//Custom Code @33-2A29BDB7
// -------------------------

    require_once('Database/MySQL.php');
	
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
	
	$sql = "TRUNCATE TABLE ws_dummy";
	$result = $db->query($sql);  // table has been cleaned up

// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
