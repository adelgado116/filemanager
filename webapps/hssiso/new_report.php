<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

$sql = "SELECT * FROM reports_types WHERE show_option='1'";
$res = mysql_query($sql, $link_id);

?>

<html>

<head>
<link rel="stylesheet" href="css/dashboard.css" type="text/css" />
</head>

<body>


<div id="title">
<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
Create New Report
</font>
</div>

<div id="options"> 

<form name="sel" action="report1.php" method="post" target="report_iframe">
    <p>
	<font class="font8"><strong>Report for: &nbsp;</strong></font>
      <select name="select_report_type" onchange="sel.submit()" style="color:black; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:84%;
	  font-weight:bold; background-color:white; border:none; border-top-color:white; border-left-color:white; border-right-color:white;
	  border-bottom-color:white">
        <option value="0">Select type of report</option>
		<?php
		
		
		//$i = 0;
		while ( $row = mysql_fetch_array($res, MYSQL_ASSOC) ) {
		
			//echo '<option value="'.($i + 1).'"> '.$row['rep_name'].'</option>';
			echo '<option value="'.$row['rep_id'].'"> '.$row['rep_name'].'</option>';
			//$i++;
		}		
		
		?>
      </select>&nbsp;&nbsp;
    </p>
</form>

</div>

<div id="content">

<iframe name="report_iframe" id="report_iframe" src="report1.php" frameborder="0" height="498" width="735" scrolling="auto">
</iframe>

</div>


</body>
</html>

