<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


class Test extends CI_Controller {

 	 function __construct(){
 		 parent::__construct();
 		 $this->load->model('tes');
 	 }


	 //used in : this controller 
	 function error_responce($reason=''){ 

 		 $response_array = array('response' => 0,'reason' => $reason );   
		 echo json_encode($response_array); exit; 

	 }  

	 //used in : this controller 
  	 function success_responce($reason=''){ 

 		 $response_array = array('response' => 1,'reason' => $reason); 
		 echo json_encode($response_array); exit; 

	 }


		//used in : main navigation as a submenu item 
	 function manage_test(){ 
		 $this->session->set_userdata('controller', 'test'); 
		 $this->session->set_userdata('function', 'manage_test'); 

 		 //Enter your contents here 

		 //Enter your contents here 


		 $this->template->set(); 
		 $this->template->current_view = 'test/manage_test'; 
		 $this->template->render(); 
	 } 


 		////used in : ////application/views/includes/js/ manage_test_js.php 
	 function add_test(){ 
		 //Enter your contents here 

		 //Enter your contents here 


	 } 


 }?> 
 
