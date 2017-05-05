<?php
// REMOVE LOAD(S) FROM GROUP(S)

// session check
session_start();
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user_id'];
}

include('functions.php');
include('dbConnect.inc');


//
// GET ARRAY OF LOADS TO BE CONFIGURED
//
$loads_unprocessed = explode('&', $_REQUEST['loads']);

$return_arr['status'] = 1;

foreach($loads_unprocessed as $load){
    
    $load = explode('=', $load);  // load_id is $load[1]
    
    // GET LOAD ID
    $load_id = $load[1];
    
    $sql = "UPDATE loads SET load_group_id='1' WHERE load_id='".$load_id."'";
    
    // send query
    if ( mysqli_query( $link_id, $sql ) ) {
        
        // 	write to log file
        $fh = fopen( "lnl.log", 'a');
        fwrite( $fh, 'I: '.date('Y.m.d,His').' user <'.$_SESSION['user']."> changed load with id [$load_id] to group 1.\n" );
        fclose( $fh );
    
    } else {
        
        // 	write to log file
        $fh = fopen( "lnl.log", 'a');
        fwrite( $fh, 'E: '.date('Y.m.d,His').' user <'.$_SESSION['user']."> failed changing load with id [$load_id] to group 1.\n" );
        fclose( $fh );
    }
}

echo json_encode($return_arr);
?>