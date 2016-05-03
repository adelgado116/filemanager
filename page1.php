<?php

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

$tsql = "SELECT SALESNUMBER,LASTCHANGED,SALESNAME,CREATEDATE, CUSTOMERREF, OURREF, IMOnumber, DELMODE
         FROM SalesTable ORDER BY SALESNUMBER DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

// count number of rows             THIS IS A MISSING FEATURE IN MSSQL SERVER DRIVER FOR PHP
$i = 1;
while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {
  $i++;
}
echo $i;  // total number of rows retreived from SalesTable


$tsql = "SELECT SALESNUMBER,LASTCHANGED,SALESNAME,CREATEDATE, CUSTOMERREF, OURREF, IMOnumber, DELMODE
         FROM SalesTable ORDER BY SALESNUMBER DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

echo "<br/><br/>";
echo "SALES TABLE:<br/>";
// table header
$fields = array("SALESNUMBER","LASTCHANGED","SALESNAME","CREATEDATE","CUSTOMERREF","OURREF","IMO","DELMODE");

echo "<table border=\"1\"> <tr>";

for ( $i = 0; $i<= (sizeof($fields) - 1); $i++ ) {
    echo "<th>".$fields[$i]."</th>";
}

echo "</tr>";


// table body
for ( $i = 0; $i <= 14; $i++ ) {
//while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {

  $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/);

  echo "<tr>";

  // print data into table cells
  for ( $f = 0; $f <= (sizeof($fields) - 1); $f++ ) {
    echo "<td>";
    
    // format datetime fields to be presented as strings
    if ( $f == 1 || $f == 3 ) {
      $toPrint = date_format( $row[$fields[$f]], "m-d-Y" );
    } else {
      $toPrint = $row[$fields[$f]];
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

$tsql = "SELECT ACCOUNTNUMBER, NAME, ADDRESS1
         FROM DebTable ORDER BY ACCOUNTNUMBER DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

// count number of rows             THIS IS A MISSING FEATURE IN MSSQL SERVER DRIVER FOR PHP
$i = 1;
while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {
  $i++;
}
echo $i;  // total number of rows retreived from SalesTable


$tsql = "SELECT ACCOUNTNUMBER, NAME, ADDRESS1
         FROM DebTable ORDER BY ACCOUNTNUMBER DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

echo "<br/><br/>";
echo "DEB TABLE:<br/>";
// table header
$fields = array("ACCOUNTNUMBER", "NAME", "ADDRESS1");

echo "<table border=\"1\"> <tr>";

for ( $i = 0; $i<= (sizeof($fields) - 1); $i++ ) {
    echo "<th>".$fields[$i]."</th>";
}

echo "</tr>";


// table body
for ( $i = 0; $i <= 14; $i++ ) {
//while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {

  $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/);

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


################################ SHIP TABLE ##########

$tsql = "SELECT IMONUMBER, NAME
         FROM ShipTable ORDER BY DATASET DESC";


$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

// count number of rows             THIS IS A MISSING FEATURE IN MSSQL SERVER DRIVER FOR PHP
$i = 1;
while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {
  $i++;
}
echo $total_ships = $i;  // total number of rows retreived from ShipTable


$tsql = "SELECT IMONUMBER, NAME
         FROM ShipTable ORDER BY DATASET DESC";
$stmt = sqlsrv_query( $conn, $tsql);
if( $stmt === false )
{
     echo "Error in executing query.</br>";
     die( print_r( sqlsrv_errors(), true));
}

echo "<br/><br/>";
echo "SHIP TABLE:<br/>";
// table header
$fields = array("IMONUMBER", "NAME");

echo "<table border=\"1\"> <tr>";

for ( $i = 0; $i<= (sizeof($fields) - 1); $i++ ) {
    echo "<th>".$fields[$i]."</th>";
}

echo "</tr>";


// table body
for ( $i = 0; $i <= $total_ships; $i++ ) {
//while ( $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/) ) {

  $row = sqlsrv_fetch_array($stmt/*, SQLSRV_FETCH_ASSOC*/);

  echo "<tr>";

  // print data into table cells
  for ( $f = 0; $f <= (sizeof($fields) - 1); $f++ ) {
    echo "<td>";
    
    // format datetime fields to be presented as strings
    /*
    if ( $f == 1 ) {
      $toPrint = date_format( $row[$fields[$f]], "m-d-Y" );
    } else {
      $toPrint = $row[$fields[$f]];
    }
    */

    $toPrint = $row[$fields[$f]];   //

    echo $toPrint;
    echo "</td>";
  }

  echo "</tr>";
}

// table end
echo "</table>";
echo "<br/>";


########################################################

echo "&copy - High Sea Support Panama - 2008.";

/* Free statement and connection resources. */
sqlsrv_free_stmt( $stmt);
sqlsrv_close( $conn);

?>

