<?php

$imo = $_REQUEST['IMO_NUMBER'];


require_once('Database/MySQL.php');

$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');
$sql = "SELECT SHIP_NAME FROM ships_tbl WHERE IMO_NUMBER='$imo'";
$res1 = $db->query($sql);
$res1_value = $res1->fetch();



//
//  OPEN REPOSITORY TO GET FOLDERS
//
$dir_path = "../../knowledgebase/$imo/GENERAL_INFO";
	
$directory = opendir( $dir_path );

while ( $entry = readdir( $directory ) ) {
	$dir_array[] = $entry;
}

closedir( $directory );

$index_count = count( $dir_array );
sort( $dir_array );

?>


<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>File Manager</title>
	
	<link href="Styles/Blueprint1/Style_doctype.css" type="text/css" rel="stylesheet">
	<link href="css/start/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>	
	
	<script type="text/javascript">
	
	var folderSelector = 0;
	
	
	
	function sendFileToServer(formData,status,folder)
	{
		switch(folder) {
			case 1:
				folder = "drawings";
				break;
			case 2:
				folder = "others";
				break;
			case 3:
				folder = "pictures";
				break;
			default:
				break;
		}
	
		var uploadURL ="upload.php?imo=<?php echo $imo; ?>&order=GENERAL_INFO&folder=" + folder ; //Upload URL
		
		var extraData ={}; //Extra Data.
		
		var jqXHR=$.ajax({
				xhr: function() {
				var xhrobj = $.ajaxSettings.xhr();
				if (xhrobj.upload) {
						xhrobj.upload.addEventListener('progress', function(event) {
							var percent = 0;
							var position = event.loaded || event.position;
							var total = event.total;
							if (event.lengthComputable) {
								percent = Math.ceil(position / total * 100);
							}
							//Set progress
							status.setProgress(percent);
						}, false);
					}
				return xhrobj;
			},
		url: uploadURL,
		type: "POST",
		contentType:false,
		processData: false,
		cache: false,
		data: formData,
		success: function(data){
		
			status.setProgress(100);
			
			
		}
		
		});
	 
		status.setAbort(jqXHR);
	}
	 
	var rowCount=0;
	function createStatusbar(obj)
	{
		 rowCount++;
		 var row="odd";
		 if(rowCount %2 ==0) row ="even";
		 this.statusbar = $("<div class='statusbar "+row+"'></div>");
		 this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
		 this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
		 this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
		 this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
		 obj.after(this.statusbar);
	 
		this.setFileNameSize = function(name,size)
		{
			var sizeStr="";
			var sizeKB = size/1024;
			if(parseInt(sizeKB) > 1024)
			{
				var sizeMB = sizeKB/1024;
				sizeStr = sizeMB.toFixed(2)+" MB";
			}
			else
			{
				sizeStr = sizeKB.toFixed(2)+" KB";
			}
	 
			this.filename.html(name);
			this.size.html(sizeStr);
		}
		this.setProgress = function(progress)
		{      
			var progressBarWidth =progress*this.progressBar.width()/ 100; 
			this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
			if(parseInt(progress) >= 100)
			{
				this.abort.hide();
			}
		}
		this.setAbort = function(jqxhr)
		{
			var sb = this.statusbar;
			this.abort.click(function()
			{
				jqxhr.abort();
				sb.hide();
			});
		}
	}
	function handleFileUpload(files,obj,folder)
	{
	   for (var i = 0; i < files.length; i++)
	   {
			var fd = new FormData();
			fd.append('file', files[i]);
	 
			var status = new createStatusbar(obj); //Using this we can set progress.
			
			status.setFileNameSize(files[i].name,files[i].size);
			
			sendFileToServer(fd,status,folder);
		}	   
	}
	
	
	
	
	$(document).ready(function()
	{
	
	
	
	$( "#tabs" ).tabs();
	
	
	var updateFiles = function( folder ) {
				
		var tab = "";
		var buttonId = "";
		
		switch ( folder ) {
			case "drawings":
				tab = "#tabs-1";
				buttonId = "#upload-files-1";
				break;
			case "others":
				tab = "#tabs-2";
				buttonId = "#upload-files-2";
				break;
			case "pictures":
				tab = "#tabs-3";
				buttonId = "#upload-files-3";
				break;
			default:
				break;
		}	
	
		
		$.post("retrieve_files_list_2.php?IMO_NUMBER=<?php echo $imo; ?>&dir=\"GENERAL_INFO\"&path=<?php echo $dir_path; ?>&SHIP_NAME=<?php echo $res1_value['SHIP_NAME']; ?>&folder=" + folder, function(data) {

			
			$( tab ).html( data );  // create Button to upload files or show files list
			
			$( buttonId )  // create the button instance to open the File Upload Modal Dialog, inside each tab
				.button()
				.click(function() {
				
				switch ( folder ) {
					case "drawings":
						folderSelector = 1;
						break;
					case "others":
						folderSelector = 2;
						break;
					case "pictures":
						folderSelector = 3;
						break;
					default:
						break;
				}
				
				$( "#dialog-upload" ).dialog( "open" );
			});
			
		});
		
	};
	
	
	updateFiles( "drawings" );
	updateFiles( "others" );	
	updateFiles( "pictures" );
		
	
	
	var obj = $("#dnd-handler");
	obj.on('dragenter', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
		$(this).css('border', '2px solid #FF0000');
	});
	obj.on('dragover', function (e)
	{
		 e.stopPropagation();
		 e.preventDefault();
	});
	obj.on('drop', function (e)
	{
	 
		 $(this).css('border', '2px dotted #0B85A1');
		 e.preventDefault();
		 var files = e.originalEvent.dataTransfer.files;
	 
		 //We need to send dropped files to Server
		 handleFileUpload(files,obj, folderSelector);
		 
	});
	$(document).on('dragenter', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
	});
	$(document).on('dragover', function (e)
	{
	  e.stopPropagation();
	  e.preventDefault();
	  obj.css('border', '2px dotted #0B85A1');
	});
	$(document).on('drop', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
	});


	
	
	$( "#dialog-upload" ).dialog({
		autoOpen: false,
		height: 450,
		width: 615,
		modal: true,
		resizable: false,
		close: function() {
			
			switch( folderSelector ) {
				case 1:
					folder = "drawings";
					break;
				case 2:
					folder = "others";
					break;
				case 3:
					folder = "pictures";
					break;
				default:
					break;
			}
			
			updateFiles( folder );
			
			//folderSelector = 0;
			
			
			// PENDING: clear the list of uploaded files.
			// ...			
		}
	});
	
	
	
	
	$( "#delete-files-1" )
		.button()
		.click(function() {
		
		$.post("page2_1.php", {
								del_2: $( "#del_2" ).val()
								
								},
		function(data){

			if(data.status == '0'){
				
				var currentURL = location.toString();
				var newURL = currentURL.substr(0, currentURL.length - 1) + folderSelector;
				
				location.replace( newURL );				
				location.reload();
			} 

		}, "json");
	});
	

	
	});
	</script>
	
	
	<style>
	#dnd-handler
	{
	border:2px dotted #0B85A1;
	width:570px;
	height:100px;
	color:#92AAB0;
	text-align:center;
	vertical-align:middle;
	padding:10px 10px 10 10px;
	margin-bottom:10px;
	font-size:200%;
	}
	.progressBar {
		width: 145px;
		height: 22px;
		border: 1px solid #ddd;
		border-radius: 5px;
		overflow: hidden;
		display:inline-block;
		margin:0px 10px 5px 5px;
		vertical-align:top;
	}
	 
	.progressBar div {
		height: 100%;
		color: #fff;
		text-align: right;
		line-height: 22px; /* same as #progressBar height if we want text middle aligned */
		width: 0;
		background-color: #0ba1b5; border-radius: 3px;
	}
	.statusbar
	{
		border-top:1px solid #A9CCD1;
		min-height:25px;
		width:570px;
		padding:5px 5px 0px 5px;
		vertical-align:top;
	}
	.statusbar:nth-child(odd){
		background:#EBEFF0;
	}
	.filename
	{
	display:inline-block;
	vertical-align:top;
	width:250px;
	}
	.filesize
	{
	display:inline-block;
	vertical-align:top;
	color:#30693D;
	width:80px;
	margin-left:5px;
	margin-right:5px;
	}
	.abort{
		background-color:#A8352F;
		-moz-border-radius:4px;
		-webkit-border-radius:4px;
		border-radius:4px;display:inline-block;
		color:#fff;
		font-family:arial;font-size:13px;font-weight:normal;
		padding:4px 15px;
		cursor:pointer;
		vertical-align:top
	}
	
	</style>
	
</head>
<body>






<table width="100%" border="0">

	<tr>
		<td width="9%">IMO</td><td width="35%">Ship Name</td>
		
		<td>
			<div align="left">&nbsp;<a href="page0.php"><strong>RETURN TO SEARCH INTERFACE</strong></a></div>
		</td>
	</tr>
	<tr>
		<td><font size="+2"><?php echo $imo; ?></font></td>
		<td>
			<font size="+2"><?php echo $res1_value['SHIP_NAME']; ?></font>
		</td>
		
		<td></td>
	</tr>

</table>




<div id="tabs">
	<ul>	
		<?php		
			for( $j = 2; $j < $index_count; $j++) {
				
				echo( "<li><a href=\"#tabs-".($j-1)."\">". $dir_array[$j] ."</a></li>" );			
			}
		?>
	</ul>
	
	<?php		
		for( $j = 2; $j < $index_count; $j++) {

			echo( "<div id=\"tabs-".($j-1)."\">" );
			
				// ajax data from retrieve_files_list.php goes here
			
			echo( "</div>" );

		}
	?>
	
</div>



<div id="dialog-upload" title="Files Upload">
	<div id="dnd-handler">
		<br/>drop files here...
	</div>
</div>



</body>
</html>

