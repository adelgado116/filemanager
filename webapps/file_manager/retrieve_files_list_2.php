<?php

//
//  Define Size Measure Unit LABEL according to file size
//
function formatSizeUnits( $bytes ) {

	if ($bytes >= 1073741824) {
		$bytes = number_format($bytes / 1073741824, 2) . ' GB';
	} elseif ($bytes >= 1048576) {
		$bytes = number_format($bytes / 1048576, 2) . ' MB';
	} elseif ($bytes >= 1024) {
		$bytes = number_format($bytes / 1024, 2) . ' KB';
	} elseif ($bytes > 1) {
		$bytes = $bytes . ' bytes';
	} elseif ($bytes == 1) {
		$bytes = $bytes . ' byte';
	} else {
		$bytes = '0 bytes';
	}

	return $bytes;
}





//
//  get list of files and format their data to be displayed on page2.php's tabs
//

$imo = $_REQUEST['IMO_NUMBER'];
$order = $_REQUEST['order'];

$path = $_REQUEST['path'];
$currentFolder = $_REQUEST['folder'];

$folder = $path."/".$currentFolder;	

$dir_array_2 = array();

$data = "";	// this will contain all the data to be displayed on page2.php



if (substr("$currentFolder", 0, 1) != ".") { // don't list hidden files

	$folder_res = opendir( $folder );

	while ( $dir_element = readdir( $folder_res ) ) {			
		$dir_array_2[] = $dir_element;
	}

	closedir( $folder_res );


	
	
	switch( $currentFolder ) {
		case "drawings":
			$tabNumber = 1;
			break;
		case "others":
			$tabNumber = 2;
			break;
		case "pictures":
			$tabNumber = 3;
			break;
		default:
			break;
	}
	
	
	

	if ( (sizeof( $dir_array_2 ) - 2) == 0 ) { // it is -2 to take out the . and .. refs

		$data .= "EMPTY FOLDER "."  <div id=\"upload-files-".$tabNumber."\">UPLOAD FILES</div>";		
		
	} else {
	
	
		$data .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" >";  // MAIN TABLE
		$data .= "<tr>";
		$data .= "<td valign=\"top\" >";
	
	
		$data .= "<table width=\"100%\">";  // TABLE FOR FILES LIST
		$data .= "<tr bgcolor=\"#5656DD\" style=\"color:#FFFFFF; font-weight: bold\" align=\"center\">";
		$data .= "<th width=\"55%\" align=\"left\">&nbsp;Filename <div id=\"upload-files-".$tabNumber."\">+</div> </th><th width=\"13%\">Size</th><th width=\"22%\">Date Uploaded</th><th width=\"5%\">Delete</th><th width=\"5%\"><a href=\"#\">Share</a></th>";
		$data .= "</tr>";
		
		
		$index_count_2 = count( $dir_array_2 );
		sort( $dir_array_2 );
		
		$bgcol = "#C4E2FF";
		
		for ( $k = 2; $k < $index_count_2; $k++ ) {
		
			$creation_dates = date( "d M Y H:i", filemtime( $folder.'/'.$dir_array_2[ $k ] ) );
			$file_size = filesize( $folder.'/'.$dir_array_2[ $k ] );
			
			$data .= "<tr bgcolor=\"".$bgcol."\">";
			//$data .= "<td align=\"center\" valign=\"middle\">";
			//$data .= "<img src=\"images/file_icon.png\" />";
			//$data .= "</td>";
			$data .= "<td>";
			$data .= "&nbsp;<a href=\"$folder/$dir_array_2[$k]\" target=\"_blank\" style=\"text-decoration: none;\" onmouseover=\"\" >$dir_array_2[$k]</a>";
			$data .= "</td>";
			$data .= "<td align=\"right\">";
			$data .= formatSizeUnits( $file_size )."&nbsp;";
			$data .= "</td>";
			$data .= "<td align=\"center\">";
			$data .= $creation_dates;
			$data .= "</td>";
			$data .= "<td align=\"center\">";
			//$data .= "<input type=\"checkbox\" id=\"del_".$k."\" name=\"del_".$k."\" value=\"$folder/$dir_array_2[$k]\" />";
			$data .= "<a href=\"page2_1.php?IMO_NUMBER=$imo&ORDER_NO=$order&TAB=".$tabNumber."&del=$folder/$dir_array_2[$k]\" onclick=\"return confirm('Are you sure you want to delete this file?')\">delete</a>";
			$data .= "</td>";
			$data .= "<td align=\"center\">";
			$data .= "<input type=\"checkbox\" name=\"\" value=\"1\" />";
			$data .= "</td>";
			$data .= "</tr>";
			
			// change the color of every row
			if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
			else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
		}
		
		$data .= "</table>";  // END OF: TABLE FOR FILES LIST
		
		
		if ( $currentFolder == "pictures" ) {
			
			$data .= "</td>";
			$data .= "<td width=\"50%\" valign=\"top\">";
			
			// the link to CSS and JS code must be done here, to follow the page loading flow.
			$data .= "<link href=\"css/fotorama.css\" rel=\"stylesheet\">";
			$data .= "<script type=\"text/javascript\" src=\"js/fotorama.js\"></script>";
			
			$data .= "<div class=\"fotorama\" data-width=\"600\" data-ratio=\"4/3\" data-fit=\"scaledown\" data-nav=\"thumbs\" data-allowfullscreen=\"native\" data-keyboard=\"true\" data-navposition=\"top\" >";
			
			
			
			$folder_res_pics = opendir( $folder );
		
			while ( $dir_element_pics = readdir( $folder_res_pics ) ) {
				$dir_array_pics[] = $dir_element_pics;
			}
		
			closedir( $folder_res_pics );

			$index_count_pics = count( $dir_array_pics );
			
			
			
			#  sort files by creation date
			array_multisort( array_map( "filemtime", $dir_array_pics ),
							 SORT_NUMERIC,
							 SORT_DESC,
							 $dir_array_pics );
							 
							 
			for ( $k = 2; $k < $index_count_pics; $k++ ) {
			
				if (substr( "$dir_array_pics[$k]", 0, 1) != ".") { // don't list hidden files
				
					# get date of creation of current picture file
					$creation_date = date( "d M Y H:i", filemtime( $folder.'/'.$dir_array_pics[ $k ] ) );
				
					$data .= "<img src=\"$folder/$dir_array_pics[$k]\" data-caption=\"".$dir_array_pics[ $k ]." :: [".$order."] - ".$_REQUEST['SHIP_NAME']." - ".$creation_date."\" />";
				}
			}

			$data .= "</div>";  // END OF: fotorama CLASS DIV
		}
		
		
		$data .= "</td>";
		$data .= "</tr>";
		$data .= "</table>";  // END OF: MAIN TABLE
	}
}



print_r( $data );



?>
