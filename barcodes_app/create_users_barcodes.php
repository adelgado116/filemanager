<?php

/*******************************************************
	- bring employees information from database
	- take emp_id number and concatenate it to "IDEMP_"
	- take emp_login and use it as the *.png filename
	- print out the generated barcodes
*******************************************************/

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

require_once('code128.class.php');

	#
	# Get data from employees table
	#
	$sql = "SELECT * FROM employees_tbl";
	
	$result = $db->query($sql);
	
	while ( $row = $result->fetch() ) {
	
		$emp_id = $row['emp_id'];
		$emp_login = $row['emp_login'];
		
		
		#
		#  Generate Barcode
		#
		$barcode = new phpCode128('IDEMP_'.$emp_id, 70, 'Dustismo_Roman.ttf', 12);
		// hide barcode text
		$barcode->setEanStyle(FALSE);
		$barcode->setShowText(FALSE);
		// remove barcode border
		$barcode->setBorderWidth(0);
		$barcode->setBorderSpacing(0);
		// setPixelWidth set to 2
		$barcode->setPixelWidth(2);
		$barcode->setAutoAdjustFontSize(FALSE);
		$barcode->setTextSpacing(5);
		// save barcode image
		$barcode->saveBarcode("$emp_login.png");
		
		
		echo "<img src=\"$emp_login.png\" /><br>$emp_login<br><br>";

	}
	
?>

<!-- <html>
<body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;">
<table width="1000">
<tr>
    <td width="307"><img src="IDEMP_2_ADE.png" /><br/>
      ADE</td>
    <td width="297"><img src="IDEMP_3_JQU.png" /><br/>
      JQU</td><td width="380"><img src="IDEMP_5_CAP.png" /><br/>CAP</td>
</tr>
<tr>
	<td width="307"><br/><img src="HSS_TID1.png" /><br/>
      tool 1</td>
    <td width="297"></br><img src="HSS_TID5.png" /><br/>
      tool 5</td><td width="380"></br><img src="HSS_TID10.png" /><br/>tool 10</td>
</tr>
<tr>
	<td width="307"></br><img src="YES.png" /><br/>
      YES</td>
    <td width="297"></br><img src="NO.png" /><br/>NO</td>
	<td width="380"></td>
</tr>
<tr>
	<td width="307"></br><img src="IN.png" /><br/>
      IN</td>
    <td width="297"></br><img src="OUT.png" /><br/>OUT</td>
	<td width="380"></td>
</tr>
<tr>
	<td width="307"></td>
    <td width="297"></td>
	<td width="380"></td>
</tr>
<tr>
	<td width="307"></td>
    <td width="297"></td>
	<td width="380"><img src="EXIT.png" /><br/>EXIT</td>
</tr>
</table>


</body>
</html> -->