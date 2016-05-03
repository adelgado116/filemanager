<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

require('functions_hssiso.php');

include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

$sql = "SELECT * FROM reports_types ORDER BY rep_id ASC";
$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());

$sql = "SELECT * FROM days_tbl";
$result_days = mysql_query($sql) or die('Query 2 failed: ' . mysql_error());

$sql = "SELECT * FROM months_tbl";
$result_months = mysql_query($sql) or die('Query 3 failed: ' . mysql_error());

$sql = "SELECT * FROM employees_tbl";
$result_employees = mysql_query($sql) or die('Query 4 failed: ' . mysql_error());

?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" href="css/iframe.css" />
<title></title>
</head>

<body>

<div id="title"> <font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif"> 
  Reports Analysis </font> </div>


<div id="filtersContainer_analysis">

<div class="tableTitle">FILTER BY</div>

<br/>

<div class="font12">

<form action="reports_analysis_results.php" method="post" target="results_iframe" >

Type of Report:<br/>
<select name="filter_report_type" class="textbox" >
<option value="0">_</option>
<?php

while ( $row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
	echo '<option value="'.$row['rep_id'].'"> '.$row['rep_name'].'</option>';
}		

?>
</select>

<br/><br/>

Submission Date:<br/>

<table border="0">
<tr align="center" class="font8">
<td>day</td><td>month</td><td>year</td>
</tr>
<tr align="center">
<td>
<select name="filter_date_day" class="textbox" >
<option value="0">_</option>
<?php

while ( $row2 = mysql_fetch_array($result_days, MYSQL_ASSOC) ) {
	echo '<option value="'.$row2['days'].'"> '.$row2['days'].'</option>';
}		

?>
</select>
</td>
<td>
<select name="filter_date_month" class="textbox" >
<option value="0">_</option>
<?php

while ( $row3 = mysql_fetch_array($result_months, MYSQL_ASSOC) ) {
	echo '<option value="'.$row3['months'].'"> '.$row3['months'].'</option>';
}		

?>
</select>
</td>
<td>
<input name="filter_date_year" class="textbox" size="4" maxlength="4" />
</td>
</tr>
</table>

<br/>

Submitter:
<select name="filter_submitter" class="textbox" >
<option value="0">_</option>
<?php

while ( $row4 = mysql_fetch_array($result_employees, MYSQL_ASSOC) ) {
	echo '<option value="'.$row4['emp_id'].'"> '.$row4['emp_login'].'</option>';
}		

?>
</select>

<br/><br/>

Reference:
<input class="textbox" type="text" name="filter_reference" size="8" maxlength="6" />

<br/><br/>


</div>  <!-- class: font12 -->


<center>
<input class="button" type="reset" value="reset">
<button class="button" type="submit" name="send" value="send" >search</button>
</center>

</form>

</div> <!-- filtersContainer_analysis -->

<div id="tableContainer_analysis">

<iframe id="results_iframe" name="results_iframe" src="reports_analysis_results.php" width="575" height="500" frameborder="0" ></iframe>

</div> <!-- tableContainer_analysis -->

</body>
</html>
