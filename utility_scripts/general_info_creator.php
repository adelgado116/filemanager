<?php

//
//  OPEN REPOSITORY TO GET FOLDERS
//
$path = "knowledgebase";
$dir = opendir( $path );


while ( $entry = readdir( $dir ) ) {
	$dir_array[] = $entry;
}

closedir( $dir );

$index_count = count( $dir_array );
sort( $dir_array );

// debug
echo $index_count . " folders</br></br>";


for( $j = 2; $j < $index_count; $j++) {
	
	// debug
	echo "</br>". $dir_array[$j] . "</br>" ;
	
	
	// check if folder exists, if not then create it	
	if ( !file_exists( $path."/GENERAL_INFO" ) ) {
	
		mkdir( $path."/".$dir_array[$j]."/GENERAL_INFO", 0777 );
		mkdir( $path."/".$dir_array[$j]."/GENERAL_INFO/drawings", 0777 );
		mkdir( $path."/".$dir_array[$j]."/GENERAL_INFO/others", 0777 );
		mkdir( $path."/".$dir_array[$j]."/GENERAL_INFO/pictures", 0777 );
	}
	
	echo "created folder for: ". $dir_array[$j];
	echo "</br>";
}

?>
