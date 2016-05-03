<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

require_once('functions_hssiso.php');

#
#  check if user has selected the REPORT TYPE
#  (if not, show a message asking him/her to select REPORT TYPE)
#
if ( ($_REQUEST['select_report_type'] == '') || ($_REQUEST['select_report_type'] == '0') ) {

	echo '<br/>';
	echo 'Please select an option from drop-down menu.';
	exit();
}

include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

$rep_id = $_REQUEST['select_report_type'];

$sql = "SELECT * FROM reports_types WHERE rep_id='$rep_id'";
$res = mysql_query($sql, $link_id);

$row = mysql_fetch_array($res, MYSQL_ASSOC);

$title = $row['rep_name'];


#
#  get options list for the selected type of report
#
$sql = "SELECT * FROM reports_options_list WHERE rep_id='$rep_id' AND show_option='1' ORDER BY rep_option ASC";
$res2 = mysql_query($sql, $link_id);

$table = get_table( $res2 );

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<object classid="CLSID:B0969A2F-A482-FF8B-784F-EEF521552178" type="application/x-oleobject"></object>

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>High Sea Support - ISO REPORTS </title>
	<link href="css/report.css" rel="stylesheet" type="text/css" media="all" />

</head>

<body>
	
<div id="content"> 
  <!-- 
<div id="title">
	echo $title;
</div>
 -->
  <form name="theForm" action="process_report.php" method="post" target="iframe2">
    <input type="hidden" name="report_type" value="<?php echo $_REQUEST['select_report_type']; ?>"/>
    <div id="left"> 
      <div class="font9"> 
        <?php
for ( $i = 0; $i <= (sizeof($table) - 1); $i++ ) {
	echo "<input type=\"checkbox\" name=\"ck_box".$i."\" value=\"".$table[$i]['rep_opt_id']."\" />".$table[$i]['rep_option'];
	echo "<input type=\"hidden\" name=\"option".$i."\" value=\"".$table[$i]['rep_option']."\"/>";
	echo '<br/>';
}
echo "Other:&nbsp;<input class=\"textbox\" name=\"other_text\" size=\"55\" maxlenght=\"100\"/>";

?>
        <input type="hidden" name="ck_box_qty" value="<?php echo sizeof($table); ?>"/>
        <hr>
        Remarks:<br/>
        <textarea class="textarea_box" name="remarks" cols="70" rows="2"></textarea>
        <br/>
        Corrective Action: 
        <textarea class="textarea_box" name="corrective" cols="70" rows="2"></textarea>
        <br/>
        Proposed Preventive Action: 
        <textarea class="textarea_box" name="preventive" cols="70" rows="2"></textarea>
      </div>
      <!-- <div class="font8"> -->
    </div>
    <!-- <div id="left"> -->
    <div id="right"> 
      <div class="font8"> <br/>
        <br/>
        Date:&nbsp;&nbsp; 
        <?php echo date('d / M / Y'); ?>
        <br/>
        <br/>
        Report submitted by:&nbsp;&nbsp; 
        <?php echo $_SESSION['user']; ?>
        <br/>
        <br/>
        Reference: 
        <input class="textbox" type="text" name="service_order" size="10" maxlength="6" />
        <br/>
        <br/>
        <br/>
        <br/>
        Memo 
        <hr>
        <br/>
        Internal:&nbsp 
        <select name="memo_internal" >
          <option value="0">select an option</option>
          <?php
			
			$sql = "SELECT * FROM employees_tbl";
			$res = mysql_query($sql, $link_id);
			
			//$i = 0;
			while ( $row2 = mysql_fetch_array($res, MYSQL_ASSOC) ) {
			
				//echo '<option value="'.($i + 1).'"> '.$row['emp_login'].'</option>';
				echo '<option value="'.$row2['emp_id'].'"> '.$row2['emp_login'].'</option>';
				//$i++;
			}		
			
			?>
        </select>
        <br/>
        <br/>
        External:<br/>
        <input class="textbox" type="text" name="memo_external" size="25" maxlength="25" />
      </div>
      <!-- <div class="font9"> -->
    </div>
    <!-- <div id="right"> -->
    <div id="submit_button"> 
      <button class="button" type="submit" name="send" value="send" >submit report</button>
    </div>
  </form>
</div>
<!-- <div id="content">  -->
		
</body>

</html>