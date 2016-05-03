<?php

function seq_gen( $seq )
{
 $fillLength = 4;
 $seqLength = strlen($seq);
 
 $fillLength = $fillLength - $seqLength;

 $fill = '';
 for ( $i = 1; $i <= $fillLength; $i++ ) {
     $fill = $fill.'0';
 }

 return 'R'.$fill.$seq;
}


function format_text( $text )
{
	strchr();
}


?>
