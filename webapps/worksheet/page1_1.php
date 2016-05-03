<?php

session_start();

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page1</title>
<meta content="CodeCharge Studio 4.01.00.06" name="GENERATOR">
<link href="Styles/hss1/Style_doctype.css" type="text/css" rel="stylesheet">
</head>
<body>
<p>
<table width="100%" border="0">
  <tr>
    <td>
      <strong><font color="#000066" size="6">Re-Assign Order No</font></strong>
    </td>
    <td>
      <div align="right">
           <a href="page5.php"><strong>BACK TO WORKSHEET REVIEW</strong></a>
      </div>
    </td>
  </tr>
</table>
</p>

<br/>

<?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">


<!-- BEGIN Grid -->
<table cellspacing="0" cellpadding="0" border="0">
<tr>
	<td valign="top">
		<table class="Header" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td class="HeaderLeft"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
			<td class="th"><strong>Enter New Order No.</strong></td>
			<td class="HeaderRight"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
		</tr>
		</table>
		<table class="Grid" cellspacing="0" cellpadding="0">
		<tr class="Caption">
			<th scope="col">CURRENT ORDER NO</th>
			<th scope="col">NEW ORDER NO</th>
		</tr>
		<tr class="Row">
			<td><input name="current_order_no" maxlength="6" value="<?php echo $_SESSION['ORDER']; ?>" readonly="" /></td>
			<td><input name="new_order_no" maxlength="6" /></td>
		</tr>
		<tr class="Footer">
			<td colspan="2"><div align="right"><input class="Button" type="submit" value="Apply Change" /></div></td>
		</tr>
		</table>
	</td>
</tr>
</table>

</form>



<?php 

} else {

	#################################
	# PROCESS THE SUBMITTED DATA
	#################################
	
	$old_order_no = $_REQUEST['current_order_no'];
	$new_order_no = $_REQUEST['new_order_no'];
	
	
	if ( $_REQUEST['new_order_no'] == '' ) {
	
		echo '<br/><br/><br/><h2>You have sent an empty form.<br/>No changes have been done to Service Order Records.</h2>';
		exit();
	}
	
	require_once('Database/MySQL.php');
	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
	
	#
	# changing ORDER_NO on all affected tables
	#
	
	# service_tbl
	$sql = "SELECT ORDER_NO FROM service_tbl WHERE ORDER_NO='$old_order_no'";
	$res1 = $db->query($sql);
	
	if ( $res1->size() != 1 ) {

		echo '<br/><br/><br/><h2>The submitted Order No. does not exits in SERVICE TABLE.</h2>';
		exit();

	} else if ( $res1->size() == 1 ) {

		$sql = "UPDATE service_tbl
				SET ORDER_NO='$new_order_no'
				WHERE ORDER_NO='$old_order_no'";

		$res1_1 = $db->query($sql);
	}
	
	# service_items_tbl
	$sql = "SELECT * FROM service_items_tbl WHERE ORDER_NO='$old_order_no'";
	$res2 = $db->query($sql);
	
	if ( $res2->size() != 1 ) {

		echo '<br/><br/><br/><h2>The submitted Order No. does not exits in SERVICE ITEMS TABLE.</h2>';
		exit();

	} else if ( $res2->size() >= 1 ) {

		$sql = "UPDATE service_items_tbl
				SET ORDER_NO='$new_order_no'
				WHERE ORDER_NO='$old_order_no'";

		$res2_1 = $db->query($sql);
	}
	
	# service_returned_parts_tbl
	$sql = "SELECT ORDER_NO FROM service_returned_parts_tbl WHERE ORDER_NO='$old_order_no'";
	$res3 = $db->query($sql);
	
	if ( $res3->size() != 1 ) {

		echo '<br/><br/><br/><h2>The submitted Order No. does not exits in SERVICE RETURNED PARTS TABLE.</h2>';

	} else if ( $res3->size() >= 1 ) {

		$sql = "UPDATE service_returned_parts_tbl
				SET ORDER_NO='$new_order_no'
				WHERE ORDER_NO='$old_order_no'";

		$res3_1 = $db->query($sql);
	}
	
	# service_done_by_tbl
	$sql = "SELECT ORDER_NO FROM service_done_by_tbl WHERE ORDER_NO='$old_order_no'";
	$res4 = $db->query($sql);
	
	if ( $res4->size() != 1 ) {

		echo '<br/><br/><br/><h2>The submitted Order No. does not exits in SERVICE DONE BY TABLE.</h2>';

	} else if ( $res4->size() >= 1 ) {

		$sql = "UPDATE service_done_by_tbl
				SET ORDER_NO='$new_order_no'
				WHERE ORDER_NO='$old_order_no'";

		$res4_1 = $db->query($sql);
	}
	
	# service_spares_tbl
	$sql = "SELECT ORDER_NO FROM service_spares_tbl WHERE ORDER_NO='$old_order_no'";
	$res5 = $db->query($sql);
	
	if ( $res5->size() != 1 ) {

		echo '<br/><br/><br/><h2>The submitted Order No. does not exits in SERVICE SPARES TABLE.</h2>';

	} else if ( $res5->size() >= 1 ) {

		$sql = "UPDATE service_spares_tbl
				SET ORDER_NO='$new_order_no'
				WHERE ORDER_NO='$old_order_no'";

		$res5_1 = $db->query($sql);
	}
	
	
	# service_failed_tbl
	
	#
	#	PENDING !!!
	#
	
	
	
	#
	# moving files from old folders to new folders
	#
	
	$path = "../../data/Admin/Service Coordinator Files/Service Raports/".$_SESSION['IMO']."/";
		
	$source = $path.$old_order_no;
	$destination = $path.$new_order_no;
	
	// it is needed to delete the 4 subfolders inside $destination to avoid a "File exist error"
	$folders_to_be_deleted = array('additional_docs', 'pictures', 'service_report', 'worksheet');
	
	for ( $k = 0; $k <= ( sizeof( $folders_to_be_deleted ) - 1 ); $k++ ) {
		rmdir( $destination.'/'.$folders_to_be_deleted[$k] );
	}
	
	
	
	$dir_array = array();	// clean up the array containing files' names
	$order_dir = opendir( $source );
	
	while ( $entry = readdir( $order_dir ) ) {
		$dir_array[] = $entry;
	}
		
	closedir( $order_dir );
		
	for ( $j = 2; $j <= ( sizeof($dir_array) - 1 ); $j++ ) {			
		if ( !rename( $source."/".$dir_array[$j], $destination."/".$dir_array[$j] ) ) {
			echo "<br/><br/>ERROR MOVING FILES TO NEW LOCATION";
		} else {
			echo "<br/>succesfully moved: ".$source."/".$dir_array[$j]." - to - ".$destination."/".$dir_array[$j];
		}
	}
	
}
?>

</body>
</html>  

