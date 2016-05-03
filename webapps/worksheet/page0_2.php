<?php

$order = $_REQUEST['SALESNUMBER'];

$path_suffix = "../../knowledgebase/non_obs/".$order;

# check if the <order>/ folder structure exists		
if ( !file_exists( $path_suffix ) ) {

	mkdir( $path_suffix, 0777 );
	mkdir( $path_suffix."/service_report", 0777 );
	mkdir( $path_suffix."/additional_docs", 0777 );
	mkdir( $path_suffix."/pictures", 0777 );
	
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page2</title>
<meta content="CodeCharge Studio 4.1.00.032" name="GENERATOR">
<link href="Styles/Blueprint1/Style_doctype.css" type="text/css" rel="stylesheet">

<table width="100%" border="0">
  <tr>
    <td>
      <p><strong><font color="#000066" size="6">NON OBS Services File Manager</font></strong></p>
    </td>
	<td>
      <div align="right">&nbsp;<a href="page0_1.php"><strong>RETURN TO SEARCH INTERFACE</strong></a></div>	  
    </td>
  </tr>
  </tr>
</table>

<br/>

<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top">
      <table class="Header" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="HeaderLeft"><img alt="" src="Styles/Blueprint1/Images/Spacer.gif" border="0"></td> 
          <td class="th"><strong>Service Order No. <?php echo $order; ?></strong></td> 
          <td class="HeaderRight"><img alt="" src="Styles/Blueprint1/Images/Spacer.gif" border="0"></td>
        </tr>
      </table>
 
      <table class="Grid" cellspacing="0" cellpadding="0">
        <tr class="Caption">
          <th scope="col">FOLDERS &amp; FILES</th>
 
          <th scope="col">UPLOAD FILES</th>
        </tr>
 
        <!-- BEGIN Row -->
		
		<?php

	$order_dir = opendir( $path_suffix );
	
	while ( $entry = readdir( $order_dir ) ) {
		$dir_array[] = $entry;
	}
	
	closedir( $order_dir );
	
	$index_count = count( $dir_array );
	sort( $dir_array );
				
	for( $j = 2; $j < $index_count; $j++) {
	
		$dir_array_2 = array();
		
		$folder = $path_suffix."/".$dir_array[$j];
	
		if (substr("$dir_array[$j]", 0, 1) != ".") { // don't list hidden files
		
			echo "<tr class=\"Row\">";
			echo "<td>$dir_array[$j]</td>";
			
			?>
			<td>
			<form enctype="multipart/form-data" action="upload.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
				<input type="hidden" name="folder_path" value="<?php echo $folder; ?>"/>
				
				<input type="hidden" name="ORDER_NO" value="<?php echo $order; ?>"/>
								
				<input name="uploaded_file" type="file" />
				<input type="submit" value="Upload" />
			</form>
			</td>
			<?php 
			echo "</tr>";
			
			$folder_res = opendir( $folder );
			
			while ( $dir_element = readdir( $folder_res ) ) {			
				$dir_array_2[] = $dir_element;
			}
			
			closedir( $folder_res );
			
			$index_count_2 = count( $dir_array_2 );
			sort( $dir_array_2 );
			
			for ( $k = 2; $k < $index_count_2; $k++ ) {

				echo "<tr class=\"Row\">";
				
				echo "<td colspan=\"2\">&nbsp;&nbsp; -> &nbsp; <a href=\"$folder/$dir_array_2[$k]\" target=\"_blank\">$dir_array_2[$k]</a> &nbsp; | &nbsp; <a href=\"page0_3.php?ORDER_NO=$order&del=$folder/$dir_array_2[$k]\" onclick=\"return confirm('Are you sure you want to delete this file?')\">delete</a></td>";
			}
		}
	}

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

