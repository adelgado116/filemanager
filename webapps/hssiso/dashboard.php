<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

?>

<html>

<head>
<link rel="stylesheet" href="css/dashboard.css" type="text/css" />
</head>

<body>


<div id="title">
<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
Dashboard
</font>
</div>

<div id="options"> 
  <?php
if ( $_SESSION['admin'] ) {
?>
	<a href="reports_analysis.php">Reports Analysis</a>&nbsp;&nbsp;|&nbsp;
	<a href="new_report.php">Create New Report</a>&nbsp;&nbsp;|&nbsp;
	<a href="changeuser.php"><?php echo $_SESSION['user'].'\'s' ?> profile</a>
	&nbsp;
</div>
<?php
} else {

	include('dbConnect_hssiso.inc');
	 
	if (! @mysql_select_db('hss_db', $link_id) ) {
		die( '<p>Unable to locate the database at this time. E1</p>' );
	}
	
	$emp_login = $_SESSION['user'];
	$sql = "SELECT emp_id FROM employees_tbl WHERE emp_login='$emp_login'";
	$res_emp = mysql_query($sql) or die('Query [emp_id] failed: ' . mysql_error());
	$emp_data = mysql_fetch_array( $res_emp, MYSQL_ASSOC );

?>
	<a href="reports_viewer_frame.php?filter_submitter=<?php echo $emp_data['emp_id']; ?>">View <?php echo $_SESSION['user'].'\'s' ?> Reports</a>&nbsp;&nbsp;|&nbsp;
	<a href="new_report.php">Create New Report</a>&nbsp;&nbsp;|&nbsp;
	<a href="changeuser.php"><?php echo $_SESSION['user'].'\'s' ?> profile</a>
	&nbsp;
</div>
<?php
}
?>

<div id="content">
<br/>space left blank for future use...
<?php
if ( $_SESSION['admin'] ) {
?>

<div id="admin_options">
<div class="font12">
<center>Administrator Tasks</center>
<hr>
&nbsp;Contents Administration
<center>
<br/>
<table border="0">
<tr><td><a href="edit_rep_types.php" >Add/Edit Types of Reports</a><br/></td></tr>
<tr><td><a href="edit_options_frame.php" >Add/Edit Reports Options</a><br/></td></tr>
<tr><td><a href="../employees/index.html" >Add/Edit Employees' Info</a><br/></td></tr>
</table>
</center>
<br/>
&nbsp;QAR Information
<center>
<br/>
<table border="0">
<tr><td><a href="change_qsm.php" >Re-Asign QAR</a><br/></td></tr>
<tr><td><a href="edit_sec_email.php" >Edit Secondary e-mail</a><br/></td></tr>
</table>
</center>
</div>
</div>
<?php
}
?>

</div>


</body>
</html>

