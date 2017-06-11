<?php if($this->session->userdata('function') == "manage_functional_rights"){ ?>

<script src="<?php echo base_url("assets/js/jquery-ui.js");?>"></script>
<script src="<?php echo base_url("assets/js/jquery.ui.touch-punch.js");?>"></script>
<script src="<?php echo base_url("assets/js/chosen.jquery.js");?>"></script>
		
		
		
		
		
	
<script type="text/javascript">
jQuery(function($){
    
get_all_func_rights();
get_sub_menu_function_list();
get_chosen();


//override dialog's title function to allow for HTML titles
$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	_title: function(title) {
		var $title = this.options.title || '&nbsp;'
		if( ("title_html" in this.options) && this.options.title_html == true )
			title.html($title);
		else title.text($title);
	}
}));

$('#submenu_id').change(function(){
    get_sub_menu_function_list();
});

$('#user_id').change(function(){
    get_sub_menu_function_list();
});

$('#submenu_id_view').change(function(){
    get_all_func_rights();
});

$('#user_id_view').change(function(){
    get_all_func_rights();
});

function start_loading(){
    $('.wait').css('opacity',1);
    $('.form-horizontal').css('opacity',0.2);
    $("#wait").css("display", "block");
    
}

function end_loading(){
    $('.wait').css('opacity',0);
    $('.form-horizontal').css('opacity',1);
    $("#wait").css("display", "none");
    
}
				
$( "#user_func_rights_link" ).on('click', function(e) {
	e.preventDefault();
        get_sub_menu_function_list();

	$( "#add_func_rights_model" ).removeClass('hide').dialog({
		resizable: true,
		width: '80%',
		modal: true,
		title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> Edit Functional Right</h4></div>',
		title_html: true,
		buttons: [
			
			{
				html: "<i class='ace-icon fa fa-reply-all bigger-110'></i>&nbsp; Edit",
				"class" : "btn btn-info btn-minier btn_add_func_right",
				click: function() {
					var user_id = $('#user_id').val();
                                        var submenu_id = $('#submenu_id').val();
                                        var checked_items = [];
                                              //checked_items  = $('.ckeckbox_rights').val();
                                              $('.ckeckbox_rights:checked').each(function() {
                                                    checked_items.push($(this).attr('value'));
                                                });
                                        
                                        //console.log(checked_items);
                                        
                                        
					
                                        if(user_id == ''){
						swal("User is Required");
						$('#user_id').focus();
                                                
					}else if(submenu_id == ''){
						swal("Submenu is Required");
						$('#submenu_id').focus();
                                                
					}else if(checked_items.length < 1){
						swal("Select atleat one function to add");
                                                
					}else{
                                                $('.btn_add_func_right').prop('disabled',true);
                                                start_loading();
                                                
						$.ajax({
							url: '<?php echo site_url('systems/add_functinal_rights');?>',
							type : 'post',
							///dataType: 'json',
							data : {user_id:user_id, submenu_id:submenu_id, checked_items:checked_items},
							success :function(data){
                                                            var response = JSON.parse(data);
                                                            var responce_type = response.response;
                                                            if(responce_type == 0){
                                                                var responce_reason =  response.reason;
                                                                swal("Error!", responce_reason, "error");
                                                                $('.btn_add_func_right').prop('disabled',false);
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
                                                                    
                                                                    clear_add_fields();
                                                                    get_all_func_rights();
                                                                    end_loading();
                                                                    $( "#add_func_rights_model" ).dialog( "close" );
                                                                    location.reload();
                                                                  });
                                                                
                                                                
                                                            }else{
                                                                swal("Error!", "Unknown network issue", "error");
                                                                $('.btn_add_func_right').prop('disabled',false);
                                                                end_loading();
                                                            }
                                                        },
							error : function(data){
                                                            //check user permission or network 
                                                            swal("Error!", "Failed to add, Please try again", "error");
                                                            $('.btn_add_func_right').prop('disabled',false);
                                                            end_loading();
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
                                        end_loading();
					$( this ).dialog( "close" );
				}
			}
		]
	});
});





function clear_add_fields(){
    $('#user_id').val($('#user_id option:first-child').val());
    $('#submenu_id').val($('#submenu_id option:first-child').val());   
    $('.btn_add_func_right').prop('disabled',false);
    end_loading();
   
}
});

function get_sub_menu_function_list(){
    var sub_menu = $('#submenu_id').val();
    var user_id = $('#user_id').val();
    var html='';
    var is_exist;
    $.ajax({
        url:'<?php echo site_url('systems/get_submenu_functions_by_ajax');?>',
        type:'post',
        data:{user_id:user_id, sub_menu:sub_menu},
        success:function(data){
            var data = JSON.parse(data);
            /*var arr = Object.values(data[1]);*/
            //console.log(arr);
            /*if(data[0].length > 0){
                $.each(data[0],function(index, val){
                    if($.inArray(val.func_id, arr) != -1){
                        is_exist = 'checked';
                    }else{
                        is_exist = '';
                    }

                    html = html + '<div class="col-md-4"><label><input name="checked[]" value="'+val.func_id+'" class="ace ace-switch ckeckbox_rights" type="checkbox" '+is_exist+'/> <span class="lbl"> &nbsp;&nbsp;'+val.func_name+'</span></label></div>';
                });
            }else{
                html = html + '<div class="col-md-5"></div><div class="col-md-3"><label> <span class="lbl"> No Items Found...! </span></label></div><div class="col-md-4"></div>';
            }*/
            
            
            $('.rights_list').empty();
            $('.rights_list').append(data);
        }
    });
}


function get_all_func_rights(){
    
    var user_id = $('#user_id_view').val();
    var sub_menu_id = $('#submenu_id_view').val();
    
    $.ajax({
        url:'<?php echo site_url('systems/get_all_func_rights_by_ajax');?>',
        type:'post',
        data:{user_id:user_id, sub_menu_id:sub_menu_id},
        success:function(data){
            var data = JSON.parse(data);
            $('#widget').empty();
            $('#widget').append(data);
           
            
        }
    });
}


function get_chosen(){
    
        $('.chosen-select').chosen({allow_single_deselect:true}); 
        //resize the chosen on window resize

        $(window)
        .off('resize.chosen')
        .on('resize.chosen', function() {
                $('.chosen-select').each(function() {
                         var $this = $(this);
                         $this.next().css({'width': $this.parent().width()});
                })
        }).trigger('resize.chosen');
        //resize chosen on sidebar collapse/expand
        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                if(event_name != 'sidebar_collapsed') return;
                $('.chosen-select').each(function() {
                         var $this = $(this);
                         $this.next().css({'width': $this.parent().width()});
                })
        });
        
        $('#modal-form').on('shown.bs.modal', function () {
                if(!ace.vars['touch']) {
                        $(this).find('.chosen-container').each(function(){
                                $(this).find('a:first-child').css('width' , '210px');
                                $(this).find('.chosen-drop').css('width' , '210px');
                                $(this).find('.chosen-search input').css('width' , '200px');
                        });
                }
        })
    
}


</script>
<?php } ?><!-- for add button -->
