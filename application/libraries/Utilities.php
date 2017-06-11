<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities 
{
	function validate_access( $categories_assigned = array(), $category_id)
	{
		if ( $categories_assigned )
		{
			if ( in_array($category_id, $categories_assigned) )
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
        
        function generate_main_menu(){
            
        }
        
//	function generate_main_menu()
//	{
//		$this->CI =& get_instance();
//		$this->CI->load->model('user','',TRUE);
//
//		//getting assigned categories id array
//		$categories_array = $this->CI->session->userdata('categories_assigned');
//
//		//loop over category id array
//		foreach( $categories_array as $category )
//		{
//			//getting details for current category
//			$category_details = $this->CI->user->get_assigned_category_details($category);
//
//			//set active category
//			$active_category = ($this->CI->session->userdata('current_category_id') == $category)? ' class="active open"':'';
//
//
//			$subcategories = $this->CI->user->get_assigned_subcategories($category_details['category_id']);
//			$subcategory_details = $this->CI->user->get_assigned_subcategory_details();
//
//			if($subcategories)
//			{
//				echo '<li'. $active_category .'><a href="'. site_url($subcategories[0]['subcategory_path']) .'"><i class="'. (($category_details['category_name'] == 'Home')?'icon-home':(($category_details['category_name'] == 'System')?'icon-cog':'icon-edit')) . '"></i><span class="menu-text">'. $category_details['category_name'] .'</span>';		
//			}
//			else
//			{
//				echo '<li'. $active_category .'><a href="'. site_url($category_details['category_path']) .'"><i class="'. (($category_details['category_name'] == 'Home')?'icon-home':(($category_details['category_name'] == 'System')?'icon-cog':'icon-edit')) . '"></i><span class="menu-text">'. $category_details['category_name'] .'</span>';				
//			}
//
//			if($subcategories)
//			{
//				echo '<b class="arrow icon-angle-down"></b></a>';
//				echo '<ul class="submenu">';
//				foreach($subcategories as $subcategory )
//				{
//					//setting class active
//					$active_subcategory = ($subcategory_details['subcategory_id'] == $subcategory['subcategory_id'])? ' class="active"':'';
//					echo '<li'. $active_subcategory .'><a href="'. site_url($subcategory['subcategory_path']) .'"><i class="icon-double-angle-right"></i>'. $subcategory['subcategory_name'] .'</a></li>';		
//				}
//				echo '</ul>';
//			}
//			else
//			{
//				echo '</a>';
//			}
//			echo '</li>';;
//		}
//	}
	
    //Reformat mySQL date format (YYYY-MM-DD HH:MM:SS) to the British Standard format DD/MM/YYYY
	function date_display_format($datetime=false) 
	{
		if ($datetime)
		{
			$dt = date_create($datetime); // shift SQL date into PHP format
			return date_format($dt, 'j/m/Y'); // format and return
		} else {
			return "never";
		}
	}

	function date_Add($interval, $number, $date) 
	{

		$date_time_array = getdate($date);
		$hours = $date_time_array['hours'];
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];

		switch ($interval) 
		{
		
			case 'yyyy':
				$year+=$number;
				break;
			case 'q':
				$year+=($number*3);
				break;
			case 'm':
				$month+=$number;
				break;
			case 'y':
			case 'd':
			case 'w':
				$day+=$number;
				break;
			case 'ww':
				$day+=($number*7);
				break;
			case 'h':
				$hours+=$number;
				break;
			case 'n':
				$minutes+=$number;
				break;
			case 's':
				$seconds+=$number; 
				break;            
		}
		
		$timestamp= mktime($hours,$minutes,$seconds,$month,$day,$year);
		return $timestamp;
	}
	
	function elapsed_time( $from_stamp = FALSE , $now_stamp = FALSE)
	{
		if ( $from_stamp && $now_stamp )
		{
			 $from_date_time = $from_stamp;
			 $to_date_time = $now_stamp;
			 $dateDiff = strtotime($to_date_time) - strtotime($from_date_time); 
			 
			 $fullHours   = floor($dateDiff/3600);
			 $fullMinutes = floor(($dateDiff-$fullHours*3600)/60);
			 $fullSeconds = floor($dateDiff-$fullHours*3600-$fullMinutes*60);

			//return date("$fullHours:$fullMinutes:$fullSeconds"); 
			return date("$fullHours.$fullMinutes"); 
		}
	}


	function return_page( $store_refered = FALSE )
	{
		$this->CI =& get_instance();
		$this->CI->load->library('user_agent');

		if ($store_refered)
		{
			if ($this->CI->session->userdata('refered_from') == FALSE)
			{
				if ( $this->CI->agent->is_referral() )
				{
					$this->CI->session->set_userdata('refered_from', $this->CI->agent->referrer());		
				}
			}

			//$this->CI->session->set_userdata('refered_from', $this->CI->agent->referrer());		
		}
		else
		{
			if ($this->CI->session->userdata('refered_from') == TRUE)
			{
				$refered_path = $this->CI->session->userdata('refered_from');
				$this->CI->session->unset_userdata('refered_from');
				redirect($refered_path);
			}
		}
	}

	//Clear return page session
	function reset_return_page()
	{
		$this->CI =& get_instance();
		$this->CI->session->unset_userdata('refered_from');
	}

	//Converts a given integer (in range [0..1T-1], inclusive) into alphabetical format ("one", "two", etc.)
	function convert_number_to_text($number) 
	{ 
		if (($number < 0) || ($number > 999999999)) 
		{ 
		throw new Exception("Number is out of range");
		} 

		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);     /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);       /* Tens (deca) */ 
		$n = $number % 10;               /* Ones */ 

		$res = ""; 

		if ($Gn) 
		{ 
			$res .= convert_number($Gn) . " Million"; 
		} 

		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($kn) . " Thousand"; 
		} 

		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($Hn) . " Hundred"; 
		} 

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
			"Seventy", "Eigthy", "Ninety"); 

		if ($Dn || $n) 
		{ 
			if (!empty($res)) 
			{ 
				$res .= " and "; 
			} 

			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 

				if ($n) 
				{ 
					$res .= "-" . $ones[$n]; 
				} 
			} 
		} 

		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 

		return $res; 
	} 

	function reverse_htmlentities($string)
	{
        $string = str_replace ( '&amp;', '&', $string );
        $string = str_replace ( '&#039;', '\'', $string );
        $string = str_replace ( '&quot;', '\"', $string );
        $string = str_replace ( '&lt;', '<', $string );
        $string = str_replace ( '&gt;', '>', $string );
        $string = str_replace ( '&AMP;', '&', $string );
        $string = str_replace ( '&#039;', '\'', $string );
        $string = str_replace ( '&QUOT;', '\"', $string );
        $string = str_replace ( '&LT;', '<', $string );
        $string = str_replace ( '&GT;', '>', $string );
        
        return $string;    
    }

	function limit_words($string, $word_limit)
	{
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}	

	function print_r_html ($arr) 
	{
	   echo '<pre>';
	   print_r($arr);
	   echo '</pre>';	
	}

	function random_hex_color()
	{
		return sprintf("%02X%02X%02X", mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
	}	

	function validate_checkbox($value)
	{
		return ($value=='')? 0:1;
	}
}

?>
