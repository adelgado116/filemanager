<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors',1);


// connect to database
$db = new mysqli('localhost', 'root', 'Marine1234', 'hss_db');


// open file and load lines on to an array
$filename = "MEF_94_concepts.csv";

$file_lines = file ( $filename );


// loop over lines and insert them into MEF_concepts
for ($i = 0; $i <= sizeof($file_lines) - 1; $i++) {
	//print_r($file_lines[$i]);  // debug

	$file_line = explode(';', $file_lines[$i]);

	$sql1 = "INSERT INTO MEF_concepts ( MEF_concept_number, MEF_concept_description, MEF_form_id )
			VALUES ( '".$file_line[0]."', '".$file_line[1]."', '2' ) ";

	$sql_result1 = $db->query($sql1);
}


// return with ok message
echo $i." lines inserted into MEF_concepts table";


?>