<?php

class MY_Model extends CI_Model{

    //Database tables
    public $users_table = 'procurement_users';

    function __construct() {
        parent::__construct();

    }

    function return_result($query){
        if ($query->num_rows () > 0) {
            return $query->result_array ();
        } else {
            return FALSE;
        }
    }

    function get_date(){
        return date ( "Y-m-d" );
    }
}
