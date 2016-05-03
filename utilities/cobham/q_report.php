<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('PHPExcel_180/Classes/PHPExcel.php');




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
		$endDate = "0930"; // sep30
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
WHERE (T0.[DocDate] >= (CONVERT(DATETIME, '".$year.$startDate."', 112))) AND (T0.[DocDate] <= (CONVERT(DATETIME, '".$year.$endDate."', 112))) AND ( T1.[ItemCode] LIKE '%TH%') AND ( T0.[CANCELED] !='Y') AND ( T0.[JrnlMemo] NOT LIKE '%Cancellation%')
ORDER BY T0.[DocDate]";

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

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [2].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$result_table2 = array();
$result_table2 = get_table( $stmt );









// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("ADELGADO")
            ->setLastModifiedBy("ADELGADO")
            ->setTitle("COBHAM - SalesOut-Q$quarter-$year")
            ->setSubject("COBHAM - SalesOut-Q$quarter-$year")
            ->setDescription("Report for Cobham's New Sales-Out by Quarter")
            ->setKeywords("cobham quarter report salesout")
            ->setCategory("Reports from SAP");
 
// Add Data in your file
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Thrane DP Business partner number')
            ->setCellValue('B1', 'Sales Date (yyyy-mm-dd)')
            ->setCellValue('C1', 'Customer name (coded)')
            ->setCellValue('D1', 'Customer country')
            ->setCellValue('E1', 'T&T Product ID')
            ->setCellValue('F1', 'Partner Product ID')
            ->setCellValue('G1', 'Number of items')
            ->setCellValue('H1', 'Invoice number')
            ->setCellValue('I1', 'Partner Product name')
            ->setCellValue('J1', 'Error description');




$rowCount = 2;
	
// WRITE INVOICED ITEMS LINES TO FILE
for( $i=0; $i<= (sizeof($result_table) - 1); $i++ ){
    
    // take out the TH from the item code and let THS parts out of the report
    if( (substr($result_table[$i]['ItemCode'], 0, 3) == "THS") || (substr($result_table[$i]['ItemCode'], 0, 3) == "TH-") ) {
        // this is a spart part, skip it
    } else {
        // Thrane DP Business partner number
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '200115750');
        // Sales Date (yyyy-mm-dd)
        $date = new DateTime( $result_table[$i]['DocDate'] );
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $date->format("Y-m-d"));
        // Customer name (coded)
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result_table[$i]['CardCode']);
        // Customer Country
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result_table[$i]['Name']);
        
        // T&T Product ID
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "\"".substr($result_table[$i]['ItemCode'], 2, strlen($result_table[$i]['ItemCode']) - 1)."\"");
        
        // Partner Product ID
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "\"".$result_table[$i]['ItemCode']."\"");
        // Number of items
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result_table[$i]['Quantity']);
        // Invoice Number
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result_table[$i]['DocNum']);
        // Partner Product Name
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $result_table[$i]['Dscription']);
        // Error description
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, '0');
        
        $rowCount++;
    }
}

// WRITE CREDIT MEMO LINES TO FILE
for( $i=0; $i<= (sizeof($result_table2) - 1); $i++ ){	
    // take out the TH from the item code and let THS parts out of the report
    if( (substr($result_table2[$i]['ItemCode'], 0, 3) == "THS") || (substr($result_table2[$i]['ItemCode'], 0, 3) == "TH-") ) {
        // this is a spart part, skip it
    } else {
        // Thrane DP Business partner number
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, '200115750');
        // Sales Date (yyyy-mm-dd)
        $date = new DateTime( $result_table2[$i]['DocDate'] );
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $date->format("Y-m-d"));
        // Customer name (coded)
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result_table2[$i]['CardCode']);
        // Customer Country
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "VOID");
        
        // T&T Product ID
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, "\"".substr($result_table2[$i]['ItemCode'], 2, strlen($result_table2[$i]['ItemCode']) - 1)."\"");
        
        // Partner Product ID
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, "\"".$result_table2[$i]['ItemCode']."\"");
        // Number of items
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result_table2[$i]['Quantity']);
        // Invoice Number
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result_table2[$i]['DocNum']);
        // Partner Product Name
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $result_table2[$i]['Dscription']);
        // Error description
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, '0');
        
        $rowCount++;
    }
}
    
    
    
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('SALES OUT Q2-2105');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

foreach(range('A','J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}


// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( './reports/'."SalesOut-Q$quarter-$year".'- UNPROCESSED CREDIT MEMOS -'.date('_Ymd_Hi').".xlsx" ); 
 
// Echo done
echo "Done writing file";





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

?>

<html>
<head>
	<meta http-equiv="refresh" content="0; url=index.php">
</head>
</html>