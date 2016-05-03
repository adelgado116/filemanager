<?php



require_once('Database/MySQL.php');

$db = &new MySQL('localhost', 'root', 'Marine1234', 'hss_db');

$imo = $_REQUEST['IMO_NUMBER'];
$order = $_REQUEST['ORDER_NO'];

$sql = "SELECT SHIP_NAME FROM ships_tbl WHERE IMO_NUMBER='$imo'";

$res1 = $db->query($sql);
$res1_value = $res1->fetch();





$order_dir_path = "../../knowledgebase/$imo/$order";
	
$order_dir = opendir( $order_dir_path );

while ( $entry = readdir( $order_dir ) ) {
	$dir_array[] = $entry;
}

closedir( $order_dir );

$index_count = count( $dir_array );
sort( $dir_array );




?>


<!doctype html>
<html lang="us">
<head>
	<meta charset="utf-8">
	<title>File Manager</title>
	<link href="css/start/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	
	
	<script>
	function sendFileToServer(formData,status)
	{
		var uploadURL ="upload.php"; //Upload URL
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
	 
				//$("#status1").append("File upload Done<br>");        
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
	function handleFileUpload(files,obj)
	{
	   for (var i = 0; i < files.length; i++)
	   {
			var fd = new FormData();
			fd.append('file', files[i]);
	 
			var status = new createStatusbar(obj); //Using this we can set progress.
			status.setFileNameSize(files[i].name,files[i].size);
			sendFileToServer(fd,status);
	 
	   }
	}
	
	
	
	
	$(document).ready(function()
	{
	
	
	$( "#tabs" ).tabs();
	
	var obj = $("#dndhandler");
	obj.on('dragenter', function (e)
	{
		e.stopPropagation();
		e.preventDefault();
		$(this).css('border', '2px solid #0B85A1');
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
		 handleFileUpload(files,obj);
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
	 
	});
	</script>
	
	
	<style>
	#dndhandler
	{
	border:2px dotted #0B85A1;
	width:400px;
	color:#92AAB0;
	text-align:left;vertical-align:middle;
	padding:10px 10px 10 10px;
	margin-bottom:10px;
	font-size:200%;
	}
	.progressBar {
		width: 200px;
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
		width:700px;
		padding:10px 10px 0px 10px;
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
	width:100px;
	margin-left:10px;
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
    <td>
      <p><strong><font color="#000066" size="6">File Manager</font></strong></p>
    </td>
    <td>
      <div align="right">&nbsp;<a href="page0.php"><strong>RETURN TO SEARCH INTERFACE</strong></a></div>
	  
	  <?php
	  
	  if ( strchr( $_SERVER['HTTP_REFERER'], "http://freja/webapps/file_manager/page1.php" ) /*  || ( strchr( $_SERVER['HTTP_REFERER'], "http://odin/webapps/file_manager/upload.php" && show_link == 'true' ) )  */  ) {
	  
	  	?>
	  	<br/>
		<div align="right">&nbsp;<a href="page1.php?IMO_NUMBER=<?php echo $imo; ?>"><strong>RETURN TO SERVICES LIST FOR: <?php echo $res1_value['SHIP_NAME']; ?></strong></a></div>
		<?php
	  }
	  
	  ?>
	  
    </td>
  </tr>
</table>



<table border="0" width="50%">
<tr>
	<td>Ship Name</td><td>IMO</td><td>Service Order</td>
</tr>
<tr>
	<td><font size="+2"><?php echo $res1_value['SHIP_NAME']; ?></font></td>
	<td><font size="+2"><?php echo $imo; ?></font></td>
	<td><font size="+2"><?php echo $order; ?></td>
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

			$dir_array_2 = array();
			$folder = $order_dir_path."/".$dir_array[$j];	

			
			echo( "<div id=\"tabs-".($j-1)."\">" );
	
			echo( "<table width=\"100%\">");
			echo( "<tr bgcolor=\"#5656DD\" style=\"color:#FFFFFF; font-weight: bold\" align=\"center\">" );
			echo( "<th width=\"70%\">Filename</th><th width=\"20%\">Creation Date</th><th width=\"10%\">Actions</th>" );
			echo( "</tr>" );
			
			if (substr("$dir_array[$j]", 0, 1) != ".") { // don't list hidden files
			
				$folder_res = opendir( $folder );
			
				while ( $dir_element = readdir( $folder_res ) ) {			
					$dir_array_2[] = $dir_element;
				}
			
				closedir( $folder_res );
			
				
				#
				#	get date of creation of every file
				#
				$creation_dates = array();
				for ( $i = 2; $i <= sizeof( $dir_array_2 ) - 1; $i++ ) {
		
					$creation_dates[] = date( "d M Y H:i", filemtime( $folder.'/'.$dir_array_2[ $i ] ) );				
				}

				$index_count_2 = count( $dir_array_2 );
				sort( $dir_array_2 );
				
				$bgcol = "#C4E2FF";
				
				for ( $k = 2; $k < $index_count_2; $k++ ) {
	
					echo "<tr bgcolor=\"".$bgcol."\">";
					echo "<td>";
					echo "<img src=\"images/file_icon.png\" /> <a href=\"$folder/$dir_array_2[$k]\" target=\"_blank\">$dir_array_2[$k]</a>";
					echo "</td>";
					echo "<td>";
					echo $creation_dates[$k - 2];
					echo "</td>";
					echo "<td>";
					echo "<a href=\"page2_1.php?IMO_NUMBER=$imo&ORDER_NO=$order&del=$folder/$dir_array_2[$k]\" onclick=\"return confirm('Are you sure you want to delete this file?')\">delete</a>";
					echo "</td>";
					echo "</tr>";
					
					// change the color of every row
					if ($bgcol == "#C4E2FF") { $bgcol = "#E2F1FF"; }
					else if ($bgcol == "#E2F1FF") { $bgcol = "#C4E2FF"; }
				
				}
			}
			
			echo( "</table>" );
			
			echo( "</div>" );
			
		}
	?>
	
</div>


</body>
</html>
