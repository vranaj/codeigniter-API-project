<?php

    function is_logged_in(){
        $CI =& get_instance();
		
			if($CI->router->class != 'users' and $CI->router->method!='index'){
				$CI->load->library('session');
				$CI->load->model('user');
				if(!empty($CI->session->userdata['log_data'][0])){
					$user_id = $CI->session->userdata['log_data'][0]['user_id'];
					$curr_class = $CI->router->class;
					$sub_menu = $CI->session->userdata['function'];
					$curr_method = $CI->router->method;
					//print_r("<pre>");print_r($CI->session->userdata);
					
					if($CI->user->check_authority($user_id,$curr_class,$sub_menu,$curr_method) == false){
						$CI->template->set_message("You do not have privileges to access", "error");
						redirect(site_url($curr_class.'/'.$sub_menu));
					}
				}else{
					redirect(site_url());
				}
				
				
			}
		
		
		
    }
    



?>
