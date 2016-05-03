<?php

// Start the session
session_start();

# DO NOT DISPLAY ERRORS, WARNINGS OR NOTICES.
ini_set('display_errors', 'Off');
#error_reporting(E_ALL);


//debug
echo $_REQUEST['wrong'];


require_once('functions_hssiso.php');

include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

$sql = "SELECT * FROM reports_types";

$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
$rowsQty = mysql_num_rows($result);

$table_row = array();
$table_row = get_table($result);

$divisor = 15;
$pagesQty = ceil($rowsQty / $divisor);

$currentPage = $_REQUEST['current'];

if ( $_REQUEST['current'] == '' ) {
	
	$currentPage = 1;
	
}

if ( $_REQUEST['page'] == 'next' ) {

	$currentPage = $currentPage + 1;
	
	if ( $currentPage >= $pagesQty ) { $currentPage = $pagesQty; }  # pages cannot be more than $pagesQty
}
else if ( $_REQUEST['page'] == 'prev' ) {

	$currentPage = $currentPage - 1;
	
	if ( $currentPage <= 0 ) { $currentPage = 1; }  # pages must be a positive number
}




?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" href="css/iframe.css" />
<title></title>
</head>

<body>

<div id="title"> <font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif"> 
  Edit Types of Reports </font> </div>

<br/><br/><br/>

<center>


<div id="tableContainer">

<?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">

<table class="tableText">
	<thead>
		<tr bgcolor="#00CCFF" align="center">
			<td>REPORT ID</td><td>REPORT NAME</td><td>CODE</td><td>VERSION-REVISION</td><td>SHOW</td><td>ACTIONS</td>
		</tr>
	</thead>
	<!--<tfoot>
		<tr bgcolor="#00CCFF">
			<td>previous page</td>
			<td>current</td>
			<td>next page</td>
		</tr>
	</tfoot> -->
	<tbody>
		<?php
			$bgcol = "#C4E2FF";
			
			
			#### table displaying structure ########
			#
			$init = ($currentPage - 1) * $divisor;
			
			if ( $currentPage != $pagesQty ) {
			
				$limit = (($currentPage - 1) * $divisor) + ($divisor - 1);
			
			} else {
			
				$limit = ((($currentPage - 1) * $divisor) + ($rowsQty % $divisor)) - 1;
			}
			#
			#### table displaying structure ########
			
			// debug
			//echo $init;
			//echo $limit;
			
			for ( $rowNumb = $init; $rowNumb <= ($limit); $rowNumb++ ) {
		?>
		
			<TR bgcolor=<?php echo $bgcol; ?> >
			
			<!-- row n, column m -->
			<TD align="center"> <?php echo $table_row[$rowNumb]['rep_id']; ?>
				<input type="hidden" class="tableText"
					   name="<?php echo 'rep_id'.$rowNumb; ?>"
					   value="<?php echo $table_row[$rowNumb]['rep_id']; ?>" />
			
			</TD>
			
			<!-- row n, column m+1 -->
			<TD>
				<input type="text" size="30" maxlength="25" class="tableText"
					   name="<?php echo 'rep_name'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none"
					   value="<?php echo $table_row[$rowNumb]['rep_name']; ?>" />
			</TD>
			
			<!-- row n, column m+2 -->
			<TD>
				<input type="text" size="5" maxlength="3" class="tableText"
					   name="<?php echo 'doc_code'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none"
					   value="<?php echo $table_row[$rowNumb]['doc_code']; ?>" />
			</TD>
			
			<!-- row n, column m+3 -->
			<TD>
				<input type="text" size="25" maxlength="20" class="tableText"
					   name="<?php echo 'ver_rev'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none"
					   value="<?php echo $table_row[$rowNumb]['version_revision']; ?>" />
			</TD>
					
			<!-- row n, column m+4 -->
			<TD>
				<input type="checkbox"
					   name="<?php echo 'show_sel'.$rowNumb; ?>"
					   value="1" <?php if ($table_row[$rowNumb]['show_option'] == 1) echo "checked"; ?>/>
			</TD>
			
			<!-- row n, column m+5 -->
			<TD>
			<a href="print_blank_report.php?rep_id=<?php echo $table_row[$rowNumb]['rep_id']; ?>" target="_blank">PRINT BLANK</a>
			
			</TD>
					
			</TR>
		
		<?php
		
				// change the color of every row
				if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
				else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
				
			}  // end of: for ( $rowNumb = (($currentPage - 1) * $divisor);... ) {
			
		$bgcol = "#DD8888";
		
		?>
		
		<!-- fields for new entry -->
		<tr>
		<td bgcolor="<?php echo $bgcol; ?>">new entry ::</td>
		<td bgcolor=<?php echo $bgcol; ?>>
		<input type="text" size="30" maxlength="25" class="tableText"
			   name="new_rep_type"
			   style="background-color:<?php echo $bgcol; ?>;"
			   value="" />
		</td>
		<td bgcolor=<?php echo $bgcol; ?>>
		<input type="text" size="5" maxlength="3" class="tableText"
			   name="new_doc_code"
			   style="background-color:<?php echo $bgcol; ?>;"
			   value="" />
		</td>
		<td bgcolor=<?php echo $bgcol; ?>>
		<input type="text" size="25" maxlength="20" class="tableText"
			   name="new_ver_rev"
			   style="background-color:<?php echo $bgcol; ?>;"
			   value="" />
		</td>
		<td bgcolor="<?php echo $bgcol; ?>">
		<input type="checkbox"
			   name="new_rep_type_show"
			   value="1"/>
		</td>
		
		<TD>
		<?php
			if ( isset( $_REQUEST['wrong'] ) ) {
			
				switch ( $_REQUEST['wrong'] ) {
					case 1:
						echo '<font color=red>only letters and numbers allowed</font>';
						break;
					default:
						break;
				} 
			}
		?>
		</TD>
		
		</tr>

		<tr>
		<td colspan="6" align="center">
			<input type="hidden" name="lowlimit" value="<?php echo $init; ?>" />
			<input type="hidden" name="uplimit" value="<?php echo $limit; ?>" />
			<input type="hidden" name="pagenumber" value="<?php echo $currentPage; ?>" />
			<input class="tableSubmit" type="submit" value="save changes" />
		</td>
		</tr>
		<tr>
		
		<!-- lower navigator -->
		<td colspan="6" align="center">
			<a href="edit_rep_types.php?current=<?php echo $currentPage; ?>&selectFilter=<?php echo $sel; ?>&page=prev">&lt;&lt; prev page</a>
			<?php echo ' [ '.$currentPage.' of '.$pagesQty.' ] '; ?>
			<a href="edit_rep_types.php?current=<?php echo $currentPage; ?>&selectFilter=<?php echo $sel; ?>&page=next">next page &gt;&gt;</a>
		</td>
		</tr>
		
	</tbody>
</table>

</form>

</div> <!-- tableContainer -->

</center>

<?php } else {

	#################################
	# PROCESS THE SUBMITTED DATA
	#################################
	
	# UPDATE TABLE(s)
	
	for ( $i = $_REQUEST['lowlimit']; $i <= $_REQUEST['uplimit']; $i++ ) {
		
		$rep_id     = 'rep_id'.$i;
		$rep_name = 'rep_name'.$i;
		$show_sel  = 'show_sel'.$i;
		$ver_rev = 'ver_rev'.$i;
		$code = 'doc_code'.$i;
		
		$rip = $_REQUEST[$rep_id];
		$rname = $_REQUEST[$rep_name];
		$doc_code = $_REQUEST[$code];
		$version = $_REQUEST[$ver_rev];
		$showsel = $_REQUEST[$show_sel];
		
		$sql = "UPDATE reports_types
				SET rep_name='$rname', doc_code='$doc_code', version_revision='$version', show_option='$showsel'
				WHERE rep_id='$rip'";
		
		$result = mysql_query($sql) or die('Query 2 failed: ' . mysql_error());
	}
	
	
	# INSERT NEW DATA INTO TABLE (IF AVAILABLE)
	
	# VALIDATE DATA FROM NEW ENTRY
	$wrong = 0;
	if ($_REQUEST['new_rep_type'] != "") {
	
		if ( is_alphanum_enh( $_REQUEST['new_rep_type'], 25 ) != '0' )  { $wrong = 1; }
	
		if ( $wrong == 0 ) {
	
			# ALL OK. execute corresponding actions
			
			# INSERT NEW DATA
			$new_rep_type = $_REQUEST['new_rep_type'];
			$code = $_REQUEST['new_doc_code'];
			$new_version = $_REQUEST['new_ver_rev'];
			$show_sel = $_REQUEST['new_rep_type_show'];
			
			
			$sql = "INSERT INTO reports_types (rep_name, doc_code, version_revision, show_option) VALUES ('$new_rep_type', '$code', '$new_version','$show_sel')";
			
			$result = mysql_query($sql) or die('Query failed [inserting new rep type]: ' . mysql_error());
		
			
			# display edition page
			$dir = $_SERVER['PHP_SELF'];  // can be declared once at the beginning
			header('Location: edit_rep_types.php' );
				
		} else {
		
			header("Location: edit_rep_types.php?current=".$_REQUEST['pagenumber']."&wrong=".$wrong);
		}
		
	} else {
	
		# just display the same page once again with new values from database
		header('Location: edit_rep_types.php?current='.$_REQUEST['pagenumber'] );
	}

}   //  end of main else
?>

</body>
</html>
