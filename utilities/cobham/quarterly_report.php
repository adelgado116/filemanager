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
echo "--  COBHAM REPORT EXTRACTOR<br/>";
echo "-------------------------------------------------<br/>"; 


# filtering variables
$year = $_REQUEST['report_year'];
$quarter = $_REQUEST['report_quarter'];  // get invoices only from the last three months


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
	echo "<strong>UNABLE TO CONNECT TO MSSQL.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
	die( print_r( mssql_get_last_message(), true));

} else {
    $selected_db = mssql_select_db( $database, $conn ) or die("<br/>Couldn’t open database $database");
    echo "<br/>connected to database $database<br/><br/>";
}


########################  GET DATA FROM INVOICES AND CREDIT MEMO TABLES  ########################

switch($quarter){
	case '1':
		$startDate = "0101"; // jan01
		$endDate = "0331"; // mar31
		break;
	case '2':
		$startDate = "0401"; // apr01
		$endDate = "0630"; // jun30
		break;
	case '3':
		$startDate = "0701"; // jul01
		$endDate = "0931"; // sep31
		break;
	case '4':
		$startDate = "1001"; // oct01
		$endDate = "1231"; // dec31
		break;
	default:
		break;
}


$tsql = "SELECT T0.[DocDate], T0.[CardCode], T1.[ItemCode], T1.[Quantity], T0.[DocNum], T1.[Dscription], T3.[Name]
FROM OINV T0 INNER JOIN INV1 T1 ON T0.[DocEntry] = T1.[DocEntry] INNER JOIN OCRD T2 ON T0.[CardCode] = T2.[CardCode] INNER JOIN OCRY T3 ON T2.[Country] = T3.[Code]
WHERE (T0.[DocDate] >= (CONVERT(DATETIME, '".$year.$startDate."', 112))) AND (T0.[DocDate] <= (CONVERT(DATETIME, '".$year.$endDate."', 112))) AND ( T1.[ItemCode] LIKE '%TH%') AND ( T0.[CANCELED] !='Y')
ORDER BY T0.[DocDate]";

/*
$tsql = "SELECT T0.[DocDate], T0.[CardCode], T1.[ItemCode], T1.[Quantity], T0.[DocNum], T1.[Dscription],T2.[Country]
FROM [dbo].[OINV]  T0 INNER JOIN [dbo].[INV1]  T1 ON T0.[DocEntry] = T1.[DocEntry] INNER JOIN [dbo].[OCRD]  T2 ON T0.[CardCode] = T2.[CardCode]
WHERE (T0.[DocDate] >= (CONVERT(DATETIME, '".$year.$startDate."', 112))) AND (T0.[DocDate] <= (CONVERT(DATETIME, '".$year.$endDate."', 112))) AND ( T1.[ItemCode] LIKE '%TH%') AND ( T0.[CANCELED] !='Y')
ORDER BY T0.[DocDate]";
*/

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false ){
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$result_table = array();
$result_table = get_table( $stmt );

//print_r($result_table);
//echo '<br/><br/>';



$tsql = "SELECT T0.[DocNum], T0.[CardCode], T0.[DocDate], T1.[ItemCode], T1.[Quantity], T1.[Dscription]
FROM ORIN T0 INNER JOIN RIN1 T1 ON T0.[DocEntry] = T1.[DocEntry]
WHERE (T0.[DocDate] >= (CONVERT(DATETIME, '".$year.$startDate."', 112))) AND (T0.[DocDate] <= (CONVERT(DATETIME, '".$year.$endDate."', 112))) AND ( T1.[ItemCode] LIKE '%TH%')
ORDER BY T0.[DocDate]";

/*
$tsql = "SELECT T0.[DocNum], T0.[CardCode], T0.[DocDate], T1.[ItemCode], T1.[Quantity], T1.[Dscription]
FROM ORIN T0 INNER JOIN RIN1 T1 ON T0.[DocEntry] = T1.[DocEntry]
WHERE (T1.[ItemCode] LIKE '%TH%')
ORDER BY T0.[DocDate]";
*/

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [2].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$result_table2 = array();
$result_table2 = get_table( $stmt );

//print_r($result_table2);
//echo '<br/><br/>';



// GENERATE FILE

$newReport = "cobham_report_".$year."Q".$quarter.date('_Ymd_Hi').".txt";
$reportName = "reports/".$newReport;

if( $file = fopen( $reportName, "w") ) {
	
	// table headers
	fwrite($file, "Thrane DP Business partner number\tSales Date (yyyy-mm-dd)\tCustomer name (coded)\tCustomer Country\tT&T Product ID\tPartner Product ID\tNumber of items\tInvoice number\tPartner Product Name\tError");
	fwrite($file, "\r");
	
	// WRITE INVOICED ITEMS LINES TO FILE
	for( $i=0; $i<= (sizeof($result_table) - 1); $i++ ){
		
		// take out the TH from the item code and let THS parts out of the report
		if( (substr($result_table[$i]['ItemCode'], 0, 3) == "THS") || (substr($result_table[$i]['ItemCode'], 0, 3) == "TH-") ) {
			// this is a spart part, skip it
		} else {
			
			echo "line [$i]: ".$result_table[$i]['CardCode'].' - '.$result_table[$i]['DocNum'].' - '.$result_table[$i]['Dscription'].'<br/>';
			
			$d1[0] = '200115750';
			$date = new DateTime( $result_table[$i]['DocDate'] );
			$d1[1] = $date->format("Y-m-d");
			$d1[2] = $result_table[$i]['CardCode'];
			$d1[3] = $result_table[$i]['Name'];  //$d1[3] = $result_table[$i]['Country'];
			$d1[4] = "\"".substr($result_table[$i]['ItemCode'], 2, strlen($result_table[$i]['ItemCode']) - 1)."\"";
			$d1[5] = "\"".$result_table[$i]['ItemCode']."\"";
			$d1[6] = $result_table[$i]['Quantity'];
			$d1[7] = $result_table[$i]['DocNum'];
			$d1[8] = $result_table[$i]['Dscription'];
			$d1[9] = '0';
			
			$new = implode( "\t", $d1 );
			
			fwrite( $file, $new );
			fwrite( $file, "\r" );	
		}
	}
	
	
	// WRITE CREDIT MEMO LINES TO FILE
	for( $i=0; $i<= (sizeof($result_table2) - 1); $i++ ){	
		// take out the TH from the item code and let THS parts out of the report
		if( (substr($result_table2[$i]['ItemCode'], 0, 3) == "THS") || (substr($result_table2[$i]['ItemCode'], 0, 3) == "TH-") ) {
			// this is a spart part, skip it
		} else {
			echo "line [$i]: ".$result_table2[$i]['CardCode'].' - '.$result_table2[$i]['DocNum'].' - '.$result_table2[$i]['Dscription'].' - '.$result_table2[$i]['ItemCode'].' - '.$result_table2[$i]['Quantity'].'<br/>';
			
			$d1[0] = '200115750';
			$date = new DateTime( $result_table2[$i]['DocDate'] );
			$d1[1] = $date->format("Y-m-d");
			$d1[2] = $result_table2[$i]['CardCode'];
			$d1[3] = "VOID";
			$d1[4] = substr($result_table2[$i]['ItemCode'], 2, strlen($result_table2[$i]['ItemCode']) - 1);
			$d1[5] = $result_table2[$i]['ItemCode'];
			$d1[6] = $result_table2[$i]['Quantity'];
			$d1[7] = $result_table2[$i]['DocNum'];
			$d1[8] = $result_table2[$i]['Dscription'];
			$d1[9] = '0';
			
			$new = implode( "\t", $d1 );
			
			fwrite( $file, $new );
			fwrite( $file, "\r" );
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
