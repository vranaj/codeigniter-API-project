<?php if($this->session->userdata('function') == "manage_sub_menu_functions"){ ?>

<script src="<?php echo base_url("assets/js/jquery-ui.js");?>"></script>
<script src="<?php echo base_url("assets/js/jquery.ui.touch-punch.js");?>"></script>
		
<!-- for data tables -->
<script src="<?php echo base_url("assets/js/dataTables/jquery.dataTables.js");?>"></script>
<script src="<?php echo base_url("assets/js/dataTables/jquery.dataTables.bootstrap.js");?>"></script>
<script src="<?php echo base_url("assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js");?>"></script>
<script src="<?php echo base_url("assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js");?>"></script>		
		
		
		
		
	
<script type="text/javascript">
jQuery(function($){

//to call the sub menu list
get_sub_menu_function_list();

//override dialog's title function to allow for HTML titles
$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	_title: function(title) {
		var $title = this.options.title || '&nbsp;'
		if( ("title_html" in this.options) && this.options.title_html == true )
			title.html($title);
		else title.text($title);
	}
}));
				
$( "#sub_menu_func_add_link" ).on('click', function(e) {
	e.preventDefault();
        clear_add_fields();enable_fields()
        
	$( "#add_sub_menu_func_model" ).removeClass('hide').dialog({
		resizable: true,
		width: '500',
		modal: true,
		title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> Add New Function</h4></div>',
		title_html: true,
		buttons: [
			
			{
				html: "<i class='ace-icon fa fa-reply-all bigger-110'></i>&nbsp; Add",
				"class" : "btn btn-info btn-minier btn_add_sub_menu_func",
				click: function() {
					var func_name = $('#func_name').val();
                                        var sub_menu_id = $('#sub_menu_id').val();
                                        var func_module = $('#func_module').val();
					var is_active = $('#is_active').val();
					
                                        if(func_name == ''){
						swal("Function Name is Required");
						$('#func_name').focus();
                                                
					}else if(sub_menu_id == ''){
						swal("Sub Menu is Required");
						$('#sub_menu_id').focus();
                                                
					}else if(func_module == ''){
						swal("Module is Required");
						$('#func_module').focus();
                                                
					}else{
                                                $('.btn_add_sub_menu_func').prop('disabled',true);
						$.ajax({
							url: '<?php echo site_url('systems/add_sub_menu_functions');?>',
							type : 'post',
							///dataType: 'json',
							data : {func_name:func_name, sub_menu_id:sub_menu_id, func_module:func_module, is_active:is_active},
							success :function(data){
                                                            var response = JSON.parse(data);
                                                            var responce_type = response.response;
                                                            if(responce_type == 0){
                                                                var responce_reason =  response.reason;
                                                                swal("Error!", responce_reason, "error");
                                                                $('.btn_add_sub_menu_func').prop('disabled',false);
                                                            }else if(responce_type == 1){
                                                                swal({
                                                                    title: "Success",
                                                                    text: "",
                                                                    type: "success",
                                                                    confirmButtonClass: "btn-primary",
                                                                    confirmButtonText: "Ok",
                                                                    closeOnConfirm: true
                                                                  },
                                                                  function(){
                                                                    //to clear the input fields
                                                                    clear_add_fields();get_sub_menu_function_list();
                                                                    $( "#add_sub_menu_func_model" ).dialog( "close" );
                                                                    location.reload();
                                                                  });
                                                                
                                                                
                                                            }else{
                                                                swal("Error!", "Unknown network issue", "error");
                                                                $('.btn_add_sub_menu_func').prop('disabled',false);
                                                            }
                                                        },
							error : function(data){
                                                            //check user permission or network 
                                                            swal("Error!", "Failed to add, Please try again", "error");
                                                            $('.btn_add_sub_menu_func').prop('disabled',false);
                                                        }
						});
					}
					
					//$( this ).dialog( "close" );
				}
				
				
			}
			,
			{
				html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
				"class" : "btn btn-minier",
				click: function() {
                                    
                                        //to clear the input fields
                                        clear_add_fields();
					$( this ).dialog( "close" );
				}
			}
		]
	});
});


function view_func(id){
        
        if(id > 0){
            $.ajax({
                url:'<?php echo site_url('systems/view_sub_menu_func_by_id');?>',
                type:'post',
                data:{id:id},
                success:function(data){
                    var data = JSON.parse(data);
                    clear_add_fields();disable_fields();
                    $('#func_name').val(data[0].function_name);
                    $('#sub_menu_id').val(data[0].sub_menu_id);
                    $('#func_module').val(data[0].module_id);
                    $('#is_active').val(data[0].status);

                }
            });
            
            
            $( "#add_sub_menu_func_model" ).removeClass('hide').dialog({
                    resizable: true,
                    width: '500',
                    modal: true,
                    title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> View Function</h4></div>',
                    title_html: true,
                    buttons: [


                            {
                                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                                    "class" : "btn btn-minier",
                                    click: function() {

                                            //to clear the input fields
                                            clear_add_fields();
                                            $( this ).dialog( "close" );
                                    }
                            }
                    ]
            });
        }

	

}


function edit_func(id){
        clear_add_fields();
        enable_fields();
        
        if(id>0){
            $.ajax({
                url:'<?php echo site_url('systems/view_sub_menu_func_by_id');?>',
                type:'post',
                data:{id:id},
                success:function(data){
                    var data = JSON.parse(data);
                    $('#func_name').val(data[0].function_name);
                    $('#sub_menu_id').val(data[0].sub_menu_id);$('#sub_menu_id').prop('disabled',true);
                    $('#func_module').val(data[0].module_id);
                    $('#is_active').val(data[0].status);

                }
            });
            
            
            $( "#add_sub_menu_func_model" ).removeClass('hide').dialog({
                    resizable: true,
                    width: '500',
                    modal: true,
                    title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> Edit Function</h4></div>',
                    title_html: true,
                    buttons: [

                            {
                                    html: "<i class='ace-icon fa fa-reply-all bigger-110'></i>&nbsp; Edit",
                                    "class" : "btn btn-info btn-minier btn_edit_sub_menu_func",
                                    click: function() {
                                            
                                            var func_name = $('#func_name').val();
                                            var sub_menu_id = $('#sub_menu_id').val();
                                            var func_module = $('#func_module').val();
                                            var is_active = $('#is_active').val();
                                            
                                            if(func_name == ''){
                                                    swal("Function Name is Required");
                                                    $('#func_name').focus();

                                            }else if(sub_menu_id == ''){
                                                    swal("Sub Menu is Required");
                                                    $('#sub_menu_id').focus();

                                            }else if(func_module == ''){
						swal("Module is Required");
						$('#func_module').focus();
                                                
                                            }else{
                                                    $('.btn_edit_sub_menu_func').prop('disabled',true);
                                                    
                                                    $.ajax({
                                                            url: '<?php echo site_url('systems/edit_sub_menu_functions');?>',
                                                            type : 'post',
                                                            ///dataType: 'json',
                                                            data : {id:id,func_name:func_name, sub_menu_id:sub_menu_id, func_module:func_module, is_active:is_active},
                                                            success :function(data){
                                                                var response = JSON.parse(data);
                                                                var responce_type = response.response;
                                                                if(responce_type == 0){
                                                                    var responce_reason =  response.reason;
                                                                    swal("Error!", responce_reason, "error");
                                                                    $('.btn_edit_sub_menu_func').prop('disabled',false);
                                                                }else if(responce_type == 1){
                                                                    swal("Success!", responce_reason, "success");

                                                                    //to clear the input fields
                                                                    clear_add_fields();get_sub_menu_function_list();
                                                                    $( "#add_sub_menu_func_model" ).dialog( "close" );
                                                                }else{
                                                                    swal("Error!", "Unknown network issue", "error");
                                                                    $('.btn_edit_sub_menu_func').prop('disabled',false);
                                                                }
                                                            },
                                                            error : function(data){
                                                                //check user permission or network 
                                                                swal("Error!", "Failed to edit, Please try again", "error");
                                                                $('.btn_edit_sub_menu_func').prop('disabled',false);
                                                            }
                                                    });
                                            }

                                            //$( this ).dialog( "close" );
                                    }


                            }
                            ,
                            {
                                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                                    "class" : "btn btn-minier",
                                    click: function() {

                                            //to clear the input fields
                                            clear_add_fields();
                                            $( this ).dialog( "close" );
                                    }
                            }
                    ]
            });
        }
	
}


function remove_func(id){
        clear_add_fields();
        
        if(id>0){
            $.ajax({
                url:'<?php echo site_url('systems/view_sub_menu_func_by_id');?>',
                type:'post',
                data:{id:id},
                success:function(data){
                    var data = JSON.parse(data);
                    $('#func_name').val(data[0].function_name);
                    $('#sub_menu_id').val(data[0].sub_menu_id);
                    $('#func_module').val(data[0].module_id);
                    $('#is_active').val(data[0].status);
                    disable_fields();
                }
            });
            
            
            $( "#add_sub_menu_func_model" ).removeClass('hide').dialog({
                    resizable: true,
                    width: '500',
                    modal: true,
                    title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> Remove Function</h4></div>',
                    title_html: true,
                    buttons: [

                            {
                                    html: "<i class='ace-icon fa fa-reply-all bigger-110'></i>&nbsp; Remove",
                                    "class" : "btn btn-warning btn-minier btn_remove_sub_menu_func",
                                    click: function() {
                                            
                                            
                                            if(id == ''){
                                                    swal("Item is Required");
                                                    $('#func_name').focus();

                                            }else{
                                                    $('.btn_remove_sub_menu_func').prop('disabled',true);
                                                    
                                                    $.ajax({
                                                            url: '<?php echo site_url('systems/remove_sub_menu_functions');?>',
                                                            type : 'post',
                                                            ///dataType: 'json',
                                                            data : {id:id},
                                                            success :function(data){
                                                                var response = JSON.parse(data);
                                                                var responce_type = response.response;
                                                                if(responce_type == 0){
                                                                    var responce_reason =  response.reason;
                                                                    swal("Error!", responce_reason, "error");
                                                                    $('.btn_remove_sub_menu_func').prop('disabled',false);
                                                                }else if(responce_type == 1){
                                                                    swal("Success!", responce_reason, "success");

                                                                    //to clear the input fields
                                                                    enable_fields();clear_add_fields();get_sub_menu_function_list();
                                                                    $( "#add_sub_menu_func_model" ).dialog( "close" );
                                                                }else{
                                                                    swal("Error!", "Unknown network issue", "error");
                                                                    $('.btn_remove_sub_menu_func').prop('disabled',false);
                                                                }
                                                            },
                                                            error : function(data){
                                                                //check user permission or network 
                                                                swal("Error!", "Failed to remove, Function is already assigned", "error");
                                                                $('.btn_remove_sub_menu_func').prop('disabled',false);
                                                            }
                                                    });
                                            }

                                            //$( this ).dialog( "close" );
                                    }


                            }
                            ,
                            {
                                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; Cancel",
                                    "class" : "btn btn-minier",
                                    click: function() {

                                            //to clear the input fields
                                            clear_add_fields();enable_fields();
                                            $( this ).dialog( "close" );
                                    }
                            }
                    ]
            });
        }
	
}

function clear_add_fields(){
    $('#func_name').val('');
    $('#sub_menu_id').val(1);
    $('#func_module').val(1);
    $('#is_active').val(1);
    $('.btn_add_sub_menu_func').prop('disabled',false);
   
}

function enable_fields(){
    $('#func_name').prop('disabled',false);
    $('#sub_menu_id').prop('disabled',false);
    $('#func_module').prop('disabled',false);
    $('#is_active').prop('disabled',false);
}

function disable_fields(){
    $('#func_name').prop('disabled',true);
    $('#sub_menu_id').prop('disabled',true);
    $('#func_module').prop('disabled',true);
    $('#is_active').prop('disabled',true);
}

function get_sub_menu_function_list(){
    
    $.ajax({
        url:'<?php echo site_url('systems/view_sub_menu_functions');?>',
        type:'post',
        data:{},
        success:function(data){
            //console.log(data);
            $("#dynamic-table").dataTable().fnDestroy();
            $('.function_view_table').empty();
            $('.function_view_table').append(JSON.parse(data));
            data_table();
            $('#dynamic-table_filter').addClass('hidden-480');
            
            $('.function_view_table').on('click','.view_func',function(e){
                    e.preventDefault();
                    var val =$(this).attr('value');
                    view_func(val);
            });
            $('.function_view_table').on('click','.edit_func',function(e){
                    e.preventDefault();
                    var val =$(this).attr('value');
                    edit_func(val);
            });
            $('.function_view_table').on('click','.remove_func',function(e){
                    e.preventDefault();
                    var val =$(this).attr('value');
                    remove_func(val);
            });
           
            
        }
    });
}

});
</script>

<script type="text/javascript">
			jQuery(function($) {
				});
                                
                                function data_table(){
                                    //initiate dataTables plugin
                                
				var oTable1 = 
				$('#dynamic-table')
				.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.dataTable( {
                                        "bDestroy":true,
					"bAutoWidth": false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null,null, /*null, null,*/
					  { "bSortable": false }
					],
					"aaSorting": [],
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			    } );
				//oTable1.fnAdjustColumnSizing();
			
			
				//TableTools settings
				TableTools.classes.container = "btn-group btn-overlap";
				TableTools.classes.print = {
					"body": "DTTT_Print",
					"info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
					"message": "tableTools-print-navbar"
				}
			
				//initiate TableTools extension
                                
				var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
					"sSwfPath": "<?php echo base_url("assets/js/dataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf");?>", //in Ace demo ../assets will be replaced by correct assets path
					
					"sRowSelector": "td:not(:last-child)",
					"sRowSelect": "multi",
					"fnRowSelected": function(row) {
						//check checkbox when row is selected
						try { $(row).find('input[type=checkbox]').get(0).checked = true }
						catch(e) {}
					},
					"fnRowDeselected": function(row) {
						//uncheck checkbox
						try { $(row).find('input[type=checkbox]').get(0).checked = false }
						catch(e) {}
					},
			
					"sSelectedClass": "success",
			        "aButtons": [
						{
							"sExtends": "copy",
							"sToolTip": "Copy to clipboard",
							"sButtonClass": "btn btn-white btn-primary btn-bold",
							"sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
							"fnComplete": function() {
								this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
									1500
								);
							}
						},
						
						{
							"sExtends": "csv",
							"sToolTip": "Export to CSV",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
						},
						
						{
							"sExtends": "pdf",
							"sToolTip": "Export to PDF",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
						},
						
						{
							"sExtends": "print",
							"sToolTip": "Print view",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
							
							"sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Available Menus List</small></a></div></div>",
							
							"sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>",
						}
			        ]
			    } );
                            
                            //to clear the existing tool settings
                            $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container').empty());
                            
                            //we put a container before our table and append TableTools element to it
			    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
				
				//also add tooltips to table tools buttons
				//addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
				//so we add tooltips to the "DIV" child after it becomes inserted
				//flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
				setTimeout(function() {
					$(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
						var div = $(this).find('> div');
						if(div.length > 0) div.tooltip({container: 'body'});
						else $(this).tooltip({container: 'body'});
					});
				}, 200);
				
				
				
				//ColVis extension
				var colvis = new $.fn.dataTable.ColVis( oTable1, {
					"buttonText": "<i class='fa fa-search'></i>",
					"aiExclude": [0, 6],
					"bShowAll": true,
					"bRestore": true,
					"sAlign": "right",
					"fnLabel": function(i, title, th) {
						return $(th).text();//remove icons, etc
					}
					
				}); 
				
				//style it
				$(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')
				
				//and append it to our table tools btn-group, also add tooltip
				$(colvis.button())
				.prependTo('.tableTools-container .btn-group')
				.attr('title', 'Show/hide columns').tooltip({container: 'body'});
				
				//and make the list, buttons and checkboxed Ace-like
				$(colvis.dom.collection)
				.addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
				.find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
				.find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');
			
			
				
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) tableTools_obj.fnSelect(row);
						else tableTools_obj.fnDeselect(row);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(!this.checked) tableTools_obj.fnSelect(row);
					else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
				});
				
			
				
				
					$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
                                    
                               
			
                                }
                                
		</script>
<?php } ?><!-- for add button -->
