<?php


if ( strchr( $_SERVER['HTTP_REFERER'], "http://freja/webapps/file_manager/page0_home.html" ) ) {
	$return_to_page = "page0_home.html";
} else {
	$return_to_page = "page0_home.html";
}



$tabNumber = $_REQUEST['TAB'];

#
#  delete the file indicated by "del" variable coming from page0.html
#
if ( isset($_REQUEST['del']) ) {
	
	if ( file_exists($_REQUEST['del']) ) {
	
		unlink ($_REQUEST['del']);
		$success = TRUE;
	} else {
	}
}

header("Location: ".$return_to_page."#tabs-$tabNumber");



?>
