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
 * DEPENDENCIES
 * 
 * - PHPExcel
 * 
 *******************************************************************/
include('PHPExcel_180/Classes/PHPExcel.php');





/********************************************************************
 * MAIN PROGRAM
 * 
 * 
 *******************************************************************/
echo "-------------------------------------------------<br/>";
echo "--  MEF REPORT EXTRACTOR<br/>";
echo "-------------------------------------------------<br/>"; 


//
// GET DATA FROM MSSQL DATABASE
//
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
# filtering variables
$year = $_REQUEST['report_year'];
$month = $_REQUEST['report_month'];

//$remote_table = "ORDR";

$tsql= "SELECT
T0.[U_BPType] AS 'TIPO DE PERSONA',
T0.[LicTradNum] AS 'RUC',
T0.[VatIdUnCmp] AS 'DV',
T0.[CardName] AS 'NOMBRE O RAZON SOCIAL',
T1.[NumAtCard] AS 'FACTURA',
T1.[TaxDate] AS 'FECHA',
T0.[U_ID2] AS 'CONCEPTO',
T0.[Country],
T1.[DocTotalSy] AS 'MONTO EN BALBOAS',
T1.[VatSum] AS 'ITBMS PAGADO EN BALBOAS'
FROM OCRD T0 INNER JOIN OPCH T1 ON T0.[CardCode] = T1.[CardCode]
WHERE T0.[CardType] = 'S'
AND MONTH(T1.[TaxDate])='{$month}'
AND YEAR(T1.[TaxDate])='{$year}'
ORDER BY T1.[TaxDate] ASC";



$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}


$purchases_table = array();
$purchases_table = get_table( $stmt );

//print_r($purchases_table);




////////////////////////////////////////////////////////////////
//  CREATE AND FILL OUT NEW EXCEL FILE WITH EXTRACTED DATA
////////////////////////////////////////////////////////////////

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("ADELGADO")
            ->setLastModifiedBy("ADELGADO")
            ->setTitle("MEF-FORM43")
            ->setSubject("MEF-FORM43-REPORT")
            ->setDescription("FORM 43 - Report for Monthly Purchases")
            ->setKeywords("form 43, report, monthly")
            ->setCategory("Reports from SAP");
 
// Worksheet headers
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'TIPO DE PERSONA')
            ->setCellValue('B1', 'RUC')
            ->setCellValue('C1', 'DV')
            ->setCellValue('D1', 'NOMBRE O RAZON SOCIAL')
            ->setCellValue('E1', 'FACTURA')
            ->setCellValue('F1', 'FECHA')
            ->setCellValue('G1', 'CONCEPTO')
            ->setCellValue('H1', 'COMPRAS DE BIENES Y SERVICIOS')
            ->setCellValue('I1', 'MONTO')
            ->setCellValue('J1', 'ITBMS PAGADO EN BALBOAS');



$rowCount = 2;
for( $i=0; $i<= (sizeof($purchases_table) - 1); $i++ ){

	//print_r($purchases_table[$i]);

	switch( $purchases_table[$i]['TIPO DE PERSONA'] ){  // type of entity
		case '1':
			$d1[0] = 'N';
			break;
		case '2':
			$d1[0] = 'J';
			break;
		case '3':
			$d1[0] = 'E';
			break;
		default:
			break;
	}
	
	$d1[1] = $purchases_table[$i]['RUC'];   // ruc
	if ( $d1[0] == 'E' ){

		$d1[1] = '0';
	}

	$d1[2] = $purchases_table[$i]['DV'];  // dv number
	if ( $d1[0] == 'E' ){

		$d1[2] = '';
	}

	$d1[3] = $purchases_table[$i]['NOMBRE O RAZON SOCIAL'];  // entity name

	$d1[4] = $purchases_table[$i]['FACTURA'];  // invoice number

	$date = new DateTime( $purchases_table[$i]['FECHA'] );  // date
	$d1[5] = $date->format("Ymd");

	$d1[6] = $purchases_table[$i]['CONCEPTO'];  // concept

	if ( $purchases_table[$i]['Country'] == 'PA' ) {  // source, 'COMPRAS DE BIENES Y SERVICIOS'
		$d1[7] = '1';
	} else {
		$d1[7] = '2';
	}

	$d1[8] = $purchases_table[$i]['MONTO EN BALBOAS'];  // total
	$d1[9] = round($purchases_table[$i]['ITBMS PAGADO EN BALBOAS'], 0);  // taxes


	// DEBUG
	//var_dump( implode( " // ", $d1 ) );
	//echo "<br/>";


	//
	//  WRITE LINES TO EXCEL FILE
	//
	$objPHPExcel->getActiveSheet()->SetCellValueExplicit('A'.$rowCount, $d1[0], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('B'.$rowCount, $d1[1], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('C'.$rowCount, $d1[2], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowCount, $d1[3], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowCount, $d1[4], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$rowCount, $d1[5], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$rowCount, $d1[6], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$rowCount, $d1[7], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $d1[8]);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $d1[9]);
    
    $rowCount++;
}

    
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('FORM 43 - 2016-08');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);

foreach(range('A','J') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( './reports/MEF-FORM43_'.date('Ymd_Hi').'.xlsx' ); 
 
// DEBUG
//echo "<br/><br/>Done writing file";




	
?>

<html>
<head>
	<meta http-equiv="refresh" content="0; url=index.php">
</head>
</html>
