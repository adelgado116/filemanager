<?php

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<title>High Sea Support - Service Report Tool </title>
	<link href="css/report.css" rel="stylesheet" type="text/css" media="all" />

	
	
	<script type="text/javascript" src="ajaxrequest.js"></script>
	
	<script type="text/javascript">
	
		function callAjax(method, oldValue, newValue, target) {
			
			//alert(method + ' - ' + oldValue + ' - ' + newValue + ' - ' + target);
			
			
			if (encodeURIComponent) {
						
				var req = new AjaxRequest();
				var params = "method=" + method + "&oldValue=" + encodeURIComponent(oldValue) + "&newValue=" + encodeURIComponent(newValue) + "&target=" + target;
				req.setMethod("POST");
				req.loadXMLDoc('process_rename_order.php', params);
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

<body OnLoad="document.form.newServiceOrder.focus();">
	
<div id="content"> 
  <!-- 
<div id="title">
	echo $title;
</div>
 -->
  <!-- <form name="form" action="" method="post" target="iframe2"> -->
    <div id="left"> 
      <div class="font9"> 
        
		<table border="0">
		<tr><td>&nbsp;</td><td></td></tr>
		<tr>
			<td>Current Order No.</td>
			<td></td>
			<td>New Order No.</td>
		</tr>
		<tr>
			<td align="center"><strong><?php echo $_REQUEST['serviceOrder']; ?></strong></td>
			<td align="center"> --> </td>
			<td align="center"><input class="textbox" autocomplete="off" id="newServiceOrder" name="newServiceOrder" size="6" maxlength="6" placeholder="6 digits" style="text-transform: uppercase; text-align: center"   onkeyup="if(this.value.length == 6) { buttonDisable(false); } else { buttonDisable(true); }" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td></td>
			<td><div id="rsp_result"><!-- --></div></td>
		</tr>
		
		</table>
      </div>
      <!-- <div class="font9"> -->
    </div>
    <!-- <div id="left"> -->
    
    <div id="submit_button"> 
      <button class="button" type="submit" name="send" id="send" value="send" disabled onClick="callAjax('rename', '<?php echo $_REQUEST['serviceOrder']; ?>', document.getElementById('newServiceOrder').value, document.getElementById('rsp_result').id);" >rename Order</button>
    </div>
  <!-- </form> -->
</div>
<!-- <div id="content">  -->
		
</body>

</html>