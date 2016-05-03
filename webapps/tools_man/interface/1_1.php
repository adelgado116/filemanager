<?php
/*
echo $_REQUEST['user_id'];
exit(1);
*/

$idstring = array();
$idstring = explode( '_', $_REQUEST['user_id'] );


if ( $idstring[0] == "IDEMP" ) {  // check for valid barcode input

	$user = strstr( $_REQUEST['user_id'], '_' );
	
	$user_id = array();
	$user_id = explode( '_', $user );
	
	header( 'Location: 2.php?user_id='.$user_id[1] );  // redirect to next page and pass the user id number only

} else if ( $_REQUEST['user_id'] == "MESSAGE" ) {

	header( 'Location: show_messages.php' );
	
} else if ( $idstring[0] == "HSS" ) {  // check selected barcode to see if tool exists

	$tool = strstr( $_REQUEST['user_id'], 'D' );  // extract this tool's id

	$tool_id = array();
	$tool_id = explode( 'D', $tool );

	$tool = $tool_id[1];
	
	header( "Location: check_tool_existence.php?tool_id=$tool" );
	
} else {

	header( 'Location: 1.php' );  // wrong barcode type selected, keep user on same page
}

?>