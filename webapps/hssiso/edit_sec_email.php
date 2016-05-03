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
	2nd e-mail
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

  $result = mysql_query( "SELECT * FROM reports_secondary_email", $link_id );
  $row = mysql_fetch_array($result, MYSQL_ASSOC);
    
  ?>
  <br/>
      <table border="0" cellspacing="5" cellpadding="5">
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
          <tr>
		  	<td></td><td>(enable)</td><td></td>
		  </tr>
		  <tr> 
            <td>2nd e-mail: </td>
            <td align="center"><input type="checkbox" name="enable" value="1" <?php if ($row['enable'] == 1) echo "checked"; ?>/></td>
			<td><input class="textbox" type="text" size="30" name="email" maxlength="50" value="<?php echo $row['secondary_email'] ?>"></td>
          </tr>
          <tr> 
            <td colspan="3" align="center"><br/>
              <input class="button" type="submit" name="submit" value="save changes"></td>
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

	$enable = $_REQUEST['enable'];
	$new_email = $_REQUEST['email'];
	
	if ( is_email( $new_email ) == 0 ) {
	
		include('dbConnect_hssiso.inc');
		
		if ( ! @mysql_select_db('hss_db', $link_id) ) {
		die( '<p>Unable to locate the database at this time. E3</p>' );
		}	
		
		$sql = "UPDATE reports_secondary_email SET enable = '$enable', secondary_email = '$new_email'";		
		$res1 = mysql_query( $sql, $link_id );
		
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
		<center>Your changes have been saved.</center>
		</div>
		</body>
		</html>
		
		<?php
	
	} else {
	
		?>
		
		<html>
		<head>
		<title>error</title>
		<link rel="stylesheet" href="css/home.css" type="text/css" />
		<meta HTTP-EQUIV="REFRESH" content="3; edit_sec_email.php">
		</head>
		
		<body>
		<br><br><br><br>
		
		<center><img src="images/bad.png"></center>
		
		<br>
		<div class="font12">
		<center>Invalid data was entered,<br/>please follow the Notes...</center>
		</div>
		</body>
		</html>
		
		<?php
	}
  
}  // else end.
?>
