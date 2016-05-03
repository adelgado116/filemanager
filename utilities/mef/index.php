
<html>

<body style="font-family: sans-serif">

<br/>
<strong>MEF Report of Payment to Third Parties</strong>
<br/><br/>


<form name="form1" action="mef_report.php">
	Year <select name="report_year">
			<option value="2015">2015</option>
			<option value="2016">2016</option>
	</select>
	Month <select name="report_month">
		<option value="01">January</option>
		<option value="02">February</option>
		<option value="03">March</option>
		<option value="04">April</option>
		<option value="05">May</option>
		<option value="06">June</option>
		<option value="07">July</option>
		<option value="08">August</option>
		<option value="09">September</option>
		<option value="10">October</option>
		<option value="11">November</option>
		<option value="12">December</option>			
	</select>
	<input type="submit" value="create report" />
</form>

<p style="font-size: small" >&#8226 The information contained on this report comes from SAP Business One Database.</p>

<hr/>

<br/>
<strong>List of Available Reports</strong>
<p style="font-size: small" >&#8226 Proceed to MEF Reporting Tool after creating and downloading the TXT file.</p>

<?php

	$folder_res = opendir( "reports" );
	
	while ( $dir_element = readdir( $folder_res ) ) {			
		$dir_array_2[] = $dir_element;
	}

	closedir( $folder_res );
	
	
	
	if ( (sizeof( $dir_array_2 ) - 2) == 0 ) { // it is -2 to take out the . and .. refs

		echo "<br/><br/>";
		echo "EMPTY FOLDER ";
		
	} else {
	
		$data .= "<table width=\"50%\">";  // TABLE FOR FILES LIST
		$data .= "<tr bgcolor=\"#5656DD\" style=\"color:#FFFFFF; font-weight: bold\" align=\"center\">";
		$data .= "<th align=\"left\">&nbsp;Filename</th><th align=\"left\">&nbsp;Actions</th>";
		$data .= "</tr>";
		
		
		$index_count_2 = count( $dir_array_2 );
		sort( $dir_array_2 );
		
		$bgcol = "#C4E2FF";
		
		for ( $k = 2; $k < $index_count_2; $k++ ) {
			
			// filter non TXT files
			if ( substr( $dir_array_2[$k], strrpos( $dir_array_2[$k], '.' ) + 1 ) == 'txt' ) {
			
				$data .= "<tr bgcolor=\"".$bgcol."\">";
				$data .= "<td>";
				$data .= "&nbsp;<a href=\"reports/$dir_array_2[$k]\" target=\"_blank\" style=\"text-decoration: none;\" onmouseover=\"\" >$dir_array_2[$k]</a>";
				$data .= "</td>";
				$data .= "<td>";
				$data .= "<a href=\"delete_report.php?del=reports/$dir_array_2[$k]\" onclick=\"return confirm('Are you sure you want to delete this file?')\">delete</a>";
				$data .= "</td>";
				$data .= "</tr>";
				
				// change the color of every row
				if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
				else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
			}
		}
		
		$data .= "</table>";  // END OF: TABLE FOR FILES LIST
	}

	echo $data;

?>

</body>

</html>