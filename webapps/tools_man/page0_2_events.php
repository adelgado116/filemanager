<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-BB978568
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page0_2; //Compatibility
//End Page_BeforeShow

//Custom Code @50-2A29BDB7
// -------------------------
	
	require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
	
	$tid = $_REQUEST['tool_id'];

	$sql = "SELECT tool_description FROM tools WHERE tool_id='$tid'";
	$res = $db->query($sql);
	$row = $res->fetch();

	echo '<font size="+2" color="blue"><b>Accessories for: '.$row['tool_description'].'</b></font>';
	echo '<br/>';
	//echo '<a href"p.php">ADD NEW ACCESSORY</a>';

    //$_SESSION['TOOL_ID'] = $_REQUEST['tool_id'];
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
