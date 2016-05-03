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
Edit Reports Options
</font>
</div>



<div id="options"> 

<form name="sel" action="edit_options.php" method="post" target="report_iframe">
    <p>
	<font class="font8"><strong>Filter Options: &nbsp;</strong></font>
      <select name="filter_report_type" onchange="sel.submit()" style="color:black; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:84%;
	  font-weight:bold; background-color:white; border:none; border-top-color:white; border-left-color:white; border-right-color:white;
	  border-bottom-color:white">
        <option value="0">Select type of report</option>
		<?php
		
		while ( $row = mysql_fetch_array($res, MYSQL_ASSOC) ) {
			echo '<option value="'.$row['rep_id'].'"> '.$row['rep_name'].'</option>';
		}		
		
		?>
      </select>&nbsp;&nbsp;
    </p>
</form>

</div>

<div id="content">

<iframe name="report_iframe" id="report_iframe" src="edit_options.php" frameborder="0" height="498" width="735" scrolling="auto">
</iframe>

</div>


</body>
</html>

