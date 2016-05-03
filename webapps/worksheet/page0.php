<?php

/********************************************************************
 * GET A COMPLETE TABLE FROM A [SELECT * FROM table] QUERY
 * 
 * REMARK: adapted for MSSQL Server
 *
 * notes:
 * This function returns an array of arrays. Every array contained
 * inside de main array is a associative array representing a table
 * row from a MySQL database.
 * 
 *******************************************************************/
function get_table( $result )
{
    $index = 0;
	$a = array();
	
    while ( $row = sqlsrv_fetch_array( $result/*, SQLSRV_FETCH_ASSOC*/ ) ) {
		$a[$index] = $row;
		$index++;
	}
	return $a;
}



/* Specify the server and connection string attributes. */
$serverName = "s-sql.hansbuch.local";
$connectionInfo = array( "UID"=>"HSS", "PWD"=>"HSSintegration", "Database"=>"");

/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "<strong>UNABLE TO CONNECT TO XAL - CONTACT IT DEPARTMENT.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
     die( print_r( sqlsrv_errors(), true));
}

########################  SALES TABLE  ########################
$tsql = "SELECT CREATEDATE,SALESNUMBER,IMOnumber,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT
         FROM SalesTable WHERE DELMODE='OBS' ORDER BY CREATEDATE DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}


$sales_table = array();
$sales_table = get_table( $stmt );



###########################    pages navigation structure    ###########################
$records_per_page = 20;
$pages_qty = ceil( sizeof( $sales_table ) / $records_per_page );

$current_page = $_REQUEST['current'];

if ( $_REQUEST['current'] == '' ) {	$current_page = 1;   }
if ( $_REQUEST['page'] == 'next' ) {
	$current_page = $current_page + 1;
	if ( $current_page >= $pages_qty ) { $current_page = $pages_qty; }  # pages cannot be more than $pagesQty
} else if ( $_REQUEST['page'] == 'prev' ) {
	$current_page = $current_page - 1;
	if ( $current_page <= 0 ) { $current_page = 1; }  # pages must be a positive number
}
########################   end of: pages navigation structure    #########################



$fields = array("CREATEDATE", "SALESNUMBER","IMOnumber","CUSTOMERREF","REQUISNUMBER");


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1252">
<title>page1</title>
<meta content="CodeCharge Studio 4.01.00.06" name="GENERATOR">
<link href="Styles/hss1/Style_doctype.css" type="text/css" rel="stylesheet">
</head>
<body>
<p>
<table width="100%" border="0">
  <tr>
    <td>
      <strong><font color="#000066" size="6">Orders List</font></strong>
    </td>
    <td>
      <!-- <div align="right">
           <a href="login.php?Logout=True">LOGOUT</a>&nbsp;
      </div> -->
    </td>
  </tr>
</table>
</p>


<?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>

<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">


<table width="100%" border="0">
  <tr>
    <td>&nbsp;
      <!-- BEGIN Grid service_tbl -->
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top">
            <table class="Header" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td class="HeaderLeft"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
                <td class="th"><strong>Service Orders</strong></td>
                <td class="HeaderRight"><img alt="" src="Styles/hss1/Images/Spacer.gif" border="0"></td>
              </tr>
            </table>

            <table class="Grid" cellspacing="0" cellpadding="0">
              <tr class="Caption">
                <th scope="col">CREATION DATE</th>
				
				<th scope="col">ORDER NO</th>

                <th scope="col">IMO NUMBER</th>

                <th scope="col">SHIPNAME</th>
                
                <th scope="col">CUSTOMER REQUISITION</th>

                <th scope="col"><div align="center">ACTION</div></th>
				
				<th scope="col"><div align="center">STATUS</div></th>
              </tr>

              <!-- BEGIN Row
              <tr class="Row">  -->
              
              <?php
              // table body
			  
			  #### table displaying structure ########
			  #
			  $init = ($current_page - 1) * $records_per_page;
			  
			  if ( $current_page != $pages_qty ) {
			  	$limit = (($current_page - 1) * $records_per_page) + ($records_per_page - 1);
			  } else {
			  	$limit = ((($current_page - 1) * $records_per_page) + ( sizeof( $sales_table ) % $records_per_page )) - 1;
			  }
			  #
			  #### table displaying structure ########
			  
			  for ( $row_numb = $init; $row_numb <= $limit; $row_numb++ ) {

                      echo "<tr class=\"Row\">";

                      // print data into table cells
                      for ( $f = 0; $f <= ( sizeof($fields) - 1 ); $f++ ) {

                        // format datetime field to be presented as string
						if ( $f == 0 ) {
						  $toPrint = date_format( $sales_table[$row_numb][$f], "d-m-Y" );
						} else {
						  $toPrint = $sales_table[$row_numb][$f];
						}
						
						echo "<td>";
						echo $toPrint;
						echo "</td>";
                          
                      }
                      
                      // THIS IS A TEMPORAL SOLUTION TO THE PROBLEM OF SPACES COMING ALONG WITH THE ORDER NUMBER FROM XAL -- 07JAN2009 --ADE.
                      $sales_table[$row_numb][1] = substr( $sales_table[$row_numb][1], 4, 6 );
                                            
                      ?>
                      <td>
                      <a href="page2.php?ORDER_NO=<?php echo $sales_table[$row_numb][1]; ?>&IMO_NUMBER=<?php echo $sales_table[$row_numb][2]; ?>&SHIPNAME=<?php echo $sales_table[$row_numb][3]; ?>&REQUISNUMBER=<?php echo $sales_table[$row_numb][4]; ?>&SALESNAME=<?php echo $sales_table[$row_numb][5]; ?>&DEBTORACCOUNT=<?php echo $sales_table[$row_numb][6]; ?>">EDIT WORKSHEET</a>
                      </td>
					  
					  <td>
					  <?php  // check the status from service_tbl -> STATUS_ID and set the corresponding indication image
					  /*
					  	require_once('Database/MySQL.php');
					  	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
						
						$order = $sales_table[$row_numb][1];
						
						$sql = "SELECT STATUS_ID FROM service_tbl WHERE ORDER_NO='$order'";
						$res_local = $db->query($sql);
						$status = $res_local->fetch();
						
						echo $;
						
						switch ( $status[0] ) {
							case 1:
								echo "<img src=\"images/1_opened.png\" />";
								break;
							case 2:
								echo "<img src=\"images/2_running.png\" />";
								break;
							case 3:
								echo "<img src=\"images/3_finished.png\" />";
								break;
							case 4:
								echo "<img src=\"images/4_followup.png\" />";
								break;
							case 5:
								echo "<img src=\"images/5_invoice.png\" />";
								break;
							case 6:
								echo "<img src=\"images/6_closed.png\" />";
								break;								
						}
					  */
					  
					  ?>					  
					  </td>
					  
                      <?php
					  
                      echo "</tr>";
             }

             ?>
             
 <!-- END Row -->
 
			<tr>
				<td colspan="6" align="center">
					<input type="hidden" name="lowlimit" value="<?php echo $init; ?>" />
					<input type="hidden" name="uplimit" value="<?php echo $limit; ?>" />
					<input type="hidden" name="pagenumber" value="<?php echo $current_page; ?>" />
				</td>
			</tr>

              <tr class="Footer">
                <td colspan="7">
                  <!-- BEGIN Navigator -->
				  <a href="page0.php?current=<?php echo $current_page; ?>&page=prev">&lt;&lt; prev page</a>
				  |
				  <a href="page0.php?current=<?php echo 1; ?>">first page</a>
				  <?php echo ' [ page '.$current_page.' of '.$pages_qty.' ] '; ?>
				  <a href="page0.php?current=<?php echo $pages_qty; ?>">last page</a>
				  |
				  <a href="page0.php?current=<?php echo $current_page; ?>&page=next">next page &gt;&gt;</a>
                  <!-- END Navigator -->
				</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <!-- END Grid service_tbl --></td>
    <td>
	
	<table>
	<tr>
		<td>
			<font size="+1"><strong>More Options...</strong></font>
			<br/><br/>
			<ul>
			<li><a href="../ws_dummy" target="_blank">CREATE DUMMY WORKSHEET</a></li>
			<br/>
			<li><a href="page2_1.php">EDIT PORTS DATABASE</a></li>
			<br/>
			<li><a href="page2_2.php">EDIT AGENTS DATABASE</a></li>
			<br/>
			<li><a href="page3_1.php">EDIT EQUIPMENTS DATABASE</a></li>
			<br/>
			<li><a href="../file_manager/page1.php">OPEN FILES MANAGER</a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td>
			<br/>
			<font size="+1"><strong>Status Description</strong></font>
			<br/><br/>
			future development...
			<!-- <img src="images/status_description.PNG" /> -->
		</td>
	</tr>
	</table>
	
    </td>
  </tr>

</table>

</form>



<?php 

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);


} else {

	#################################
	# PROCESS THE SUBMITTED DATA
	#################################
	
	# just display the same page once again with new values from database
	header('Location: page0.php?current='.$_REQUEST['pagenumber'] );
}
?>

</body>
</html>

