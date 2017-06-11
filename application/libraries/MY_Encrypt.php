<?php
class MY_Encrypt extends CI_Encrypt
{
     
	function __construct()
	{
		parent::__construct();
		//$this->set_cipher('MCRYPT_RIJNDAEL_128');
		//$this->set_mode('MCRYPT_MODE_CFB');
	}


	function url_encode($string)
	{
		
		$enc = $this->encode($string);
		
		$new_enc = strtr(
            base64_encode($enc),
            array(
                '+' => '.',
                '=' => '-',
                '/' => '~'
            )
        );
		
		return $new_enc;
	}


	function url_decode($string)
	{

		$dec =  base64_decode(strtr(
                $string,
                array(
                    '.' => '+',
                    '-' => '=',
                    '~' => '/'
                )
            ));
		return $this->decode($dec);

	}
	
	
}
