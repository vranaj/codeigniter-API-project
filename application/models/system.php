<?php

class System extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
//common functions - start
    
    //used in :  manage_sub_menus,
    function get_menus(){
        $this->db->select('id as menu_id,name as menu_name');
        $this->db->from(TBL_MENUS);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    function get_menu_data($id){
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->where('id', $id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_user_rights,
    function get_user_roles(){
        $this->db->select('id as role_id,description as role_name');
        $this->db->from(TBL_ROLES);
        $this->db->where('status','1');
        //$this->db->where_not_in('id','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_user_rights,manage_sub_menu_functions,manage_functional_rights,
    function get_sub_menus(){
        $this->db->select('id as sub_menu_id,name as sub_menu_name');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_sub_menu_functions
    function get_modules(){
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_functional_rights
    function get_users(){
        $this->db->select('user_id,user_name');
        $this->db->from(TBL_USERS);
        $this->db->where('status','1');
        //$this->db->where_not_in('user_id','admin');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_submenu_functions_by_ajax
    function get_sub_menu_functions($submenu_id=''){
        $this->db->select('id as func_id, function_name as func_name, sub_menu_id');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
        if($submenu_id!=''){
            $this->db->where('sub_menu_id', $submenu_id);
        }
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_submenu_functions_by_ajax
    function get_given_functional_rights($user_id,$submenu_id=''){
        $arr = array();
        
        $this->db->select('fn_r.id, fn_r.user_id, fn_r.submenu_function_id');
        $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS.' fn_r');
        $this->db->join(TBL_FUNCTIONS_OF_SUBMENU.' sf', 'fn_r.submenu_function_id=sf.id');
        $this->db->where('sf.sub_menu_id', $submenu_id);
        $this->db->where('fn_r.user_id', $user_id);
        $this->db->where('fn_r.status', 1);
        $result = $this->db->get()->result_array();
        
        if(!empty($result)){
            foreach($result as $val){
               $arr[$val['submenu_function_id']] = $val['submenu_function_id'];
            }
        }
        
        return $arr;
        
        
    }
    
    //used in : get_assign_submenus_by_ajax
    function get_active_sub_menus(){
        $this->db->select('id as submenu_id, name as submenu_name');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where('status', 1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_assign_submenus_by_ajax
    function get_given_rights($role_id=''){
        $arr = array();
        
        $this->db->select('rr.id, rr.role_id, rr.submenu_id');
        $this->db->from(TBL_RIGHTS_FOR_USERROLES.' rr');
        $this->db->join(TBL_SUB_MENU.' sm', 'rr.submenu_id=sm.id');
        if($role_id != ''){
            $this->db->where('rr.role_id', $role_id);
        }
        $this->db->where('rr.status', 1);
        $result = $this->db->get()->result_array();
        
        if(!empty($result)){
            foreach($result as $val){
               $arr[$val['submenu_id']] = $val['submenu_id'];
            }
        }
        
        return $arr;
    }
    
    //used in : get_all_rights_by_ajax
    function get_all_given_rights(){
       // print_r("<pre>");
        
        $rights_array = array();
        $max_length_of_sub_array = 0;
        $this->db->select('*');
        $this->db->from(TBL_ROLES);
        $this->db->where('status', 1);
        $roles = $this->db->get()->result_array();
        
        foreach($roles as $role){
            $this->db->select('*');
            $this->db->from(TBL_RIGHTS_FOR_USERROLES.' rr');
            $this->db->join(TBL_SUB_MENU.' sm','rr.submenu_id = sm.id');
            $this->db->where('role_id', $role['id']);
            $this->db->where('rr.status', 1);
            $this->db->order_by('sm.id');
            $rights = $this->db->get()->result_array();
            
            $temp_arr = $role;
            $temp_arr['rights'] = $rights;
            array_push($rights_array, $temp_arr);
            
            $length = count($rights);
        if($length > $max_length_of_sub_array){
            $max_length_of_sub_array = $length;
        }
            
        }
        $rights_array['length_of_array'] = count($rights_array);
        $rights_array['max_length_of_sub_array'] = $max_length_of_sub_array;
        return $rights_array;
    }

//common functions - end
//
//        
//controller functions related model functions    
    //for menus
    function add_menu_item($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->where(array('name'=>$add_array['menu_name'], 'path'=>$add_array['controller_name']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'name'=>  $add_array['menu_name'],
                'path' => $add_array['controller_name'],
                'dispaly_order' => $add_array['display_order'],
                'icon_name' => $add_array['icon_name'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_MENUS,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : edit_menus
    function edit_menu_item($edit_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->where(array('name'=>$edit_array['menu_name'], 'path'=>$edit_array['controller_name']));
        $this->db->where_not_in('id',$edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'name'=>  $edit_array['menu_name'],
                'path' => $edit_array['controller_name'],
                'dispaly_order' => $edit_array['display_order'],
                'icon_name' => $edit_array['icon_name'],
                'status' => $edit_array['is_active']
                );
            
            $this->db->where('id',$edit_array['id']);
            if($this->db->update(TBL_MENUS,$insert_array)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : remove_menus
    function romove_menu_item($remove_array){
        
            $this->db->where('id',$remove_array['id']);
            if($this->db->delete(TBL_MENUS)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
    }
    
    //used in : view_menus
    function get_menu_list(){
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->order_by('name');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in :view_menu_by_id
    function get_menu_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    
    //for sub menus
    function add_sub_menu_item($add_array){
         //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where(array('path'=>$add_array['sub_menu_path'], 'menu_id'=>$add_array['parent_menu']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'name'=>  $add_array['sub_menu_name'],
                'path' => $add_array['sub_menu_path'],
                'menu_id' => $add_array['parent_menu'],
                'display_order' => $add_array['display_order'],
                'icon_name' => $add_array['icon_name'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_SUB_MENU,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    //used in : edit_sub_menus
    function edit_sub_menu_item($edit_array){
        
         //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where(array('path'=>$edit_array['sub_menu_path'], 'menu_id'=>$edit_array['parent_menu']));
        $this->db->where_not_in('id',$edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $update_array = array(
                'name'=>  $edit_array['sub_menu_name'],
                'path' => $edit_array['sub_menu_path'],
                'menu_id' => $edit_array['parent_menu'],
                'display_order' => $edit_array['display_order'],
                'icon_name' => $edit_array['icon_name'],
                'status' => $edit_array['is_active']
                );
            
            $this->db->where('id',$edit_array['id']);
           if($this->db->update(TBL_SUB_MENU,$update_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
            
        
    }
    
    //used in : view_sub_menus
    function get_sub_menu_list(){
        $this->db->select('psm.*, pm.name as menu_name');
        $this->db->from(TBL_SUB_MENU.' psm');
        $this->db->join(TBL_MENUS.' pm', 'psm.menu_id = pm.id');
        $this->db->order_by('psm.name');
        $result = $this->db->get()->result_array();
        //var_dump($result);
        return $result;
    }
    
    //used in :view_sub_menu_by_id, edit_submenus
    function get_sub_menu_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : edit_sub_menus
    function get_parent_menu_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_MENUS);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : remove_sub_menus
    function remove_sub_menu_item($remove_array){
        
        $this->db->where('id',$remove_array['id']);
        if($this->db->delete(TBL_SUB_MENU)){
            return 1;//insert success
        }else{
            return 0;//failed to insert
        }
    
    }
    
    
    
    
    
    
    //for manage user roles
	
    function add_user_role($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_ROLES);
        $this->db->where(array('description'=>$add_array['role_name']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'description'=>  $add_array['role_name'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_ROLES,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    //use in : view_user_roles,
    function get_user_roles_list(){
        $this->db->select('id, description as role_name, status');
        $this->db->from(TBL_ROLES);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        //var_dump($result);
        return $result;
    }
    
    //used in : view_role_by_id
    function get_user_role_by_id($id){
        $this->db->select('id, description as role_name, status');
        $this->db->from(TBL_ROLES);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : edit_user_roles
    function edit_user_role($edit_array){
        //var_dump($edit_array);
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_ROLES);
        $this->db->where(array('description'=>$edit_array['role_name']));
        $this->db->where_not_in('id', $edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $update_array = array(
                'description'=>  $edit_array['role_name'],
                'status' => $edit_array['is_active']
                );

            $this->db->where('id', $edit_array['id']);
            if($this->db->update(TBL_ROLES,$update_array)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
        
        
    }
    
    //used in : remove_user_roles
    function remove_role_item($remove_array){
         $this->db->where('id',$remove_array['id']);
        if($this->db->delete(TBL_ROLES)){
            return 1;//insert success
        }else{
            return 0;//failed to insert
        }
    }
    
    
    //for manage user rights
    function add_user_right($add_array){
        $responce = 0;
        $array = array();
        
        //to create an checked item array
        $checked_item_array = array();
        foreach($add_array['checked_items'] as $checked_item){
            $checked_item_array[$checked_item] = $checked_item;
        }
        
        //to get all the sub menus
        $this->db->select('id');
        $this->db->from(TBL_SUB_MENU);
        $this->db->order_by('id');
        $result_sub_menus = $this->db->get()->result_array();
        
        if(!empty($result_sub_menus)){
            foreach($result_sub_menus as $sub_menu){
                
                if(in_array($sub_menu['id'], $checked_item_array)){
                                        
                    //to update functional rights
                    $this->change_users_function_level_right($sub_menu['id'], $add_array['role_id'], true);
                    
                    //to check as is existing 
                    $this->db->select('*');
                    $this->db->from(TBL_RIGHTS_FOR_USERROLES);
                    $this->db->where(array('role_id'=>$add_array['role_id'], 'submenu_id'=>$sub_menu['id']));
                    $result_roe_right = $this->db->get()->result_array();
                    
                    if(empty($result_roe_right)){
                        array_push($array, array('role_id'=>$add_array['role_id'], 'submenu_id'=>$sub_menu['id'], 'status'=>1));
                    }else{
                        $this->db->where(array('role_id'=>$add_array['role_id'], 'submenu_id'=>$sub_menu['id']));
                        if($this->db->update(TBL_RIGHTS_FOR_USERROLES, array('status'=>1))){
                           $responce = 1;//insert success 
                        }
                    }
                    
                    
                }else{
                    
                    $this->change_users_function_level_right($sub_menu['id'], $add_array['role_id'], false);
                    
                    $this->db->where(array('role_id'=>$add_array['role_id'], 'submenu_id'=>$sub_menu['id']));
                    if($this->db->update(TBL_RIGHTS_FOR_USERROLES, array('status'=>0))){
                        $responce = 1;//insert success
                    }
                }
            }
            
            if(!empty($array)){
                if($this->db->insert_batch(TBL_RIGHTS_FOR_USERROLES,$array)){
                   $responce = 1;//insert success
               }
            }
        
            if($responce == 1){
                return 1;
            }else{
                return 0;
            }
        }
        

    }
    
    //used in : add_user_right
    function change_users_function_level_right($sub_menu_id, $role_id, $is_added){
            
            $insert_array = array();
            //to get the all the users related to this role
            $this->db->select('user_id');
            $this->db->from(TBL_USERROLES);
            $this->db->where('role_id', $role_id);
            $users_list = $this->db->get()->result_array();
            
            //to get the all the functoins related to this submenu
            $this->db->select('id');
            $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
            $this->db->where('sub_menu_id', $sub_menu_id);
            $functions_list = $this->db->get()->result_array();
            
            //to update the functional rights for each users of to that role
            foreach($users_list as $user){
                
                $temp_user_id = $user['user_id'];
                
                $athe_roles_related_funcs = $this->get_user_related_funcs($temp_user_id, $role_id);
                
                foreach($functions_list as $function){
                    $this->db->select('*');
                    $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS);
                    $this->db->where(array('user_id'=>$temp_user_id, 'submenu_function_id'=>$function['id']));
                    $result_right = $this->db->get()->result_array();
                    
                    if($is_added == true){
                        
                        if(empty($result_right)){
                            array_push($insert_array, array('user_id'=>$temp_user_id,'submenu_function_id'=>$function['id'],'status'=>1));
                        }else{
                            //if($user['user_id']>0 && $function['id'] >0){
                                $this->db->where(array('user_id'=>$temp_user_id, 'submenu_function_id'=>$function['id']));
                                $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>1));
                            //}
                        }
                    }else{
                        $athe_roles_related_funcs = $this->get_user_related_funcs($temp_user_id, $role_id);
                        
                        if(!in_array($function['id'], $athe_roles_related_funcs)){
                            
                            if(!empty($result_right)){
                                //if($user['user_id']>0 && $function['id'] >0){
                                    $this->db->where(array('user_id'=>$temp_user_id, 'submenu_function_id'=>$function['id']));
                                    $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>0));
                                //}

                            }
                            
                        }
                        
                        
                    }
                    
                }
                
            }
            
            if(!empty($insert_array) && $is_added==false){
                $this->db->insert_batch(TBL_RIGHTS_OF_SUBMENU_FUNCS, $insert_array);
            }
            
            
        
    }
    
    function get_user_related_funcs($user_id, $role_id){
        
        $role_array = array();
        
        $this->db->select('sbmf.id');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU.' sbmf');
        $this->db->join(TBL_SUB_MENU.' sbm', 'sbmf.sub_menu_id=sbm.id');
        $this->db->join(TBL_RIGHTS_FOR_USERROLES.' rfur', 'sbm.id=rfur.submenu_id');
        $this->db->join(TBL_USERROLES.' ur', 'rfur.role_id=ur.role_id');
        $this->db->where('ur.user_id', $user_id);
        $this->db->where_not_in('ur.role_id', $role_id);
        $this->db->order_by('sbmf.id');
        $roles = $this->db->get()->result_array();
        
        
        if(!empty($roles)){
            foreach($roles as $role){
               $role_array[$role['id']] = $role['id'];
            }
        }
        return $role_array;
        
    }
    
    //for add sub menu function
    function add_sub_menu_function($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
        $this->db->where(array('function_name'=>$add_array['func_name'], 'sub_menu_id'=>$add_array['sub_menu_id']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'function_name'=>  $add_array['func_name'],
                'sub_menu_id'=> $add_array['sub_menu_id'],
                'module_id'=> $add_array['func_module'],
                'status' => $add_array['is_active']
            );

           if($this->db->insert(TBL_FUNCTIONS_OF_SUBMENU,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : edit_sub_menu_functions
    function edit_sub_menu_function($data_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
        $this->db->where(array('function_name'=>$data_array['func_name'], 'sub_menu_id'=>$data_array['sub_menu_id']));
        $this->db->where_not_in('id',$data_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $update_array = array(
                'function_name'=>  $data_array['func_name'],
                'sub_menu_id'=> $data_array['sub_menu_id'],
                'module_id'=> $data_array['func_module'],
                'status' => $data_array['is_active']
            );
            
           $this->db->where('id',$data_array['id']);
           if($this->db->update(TBL_FUNCTIONS_OF_SUBMENU,$update_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    function remove_sub_menu_function($remove_array){
        $this->db->where('id',$remove_array['id']);
        if($this->db->delete(TBL_FUNCTIONS_OF_SUBMENU)){
            return 1;//insert success
        }else{
            return 0;//failed to insert
        }
    }


    //used in : view_sub_menu_functions
    function get_sub_menu_function_list(){
        $this->db->select('psmf.*, psm.name as sub_menu_name, pm.description as module');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU.' psmf');
        $this->db->join(TBL_SUB_MENU.' psm', 'psmf.sub_menu_id = psm.id');
        $this->db->join(TBL_MODULES.' pm', 'psmf.module_id = pm.id');
        $this->db->order_by('psmf.function_name');
        $result = $this->db->get()->result_array();
        //var_dump($result);
        return $result;
    }
    
    //used in : view_role_by_id, edit_sub_menu_functions
    function get_sub_menu_func_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //for add sub menu functional rights
    function add_functional_right($add_array){
        
        $responce = 0;
        
        
        //to get all submenu funcs
        $this->db->select('rsf.id,submenu_function_id');
        $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS.' rsf');
        $this->db->join(TBL_FUNCTIONS_OF_SUBMENU.' sbmf', 'rsf.submenu_function_id=sbmf.id');
        $this->db->where('sbmf.sub_menu_id', $add_array['submenu_id']);
        $this->db->where('rsf.user_id', $add_array['user_id']);
        $funcs = $this->db->get()->result_array();
         
        //to update the available rights to inactive
        foreach($funcs as $fun){
            $this->db->where('id', $fun['id']);
            $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>0));
        }
        
        
        $array = array();
        
        
        //to check as is existing 
        foreach($add_array['checked_items'] as $val){
            $this->db->select('*');
            $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS);
            $this->db->where(array('user_id'=>$add_array['user_id'], 'submenu_function_id'=>$val));
            $result = $this->db->get()->result_array();
            
            if(empty($result[0])){
                array_push($array, array('user_id'=>$add_array['user_id'], 'submenu_function_id'=>$val, 'status'=>1));
            }else{
                $this->db->where('id', $result[0]['id']);
                if($this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>1)))
                {
                    $responce = 1;//upddate success
                }
            }
        }
        
        if(!empty($array)){
            if($this->db->insert_batch(TBL_RIGHTS_OF_SUBMENU_FUNCS,$array)){
               $responce = 1;//insert success
           }
        }
        
        if($responce == 1){
            return 1;
        }else{
            return 0;
        }
           
        
    }
    
    //used in : get_all_func_rights_by_ajax
    function get_all_given_func_rights($user_id, $submenu_id){
        
        $rights_array = array();
        $length_of_array = 0;
        $max_length_of_rights_array = 0;
        
        $this->db->select('id as sbm_id, name as sbm_name');
        $this->db->from(TBL_SUB_MENU);
        if($submenu_id > 0 && $submenu_id !=''){
            $this->db->where('id', $submenu_id);
        }
        $this->db->where('status', 1);
        $this->db->order_by('name');
        $results = $this->db->get()->result_array();
        
        
        foreach($results as $result){
            $this->db->select('psf.id as function_id, psf.function_name as function_name');
            $this->db->from(TBL_FUNCTIONS_OF_SUBMENU.' psf');
            $this->db->join(TBL_RIGHTS_OF_SUBMENU_FUNCS.' pusfr', 'psf.id=pusfr.submenu_function_id');
            $this->db->where('psf.status', 1);
            $this->db->where('pusfr.status', 1);
            $this->db->where('psf.sub_menu_id', $result['sbm_id']);
            $this->db->where('pusfr.user_id', $user_id);
            $rights = $this->db->get()->result_array();
            
            if(!empty($rights)){
                $temp_array = array(
                    'sbm_id'=>$result['sbm_id'],
                    'sbm_name'=>$result['sbm_name'],
                    'rights'=>$rights
                );

                if(count($rights) > $max_length_of_rights_array){
                    $max_length_of_rights_array = count($rights);
                }

                array_push($rights_array, $temp_array);

                //var_dump('$result');var_dump($result);
                //var_dump('$rights');var_dump($rights);
                //var_dump('$temp_array');var_dump($temp_array);
                //var_dump('$rights_array');var_dump($rights_array);
            }
            
            
        }
        $length_of_array = count($rights_array);
        $rights_array['length_of_array'] = $length_of_array;
        $rights_array['max_length_of_rights_array'] = $max_length_of_rights_array;
        
        return $rights_array;
        
    }
    
    
    //for manage modules
    
    //used in : add_modules
    function add_module($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->where(array('description'=>$add_array['module_name']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'description'=>  $add_array['module_name'],
                'status' => $add_array['is_active']
            );

           if($this->db->insert(TBL_MODULES,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : view_modules
    function get_modules_list(){
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        //var_dump($result);
        return $result;
    }
    
    //used in : view_modules_by_id
    function get_module_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : edit_modules
    function edit_module($edit_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->where(array('description'=>$edit_array['module_name']));
        $this->db->where_not_in('id',$edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $update_array = array(
                'description'=>  $edit_array['module_name'],
                'status' => $edit_array['is_active']
            );
            
           $this->db->where('id',$edit_array['id']);
           if($this->db->update(TBL_MODULES,$update_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    
    function remove_module($remove_array){
        $this->db->where('id',$remove_array['id']);
        if($this->db->delete(TBL_MODULES)){
            return 1;//insert success
        }else{
            return 0;//failed to insert
        }
    }
}

/* End of file user.php */
/* Location: ./application/models/user.php */