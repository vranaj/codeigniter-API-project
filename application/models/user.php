<?php

class User extends CI_Model {

    function __construct() {
        parent::__construct();
    }
	
 
    function check_login_data($user_id='',$password=''){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where('user_id',$user_id);
        
        if($password != ''){
            $this->db->where('password',md5($password));
        }
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_userData($user_id){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_user_designation($user_id){
        $this->db->select('*');
        $this->db->from(TBL_USERS_DESIGNATIONS);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_user_costcentres($user_id){
        $this->db->select('*');
        $this->db->from(TBL_USERS_COSTCENTRES);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_users_roles($user_id){
        $this->db->select('*');
        $this->db->from(TBL_USERROLES);
        $this->db->where('user_id',$user_id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_user_permission($user_roles){
        
        $this->db->select('rr.id as rights_id, rr.role_id as role_id, rr.submenu_id as submenu_id, '
                . 'm.id as menu_id, m.name as menu_name, m.path as menu_path, m.dispaly_order as menu_order, m.icon_name as menu_icon,'
                . 'sm.id as submenu_id, sm.name as submenu_name, sm.path as submenu_path, sm.display_order as submenu_order, sm.icon_name as sub_menu_icon');
        $this->db->from(TBL_RIGHTS_FOR_USERROLES.' rr');
        $this->db->where_in('rr.role_id',$user_roles);
        $this->db->where('rr.status',1);
        $this->db->where('m.status',1);
        $this->db->where('sm.status',1);
        $this->db->join(TBL_SUB_MENU.' sm','rr.submenu_id = sm.id','left');
        $this->db->join(TBL_MENUS.' m','sm.menu_id = m.id','left');
        $this->db->order_by('m.dispaly_order');
        $this->db->order_by('sm.display_order');
        $result = $this->db->get()->result_array();
        return $result;
    }
	
    function get_user_functional_permission($user_id){
        $this->db->select('*');
        $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS.' rsf');
        $this->db->where('rsf.user_id',$user_id);
        $this->db->join(TBL_FUNCTIONS_OF_SUBMENU.' sbmf', 'rsf.submenu_function_id = sbmf.id');
        $this->db->order_by('sbmf.sub_menu_id');
        $result = $this->db->get()->result_array();
        return $result;
    }
	
    function check_authority($user_id,$curr_class,$sub_menu,$curr_method){
        //var_dump($user_id);var_dump($curr_class);var_dump($sub_menu);var_dump($curr_method);
        $this->db->select('*');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where('path',$curr_class.'/'.$curr_method);
        $this->db->where('status',1);
        $is_sub_menu = $this->db->get()->result_array();
        //var_dump($is_sub_menu);
        if(!empty($is_sub_menu)){
                return true;
        }else{
                $this->db->select('id');
                $this->db->from(TBL_SUB_MENU);
                $this->db->where('path',$curr_class.'/'.$sub_menu);
                $this->db->where('status',1);
                $result = $this->db->get()->result_array();
                //var_dump($result);

                $this->db->select('usfr.id, usfr.user_id, usfr.submenu_function_id, usfr.status');
                $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS.' usfr');
                $this->db->join(TBL_FUNCTIONS_OF_SUBMENU.' sf','usfr.submenu_function_id = sf.id');
                $this->db->where('usfr.user_id', $user_id);
                $this->db->where('sf.sub_menu_id', $result[0]['id']);
                $this->db->where('sf.function_name', $curr_method);
                $this->db->where('usfr.status', 1);
                $result1 = $this->db->get()->result_array();
                //var_dump($result1);

                if(!empty($result1)){return true;}else{return false;}
        }
		
		
    }
	
	

}

/* End of file user.php */
/* Location: ./application/models/user.php */