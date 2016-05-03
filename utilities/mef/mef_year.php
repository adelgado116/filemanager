<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('PHPExcel_180/Classes/PHPExcel.php');




echo "<hr/>";
echo "<center>EXTRACTOR FOR MEF<br/>ANNUAL TAXES DECLARATION REPORT</center>";
echo "<hr/>"; 


/*
 *  CONNECT TO MSSQL DATABASE ON SAP SERVER
 */
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
    echo "<br/>connected to database: $database<br/><br/>";
}


/*
 *  GET DATA FROM DB.TABLES
 */

 // array of G/L Accounts to be summarized and extracted
 $gl_accounts = array('705001', '705005', '706001', '706002', '706003', '706004', '706009', '706005', '604003', '604005', '605001', '605002', '605003', '605004', '701001', '701002', '701003', '701005', '701007', '701013', '701014', '701099', '703008', '703009', '706006', '706007', '706010', '707004', '708001', '708002', '713003', '713007', '713008', '713009');
 
 
 for($j=0; $j<= (sizeof($gl_accounts) - 1); $j++) {
    
    $gl_acc = $gl_accounts[$j];
    
    
    $tsql = "SELECT T1.[U_BPType] AS 'Tipo de Persona', T1.[LicTradNum] AS 'RUC', T1.[VatIdUnCmp] AS 'DV', T1.[CardName] AS 'Nombre o Razon Social', T0.[BaseCard] AS 'Tipo de Pago', SUM(T0.[LineTotal]) AS 'Monto'
            FROM PCH1 T0  INNER JOIN OCRD T1 ON T0.[BaseCard] = T1.[CardCode] INNER JOIN OPCH T2 ON T0.[DocEntry] = T2.[DocEntry]
            WHERE T0.[AcctCode] = $gl_acc
            AND T0.[DocDate] > '01/01/15'
            AND T0.[DocDate] < '01/01/16'
            AND T2.[CANCELED] = 'N'
            GROUP BY T1.[U_BPType], T1.[LicTradNum], T1.[VatIdUnCmp], T1.[CardName], T0.[BaseCard]
            ORDER BY SUM(T0.[LineTotal]) DESC";
    
    
    $stmt = mssql_query( $tsql, $conn );
    
    if( $stmt === false ) {
        echo "Error in executing query [1].</br>";
        die( print_r( mssql_get_last_message(), true));
    }    
    
    
    while ( $row = mssql_fetch_array( $stmt ) ) {
        $row[] = $gl_acc;
	$result_table[] = $row;
    }
 }




/*
 *  CREATE AND FILL OUT NEW EXCEL FILE WITH EXTRACTED DATA
 */


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("ADELGADO")
            ->setLastModifiedBy("ADELGADO")
            ->setTitle("MEF-TAXES-REPORT")
            ->setSubject("MEF-TAXES-REPORT")
            ->setDescription("Report for Annual Taxes Declaration")
            ->setKeywords("MEF taxes report declaration")
            ->setCategory("Reports from SAP");
 
// Add Data in your file
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tipo de persona')
            ->setCellValue('B1', 'RUC')
            ->setCellValue('C1', 'DV')
            ->setCellValue('D1', 'Nombre o Razon Social')
            ->setCellValue('E1', 'Tipo de Pago')
            ->setCellValue('F1', 'Monto')
            ->setCellValue('G1', 'GL Account');

            
$rowCount = 2;

// WRITE LINES TO FILE
for( $i=0; $i<= (sizeof($result_table) - 1); $i++ ){

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result_table[$i]['Tipo de Persona']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result_table[$i]['RUC']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result_table[$i]['DV']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $result_table[$i]['Nombre o Razon Social']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $result_table[$i]['Tipo de Pago']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $result_table[$i]['Monto']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result_table[$i][6]);
    
    $rowCount++;
}
    

    
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('MEF REPORT - COMPLETE');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);

foreach(range('A','G') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}


// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( './reports/MEF-TAXES-REPORT-2015-ver_'.date('Ymd_Hi').'.xlsx' ); 
 
// Echo done
echo "<br/><br/>Done writing file";






?>