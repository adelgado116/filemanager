<?php


$letters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');


for ( $i = 0; $i <= 25; $i++ ) {

	
	//mkdir( "../../data/Admin/Service Coordinator Files/Service Raports/".$letters[$i], 0777 );
	mkdir( "data/".$letters[$i], 0777 );

	echo $letters[$i];
}


echo "<br/>finished";
?>