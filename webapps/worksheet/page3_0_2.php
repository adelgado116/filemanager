<?php

switch ( $_REQUEST['status'] ) {

	case "failed":
		$message = "<font color=\"#FF0000\"><strong>FAILED SENDING EMAIL</strong></font>";
		break;
		
	case "empty":
		$message = "<font color=\"#FF0000\"><strong>PLEASE ENTER A VALID E-MAIL ADDRESS</strong></font>";
		break;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<meta http-equiv="REFRESH" content="3;url=page3.php">
<title>send automatic mail</title>
<meta content="CodeCharge Studio 4.01.00.06" name="GENERATOR">
<link href="Styles/hss1/Style_doctype.css" type="text/css" rel="stylesheet">
</head>
<body>

<br/><br/><br/><br/><br/><br/>

<center>

<?php echo $message; ?>

</center>


</body>
</html>