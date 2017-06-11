<?php

class Users extends CI_Controller {

    function __construct() {
        parent::__construct();

        //Load the required models
        $this->load->model('user');
        $this->load->model('audit');

        //Load the required libraries
        $this->load->library('grocery_CRUD');
    }
    
    //common function - start
    
    //to set the skin theme 
    //used in : application.php
        function set_skin_by_ajax(){
            $skin = $this->input->post('skin_val');
            $this->session->set_userdata('skin',$skin);
        }
        
        //used in : application.php
        function set_inside_container_ajax(){
            $inside_container = $this->input->post('ic');
            $this->session->set_userdata('ic',$inside_container);
        }
        
        //used in : application.php
        function set_li_hover_ajax(){
            $li_hover= $this->input->post('li_hover');
            $this->session->set_userdata('li_hover',$li_hover);
        }
        
        //used in : application.php
        function set_sb_compact_ajax(){
            $sb_compact= $this->input->post('sb_compact');
            $this->session->set_userdata('sb_compact',$sb_compact);
        }
    //common function -end

    function index($user_id=false, $password=false, $login_type=false) {
            
            $this->session->set_userdata('controller', 'users');//to set menu
            $this->session->set_userdata('function', 'index');//to set sub menu
	
            //if already logged in
            if($this->session->userdata('user_log') == true){
		$this->log_in();
                
            }else{ //else
            
                //this is used to login through direct url-link and assign values from url_link
		if($user_id != false && $password != false && $login_type != false){
                    $user_id = $user_id;
                    $password = $password;
                    $login_type = $login_type;
                    
                }else{ //if it is form submit
                    //to set rule
                    $this->form_validation->set_error_delimiters('<li>', '</li>');
                    $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|min_length[1]|max_length[25]');
                    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[1]|max_length[100]');
                    //$this->form_validation->set_rules('login_type', 'Login Type', 'trim|required|min_length[1]|max_length[100]');
                    
                    //check validation
                    if ($this->form_validation->run() == FALSE) {
                        //Set Auth Session
                        $this->session->set_userdata('auth', FALSE);
                        
                        //Load the index view
                        $this->template->render('login');
                        
                    }else{
                        //add values from form submit value
                        $user_id = $this->input->post('user_id');
                        $password = $this->input->post('password');
                        $login_type = $this->input->post('login_type');

                    }
					
                }
				
                //to check the input values and to log in
                if($user_id && $password){
                    $user_exist =array();
                    
                    // to check the log in type and to get the user data
                    if($login_type == 'direct'){//need only user_id to log in
                            $user_exist = $this->user->check_login_data($user_id,'');
                    }elseif($login_type == 'default'){//need user_id and password to log in
                            $user_exist = $this->user->check_login_data($user_id,$password);
                    }elseif($login_type == 'url'){//need user_id and password to log in
                            $user_exist = $this->user->check_login_data($user_id,$password);
                    }else{
                        $this->template->set_message('Invalid Login Type', 'error');
                        redirect(site_url("users/login_error"), 'refresh');
                    }
				
                    // if user exist
                    if(!empty($user_exist)){
                        
                        // user datas from user table
                            $user_log_data = $this->user->get_userData($user_id);
                        
                        //to get the assigned designations and to create single array of designations
                            $user_designations_temp = $this->user->get_user_designation($user_id);
                            $user_designations = $this->seperate_array_value_to_bus_array($user_designations_temp, array('designation_id','is_primary'));
                            
                        //to get the assigned cost centers and to create single array of cost centers
                            $user_costcentres_temp = $this->user->get_user_costcentres($user_id);
                            $user_costcentres = $this->seperate_array_value_to_bus_array($user_costcentres_temp, array('costcentre_code','is_primary'));
                        
                        //to get the assigned user roles and to create single array of user roles
                            $user_roles_temp = $this->user->get_users_roles($user_id);
                            $user_roles = $this->seperate_array_value_to_bus_array($user_roles_temp, array('role_id'));
                        
                        //to get the assigned role permissions and to create single array of role permissions
                            $user_role_list = $this->create_single_array($user_roles,'role_id');
                            $user_permission = $this->user->get_user_permission($user_role_list);
                                           
                        //to create menu list
                            $menu_list = $this->seperate_array_value_to_bus_array($user_permission, array('role_id'));
                            $nav_menu = $this->create_menu($user_permission);
                        
                        // to get user functional wise permissions for every sub menus
                            $user_functional_permission = $this->user->get_user_functional_permission($user_id);
                            //var_dump($user_functional_permission);die;
                            
                        //to create the session array and to set session data
                            $session_data = array(
                                     'log_data'=>$user_log_data,
                                     'designations'=>$user_designations,
                                     'costcentres'=>$user_costcentres,
                                     'roles'=>$user_roles,
                                     'permission'=>$user_permission,
                                     'menu'=>$nav_menu

                             );
                            $this->set_login($session_data);
                        
                        //to redirect to view
                            $this->log_in();


                    } else {
                            $this->template->set_message('Username or Password is invalid', 'error');
                            redirect(site_url("users/login_error"), 'refresh');

                    }
                }/*else{
                    $this->template->set_message('Invalid argument', 'error');
                    redirect(site_url("users/login_error"), 'refresh');
                }*/
				
            }
        
    }
	
    function login_error() {
        //Display login error view
        $this->template->render('login');
    }
	
    function log_in() {
        if($this->session->userdata('user_log') == true){

                $this->template->set();

                $this->template->current_view = 'home';  //Set Current view	
                //Load the index view
                $this->template->render();
        }
        
    }

    function logout() {
        $this->session->sess_destroy();
        redirect(site_url("users/index"), 'refresh');
    }
	
	//need
    function seperate_array_value_to_bus_array($parent_array, $values){
        $sub_arr = array();
//        var_dump($parent_array);
//        var_dump($values);
        foreach($parent_array as $row){
            
            $sub_arr2 = array();
            foreach($values as $val){
                
                $sub_arr2[$val] = $row[$val];
                
            }
            array_push($sub_arr, $sub_arr2);
            
        }
//        var_dump($sub_arr);die;
        return $sub_arr;
    }
    
    //need
    function create_single_array($dataArray,$val){
        
        $temp_arr = array();
        foreach($dataArray as $row){
            array_push($temp_arr, $row[$val]);
        }
        return $temp_arr;
    }
    
    //need
    function create_menu($array){
        //var_dump($array);
        
        $nav_array = array();
        
        $array_length = count($array);
        
        //echo('<pre>');
        
        //to create the nav menu
        foreach($array as $row){
                
                $sub_menu = array();
                
                $nav_array[$row['menu_id']]['menu_id'] = $row['menu_id'];
                $nav_array[$row['menu_id']]['menu_name'] = $row['menu_name'];
                $nav_array[$row['menu_id']]['menu_path'] = $row['menu_path'];
                $nav_array[$row['menu_id']]['menu_order'] = $row['menu_order'];
                $nav_array[$row['menu_id']]['menu_icon'] = $row['menu_icon'];
                
                $sub_menu['menu_id'] = $row['menu_id'];
                $sub_menu['submenu_id'] = $row['submenu_id'];
                $sub_menu['submenu_name'] = $row['submenu_name'];
                $sub_menu['submenu_path'] = $row['submenu_path'];
                $sub_menu['submenu_order'] = $row['submenu_order'];
                $sub_menu['sub_menu_icon'] = $row['sub_menu_icon'];
                
                $nav_array[$row['menu_id']]['sub_menus'][$row['submenu_id']] = $sub_menu;
                
                //print_r('submenu ');print_r($sub_menu);
                
                //print_r($nav_array);
                
                
                
        }
        
        return $nav_array;
    }
    
    //need
    function set_login($array=false){
        //var_dump($array);die;
        foreach($array as $key => $row){
            
            $this->session->set_userdata($key,$row);
            $this->session->set_userdata('user_log',true);
        }
        
        //var_dump($this->session->userdata);
    }
	
	

    
    //need
    /*function direct_login() {
        if($this->session->userdata('user_log') == true){
				//$data['controller'] = 'users';
                //$this->template->set($data);
                
                //$this->template->current_view = 'home';  //Set Current view	
                //Load the index view
                //$this->template->render();
				$this->log_in();
        }else{
            if ($this->input->post()) {
            
                $user_id = $this->input->post('user_id');
                $password = $this->input->post('password');
                $login_type = $this->input->post('login_type');
                $user_exist =array();

                if($login_type == 'direct'){
                    $user_exist = $this->user->check_login_data($user_id,'');
                }elseif($login_type == 'default'){
                    $user_exist = $this->user->check_login_data($user_id,$password);
                }elseif($login_type == 'url'){
                    $user_exist = $this->user->check_login_data($user_id,$password);
                }

                if(!empty($user_exist)){
                   $user_log_data = $this->user->get_userData($user_id);
                   $user_designations_temp = $this->user->get_user_designation($user_id);
                   $user_designations = $this->seperate_array_value_to_bus_array($user_designations_temp, array('designation_id','is_primary'));

                   $user_costcentres_temp = $this->user->get_user_costcentres($user_id);
                   $user_costcentres = $this->seperate_array_value_to_bus_array($user_costcentres_temp, array('costcentre_code','is_primary'));

                   $user_roles_temp = $this->user->get_users_roles($user_id);
                   $user_roles = $this->seperate_array_value_to_bus_array($user_roles_temp, array('role_id'));

                   $user_role_list = $this->create_single_array($user_roles,'role_id');
                   $user_permission = $this->user->get_user_permission($user_role_list);

                   $menu_list = $this->seperate_array_value_to_bus_array($user_permission, array('role_id'));
                   $nav_menu = $this->create_menu($user_permission);

                   $session_data = array(
                                        'log_data'=>$user_log_data,
                                        'designations'=>$user_designations,
                                        'costcentres'=>$user_costcentres,
                                        'roles'=>$user_roles,
                                        'permission'=>$user_permission,
                                        'menu'=>$nav_menu

                                    );
                    $this->set_login($session_data);

                    $this->log_in();


                } else {
                    $this->template->set_message('Username or Password is invalid', 'error');
                    redirect(site_url("users/login_error"), 'refresh');

                }



            }
        }
        
        
        
    }*/
    
    
	
}

/* End of file users.php */
/* Location: ./system/application/controllers/users.php */