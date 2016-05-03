<?php
include('functions.php');

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

<div id="form_1">
<div class="font8">
<br>
<center>
To create a new user and password please fill in the following fields.<br>
<br>
<hr>

  <table border="0" cellspacing="5" cellpadding="5">
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
      <tr> 
        <td>username</td>
        <td><input class="textbox" type="text" size="15" name="user" maxlength="10" /></td>
      </tr>
      <tr> 
        <td>password</td>
        <td><input class="textbox" type="password" size="15" name="pass" maxlength="10" /></td>
      </tr>
      <tr> 
        <td>retype password</td>
        <td><input class="textbox" type="password" size="15" name="repass" maxlength="10" /></td>
      </tr>
      <tr>
	  <tr> 
        <td>administrator rights?</td>
        <td><input type="checkbox" name="administrator" value="1" /></td>
      </tr>
      <tr> 
        <td colspan="2" align="center"><input class="button" type="submit" name="submit" value="create user" /></td>
      </tr>
    </form>
  </table>
 
  <hr>
  Notes:<br>
    username and password: must be between 6 an 10 characters long.<br>
    The system only accepts alphanumeric characters.<br>
	You can use either Upper- or Lower- case letters.
 
 </center>
  
  </div>
  </div>
</center>
</body>
</html>

<?php
} else {

  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $repass = $_POST['repass'];
  $admin_rights = $_POST['administrator'];
  
  $flag = 0;  // everything ok @ the beginning...

  // see if the new username already exists !
  include('dbConnect.inc');

  if ( ! @mysql_select_db('configuration_db', $link_id) ) {
    die( '<p>Unable to locate the database at this time. E2</p>' );
  }

  $result = mysql_query( "SELECT * FROM system_users WHERE emp_login='$user'", $link_id );
  
  if ( mysql_num_rows( $result ) != 0 ) {  // the username already exists
    $flag = -1;  // to avoid the program sending data to MySQL
?>

<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="3; newuser.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>This Username already exists,<br> please enter the values again.</center>
</div>
</body>
</html>

<?php
  }  // if ( mysql_num_rows( $result ) != 0 )
  
  else {


  if ( strcmp($pass, $repass) != 0 ) {
    $flag = -1;  // to avoid the program sending data to MySQL
?>

<html>
<head>
<title>error</title>
<link rel="stylesheet" href="css/home.css" type="text/css" />
<meta HTTP-EQUIV="REFRESH" content="3; newuser.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>Passwords mismatch,<br> please enter the values again.</center>
</div>
</body>
</html>

<?php
  }  // if ( strcmp($pass, $repass) != 0 )
  
  }  // end of the "else"

  
  // data validation
  if ( is_alphanum($user) == -1 || is_alphanum($pass) == -1 ) {
    $flag = 1;
  }
  
  switch ($flag) {
    case 0:

	// add new user/password
	$md5pass = md5($pass);
	
	if ( $admin_rights == '1' ) {
	
		$sql = "INSERT INTO system_users (emp_login, emp_password, group_id) VALUES ('$user', '$md5pass', '2')";
	} else {
	
		$sql = "INSERT INTO system_users (emp_login, emp_password, group_id) VALUES ('$user', '$md5pass', '1')";
	}
	
	mysql_query( $sql, $link_id );
	
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
<center>The user was successfully created.</center>
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
<meta HTTP-EQUIV="REFRESH" content="4; newuser.php">
</head>

<body>
<br><br><br><br>

<center><img src="images/bad.png"></center>

<br>
<div class="font12">
<center>Invalid data was entered, please follow the Notes...</center>
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