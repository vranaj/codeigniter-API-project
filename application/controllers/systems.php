<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Systems extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	function __construct(){
		parent::__construct();
		$this->load->model('system');
                $this->load->helper('file');
                
	}
        
        //common ajax functions - Start
        
        //used in : this controller
        function error_responce($reason=''){
            $response_array = array(
                'response' => 0,
                'reason' => $reason
            );
            echo json_encode($response_array);
            exit;
        }
        
        //used in : this controller
        function success_responce($reason=''){
            $response_array = array(
                'response' => 1,
                'reason' => $reason
            );
            echo json_encode($response_array);
            exit;
        }
        
        
        
        
        //used in : 
                    //application\views\includes\js\functional_rights_js.php
        function get_submenu_functions_by_ajax(){
            $submenu_id = $this->input->post('sub_menu');
            $user_id = $this->input->post('user_id');
            
            $data[0] = $this->system->get_sub_menu_functions($submenu_id);
            $data[1] = $this->system->get_given_functional_rights($user_id,$submenu_id);
            
            $html='';
            
            if(count($data[0]) > 0){
                foreach($data[0] as $sub_menu){
                    //var_dump($sub_menu);
                    //var_dump($data[1]);
                    if(in_array($sub_menu['func_id'], $data[1])){
                        $is_exist = 'checked';
                    }else{
                        $is_exist = '';
                    }
                    
                    $html = $html . '<div class="col-md-4"><label><input name="checked[]" value="'.$sub_menu['func_id'].'" class="ace ace-switch ckeckbox_rights" type="checkbox" '.$is_exist.'/> <span class="lbl"> &nbsp;&nbsp;'.$sub_menu['func_name'].'</span></label></div>';
                }
            }else{
                $html = $html.'<div class="col-md-5"></div><div class="col-md-3"><label> <span class="lbl"> No Items Found...! </span></label></div><div class="col-md-4"></div>';
            }
            
            echo json_encode($html);
        }
        
        //used in : 
                    //application\views\includes\js\user_rights_js.php
        function get_assign_submenus_by_ajax(){
            $role_id = $this->input->post('role_id');
            $data[0] = $this->system->get_active_sub_menus();
            $data[1] = $this->system->get_given_rights($role_id);
            echo json_encode($data);
        }
        
        //used in : 
                    //application\views\includes\js\user_rights_js.php
        function get_all_rights_by_ajax(){
            
            $data = $this->system->get_all_given_rights();
            //print_r("<pre>");print_r($data);
            
            $wigdget[0]='red'; $wigdget[1]='orange'; $wigdget[2]='blue'; $wigdget[3]='green'; $wigdget[4]='grey';
            $button[0]='danger'; $button[1]='warning'; $button[2]='primary'; $button[3]='success'; $button[4]='grey';
            $html = '';
            $i=0;
            
            foreach($data as $val){
                $arr_len = $data['length_of_array'];
                $max_len = $data['max_length_of_sub_array'];
                if($i < $arr_len){
                    $rights = $val['rights'];
                    $descriptions='';
                    if(!empty($val)){
                        $descriptions=$val['description'];
                        if(!empty($rights)){

                            $sub_list = '';
                            $j=0;
                            foreach ($rights as $right){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; ">'.$right['name'].'</li>';
                                $j++;
                            }
                            for($j; $j < $max_len; $j++){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; height:33px; " > </li>'; 
                            }
                        }else{
                            $sub_list = '';
                            $j=0;

                            for($j; $j < $max_len; $j++){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; height:33px; "> </li>'; 
                            }
                        }
                    }
                    
                    $index=0;
                        $x=0;
                        
                        if($i > 4){
                            if(($i%5)==0){
                                $index = 0;
                            }else if(($i%5)==1){
                                $index = 1;
                            }else if(($i%5)==2){
                                $index = 2;
                            }else if(($i%5)==3){
                                $index = 3;
                            }else if(($i%5)==4){
                                $index = 4;
                            }
                            
                        }else{
                            $index = $i;
                        }
                        
                        
                        
                        if($i == 0){
                        $html = $html.'<div class="col-md-12">';
                    }
                    
                    $html = $html.'<div class="pricing-span"><div class="widget-box pricing-box-small widget-color-'.$wigdget[$index].'" > <div class="widget-header"> <h5 class="widget-title bigger lighter">'.$descriptions.'</h5> </div> <div class="widget-body"> <div class="widget-main no-padding"> <ul class="list-unstyled list-striped pricing-table"> '.$sub_list.' <li> <i class="ace-icon fa fa-refresh '.$wigdget[$index].'"></i> </li> </ul> <div class="price"> <span class="label label-lg label-inverse arrowed-in arrowed-in-right"> '.count($rights).' <small>/Rights</small> </span> </div> </div> <div> <label class="btn btn-block btn-sm btn-'.$button[$index].'"> <span>User Rights List</span> </label> </div> </div> </div> ';
                    $html = $html.'</div>';
                    
                    if($i > 3 || $i == 3){
                        if((($i+1)%4) == 0){
                            $html = $html.'</div><div class="clearfix"></div><div class="col-md-12">';
                        }
                            
                    }
                    
                }
                
                
                
                
                $i++;
            }
            $html = $html.'<div class="clearfix"></div>';
            
            echo json_encode($html);
        }
        
        //common ajax functions - End
        
        
        
        
	//------------for manage main manus-------------//
	function manage_menus(){
		$this->session->set_userdata('controller', 'systems');
		$this->session->set_userdata('function', 'manage_menus');
		
		$this->template->set();
		$this->template->current_view = 'systems/manage_menus';
		$this->template->render();
	}
	
	function add_menus(){
            
            //declareing the variables
                $menu_name;$controller_name;$icon_name;$display_order;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['menu_name'])){$menu_name = $input_array['menu_name'];}else{$this->error_responce('Menu name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['controller_name'])){$controller_name = $input_array['controller_name'];}else{$this->error_responce('Controller name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['icon_name'])){$icon_name = $input_array['icon_name'];}else{$this->error_responce('Icon name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['display_order'])){$display_order = $input_array['display_order'];}else{$this->error_responce('Display order not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($menu_name!='' && $controller_name!='' && $icon_name!='' && $display_order!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'menu_name' => $menu_name,
                            'controller_name' => $controller_name,
                            'icon_name' => $icon_name,
                            'display_order' => $display_order,
                            'is_active' => $is_active
                            
                        );
                        
                        //for cteare the files for this menu - start
                        $model_name = substr($controller_name, 0, -1);
                        
                        //to create the controller - start
                        $file_data_controller= "<?php defined('BASEPATH') OR exit('No direct script access allowed'); \n\n\n"
                                        . "class ".ucfirst($controller_name)." extends CI_Controller {\n\n"
                                        . " \t "
                                            ."function __construct(){\n"
                                        . " \t\t "
                                                . "parent::__construct();\n"
                                        . " \t\t "
                                                . "$"
                                                ."this->load->model('".$model_name."');\n"
                                        . " \t "
                                        . "}\n\n\n"
                                        ."\t //used in : this controller \n"
                                            . "\t function error_responce($"
                                                ."reason=''){ \n\n"
                                                    . " \t\t $"
                                                    ."response_array = array("
                                                        ."'response' => 0,"
                                                        . "'reason' => $"
                                                                        . "reason "
                                                    . ");  "
                                                    . " \n\t\t echo json_encode($"
                                                    . "response_array); exit; \n\n\t } "
                                        . " \n\n\t //used in : this controller \n "
                                            . " \t function success_responce($"
                                                . "reason=''){ \n\n"
                                                    . " \t\t $"
                                                    . "response_array = array("
                                                        . "'response' => 1,"
                                                        . "'reason' => $"
                                                                        . "reason"
                                                    . ");"
                                                    . " \n\t\t echo json_encode($"
                                                    . "response_array); exit; \n\n\t }"
                                        . "\n\n\n}?>";
                        
                        $file_path_controller = APPPATH.'controllers/'.$controller_name.'.php';
                        //var_dump($file_path_controller);
                        $write_mode = 'w';
                        if(!fopen($file_path_controller, $write_mode)){
                            $this->error_responce('Controller not created, Please retry');
                        }else{
                            $file_controller_is = fopen($file_path_controller, $write_mode);
                            if(!fwrite($file_controller_is, $file_data_controller)){
                                $this->error_responce('Controller data not written correctly, Please retry');
                            }else{
                                mkdir(APPPATH.'views/'.$controller_name, 0777, true);
                                fclose($file_controller_is);
                            }
                        }
                        
                        //to create the controller - end
                        
                        //to create the model - start
                        $file_data_model= "<?php \n\n "
                                        . "class ".ucfirst($model_name)." extends CI_Model {\n\n"
                                        . " \t "
                                            ."function __construct(){\n"
                                        . " \t\t "
                                                . "parent::__construct();\n"
                                        
                                        . " \t }\n\n\n"
                                        . "}?>";
                        
                        $file_path_model = APPPATH.'models/'.$model_name.'.php';
                        //var_dump($file_path_controller);
                        $write_mode = 'w';
                        if(!fopen($file_path_model, $write_mode)){
                            $this->error_responce('Model not created, Please retry');
                        }else{
                            $file_model_is = fopen($file_path_model, $write_mode);
                            if(!fwrite($file_model_is, $file_data_model)){
                                $this->error_responce('Model data not written correctly, Please retry');
                            }else{
                                fclose($file_model_is);
                            }
                        }
                        
                        //to create the model - end
                        
                        //for cteare the files for this menu - end
                        
                        //to add data to table
                        $add_result = $this->system->add_menu_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Menu item added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add menu item, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
//                    $response = array(
//                        'response' => 0,
//                        'reason' => 'No data recieved due to network issue'
//                    );
                    //echo json_encode($response);
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
	function edit_menus(){
		//declareing the variables
                $id;$menu_name;$controller_name;$icon_name;$display_order;$is_active;$old_conrtoller_name;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['menu_name'])){$menu_name = $input_array['menu_name'];}else{$this->error_responce('Menu name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['controller_name'])){$controller_name = $input_array['controller_name'];}else{$this->error_responce('Controller name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['icon_name'])){$icon_name = $input_array['icon_name'];}else{$this->error_responce('Icon name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['display_order'])){$display_order = $input_array['display_order'];}else{$this->error_responce('Display order not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!='' && $menu_name!='' && $controller_name!='' && $icon_name!='' && $display_order!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'menu_name' => $menu_name,
                            'controller_name' => $controller_name,
                            'icon_name' => $icon_name,
                            'display_order' => $display_order,
                            'is_active' => $is_active
                            
                        );
                        
                        
                        $error = 0;//1=empty old controller name,2=old file not found,3=controller word not found,4=can not replaced the text5=data not written
                        $old_conrtoller_name='';$add_result=0;$model_name_new='';$file_path_controller_old='';$file_path_controller_new='';
                        $contents_controller_old='';$contents_controller_new='';
                        
                        //to get the existing data -start
                        $menu_data = $this->system->get_menu_data($id);
                        if(!empty($menu_data)){
                            $old_conrtoller_name = $menu_data[0]['path'];
                        }
                        //to get the existing data -end
                        
                        
                        //to add data to table - start
                        $add_result = $this->system->edit_menu_item($data_array);
                        //to add data to table - end
                        
                        if($add_result == 1 ){
                            
                            //to update the files - start
                                if($old_conrtoller_name != ''){
                                    
                                    //for cteare the files for this menu - start
                                                                                
                                        $file_path_controller_old = APPPATH.'controllers/'.$old_conrtoller_name.'.php';
                                        $file_path_controller_new = APPPATH.'controllers/'.$controller_name.'.php';
                                        
                                        
                                        if(file_exists($file_path_controller_old)){
                                            $contents_controller_old = file_get_contents($file_path_controller_old);
                                            
                                            if(strpos($contents_controller_old, 'class '.ucfirst($old_conrtoller_name)) !== false){
                                                
                                                if($contents_controller_new = str_replace('class '.ucfirst($old_conrtoller_name), 'class '.ucfirst($controller_name), $contents_controller_old)){
                                                   
                                                    rename($file_path_controller_old,$file_path_controller_new);
                                                    
                                                        $write_mode = 'w';
                                            
                                                        $file_controller_is = fopen($file_path_controller_new, $write_mode);
                                                        if(!fwrite($file_controller_is, $contents_controller_new)){
                                                            $error = 5;
                                                            $this->error_responce('Controller data not written correctly, Please retry');
                                                        }else{
                                                            fclose($file_controller_is);
                                                        }
                                                    
                                                }else{
                                                    $error = 4;
                                                    $this->error_responce('Controller name not changed, Please retry');
                                        
                                                }
                                            }else{
                                                $error = 3;
                                                $this->error_responce('The name '.$old_conrtoller_name.' is not found, Please retry');
                                        
                                            }
                                            
                                        }else{
                                            $error = 2;
                                            $this->error_responce('Controller with the file name '.$file_path_controller_old.' not found, Please retry');
                                        }
                                        
                                    }else{
                                        $error = 1;
                                        $this->error_responce('Failed find the file, Please retry');
                                    }
                                    
                                    if($error > 0){
                                        //create data array to add
                                            $data_array = array(
                                                'id'=>$id,
                                                'menu_name' => $menu_data[0]['name'],
                                                'controller_name' => $menu_data[0]['path'],
                                                'icon_name' => $menu_data[0]['icon_name'],
                                                'display_order' => $menu_data[0]['dispaly_order'],
                                                'is_active' => $menu_data[0]['status']

                                            );
                                            //to add data to table - start
                                            $add_result = $this->system->edit_menu_item($data_array);
                                            $this->error_responce('Failed to update the files, Please retry');
                                    }

                            //to update the files - end
                            
                            $this->success_responce('Menu item updated successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to update menu item, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
	function view_menus(){
            $html='';
            $menu_list = $this->system->get_menu_list();
            //var_dump($menu_list);
            
            foreach($menu_list as $menu){
                if($menu['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $menu['name'] .'</td>'
                       . '<td class="hidden-480">'. $menu['path'] .'</td>'
                       . '<td class="hidden-480 center">'. $menu['dispaly_order'] .'</td>'
                       . '<td class="hidden-480 center" ><i class="'. $menu['icon_name'] .' bigger-130 center"></i></td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
            
            
	}
        
        function view_menu_by_id(){
            $id = $this->input->post('id');
            $menu = $this->system->get_menu_by_id($id);
            echo json_encode($menu);
        }
	
	function remove_menus(){
            //declareing the variables
                $id;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id
                        );
                        
                        //to add data to table
                        $add_result = $this->system->romove_menu_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Menu item deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete menu item, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
//                    $response = array(
//                        'response' => 0,
//                        'reason' => 'No data recieved due to network issue'
//                    );
                    //echo json_encode($response);
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
        
        
	//-----------for manage sub manus---------------//
	function manage_sub_menus(){
		$this->session->set_userdata('controller', 'systems');
		$this->session->set_userdata('function', 'manage_sub_menus');
		
                $data['parent_menus'] = $this->system->get_menus();
		$this->template->set($data);
		$this->template->current_view= "systems/manage_sub_menus";
		$this->template->render();
	}
	
	function add_sub_menus(){
            
            //declareing the variables
                $sub_menu_name;$sub_menu_path;$parent_menu;$icon_name;$display_order;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['sub_menu_name'])){$sub_menu_name= $input_array['sub_menu_name'];}else{$this->error_responce('Sub menu name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['sub_menu_path'])){$sub_menu_path= $input_array['sub_menu_path'];}else{$this->error_responce('Sub menu path not recieved due to network issue, Please retry');}
                    if(!empty($input_array['parent_menu'])){$parent_menu= $input_array['parent_menu'];}else{$this->error_responce('Parent menu not recieved due to network issue, Please retry');}
                    if(!empty($input_array['icon_name'])){$icon_name= $input_array['icon_name'];}else{$this->error_responce('Icon name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['display_order'])){$display_order= $input_array['display_order'];}else{$this->error_responce('Display order not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($sub_menu_name!='' && $sub_menu_path!='' && $parent_menu!='' && $icon_name!='' && $display_order!='' && $is_active!=''){
                        
                        $menu_data = $this->system->get_parent_menu_by_id($parent_menu);
                        
                        if(!empty($menu_data)){
                            //create data array to add
                            $data_array = array(
                                'sub_menu_name' => $sub_menu_name,
                                'sub_menu_path' => $menu_data[0]['path'].'/'.$sub_menu_path,
                                'parent_menu' => $parent_menu,
                                'icon_name' => $icon_name,
                                'display_order' => $display_order,
                                'is_active' => $is_active

                            );
                            
                            //$sub_menu_arr = explode('/', $sub_menu_path);
                                $conrtoller_name = $menu_data[0]['path'];
                                $sub_menu_name = $sub_menu_path;
                                $menu_contents = "\t\t//used in : main navigation as a submenu item \n"
                                                    . "\t function ".$sub_menu_name."(){ \n"
                                                        . "\t\t $"
                                                                . "this->session->set_userdata('controller', '".$conrtoller_name."'); \n"
                                                        . "\t\t $"
                                                                . "this->session->set_userdata('function', '".$sub_menu_name."'); \n\n "
                                                        . "\t\t //Enter your contents here \n\n"
                                                        . "\t\t //Enter your contents here \n\n\n"
                                                        . "\t\t $"
                                                                . "this->template->set(); \n"
                                                        . "\t\t $"
                                                                . "this->template->current_view = '".$conrtoller_name."/".$sub_menu_name."'; \n"
                                                        . "\t\t $"
                                                                . "this->template->render(); \n"
                                                        . "\t } \n\n\n"
                                                        . " }?> \n";
                                //to update the files - start
                                        if($conrtoller_name != ''){

                                            //for cteare the files for this menu - start

                                                $file_path_controller = APPPATH.'controllers/'.$conrtoller_name.'.php';


                                                if(file_exists($file_path_controller)){
                                                    $contents_controller_old = file_get_contents($file_path_controller);

                                                    if(strpos($contents_controller_old, '}?>') !== false){

                                                        if($contents_controller_new = str_replace('}?>', $menu_contents, $contents_controller_old)){

                                                                $write_mode = 'w';

                                                                $file_controller_is = fopen($file_path_controller, $write_mode);
                                                                if(!fwrite($file_controller_is, $contents_controller_new)){
                                                                    $error = 5;
                                                                    $this->error_responce('Function data not written correctly, Please retry');
                                                                }else{
                                                                    fclose($file_controller_is);

                                                                    //for new view - start
                                                                    $view_path = APPPATH.'views/'.$conrtoller_name.'/'.$sub_menu_name.'.php';

                                                                    $write_mode = 'w';
                                                                    if(!fopen($view_path, $write_mode)){
                                                                        $this->error_responce('View not created, Please retry');
                                                                    }else{
                                                                        $file_view_is = fopen($view_path, $write_mode);
                                                                        $view_data="<div class=\"row\"> \n"
                                                                                        ."\t <div class=\"col-xs-12\"> \n"
                                                                                                ."\t\t <!-- PAGE CONTENT BEGINS --> \n"
                                                                                                ."\t\t <!-- #section:basics/sidebar.mobile.style2 --> \n"
                                                                                                ."\t\t <div class=\"well1 col-md-12 col-sm-12 col-xs-12\"> \n"
                                                                                                        ."\t\t\t <div class=\"pull-right col-md-9 col-xs-12 col-sm-12\"> \n"
                                                                                                        ."\t\t\t </div> \n"
                                                                                                ."\t\t </div> \n"
                                                                                                ."\t\t <!-- /section:basics/sidebar.mobile.style2 --> \n"
                                                                                                ."\t\t <!-- PAGE CONTENT ENDS -->\n"
                                                                                        ."\t </div><!-- /.col -->\n"
                                                                                ."</div><!-- /.row -->";
                                                                        if(!fwrite($file_view_is, $view_data)){
                                                                            $this->error_responce('View data not written correctly, Please retry');
                                                                        }else{
                                                                            fclose($file_view_is);
                                                                        }


                                                                    }//for new view - end


                                                                    //for new css - start
                                                                    $css_path = APPPATH.'views/includes/css/'.$sub_menu_name.'_css.php';

                                                                    $write_mode = 'w';
                                                                    if(!fopen($css_path, $write_mode)){
                                                                        $this->error_responce('CSS file not created, Please retry');
                                                                    }else{
                                                                        $file_css_is = fopen($css_path, $write_mode);
                                                                        $css_data="<?php if("
                                                                                        ."$"
                                                                                            ."this->session->userdata('function') == \"".$sub_menu_name."\"){ ?> \n\n\n <!-- add the contents here --> \n\n\n <?php } ?>";
                                                                        if(!fwrite($file_css_is, $css_data)){
                                                                            $this->error_responce('View data not written correctly, Please retry');
                                                                        }else{
                                                                            fclose($file_css_is);
                                                                        }


                                                                    }//for new css - end

                                                                    //for new js - start
                                                                    $js_path = APPPATH.'views/includes/js/'.$sub_menu_name.'_js.php';

                                                                    $write_mode = 'w';
                                                                    if(!fopen($js_path, $write_mode)){
                                                                        $this->error_responce('JS file not created, Please retry');
                                                                    }else{
                                                                        $file_js_is = fopen($js_path, $write_mode);
                                                                        $js_data="<?php if("
                                                                                        ."$"
                                                                                            ."this->session->userdata('function') == \"".$sub_menu_name."\"){ ?> \n\n\n <!-- add the contents here --> \n\n\n <?php } ?>";
                                                                        if(!fwrite($file_js_is, $js_data)){
                                                                            $this->error_responce('JS data not written correctly, Please retry');
                                                                        }else{
                                                                            fclose($file_js_is);
                                                                        }


                                                                    }//for new js - end

                                                                    //for add js file psth to main js file - start
                                                                    $js_file_path = "\n <?php $"
                                                                                            . "this->load->view('includes/js/".$sub_menu_name."_js');?>";
                                                                    $main_js_path = APPPATH.'views/layouts/blocks/js.php';

                                                                    if(file_exists($main_js_path)){

                                                                        $handler = fopen($main_js_path, 'a');
                                                                        fwrite($handler, $js_file_path);       
                                                                        fclose($handler);


                                                                    }else{
                                                                        $this->error_responce('Main JS file not found, Please retry');
                                                                    }
                                                                    //for add js file psth to main js file - end

                                                                    //for add css file psth to main css file - start
                                                                    $css_file_path = "\n <?php $"
                                                                                            . "this->load->view('includes/css/".$sub_menu_name."_css');?>";
                                                                    $main_css_path = APPPATH.'views/layouts/blocks/css.php';

                                                                    if(file_exists($main_css_path)){


                                                                        $handle = fopen($main_css_path, 'a');
                                                                        fwrite($handle, $css_file_path);       
                                                                        fclose($handle);


                                                                    }else{
                                                                        $this->error_responce('Main CSS file not found, Please retry');
                                                                    }
                                                                    //for add css file psth to main css file - end

                                                                }

                                                        }else{
                                                            $error = 4;
                                                            $this->error_responce('Function not added, Please retry');

                                                        }
                                                    }else{
                                                        $error = 3;
                                                        $this->error_responce('Function location is not found, Please retry');

                                                    }

                                                }else{
                                                    $error = 2;
                                                    $this->error_responce('Controller with the file name '.$file_path_controller.' not found, Please retry');
                                                }

                                            }else{
                                                $error = 1;
                                                $this->error_responce('Failed find the file, Please retry');
                                            }



                                //to add data to table
                                $add_result = $this->system->add_sub_menu_item($data_array);
                                if($add_result == 1 ){
                                    $this->success_responce('Sub menu item added successfully');
                                }else {
                                    if($add_result == 2 ){
                                        $this->error_responce('Item alresdy exist');
                                    }else if($add_result == 0 ){
                                        $this->error_responce('Failed to add sub menu item, Please retry');
                                    }else{
                                        $this->error_responce('Failed due to unknown issue, Please retry');
                                    }

                                }
                        
                        }else{
                            $this->error_responce('Menu not found, Please retry');
                        }
                        
                        
                        
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
                
            
                
	}
	
	function edit_sub_menus(){
            //declareing the variables
                $id;$sub_menu_name;$sub_menu_path;$parent_menu;$icon_name;$display_order;$is_active;$old_function_name;$error=0;
		$old_controller;
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['sub_menu_name'])){$sub_menu_name= $input_array['sub_menu_name'];}else{$this->error_responce('Sub menu name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['sub_menu_path'])){$sub_menu_path= $input_array['sub_menu_path'];}else{$this->error_responce('Sub menu path not recieved due to network issue, Please retry');}
                    if(!empty($input_array['parent_menu'])){$parent_menu= $input_array['parent_menu'];}else{$this->error_responce('Parent menu not recieved due to network issue, Please retry');}
                    if(!empty($input_array['icon_name'])){$icon_name= $input_array['icon_name'];}else{$this->error_responce('Icon name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['display_order'])){$display_order= $input_array['display_order'];}else{$this->error_responce('Display order not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    if(!empty($input_array['id'])){$id= $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                   
                    //validating input data to add 
                    if($id!='' && $sub_menu_name!='' && $sub_menu_path!='' && $parent_menu!='' && $icon_name!='' && $display_order!='' && $is_active!=''){
                        
                        $menu_data = $this->system->get_parent_menu_by_id($parent_menu);
                                                        
                        $old_function = $this->system->get_sub_menu_by_id($id);
                        if(!empty($old_function)){
                            $path = explode('/', $old_function[0]['path']);
                            $old_controller = $path[0];
                            $old_function_name = $path[1];
                        }
                        
                        if(!empty($menu_data)){
                           //create data array to add
                            $data_array = array(
                                'id'=>$id,
                                'sub_menu_name' => $sub_menu_name,
                                'sub_menu_path' => $old_controller.'/'.$sub_menu_path,
                                'parent_menu' => $parent_menu,
                                'icon_name' => $icon_name,
                                'display_order' => $display_order,
                                'is_active' => $is_active

                            );
                            
                            //to add data to table
                            $add_result = $this->system->edit_sub_menu_item($data_array);
                            if($add_result == 1 ){
                                
                                //to update the files - start
                                //to change the controller function data - start
                                if($old_function_name != ''){
                                    
                                    //for cteare the files for this menu - start
                                                                                
                                        $file_path_controller = APPPATH.'controllers/'.$old_controller.'.php';
                                        
                                        
                                        if(file_exists($file_path_controller)){
                                            $contents_controller_old = file_get_contents($file_path_controller);
                                            
                                            if(strpos($contents_controller_old, 'function '.$old_function_name) !== false){
                                                
                                                if($contents_controller_new = str_replace('function '.$old_function_name, 'function '.$sub_menu_path, $contents_controller_old)){
                                                    
                                                    if(strpos($contents_controller_new, "'".$old_function_name."')") !== false){
                                                        if($contents_controller_new = str_replace("'".$old_function_name."')", "'".$sub_menu_path."')", $contents_controller_new)){
                                                        
                                                            $write_mode = 'w';
                                            
                                                            $file_controller_is = fopen($file_path_controller, $write_mode);
                                                            if(!fwrite($file_controller_is, $contents_controller_new)){
                                                                $error = 5;
                                                                $this->error_responce('Function data not written correctly, Please retry');
                                                            }else{
                                                                fclose($file_controller_is);
                                                            }
                                                        
                                                        }
                                                    }
                                                        
                                                    
                                                }else{
                                                    $error = 4;
                                                    $this->error_responce('Function name not changed, Please retry');
                                        
                                                }
                                            }else{
                                                $error = 3;
                                                $this->error_responce('Function not found, Please retry');
                                        
                                            }
                                            
                                        }else{
                                            $error = 2;
                                            $this->error_responce('Controller not found, Please retry');
                                        }
                                        
                                    }else{
                                        $error = 1;
                                        $this->error_responce('No file data, Please retry');
                                    }//to change the controller function data - end
                                    
                                    
                                    //to change the css file data - start
                                    if($error == 0){
                                                                                                                    
                                        $css_path = APPPATH.'views/includes/css/'.$old_function_name.'_css.php';
                                        
                                        
                                        if(file_exists($css_path)){
                                            $contents_css_old = file_get_contents($css_path);
                                            
                                            if(strpos($contents_css_old, $old_function_name) !== false){
                                                
                                                if($contents_css_new = str_replace($old_function_name, $sub_menu_path, $contents_css_old)){
                                                   
                                                        $write_mode = 'w';
                                            
                                                        $file_css_is = fopen($css_path, $write_mode);
                                                        if(!fwrite($file_css_is, $contents_css_new)){
                                                            $error = 10;
                                                            $this->error_responce('CSS file not written correctly, Please retry');
                                                        }else{
                                                            fclose($file_css_is);
                                                        }
                                                    
                                                }else{
                                                    $error = 9;
                                                    $this->error_responce('CSS function name not changed, Please retry');
                                        
                                                }
                                            }else{
                                                $error = 8;
                                                $this->error_responce('CSS function not found, Please retry');
                                        
                                            }
                                            
                                        }else{
                                            $error = 7;
                                            $this->error_responce('CSS not found, Please retry');
                                        }
                                        
                                    }else{
                                        $error = 6;
                                        $this->error_responce('CSS change not triggered, Please retry');
                                    }//to change the css file data - end
                                    
                                    
                                    //to change the js file data - start
                                    if($error == 0){
                                                                                                                    
                                        $js_path = APPPATH.'views/includes/js/'.$old_function_name.'_js.php';
                                        
                                        
                                        if(file_exists($js_path)){
                                            $contents_js_old = file_get_contents($js_path);
                                            
                                            if(strpos($contents_js_old, $old_function_name) !== false){
                                                
                                                if($contents_js_new = str_replace($old_function_name, $sub_menu_path, $contents_js_old)){
                                                   
                                                        $write_mode = 'w';
                                            
                                                        $file_js_is = fopen($js_path, $write_mode);
                                                        if(!fwrite($file_js_is, $contents_js_new)){
                                                            $error = 15;
                                                            $this->error_responce('JS file not written correctly, Please retry');
                                                        }else{
                                                            fclose($file_js_is);
                                                        }
                                                    
                                                }else{
                                                    $error = 14;
                                                    $this->error_responce('JS function name not changed, Please retry');
                                        
                                                }
                                            }else{
                                                $error = 13;
                                                $this->error_responce('JS function not found, Please retry');
                                        
                                            }
                                            
                                        }else{
                                            $error = 12;
                                            $this->error_responce('JS not found, Please retry');
                                        }
                                        
                                    }else{
                                        $error = 11;
                                        $this->error_responce('JS change not triggered, Please retry');
                                    }//to change the js file data - end
                                    
                                    
                                    
                                    if($error > 0){
                                            //create data array to add
                                            $data_array = array(
                                                'id'=>$id,
                                                'sub_menu_name' => $menu_data[0]['name'],
                                                'sub_menu_path' => $menu_data[0]['path'],
                                                'parent_menu' => $menu_data[0]['menu_id'],
                                                'icon_name' => $menu_data[0]['icon_name'],
                                                'display_order' => $menu_data[0]['display_order'],
                                                'is_active' => $menu_data[0]['status']

                                            );
                                            //to add data to table - start
                                            $add_result = $this->system->edit_menu_item($data_array);
                                            $this->error_responce('Failed to update the files, Please retry');
                                    }

                            //to update the files - end
                                
                                $this->success_responce('Sub Menu item updated successfully');
                            }else {
                                if($add_result == 2 ){
                                    $this->error_responce('Item alresdy exist');
                                }else if($add_result == 0 ){
                                    $this->error_responce('Failed to update sub menu item, Please retry');
                                }else{
                                    $this->error_responce('Failed due to unknown issue, Please retry');
                                }

                            } 
                        }else{
                            $this->error_responce('Menu not found, Please retry');
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
	function view_sub_menus(){
            $html='';
            $sub_menu_list = $this->system->get_sub_menu_list();
            //var_dump($menu_list);
            
            foreach($sub_menu_list as $menu){
                if($menu['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $menu['name'] .'</td>'
                       . '<td class="hidden-480">'. $menu['path'] .'</td>'
                       . '<td class="hidden-480 center">'. $menu['menu_name'] .'</td>'
                       . '<td class="hidden-480 center" >'. $menu['display_order'] .'</td>'
                       . '<td class="hidden-480 center" ><i class="'. $menu['icon_name'] .' bigger-130 center"></i></td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_menu" href="#" value="'. $menu['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_menu" value="'. $menu['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
	}
        
        function view_sub_menu_by_id(){
            $id = $this->input->post('id');
            $menu = $this->system->get_sub_menu_by_id($id);
            echo json_encode($menu);
        }
	
	function remove_sub_menus(){
            //declareing the variables
                $id;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id
                        );
                        
                        //to add data to table
                        $add_result = $this->system->remove_sub_menu_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Sub menu item deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete sub menu item, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
//                    $response = array(
//                        'response' => 0,
//                        'reason' => 'No data recieved due to network issue'
//                    );
                    //echo json_encode($response);
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
        
        
        
	//-----------for manage user roles-------------//
	function manage_user_roles(){
		$this->session->set_userdata('controller', 'systems');
		$this->session->set_userdata('function', 'manage_user_roles');
		
		$this->template->set();
		$this->template->current_view= "systems/manage_user_roles";
		$this->template->render();
	}
	
	function add_user_roles(){
            //declareing the variables
                $role_name;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['role_name'])){$role_name= $input_array['role_name'];}else{$this->error_responce('Role name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($role_name!='' && $is_active!=''){
                        //create data array to add
                        $data_array = array(
                            'role_name' => $role_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->add_user_role($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User role added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add user role, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
                
            
            
	}
	
	function edit_user_roles(){
            //declareing the variables
                $id;$role_name;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['role_name'])){$role_name= $input_array['role_name'];}else{$this->error_responce('Role name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    if(!empty($input_array['id'])){$id= $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                   
                    
                    //validating input data to add 
                    if($id!='' && $role_name!='' && $is_active!=''){
                        //create data array to add
                        $data_array = array(
                            'id' => $id,
                            'role_name' => $role_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->edit_user_role($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User role updated successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add user role, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
	
	function view_user_roles(){
            $html='';
            $user_roles_list = $this->system->get_user_roles_list();
            //var_dump($user_roles_list);
            
            foreach($user_roles_list as $roles){
                if($roles['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $roles['role_name'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_role" href="#" value="'. $roles['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_role" href="#" value="'. $roles['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_role" href="#" value="'. $roles['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_role" value="'. $roles['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_role" value="'. $roles['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_role" value="'. $roles['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
	}
        
        function view_role_by_id(){
            $id = $this->input->post('id');
            $role = $this->system->get_user_role_by_id($id);
            echo json_encode($role);
        }
	
	function remove_user_roles(){
            //declareing the variables
                $id;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id
                        );
                        
                        //to add data to table
                        $add_result = $this->system->remove_role_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Role item deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete role item, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
        
        
	
        
        //---------------for manage user rights--------------------//
        function manage_user_rights(){
            $this->session->set_userdata('controller', 'systems');
            $this->session->set_userdata('function', 'manage_user_rights');
            
            
            $data['user_roles'] = $this->system->get_user_roles();
            $data['sub_menus'] = $this->system->get_sub_menus();
            
            $this->template->set($data);
            $this->template->current_view =  'systems/manage_user_rights';
            $this->template->render();
        }
        
        function add_user_right(){
            //declareing the variables
                $role;$sub_menu;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['role'])){$role= $input_array['role'];}else{$this->error_responce('Role not recieved due to network issue, Please retry');}
                    if(!empty($input_array['checked_items'])){$checked_items= $input_array['checked_items'];}else{$this->error_responce('Selected item list not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($role!='' && !empty($checked_items)){
                        //create data array to add
                        $data_array = array(
                            'role_id' => $role,
                            'checked_items' => $checked_items
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->add_user_right($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User right added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add user right, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
                 
        }
        
        
        
        
	//-------------for manage module-------------------//
	function manage_module(){
		$this->session->set_userdata('controller', 'systems');
		$this->session->set_userdata('function', 'manage_module');
		
		$this->template->set();
		$this->template->current_view = 'systems/manage_module';
		$this->template->render();
	}
	
	function add_modules(){
	
                //declareing the variables
                $module_name;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['module_name'])){$module_name= $input_array['module_name'];}else{$this->error_responce('Module name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($module_name!='' && $is_active!=''){
                        //create data array to add
                        $data_array = array(
                            'module_name' => $module_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->add_module($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Module added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add the module, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
		
	}
        
        function view_modules(){
            $html='';
            $modules_list = $this->system->get_modules_list();
            //var_dump($menu_list);
            
            foreach($modules_list as $module){
                if($module['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $module['description'] .'</td>'
                       . '<td class="center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_module" href="#" value="'. $module['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_module" href="#" value="'. $module['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_module" href="#" value="'. $module['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_module" value="'. $module['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_module" value="'. $module['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_module" value="'. $module['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
        }
	
	function view_modules_by_id(){
            $id = $this->input->post('id');
            $role = $this->system->get_module_by_id($id);
            echo json_encode($role);
	}
        
        function edit_modules(){
            //declareing the variables
                $id;$module_name;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['module_name'])){$module_name= $input_array['module_name'];}else{$this->error_responce('Module name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    if(!empty($input_array['id'])){$id= $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                   
                    
                    //validating input data to add 
                    if($id !='' && $module_name!='' && $is_active!=''){
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'module_name' => $module_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->edit_module($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Module editrd successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to edit user right, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
        }
        
        function remove_modules(){
            //declareing the variables
                $id;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!=''){
                        
                        //create data array to add
                        $remove_array = array(
                            'id'=>$id
                        );
                        
                        //to add data to table
                        $add_result = $this->system->remove_module($remove_array);
                        if($add_result == 1 ){
                            $this->success_responce('Module deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the module, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
	}
        
	
	function view_users(){
		$this->template->set();
		$this->temlate->current_view = "home";
		$this->template->render();
	}
	
	function remove_users(){
	
            $this->template->set();
            $this->template->current_view = 'home';  //Set Current view	
            //Load the index view
            $this->template->render();
		
	}
        
        
        
        
        
        //-----------------for manage submenu related functions----------------//
        function manage_sub_menu_functions(){
            $this->session->set_userdata('controller', 'systems');
            $this->session->set_userdata('function', 'manage_sub_menu_functions');
            
            $data['sub_menus'] = $this->system->get_sub_menus();
            $data['modules'] = $this->system->get_modules();
            
            $this->template->set($data);
            $this->template->current_view = 'systems/manage_sub_menu_functions';
            $this->template->render();
        }
        
        function add_sub_menu_functions(){
            //declareing the variables
                $func_name;$sub_menu_id;$func_module;$is_active;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['func_name'])){$func_name= $input_array['func_name'];}else{$this->error_responce('Function name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['sub_menu_id'])){$sub_menu_id= $input_array['sub_menu_id'];}else{$this->error_responce('Sub menu not recieved due to network issue, Please retry');}
                    if(!empty($input_array['func_module'])){$func_module= $input_array['func_module'];}else{$this->error_responce('Module not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($func_name!='' && $sub_menu_id!='' && $func_module!='' && $is_active!=''){
                        //create data array to add
                        $data_array = array(
                            'func_name' => $func_name,
                            'sub_menu_id'  => $sub_menu_id,
                            'func_module' => $func_module,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->add_sub_menu_function($data_array);
                        if($add_result == 1 ){
                            
                            $submenu_data = $this->system->get_sub_menu_by_id($sub_menu_id);
                            if(!empty($submenu_data)){
                                //to update the files - start
                                
                                $path = explode('/', $submenu_data[0]['path']);
                                $controller_name = $path[0];
                                $submenu_function = $path[1];
                                
                                $menu_contents = "\t\t////used in : ////application/views/includes/js/ ".$submenu_function."_js.php \n"
                                                    . "\t function ".$func_name."(){ \n"
                                                        . "\t\t //Enter your contents here \n\n"
                                                        . "\t\t //Enter your contents here \n\n\n"
                                                        . "\t } \n\n\n"
                                                        . " }?> \n";
                                
                                
                                if($controller_name != ''){
                                    $file_path_controller = APPPATH.'controllers/'.$controller_name.'.php';
                                    
                                    if(file_exists($file_path_controller)){
                                        $contents_controller_old = file_get_contents($file_path_controller);
                                        
                                        if(strpos($contents_controller_old, '}?>') !== false){

                                            if($contents_controller_new = str_replace('}?>', $menu_contents, $contents_controller_old)){
                                                $write_mode = 'w';

                                                $file_controller_is = fopen($file_path_controller, $write_mode);
                                                if(!fwrite($file_controller_is, $contents_controller_new)){
                                                    $this->error_responce('Function data not written correctly, Please retry');
                                                }else{
                                                    fclose($file_controller_is);
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                //to update the files - start
                            }
                            
                            $this->success_responce('Sub menu function added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add user right, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
            
        }
        
        function edit_sub_menu_functions(){
            //declareing the variables
                $id;$func_name;$sub_menu_id;$func_module;$is_active;$old_function_data;$submenu_data;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['func_name'])){$func_name= $input_array['func_name'];}else{$this->error_responce('Function name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['sub_menu_id'])){$sub_menu_id= $input_array['sub_menu_id'];}else{$this->error_responce('Sub menu not recieved due to network issue, Please retry');}
                    if(!empty($input_array['func_module'])){$func_module= $input_array['func_module'];}else{$this->error_responce('Module not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    if(!empty($input_array['id'])){$id= $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                   
                    
                    //validating input data to add 
                    if($id !='' && $func_name!='' && $sub_menu_id!='' && $func_module!='' && $is_active!=''){
                        
                        $old_function_data = $this->system->get_sub_menu_func_by_id($id);
                        $submenu_data = $this->system->get_sub_menu_by_id($sub_menu_id);
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'func_name' => $func_name,
                            'sub_menu_id'  => $sub_menu_id,
                            'func_module' => $func_module,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->system->edit_sub_menu_function($data_array);
                        if($add_result == 1 ){
                            
                            if(!empty($submenu_data)){
                                //to update the files - start
                                
                                $path = explode('/', $submenu_data[0]['path']);
                                $controller_name = $path[0];
                                $old_function = $old_function_data[0]['function_name'];
                                
                                $file_path_controller = APPPATH.'controllers/'.$controller_name.'.php';
                                
                                if(file_exists($file_path_controller)){
                                    $contents_controller_old = file_get_contents($file_path_controller);
                                            
                                        if(strpos($contents_controller_old, 'function '.$old_function) !== false){

                                            if($contents_controller_new = str_replace('function '.$old_function, 'function '.$func_name, $contents_controller_old)){

                                                    $write_mode = 'w';

                                                    $file_controller_is = fopen($file_path_controller, $write_mode);
                                                    if(!fwrite($file_controller_is, $contents_controller_new)){
                                                        $this->error_responce('Function data not written correctly, Please retry');
                                                    }else{
                                                        fclose($file_controller_is);
                                                    }

                                            }else{
                                                $this->error_responce('Function name not changed, Please retry');

                                            }
                                        }else{
                                            $this->error_responce('Function not found, Please retry');

                                        }
                                            
                                    }else{
                                        $this->error_responce('Controller not found, Please retry');
                                    }
                                
                                
                                //to update the files - start
                            }
                            $this->success_responce('Sub menu function editrd successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to edit user right, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
        }
        
        function view_sub_menu_functions(){
            $html='';
            $sub_menu_function_list = $this->system->get_sub_menu_function_list();
            //var_dump($menu_list);
            
            foreach($sub_menu_function_list as $function){
                if($function['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $function['function_name'] .'</td>'
                       . '<td class="hidden-480">'. $function['sub_menu_name'] .'</td>'
                       . '<td class="hidden-480">'. $function['module'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_func" href="#" value="'. $function['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_func" href="#" value="'. $function['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_func" href="#" value="'. $function['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_func" value="'. $function['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_func" value="'. $function['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_func" value="'. $function['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
        }
        
        function view_sub_menu_func_by_id(){
            $id = $this->input->post('id');
            $role = $this->system->get_sub_menu_func_by_id($id);
            echo json_encode($role);
        }
        
        function remove_sub_menu_functions(){
            //declareing the variables
                $id;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                //var_dump($input_array);
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id
                        );
                        
                        //to add data to table
                        $add_result = $this->system->remove_sub_menu_function($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Function deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the function, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                    
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
        }
        
        
        
        
        
        
        
        //--------------for manage sub menu functional rights----------------//
        function manage_functional_rights(){
            $this->session->set_userdata('controller', 'systems');
            $this->session->set_userdata('function', 'manage_functional_rights');
            
            $data['users'] = $this->system->get_users();
            $data['sub_menus'] = $this->system->get_sub_menus();
            
            $this->template->set($data);
            $this->template->current_view = 'systems/manage_functional_rights';
            $this->template->render();
        }
        
        function add_functinal_rights(){
             //declareing the variables
                $user_id;$submenu_id;$checked_items;
                
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
                
            //validating input array 
                if(!empty($input_array)){
                    //validating input by each items
                    if(!empty($input_array['user_id'])){$user_id= $input_array['user_id'];}else{$this->error_responce('User name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['submenu_id'])){$submenu_id= $input_array['submenu_id'];}else{$this->error_responce('Sub menu name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['checked_items'])){$checked_items= $input_array['checked_items'];}else{$this->error_responce('Selected item list not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($user_id!='' && $input_array!='' && !empty($checked_items)){
                        //create data array to add
                        $data_array = array(
                            'user_id' => $user_id,
                            'submenu_id'  => $submenu_id,
                            'checked_items' => $checked_items
                            
                        );
                        
                        
                        //to add data to table
                        $add_result = $this->system->add_functional_right($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Functional Right added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add user right, Please retry');
                            }else{
                                $this->error_responce('Failed due to unknown issue, Please retry');
                            }
                            
                        }
                        
                    }else{
                        $this->error_responce('Internal server error, Please retry');
                    }
                }else{
                    $this->error_responce('No data recieved due to network issue, Please retry');
                }
        }
        
        
        function get_all_func_rights_by_ajax(){
            $submenu_id = $this->input->post('sub_menu_id');
            $user_id = $this->input->post('user_id');
            
            
            
            
            $data = $this->system->get_all_given_func_rights($user_id, $submenu_id);
            //print_r("<pre>");print_r($data);die;
            
            $wigdget[0]='red'; $wigdget[1]='orange'; $wigdget[2]='blue'; $wigdget[3]='green'; $wigdget[4]='grey';
            $button[0]='danger'; $button[1]='warning'; $button[2]='primary'; $button[3]='success'; $button[4]='grey';
            $html = '';
            $i=0;
            
            foreach($data as $val){
                $arr_len = $data['length_of_array'];
                $max_len = $data['max_length_of_rights_array'];
                if($i < $arr_len){
                    $rights = $val['rights'];
                    $sub_menu='';
                    if(!empty($val)){
                        $sub_menu=$val['sbm_name'];
                        if(!empty($rights)){

                            $sub_list = '';
                            $j=0;
                            foreach ($rights as $right){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; ">'.$right['function_name'].'</li>';
                                $j++;
                            }
                            for($j; $j < $max_len; $j++){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; height:33px; " > </li>'; 
                            }
                        }else{
                            $sub_list = '';
                            $j=0;

                            for($j; $j < $max_len; $j++){
                                $sub_list = $sub_list.'<li style="word-wrap:break-word; height:33px; "> </li>'; 
                            }
                        }
                    }
                    
                    
                        $ind=0;
                        $x=0;
                        
                        if($i > 4){
                            if(($i%5)==0){
                                $ind = 0;
                            }else if(($i%5)==1){
                                $ind = 1;
                            }else if(($i%5)==2){
                                $ind = 2;
                            }else if(($i%5)==3){
                                $ind = 3;
                            }else if(($i%5)==4){
                                $ind = 4;
                            }
                            
                        }else{
                            $ind = $i;
                        }
                        
                    
                    if($i == 0){
                        $html = $html.'<div class="col-md-12">';
                    }
                    $html = $html.'<div class="pricing-span">'
                                 . '<div class="widget-box pricing-box-small widget-color-'.$wigdget[$ind].'" > '
                                    . '<div class="widget-header"> '
                                       . '<h5 class="widget-title bigger lighter">'.$sub_menu.'</h5> '
                                    . '</div> <div class="widget-body"> '
                                    . '<div class="widget-main no-padding"> '
                                        . '<ul class="list-unstyled list-striped pricing-table"> '.$sub_list.' '
                                            . '<li> <i class="ace-icon fa fa-refresh '.$wigdget[$ind].'"></i> '
                                            . '</li> </ul> <div class="price"> '
                                                . '<span class="label label-lg label-inverse arrowed-in arrowed-in-right"> '.count($rights).' <small>/Rights</small> </span> '
                                    . '</div> </div> <div> <label class="btn btn-block btn-sm btn-'.$button[$ind].'"> <span>Functional Rights</span> </label> </div> </div> </div> ';
                    $html = $html.'</div>';
                    if($i > 3 || $i == 3){
                        if((($i+1)%4) == 0){
                            $html = $html.'</div><div class="clearfix"></div><div class="col-md-12">';
                        }
                            
                    }
                    
                    
                }
                
                
                
                
                $i++;
            }
            $html = $html.'<div class="clearfix"></div>';
            
            echo json_encode($html);
        }
        
        
        
        
}
