<?php

require_once('Database/MySQL.php');

$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$imo = $_REQUEST['IMO_NUMBER'];
$order = $_REQUEST['ORDER_NO'];

$sql = "SELECT SHIP_NAME, location_in_server FROM ships_tbl WHERE IMO_NUMBER='$imo'";
$res1 = $db->query($sql);
$res1_value = $res1->fetch();

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
      <p><strong><font color="#000066" size="6">File Manager</font></strong></p>
    </td>
    <td>
      <div align="right">&nbsp;<!-- <a href="page1_1.php"><strong>RETURN TO ORDERS LIST</strong></a> --></div>
    </td>
  </tr>
</table>

<table border="0">
<tr><td></td><td colspan="3">SHIP NAME: &nbsp;&nbsp;<font size="+2"><?php echo $res1_value['SHIP_NAME']; ?></font></td></tr>
<tr><td></td><td>IMO: &nbsp;&nbsp;<font size="+2"><?php echo $imo; ?></font></td></tr>
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

	$order_dir = opendir( $res1_value['location_in_server']."/".$order );
	
	while ( $entry = readdir( $order_dir ) ) {
		$dir_array[] = $entry;
	}
	
	closedir( $order_dir );
	
	$index_count = count( $dir_array );
	sort( $dir_array );
				
	for( $j = 2; $j < $index_count; $j++) {
	
		$dir_array_2 = array();
		
		$folder = $res1_value['location_in_server']."/".$order."/".$dir_array[$j];
	
		if (substr("$dir_array[$j]", 0, 1) != ".") { // don't list hidden files

			?>
			<tr class="Row">
			<td><?php echo "$dir_array[$j]"; ?></td>
			
			<td>
			<form enctype="multipart/form-data" action="upload.php" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
				<input type="hidden" name="folder_path" value="<?php echo $folder; ?>"/>
				<input name="uploaded_file" type="file" />
				<input type="submit" value="Upload" />
			</form>
			</td>
			
			</tr>
			<?php 
			
			$folder_res = opendir( $folder );
			
			while ( $dir_element = readdir( $folder_res ) ) {			
				$dir_array_2[] = $dir_element;
			}
			
			closedir( $folder_res );
			
			// debug
			//print_r( $dir_array_2 );
			
			$index_count_2 = count( $dir_array_2 );
			sort( $dir_array_2 );
			
			for ( $k = 2; $k < $index_count_2; $k++ ) {

				echo "<tr class=\"Row\">";
				
				echo "<td colspan=\"2\">&nbsp;&nbsp; -> &nbsp; <a href=\"$folder/$dir_array_2[$k]\" target=\"_blank\">$dir_array_2[$k]</a> </td>";
				
				echo "</tr>";  // end row
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