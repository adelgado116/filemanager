<?php


$mail_list = "";


// source file
$filename = $_REQUEST['source'];

// get lines from file to array
$lines = file($filename);

// cycle through each line -- start on second line
for($i==1; $i<=sizeof($lines); $i++) {
    
    // explode each line to another array
    $line = explode("\t", $lines[$i]);
    
    // filter using selection marker -- line[5]='1'
    if ($line[5] == 1){
        
        if($line[3] != "") {  // is this email field empty?
            
            // check if the mail already exists in mail list
            if ( substr_count($mail_list, $line[3]) >= 1 ){
                ; // do nothing, skip
            } else {
                $mail_list = $mail_list.';'.$line[3];  // add to mail list
            }    
        }
        
        if($line[4] != "") {  // is this email field empty?
            
            // check if the mail already exists in mail list
            if ( substr_count($mail_list, $line[4]) >= 1 ){
                ; // do nothing, skip
            } else {
                $mail_list = $mail_list.';'.$line[4];  // add to mail list
            }
        }
    }
}



// transfer mail list to TXT file
echo $mail_list; // debug

$target = $_REQUEST['target'];
$fh = fopen($target, "a");
fwrite($fh, $mail_list);
fclose($fh);




?>