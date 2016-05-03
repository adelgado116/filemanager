<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('functions.php');
include('dbConnect_i.php');

header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=stock_list-".date('dmY-Hi').".xls");


if (isset($_REQUEST['page'])){
	$offset = $_REQUEST['page'] - 1;
}else {
	$offset = '0';
}

$offset*=20;
$pageSize = $_REQUEST['rowsPerPage'];

$keyword = $_REQUEST['keyword'];

if ($_REQUEST['manufacturerId'] == 0) {
    $manufacturerId = "ItmsGrpCod NOT LIKE '[XXX]%'";
}else{
    $manufacturerId = "ItmsGrpCod LIKE '%".$_REQUEST['manufacturerId']."%'";
}


if ( $_REQUEST['keyword']=='' && $_REQUEST['manufacturerId']==0 ) {
    $sql = "SELECT * FROM sap_stock";
} else {
    if( $_REQUEST['manufacturerId']!=0 && $_REQUEST['keyword']=='' ){
        $sql = "SELECT * FROM sap_stock WHERE ($manufacturerId)";
    } else {
        $sql = "SELECT * FROM sap_stock WHERE ($manufacturerId) AND (ItemCode LIKE '%$keyword%' OR ItemName LIKE '%$keyword%' OR FrgnName LIKE '%$keyword%' OR UserText LIKE '%$keyword%') LIMIT $offset,$pageSize";
    }    
}


#
# GET DATA FROM MYSQL DATABASE
#
$result2 = $link_id->query($sql);

$results_table = get_table( $result2 );


echo "Stock No.\tPart Description\tForeign Description\tOn Hand\tCommited";
echo "\r";
	
for( $i=0; $i<= (sizeof($results_table) - 1); $i++ ){
    
    $d1[0] = $results_table[$i]['ItemCode'];
    $d1[1] = $results_table[$i]['ItemName'];
    $d1[2] = $results_table[$i]['FrgnName'];
 //   $d1[3] = $results_table[$i]['ItmsGrpCod'];
    
    $d1[4] = $results_table[$i]['OnHand'];
    $d1[5] = $results_table[$i]['IsCommited'];
 //   $d1[6] = $results_table[$i]['OnOrder'];
    
    $new = implode( "\t", $d1 );
    
    echo $new;
    echo "\r";
}

?>