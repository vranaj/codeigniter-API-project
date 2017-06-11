<?php
class Audit extends CI_Model 
{

	function __construct()
	{
		parent::__construct();
	}
	
	function log( $unique_id = FALSE, $identifier = FALSE, $information = FALSE, $sql = FALSE)
	{
		if ($unique_id && $identifier &&  $information)
		{
			$this->db->set('user_id', $this->session->userdata('user_id'));
			$this->db->set('ip_address', $this->input->ip_address());
			$this->db->set('controller', $this->router->class);
			$this->db->set('method', $this->router->method);
			$this->db->set('unique_id', $unique_id);
			$this->db->set('identifier', $identifier);
			$this->db->set('information', $information);
	
			//echo $this->db->last_query() . "<br/><br/>";
		
			if ($sql)
			{
				$this->db->set('sql', $sql );
			}

			$this->db->insert('audit');
		}
	}

    function get($return_count = FALSE, $record_count = 500, $offset = 0)
    {
        $this->db->select('audit.id, date_stamp, user_id, ip_address, controller, method, unique_id, identifier, information, sql, username');
        $this->db->from('audit');
		$this->db->join('users', 'users.id = audit.user_id');

        $this->db->limit($record_count);
        $this->db->order_by('id', 'desc');

        if ( $record_count )
        {
            $this->db->limit($record_count, $offset);
        }

        $query = $this->db->get();

		//echo $this->db->last_query() . "<br/><br/>";


        if ( ! $return_count )
		{
            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return $query->num_rows();
        }
    }

    function get_audit_unique_id($unique_id = FALSE, $identifier = FALSE)
    {
        $this->db->select('*');
        $this->db->from('audit');
        $this->db->join('users', 'users.id = audit.user_id');
        $this->db->where('unique_id', $unique_id);
        $this->db->order_by('audit.id', 'DESC');

        if($identifier)
        {
            $this->db->like('identifier', $identifier, 'left');
        }

        $query = $this->db->get();

        //echo $this->db->last_query() . "<br/><br/>";

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Add data into database
     * @access public
     * @param mixed $table (table name)
     * @param mixed $data (insert data array)
     * @return int last inserted id from the database.
     * @author pradeep - <pradeep@tryonics.com>
     * */
    public function add($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
}

/* End of file audit.php */
/* Location: ./application/models/audit.php */