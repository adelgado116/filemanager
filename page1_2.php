<?php


/********************************************************************
 * GET A COMPLETE TABLE FROM A [SELECT * FROM table] QUERY
 * 
 * REMARK: adapted for MSSQL Server
 *
 * notes:
 * This function returns an array of arrays. Every array contained
 * inside de main array is a associative array representing a table
 * row from a MySQL database.
 * 
 *******************************************************************/
function get_table( $result )
{
    $index = 0;
	$a = array();
	
    while ( $row = sqlsrv_fetch_array( $result/*, SQLSRV_FETCH_ASSOC*/ ) ) {
		$a[$index] = $row;
		$index++;
	}
	return $a;
}


/* Specify the server and connection string attributes. */
$serverName = "s-sql.hansbuch.local";
$connectionInfo = array( "UID"=>"HSS", "PWD"=>"HSSintegration", "Database"=>"");

/* Connect using SQL Server Authentication. */
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if( $conn === false )
{
     echo "Unable to connect.</br>";
     die( print_r( sqlsrv_errors(), true));
}


################################ SALES TABLE ##########

$tsql = "SELECT CREATEDATE,SALESNUMBER,IMOnumber,CUSTOMERREF,REQUISNUMBER,SALESNAME,DEBTORACCOUNT
         FROM SalesTable WHERE DELMODE='OBS' ORDER BY CREATEDATE DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

$sales_table = array();
$sales_table = get_table( $stmt );

//( count($sales_table) - 1 )


######## test test test test ########
/*
for ( $i = 0; $i <= 14; $i++ ) {

  $name = $sales_table[$i][5];

  $tsql = "SELECT ACCOUNTNUMBER, NAME FROM DebTable WHERE NAME='$name'";

  $stmt = sqlsrv_query( $conn, $tsql);

  if( $stmt === false )
  {
       echo "Error in executing query.</br>";
       die( print_r( sqlsrv_errors(), true));
  }

  
  $row = sqlsrv_fetch_array( $stmt );

  $sales_table[$i][6] = $row['0'];

}
*/
######## test test test test ########







echo "<br/><br/>";
echo "SALES TABLE:<br/>";
// table header
$fields = array("CREATEDATE","SALESNUMBER","IMOnumber","CUSTOMERREF","REQUISNUMBER","SALESNAME","DEBTORACCOUNT");

echo "<table border=\"1\"> <tr>";

for ( $i = 0; $i<= (sizeof($fields) - 1); $i++ ) {
    echo "<th>".$fields[$i]."</th>";
}

echo "</tr>";


// table body
for ( $row_numb = 0; $row_numb <= 14; $row_numb++ ) {

  echo "<tr>";

  // print data into table cells
  for ( $f = 0; $f <= (sizeof($fields) - 1); $f++ ) {
    echo "<td>";
    
    // format datetime fields to be presented as strings
    if ( $f == 0 ) {
	$toPrint = date_format( $sales_table[$row_numb][$f], "m-d-Y" );
    } else {
	$toPrint = $sales_table[$row_numb][$f];
    }

    echo $toPrint;
    echo "</td>";
  }

  echo "</tr>";
}

// table end
echo "</table>";
echo "<br/>";


################################ DEB TABLE ##########
/*
$name = $sales_table[$row_numb - 4][5];

$tsql = "SELECT ACCOUNTNUMBER, NAME
         FROM DebTable WHERE NAME='$name'";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

echo "<br/><br/>";
echo "DEB TABLE:<br/>";
// table header
$fields = array("ACCOUNTNUMBER", "NAME");

echo "<table border=\"1\"> <tr>";

for ( $i = 0; $i<= (sizeof($fields) - 1); $i++ ) {
    echo "<th>".$fields[$i]."</th>";
}

echo "</tr>";


// table body
for ( $i = 0; $i <= 14; $i++ ) {
//while ( $row = sqlsrv_fetch_array($stmt) ) {

  $row = sqlsrv_fetch_array($stmt);

  echo "<tr>";

  // print data into table cells
  for ( $f = 0; $f <= (sizeof($fields) - 1); $f++ ) {
    echo "<td>";

    echo $row[$fields[$f]];

    echo "</td>";
  }

  echo "</tr>";
}

// table end
echo "</table>";
echo "<br/>";

*/


########################################################

echo "&copy - High Sea Support Panama - 2008.";

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>

