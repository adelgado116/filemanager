<?php

# DO NOT DISPLAY ERRORS, WARNINGS OR NOTICES.
//ini_set('display_errors', 'Off');
#error_reporting(E_ALL);


require_once('functions_hssiso.php');
include('dbConnect_hssiso.inc');


if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}



$sql = "SELECT * FROM report_starter WHERE serviceOrder LIKE '4%' ORDER BY serviceOrder DESC";

$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
$rowsQty = mysql_num_rows($result);

$table_row = array();
$table_row = get_table($result);


?>
<html>

<head>
<link rel="stylesheet" href="css/dashboard.css" type="text/css" />
</head>

<body>


<div id="title">
<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
Reports List
</font>
</div>


<div id="content">

	<table>
		<tr bgcolor="#5656DD" style="color:#FFFFFF; font-weight: bold" align="center">
			<td>ORDER No.</td>
			<td>VESSEL NAME</td>
			<td>EQUIPMENT</td>
			<td>TYPE OF SERVICE</td>
			<td colspan="3">ACTIONS</td>
		</tr>		
		
		<?php
			$bgcol = "#C4E2FF";
			
			
			$tabIndex1 = 1;
			
			
			
			for ( $rowNumb = 0; $rowNumb <= ($rowsQty - 1); $rowNumb++ ) {
		?>
		
			<tr bgcolor=<?php echo $bgcol; ?> >
			
			<td align="center"> <?php echo '<a href="parts_list.php?serviceOrder='.$table_row[$rowNumb]['serviceOrder'].'" title="click to open parts list">'.$table_row[$rowNumb]['serviceOrder'].'</a>'; ?> </td>
			
			<td> <?php echo $table_row[$rowNumb]['vesselName']; ?> </td>
			
			<td> <?php echo $table_row[$rowNumb]['equipment']; ?> </td>
			
			<td> <?php echo $table_row[$rowNumb]['typeOfService']; ?>	</td>
			
			<td> <?php echo '<a href="rename_order.php?serviceOrder='.$table_row[$rowNumb]['serviceOrder'].'" title="click to reassign ORDER NUMBER">RENAME</a>'; ?></td>
			<td> <?php echo '<a href="xml_creator.php?serviceOrder='.$table_row[$rowNumb]['serviceOrder'].'" title="click to generate XML file">XML</a>'; ?></td>
			<td> CLOSE </td>
			
			</tr>
		
		<?php
		
				// change the color of every row
				if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
				else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
				
				
				
			}  // end of: for ( $rowNumb = ...
			
		$bgcol = "#DD8888";
		
		?>
		
	</table>

</div>

</body>
</html>
