<?php

if ( $_REQUEST['message'] == 'not_ok' ) {

	$message_to_display = "Error uploading file.<br/><br/><strong><font color=\"red\">Please use the \"RETURN TO FILE MANAGER\" link and try again.</font></strong>";
	$qty = 1;
}

if ( $_REQUEST['message'] == 'ok' ) {

	$message_to_display = "The file has been saved as: ".$_REQUEST['path'];
	$qty = 1;
		
} else {

	if ( $_REQUEST['message'] == 'empty' ) {
	
		//$message_to_display = "error.<br/>Please contact system administrator";
		$message_to_display = "Error.<br/>No file selected.<br/><br/><strong><font color=\"red\">Please use the \"RETURN TO FILE MANAGER\" link and try again.</font></strong>";
		$qty = 0;
	} else {
	
		if ( $_REQUEST['message'] == 'new' ) {
		
			$message_to_display = "The new file has been saved as: ".$_REQUEST['path'];
			$qty = 1;
			
		} else {
		
			if ( $_REQUEST['message'] == 'too_big' ) {
			
				$message_to_display = "Error.<br/>The file You are trying to upload is too big.<br/><br/><strong><font color=\"red\">Please use the \"RETURN TO FILE MANAGER\" link and try again.</font></strong>";
				$qty = 0;
			}
		}
	}
}

?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page2</title>
<meta content="CodeCharge Studio 4.1.00.032" name="GENERATOR">
<link href="Styles/Blueprint1/Style_doctype.css" type="text/css" rel="stylesheet">


<table width="100%" border="0">
  <tr>
    <td>
      <p><strong><font color="#000066" size="6">File Manager</font></strong></p>
    </td>
    <td>
      <div align="right">&nbsp;<a href="#" onClick="history.go(-1)"><strong>RETURN TO FILE MANAGER</strong></a></div>
    </td>
  </tr>
</table>


<table cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td valign="top">
      <table class="Header" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td class="HeaderLeft"><img alt="" src="Styles/Blueprint1/Images/Spacer.gif" border="0"></td> 
          <td class="th"><strong>Operation Result</strong></td> 
          <td class="HeaderRight"><img alt="" src="Styles/Blueprint1/Images/Spacer.gif" border="0"></td>
        </tr>
      </table>
 
      <table class="Grid" cellspacing="0" cellpadding="0">
        <tr class="Caption">
          <th scope="col">RESULT</th>
 
          <th scope="col">UPLOADED FILES</th>
        </tr>
 
        <!-- BEGIN Row -->
		
		<tr class="Row">
			<td><?php echo $message_to_display; ?></td>
			<td><div align="center"><?php echo $qty; ?></div></td>
		</tr>
		
		<tr class="Footer">
          <td colspan="2"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>

   
</body>
</html>

