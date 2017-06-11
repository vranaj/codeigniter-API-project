<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perameters extends CI_Controller {

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
		$this->load->model('perameter');
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
        
            //common ajax functions - end


            //--------------for manage cost centers-----------------//--start//

            //used in : 
                        //main navigation as a submenu item 
	function manage_cost_centers(){
		$this->session->set_userdata('controller', 'perameters');
		$this->session->set_userdata('function', 'manage_cost_centers');
		
		$this->template->set();
		$this->template->current_view = 'perameters/manage_cost_centers';
		$this->template->render();
	}
        
            //used in : 
                        ////application\views\includes\js\manage_cost_centers_js.php
        function add_cost_centres(){
            //declareing the variables
                $cost_centres_code;$cost_centres_name;$cost_centres_address;$is_dispatch_to;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['cost_centres_code'])){$cost_centres_code = $input_array['cost_centres_code'];}else{$this->error_responce('Cost centre code not recieved due to network issue, Please retry');}
                    if(!empty($input_array['cost_centres_name'])){$cost_centres_name = $input_array['cost_centres_name'];}else{$this->error_responce('Cost centre name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['cost_centres_address'])){$cost_centres_address = $input_array['cost_centres_address'];}else{$this->error_responce('Cost centre address not recieved due to network issue, Please retry');}
                    if($input_array['is_dispatch_to'] == 0 || $input_array['is_dispatch_to'] == 1){$is_dispatch_to = $input_array['is_dispatch_to'];}else{$this->error_responce('Is dispatched field not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($cost_centres_code!='' && $cost_centres_name!='' && $cost_centres_address!='' && $is_dispatch_to!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'cost_centres_code' => $cost_centres_code,
                            'cost_centres_name' => $cost_centres_name,
                            'cost_centres_address' => $cost_centres_address,
                            'is_dispatch_to' => $is_dispatch_to,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->add_cost_centres_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Cost centre item added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add cost centre item, Please retry');
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
        
            //used in : 
                        ////application\views\includes\js\manage_cost_centers_js.php
        function view_cost_centre(){
            $html='';
            $cost_centres_list = $this->perameter->get_cost_centres_list();
            //var_dump($menu_list);
            
            foreach($cost_centres_list as $cost_centre){
                if($cost_centre['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td>'. $cost_centre['code'] .'</td>'
                       . '<td class="">'. $cost_centre['description'] .'</td>'
                       . '<td class="hidden-480">'. $cost_centre['address'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_cost_centre" href="#" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_cost_centre" href="#" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_cost_centre" href="#" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_cost_centre" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_cost_centre" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_cost_centre" value="'. $cost_centre['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
        }
        
            //used in : 
                        ////application\views\includes\js\manage_cost_centers_js.php
        function view_cost_centres_by_id(){
            $id = $this->input->post('id');
            $cost_centre = $this->perameter->view_cost_centre_by_id($id);
            echo json_encode($cost_centre);
        }
        
            //used in : 
                        ////application\views\includes\js\manage_cost_centers_js.php
        function edit_cost_centre(){
            //declareing the variables
                $id;$cost_centres_code;$cost_centres_name;$cost_centres_address;$is_dispatch_to;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    if(!empty($input_array['cost_centres_code'])){$cost_centres_code = $input_array['cost_centres_code'];}else{$this->error_responce('Cost centre code not recieved due to network issue, Please retry');}
                    if(!empty($input_array['cost_centres_name'])){$cost_centres_name = $input_array['cost_centres_name'];}else{$this->error_responce('Cost centre name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['cost_centres_address'])){$cost_centres_address = $input_array['cost_centres_address'];}else{$this->error_responce('Cost centre address not recieved due to network issue, Please retry');}
                    if($input_array['is_dispatch_to'] == 0 || $input_array['is_dispatch_to'] == 1){$is_dispatch_to = $input_array['is_dispatch_to'];}else{$this->error_responce('Is dispatched field not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!='' && $cost_centres_code!='' && $cost_centres_name!='' && $cost_centres_address!='' && $is_dispatch_to!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'cost_centres_code' => $cost_centres_code,
                            'cost_centres_name' => $cost_centres_name,
                            'cost_centres_address' => $cost_centres_address,
                            'is_dispatch_to' => $is_dispatch_to,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->edit_cost_centres_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Cost centre item updated successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to update cost centre item, Please retry');
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
        
            //used in : 
                        ////application\views\includes\js\manage_cost_centers_js.php
        function remove_cost_centre(){
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
                        $add_result = $this->perameter->romove_cost_centre($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Cost centre deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the cost centre, Please retry');
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
        }//--------------for manage cost centers-----------------//--end//
        
        
            //------------------for manage designations--------------------//--srart//

            //used in : 
                        ////main navigation list as a sub menu item
	function manage_designations(){
		$this->session->set_userdata('controller', 'perameters');
		$this->session->set_userdata('function', 'manage_designations');
		
		$this->template->set();
		$this->template->current_view = 'perameters/manage_designations';
		$this->template->render();
	}
        
            //used in : 
                        ////application\views\includes\js\manage_designations_js.php
        function add_designation(){
            //declareing the variables
                $designation;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['designation'])){$designation = $input_array['designation'];}else{$this->error_responce('Designation not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($designation!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'designation' => $designation,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->add_designation_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Designation added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add the designation, Please retry');
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
        
            //used in : 
                        ////application\views\includes\js\manage_designations_js.php
        function view_designation(){
            $html='';
            $designation_list = $this->perameter->get_designation_list();
            //var_dump($menu_list);
            
            foreach($designation_list as $designation){
                if($designation['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td class="">'. $designation['description'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_designation" href="#" value="'. $designation['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_designation" href="#" value="'. $designation['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_designation" href="#" value="'. $designation['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_designation" value="'. $designation['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_designation" value="'. $designation['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_designation" value="'. $designation['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
        }
        
            //used in : 
                        ////application\views\includes\js\manage_designations_js.php
        function view_designation_by_id(){
            $id = $this->input->post('id');
            $designation = $this->perameter->view_designation_by_id($id);
            echo json_encode($designation);
        }
        
            //used in : 
                        ////application\views\includes\js\manage_designations_js.php
        function edit_designation(){
            //declareing the variables
                $id;$designation;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    if(!empty($input_array['designation'])){$designation = $input_array['designation'];}else{$this->error_responce('Designation not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($id!='' && $designation!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'designation' => $designation,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->edit_designation_item($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Designation updated successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Item alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to update the designation, Please retry');
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
        
            //used in : 
                        ////application\views\includes\js\manage_designations_js.php
        function remove_designation(){
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
                        $add_result = $this->perameter->romove_designation($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Designation deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the designation, Please retry');
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
        }//------------------for manage designations--------------------//--end//
        
            //--------------for manage users------------------//----start//

            //used in : 
                        ////used in main navigation as a submenu item
        function manage_users(){
		$this->session->set_userdata('controller', 'perameters');
		$this->session->set_userdata('function', 'manage_users');
                
                $data['users_list'] = $this->perameter->get_users_for_dropdown();
                $data['costcentre'] = $this->perameter->get_costcentre_for_dropdown();
                $data['designation'] = $this->perameter->get_designation_for_dropdown();
                $data['departments'] = $this->perameter->get_departments_for_dropdown();
                $data['roles'] = $this->perameter->get_roles();
		
		$this->template->set($data);
		$this->template->current_view = 'perameters/manage_user';
		$this->template->render();
	}
	
            //used in : 
                ////application\views\includes\js\manage_user_js.php
	function add_users(){
	
            //declareing the variables
                $user_id;$user_name;$user_password;$user_email;$costcentre;$designation;$supervisor;$is_active;$department;$user_role;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['user_id'])){$user_id = $input_array['user_id'];}else{$this->error_responce('User ID not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_name'])){$user_name = $input_array['user_name'];}else{$this->error_responce('User name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_password'])){$user_password = $input_array['user_password'];}else{$this->error_responce('Password not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_email'])){$user_email = $input_array['user_email'];}else{$this->error_responce('E-Mail not recieved due to network issue, Please retry');}
                    if(!empty($input_array['costcentre'])){$costcentre = $input_array['costcentre'];}else{$this->error_responce('Costcentre not recieved due to network issue, Please retry');}
                    if(!empty($input_array['designation'])){$designation = $input_array['designation'];}else{$this->error_responce('Designation not recieved due to network issue, Please retry');}
                    if(!empty($input_array['supervisor'])){$supervisor = $input_array['supervisor'];}else{$this->error_responce('Supervisor not recieved due to network issue, Please retry');}
                    if(!empty($input_array['department'])){$department = $input_array['department'];}else{$this->error_responce('Department not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_role'])){$user_role = $input_array['user_role'];}else{$this->error_responce('Role not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($user_id!='' && $user_name!='' && $user_password!='' && $user_email!='' && $supervisor!='' && $department!='' && $is_active!='' && $user_role!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'password' => $user_password,
                            'email' => $user_email,
                            'costcentre'=>$costcentre,
                            'designation'=>$designation,
                            'supervisor' => $supervisor,
                            'department'=>$department,
                            'user_role'=>$user_role,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->add_user($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('user alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add the user, Please retry');
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
	

            //used in : 
                ////application\views\includes\js\manage_user_js.php
	function edit_users(){
	    //declareing the variables
                $id;$user_id;$user_name;$user_password;$user_email;$costcentre;$designation;$supervisor;$is_active;$department;$user_role;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_id'])){$user_id = $input_array['user_id'];}else{$this->error_responce('User ID not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_name'])){$user_name = $input_array['user_name'];}else{$this->error_responce('User name not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_password'])){$user_password = $input_array['user_password'];}else{$this->error_responce('Password not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_email'])){$user_email = $input_array['user_email'];}else{$this->error_responce('E-Mail not recieved due to network issue, Please retry');}
                    if(!empty($input_array['costcentre'])){$costcentre = $input_array['costcentre'];}else{$this->error_responce('Costcentre not recieved due to network issue, Please retry');}
                    if(!empty($input_array['designation'])){$designation = $input_array['designation'];}else{$this->error_responce('Designation not recieved due to network issue, Please retry');}
                    if(!empty($input_array['supervisor'])){$supervisor = $input_array['supervisor'];}else{$this->error_responce('Supervisor not recieved due to network issue, Please retry');}
                    if(!empty($input_array['department'])){$department = $input_array['department'];}else{$this->error_responce('Department not recieved due to network issue, Please retry');}
                    if(!empty($input_array['user_role'])){$user_role = $input_array['user_role'];}else{$this->error_responce('Role not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    
                    //validating input data to add 
                    if($user_id!='' && $user_name!='' && $user_password!='' && $user_email!='' && $supervisor!='' && $is_active!='' && $department!='' && $user_role!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'id'=>$id,
                            'user_id' => $user_id,
                            'user_name' => $user_name,
                            'password' => $user_password,
                            'email' => $user_email,
                            'costcentre'=> $costcentre,
                            'designation'=> $designation,
                            'supervisor' => $supervisor,
                            'is_active' => $is_active,
                            'department'=> $department,
                            'user_role'=>$user_role
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->edit_user($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User updated successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('user alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to update the user, Please retry');
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
	
            //used in : 
                ////application\views\includes\js\manage_user_js.php
	function view_users(){
            $html='';
            $users_list = $this->perameter->get_users_list();
            //var_dump($menu_list);
            
            foreach($users_list as $user){
                if($user['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td class="">'. $user['user_id'] .'</td>'
                       . '<td class="hidden-480">'. $user['user_name'] .'</td>'
                       . '<td class="hidden-480">'. $user['email'] .'</td>'
                       . '<td class="hidden-480">'. $user['supervisor'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_user" href="#" value="'. $user['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_user" href="#" value="'. $user['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_user" href="#" value="'. $user['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_user" value="'. $user['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_user" value="'. $user['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_user" value="'. $user['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
	}
        
            //used in : 
                ////application\views\includes\js\manage_user_js.php
        function view_user_by_id(){
            $id = $this->input->post('id');
            $data = $this->perameter->view_user_by_id($id);
            
            //for cost centres
            $user_cost_centre = $this->perameter->view_user_costsentre_by_id($data[0]['user_id']);
            $cc_arr = array();
            foreach($user_cost_centre  as $row){
                array_push($cc_arr, $row['costcentre_code']);
            }
            
            //for designations
            $user_designation = $this->perameter->view_user_designation_by_id($data[0]['user_id']);
            $des_arr = array();
            foreach($user_designation  as $row){
                array_push($des_arr, $row['designation_id']);
            }
            
            //for designations
            $user_department = $this->perameter->view_user_department_by_id($data[0]['user_id']);
            $dep_arr = array();
            foreach($user_department  as $row){
                array_push($dep_arr, $row['department_code']);
            }
            
            //for designations
            $user_roles = $this->perameter->view_user_roles_by_id($data[0]['user_id']);
            $role_arr = array();
            foreach($user_roles  as $row){
                array_push($role_arr, $row['role_id']);
            }
            
            
            $data[0]['user_cost_centre'] = implode(',',$cc_arr);
            $data[0]['user_designation'] = implode(',',$des_arr);
            $data[0]['department'] = implode(',',$dep_arr);
            $data[0]['user_roles'] = implode(',',$role_arr);
                    
            echo json_encode($data);
        }
	
            //used in : 
                ////application\views\includes\js\manage_user_js.php
	function remove_users(){
	
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
                        $add_result = $this->perameter->remove_user($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('User deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the user, Please retry');
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
		
	}//----------------------for manage users----------------------//--end//
        

            //----------------------for manage departments----------------------//

            //used in : 
                ////in the main navigation menu as a sub menu item
	function manage_departments(){
		$this->session->set_userdata('controller', 'perameters');
		$this->session->set_userdata('function', 'manage_departments');
		
		$this->template->set();
		$this->template->current_view = 'perameters/manage_departments';
		$this->template->render();
	}
        
            //used in : 
                ////application\views\includes\js\manage_departments_js.php
        function add_department(){
            //declareing the variables
               $department_code;$department_name;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['department_code'])){$department_code = $input_array['department_code'];}else{$this->error_responce('Department code not recieved due to network issue, Please retry');}
                    if(!empty($input_array['department_name'])){$department_name = $input_array['department_name'];}else{$this->error_responce('Department name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($department_code!='' && $department_name!='' && $is_active!=''){
                        
                        //create data array to add
                        $data_array = array(
                            'department_code'=>$department_code,
                            'department_name' => $department_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->add_department($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Department added successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('user alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to add the department, Please retry');
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
        
            //used in : 
                ////application\views\includes\js\manage_departments_js.php
        function edit_department(){
            //declareing the variables
               $id;$department_code;$department_name;$is_active;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['id'])){$id = $input_array['id'];}else{$this->error_responce('Item not recieved due to network issue, Please retry');}
                    if(!empty($input_array['department_code'])){$department_code = $input_array['department_code'];}else{$this->error_responce('Department code not recieved due to network issue, Please retry');}
                    if(!empty($input_array['department_name'])){$department_name = $input_array['department_name'];}else{$this->error_responce('Department name not recieved due to network issue, Please retry');}
                    if($input_array['is_active'] == 0 || $input_array['is_active'] == 1){$is_active = $input_array['is_active'];}else{$this->error_responce('Status not recieved due to network issue, Please retry');}
                    
                    //validating input data to add 
                    if($department_code!='' && $department_name!='' && $is_active!=''){
                        
                        //create data array to add
                        $edit_array = array(
                            'id'=>$id,
                            'department_code'=>$department_code,
                            'department_name' => $department_name,
                            'is_active' => $is_active
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->edit_department($edit_array);
                        if($add_result == 1 ){
                            $this->success_responce('Department edited successfully');
                        }else {
                            if($add_result == 2 ){
                                $this->error_responce('Department alresdy exist');
                            }else if($add_result == 0 ){
                                $this->error_responce('Failed to edit the department, Please retry');
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
        
            //used in : 
                ////application\views\includes\js\manage_departments_js.php
        function view_departments(){
            $html='';
            $departments_list = $this->perameter->get_department_list();
            //var_dump($menu_list);
            
            foreach($departments_list as $dep){
                if($dep['status'] == 1){ $status = 'success'; $status_text = 'Active';}else{ $status = 'warning'; $status_text = 'Inactive';}
               $html = $html.'<tr>'
                       . '<!--<td class="center">'
                            . '<label class="pos-rel"> '
                                . '<input type="checkbox" class="ace" /> '
                                    . '<span class="lbl"></span></label></td>-->'
                       . '<td class="">'. $dep['code'] .'</td>'
                       . '<td class="hidden-480">'. $dep['description'] .'</td>'
                       . '<td class="hidden-480 center"><span class="label label-sm label-'. $status .' arrowed-in-right">'. $status_text .'</span></td>'
                       . '<td class="center">'
                            . '<div class="hidden-sm hidden-xs action-buttons">'
                                . '<a class="blue view_dep" href="#" value="'. $dep['id'] .'"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>'
                                . '<a class="green edit_dep" href="#" value="'. $dep['id'] .'"><i class="ace-icon fa fa-pencil bigger-130"></i></a>'
                                . '<a class="red remove_dep" href="#" value="'. $dep['id'] .'"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></div>'
                            . '<div class="hidden-md hidden-lg"><div class="inline pos-rel">'
                                    . '<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">'
                                        . '<i class="ace-icon fa fa-caret-down icon-only bigger-120"></i></button>'
                                    . '<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">'
                                        . '<li><a href="#"  class="tooltip-info " data-rel="tooltip" title="View">'
                                                . '<span class="blue view_dep" value="'. $dep['id'] .'"><i class="ace-icon fa fa-search-plus bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-success " data-rel="tooltip" title="Edit">'
                                                . '<span class="green edit_dep" value="'. $dep['id'] .'"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span></a></li>'
                                        . '<li><a href="#"  class="tooltip-error " data-rel="tooltip" title="Delete">'
                                                . '<span class="red remove_dep" value="'. $dep['id'] .'"><i class="ace-icon fa fa-trash-o bigger-120"></i></span></a></li>'
                                    . '</ul>'
                            . '</div></td></tr>'; 
            }
            
            echo json_encode($html);
        }
        
            //used in : 
                ////application\views\includes\js\manage_departments_js.php
        function view_departments_by_id(){
            $id = $this->input->post('id');
            $department = $this->perameter->view_department_by_id($id);
            echo json_encode($department);
        }
        
            //used in : 
                ////application\views\includes\js\manage_departments_js.php
        function remove_department(){
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
                        $add_result = $this->perameter->romove_department($data_array);
                        if($add_result == 1 ){
                            $this->success_responce('Department deleted successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to delete the department, Please retry');
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
        }//-----------------to manage departments----------------------//-----end//
        
        
        
            //-----------------to manage module rights----------------------//-----start//
            //used in : 
                ////main navigation as a sub menu item
        function manage_module_rights(){
            $this->session->set_userdata('controller', 'perameters');
            $this->session->set_userdata('function', 'manage_module_rights');
            
            $data['users'] = $this->perameter->get_users();
            $data['sub_menus'] = $this->perameter->get_sub_menus();
            
            $this->template->set($data);
            $this->template->current_view = 'perameters/manage_module_rights';
            $this->template->render();
        }
        
            //used in : 
                ////application\views\includes\js\manage_module_rights_js.php
        function get_sub_menus_by_ajax(){
            $user_id = $this->input->post('user_id');
            $available_userroles_array = array();
            $available_submenu_array = array();
            
            $available_roles = $this->perameter->get_assigned_roles($user_id);
            if(!empty($available_roles)){
                foreach($available_roles as $row){
                    $available_userroles_array[$row['role_id']] = $row['role_id'];
                }
            }
            
            $available_submenus = $this->perameter->get_assigned_sub_menus($available_userroles_array);
            if(!empty($available_submenus)){
                foreach($available_submenus as $row){
                    $available_submenu_array[$row['submenu_id']] = $row['submenu_id'];
                }
            }
            //var_dump($available_roles);
            $sum_menus = $this->perameter->get_sub_menus_by_ajax($available_submenu_array);
            echo json_encode($sum_menus);
            
        }
        
            //used in : 
                ////application\views\includes\js\manage_module_rights_js.php
        function get_all_assign_user_rights_by_ajax(){
            $user_id;$submenu_id;
            
            $user_id = $this->input->post('user_id');
            $submenu_id = $this->input->post('sub_menu');
            
            $assign_rights_array = array();
            $available_userroles_array = array();
            $available_submenu_array = array();
            
            $assign_rights = $this->perameter->get_assigned_user_rights($user_id,$submenu_id);
            if(!empty($assign_rights)){
                foreach($assign_rights as $row){
                    $assign_rights_array[$row['submenu_function_id']] = $row['submenu_function_id'];
                }
            }
            
            $data['assigned_rights'] = $assign_rights_array;
            $data['available_modules'] = $this->perameter->get_available_modules();
            
            $available_roles = $this->perameter->get_assigned_roles($user_id);
            if(!empty($available_roles)){
                foreach($available_roles as $row){
                    $available_userroles_array[$row['role_id']] = $row['role_id'];
                }
            }
            
            $available_submenus = $this->perameter->get_assigned_sub_menus($available_userroles_array);
            if(!empty($available_submenus)){
                foreach($available_submenus as $row){
                    $available_submenu_array[$row['submenu_id']] = $row['submenu_id'];
                }
            }
            
            
            $data['available_rights'] = $this->perameter->get_available_rights($submenu_id,$data['available_modules'],$available_submenu_array);
            
            
            $html='';
            $i=0;
            $functions;
            //$wigdget[0]='red'; $wigdget[1]='orange'; $wigdget[2]='blue'; $wigdget[3]='green'; $wigdget[4]='grey';
            $wigdget[0]='blue'; $wigdget[1]='red'; $wigdget[2]='green'; $wigdget[3]='grey'; $wigdget[4]='orange';
            $button[0]='danger'; $button[1]='warning'; $button[2]='primary'; $button[3]='success'; $button[4]='grey';
            
            //print_r('<pre>');print_r($data['assigned_rights']);print_r($data['available_rights']);
            if(!empty($data['available_rights'])){
                foreach($data['available_rights'] as $row){
                    
                    $index=0;
                        
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
                        
                    
                    $functions = '';
                    $active_sm_functions = 0;
                    if(!empty($row['functions'])){
                        
                        
                        foreach($row['functions'] as $sbm){ //$sbm = sum module
                            $checked_satus='';//if have any sub menu functions in active, then checked.
                            $disabled = '';//if don't have any sub menu functions, then disable.
                            
                            $sub_menu_funcs = $sbm['functions'];
                            if(!empty($sub_menu_funcs)){
                                foreach($sub_menu_funcs as $smf){
                                    $smf_id = $smf['id'];
                                    
                                    if(in_array($smf_id, $data['assigned_rights'])){
                                        $checked_satus='checked';
                                    }
                                }
                                $disabled = '';
                                $active_sm_functions++;
                            }else{
                                $disabled = 'disabled';
                            }
                            
                            $functions =   $functions. '<li>'
                                                .'<div class="checkbox">'
                                                        .'<label class="block" >'
                                                                .'<input name="form-field-checkbox" type="checkbox" class="ace module_list_'.$row['id'].'" '.$checked_satus.' '.$disabled.' data="'.$sbm['id'].'"/>'
                                                                .'<span class="lbl" > '.$sbm['description'].' </span>'
                                                                
                                                        .'</label>'

                                                .'</div>'
                                            .'</li>';
                        }
                    }
                    
                    $submit_and_check_all = '';//if do not have any sub menu function in active then disable
                    if($active_sm_functions < 1){
                        $submit_and_check_all = 'disabled';
                    }
                    
                    $html = $html.'<div class="pricing-span"><div class="widget-box pricing-box-small widget-color-'.$wigdget[$index].'" >'
                                                    .'<div class="widget-header">'
                                                            .'<h5 class="widget-title bigger lighter">'.$row['name'].'</h5>'
                                                    .'</div>'

                                                    .'<div class="widget-body">'
                                                            .'<div class="widget-main">'
                                                                    .'<ul class="list-unstyled spaced2">'.$functions
                                                                    .'</ul>'

                                                                    .'<hr />'
                                                                    .'<div class="price">'
                                                                            .'<div class="checkbox">'
                                                                                    .'<small><label class="block" >'
                                                                                            .'<input class="form-field-checkbox select_all" data="'.$row['id'].'" type="checkbox" class="ace" '.$submit_and_check_all.'/>'
                                                                                            .'<span class="label label-lg label-inverse arrowed-in arrowed-in-right"><small>Check All</small> </span>'

                                                                                    .'</label></small>'

                                                                            .'</div>'
                                                                            
                                                                    .'</div>'
                                                            .'</div>'

                                                            .'<div>'
                                                                    .'<a href="#"         data="'.$row['id'].'"        class="btn btn-block btn-'.$button[$index].' submit_btn"            '.$submit_and_check_all.' >'
                                                                            .'<i class="ace-icon fa fa-pencil-square-o bigger-110"></i>'
                                                                            .'<span>Update</span>'
                                                                    .'</a>'
                                                            .'</div>'
                                                    .'</div>'
                                            .'</div>'
                                    .'</div></div>';
                    
                    $i++;
                }
                
                
            }
            
            if($html==''){
                $html = "<div>No rights added to this user. check the user role....!!!</div>";
            }
            echo json_encode($html);
        }
        
            //used in : 
                    ////application\views\includes\js\manage_module_rights_js.php
        function update_module_rights(){
            //declareing the variables
               $user_id;$sub_menu;$modules;
		
            //getting the input and assingong to a variable
                $input_array = $this->input->post();
            
            //validating input array 
                if(!empty($input_array)){
            
                    //validating input by each items
                    if(!empty($input_array['user_id'])){$user_id = $input_array['user_id'];}else{$this->error_responce('User not recieved due to network issue, Please retry');}
                    if(!empty($input_array['sub_menu'])){$sub_menu = $input_array['sub_menu'];}else{$this->error_responce('Submenu not recieved due to network issue, Please retry');}
                    if(!empty($input_array['modules'])){$modules = $input_array['modules'];}else{$modules = array();}
                     
                    //validating input data to add 
                    if($user_id!='' && $sub_menu!='' && $modules!=''){
                        
                        //create data array to add
                        $edit_array = array(
                            'user_id'=>$user_id,
                            'sub_menu'=>$sub_menu,
                            'modules' => $modules
                            
                        );
                        
                        //to add data to table
                        $add_result = $this->perameter->edit_module_rights($edit_array);
                        if($add_result == 1 ){
                            $this->success_responce('Module rights edited successfully');
                        }else {
                            if($add_result == 0 ){
                                $this->error_responce('Failed to edit the module rights, Please retry');
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
                
        
        
        
}
