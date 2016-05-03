<?php


$fh = fopen("test_result.txt", 'a');

fwrite( $fh, date('Y-m-d - H:i:s') );
fwrite( $fh, "\n" );

fclose( $fh );


?>
