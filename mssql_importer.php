<?php

$start = time();

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
echo "--  MSSQL-to-MySQL Importing Script<br/>";
echo "--  OBS<br/>";
echo "--  ADE for HSS<br/>";
echo "--  last edition: 2014.01.28-10:39<br/>";
echo "-------------------------------------------------<br/>"; 
 
/*
 * GET DATA FROM MSSQL DATABASE
 *
 */
$server = "192.168.244.29";    //"sapbo";
$user = "dbuser";
$pass = "Raytheon10";
$database = "ERP";

$conn = mssql_connect($server, $user, $pass);

if( $conn === false ) {
	$fh = fopen( "mssql.log", 'a' );
	fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER - unable to connect to MSSQL server\n" );
	fclose( $fh );

	echo mssql_get_last_message();
	echo "<strong>UNABLE TO CONNECT TO MSSQL - CONTACT IT DEPARTMENT.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
	die( print_r( mssql_get_last_message(), true));

} else {
    $selected_db = mssql_select_db( $database, $conn ) or die("<br/>Couldn’t open database $database");
    echo "<br/>connected to database $database<br/><br/>";
}


/*
 * REMOTE SALES TABLE
 *
 */
$remote_table = "ORDR";
$tsql = "SELECT DocDate,DocNum,U_IMO,NumAtCard,U_Shipname,CardName,CardCode
         FROM $remote_table WHERE SlpCode='1' ORDER BY DocDate DESC";

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false )
{
	$fh = fopen( "mssql.log", 'a' );
	fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER - error executing query [1]\n" );
	fclose( $fh );

	echo "Error in executing query [1].</br>";
	die( print_r( mssql_get_last_message(), true));
}


$sales_table = array();
$sales_table = get_table( $stmt );

print_r($sales_table);
echo "<br/><br/>extracted from $server >> $database >> $remote_table:  ".sizeof( $sales_table )." records<br/>";


#
#  Import to MySQL
#
require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

#
#  truncate (clean up) hss_db.sales_table_imported
#
$sql = "TRUNCATE TABLE sales_table_imported";
$res1 = $db->query($sql);

#
#  import REMOTE and LOCAL SALES TABLES to hss_db.sales_table_imported
#
for ( $i = 0; $i <= ( sizeof( $sales_table ) - 1 ); $i++ ) {

	$sales_number = $sales_table[$i]['DocNum'];
	$date = date_create( $sales_table[$i]['DocDate'] );
	//$create_date = date_format( $date, "d-m-Y" );
	$create_date = date_format( $date, "Y-m-d" );
	$imo_number = $sales_table[$i]['U_IMO'];
	$customer_ref = $sales_table[$i]['U_Shipname'];
	$requis_number = $sales_table[$i]['NumAtCard'];
	$sales_name = $sales_table[$i]['CardName'];
	$debtor_account = $sales_table[$i]['CardCode'];
	
	
	$sql ="INSERT INTO
		   sales_table_imported ( CREATEDATE,SALESNUMBER,IMOnumber,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT )
		   VALUES ( '$create_date', '$sales_number', '$imo_number', '$customer_ref', '$requis_number', '$sales_name', '$debtor_account' )";

	$res2 = $db->query($sql);
}



################## LOCAL SALES TABLE (old HSS system) ##################
$sql = "SELECT * FROM sales_table_hss ORDER BY CREATEDATE DESC";
$res = $db->query($sql);

echo "<br/>extracted from freja >> hss_db >> sales_table_hss:  ".$res->size()." records<br/><br/>";


$sql = "INSERT INTO sales_table_imported SELECT * FROM sales_table_hss";
$res = $db->query($sql);



$end = time();
$process_time = $end - $start;

$fh = fopen( "mssql.log", 'a' );
fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER - import completed - process took [$process_time] seconds.\n" );
fclose( $fh );


echo '<br/>Import has been completed.';
?>
