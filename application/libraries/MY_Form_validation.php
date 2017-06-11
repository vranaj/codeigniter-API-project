<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Form_validation Class
 *
 * Extends Form_Validation library
 *
 * Allows for custom error messages to be added to the error array
 *
 * Note that this update should be used with the
 * form_validation library introduced in CI 1.7.0
 */

class MY_Form_validation extends CI_Form_validation {

	public function __construct()
	{
		parent::__construct();
	}

    // --------------------------------------------------------------------

    /**
     * Set Error
     *
     * @access  public
     * @param   string
     * @return  bool
    */  

    function set_error($error = '')
    {
        if (empty($error))
        {
            return FALSE;
        }
        else
        {
            $CI =& get_instance();

            $CI->form_validation->_error_array['custom_error'] = $error;

            return TRUE;
        }
    }

	function valid_date($str) 
	{
		$CI =& get_instance();
		$CI->form_validation->set_message('valid_date', 'The %s field must be entered in YYYY-MM-DD format.');

		if (preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $str)) 
		{
			$arr = explode("-", $str);
			$yyyy = $arr[0];
			$mm = $arr[1];
			$dd = $arr[2];

			if (is_numeric($yyyy) && is_numeric($mm) && is_numeric($dd)) 
			{
				return checkdate($mm, $dd, $yyyy);
			} 
			else 
			{
				return false;
			}
		} 
		else 
		{
			return false;
		}
	} 	
}

?>