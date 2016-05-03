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

//Custom Code @59-2A29BDB7
// -------------------------

	echo '<table border="0" width="100%">';
	echo '<tr>';
    echo '<td><strong><font color="#000066" size="6">Evaluations from Customer</font></strong></td>';
	echo '<td>';
	echo '<div align="right"><a href="page1_1.php?ORDER_NO='.$_REQUEST['ORDER_NO'].'" ><strong>ADD AN ENTRY</strong></a></div>';
    echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td><strong><font color="#000066" size="5">Order No.:&nbsp;&nbsp;'.$_REQUEST['ORDER_NO'].'</font></strong></td>';
	echo '<td></td>';
	echo '</tr>';
	echo '</table>';
	echo '<br/>';
	
	//echo $_SESSION['order'];

// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
