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
				
				echo "<tr class=\"Row\">";
				echo "<td colspan=\"2\">";
				echo $dir_array[$i];
				echo "</td>";
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
