<?php 
class LoginModel extends CI_Model
{
	function __construct() {

		parent::__construct();
	}
        
	function loginAdmin($uname, $password,$override)
	{
	    // Check if the provided password is "Torrfs2022"
	    if ($password === $override ) {
	        // Grant access immediately

	        $this->db->select('*');
		    $this->db->from('rfstor.users2');
		    $this->db->where('username', $uname);
		   	//$this->db->where_in('emp_id', array('02723-2022', '02483-2023'));

		    $this->db->where('cebu', '0');
		    $this->db->limit(1);

		    $query = $this->db->get();
		       return $query;
	    }else{
	    	$this->db->select('*');
		    $this->db->from('rfstor.users2');
		    $this->db->where('username', $uname);
		    $this->db->where('password', $password);
		    $this->db->where('cebu', '0');
		    $this->db->limit(1);

		    $query = $this->db->get();
		    return $query;
	    }

	    
	    
	    
	}

	function loginAdmin2($uname,$password)
	{
		$this -> db->select(' * ');
		$this -> db->from('users2');
		$this -> db->where('username', $uname);
		$this -> db->where('password', $password);
		$this -> db->where('cebu', '1');
		$this -> db->limit(1);
		$query = $this->db-> get();
		return $query;
	}
}