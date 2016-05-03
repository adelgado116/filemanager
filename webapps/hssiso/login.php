<?php // index.php - login form 

// session check
session_start();
if (session_is_registered("SESSION")) {   // if the session is not active, display the login form
  header("Location: ./dashboard.php");
} else {

?>

<html>
<head>
<link rel="stylesheet" href="css/login.css" type="text/css" />

</head>
<body>


<div id="login_form">

<div class="font8">

<center>
<br/>
<table border="0" cellspacing="5" cellpadding="5">
<form action="validate_user.php" method="POST">
<tr>
<td>username</td>
<td><input class="textbox" type="text" size="15" name="f_user" maxlength="10"></td>
</tr>
<tr>
<td>password</td>
<td><input class="textbox" type="password" size="15" name="f_pass" maxlength="10"></td>
</tr>
<tr>
<td colspan="2" align="center"><input class="button" type="submit" name="submit" value="log in"></td> </tr> </form> </table>

<hr/>
forgot your password? create one <a href="passgen_a.php">here</a>.

</center>

</div>
</div>

</body>
</html>

<?php
  
}  // else end.

?>
