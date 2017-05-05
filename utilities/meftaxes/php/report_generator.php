<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('PHPExcel_180/Classes/PHPExcel.php');

include('functions.php');
include('dbConnect_i.php');


/*
 *	GET REPORT PERIOD (YEAR)
 *	FROM report_year SELECT CONTROL FROM index.html
 */
$year = substr($_REQUEST['report_year'], 2);

$report_initial_date = "01/01/".$year;
$report_ending_date = "01/01/".($year+1);



/*
 *	GET DATA FROM MYSQL DATABASE
 *	- Accounts with active = '1'
 *
 */
$sql1 = "SELECT * FROM sapbo_oact WHERE active = '1'";
$result1 = $link_id->query($sql1);
$active_gl_accounts = get_table( $result1 );

// DEBUG
//print_r( $active_gl_accounts );


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
for($j = 0; $j <= (sizeof($active_gl_accounts) - 1); $j++) {

	
	// DEBUG
	/*
	echo '<br/>';
	print_r($active_gl_accounts[$j]);
	echo '<br/>';
	*/

	$gl_account = $active_gl_accounts[$j]['AcctCode'];

	/*
	$tsql = "SELECT T0.[Account], T0.[Debit], T0.[Credit], T0.[ContraAct], T0.[RefDate], T0.[BaseRef]
			FROM JDT1 T0
			WHERE T0.[Account] = $gl_account
			AND T0.[RefDate] >= '".$report_initial_date."'
			AND T0.[RefDate] < '".$report_ending_date."'
			AND T0.[ContraAct] != '305999'";  // EXCLUDE THIS ACCOUNT. IT IS FOR PERIOD OPENING BALANCES BY ACCOUNTING DEPT.
	*/

	$tsql = "SELECT T0.[Account], T0.[Debit], T0.[Credit], T0.[ContraAct], T0.[RefDate], T0.[BaseRef]
			FROM JDT1 T0
			WHERE T0.[Account] = $gl_account
			AND T0.[RefDate] >= '".$report_initial_date."'
			AND T0.[RefDate] < '".$report_ending_date."'
			AND T0.[ContraAct] != '305999'";  // EXCLUDE THIS ACCOUNT. IT IS FOR PERIOD OPENING BALANCES BY ACCOUNTING DEPT.

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
	}

	$index = 0;
	$result_table = array();
	$filling = array( 'Tipo de Persona' => 'JE', 'RUC' => '0', 'DV' => '0', 'Nombre o Razon Social' => 'Journal Entry' );


	// DEBUG
	echo '<br/>';
	print_r($filling);
	echo '<br/>';



	while ( $row = mssql_fetch_array( $stmt ) ) {
		$result_table[$index] = $row;

		// DEBUG
		/*
		echo "$index: ";
		print_r($result_table[$index]);
		echo "<br/>";
		*/


		/*
		 *  GET VENDOR DATA FROM $result_table USING ContraAct AS KEY
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
		 *	PREPPEND VENDOR DETAILS TO CURRENT RECORD IN $result_table
		 */
		if( strlen($result_table[$index]['BaseRef']) == 6 && substr($result_table[$index]['BaseRef'], 0, 1) == '8' ){

			// DEBUG
			//echo "<br/>ap invoice found<br/>";

			//$result_table[$index] = array_merge( $result_table[$index], $row3 );
			$result_table[$index] = array_merge( $row3, $result_table[$index] );

		} else {

			if ( strlen($result_table[$index]['BaseRef']) != 6) {

				$result_table[$index] = array_merge( $filling, $result_table[$index] );
			}
		}


		/*
		 *	VERIFY A/P INVOICES ARE NOT CANCELED - USE $result_table.BaseRef
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
 *	PROCESS DATA FROM RESULT SET
 *	
 *	- 
 *
 *
 *	
 *
 */
//for ( $i = 0; $i <= ($report_records - 1); $i++ ) {
for ( $i = 0; $i <= 1; $i++ ) {

	// GET CURRENT RECORD VALUES AND COPY THEM TO NEW ARRAY
	$j = 0;
	for ( $k = 0; $k <= 3; $k++ ) {

		$report_table[$j][] = $report_records[$i][$k];

	}
	
	// GET "TIPO DE PAGO" AND "CONCEPTO" FROM SAPBO_OACT TABLE, COPY THEM TO NEW ARRAY
	$currect_gl_account = $report_records[$i][4];
	$sql2 = "SELECT sapbo_oact.payment_type, MEF_concepts.MEF_concept_number
			FROM sapbo_oact, MEF_concepts
			WHERE sapbo_oact.MEF_concept_id = MEF_concepts.MEF_concept_id
			AND AcctCode = $currect_gl_account
			AND active = '1'";
	$result2 = $link_id->query($sql2);
	$gl_account_properties = mysqli_fetch_array($result2, MYSQL_ASSOC);

	$report_table[$j][] = $gl_account_properties['payment_type'];
	$report_table[$j][] = $gl_account_properties['MEF_concept_number'];

	/* LOOP THROUGH $report_records LOOKING FOR SAME "RUC"
	 * ON EACH OCCURENCE ADD UP "DEBIT" VALUE
	 *
	 */
	;


	$j++;
}


print_r($report_table);


























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