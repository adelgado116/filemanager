<?php

include('PHPExcel_180/Classes/PHPExcel.php');

include('functions.php');
include('dbConnect_i.php');


/*
 *	GET REPORT VARIABLES FROM index.html
 *	- PERIOD (YEAR), SELECT CONTROL: report_year
 *	- MEF FORM NUMBER, SELECT CONTROL: mef_form_number
 *	
 */
$year = $_REQUEST['report_year'];
$mef_form_selection = $_REQUEST['mef_form_selector'];


if ( $mef_form_selection == '0' ){
	echo '<b>Please select a valid MEF Form!</b>';
	exit();
}



/*
 *	GET DATA FROM MYSQL DATABASE
 *	- Accounts with active = '1'
 *
 */
$sql1 = "SELECT sapbo_oact.AcctCode, sapbo_oact.payment_type, MEF_concepts.MEF_concept_number
		FROM sapbo_oact, MEF_concepts
		WHERE sapbo_oact.MEF_concept_id = MEF_concepts.MEF_concept_id
		AND sapbo_oact.MEF_form_id =  '$mef_form_selection'
		AND sapbo_oact.active =  '1'";

$result1 = $link_id->query($sql1);
$active_gl_accounts = get_table( $result1 );


/*
 *  CONNECT TO MSSQL DATABASE ON SAP SERVER
 *
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
 * LOOP THROUGH $active_gl_accounts
 * - FOR EACH GL ACCOUNT
 *	- SELECT ALL JOURNAL ENTRIES FROM JDT1, FILTERING BY GL ACCOUNT, INITIAL DATE, FINAL DATE, CONTRAACT != '305999'
 *	- 
 *
 */
$result_table_vendors = array();
$num_of_rows = 0;
$index = 0;

for($j = 0; $j <= (sizeof($active_gl_accounts) - 1); $j++) {

	
	// DEBUG
	/*
	echo '<br/>';
	print_r($active_gl_accounts[$j]);
	echo '<br/>';
	*/

	$gl_account = $active_gl_accounts[$j]['AcctCode'];
	$payment_type = $active_gl_accounts[$j]['payment_type'];
	$mef_concept = $active_gl_accounts[$j]['MEF_concept_number'];
	$application_period = '1';

/*
	$tsql = "SELECT T1.[U_BPType] AS 'Tipo de Persona', T1.[LicTradNum] AS 'RUC', T1.[VatIdUnCmp] AS 'DV', T1.[CardName] AS 'Nombre o Razon Social',  T1.[CardCode] AS 'BP Account Num', T0.[Account], T0.[Debit], T0.[Credit], T0.[RefDate], T0.[BaseRef]
			FROM JDT1 T0 , OCRD T1
			WHERE T0.[ContraAct] = T1.[CardCode]
			AND  T0.[Account] ='$gl_account'
			AND YEAR(T0.[RefDate])='$year'
			AND T0.[ContraAct] != '305999'";	// EXCLUDE THIS ACCOUNT. IT IS FOR PERIOD OPENING BALANCES BY ACCOUNTING DEPT.
*/

/*
	$tsql = "SELECT T1.[U_BPType] AS 'Tipo de Persona', T1.[LicTradNum] AS 'RUC', T1.[VatIdUnCmp] AS 'DV', T1.[CardName] AS 'Nombre o Razon Social',  T1.[CardCode] AS 'BP Account Num', T0.[Account], SUM(T0.[Debit]) AS 'Monto'
			FROM JDT1 T0 , OCRD T1
			WHERE T0.[ContraAct] = T1.[CardCode]
			AND  T0.[Account] ='$gl_account'
			AND YEAR(T0.[RefDate])='$year'
			AND T0.[ContraAct] != '305999'    
			GROUP BY T1.[U_BPType], T1.[LicTradNum], T1.[VatIdUnCmp], T1.[CardName],  T1.[CardCode], T0.[Account]
			ORDER BY T0.[Account] ASC";    // EXCLUDE ACCOUNT 305999 . IT IS FOR PERIOD OPENING BALANCES BY ACCOUNTING DEPT.
*/

	$tsql = "SELECT (SELECT T1.[U_BPType] FROM OCRD T1 WHERE T1.[CardCode] = T0.[ContraAct]) AS 'Tipo de Persona',
					(SELECT T1.[LicTradNum] FROM OCRD T1 WHERE T1.[CardCode] = T0.[ContraAct]) AS 'RUC',
					(SELECT T1.[VatIdUnCmp] FROM OCRD T1 WHERE T1.[CardCode] = T0.[ContraAct]) AS 'DV',
					(SELECT T1.[CardName] FROM OCRD T1 WHERE T1.[CardCode] = T0.[ContraAct]) AS 'Nombre o Razon Social',
					(SELECT T1.[CardCode] FROM OCRD T1 WHERE T1.[CardCode] = T0.[ContraAct]) AS 'BP Account Num',
					T0.[Account], (T0.[Debit] - T0.[Credit]) AS 'Monto',
					CASE T0.[TransType]
						WHEN	-3	THEN	'BC'
						WHEN	-4	THEN	'BN'
						WHEN	182	THEN	'BT'
						WHEN	14	THEN	'CN'
						WHEN	57	THEN	'CP'
						WHEN	76	THEN	'DD'
						WHEN	15	THEN	'DN'
						WHEN	25	THEN	'DP'
						WHEN	203	THEN	'DT'
						WHEN	69	THEN	'IF'
						WHEN	67	THEN	'IM'
						WHEN	13	THEN	'IN'
						WHEN	30	THEN	'JE'
						WHEN	162	THEN	'MR'
						WHEN	-2	THEN	'OB'
						WHEN	19	THEN	'PC'
						WHEN	20	THEN	'PD'
						WHEN	21	THEN	'PR'
						WHEN	46	THEN	'PS'
						WHEN	18	THEN	'PU'
						WHEN	202	THEN	'PW'
						WHEN	24	THEN	'RC'
						WHEN	16	THEN	'RE'
						WHEN	-5	THEN	'RU'
						WHEN	59	THEN	'SI'
						WHEN	60	THEN	'SO'
						WHEN	58	THEN	'ST'
					END AS 'TransType',
					T0.[TransId] AS 'TransId'
			FROM JDT1 T0
			WHERE T0.[Account] ='$gl_account'
			AND YEAR(T0.[RefDate])='$year'
			AND T0.[ContraAct] != '305999'";


	// DEBUG
	/*
	echo '<br/>';
	echo $tsql;
	echo '<br/>';
	*/

	$stmt = mssql_query( $tsql, $conn );

	if( $stmt === false ) {
		echo "Error in executing query [1].</br>";
		die( print_r( mssql_get_last_message(), true));
	} else {

		$num_of_rows = $num_of_rows + mssql_num_rows($stmt);
	}



	while ( $row = mssql_fetch_array( $stmt ) ) {

		$result_table_vendors[$index] = $row;

		// DEBUG
		/*
		echo "$index: ";
		print_r($result_table_vendors[$index]);
		echo "<br/>";
		*/



		/*
		 *	VERIFY A/P INVOICES ARE NOT CANCELED - USE $result_table.BaseRef
		 */
		/*
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
		*/

		$index++;
	}
}

// DEBUG
echo '<br/>number of rows in result table = '.$num_of_rows;

print_table( $result_table_vendors );
//print_table( $canceled_ap_invoices );







/*
 *  CREATE AND FILL OUT NEW EXCEL FILE WITH EXTRACTED DATA
 *
 */

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("ADELGADO")
            ->setLastModifiedBy("ADELGADO")
            ->setTitle("MEF-EOY-REPORT")
            ->setSubject("MEF-EOY-REPORT")
            ->setDescription("Report for Annual Taxes Declaration")
            ->setKeywords("MEF taxes report declaration")
            ->setCategory("Reports from SAP");
 
// Worksheet headers
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tipo de Persona')
            ->setCellValue('B1', 'RUC')
            ->setCellValue('C1', 'DV')
            ->setCellValue('D1', 'Nombre o Razon Social')
            ->setCellValue('E1', 'BP Account Number')
            ->setCellValue('F1', 'GL Account')
            ->setCellValue('G1', 'Monto')
            ->setCellValue('H1', 'TransType')
            ->setCellValue('I1', 'TransId');

//  WRITE LINES TO FILE
$rowCount = 2;
for( $i = 0; $i <= (sizeof($result_table_vendors) - 1); $i++ ){

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $result_table_vendors[$i]['Tipo de Persona']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $result_table_vendors[$i]['RUC'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $result_table_vendors[$i]['DV'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('D'.$rowCount, $result_table_vendors[$i]['Nombre o Razon Social']);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('E'.$rowCount, $result_table_vendors[$i]['BP Account Num'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValueExplicit('F'.$rowCount, $result_table_vendors[$i]['Account'], PHPExcel_Cell_DataType::TYPE_STRING);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $result_table_vendors[$i]['Monto']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $result_table_vendors[$i]['TransType']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $result_table_vendors[$i]['TransId']);
    
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
/*
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
*/

/*
 *  WRITE LINES TO FILE
 */
/*
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
*/



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$excel_file_name = "MEF-REPORT_Form_94_".$year."_c".date('Ymd_Hi').'.xlsx';

$objWriter->save( "../reports/$excel_file_name" );


// Echo done
echo "<br/><br/>Download Excel file: ";
echo "<a href=\"../reports/$excel_file_name\">$excel_file_name</a>";















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
        
        	echo "<td>";
        	echo $i+1;
        	echo "</td>";

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