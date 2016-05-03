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
echo "--  SAP DATA EXTRACTOR<br/>";
echo "-------------------------------------------------<br/>"; 

# filtering variables

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

########################  REMOTE SALES TABLE  ########################

$tsql= "SELECT CardCode, CardName, GroupCode, LicTradNum, Phone1, E_Mail, U_BPType FROM OCRD";

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$results_table = array();
$results_table = get_table( $stmt );

//print_r($results_table);

$newList = "sap_bp_list".date('dmY_Hi').".txt";

if( $file = fopen( $newList, "w") ) {
	
	fwrite( $file, "BUSINESS PARTNER CODE\tBUSINESS PARTNER NAME\tGROUP\tVAT / RUC\tPHONE\tEMAIL\t\tBP TYPE" );
    fwrite( $file, "\r" );
	
	for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){
		echo "line [$i]: ".$results_table[$i]['ItemCode'].' - '.$results_table[$i]['ItemName'].' - '.$results_table[$i]['FrgnName'].' - '.$results_table[$i]['ItmsGrpCod'].' - '.$results_table[$i]['OnHand'].' - '.$results_table[$i]['IsCommited'].' - '.$results_table[$i]['OnOrder'].' - '.$results_table[$i]['Counted'];
		
		$d1[0] = $results_table[$i]['ItemCode'];
        $d1[1] = $results_table[$i]['ItemName'];
        $d1[2] = $results_table[$i]['FrgnName'];
        $d1[3] = $results_table[$i]['ItmsGrpCod'];
		
		$d1[4] = $results_table[$i]['OnHand'];
		$d1[5] = $results_table[$i]['IsCommited'];
		$d1[6] = $results_table[$i]['OnOrder'];
		$d1[7] = $results_table[$i]['Counted'];
		
		$new = implode( "\t", $d1 );
		
        fwrite( $file, $new );
        fwrite( $file, "\r" );
        
        echo '<br/>';
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