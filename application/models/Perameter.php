<?php

class Perameter extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    
//common functions - start
    
    //used in : manage_users
    function get_users_for_dropdown(){
        $this->db->select('user_id,user_name');
        $this->db->from(TBL_USERS);
        $this->db->order_by('user_name');
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_users
    function get_costcentre_for_dropdown(){
        $this->db->select('code,description');
        $this->db->from(TBL_COST_CENTRES);
        $this->db->order_by('description');
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_users
    function get_designation_for_dropdown(){
        $this->db->select('id,description');
        $this->db->from(TBL_DESIGNATIONS);
        $this->db->order_by('description');
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_users
    function get_departments_for_dropdown(){
    
        $this->db->select('id,code,description');
        $this->db->from(TBL_DEPARTMENTS);
        $this->db->order_by('description');
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
        
    }
    
    
    //used in : manage_module_rights
    function get_sub_menus(){
        $this->db->select('id as sub_menu_id,name as sub_menu_name');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_sub_menu_list
    function get_sub_menus_by_ajax($available_submenu_array){
        if(empty($available_submenu_array)){$available_submenu_array = array(0);}
        
        $this->db->select('id as sub_menu_id,name as sub_menu_name');
        $this->db->from(TBL_SUB_MENU);
        $this->db->where_in('id',$available_submenu_array);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_module_rights
    function get_users(){
        $this->db->select('user_id,user_name');
        $this->db->from(TBL_USERS);
        $this->db->where('status','1');
        //$this->db->where_not_in('user_id','admin');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : manage_users
    function get_roles(){
        $this->db->select('id,description');
        $this->db->from(TBL_ROLES);
        $this->db->where('status','1');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    

//common functions - end
//
//        
//controller functions related model functions    
    //used in : add_cost_centres
    function add_cost_centres_item($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_COST_CENTRES);
        $this->db->where(array('code'=>$add_array['cost_centres_code']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'code'=>  $add_array['cost_centres_code'],
                'description' => $add_array['cost_centres_name'],
                'address' => $add_array['cost_centres_address'],
                'is_dispatch_to' => $add_array['is_dispatch_to'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_COST_CENTRES,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : view_cost_centre
    function get_cost_centres_list(){
        $this->db->select('*');
        $this->db->from(TBL_COST_CENTRES);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_cost_centres_by_id
    function view_cost_centre_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_COST_CENTRES);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }


    //used in : edit_cost_centre
    function edit_cost_centres_item($edit_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_COST_CENTRES);
        $this->db->where(array('code'=>$edit_array['cost_centres_code']));
        $this->db->where_not_in('id',$edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'code'=>  $edit_array['cost_centres_code'],
                'description' => $edit_array['cost_centres_name'],
                'address' => $edit_array['cost_centres_address'],
                'is_dispatch_to' => $edit_array['is_dispatch_to'],
                'status' => $edit_array['is_active']
                );
            
            $this->db->where('id',$edit_array['id']);
            if($this->db->update(TBL_COST_CENTRES,$insert_array)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
        
    }
    
    //used in : remove_cost_centre
    function romove_cost_centre($remove_array){
        
            $this->db->where('id',$remove_array['id']);
            if($this->db->delete(TBL_COST_CENTRES)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
    }
    
    //used in : add_designation
    function add_designation_item($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_DESIGNATIONS);
        $this->db->where(array('description'=>$add_array['designation']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'description'=>  $add_array['designation'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_DESIGNATIONS,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    //used in : view_menus
    function get_designation_list(){
        $this->db->select('*');
        $this->db->from(TBL_DESIGNATIONS);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in :view_menu_by_id
    function view_designation_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_DESIGNATIONS);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    
    function edit_designation_item($edit_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_DESIGNATIONS);
        $this->db->where(array('description'=>$edit_array['designation']));
        $this->db->where_not_in('id',$edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'description'=>  $edit_array['designation'],
                'status' => $edit_array['is_active']
                );
            
            $this->db->where('id',$edit_array['id']);
            if($this->db->update(TBL_DESIGNATIONS,$insert_array)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
    }
    
    
    function romove_designation($remove_array){
        $this->db->where('id',$remove_array['id']);
            if($this->db->delete(TBL_DESIGNATIONS)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
    }
    
    
    //for manage user
    
    //used in : view_users
    function get_users_list(){
        $this->db->select('pr.id,pr.user_id,pr.user_name,pr.password,pr.email,pr.status,spr.user_name as supervisor');
        $this->db->from(TBL_USERS.' pr');
        $this->db->join(TBL_USERS.' as spr','pr.supervisor = spr.user_id','left');
        $this->db->order_by('user_name');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : add_users
    function add_user($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where(array('user_id'=>$add_array['user_id']));
        $result = $this->db->get()->result();
        
        $costcentre = $add_array['costcentre'];
        $designation = $add_array['designation'];
        $department = $add_array['department'];
        $user_role = $add_array['user_role'];
        
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'user_id'=>  $add_array['user_id'],
                'user_name'=>  $add_array['user_name'],
                'password'=>  md5($add_array['password']),
                'email'=>  $add_array['email'],
                'supervisor'=>  $add_array['supervisor'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_USERS,$insert_array)){
               //$inserted_id = $this->db->insert_id();
               
               //to add cost centres
               $this->insert_costsentres(TBL_USERS_COSTCENTRES,$add_array['user_id'],$costcentre);
               
               //to add designations
               $this->insert_designations(TBL_USERS_DESIGNATIONS,$add_array['user_id'],$designation);
               
               //to add designations
               $this->insert_departments(TBL_USERS_DEPARTMENTS,$add_array['user_id'],$department);
               
               //to add roles
               $this->insert_roles(TBL_USERROLES,$add_array['user_id'],$user_role);
               
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    //used in : add_user
    function insert_costsentres($table,$user_id,$costcentres_array){
        $insert_array=array();
        
        if(!empty($costcentres_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($costcentres_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'costcentre_code'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                
                
                $i++;
            }
            
            $this->db->where('user_id',$user_id);
            $this->db->delete($table);
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    //used in : add_user
    function insert_designations($table,$user_id,$designations_array){
        $insert_array=array();
        
        if(!empty($designations_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($designations_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'designation_id'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                
                
                $i++;
            }
            $this->db->where('user_id',$user_id);
            $this->db->delete($table);
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    
    //used in : add_user
    function insert_roles($table,$user_id,$users_array){
        $insert_array=array();
        
        if(!empty($users_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($users_array as $row){
                
                $this->add_user_rights_for_user_role($row,$user_id);
                
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'role_id'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                
                
                $i++;
            }
            $this->db->where('user_id',$user_id);
            $this->db->delete($table);
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    //used in : insert_roles
    function add_user_rights_for_user_role($role_id,$user_id){
        
        
        $this->db->select('sbmf.id as sub_menu_func_id');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU.' sbmf');
        $this->db->join(TBL_RIGHTS_FOR_USERROLES.' rr', 'sbmf.sub_menu_id = rr.submenu_id');
        $this->db->where('rr.role_id', $role_id);
        $sbm_funcs = $this->db->get()->result_array();
        
        
        $insert_array = array();
        
        foreach($sbm_funcs as $func){
            $this->db->select('*');
            $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS);
            $this->db->where('user_id',$user_id);
            $this->db->where('submenu_function_id', $func['sub_menu_func_id']);
            $result = $this->db->get()->result_array();
            
            if(empty($result)){
                $temp_array = array(
                    'user_id' =>$user_id,
                    'submenu_function_id' =>$func['sub_menu_func_id'],
                    'status' =>1,
                );
                array_push($insert_array,$temp_array);
            }else{
                $this->db->where('user_id',$user_id);
                $this->db->where('submenu_function_id',$func['sub_menu_func_id']);
                $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS,array('status' =>1));
            }
        }
        
        if(!empty($insert_array)){
            $this->db->insert_batch(TBL_RIGHTS_OF_SUBMENU_FUNCS,$insert_array);
        }
        
        
    }
    

    //used in : add_user
    function insert_departments($table,$user_id,$departments_array){
        $insert_array=array();
        
        if(!empty($departments_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($departments_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'department_code'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                
                
                $i++;
            }
            $this->db->where('user_id',$user_id);
            $this->db->delete($table);
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    
    //used in : view_user_by_id
    function view_user_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_user_by_id
    function view_user_costsentre_by_id($id){
        $this->db->select('costcentre_code');
        $this->db->from(TBL_USERS_COSTCENTRES);
        $this->db->where('user_id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_user_by_id
    function view_user_designation_by_id($id){
        $this->db->select('designation_id');
        $this->db->from(TBL_USERS_DESIGNATIONS);
        $this->db->where('user_id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_user_by_id
    function view_user_department_by_id($id){
        $this->db->select('department_code');
        $this->db->from(TBL_USERS_DEPARTMENTS);
        $this->db->where('user_id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_user_by_id
    function view_user_roles_by_id($id){
        $this->db->select('role_id');
        $this->db->from(TBL_USERROLES);
        $this->db->where('user_id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : edit_users
    function edit_user($edit_array){
        
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_USERS);
        $this->db->where('user_id',$edit_array['user_id']);
        $this->db->where_not_in('id', $edit_array['id']);
        $result = $this->db->get()->result();
        
        $costcentre = $edit_array['costcentre'];
        $designation = $edit_array['designation'];
        $departments = $edit_array['department'];
        $user_role = $edit_array['user_role'];
        
        if(!$result){
            $response=0;
            
            //to create add array
            $update_array = array(
                'user_id'=>  $edit_array['user_id'],
                'user_name'=>  $edit_array['user_name'],
                'password'=>  md5($edit_array['password']),
                'email'=>  $edit_array['email'],
                'supervisor'=>  $edit_array['supervisor'],
                'status' => $edit_array['is_active']
                );
            
            //to get old user id
               
            $this->db->select('user_id');
            $this->db->from(TBL_USERS);
            $this->db->where('id',$edit_array['id']);
            $last_result = $this->db->get()->result_array();
            
            //remove old assigned cost centers
                $this->db->where('user_id',$last_result[0]['user_id']);
                $this->db->delete(TBL_USERS_COSTCENTRES);
            
            //remove old assigned departments
                $this->db->where('user_id',$last_result[0]['user_id']);
                $this->db->delete(TBL_USERS_DESIGNATIONS);

            //remove old assigned departments
                $this->db->where('user_id',$last_result[0]['user_id']);
                $this->db->delete(TBL_USERS_DEPARTMENTS);
                
            //remove old assigned roles
                $this->db->where('user_id',$last_result[0]['user_id']);
                $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS,array('status'=>0));
                
                $this->db->where('user_id',$last_result[0]['user_id']);
                $this->db->delete(TBL_USERROLES);
                
                
                
                
            //to update
            $this->db->where('id', $edit_array['id']);
            if($this->db->update(TBL_USERS,$update_array)){
                
                //to update supervisor ids wich are = $last_result[0]['id']
                $this->db->where('supervisor', $last_result[0]['user_id']);
                if($this->db->update(TBL_USERS,array('supervisor'=>$edit_array['user_id']))){
                    
                    //to edit cost centres
                    $this->edit_costsentres(TBL_USERS_COSTCENTRES,$edit_array['user_id'],$costcentre);

                    //to edit designations
                    $this->edit_designations(TBL_USERS_DESIGNATIONS,$edit_array['user_id'],$designation);
                    
                    //to edit designations
                    $this->edit_departments(TBL_USERS_DEPARTMENTS,$edit_array['user_id'],$departments);
                    
                    //to edit designations
                    $this->edit_roles(TBL_USERROLES,$edit_array['user_id'],$user_role);
               
                    return 1;//insert success
                }else{
                    return 0;//failed to insert
                }
                
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
    }
    
    //used in : edit_user
    function edit_costsentres($table,$user_id,$costcentres_array){
        $insert_array=array();
        
        if(!empty($costcentres_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($costcentres_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'costcentre_code'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                $i++;
            }
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    //used in : edit_user
    function edit_designations($table,$user_id,$designations_array){
        $insert_array=array();
        
        if(!empty($designations_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($designations_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'designation_id'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                $i++;
            }
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    //used in : edit_user
    function edit_departments($table,$user_id,$departments_array){
        $insert_array=array();
        
        if(!empty($departments_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($departments_array as $row){
                $is_primary=0;
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                $temp_array = array(
                    'user_id'=>$user_id,
                    'department_code'=>$row,
                    'is_primary'=>$is_primary,
                    'status'=>1
                );
                
                array_push($insert_array, $temp_array);
                
                $i++;
            }
            $this->db->insert_batch($table,$insert_array);
        }
    }
    
    
    //used in : edit_user
    function edit_roles($table,$user_id,$users_array){
        $insert_array=array();
        
        if(!empty($users_array) && $user_id!='' && $table!=''){
            $i=0;//for set first row only primary
            
            
            foreach($users_array as $row){
                $this->edit_user_rights_for_user_role($row,$user_id);
                $is_primary=0;
                
                if($i == 0){$is_primary=1;}else{$is_primary=0;}
                
                $this->db->select('*');
                $this->db->from(TBL_USERROLES);
                $this->db->where(array('user_id'=>$user_id,'role_id'=>$row));
                $result_role = $this->db->get()->result_array();
                
                    if(empty($result_role)){
                            $temp_array = array(
                            'user_id'=>$user_id,
                            'role_id'=>$row,
                            'is_primary'=>$is_primary,
                            'status'=>1
                        );

                        array_push($insert_array, $temp_array);
                    }else{
                        $this->db->where(array('user_id'=>$user_id,'role_id'=>$row));
                        $this->db->update(TBL_USERROLES,array('status'=>1,'is_primary'=>$is_primary));
                    }
                    
                
                
                $i++;
            }
            
            if(!empty($insert_array)){
                $this->db->insert_batch($table,$insert_array);
            }
            
        }
    }
    
    //used in : edit_roles
    function edit_user_rights_for_user_role($role_id,$user_id){
        
        
        $this->db->select('sbmf.id as sub_menu_func_id');
        $this->db->from(TBL_FUNCTIONS_OF_SUBMENU.' sbmf');
        $this->db->join(TBL_RIGHTS_FOR_USERROLES.' rr', 'sbmf.sub_menu_id = rr.submenu_id');
        $this->db->where('rr.role_id', $role_id);
        $sbm_funcs = $this->db->get()->result_array();
        
        
        $insert_array = array();
        
        foreach($sbm_funcs as $func){
            $this->db->select('*');
            $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS);
            $this->db->where('user_id',$user_id);
            $this->db->where('submenu_function_id', $func['sub_menu_func_id']);
            $result = $this->db->get()->result_array();
            
            if(empty($result)){
                $temp_array = array(
                    'user_id' =>$user_id,
                    'submenu_function_id' =>$func['sub_menu_func_id'],
                    'status' =>1,
                );
                array_push($insert_array,$temp_array);
            }else{
                $this->db->where('user_id',$user_id);
                $this->db->where('submenu_function_id',$func['sub_menu_func_id']);
                $this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS,array('status' =>1));
            }
        }
        
        if(!empty($insert_array)){
            $this->db->insert_batch(TBL_RIGHTS_OF_SUBMENU_FUNCS,$insert_array);
        }
        
        
    }
    
    
    function remove_user($remove_array){
        $this->db->select('user_id');
        $this->db->from(TBL_USERS);
        $this->db->where('id',$remove_array['id']);
        $last_result = $this->db->get()->result_array();
        
        $this->db->where('user_id',$last_result[0]['user_id']);
        //to remove cost centres
        if($this->db->delete(TBL_USERS_COSTCENTRES)){
            //to remove designations
            $this->db->where('user_id',$last_result[0]['user_id']);
            if($this->db->delete(TBL_USERS_DESIGNATIONS)){
                //to remove departments
                $this->db->where('user_id',$last_result[0]['user_id']);
                if($this->db->delete(TBL_USERS_DEPARTMENTS)){
                    
                    //remove user rights
                    $this->db->where('user_id',$last_result[0]['user_id']);
                    if($this->db->delete(TBL_RIGHTS_OF_SUBMENU_FUNCS)){
                        
                        //remove user roles
                        $this->db->where('user_id',$last_result[0]['user_id']);
                        if($this->db->delete(TBL_USERROLES)){
                            //to remove user
                            $this->db->where('id',$remove_array['id']);
                            if($this->db->delete(TBL_USERS)){
                                return 1;//insert success
                            }else{
                                return 0;//failed to insert
                            }
                        }
                    }
                    
                }
                
            }
        }
            
    }
    
    
    //for manage departments
    
    //used in : add_department
    function add_department($add_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_DEPARTMENTS);
        $this->db->where(array('code'=>$add_array['department_code']));
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'code'=>  $add_array['department_code'],
                'description'=> $add_array['department_name'],
                'status' => $add_array['is_active']
                );

           if($this->db->insert(TBL_DEPARTMENTS,$insert_array)){
               return 1;//insert success
           }else{
               return 0;//failed to insert
           }
        }else{
            return 2;//already exixt
        }
    }
    
    //used in : view_departments
    function get_department_list(){
        $this->db->select('*');
        $this->db->from(TBL_DEPARTMENTS);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : view_departments_by_id
    function view_department_by_id($id){
        $this->db->select('*');
        $this->db->from(TBL_DEPARTMENTS);
        $this->db->where('id',$id);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : edit_department
    function edit_department($edit_array){
        //to check as is existing 
        $this->db->select('*');
        $this->db->from(TBL_DEPARTMENTS);
        $this->db->where(array('code'=>$edit_array['department_code']));
        $this->db->where_not_in('id', $edit_array['id']);
        $result = $this->db->get()->result();
        
        if(!$result){
            //to create add array
            $insert_array = array(
                'code'=>  $edit_array['department_code'],
                'description'=> $edit_array['department_name'],
                'status' => $edit_array['is_active']
                );
            
            $this->db->where('id',$edit_array['id']);
            if($this->db->update(TBL_DEPARTMENTS,$insert_array)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
        }else{
            return 2;//already exixt
        }
    }
    
    
    //used in : remove_department
    function romove_department($remove_array){
        $this->db->where('id',$remove_array['id']);
            if($this->db->delete(TBL_DEPARTMENTS)){
                return 1;//insert success
            }else{
                return 0;//failed to insert
            }
    }
    
    //used in : get_all_assign_user_rights_by_ajax
    function get_assigned_user_rights($user_id='',$submenu_id=''){
        $this->db->select('psfr.*');
        $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS.' psfr');
        $this->db->join(TBL_FUNCTIONS_OF_SUBMENU.' psf','psfr.submenu_function_id = psf.id');
        $this->db->join(TBL_SUB_MENU.' psm','psf.sub_menu_id = psm.id');
        
        if($submenu_id != ''){
            $this->db->where('psf.sub_menu_id', $submenu_id);
        }
        if($user_id != ''){
            $this->db->where('psfr.user_id', $user_id);
        }
        $this->db->where('psfr.status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_all_assign_user_rights_by_ajax, get_sub_menus_by_ajax
    function get_assigned_roles($user_id=''){
        $this->db->select('*');
        $this->db->from(TBL_USERROLES);
        $this->db->where('user_id',$user_id);
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_all_assign_user_rights_by_ajax, get_sub_menus_by_ajax
    function get_assigned_sub_menus($roles=''){
        if(empty($roles)){$roles = array(0);}
        
        $this->db->select('*');
        $this->db->from(TBL_RIGHTS_FOR_USERROLES);
        //if(!empty($roles)){
            $this->db->where_in('role_id',$roles);
        //}
        
        $this->db->where('status',1);
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : get_all_assign_user_rights_by_ajax
    function get_available_rights($submenu_id='',$module , $available_submenu_array){
        if(empty($available_submenu_array)){$available_submenu_array = array(0);}
        
        //create new array to hols final output
        $av_rights = array();
        
        //get all the sub menus
        $this->db->select('*');
        $this->db->from(TBL_SUB_MENU);
        if($submenu_id != ''){
            $this->db->where('id', $submenu_id);
        }else{
            $this->db->where_in('id', $available_submenu_array);
        }
        
        
        $this->db->order_by('name');
        $result = $this->db->get()->result_array();
        
        //var_dump($this->db->last_query());
        $av_rights = $result; 
        
        
        //to get the available rights for each sub menus
        $i=0;
        
        $submenu_array = array();
        
        foreach($result as $row){
            $temp = array();
            
            foreach($module as $mod){
                
                
                //get all the rights for the perticular submenu
                $this->db->select('*');
                $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
                $this->db->where('sub_menu_id', $row['id']);
                $this->db->where('module_id', $mod['id']);
                $result1 = $this->db->get()->result_array();
                
                if(!empty($result1)){
                   $mod['functions'] = $result1; 
                }else{
                   $mod['functions'] = '';  
                }
                
                
                $temp[$mod['id']] = $mod;
                
                
            }
            
            
            
            $row = $temp;
            //add the rights array to the submenu array
            $av_rights[$i]['functions'] = $row;
            $i++;
        }
        
        
        return $av_rights;
    }
    
    //used in : get_all_assign_user_rights_by_ajax
    function get_available_modules(){
        
        $this->db->select('*');
        $this->db->from(TBL_MODULES);
        $this->db->order_by('description');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
    //used in : update_module_rights
    function edit_module_rights($data){
        $modules=array();
        $arr= array();
        $update =0;
        $insert_array=array();
        $functions_list = '';
        $inactive_func_list = '';
        $i=0;$j=0;
        $comma = '';$commaj='';
        
        $user_id = $data['user_id'];
        $sub_menu = $data['sub_menu'];
        
        if(!empty($data['modules'])){$modules = explode(',', $data['modules']);}
        
        
        if(!empty($modules)){
           foreach($modules as $arra){
                $arr[$arra]=$arra;
            } 
        }else{
            $arr = array();
        }
        
        
        
        $this->db->select('id');
        $this->db->from(TBL_MODULES);
        $modules_result = $this->db->get()->result_array();
        

        foreach($modules_result as $module){ //to get the submodule functions for each submenus
            
            $this->db->select('*');
            $this->db->from(TBL_FUNCTIONS_OF_SUBMENU);
            $this->db->where('sub_menu_id',$sub_menu);
            $this->db->where('module_id',$module['id']);
            $result = $this->db->get()->result_array();
            
            if(!empty($result)){
               
                foreach($result as $res){//to get the function id if each submodules functions if given submenu
                    
                    if($i > 0 ){$comma = ','; }if($j > 0 ){$commaj = ','; }//to remove first comma.
                    if(in_array( $module['id'] , $arr)){
                        $functions_list = $functions_list.$comma.$res['id'];
                        $i++;
                    }else{
                        $inactive_func_list = $inactive_func_list.$commaj.$res['id'];
                        $j++;
                    }
                    
                    
                }
                
            }
        }
        
        if($functions_list!=''){$functions_array = explode(',', $functions_list);}
        if($inactive_func_list!=''){$inactive_func_array = explode(',', $inactive_func_list);}
        
        
        //to iactive the unassign funcs
        if(!empty($inactive_func_array)){
            $this->db->where_in('submenu_function_id',$inactive_func_array);
            if($this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>0))){
                $update++;
            }
        }
        
        
        if(!empty($functions_array)){
            foreach($functions_array as $func){//to add the function to the functional rights table
                        
                $this->db->select('*');
                $this->db->from(TBL_RIGHTS_OF_SUBMENU_FUNCS);
                $this->db->where('submenu_function_id',$func);
                $this->db->where('user_id',$user_id);
                $right_result = $this->db->get()->result_array(); 

                if(!empty($right_result)){
                    
                    $this->db->where(array('submenu_function_id'=>$func,'user_id'=>$user_id));
                    if($this->db->update(TBL_RIGHTS_OF_SUBMENU_FUNCS, array('status'=>1))){
                        $update++;
                    }
                }else{
                    $temp_array = array(
                        'user_id'=>$user_id,
                        'submenu_function_id'=>$func,
                        'status'=>1
                    );
                    array_push($insert_array, $temp_array);
                }

            }
        }
        
        
        //to insert new rights
        if(!empty($insert_array)){
            if($this->db->insert_batch(TBL_RIGHTS_OF_SUBMENU_FUNCS,$insert_array)){
                $update++;
            }
        }
        
        
        if($update>0){
            return 1;
        }else{
            return 0;
        }
    }
    
    
    
}

/* End of file user.php */
/* Location: ./application/models/user.php */