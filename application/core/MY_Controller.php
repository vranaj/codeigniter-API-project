<?php if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 *  A base controller class including common functions
 *
 * @author		Sankalpana
 */
class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        // enable profiler if not an Ajax request
        if (!$this->input->is_ajax_request()) {
           //$this->output->enable_profiler(ENVIRONMENT == 'development');
        }
    }

    /**
     * Validate access to current module
     *
     * @param $module_id
     * @return bool
     */
    function validate_access($module_id)
    {

        $this->session->set_userdata('current_category_id', $module_id);

        //$modules_assigned = array();
        $modules_assigned = $this->session->userdata('categories_assigned');

        return true;

        /*if ( $modules_assigned )
        {
            if ( !in_array($module_id, $modules_assigned) )
            {
                redirect(site_url("users/login_error"), 'refresh');
            }
            else
            {
                return true;
            }
        }else{
           redirect(site_url("users/login_error"), 'refresh');
        }*/
    }

    /**
     * Render view with Ocular Layout Library
     *
     * @param array $data
     * @param bool|false $is_popup
     */
    public function render($data = array(),$is_popup = false)
    {

        $this->template->set($data);

        if($is_popup)
            $this->template->render('popup');
        else
            $this->template->render();
    }

    /**
     * Sending an Email
     *
     * @param $email
     * @param $subject
     * @param $message
     */
    function send_email($email, $subject, $message)
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");
        $this->email->from('test@tryonics.com', 'UA Stationary System');
        $this->email->to($email);
        $this->email->cc('');
        $this->email->bcc('');
        $this->email->subject($subject);
        $this->email->message($message);
//      TODO: Uncomment below line before pushing to the production server
      //$this->email->send();
//      TODO: Comment below line before pushing to the production server
//      echo "$message";
//      echo $this->email->print_debugger();

    }
}

/* End of file MY_Controller.php */
/* Location: ./system/application/core/MY_Controller.php */