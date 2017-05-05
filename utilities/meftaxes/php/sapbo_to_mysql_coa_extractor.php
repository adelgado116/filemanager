<?php

/*	
 *	MAIN PROGRAM
 *
 *	- READ CHART OF ACCOUNTS FROM SAPBO
 *	- UPDATE LOCAL DB.TABLE sapbo_oact
 *	- PASS JSON ENCODED TABLE TO table_view.js *
 *
 */

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


/*
 *	GET DATA FROM MSSQL DATABASE
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
    //echo "<br/>connected to database $database<br/><br/>";
}


/*******************  REMOTE TABLE  *******************/
/*
 *	THIS QUERY RETRIEVES DATA FROM SAPBO MSSQL DB:
 *
 */
$tsql = "SELECT T0.[AcctCode], T0.[AcctName] FROM OACT T0";


$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$results_table = array();
$results_table = get_table( $stmt );


/*
 *	IMPORT/UPDATE MYSQL TABLE
 */
$db = new mysqli('localhost', 'root', 'Marine1234', 'hss_db');

for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){

	$acctcode = $results_table[$i]['AcctCode'];
	$acctname = $results_table[$i]['AcctName'];
    

    $sql = "INSERT INTO sapbo_oact ( AcctCode, AcctName )
            VALUES ( '".$acctcode."', '".$acctname."' ) 
            ON DUPLICATE KEY UPDATE
            AcctCode='".$acctcode."', AcctName='".$acctname."'";
    
	$res2 = $db->query($sql);
}


//echo "total records updated + inserted = ".($i - 1);

$return_arr['records'] = $i-1;
echo json_encode($return_arr);



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