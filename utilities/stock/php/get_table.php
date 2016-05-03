<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);

include('functions.php');
include('dbConnect_i.php');

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

#
# GET DATA FROM MYSQL DATABASE
#
$sql = "SELECT * FROM sap_stock WHERE ($manufacturerId) AND (ItemCode LIKE '%$keyword%' OR ItemName LIKE '%$keyword%' OR FrgnName LIKE '%$keyword%' OR UserText LIKE '%$keyword%')";
$result1 = $link_id->query($sql);

$sql = "SELECT sap_stock.ItemCode, sap_stock.ItemName, sap_stock.OnHand, sap_stock.IsCommited, sap_stock.Price, sap_stock.Currency, sap_stock.UserText, sap_manufacturers.manufacturerName
		FROM sap_stock, sap_manufacturers
		WHERE sap_stock.ItmsGrpCod = sap_manufacturers.manufacturerId
		AND ($manufacturerId)
		AND (ItemCode LIKE '%$keyword%' OR ItemName LIKE '%$keyword%' OR FrgnName LIKE '%$keyword%' OR UserText LIKE '%$keyword%')
		ORDER BY sap_manufacturers.manufacturerName, sap_stock.ItemCode ASC
		LIMIT $offset,$pageSize";
$result2 = $link_id->query($sql);


$result_to_encode = array();
$result_to_encode['num_rows'] = $result1->num_rows;
$result_to_encode['table'] = get_table( $result2 );

echo( json_encode( $result_to_encode ) );

?>