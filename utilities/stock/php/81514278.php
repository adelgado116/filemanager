<?php

// debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('functions.php');
include('dbConnect.inc');

$selection = $_REQUEST['selType'];
$id = $_REQUEST['selId'];

if ($selection=='group') {
    // get configurations for the selected group
    $res_config = mysqli_query( $link_id, "SELECT * FROM loads_groups_config WHERE loads_group_id='$id'" );
    $configs_array = array();
    $configs_array = get_table( $res_config );
}else{  // $selection=='load'
    // get configurations for the selected load
    $res_config = mysqli_query( $link_id, "SELECT * FROM loads_config WHERE load_id='$id'" );
    $configs_array = array();
    $configs_array = get_table( $res_config );
}

//print_r($configs_array);
echo( json_encode($configs_array) );
?>