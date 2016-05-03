<?php



require_once('functions_hssiso.php');


include('dbConnect_hssiso.inc');

if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>High Sea Support - Service Report Tool </title>
	<link href="css/report.css" rel="stylesheet" type="text/css" media="all" />

	
	
	<script type="text/javascript" src="ajaxrequest.js"></script>
	
	<script type="text/javascript">
	
		function callAjax(method, value, target) {
			
			if (encodeURIComponent) {
				var req = new AjaxRequest();
				var params = "method=" + method + "&value=" + encodeURIComponent(value) + "&target=" + target;
				req.setMethod("POST");
				req.loadXMLDoc('check_serviceOrder.php', params);
			}
		}
		
		
		function buttonDisable(state) {
			
			var button = document.getElementById('send');
			
			button.disabled = state;
		
		}
		
		function checkForm(form) {
		
			if(this.serviceOrder.value == "") {
				alert("Enter Service Order Number");
				this.serviceOrder.focus();
				return false;
			}
			
			//alert("form ok.");
			
			return false;
		}
	
	</script>

</head>

<body OnLoad="document.form.serviceOrder.focus();">
	
<div id="content"> 
  <!-- 
<div id="title">
	echo $title;
</div>
 -->
  <form name="form" action="parts_list.php" method="post" target="iframe2">
    <div id="left"> 
      <div class="font9"> 
        
		<table border="0">
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td><strong>Service Order:</strong></td><td><input class="textbox" autocomplete="off" id="serviceOrder" name="serviceOrder" placeholder="6 digits" size="6" maxlength="6" onkeyup="if(this.value != '' & this.value.length == 6) { callAjax('checkOrderNo', this.value, this.id); } else { callAjax('clearMessage', this.value, this.id); }  if(this.value.length == 6) { buttonDisable(false); } else { buttonDisable(true); }" style="text-transform: uppercase; text-align: center" /> (use temporary code if Order is not available)</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td rowspan=3><div id="rsp_serviceOrder"><!-- --></div></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		
		<tr>
			<td>Vessel Name:</td><td><input class="textbox" id="vesselName" name="vesselName" size="30" maxlength="30" disabled /></td>
		</tr>
		<tr>
			<td>IMO:</td><td><input class="textbox" id="imo" name="imo" size="6" maxlength="7" disabled /></td>
		</tr>
		<tr>
			<td>Place:</td><td><input class="textbox" id="place" name="place" size="35" maxlength="40" disabled /></td>
		</tr>
		<tr>
			<td>Agent:</td><td><input class="textbox" id="agent" name="agent" size="35" maxlength="40" disabled /></td>
		</tr>
		<tr>
			<td>Customer Order:</td><td><input class="textbox" id="customerOrder" name="customerOrder" size="15" maxlength="20" disabled /></td>
		</tr>
		<tr>
			<td>Type of Service:</td><td><input class="textbox" id="typeOfService" name="typeOfService" size="35" maxlength="40" disabled /></td>
		</tr>
		<tr>
			<td>Equipment:</td><td><input class="textbox" id="equipment" name="equipment" size="35" maxlength="40" disabled /></td>
		</tr>
		</table>
      </div>
      <!-- <div class="font9"> -->
    </div>
    <!-- <div id="left"> -->
    
    <div id="submit_button"> 
      <button class="button" type="submit" name="send" id="send" value="send" disabled>continue</button>
    </div>
  </form>
</div>
<!-- <div id="content">  -->
		
</body>

</html>