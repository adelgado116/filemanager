<?php

	$letter = $_REQUEST['letter'];

	$dir = "D:/data/container/before_april_2009/".$_REQUEST['letter'].'/';

	// open directory, and proceed to read its contents
	if (is_dir($dir)) {
	
    	if ($dh = opendir($dir)) {
			$dir_array = array();

			while ( ($entry = readdir( $dh )) !== false ) {
				$dir_array[] = $entry;
			}
			
        	closedir($dh);
			
			$index_count = count( $dir_array );
			sort( $dir_array );
			
			// printing of vessel's names is done afterwards...
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> High Sea Support - old files viewer </title>
<link href="css/styles.css" type="text/css" rel="stylesheet">
</head>

<body>

File Manager - [ Services carried out before March 24th, 2009 ]
<br/><br/>
Index: <strong> <?php echo $letter; ?> </strong>

<br/><br/>


<form action="old_files.php" target="file_presenter" method="post">

Select Ship:
<select name="shipname" onchange="this.form.submit();" >
<?php
for ( $i = 2; $i <= $index_count - 1; $i++ ) {
	echo "<option value=\"$dir_array[$i]\">$dir_array[$i]</option> ";
}
?>
</select>
<input type="hidden" name="letter" value="<?php echo $letter; ?>" />

</form>


<div id="iframe_position">

	<iframe name="file_presenter" src ="" width="1000" height="550" frameborder="1"></iframe>

</div>

</body>
</html>