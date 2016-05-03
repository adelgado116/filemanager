<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

/*
$res = mysql_query("SELECT * FROM reports_types WHERE rep_id='1'", $link_id);
	
echo $res_qty = mysql_num_rows( $res );


?>
*/



# DO NOT DISPLAY ERRORS, WARNINGS OR NOTICES.
ini_set('display_errors', 'Off');
#error_reporting(E_ALL);

// Start the session
#session_start();

//require('../DB/dbConnect.inc');
//require('./inc/functions.inc.php');
require('functions_hssiso.php');

$sql = "SELECT * FROM reports_options_list ORDER BY rep_id ASC";

$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
$rowsQty = mysql_num_rows($result);

$products = array();
$products = get_table($result);

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
  Edit Reports Options List </font> </div>


<br/><br/><br/>

<center>

<div id="tableContainer">

<?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">

<table class="tableText">
	<thead>
		<tr bgcolor="#00CCFF" align="center">
			<td>ID</td><td>REPORT TYPE</td><td>REPORT OPTION</td><td>SHOW</td>
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
			
			
			for ( $rowNumb = $init; $rowNumb <= $limit; $rowNumb++ ) {
		?>
		
			<TR bgcolor=<?php echo $bgcol; ?> >
			
			<!-- row n, column m -->
			<TD align="center"> <?php echo $products[$rowNumb]['rep_opt_id']; ?>
				<input type="hidden" class="tableText"
					   name="<?php echo 'rep_opt_id'.$rowNumb; ?>"
					   value="<?php echo $products[$rowNumb]['rep_opt_id']; ?>" />
			
			</TD>
			
			<!-- row n, column m+1 -->
			<TD> <?php
				$repid = $products[$rowNumb]['rep_id'];
				$sql = "SELECT rep_name FROM reports_types WHERE rep_id='$repid'";
				$result = mysql_query($sql) or die('Query failed [getting report type]: ' . mysql_error());
				$row = mysql_fetch_array( $result, MYSQL_ASSOC );
				
				echo $row['rep_name']; ?>
				
				<input type="hidden" class="tableText"
					   name="<?php echo 'rep_id'.$rowNumb; ?>"
					   value="<?php echo $products[$rowNumb]['rep_id']; ?>" />
			
			</TD>
			
			<!-- row n, column m+2 -->
			<TD>
				<input type="text" size="50" maxlength="100" class="tableText"
					   name="<?php echo 'rep_option'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none"
					   value="<?php echo $products[$rowNumb]['rep_option']; ?>" />
			</TD>
						
			<!-- row n, column m+3 -->
			<TD>
				<input type="checkbox"
					   name="<?php echo 'show_sel'.$rowNumb; ?>"
					   value="1" <?php if ($products[$rowNumb]['show_option'] == 1) echo "checked"; ?>/>
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
		<TR>
		<TD bgcolor=<?php echo $bgcol; ?>>new entry ::</TD>
		
		<TD bgcolor=<?php echo $bgcol; ?>> <?php
			
			$sql = "SELECT * FROM reports_types";
			$result = mysql_query($sql) or die('Query failed [getting report type]: ' . mysql_error());
			?>
			
			<select name="select_report_type" style="color:black; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:84%;
				font-weight:normal; background-color:<?php echo $bgcol; ?>; border:none; border-top-color:<?php echo $bgcol; ?>; border-left-color:<?php echo $bgcol; ?>; border-right-color:<?php echo $bgcol; ?>;
				border-bottom-color:<?php echo $bgcol; ?>">
				<option value="0">Select an option</option>
				<?php
				
				
				while ( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
				
					echo '<option value="'.$row['rep_id'].'"> '.$row['rep_name'].'</option>';
				}		
				
				?>
			</select>
		
		</TD>
		
		<TD bgcolor=<?php echo $bgcol; ?>>
			<input type="text" size="50" maxlength="100" class="tableText"
				   name="new_rep_option"
				   style="background-color:<?php echo $bgcol; ?>;"
				   value="<?php echo $_REQUEST['new_option_again'] ?>" />
		</TD>
					
		<TD bgcolor=<?php echo $bgcol; ?>>
			<input type="checkbox"
				   name="new_rep_option_show"
				   value="1"/>
		</TD>
		
		<TD>
		<?php
			if ( isset( $_REQUEST['wrong'] ) ) {
			
				switch ( $_REQUEST['wrong'] ) {
					case 1:
						echo '<font color=red>only letters and numbers allowed for New Report Options</font>';
						break;
					case 2:
						echo '<font color=red>select TYPE OF REPORT for this entry</font>';
						break;
					default:
						break;
				} 
			}
		?>
		</TD>
				
		</TR>

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
			<a href="edit_options.php?current=<?php echo $currentPage; ?>&selectFilter=<?php echo $sel; ?>&page=prev">&lt;&lt; prev page</a>
			<?php echo ' [ '.$currentPage.' of '.$pagesQty.' ] '; ?>
			<a href="edit_options.php?current=<?php echo $currentPage; ?>&selectFilter=<?php echo $sel; ?>&page=next">next page &gt;&gt;</a>
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
		
		$rep_opt_id     = 'rep_opt_id'.$i;
		$rep_id     = 'rep_id'.$i;
		$rep_option = 'rep_option'.$i;
		$show_sel  = 'show_sel'.$i;
		
		$ropt = $_REQUEST[$rep_opt_id];
		$roption = $_REQUEST[$rep_option];
		$showsel = $_REQUEST[$show_sel];
		
		$sql = "UPDATE reports_options_list
				SET rep_option='$roption', show_option='$showsel' WHERE rep_opt_id='$ropt'";
		
		$result = mysql_query($sql) or die('Query 2 failed: ' . mysql_error());

	}


	# INSERT NEW DATA INTO TABLE (IF AVAILABLE)
	
	# VALIDATE DATA FROM NEW ENTRY
	$wrong = 0;
	if ($_REQUEST['new_rep_option'] != "") {
	
		# validate REPORT TYPE selection
		if ( $_REQUEST['select_report_type'] == 0 ) {
			$wrong = 2;
		}
		
		// no need to validate $_REQUEST['new_rep_option'], user can enter whatever he wants
		/*
		if ( is_alphanum_enh( $_REQUEST['new_rep_option'], 25 ) != '0' ) {
			$wrong = 1;
		}
		*/
	
		if ( $wrong == 0 ) {
	
			# ALL OK. execute corresponding actions
			
			# INSERT NEW DATA
			$rep_id = $_REQUEST['select_report_type'];
			$new_rep_option = $_REQUEST['new_rep_option'];
			$show_sel = $_REQUEST['new_rep_option_show'];
			
			
			$sql = "INSERT INTO reports_options_list (rep_option, rep_id, show_option) VALUES ('$new_rep_option','$rep_id','$show_sel')";
			
			$result = mysql_query($sql) or die('Query failed [inserting new rep type]: ' . mysql_error());
		
			
			# display edition page
			$dir = $_SERVER['PHP_SELF'];  // can be declared once at the beginning
			header('Location: edit_options.php' );
				
		} else {
		
			header("Location: edit_options.php?current=".$_REQUEST['pagenumber']."&wrong=".$wrong."&new_option_again=".$_REQUEST['new_rep_option']);
		}
		
	} else {
	
		# just display the same page once again with new values from database
		header('Location: edit_options.php?current='.$_REQUEST['pagenumber'] );
	}
}
?>

</body>
</html>
