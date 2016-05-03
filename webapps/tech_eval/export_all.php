<?php

$tech = $_REQUEST['tech_id'];

require_once('Database/MySQL.php');
$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');


$sql = "SELECT * FROM tech_eval ORDER BY service_date_year desc, service_date_month desc, service_date_day desc";
$res2 = $db->query($sql);

#
#  start writing data to file
#
$filename = "../../customer_eval_reports/ISO_Report_Techs_Evaluations_".date("dmY_Hi").".xls";
$fh = fopen( $filename, 'w' ) or die( "can't open file" );


fwrite( $fh, "ORDER NO\tTECHNICIAN\tSERVICE DATE\tPERFORMANCE\tCOORDINATION\tACCOMPLISHMENT\tQUALITY\n" );

for ( $i == 0; $i <= ( $res2->size() - 1 ); $i++ ) {
	
	$row = $res2->fetch();
	
	
	fwrite( $fh, $row['ORDER_NO']."\t" );
	
	$tech_id = $row['tech_id'];
	$sql = "SELECT emp_name FROM employees_tbl WHERE emp_id='$tech_id'";
	$res = $db->query($sql);
	$tech_name = $res->fetch();

	$id1 = $row['performance'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id1'";
	$res = $db->query($sql);
	$eval_data_1 = $res->fetch();
	
	$id2 = $row['coordination'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id2'";
	$res = $db->query($sql);
	$eval_data_2 = $res->fetch();
	
	$id3 = $row['accomplishment'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id3'";
	$res = $db->query($sql);
	$eval_data_3 = $res->fetch();
	
	$id4 = $row['quality'];
	$sql = "SELECT tech_eval_value FROM tech_eval_values WHERE tech_eval_value_id='$id4'";
	$res = $db->query($sql);
	$eval_data_4 = $res->fetch();
	
	
	fwrite( $fh, $tech_name['emp_name']."\t" );
	fwrite( $fh, $row['service_date_day']."-".$row['service_date_month']."-".$row['service_date_year']."\t" );
	fwrite( $fh, $eval_data_1['tech_eval_value']."\t" );
	fwrite( $fh, $eval_data_2['tech_eval_value']."\t" );
	fwrite( $fh, $eval_data_3['tech_eval_value']."\t" );
	fwrite( $fh, $eval_data_4['tech_eval_value'] );
	fwrite( $fh, "\n");
}

fclose( $fh );

?>

<html>
<body>
<a href="<?php echo $filename; ?>">download report</a>
</body>
</html>
