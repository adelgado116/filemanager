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
echo "--  MSSQL-to-MySQL Importing Script<br/>";
echo "--  NON-OBS<br/>";
echo "--  ADE for HSS<br/>";
echo "--  last edition: 2014.01.28-10:39<br/>";
echo "-------------------------------------------------<br/>"; 
 
#
# GET DATA FROM OLD MSSQL DATABASE
#
/*
$server = "s-sql2008.fstg.local";
$user = "HSS";
$pass = "HSSintegration";
$database = "HSS";
*/

$server = "s-sql2012.fstg.local\sql2012";
$user = "HSS";
$pass = "HSSintegration";
$database = "HSS";

$conn = mssql_connect($server, $user, $pass);

if( $conn === false ) {
    $fh = fopen( "mssql.log", 'a' );
    fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER_NON_OBS - unable to connect to MSSQL server\n" );
    fclose( $fh );

    echo "<strong>UNABLE TO CONNECT TO MSSQL - CONTACT IT DEPARTMENT.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
    die( print_r( mssql_get_last_message(), true));
} else {
    $selected_db = mssql_select_db( $database, $conn ) or die("<br/>Couldn’t open database $database");
    echo "<br/>connected to database $database<br/>";
}


########################  SALES TABLE  ########################
$remote_table = "SalesTable";
$tsql = "SELECT CREATEDATE,SALESNUMBER,IMOnumber,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT,DELMODE
         FROM $remote_table WHERE DELMODE='PICK' OR DELMODE='UPS' OR DELMODE='FDX' OR DELMODE='DHL' OR DELMODE='FRW' OR DELMODE='ROAD' ORDER BY CREATEDATE DESC";

$stmt = mssql_query( $tsql, $conn );
if( $stmt === false ){
    $fh = fopen( "mssql.log", 'a' );
    fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER_NON_OBS - error executing query [1]\n" );
    fclose( $fh );

    echo "Error in executing query [1].</br>";
    die( print_r( mssql_get_last_message(), true));
}


$sales_table = array();
$sales_table = get_table( $stmt );

echo "extracted from $server->$database->$remote_table:  ".sizeof( $sales_table )." records<br/>";



#
# GET DATA FROM NEW MSSQL DATABASE
#
$server2 = "s-sql2008.fstg.local";
$user2 = "HSSSERVICEREP";
$pass2 = "SERVICE1234";
$database2 = "HSS-ServiceReport";

/* Connect using SQL Server Authentication. */
$conn2 = mssql_connect($server2, $user2, $pass2);

if( $conn2 === false )
{
	$fh = fopen( "mssql.log", 'a' );
	fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER_NON_OBS - unable to connect to MSSQL server\n" );
	fclose( $fh );

	echo "<strong>UNABLE TO CONNECT TO NEW DATABASE - CONTACT IT DEPARTMENT.</strong></br></br>ignore the following lines (used for diagnostics)</br></br>";
	die( print_r( mssql_get_last_message(), true));

} else {

	$selected_db2 = mssql_select_db( $database2, $conn2 ) or die("<br/>Couldn’t open database $database2");
	
    echo "<br/>connected to database $database2<br/>";
} 
 
 
########################  SALES TABLE  ########################
$remote_table2 = "[SALESTABLE-OBS]";
$tsql = "SELECT CREATEDDATETIME,SALESID,CUSTOMERREF,PURCHORDERFORMNUM,SALESNAME,CUSTACCOUNT,DLVMODE
         FROM $remote_table2 WHERE DLVMODE='PICK' OR DLVMODE='UPS' OR DLVMODE='FDX' OR DLVMODE='DHL' OR DLVMODE='FRW' OR DLVMODE='ROAD' ORDER BY CREATEDDATETIME DESC";

$stmt2 = mssql_query( $tsql2, $conn2 );
if( $stmt2 === false )
{
	$fh = fopen( "mssql.log", 'a' );
	fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER_NON_OBS - error executing query [2]\n" );
	fclose( $fh );

	echo "Error in executing query [2].</br>";
	die( print_r( mssql_get_last_message(), true));
}


$sales_table_2 = array();
$sales_table_2 = get_table( $stmt2 );

echo "extracted from $server2->$database2->$remote_table2:  ".sizeof( $sales_table_2 )." records<br/><br/>";
 

 
 
#
#  MySQL import
# 
 
require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

#
#  truncate (clean up) hss_db.sales_table_imported_non_obs
#
$sql = "TRUNCATE TABLE sales_table_imported_non_obs";
$res1 = $db->query($sql);


#
#  import the excerpts from SALESTABLE (2003) and SALESTABLE (2008) to hss_db.sales_table_imported_non_obs
#
for ( $i = 0; $i <= ( sizeof( $sales_table ) - 1 ); $i++ ) {

	$sales_number = substr( $sales_table[$i]['SALESNUMBER'], 4, 6 );
	
	$date = date_create( $sales_table[$i]['CREATEDATE'] );
	$create_date = date_format( $date, "d-m-Y" );
	
	$imo_number = $sales_table[$i]['IMOnumber'];
	$customer_ref = $sales_table[$i]['CUSTOMERREF'];
	$requis_number = $sales_table[$i]['REQUISNUMBER'];
	$sales_name = $sales_table[$i]['SALESNAME'];
	$debtor_account = $sales_table[$i]['DEBTORACCOUNT'];
	$del_mode = $sales_table[$i]['DELMODE'];
	
	
	$sql ="INSERT INTO
		   sales_table_imported_non_obs ( CREATEDATE,SALESNUMBER,IMOnumber,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT,DELMODE )
		   VALUES ( '$create_date', '$sales_number', '$imo_number', '$customer_ref', '$requis_number', '$sales_name', '$debtor_account', '$del_mode' )";

	$res2 = $db->query($sql);
}


for ( $i = 0; $i <= ( sizeof( $sales_table_2 ) - 1 ); $i++ ) {

	$sales_number = $sales_table_2[$i]['SALESID'];
	
	$date = date_create( $sales_table[$i]['CREATEDATE'] );
	$create_date = date_format( $date, "d-m-Y" );
		
	//$imo_number = $sales_table_2[$i]['IMOnumber'];
	$customer_ref = $sales_table_2[$i]['CUSTOMERREF'];
	$requis_number = $sales_table_2[$i]['PURCHORDERFORMNUM'];
	$sales_name = $sales_table_2[$i]['SALESNAME'];
	$debtor_account = $sales_table_2[$i]['CUSTACCOUNT'];
	$del_mode = $sales_table_2[$i]['DLVMODE'];
	
	
	$sql ="INSERT INTO
		sales_table_imported_non_obs ( CREATEDATE,SALESNUMBER,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT,DELMODE )
		VALUES ( '$create_date', '$sales_number', '$customer_ref', '$requis_number', '$sales_name', '$debtor_account', '$del_mode' )";

	$res3 = $db->query($sql);
} 


$fh = fopen( "mssql.log", 'a' );
fwrite( $fh, date('Y.m.d-H:i:s')." - MSSQL_IMPORTER_NON_OBS - import completed.\n" );
fclose( $fh );


echo '<br/>Import has been completed.';


?>
