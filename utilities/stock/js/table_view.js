$(document).ready( function() {
	
    //
    //  INITIAL DECLARATIONS, STATE
    //
    $('#empty-set-message').hide();
    $('#tbl1').hide();
	$('#navigation_controls').hide();

	
    $('#loads_button').button({disabled:true});
    $('#add_to_group_button').button({disabled:true});
    $('#groups_button').button({disabled:true});
	
	
	
	$('#download_button').button({disabled:true});
    
    
    //ajax_update();
	
	//update_table_view("php/get_table_data.php");
	update_table_view("php/get_table.php");
	
	populate_manufacturerSelector();
	
	$('#filterTextBox').focus();
    
    
    $('#dialog_user_settings').dialog({
        closeOnEscape: true,
		resizable: false,
		autoOpen: false,
		height: 240,
		width: 'auto',
		modal: true,
        buttons:{
            "save changes": function() {
                
                promise = $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"php/9046660611286.php",
                    data: {
                        old_password: $("#old_password"),
                        new_password: $("#new_password").val(),
                        new_password_2: $("#new_password_2").val()
                    },
                    cache:false,
                });
            
                promise.done(function(data) {
                    
                });

                promise.fail(function() {				
                    console.log('A failure occurred');                
                    
                });
                
            },
            "close": function() {
				$(this).dialog('close');
			}
        }
    });
    

    
    $('#dialog_ungroup_confirm').dialog({
        title: 'Ungroup Loads',
        closeOnEscape: false,
		resizable: false,
		autoOpen: false,
		height: 'auto',
		width: 'auto',
		modal: true,
        buttons:{
            "yes": function(){
                $(".ui-dialog-buttonpane button:contains('yes')").button("disable");
                $(".ui-dialog-buttonpane button:contains('no')").button("disable");
                
                promise = $.ajax({
                    type:"POST",
                    dataType:"json",
                    url:"php/0395168096.php",
                    data: {
                        loads: $('input:checkbox.tbl1chkbox').filter(':checked').serialize(),
                    },
                    cache:false,
                });

                promise.done(function(data) {
                    if(data.status==1){
                        $('#ungroup_confirmation').html('');
                        $('#ungroup_confirmation').html("<p>Selected Loads have been removed from their Groups.</p>");
                        
                        setTimeout(function(){
                            $('#dialog_ungroup_confirm').dialog('close');
                            $('#ungroup_confirmation').html('');
                            $('#ungroup_confirmation').html("<p>Do you want to ungroup the Selected Loads ?</p>");
                            $(".ui-dialog-buttonpane button:contains('yes')").button("enable");
                            $(".ui-dialog-buttonpane button:contains('no')").button("enable");
                        }, 3000);
                    }
                    
                    
                    //  REFRESH LOADS VIEW USING APPLIED FILTERS
                });

                promise.fail(function() {				
                    //console.log('A failure occurred');
                    
                    
                    $(".ui-dialog-buttonpane button:contains('yes')").button("enable");
                    $(".ui-dialog-buttonpane button:contains('no')").button("enable");
                });
            },
            "no": function() {
				$(this).dialog('close');
			}
        }
    });
    
    
	
    //
    // EVENTS
    //
    $('#select_all_loads').click(function(){
       // get all checkboxes
       var checkBoxes = $('input:checkbox.tbl1chkbox');
       
		// check only checkboxes of available loads
		checkBoxes.each( function(){
			if($(this).prop('disabled')){
			// do nothing
			}else{
				if(($('#select_all_loads').prop('checked')) && (!$(this).prop('checked'))){
				$(this).prop('checked', !$(this).prop('checked'));
				}else{
					if((!$('#select_all_loads').prop('checked')) && ($(this).prop('checked'))) {
						$(this).prop('checked', !$(this).prop('checked'));
					}
				}	
			}
		});
       
       if($('input:checkbox.tbl1chkbox').filter(':checked').length==0){
            
			//$('#loads_button').button({disabled:true});
            //$('#add_to_group_button').button({disabled:true});
            
			$('#ungroup_button').button({disabled:true});
       }else{
            if($('input:checkbox.tbl1chkbox').filter(':checked').length==1){
                
				//$('#loads_button').button({disabled:false});
                //$('#add_to_group_button').button({disabled:false});
                
				$('#ungroup_button').button({disabled:false});
            }else{
                if($('input:checkbox.tbl1chkbox').filter(':checked').length>=1){
                   
				    //$('#loads_button').button({disabled:true});
                    //$('#ungroup_button').button({disabled:false});
                    //$('#add_to_group_button').button({disabled:false});
                    //$('#add_to_group_button').focus();
                }
            }
       }
    });
    
    $('body').on('click', 'input:checkbox.tbl1chkbox', function(){
       if($('input:checkbox.tbl1chkbox').filter(':checked').length==0){
            
			/*
			$('#loads_button').button({disabled:true});
            $('#add_to_group_button').button({disabled:true});
            $('#ungroup_button').button({disabled:true});
            */
       }else{
            if($('input:checkbox.tbl1chkbox').filter(':checked').length==1){
                
				/*
				$('#loads_button').button({disabled:false});
                $('#add_to_group_button').button({disabled:false});
                $('#ungroup_button').button({disabled:false});
                */
            }else{
                if($('input:checkbox.tbl1chkbox').filter(':checked').length>=1){
					
					/*
                    $('#loads_button').button({disabled:true});
                    $('#ungroup_button').button({disabled:false});
                    $('#add_to_group_button').button({disabled:false});
                    $('#add_to_group_button').focus();
                    */
                }
            }
       }
    });
    
    $('#loads_button').button().click(function(){
       if($('input:checkbox.tbl1chkbox').filter(':checked').length==1){  // get the selected load's id from the checkbox
            $('#group_selector_div').hide('fast');
            get_config('load', $('input:checkbox.tbl1chkbox').filter(':checked').val(), false); // get selected load's config, edit view
            $('#automatic_settings_title').text('Automatic Control');  // set title
            $('#config_table_div').show('fast');
            $(".ui-dialog-buttonpane button:contains('store configuration')").button("enable");
            $('#dialog_config_form').dialog('open');  // open dialog
       }
       return false;
    });

    $('#add_to_group_button').button().click(function(){
        populate_group_select();
        $('#group_selector_div').show('fast');
        $('#manual_control_div').hide('fast');
        $('#automatic_settings_title').text('');
        $('#config_table_div').hide('fast');
        $('#dialog_config_form').dialog('open');
        $(".ui-dialog-buttonpane button:contains('store configuration')").button("disable");
        return false;
    });
	
	
	
	
	$('#update_inventory_button').button().click(function(){
		
		$('#update_inventory_button').button({disabled:true});
		
		
		promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:"php/sap_to_mysql_stock_extractor.php",
			data: {},
			cache:false,
		});
	
		promise.done(function(data) {
			alert('total number of records updated/imported was ' + data.records);
			
			$('#update_inventory_button').button({disabled:false});
			
			update_table_view("php/get_table.php");
		});
	
		promise.fail(function() {				
			console.log('A failure occurred');                
			
		});
	});
	
	
	// WILL CREATE A PROPER EXCEL FILE WITH LIST ORDERED BY MANUFACTURER, ITEM NUMBER
	$('#download_button').button().click(function(){
        
		var pageNumber=0;
		
		if(typeof($('#pageSelector').val()) === "string"){
			pageNumber=$('#pageSelector').val();
		}else{
			pageNumber='1';
		}
		
		
		window.open("php/export_items_list.php?page="+pageNumber+"&rowsPerPage="+$('#filterSelectRowsPerPage').val()+"&keyword="+$('#filterTextBox').val()+"&manufacturerId="+$('#filterSelectManufacturer').val(), '_blank');
    });
    
	
	$('#pageSelector').on('change', function(){
		//update_table_view("php/get_table_data.php");
		update_table_view("php/get_table.php");
	});
	
	
	$('#filterTextBox').on('keyup', function(){		
		//update_table_view("php/get_table_by_item.php");
		update_table_view("php/get_table.php");
	});
	
	
	$('#filterSelectManufacturer').on('change', function(){
		//update_table_view("php/get_table_by_manufacturer.php");
		update_table_view("php/get_table.php");
	});
	
	$('#filterSelectRowsPerPage').on('change', function(){
		//update_table_view("php/get_table_by_manufacturer.php");
		update_table_view("php/get_table.php");
	});
    
    
    //
    // FUNCTIONS
    //
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
	
	function populate_manufacturerSelector(){
		promise = $.ajax({
			type:"GET",
			dataType:"json",
			url:"php/get_manufacturers.php",
			cache:false,
		});
		promise.done(function(data){
			$('#filterSelectManufacturer').html('');
            $('#filterSelectManufacturer').append('<option value="0">-- All Manufacturers --</option>');
			$.each( data, function(i,v){
				$('#filterSelectManufacturer').append('<option value="'+v.manufacturerId+'">'+v.manufacturerName+'</option>');
			});
				
		});
		promise.fail(function(){				
			console.log('A failure occurred');
			$('#filterSelectManufacturer').html('<option id="-1">-- no options available --</option>');
		});
	}
	
	
    function ajax_update(){
        $('#ajax-loader').removeClass('not');
        var lu = setInterval(update_table_view, 1000*5);
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
				keyword: $('#filterTextBox').val(),
				manufacturerId: $('#filterSelectManufacturer').val()
			},
			cache:false,
		});
		
		promise.done(function(data) {
			if(data.num_rows==0){                    
				$('#tbl1').hide();
				$('#navigation_controls').hide();
				$('#empty-set-message').show();
				$('#download_button').button({disabled:true});
				$('#loads_button').button({disabled:true});
				$('#add_to_group_button').button({disabled:true});
			}else{
				$('#empty-set-message').hide();
				$('#tbl1').show();
				populate_pageSelector(data.num_rows, pageNumber);
				$('#navigation_controls').show();
				$('#download_button').button({disabled:false});
				
				var group_number='';
				// show table headers
				$('#loads_headers').removeClass('not');
				// clear table contents
				$('#tbl1').find('tr:gt(0)').remove();
				
				$.each( data.table, function(i,v) {
					$('#tbl1 > tbody').append('<tr></tr>');
					
					//console.log(v);  // debug: show loads data
					
					// define
					$('#tbl1 tr:odd').attr('bgcolor', '#C4E2FF');
					$('#tbl1 tr:even').attr('bgcolor', '#E2F1FF');
					
					$("tr").not(':first').hover( function () {
						$(this).css("background","yellow");
					}, function () {
						$(this).css("background","");
					});
					
					// checkbox
					//if(v.load_status=='available'){
						$('#tbl1 tr:last').append('<td><input class="tbl1chkbox" id="'+v.ItemCode+'" name="'+v.ItemCode+'" type="checkbox" value="'+v.ItemCode+'" /></td>');
					//}else{
					//	$('#tbl1 tr:last').append('<td><input class="tbl1chkbox" disabled id="load'+v.load_id+'" name="load'+v.load_id+'" type="checkbox" value="'+v.load_id+'" /></td>');
					//}
					
					$('#tbl1 tr:last').append('<td>'+v.ItemCode+'</td>');
					$('#tbl1 tr:last').append('<td title="'+v.UserText+'">'+v.ItemName+'</td>');
					//$('#tbl1 tr:last').append('<td>'+v.FrgnName+'</td>');
					$('#tbl1 tr:last').append('<td title="'+v.manufacturerName+'">'+v.manufacturerName.slice(0, 24)+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.OnHand+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.IsCommited+'</td>');
					//$('#tbl1 tr:last').append('<td>'+v.OnOrder+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.Price+'</td>');
					$('#tbl1 tr:last').append('<td>'+v.Currency+'</td>');
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