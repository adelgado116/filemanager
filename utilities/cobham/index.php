<html>
	
	<head>
		<link href="styles/styles.css" rel="stylesheet">
		<title>RAn Panama - Cobham Q-Rep</title>
	</head>
	<body>
		
		<div id="header">
			<img src="images/LogoRANPanama_hor.png" >
			<h1>&nbsp;&nbsp;|&nbsp;&nbsp;Cobham's Quarterly Report</h1>
		</div>
		
		<!-- <form name="form1" action="quarterly_report.php"> -->
		<form name="form1" action="q_report.php">
			Year <select name="report_year">
					<option value="2015">2015</option>
					<option value="2016">2016</option>
					<option value="2017">2017</option>
			</select>
			Month <select name="report_quarter">
				<option value="1">Q1</option>
				<option value="2">Q2</option>
				<option value="3">Q3</option>
				<option value="4">Q4</option>			
			</select>
			<input type="submit" value="create report" />
		</form>
		
		<p style="color: #FF0000" >&#8226 The information contained on this report comes from SAP BO, Database: ERP.</p>
		<p>
			NOTES:
			<ul>
				<li>
					The Report has to be processed by hand before sending it to COBHAM.
				</li>
				<li>
					Credit Memos (documents starting with 20....) has to be match to their Invoice, both have to be deleted from the Report.
				</li>
				<li>
					All Consignment Parts appearing on the Report have to be removed.
				</li>
				<li>
					Make a last review to make sure only "indirect sales" invoices appear on the final Report.
				</li>
			</ul>
		</p>
		
		
		
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
					if ( (substr( $dir_array_2[$k], strrpos( $dir_array_2[$k], '.' ) + 1 ) == 'txt') || (substr( $dir_array_2[$k], strrpos( $dir_array_2[$k], '.' ) + 1 ) == 'xlsx') || (substr( $dir_array_2[$k], strrpos( $dir_array_2[$k], '.' ) + 1 ) == 'xls') ) {
					
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