<?php

/********************************************************************
 * UTILITARIAN FUNCTIONS
 * get_table()
 * 
 *******************************************************************/


/********************************************************************
 * GET A COMPLETE TABLE FROM A [SELECT * FROM table] QUERY
 * 
 * REMARK: adapted for MSSQL Server
 *
 * notes:
 * This function returns an array of arrays. Every array contained
 * inside de main array is a associative array representing a table
 * row from an SQL database.
 * 
 *******************************************************************/
function get_table( $result ) {

    $index = 0;
    $a = array();
    
    while ( $row = mssql_fetch_array( $result ) ) {
	$a[$index] = $row;
	$index++;
    }
    
    return $a;
}


/********************************************************************
 * MAIN PROGRAM
 * 
 * 
 *******************************************************************/

echo "-------------------------------------------------<br/>";
echo "--  MEF REPORT EXTRACTOR<br/>";
echo "-------------------------------------------------<br/>"; 


# filtering variables
$year = $_REQUEST['report_year'];
$month = $_REQUEST['report_month'];


#
# GET DATA FROM MSSQL DATABASE
#
$server = "192.168.244.29";    //"sapbo";
$user = "dbuser";
$pass = "Raytheon10";
$database = "ERP";

$conn = mssql_connect($server, $user, $pass);

if( $conn === false ) {

	echo mssql_get_last_message();
	echo "<strong>UNABLE TO CONNECT TO MSSQL - CONTACT IT DEPARTMENT.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
	die( print_r( mssql_get_last_message(), true));

} else {
    $selected_db = mssql_select_db( $database, $conn ) or die("<br/>Couldn’t open database $database");
    echo "<br/>connected to database $database<br/><br/>";
}


########################  REMOTE TABLE  ########################
//$remote_table = "ORDR";

$tsql= "SELECT T0.[CardCode], T0.[CardName], T0.[U_BPType], T0.[U_ID2], T0.[VatIdUnCmp], T0.[LicTradNum], T0.[validFor], T1.[NumAtCard], T1.[TaxDate], T0.[Country],  T1.[DocTotalSy], T1.[VatSum] FROM OCRD T0 INNER JOIN OPCH T1 ON T0.[CardCode] = T1.[CardCode] WHERE T0.[CardType] = 'S'";

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}


$sales_table = array();
$sales_table = get_table( $stmt );

//print_r($sales_table);

$newReport = "MEF_Report_".date('Ymd_Hi').".txt";
$reportName = "reports/".$newReport;

if( $file = fopen( $reportName, "w") ) {
	
	
	for( $i=0; $i<= (sizeof($sales_table) - 1); $i++ ){
	    //print_r($sales_table[$i]);
	    echo "line [$i]: ".$sales_table[$i]['U_BPType'].' - '.$sales_table[$i]['CardName'].' - ';
	    
	    
	    $d1[0] = $sales_table[$i]['U_BPType'];  // type of entity
	    $d1[1] = $sales_table[$i]['LicTradNum'];  // ruc
	    $d1[2] = $sales_table[$i]['VatIdUnCmp'];  // dv number
	    $d1[3] = $sales_table[$i]['CardName'];  // entity name
	    $d1[4] = $sales_table[$i]['NumAtCard'];  // invoice number
	    
	    $date = new DateTime( $sales_table[$i]['TaxDate'] );  // date
	    $d1[5] = $date->format("Ymd");
	    
	    
	    //debug
	    echo substr($d1[5], 4, 2);
	    echo '<br/>';
	    
	    
	    $d1[6] = $sales_table[$i]['U_ID2'];  // concept
	    
	    if ( $sales_table[$i]['Country'] == 'PA' ) {  // source
		    $d1[7] = '1';
	    } else {
		    $d1[7] = '2';
	    }
	    
	    $d1[8] = $sales_table[$i]['DocTotalSy'];  // total
	    $d1[9] = round($sales_table[$i]['VatSum'], 0);  // taxes
	    
	    
	    $new = implode( "\t", $d1 );
	    
	    
	    // apply filters before printing to file
	    // filter for year
	    if ( substr($d1[5], 0, 4) != $year ){
		; // do nothing
	    } else {    
		// filter for month
		if (substr($d1[5], 4, 2) != $month) {
		    ; // do nothing
		} else {
		    fwrite( $file, $new );
		    fwrite( $file, "\r" );
		}
	    }
	}
	
	fclose( $file );

	echo '<br /><br />';
	echo 'File correctly saved to final format.<br/><br/>';
	
} else {
	
	echo '<br /><br />';
	echo 'Failed creating file.<br/>';
	exit();
}

echo '<br/>process has been completed.';
?>

<html>
<head>
	<meta http-equiv="refresh" content="0; url=index.php">
</head>
</html>