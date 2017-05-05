$(document).ready( function() {
	
    /*
     *	INITIAL DECLARATIONS, STATE
     *
     */
	
    $('#update_coa_button').button({disabled:false});
    $('#add_mef_form_button').button({disabled:true});
    $('#download_mef_report_button').button({disabled:false});

   

    update_table_view("php/get_table.php");

	populate_filterSelect1();
	populate_select1();
	
	
	
    /*
     *	EVENTS
     *
     */
    $('#download_mef_report_button').button().click(function(){
        
				
		window.open("php/report_extractor_2.php?report_year="+$('#report_year').val()+"&mef_form_selector="+$('#select1').val(), '_blank');
    });


    $('#update_coa_button').button().click(function(){

    	$('#update_coa_button').button({disabled:true});

        promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:"php/sapbo_to_mysql_coa_extractor.php",
			data: {},
			cache:false,
		});
	
		promise.done(function(data) {
			alert('total number of records updated/imported was ' + data.records);
			
			$('#update_coa_button').button({disabled:false});
			
		});
	
		promise.fail(function() {				
			console.log('A failure occurred');                
			
		});
    });




     $('#pageSelector').on('change', function(){
		update_table_view("php/get_table.php");
	});
	
	$('#filterTextBox1').on('keyup', function(){		
		update_table_view("php/get_table.php");
	});
		
	$('#filterSelectRowsPerPage').on('change', function(){
		update_table_view("php/get_table.php");
	});




    
    /*
     *	FUNCTIONS
     *
     */
    function populate_filterSelect1() {
    	promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:"php/get_accounts_catalog.php",
			cache:false,
		});
		promise.done(function(data){
			$('#filterSelect1').html('');
            $('#filterSelect1').append('<option value="0">-- select and option --</option>');
			$.each( data, function(i,v){
				$('#filterSelect1').append('<option value="'+v.AcctCode+'">'+v.AcctName+'</option>');
			});
				
		});
		promise.fail(function(){				
			console.log('A failure occurred');
			$('#filterSelect1').html('<option id="-1">-- no options available --</option>');
		});
    }

    function populate_select1() {
    	promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:"php/get_mef_forms_catalog.php",
			cache:false,
		});
		promise.done(function(data){
			$('#select1').html('');
            $('#select1').append('<option value="0">-- select and option --</option>');
			$.each( data, function(i,v){
				$('#select1').append('<option value="'+v.MEF_form_id+'">'+v.MEF_form_number+' - '+v.MEF_form_description+'</option>');
			});
				
		});
		promise.fail(function(){				
			console.log('A failure occurred');
			$('#select1').html('<option id="-1">-- no options available --</option>');
		});
    }





    function populate_pageSelector(recordsTotal, currentPage){
		
		var pagesTotal = Math.ceil( recordsTotal / $('#filterSelectRowsPerPage').val() );
		
		$('#pageSelector').html('');
		
		for(i=1; i<=pagesTotal; i++){
			$('#pageSelector').append('<option value="' + i + '">' + i + '</option>');
		}
		
		// logic to set currently selected option
		$("#pageSelector option").filter(function() {
			//may want to use $.trim in here
			return $(this).text() == currentPage;
		}).prop('selected', true);
	}



    function update_table_view(dataExtractor) {
        
		var cellStyle = '';
		
		//$('#ajax-loader').removeClass('not');
		$('#ajax-loader').addClass('not');
		
		var pageNumber=0;
		
		if(typeof($('#pageSelector').val()) === "string"){
			pageNumber=$('#pageSelector').val();
		}else{
			pageNumber='1';
		}
		
		promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:dataExtractor,
			data:{
				rowsPerPage: $('#filterSelectRowsPerPage').val(),
				page: pageNumber,
				keyword: $('#filterTextBox1').val(),
				filterSelect1ID: $('#filterSelect1').val()
			},
			cache:false,
		});
		
		promise.done(function(data) {
			if(data.num_rows==0){

				$('#tbl1').hide();
				$('#navigation_controls').hide();
				$('#empty-set-message').show();
				
			}else{

				$('#empty-set-message').hide();
				$('#tbl1').show();
				populate_pageSelector(data.num_rows, pageNumber);
				$('#navigation_controls').show();
				
				
				var group_number='';
				// show table headers
				$('#loads_headers').removeClass('not');
				// clear table contents
				$('#tbl1').find('tr:gt(0)').remove();
				
				$.each( data.table, function(i,v) {
					$('#tbl1 > tbody').append('<tr></tr>');
					
					console.log(v);  // debug: show data object's contents
					
					// define
					$('#tbl1 tr:odd').attr('bgcolor', '#C4E2FF');
					$('#tbl1 tr:even').attr('bgcolor', '#E2F1FF');
					
					$("tr").not(':first').hover( function () {
						$(this).css("background","yellow");
					}, function () {
						$(this).css("background","");
					});
					
					
					$('#tbl1 tr:last').append('<td><input class="tbl1chkbox" id="'+v.active+'" name="'+v.active+'" type="checkbox" value="'+v.active+'" /></td>');
					$('#tbl1 tr:last').append('<td>'+v.AcctCode+'</td>');
					$('#tbl1 tr:last').append('<td title="'+v.AcctName+'">'+v.AcctName+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.MEF_form_number+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.MEF_concept_description+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.payment_type+'</td>');
					
				});	
			}
			
			//$('#ajax-loader').addClass('not');
			$('#pacifier').addClass('not');
		});
		
		promise.fail(function() {
			$('#loads_headers').addClass('not');
			$('#loads_list').addClass('not');
			$('#ajax-loader').addClass('not');
			
			console.log('A failure occurred');
			// DISPLAY A MESSAGE TO NOTIFY ABOUT COMMUNICATION/PROCESS FAILURE.
		});        
	}

	
});