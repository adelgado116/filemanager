<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('functions.php');
include('dbConnect_i.php');


// // // //
// PENDING:
// CHANGE THIS
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=stock_list-".date('dmY-Hi').".xls");
// FOR THIS !!!
include('PHPExcel_180/Classes/PHPExcel.php');


if (isset($_REQUEST['page'])){
	$offset = $_REQUEST['page'] - 1;
}else {
	$offset = '0';
}

$offset*=20;
$keyword = $_REQUEST['keyword'];

if ($_REQUEST['manufacturerId'] == 0) {
    $manufacturerId = "ItmsGrpCod NOT LIKE '[XXX]%'";
}else{
    $manufacturerId = "ItmsGrpCod LIKE '%".$_REQUEST['manufacturerId']."%'";
}


if ( $_REQUEST['keyword']=='' && $_REQUEST['manufacturerId']==0 ) { // NO FILTER APPLIED
    $sql = "SELECT sap_stock.ItemCode, sap_stock.ItemName, sap_stock.FrgnName, sap_manufacturers.manufacturerName
            FROM sap_stock, sap_manufacturers
            WHERE sap_stock.ItmsGrpCod = sap_manufacturers.manufacturerId
            ORDER BY sap_manufacturers.manufacturerName, sap_stock.ItemCode ASC";
} else { // FILTER BY MANUFACTURER
    if( $_REQUEST['manufacturerId']!=0 && $_REQUEST['keyword']=='' ){
        $sql = "SELECT sap_stock.ItemCode, sap_stock.ItemName, sap_stock.FrgnName, sap_manufacturers.manufacturerName
                FROM sap_stock, sap_manufacturers WHERE $manufacturerId
				AND sap_stock.ItmsGrpCod = sap_manufacturers.manufacturerId
				ORDER BY manufacturerName, ItemCode ASC";
    } else {
        if( $_REQUEST['manufacturerId']!=0 && $_REQUEST['keyword']!='' ){  // FILTER BY MANUFACTURER AND BY KEYWORD
            $sql = "SELECT * FROM sap_stock WHERE ($manufacturerId) AND (ItemCode LIKE '%$keyword%' OR ItemName LIKE '%$keyword%' OR FrgnName LIKE '%$keyword%' OR UserText LIKE '%$keyword%')";
            $result1 = $link_id->query($sql);
            $end = $result1->num_rows;
            
            $sql = "SELECT sap_stock.ItemCode, sap_stock.ItemName, sap_stock.FrgnName, sap_manufacturers.manufacturerName
                    FROM sap_stock, sap_manufacturers
                    WHERE sap_stock.ItmsGrpCod = sap_manufacturers.manufacturerId
                    AND ($manufacturerId)
                    AND (ItemCode LIKE '%$keyword%' OR ItemName LIKE '%$keyword%' OR FrgnName LIKE '%$keyword%' OR UserText LIKE '%$keyword%')
                    ORDER BY sap_manufacturers.manufacturerName, sap_stock.ItemCode ASC
                    LIMIT $offset,$end";
        }
    }    
}


#
# GET DATA FROM MYSQL DATABASE
#
$result2 = $link_id->query($sql);
$results_table = get_table( $result2 );


echo "Manufacturer\tStock No.\tPart Description\tAlias";
echo "\r";
	
for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){
    
    $d1[0] = $results_table[$i]['manufacturerName'];
    $d1[1] = $results_table[$i]['ItemCode'];
    $d1[2] = $results_table[$i]['ItemName'];
    $d1[3] = $results_table[$i]['FrgnName'];
    
    $new = implode( "\t", $d1 );
    
    echo $new;
    echo "\r";
}

?>