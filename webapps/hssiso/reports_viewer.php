<?php

// session check
session_start();
if (!session_is_registered("SESSION")) {
  // if session check fails, invoke error handler
  header("Location: ./error.php");
  exit();
}

require('functions_hssiso.php');

include('dbConnect_hssiso.inc');
	 
if (! @mysql_select_db('hss_db', $link_id) ) {
	die( '<p>Unable to locate the database at this time. E1</p>' );
}

#
#	get filter parameters coming from reports_analysis.php
#

# type of report
if ( !isset($_REQUEST['filter_report_type']) ) {	
	$report_type = 0;
} else {
	$report_type = $_REQUEST['filter_report_type'];
}

# submission date
if ( $_REQUEST['filter_date_day'] == 0 ) {
	$day = 0;
} else {
	$day = $_REQUEST['filter_date_day'];
}

if ( $_REQUEST['filter_date_month'] == 0 ) {
	$month = 0;
} else {
	$month = $_REQUEST['filter_date_month'];
}

if ( $_REQUEST['filter_date_year'] == "" ) {
	$year = 0;
} else {
	$year = $_REQUEST['filter_date_year'];
}

# submitter
if ( $_REQUEST['filter_submitter'] == 0 ) {
	$submitter = 0;
} else {
	$submitter = $_REQUEST['filter_submitter'];
}

# reference
if ( $_REQUEST['filter_reference'] == "" ) {
	$reference = 0;
} else {
	$reference = $_REQUEST['filter_reference'];
}


# get total amount of reports store in reports_repository_main
$sql = "SELECT * FROM reports_repository_main ORDER BY report_id ASC";
$result_total = mysql_query($sql) or die('Query 0 failed: ' . mysql_error());
$total = mysql_num_rows($result_total);

#
#	generate SQL QUERY
#

# no filters
if ( ($report_type == 0) && ($submitter == 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT * FROM reports_repository_main ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
}

# all filters set
if ( ($report_type != 0) && ($submitter != 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 2 failed: ' . mysql_error());
}

# report type filter set
if ( ($report_type != 0) && ($submitter == 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 3 failed: ' . mysql_error());
}

# submitter filter set
if ( ($report_type == 0) && ($submitter != 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 4 failed: ' . mysql_error());
}

# reference filter set
if ( ($report_type == 0) && ($submitter == 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE reference = '$reference'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 5 failed: ' . mysql_error());
}

# submission date filter set
if ( ($report_type == 0) && ($submitter == 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 6 failed: ' . mysql_error());
}

# report type + submission date
if ( ($report_type != 0) && ($submitter == 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 7 failed: ' . mysql_error());
}

# report type + submitter
if ( ($report_type != 0) && ($submitter != 0) && ($reference == 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 8 failed: ' . mysql_error());
}

# report type + reference
if ( ($report_type != 0) && ($submitter == 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND reference = '$reference'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 9 failed: ' . mysql_error());
}
# report type + submission date + submitter
if ( ($report_type != 0) && ($submitter != 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 10 failed: ' . mysql_error());
}

# report type + submitter + reference
if ( ($report_type != 0) && ($submitter != 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND emp_id = '$submitter'
					AND reference = '$reference'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 11 failed: ' . mysql_error());
}

# report type + reference + submission date
if ( ($report_type != 0) && ($submitter == 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE rep_id = '$report_type'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 12 failed: ' . mysql_error());
}

# submitter + reference
if ( ($report_type == 0) && ($submitter != 0) && ($reference != 0) && ($day == 0) && ($month == 0) && ($year == 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND reference = '$reference'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 13 failed: ' . mysql_error());
}

# submission date + reference
if ( ($report_type == 0) && ($submitter == 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 14 failed: ' . mysql_error());
}

# submission date + submitter
if ( ($report_type == 0) && ($submitter != 0) && ($reference == 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 15 failed: ' . mysql_error());
}

# submission date + submitter + reference
if ( ($report_type == 0) && ($submitter != 0) && ($reference != 0) && ($day != 0) && ($month != 0) && ($year != 0) ) {

	$sql = "SELECT *
			FROM reports_repository_main
			WHERE emp_id = '$submitter'
					AND reference = '$reference'
					AND date_day = '$day'
					AND date_month = '$month'
					AND date_year = '$year'
			ORDER BY report_id ASC";
	$result = mysql_query($sql) or die('Query 16 failed: ' . mysql_error());
}


#
#	table display structure
#

$reports = array();
$reports = get_table($result);

$divisor = 23;

$rowsQty = mysql_num_rows($result);

if ( $rowsQty == 0 ) {

	header( 'Location: no_results_message.html' );
	//exit();
}

$pagesQty = ceil($rowsQty / $divisor);

$currentPage = $_REQUEST['current'];

if ( $_REQUEST['current'] == '' ) {
	
	$currentPage = 1;
	
} else {

	$currentPage = $_REQUEST['select_page'];
}


?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" href="css/iframe.css" />
<title></title>
</head>

<body>


<div id="resultsContainer_analysis">
 
    <?php if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) { ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post">
      <table class="tableText">
        <thead>
          <tr> 
            <td colspan="4" align="left"><font class="tableTitle">RESULTS</font></td>
			<td align="right"></td>
          </tr>
          <tr bgcolor="#00CCFF" align="center"> 
            <td>TYPE OF REPORT</td>
            <td>DATE</td>
            <td>SUBMITTER</td>
            <td>REFERENCE</td>
            <td>ACTIONS</td>
          </tr>
        </thead>
        <!--<tfoot>
		<tr bgcolor="#00CCFF">
			<td>previous page</td>
			<td>current</td>
			<td>next page</td>
		</tr>
	</tfoot> -->
        <tbody>
          <?php
			$bgcol = "#C4E2FF";
			
			
			#### table display structure ########
			#
			$init = ($currentPage - 1) * $divisor;
			
			if ( $currentPage != $pagesQty ) {
			
				$limit = (($currentPage - 1) * $divisor) + ($divisor - 1);
			
			} else {
			
				$limit = ((($currentPage - 1) * $divisor) + ($rowsQty % $divisor)) - 1;
			}
			#
			#### table display structure ########
			
			
			for ( $rowNumb = $init; $rowNumb <= $limit; $rowNumb++ ) {
		?>
          <TR bgcolor=<?php echo $bgcol; ?> > 
            <!-- row n, column m -->
            <TD align="center"> 
              <?php
				$rep_id = $reports[$rowNumb]['rep_id'];
				$sql = "SELECT * FROM reports_types WHERE rep_id = '$rep_id'";
				$res1 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
				$row = mysql_fetch_array($res1, MYSQL_ASSOC);
				echo /*$row['rep_name'].*/'HSS-'.$row['doc_code'].'-'.$reports[$rowNumb]['sub_cat_id'];
			?>
            </TD>
            <!-- row n, column m+1 -->
            <TD> <?php echo $reports[$rowNumb]['date_day'].'/'.$reports[$rowNumb]['date_month'].'/'.$reports[$rowNumb]['date_year'] ?>	
            </TD>
            <!-- row n, column m+2 -->
            <TD align="center"> 
              <?php
				$submitter_id = $reports[$rowNumb]['emp_id'];
				$sql = "SELECT emp_login FROM employees_tbl WHERE emp_id = '$submitter_id'";
				$res2 = mysql_query($sql) or die('Query 1 failed: ' . mysql_error());
				$row2 = mysql_fetch_array($res2, MYSQL_ASSOC);
				echo $row2['emp_login'];
			?>
            </TD>
           
		    <!-- row n, column m+3 -->
            <TD> 
              <?php
				echo $reports[$rowNumb]['reference'];
			?>
            </TD>
            
			<!-- row n, column m+4 -->
            <TD>
			<?php
				if ( $reports[$rowNumb]['status']  == 'closed' ) {				
					$path_to_report = 'repository/HSS-'.$row['doc_code'].'-'.$reports[$rowNumb]['sub_cat_id'].'_revd.pdf';
				} else if ( $reports[$rowNumb]['status']  == 'open' ) {
					$path_to_report = 'repository/HSS-'.$row['doc_code'].'-'.$reports[$rowNumb]['sub_cat_id'].'.pdf';
				}
			?>			
				<a title="Open Report in PDF format" href="<?php  echo $path_to_report; ?>" target="_blank" >open Report</a>
				
			</TD>

          </TR>
          <?php
		
				// change the color of every row
				if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
				else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
				
			}  // end of: for ( $rowNumb = (($currentPage - 1) * $divisor);... ) {
		
		$bgcol = "#DD8888";
		?></TR>
          <tr> 
            <td colspan="6" align="center"> <input type="hidden" name="lowlimit" value="<?php echo $init; ?>" /> 
              <input type="hidden" name="uplimit" value="<?php echo $limit; ?>" /> 
              <input type="hidden" name="pagenumber" value="<?php echo $currentPage; ?>" /> 
            </td>
          </tr>
          <tr> 
            <!-- lower navigator -->
            <td colspan="6" align="center">
			
			<?php echo ' [ current page:'; ?>
			
			<select name="select_page" onchange="page_sel.submit()" style="color:black; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:100%;
			background-color:white; border:none; border-top-color:white; border-left-color:white; border-right-color:white;
			border-bottom-color:white">
				<?php				
				for ( $k = 1; $k <= $pagesQty; $k++ ) {
				
					if ( $k == $currentPage ) {
						$selected = 'selected';
					} else {
						$selected = '';
					}
				
					echo '<option value="'.$k.'" '.$selected.'> '.$k.'</option>';
				}
				?>
			</select>
			<?php
				echo ' (of '.$pagesQty.' pages) ] '; ?>
			
			</td>
          </tr>
        </tbody>
      </table>
    </form>

</div> <!-- resultsContainer_analysis -->

<?php } else {

	#################################
	# PROCESS THE SUBMITTED DATA
	#################################

	# just display the same page once again with new values from database
	header('Location: reports_viewer.php?select_page='.$_REQUEST['select_page'].'&current='.$_REQUEST['pagenumber'].'&filter_report_type='.$report_type.'&filter_submitter='.$submitter.'&filter_reference='.$reference.'&filter_date_day='.$day.'&filter_date_month='.$month.'&filter_date_year='.$year );
	
}
?>

</body>
</html>
