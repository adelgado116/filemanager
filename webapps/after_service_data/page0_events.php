<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-D9849F0B
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $page0; //Compatibility
//End Page_BeforeShow

//Custom Code @91-2A29BDB7
// -------------------------
    /*echo "UserID = ".$_SESSION['UserID'];
	echo "<br/>";
	echo "UserLogin = ".$_SESSION['UserLogin'];
	echo "<br/>";
	echo "GroupID = ".$_SESSION['GroupID'];*/
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
