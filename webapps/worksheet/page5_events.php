<?php
//BindEvents Method @1-721FDD1B
function BindEvents()
{
    global $service_tbl1;
    $service_tbl1->Button_Delete->CCSEvents["OnClick"] = "service_tbl1_Button_Delete_OnClick";
}
//End BindEvents Method

//service_tbl1_Button_Delete_OnClick @40-C93105BB
function service_tbl1_Button_Delete_OnClick(& $sender)
{
    $service_tbl1_Button_Delete_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $service_tbl1; //Compatibility
//End service_tbl1_Button_Delete_OnClick

//Custom Code @114-2A29BDB7
// -------------------------
    require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

	$order = $_SESSION['ORDER'];

	$sql = "DELETE FROM service_items_tbl WHERE ORDER_NO='$order'";
	$result = $db->query($sql);

// -------------------------
//End Custom Code

//Close service_tbl1_Button_Delete_OnClick @40-3B057DF8
    return $service_tbl1_Button_Delete_OnClick;
}
//End Close service_tbl1_Button_Delete_OnClick


?>
