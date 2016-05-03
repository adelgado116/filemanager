<?php

# DO NOT DISPLAY ERRORS, WARNINGS OR NOTICES.
//ini_set('display_errors', 'Off');
#error_reporting(E_ALL);


require_once('functions_hssiso.php');
include('dbConnect_hssiso.inc');


if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}


$serviceOrder = strtoupper($_REQUEST['serviceOrder']);


$sql = "SELECT * FROM report_partslist WHERE serviceOrder = '$serviceOrder'";

$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
$rowsQty = mysql_num_rows($result);

$table_row = array();
$table_row = get_table($result);


?>
<html>

<head>
<link rel="stylesheet" href="css/dashboard.css" type="text/css" />
</head>

<body OnLoad="document.form1.partNumber0.focus();">


<div id="title">
<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
Parts List - Order No. <strong><?php echo $serviceOrder; ?></strong>
</font>
</div>


<div id="content">


<form name="form1" action="process_parts_list.php" method="post">

	<table>
		<tr bgcolor="#5656DD" style="color:#FFFFFF; font-weight: bold" align="center">
			<td>ITEM</td>
			<td>QTY</td>
			<td>PART NUMBER</td>
			<td>SERIAL NUMBER</td>
			<td>PART DESCRIPTION</td>
			<td>DELETE</td>
		</tr>		
		
		<?php
			$bgcol = "#C4E2FF";
			
			
			$tabIndex1 = 1;
			
			
			
			for ( $rowNumb = 0; $rowNumb <= (24); $rowNumb++ ) {
		?>
		
			<tr bgcolor=<?php echo $bgcol; ?> >
			
			<!-- row n, column m -->
			<td align="center"> <?php echo $rowNumb + 1; ?>
				<input type="hidden" class="tableText"
					   name="<?php echo 'record_id'.$rowNumb; ?>"
					   value="<?php echo $table_row[$rowNumb]['record_id']; ?>" />
			
			</td>
			
			<!-- row n, column m+1 -->
			<td>
				<input type="text" autocomplete="off" size="3" maxlength="3" class="tableText"
					   name="<?php echo 'quantity'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none; text-align:center"
					   value="<?php echo $table_row[$rowNumb]['quantity']; ?>" />
			</td>
			
			<!-- row n, column m+2 -->
			<td>
				<input type="text" autocomplete="off" size="20" maxlength="20" class="tableText"
					   name="<?php echo 'partNumber'.$rowNumb; ?>"
					   id="<?php echo 'partNumber'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none; text-transform: uppercase "
					   value="<?php echo $table_row[$rowNumb]['partNumber']; ?>"
					   tabindex="<?php echo $tabIndex1++; ?>"/>
			</td>
			
			<!-- row n, column m+3 -->
			<td>
				<input type="text" autocomplete="off" size="20" maxlength="20" class="tableText"
					   name="<?php echo 'serialNumber'.$rowNumb; ?>"
					   id="<?php echo 'serialNumber'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none; text-transform: uppercase"
					   value="<?php echo $table_row[$rowNumb]['serialNumber']; ?>"
					   tabindex="<?php echo $tabIndex1++; ?>"
					   
					   onBlur=" if( this.tabIndex == 40 ) { var initialField; initialField = document.getElementById('partNumber0'); initialField.focus(); }"
					   
					   />
			</td>
			
			<!-- row n, column m+4 -->
			<td>
				<input type="text" autocomplete="off" size="38" maxlength="40" class="tableText"
					   name="<?php echo 'partDescription'.$rowNumb; ?>"
					   style="background-color:<?php echo $bgcol; ?>; border:none; text-transform: uppercase"
					   value="<?php echo $table_row[$rowNumb]['description']; ?>" />
			</td>
					
			<!-- row n, column m+5 -->
			<td align="center">
				<input type="checkbox"
					   name="<?php echo 'delete'.$rowNumb; ?>"
					   value="1" />
			</td>
			
			</tr>
		
		<?php
		
				// change the color of every row
				if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
				else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
				
				
				
			}  // end of: for ( $rowNumb = ...
			
		$bgcol = "#DD8888";
		
		?>
		
	</table>

	<div id="options"> 
		
		<input type="hidden" name="serviceOrder" value="<?php echo $serviceOrder; ?>" />
	
		<input class="button" type="submit" value="save changes" />
	</div>
	<div id="statusMessage">
		<?php echo $_REQUEST['status']; ?>
	</div>
</form>

</div>

</body>
</html>


