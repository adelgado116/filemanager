<?php
//BindEvents Method @1-5BE6B4AB
function BindEvents()
{
    global $service_returned_parts_tb;
    $service_returned_parts_tb->CCSEvents["BeforeShow"] = "service_returned_parts_tb_BeforeShow";
}
//End BindEvents Method

//service_returned_parts_tb_BeforeShow @2-936D5544
function service_returned_parts_tb_BeforeShow(& $sender)
{
    $service_returned_parts_tb_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $service_returned_parts_tb; //Compatibility
//End service_returned_parts_tb_BeforeShow

//Custom Code @16-2A29BDB7
// -------------------------
    
	require_once('aadv/lib.php');
	require_once('Database/MySQL.php');

	$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');



	# get last receipt number and generate next
	$sql = 'SELECT MAX(sequence_no) FROM service_returned_parts_tbl WHERE LEFT(`sequence_no`,1)= \'R\'';

	$res1 = $db->query($sql);
	$row = $res1->fetch();

	$seq = $row['MAX(sequence_no)'];
	
	if ($seq == "") {
		
		$seq = "R00001";

	} else {
	
		$seq++;
	}

	$_SESSION['sequence_no'] = $seq;



	// generate barcode text (also used for PDF filename and Sequence No. displayed on PDF file)
	//$sequence = seq_gen( $seq );
	//echo $sequence;
	
	# create new returned part record
	$sql = "INSERT INTO
				service_returned_parts_tbl ( sequence_no )
			VALUES ( '$seq' )";

	$res2 = $db->query($sql);


// -------------------------
//End Custom Code

//Close service_returned_parts_tb_BeforeShow @2-03136675
    return $service_returned_parts_tb_BeforeShow;
}
//End Close service_returned_parts_tb_BeforeShow


?>
