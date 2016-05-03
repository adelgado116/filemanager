<?php
//BindEvents Method @1-D26FA1C0
function BindEvents()
{
    global $tools;
    $tools->CCSEvents["BeforeShow"] = "tools_BeforeShow";
}
//End BindEvents Method

//tools_BeforeShow @2-BCB962D5
function tools_BeforeShow(& $sender)
{
    $tools_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $tools; //Compatibility
//End tools_BeforeShow

//Custom Code @32-2A29BDB7
// -------------------------
    if ( isset( $_REQUEST['tool_id'] ) == TRUE ) {

	    $tools->Visible = False;

		echo 'es para editar contenido existente';
	}
// -------------------------
//End Custom Code

//Close tools_BeforeShow @2-60B61409
    return $tools_BeforeShow;
}
//End Close tools_BeforeShow


?>
