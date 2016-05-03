<?php

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=SAP_stock_".date('dmY_Hi').".xls");




/********************************************************************
 * MAIN PROGRAM
 * 
 * 
 *******************************************************************/

# filtering variables
//$filter = $_REQUEST['report_manufacturer'];
$filter = 0; // temp, 0 is ALL Manufacturers


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
    //echo "<br/>connected to database $database<br/><br/>";
}


########################  REMOTE SALES TABLE  ########################

$tsql= "SELECT ItemCode,ItemName,FrgnName,ItmsGrpCod,OnHand,IsCommited,OnOrder FROM OITM WHERE InvntItem='Y'";

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}


$results_table = array();
$results_table = get_table( $stmt );

//print_r($results_table);




echo "Stock No.\tPart Description\tForeign Description\tGroup Code\tOn Hand\tCommited\tOn Order";
echo "\r";
	
for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){
    
    $d1[0] = $results_table[$i]['ItemCode'];
    $d1[1] = $results_table[$i]['ItemName'];
    $d1[2] = $results_table[$i]['FrgnName'];
    $d1[3] = $results_table[$i]['ItmsGrpCod'];
    
    $d1[4] = $results_table[$i]['OnHand'];
    $d1[5] = $results_table[$i]['IsCommited'];
    $d1[6] = $results_table[$i]['OnOrder'];
    
    $new = implode( "\t", $d1 );
    
    echo $new;
    echo "\r";
}








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