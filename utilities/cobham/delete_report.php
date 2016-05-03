<?php

#
#  delete the file indicated by "del" variable coming from page2.php
#
if ( isset($_REQUEST['del']) ) {
	
	if ( file_exists($_REQUEST['del']) ) {
	
		unlink ($_REQUEST['del']);
		$success = TRUE;
	} else {
	}
}

header("Location: index.php");

?>