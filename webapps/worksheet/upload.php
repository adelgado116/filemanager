<?php


//check that a file is present without errors
if ( ( !empty( $_FILES['uploaded_file'] ) ) && ( $_FILES['uploaded_file']['error'] == 0 ) ) {

	//Check the filetype and size
	$filename = basename($_FILES['uploaded_file']['name']);
	
	//$ext = substr($filename, strrpos($filename, '.') + 1);
	
	//if (($ext == "jpg") && ($_FILES["uploaded_file"]["type"] == "image/jpeg") && ($_FILES["uploaded_file"]["size"] < 5000000)) {
	if ( $_FILES['uploaded_file']['size'] < 30000000 ) {
	
		//Determine the path to which we want to save this file
		$newname = $_POST['folder_path']."/".$filename;
		
		//Check if a file with the same name already exists on the server
		if ( !file_exists($newname) ) {
			
			//Attempt to move the uploaded file to it's new place
			if ( ( move_uploaded_file( $_FILES['uploaded_file']['tmp_name'], $newname ) ) ) {

				//echo "It's done! The file has been saved as: ".$newname;
				//header("Location: message.php?message=ok&path=$newname");
				
				
				# just return to FILE MANAGER -user won't notice he has left the file manager
				$order = $_REQUEST['ORDER_NO'];
				
				header("Location: page0_2.php?SALESNUMBER=$order");
				
			} else {
			
				//echo "Error: A problem occurred during file upload!";
				header("Location: message.php?message=not_ok");
			}
			
		} else {
		
			//echo "Error: File ".$_FILES['uploaded_file']['name']." already exists";
			
			$path_chunks = split("[/\\.]", $newname) ;
			$n = count( $path_chunks ) - 1;
			
			$current_filename = $path_chunks[$n - 1];
			$exts = $path_chunks[$n];
			
			$newname = $_POST['folder_path']."/".$current_filename.'_v'.date('dmY_Hi').'.'.$exts;
			
			//Attempt to move the uploaded file (new version) to it's new place
			if ( ( move_uploaded_file( $_FILES['uploaded_file']['tmp_name'], $newname ) ) ) {

				//echo "It's done! The file has been saved as: ".$newname;
				//header("Location: message.php?message=new&path=$newname");
				
				# just return to FILE MANAGER -user won't notice he has left the file manager
				$imo = $_REQUEST['IMO_NUMBER'];
				$order = $_REQUEST['ORDER_NO'];
				
				header("Location: page0_2.php?SALESNUMBER=$order");
				
			} else {
			
				//echo "Error: A problem occurred during file upload!";
				header("Location: message.php?message=not_ok");
			}
		}
	} else {
		
		//echo "Error: Only .jpg images under 350Kb are accepted for upload";
		header("Location: message.php?message=too_big");
	}
	
} else {
	
	//echo "Error: No file uploaded";
	header("Location: message.php?message=empty");
}

?>