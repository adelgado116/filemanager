<?php

$letter = $_REQUEST['letter'];
$ship = $_REQUEST['shipname'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page2</title>
<meta content="CodeCharge Studio 4.1.00.032" name="GENERATOR">
<link href="../Styles/Blueprint1/Style_doctype.css" type="text/css" rel="stylesheet">


<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top">
      
      <table class="Grid" cellspacing="0" cellpadding="0">
        
        <!-- BEGIN Row -->
		
<?php

	$path = 'D:/data/container/before_april_2009/'.$letter.'/'.$ship;

	if ( is_dir( $path ) ) {
	
		if ($dh = opendir( $path )) {
		
			$dir_array = array();

			while ( ($entry = readdir( $dh )) !== false ) {
				$dir_array[] = $entry;
			}
			
        	closedir($dh);
			
			$index_count = count( $dir_array );
			sort( $dir_array );
			
			for ( $i = 2; $i <= $index_count - 1; $i++ ) {
				
				//
				//
				$path_2 = $path.'/'.$dir_array[$i];
				
				if ( is_dir( $path_2 ) ) {
				
					echo "<tr class=\"Row\">";
					echo "<td colspan=\"2\">";
					echo "<strong>".$dir_array[$i]."</strong> - is a dir";
					
					if ($dh2 = opendir( $path_2 )) {
					
						$dir_array2 = array();

						while ( ($entry2 = readdir( $dh2 )) !== false ) {
							$dir_array2[] = $entry2;
						}
			
        				closedir($dh2);
						
						$index_count2 = count( $dir_array2 );
						sort( $dir_array2 );
						
						echo "<table>";
						
						for ( $j = 2; $j <= $index_count2 - 1; $j++ ) {
						
							echo "<tr class=\"Row\">";
							echo "<td colspan=\"2\">";
							echo $dir_array2[$j];
							echo "</td>";
							echo "</tr>";
						}
					}
					
					echo "</table>";
					
					echo "</td>";
					
				} else {
				
					echo "<tr class=\"Row\">";
					echo "<td colspan=\"2\">";
					//echo "<a href=\"http://www.google.com\" target=\"_blank\">".$dir_array[$i]."</a>";
					//echo "<a href=\"$path/$dir_array[$i]\" target=\"_blank\">".$dir_array[$i]."</a>";
					echo "<a href=\"../../../email_test_file.txt\" target=\"_blank\">".$dir_array[$i]."</a>";
					echo "</td>";
				}
			}
		}
		
	} /*else {
		
	}*/	
?>        
        <tr class="Footer">
          <td colspan="2"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

   
</body>
</html>
