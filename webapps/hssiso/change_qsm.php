<?php

include('functions_hssiso.php');

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<html>
<head>
<link rel="stylesheet" href="css/login.css" type="text/css" />
</head>
<body>
	
	<div id="title">
	<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
	QAR Designation
	</font>
	</div>

  
<div id="form_3"> 
  <div class="font8"> 
    <center>
      <?php
  
  # get user's information from database
  include('dbConnect_hssiso.inc');

  if ( ! @mysql_select_db('hss_db', $link_id) ) {
    die( '<p>Unable to locate the database at this time. E2</p>' );
  }

  $result = mysql_query( "SELECT * FROM employees_tbl", $link_id );
  //$row = mysql_fetch_array($result, MYSQL_ASSOC);
  $table = get_table( $result );
    
  ?>
  <br/>
      <table border="0" cellspacing="5" cellpadding="5">
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
          <tr> 
            <td>High Sea Support's current QAR is: </td>
            <td colspan="2">
				<select name="select_qsm">
				<?php
				for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
				
					?>
					<option value="<?php echo $table[$i]['emp_id']; ?>" <?php if ($table[$i]['qsm'] == 1) echo 'selected'; ?> ><?php echo $table[$i]['emp_login'] ?></option>
					<?php
				}
				?>
				</select> 
          </tr>
          <tr> 
            <td colspan="4" align="center"><br/>
              <input class="button" type="submit" name="submit" value="save change"></td>
          </tr>
        </form>
      </table>
	  <br/>
    </center>
  </div>
</div>


</body>
</html>

<?php
} else {

	$new_qsm = $_REQUEST['select_qsm'];
	
	include('dbConnect_hssiso.inc');
	
	if ( ! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E3</p>' );
	}

/*	
	$sql = "SELECT emp_id FROM employees_tbl";		
	$res1 = mysql_query( $sql, $link_id );
	$employees = get_table( $res1 );
	
	for ( $i = 0; $i <= (sizeof( $table ) - 1); $i++ ) {
*/
		$sql = "UPDATE employees_tbl SET qsm = '0'";
		$res2 = mysql_query( $sql, $link_id );
//	}
	
	
	$sql = "UPDATE employees_tbl SET qsm = '1' WHERE emp_id = $new_qsm";		
	$res3 = mysql_query( $sql, $link_id );
	
	mysql_close($link_id);
	
?>

<html>
<head>
<title>ok</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="4; dashboard.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/good.png"></center>

<br>
<div class="font12">
<center>Your change has been saved.</center>
</div>
</body>
</html>

<?php
  
}  // else end.
?>
