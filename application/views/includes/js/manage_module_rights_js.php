<?php if($this->session->userdata('function') == "manage_module_rights"){ ?>

<script src="<?php echo base_url("assets/js/jquery-ui.js");?>"></script>
<script src="<?php echo base_url("assets/js/jquery.ui.touch-punch.js");?>"></script>
<script src="<?php echo base_url("assets/js/chosen.jquery.js");?>"></script>
		
		
		
		
		
	
<script type="text/javascript">
jQuery(function($){

get_sub_menu_function_list();
get_sub_menu_list();
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
    get_sub_menu_list();
    get_sub_menu_function_list();
});






function clear_add_fields(){
    $('#user_id').val($('#user_id option:first-child').val());
    $('#submenu_id').val($('#submenu_id option:first-child').val());   
   
}
});

function get_sub_menu_function_list(){
    var sub_menu = $('#submenu_id').val();
    var user_id = $('#user_id').val();
    var html='';
    var is_exist;
    $.ajax({
        url:'<?php echo site_url('perameters/get_all_assign_user_rights_by_ajax');?>',
        type:'post',
        data:{user_id:user_id, sub_menu:sub_menu},
        success:function(data){
            var data = JSON.parse(data);
            //var arr = Object.values(data[1]);
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
            }
            
            
            $('.rights_list').empty();
            $('.rights_list').append(data);*/
    
            $('#widget').empty();
            $('#widget').append(data);
            
            
        }
    });
}


function get_sub_menu_list(){
    var user_id = $('#user_id').val();
    var html;
    
    $.ajax({
        url:'<?php echo site_url('perameters/get_sub_menus_by_ajax');?>',
        type:'post',
        data:{user_id:user_id},
        success:function(data){
            var data = JSON.parse(data);
            html= html + '<option value="">Select the sub menu</option>';
            $.each(data,function(index, val){
                //console.log(val.sub_menu_name);
                html= html + '<option value="'+val.sub_menu_id+'">'+val.sub_menu_name+'</option>';
            });
           
    
            $('#submenu_id').empty().trigger("chosen:updated");
            $('#submenu_id').append(html).trigger("chosen:updated");
            
            
            
        }
    });
}


//to update the rights by modulewise
$('#widget').on('click','.submit_btn', function(){
    var sub_menu = ''; var modules = '';
    sub_menu = $(this).attr('data');
    var user_id = $('#user_id').val();

    var i = 0;
    var comma='';
    $('.module_list_'+sub_menu).each(function(){
        if(i > 0){comma=',';}
        if($(this).is(':disabled')!=true && $(this).is(':checked')==true){
            modules = modules + comma +$(this).attr('data').toString();
            i++;
        }
        
    });
    
    //alert(sub_menu);alert(modules);alert(user_id);
    
    $.ajax({
        url:'<?php echo site_url('perameters/update_module_rights');?>',
        type:'post',
        data:{user_id:user_id,sub_menu:sub_menu, modules:modules},
        success:function(data){
                var response = JSON.parse(data);
                var responce_type = response.response;
                if(responce_type == 0){
                    var responce_reason =  response.reason;
                    swal("Error!", responce_reason, "error");
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
                        //location.reload();
                        get_sub_menu_function_list();
                        get_chosen();
                      });


                }
            },
            error : function(data){
                //check user permission or network 
                swal("Error!", "Failed to add, Please try again", "error");
                get_sub_menu_function_list();
                get_chosen();
            }
            
        
    });
});

//to select all modules of this widget
$('#widget').on('click','.select_all', function(){
    var data = $(this).attr('data');
                
    if($(this).is(':checked') == true){
        
        $('.module_list_'+data).prop('checked',true);
    }else{
        $('.module_list_'+data).prop('checked',false);
    }
});



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


<script>

$(document).ready(function(){
    $('.price').on('click','.select_all',function(){
        //alert('a');
    });
    $('.select_all').click(function(){
        //alert('a');
       var data = $(this).val();
       //alert(data);
});
});
</script>
<?php } ?><!-- for add button -->
