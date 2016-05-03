<?php

/********************************************************************
 * MAIN PROGRAM
 * 
 * 
 *******************************************************************/

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


########################  REMOTE TABLE  ########################

// THIS QUERY RETRIEVES DATA FILTERED BY:
// InvntItem='Y' -- ITEM IS AN INVENTORY ITEM
// PriceList='1' -- ONLY SALES PRICES
// ItmsGrpCod!='118' -- EXCLUDE ITEMS FOR EXTERNAL SERVICES
// ItmsGrpCod!='121' -- EXCLUDE ITEMS FOR TECH HOURS SALES
$tsql = "SELECT T0.[ItemCode], T0.[ItemName], T0.[FrgnName], T0.[ItmsGrpCod], T0.[OnHand], T0.[IsCommited], T0.[OnOrder], T0.[UserText], T1.[Price], T1.[Currency] FROM OITM T0  INNER JOIN ITM1 T1 ON T0.[ItemCode] = T1.[ItemCode] WHERE (T0.[InvntItem]='Y') AND (T1.[PriceList]='1') AND (T0.[ItmsGrpCod]!='118') AND (T0.[ItmsGrpCod]!='121')";


$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}

$results_table = array();
$results_table = get_table( $stmt );


#
#  Import to MySQL
#
$db = new mysqli('localhost', 'root', 'Marine1234', 'hss_db');


#
#  import REMOTE table
#
for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){
    
	$itemCode = $results_table[$i]['ItemCode'];
	$itemName = $db->real_escape_string( $results_table[$i]['ItemName'] );
	$frgnName = $db->real_escape_string( $results_table[$i]['FrgnName'] );
	$itmsGrpCod = $results_table[$i]['ItmsGrpCod'];
	$onHand = $results_table[$i]['OnHand'];
	$isCommited = $results_table[$i]['IsCommited'];
	$onOrder = $results_table[$i]['OnOrder'];
	$userText = $db->real_escape_string( $results_table[$i]['UserText'] );
	$price = $results_table[$i]['Price'];
	$currency = $results_table[$i]['Currency'];


    $sql = "INSERT INTO sap_stock ( ItemCode, ItemName, FrgnName, ItmsGrpCod, OnHand, IsCommited, OnOrder, UserText, Price, Currency )
            VALUES ( '".$itemCode."', '".$itemName."', '".$frgnName."', '".$itmsGrpCod."', '".$onHand."', '".$isCommited."', '".$onOrder."', '".$userText."', '".$price."', '".$currency."' ) 
            ON DUPLICATE KEY UPDATE
            ItemName='".$itemName."', FrgnName='".$frgnName."', ItmsGrpCod='".$itmsGrpCod."', OnHand='".$onHand."', IsCommited='".$isCommited."', OnOrder='".$onOrder."', UserText='".$userText."', Price='".$price."', Currency='".$currency."'";
    
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