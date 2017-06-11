<?php if($this->session->userdata('function') == "manage_user_rights"){ ?>

<script src="<?php echo base_url("assets/js/jquery-ui.js");?>"></script>
<script src="<?php echo base_url("assets/js/jquery.ui.touch-punch.js");?>"></script>
		
		
		
		
		
	
<script type="text/javascript">
jQuery(function($){

get_all_rights();
//override dialog's title function to allow for HTML titles
$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	_title: function(title) {
		var $title = this.options.title || '&nbsp;'
		if( ("title_html" in this.options) && this.options.title_html == true )
			title.html($title);
		else title.text($title);
	}
}));

get_sub_menu_list();
$('#role_id').change(function(){
    get_sub_menu_list();
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
				
$( "#rights_add_link" ).on('click', function(e) {
    
	e.preventDefault();
        get_sub_menu_list();
	$( "#add_rights_model" ).removeClass('hide').dialog({
		resizable: true,
		width: '80%',
		modal: true,
		title: '<div class="widget-header"><h4 class="maller"><i class="menu-icon fa fa-desktop blue"></i> Edit User Right</h4></div>',
		title_html: true,
		buttons: [
			
			{
				html: "<i class='ace-icon fa fa-reply-all bigger-110'></i>&nbsp; Edit",
				"class" : "btn btn-info btn-minier btn_add_user_right",
				click: function() {
					var role = $('#role_id').val();
                                        var checked_items = [];
                                              //checked_items  = $('.ckeckbox_rights').val();
                                              $('.ckeckbox_rights:checked').each(function() {
                                                    checked_items.push($(this).attr('value'));
                                                });
					
                                        if(role == ''){
						swal("Role is Required");
						$('#role_id').focus();
                                                
					}else if(checked_items.length < 1){
						swal("Select atleast one function to add");
                                                
					}else{
                                                $('.btn_add_user_right').prop('disabled',true);
                                                
                                                start_loading();
                                                
						$.ajax({
							url: '<?php echo site_url('systems/add_user_right');?>',
							type : 'post',
							///dataType: 'json',
							data : {role:role,checked_items:checked_items},
							success :function(data){
                                                            var response = JSON.parse(data);
                                                            var responce_type = response.response;
                                                            if(responce_type == 0){
                                                                var responce_reason =  response.reason;
                                                                swal("Error!", responce_reason, "error");
                                                                $('.btn_add_user_right').prop('disabled',false);
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
                                                                    end_loading();
                                                                    clear_add_fields();
                                                                    get_all_rights();
                                                                    
                                                                    $( "#add_rights_model" ).dialog( "close" );
                                                                  });
                                                                
                                                                
                                                            }else{
                                                                swal("Error!", "Unknown network issue", "error");
                                                                $('.btn_add_user_right').prop('disabled',false);
                                                            }
                                                        },
							error : function(data){
                                                            //check user permission or network 
                                                            swal("Error!", "Failed to add, Please try again", "error");
                                                            $('.btn_add_user_right').prop('disabled',false);
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


function clear_add_fields(){
    $('#role_id').val(2);
    $('.btn_add_user_right').prop('disabled',false);
    end_loading();
   
}
});

function get_sub_menu_list(){
    var role_id = $('#role_id').val();
    var html='';
    var is_exist;
    $.ajax({
        url:'<?php echo site_url('systems/get_assign_submenus_by_ajax');?>',
        type:'post',
        data:{role_id:role_id},
        success:function(data){
            var data = JSON.parse(data);
            var arr = Object.values(data[1]);
            //console.log(data);
            if(data[0].length > 0){
                $.each(data[0],function(index, val){
                    if($.inArray(val.submenu_id, arr) != -1){
                        is_exist = 'checked';
                    }else{
                        is_exist = '';
                    }

                    html = html + '<div class="col-md-4"><label><input name="checked[]" value="'+val.submenu_id+'" class="ace ace-switch ckeckbox_rights" type="checkbox" '+is_exist+'/> <span class="lbl"> &nbsp;&nbsp;'+val.submenu_name+'</span></label></div>';
                });
            }else{
                html = html + '<div class="col-md-5"></div><div class="col-md-3"><label> <span class="lbl"> No Items Found...! </span></label></div><div class="col-md-4"></div>';
            }
            
            
            $('.rights_list').empty();
            $('.rights_list').append(html);
            
        }
    });
}


function get_all_rights(){
    
    $.ajax({
        url:'<?php echo site_url('systems/get_all_rights_by_ajax');?>',
        type:'post',
        data:{},
        success:function(data){
            var data = JSON.parse(data);
            $('#widget').empty();
            $('#widget').append(data);
           
            
        }
    });
}
</script>
<?php } ?><!-- for add button -->
