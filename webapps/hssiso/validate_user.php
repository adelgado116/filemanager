<?php
// login.php - performs validation
// authenticate using form variables

include('functions_hssiso.php');

$status = authenticate( $_POST['f_user'], md5($_POST['f_pass']) );
// if user/pass combination is correct
if ( $status == 1 ) {
  // initiate a session
  session_start();
  // register some session variables
  session_register("SESSION");

	$_SESSION['user'] = $_POST['f_user'];
  
  // redirect to protected page
  header("Location: ./dashboard.php");
  exit();
  
} else {  // user/pass check failed

	if ( $status == 2 ) {
	
		// initiate a session
		session_start();
		// register some session variables
		session_register("SESSION");
		
		$_SESSION['user'] = $_POST['f_user'];
		
		$_SESSION['admin'] = true;
		
		// redirect to protected page
		header("Location: ./dashboard.php");
		exit();
	}
  // redirect to error page
  header("Location: ./error.php");
  exit();
}

?>
