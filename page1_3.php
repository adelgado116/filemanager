<?php


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

$tsql = "SELECT SYSTEMID, ITEMNUMBER, QTY, TXT
         FROM ServSystemLines";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

$test_table = array();
$test_table = get_table( $stmt );

//( count($test_table) - 1 )




echo "<br/><br/>";
echo "TABLE:<br/>";
// table header
$fields = array("SYSTEMID", "ITEMNUMBER", "QTY", "TXT");

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
/*
    if ( $f == 0 ) {
	$toPrint = date_format( $sales_table[$row_numb][$f], "m-d-Y" );
    } else {
	$toPrint = $sales_table[$row_numb][$f];
    }
*/

    //echo $toPrint;
    echo $test_table[$row_numb][$f];
    echo "</td>";
  }

  echo "</tr>";
}

// table end
echo "</table>";
echo "<br/>";




echo "&copy - High Sea Support Panama - 2008.";

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>

