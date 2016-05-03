<?php


#
#  input from previous page have to be filtered here to make sure it is EXIT !!!
#

	if ( $_REQUEST['command'] == "EXIT" ) {
	
		header( 'Location: 1.php' );
	}	

?>
