<?php

#


?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

<link rel="stylesheet" href="css/login.css" type="text/css" />

</head>
<body>

<div id="form_1">
<div class="font8">
<br>
<center>
Please provide the following information to get a new password.<br>
<br>
<hr>

  <table border="0" cellspacing="5" cellpadding="5">
    <form action="passgen_b.php" method="POST">
      <tr> 
        <td>username</td>
        <td><input class="textbox" type="text" size="15" name="user" maxlength="10" /></td>
      </tr>
      <tr> 
        <td>e-mail</td>
        <td><input class="textbox" type="text" size="25" name="email" maxlength="35" /></td>
      </tr>
      <tr> 
        <td>retype e-mail</td>
        <td><input class="textbox" type="text" size="25" name="reemail" maxlength="35" /></td>
      </tr>
      <tr>
	    <td colspan="2" align="center"><br/><input class="button" type="submit" name="submit" value="generate password" /></td>
      </tr>
    </form>
  </table>
 
 </center>
  
  </div>
  </div>
</center>
</body>
</html>
