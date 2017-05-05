<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('PHPExcel_180/Classes/PHPExcel.php');


echo "<hr/>";
echo "<center>EXTRACTOR FOR MEF<br/>ANNUAL TAXES DECLARATION REPORT</center>";
echo "<hr/>";



echo $_REQUEST['reportYear'];

exit();



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
 $gl_accounts = array(
                      '705001',
                      '705005',
                      '706001',
                      '706002',
                      '706003',
                      '706004',
                      '706009',
                      '706005',
                      '604003',
                      '604005',
                      '605001',
                      '605002',
                      '605003',
                      '605004',
                      '701001',
                      '701002',
                      '701003',
                      '701005',
                      '701007',
                      '701013',
                      '701014',
                      '701099',
                      '703008',
                      '703009',
                      '706006',
                      '706007',
                      '706010',
                      '707004',
                      '708001',
                      '708002',
                      '713003',
                      '713007',
                      '713008',
                      '713009',
                      '705004',
                      '708004',
                      '604001',
                      '604006',
                      '701004',
                      '701008',
                      '703003',
                      '703007',
                      '703011',
                      '706008',
                      '707001',
                      '707002',
                      '711008',
                      '713011');
 
 
 
 
 
 for($j=0; $j<= (sizeof($gl_accounts) - 1); $j++) {
    
    $gl_acc = $gl_accounts[$j];
    
    $tsql = "SELECT T0.[Account], T0.[Debit], T0.[Credit], T0.[ContraAct], T0.[RefDate], T0.[BaseRef]
            FROM JDT1 T0
            WHERE T0.[Account] = $gl_acc
            AND T0.[RefDate] > '01/01/15'
            AND T0.[RefDate] < '01/01/16'
            AND T0.[ContraAct] != '305999'";
    
    $stmt = mssql_query( $tsql, $conn );
    
    if( $stmt === false ) {
        echo "Error in executing query [1].</br>";
        die( print_r( mssql_get_last_message(), true));
    }    
    
    
    $index = 0;
    $result_table = array();
    $filling = array( 'Tipo de Persona' => 'JE', 'RUC' => '0', 'DV' => '0', 'Nombre o Razon Social' => 'Journal Entry' );
    
    while ( $row = mssql_fetch_array( $stmt ) ) {
	
        $result_table[$index] = $row;
        
        // DEBUG
        print_r($result_table[$index]);        
        
        
        /*
         *  GET VENDOR DATA FROM $result_table.ContraAct
         */
        $bp_vendor_account = $result_table[$index]['ContraAct'];
        
        $tsql3 = "SELECT T0.[U_BPType] AS 'Tipo de Persona', T0.[LicTradNum] AS 'RUC', T0.[VatIdUnCmp] AS 'DV', T0.[CardName] AS 'Nombre o Razon Social'
                FROM OCRD T0
                WHERE T0.[CardCode] = '$bp_vendor_account'";
                
        /*
         *  !!! THERE IS AN ERROR IN THE RESULTING TABLE !!!
         *
         *  THE RECORD FOR BP '0001' HAS INFO FROM HANS BUCH INSTEAD OF HSS PANAMA.
         *  
         */
        
        
        // DEBUG
        //echo "<br/>$tsql3<br/>";
        
                
        $stmt3 = mssql_query( $tsql3, $conn );
        
        if( $stmt3 === false ) {
            echo "Error in executing query [3].</br>";
            die( print_r( mssql_get_last_message(), true));
        }
        
        $row3 = mssql_fetch_array( $stmt3 );
        
        // DEBUG
        //print_r($row3);
        
        /*
         * APPEND VENDOR DETAILS TO CURRENT RECORD IN $result_table
         */
        if( strlen($result_table[$index]['BaseRef']) == 6 && substr($result_table[$index]['BaseRef'], 0, 1) == '8' ){
            // DEBUG
            //echo "<br/>ap invoice found<br/>";
            
            $result_table[$index] = array_merge( $result_table[$index], $row3 );
            
        } else {
            
            $result_table[$index] = array_merge( $result_table[$index], $filling ); 
        }
        
        
        /*
         * VERIFY A/P INVOICES ARE NOT CANCELED - USE $result_table.BaseRef
         */        
        $ap_invoice_number = $result_table[$index]['BaseRef'];
        
        $tsql2 = "SELECT T0.[CANCELED]
                FROM OPCH T0
                WHERE T0.[DocNum] = $ap_invoice_number";
                
        $stmt2 = mssql_query( $tsql2, $conn );
        
        if( $stmt2 === false ) {
            echo "Error in executing query [2].</br>";
            die( print_r( mssql_get_last_message(), true));
        }
        
        if( mssql_num_rows( $stmt2 ) == 1 ){
            
            $row2 = mssql_fetch_array( $stmt2 );
            
            if( $row2['CANCELED'] == 'C' || $row2['CANCELED'] == 'Y' ){
                
                // DEBUG
                //echo "<br/>Invoice $ap_invoice_number Canceled? = ".$row2['CANCELED']."<br/>";
                
                $canceled_ap_invoices[] = $result_table[$index];
                
            }
        }
        
        
        $report_records[] = $result_table[$index];
        
        $index++;
    }
 }
 
 
    // DEBUG
    print_table( $report_records );

    print_table( $canceled_ap_invoices );
    
    
    
    


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
 
// Worksheet headers
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'GL Account')
            ->setCellValue('B1', 'Debit')
            ->setCellValue('C1', 'Credit')
            ->setCellValue('D1', 'Offset Account')
            ->setCellValue('E1', 'Base Ref')
            ->setCellValue('F1', 'Tipo de Persona')
            ->setCellValue('G1', 'RUC')
            ->setCellValue('H1', 'DV')
            ->setCellValue('I1', 'Nombre o Razon Social');

/*
 *  WRITE LINES TO FILE
 */
$rowCount = 2;
for( $i=0; $i<= (sizeof($report_records) - 1); $i++ ){

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $report_records[$i]['Account']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $report_records[$i]['Debit']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $report_records[$i]['Credit']);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowCount, $report_records[$i]['ContraAct'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowCount, $report_records[$i]['BaseRef'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $report_records[$i]['Tipo de Persona']);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$rowCount, $report_records[$i]['RUC'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$rowCount, $report_records[$i]['DV'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $report_records[$i]['Nombre o Razon Social']);
    
    $rowCount++;
}
    
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('GL ACCOUNTS - JOURNAL ENTRIES');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

foreach(range('A','I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}




/*
 *  SECOND WORKSHEET
 */
$objPHPExcel->createSheet();

// Worksheet headers
$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'GL Account')
            ->setCellValue('B1', 'Debit')
            ->setCellValue('C1', 'Credit')
            ->setCellValue('D1', 'Offset Account')
            ->setCellValue('E1', 'Base Ref')
            ->setCellValue('F1', 'Tipo de Persona')
            ->setCellValue('G1', 'RUC')
            ->setCellValue('H1', 'DV')
            ->setCellValue('I1', 'Nombre o Razon Social');

/*
 *  WRITE LINES TO FILE
 */
$rowCount = 2;
for( $i=0; $i<= (sizeof($canceled_ap_invoices) - 1); $i++ ){

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $canceled_ap_invoices[$i]['Account']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $canceled_ap_invoices[$i]['Debit']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $canceled_ap_invoices[$i]['Credit']);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowCount, $canceled_ap_invoices[$i]['ContraAct'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowCount, $canceled_ap_invoices[$i]['BaseRef'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $canceled_ap_invoices[$i]['Tipo de Persona']);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('G'.$rowCount, $canceled_ap_invoices[$i]['RUC'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$rowCount, $canceled_ap_invoices[$i]['DV'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $canceled_ap_invoices[$i]['Nombre o Razon Social']);
    
    $rowCount++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('CANCELED AP INVOICES');

$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);

foreach(range('A','I') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}




// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save( './MEF-TAXES-REPORT_'.date('Ymd_Hi').'.xlsx' );


 
// Echo done
echo "<br/><br/>Done writing file";






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
 * PRINT A TABLE RESULTING FROM FROM SQL SELECT QUERY
 * 
 * REMARK: adapted for MSSQL Server
 *
 * notes:
 * 
 *******************************************************************/
function print_table($sql_result_array){
    
    echo "<br/><br/><table border=\"1\">";
    
    for($i=0; $i<=(sizeof($sql_result_array) - 1); $i++){
        echo "<tr>";
        
        for($j=0; $j<=((sizeof($sql_result_array[$i])/2) - 1); $j++){  // sizeof($sql_result_array[$i])/2) BECAUSE ARRAY IS ASSOC AND NUMERIC
            echo "<td>";
            echo $sql_result_array[$i][$j];
            echo "</td>";
        }
        
        echo "</tr>";
    }
    
    echo "</table>";    
}


?>
