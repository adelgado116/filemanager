<?php

/*	
 *	MAIN PROGRAM
 *
 */

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

if ($_REQUEST['filterSelect1ID'] == 0) {
    $accountCategory = "CHAR_LENGTH(AcctCode)=6"; // CHAR_LENGTH(AcctCode)
}else{
    $accountCategory = "CHAR_LENGTH(AcctCode)=6 AND AcctCode LIKE '%".$_REQUEST['filterSelect1ID']."%'";
}

/*
 *	GET DATA FROM MYSQL DATABASE
 *
 */
$sql = "SELECT * FROM sapbo_oact WHERE ($accountCategory) AND (AcctName LIKE '%$keyword%' OR AcctCode LIKE '%$keyword%')";
$result1 = $link_id->query($sql);

$sql = "SELECT sapbo_oact.active, sapbo_oact.AcctCode, sapbo_oact.AcctName, MEF_forms.MEF_form_number, MEF_concepts.MEF_concept_description, sapbo_oact.payment_type
		FROM sapbo_oact, MEF_forms, MEF_concepts 
		WHERE sapbo_oact.MEF_form_id = MEF_forms.MEF_form_id
		AND sapbo_oact.MEF_concept_id = MEF_concepts.MEF_concept_id
		AND ($accountCategory) AND (AcctName LIKE '%$keyword%' OR AcctCode LIKE '%$keyword%')
		LIMIT $offset,$pageSize";
$result2 = $link_id->query($sql);


$result_to_encode = array();
$result_to_encode['num_rows'] = $result1->num_rows;
$result_to_encode['table'] = get_table( $result2 );

echo( json_encode( $result_to_encode ) );


?>