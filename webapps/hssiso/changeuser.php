<?php
include('functions_hssiso.php');

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

$user = $_SESSION['user'];


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>

<html>
<head>
<link rel="stylesheet" href="css/login.css" type="text/css" />
</head>
<body>
	
	<div id="title">
	<font size="+2" color="#000000"  face="Verdana, Arial, Helvetica, sans-serif">
	<?php echo $user.'\'s profile'; ?>
	</font>
	</div>

  <div id="form_2">
  <div class="font8">
  
  <center>
  
  <?php
  
  # get user's information from database
  include('dbConnect_hssiso.inc');

  if ( ! @mysql_select_db('hss_db', $link_id) ) {
    die( '<p>Unable to locate the database at this time. E2</p>' );
  }

  $result = mysql_query( "SELECT * FROM employees_tbl WHERE emp_login='$user'", $link_id );
  $row = mysql_fetch_array($result, MYSQL_ASSOC);
  
  
  ?>

  <table border="0" cellspacing="5" cellpadding="5">
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
      <tr> 
        <td>username</td>
        <td colspan="2"><?php echo $user ?>
		<input type="hidden" name="emp_id" value="<?php echo $row['emp_id'] ?>" />
		</td>
      </tr>
	  <tr> 
        <td>Full Name</td>
        <td colspan="2"><input class="textbox" type="text" size="30" name="fullname" maxlength="50" value="<?php echo $row['emp_name'] ?>"></td>
      </tr>
	  <tr> 
        <td>e-mail</td>
        <td colspan="2"><input class="textbox" type="text" size="30" name="email" maxlength="50" value="<?php echo $row['email'] ?>"></td>
      </tr>
	  <tr> 
        <td width="150">New Password</td>
        <td><input class="textbox" type="password" size="15" name="new_pass" maxlength="10"></td> 
		<td class="font8" rowspan="2" bgcolor="DDDDDD"><font color="#006699">leave fields<br/>blank if you<br/>don't want to<br/>change your<br/>password.</font></td>
      </tr>
      <tr> 
        <td>Retype Password</td>
        <td><input class="textbox" type="password" size="15" name="renew_pass" maxlength="10"></td>
      </tr>
      <tr> 
        <td colspan="4" align="center"><br/><input class="button" type="submit" name="submit" value="update profile"></td>
      </tr>
    </form>
  </table>


<br>
<hr>
Notes:<br>
    username and password: must be between 6 an 10 characters long.<br>
    The system only accepts alphanumeric characters.<br>
	You can use either Upper- or Lower- case letters.<br>
	Make sure to enter a valid e-mail address.

</center>

</div>
</div>


</body>
</html>

<?php
} else {

  $user = $_POST['user'];
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $newpass = $_POST['new_pass'];
  $renewpass = $_POST['renew_pass'];
  
  $flag = 0;  // all data is considered good at the beginning
  
  if ( strcmp($newpass, $renewpass) != 0 ) {
?>

<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="3; changeuser.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>Passwords mismatch,<br/>please enter the values again.</center>
</div>
</body>
</html>


<?php
	
	exit();
	
  }  // end of: if ( strcmp($pass, $repass) != 0 )
  
  // data validation
  if ( $newpass != "" ) {
  
  	if ( is_alphanum($newpass) == -1 || is_email($email) == -1 ) {
		$flag = 1;
	}
	
  } else {
  
	if ( is_email($email) == -1 ) {
		$flag = 1;
	}
  }

  switch ($flag) {
    case 0:
	
	include('dbConnect_hssiso.inc');
	
	if ( ! @mysql_select_db('hss_db', $link_id) ) {
    die( '<p>Unable to locate the database at this time. E3</p>' );
	}
	// change the values for the current user in MySQL
	$emp_id = $_REQUEST['emp_id'];	
	
	if ( $newpass != "" ) {
		$md5pass = md5($newpass);
		$sql = "UPDATE employees_tbl SET emp_password = '$md5pass', email = '$email', emp_name = '$fullname' WHERE emp_id = $emp_id";
	} else {
		$sql = "UPDATE employees_tbl SET email = '$email', emp_name = '$fullname' WHERE emp_id = $emp_id";
	}
		
	$res2 = mysql_query( $sql, $link_id );
	
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
<center>Your profile was successfully updated.</center>
</div>
</body>
</html>

<?php
	break;
    case 1:
?>
<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="4; changeuser.php">
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
	break;
    default:
    break;
  }  // switch end.
  
}  // else end.
?>