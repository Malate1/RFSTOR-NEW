<?php 
class User_model extends CI_Model
{
	function __construct() {

		parent::__construct();
	}

	public function getuserDetails($emp_id)
	{
		$query = $this->db->get_where('users2', array('emp_id' => $emp_id));
 		return $query->row();
	}

	public function getuserDetails2($user_id)
	{
		$query = $this->db->get_where('users2', array('user_id' => $user_id));
 		return $query->row();
	}



}