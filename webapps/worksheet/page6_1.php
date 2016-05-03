<?php

session_start();

require_once('Database/MySQL.php');

$order = $_SESSION['ORDER'];


?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page6_1</title>
<meta content="CodeCharge Studio 4.01.00.06" name="GENERATOR">
<link href="Styles/hss1/Style_doctype.css" type="text/css" rel="stylesheet">
</head>
<body>

<p>
<table width="100%" border="0">
  <tr>
    <td>
      <p><strong><font color="#000066" size="6">List of Generated Documents</font></strong></p>
    </td>
    <td>
      <div align="right">
	  	<a href="page5.php"><strong>WORKSHEET REVIEW</strong></a>
		&nbsp;&nbsp;|&nbsp;&nbsp;
		<a href="page6_2.php" target="_blank"><strong>CREATE CUSTOMER SATISFACTION REPORT</strong></a>
      </div>
    </td>
  </tr>
</table>
</p>


<table width="100%" border="0">
  <tr>
    <td>

      <!-- BEGIN Grid service_tbl -->
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top">
            <table class="Header" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td class="HeaderLeft"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
                <td class="th"><strong>Generated Documents for Order No. <?php echo $order; ?></strong></td>
                <td class="HeaderRight"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
              </tr>
            </table>

            <table class="Grid" cellspacing="0" cellpadding="0">
              <tr class="Caption">
                <th scope="col">EQUIPMENT</th>

                <th scope="col">WORKSHEET (click on name to open Worksheet)</th>
              </tr>

              <?php

              $db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
              $sql = "SELECT * FROM service_items_tbl WHERE ORDER_NO='$order'";
              $res1 = $db->query($sql);


              for ( $i = 0; $i <= ($res1->size() - 1); $i++ ) {

                  $row = $res1->fetch();
                  
                  $equip_id = $row['EQUIP_ID'];
                  $sql = "SELECT EQUIP_MODEL FROM equipment_model_tbl WHERE EQUIP_ID='$equip_id'";
                  $res2 = $db->query($sql);
                  $desc = $res2->fetch();


                  echo "<tr class=\"Row\">";
                  
				  // equipment description
                  echo "<td>";
				  
                  echo $desc['EQUIP_MODEL'];
				  
                  echo "</td>";
				  
                  // links to documents
                  echo "<td>";
				  
				  echo "<a href=\"".$row['path_to_doc']."\" target=\"_blank\">".end( explode( '/', $row['path_to_doc'] ) )."</a>";
				  
                  echo "</td>";
				  
                  echo "</tr>";
              }
              
              ?>

              <tr class="Footer">
                <td colspan="2">
                  <!-- BEGIN Navigator Navigator -->
                  <!-- END Navigator Navigator --></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <!-- END Grid service_tbl --></td>


    <td>
	
	<!-- <a href="page6_2.php" target="_blank"><strong>CREATE CUSTOMER SATISFACTION REPORT</strong></a> -->
    </td>
  </tr>

</table>

</body>
</html>

