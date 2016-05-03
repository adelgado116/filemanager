<?php
//BindEvents Method @1-D67F7610
function BindEvents()
{
    global $tools;
    $tools->Button_Update->CCSEvents["OnClick"] = "tools_Button_Update_OnClick";
}
//End BindEvents Method

//tools_Button_Update_OnClick @3-5B566814
function tools_Button_Update_OnClick(& $sender)
{
    $tools_Button_Update_OnClick = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools; //Compatibility
//End tools_Button_Update_OnClick

//Custom Code @37-2A29BDB7
// -------------------------
    ?>
	window.close();
	<?php
// -------------------------
//End Custom Code

//Close tools_Button_Update_OnClick @3-5DFEF545
    return $tools_Button_Update_OnClick;
}
//End Close tools_Button_Update_OnClick


?>
