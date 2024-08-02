	 <?php
	 class Employee_Model extends CI_Model {

	 	private $db2 = '';

	 	function __construct() {
	 		parent::__construct();
	 		$this->db2 = $this->load->database('pis', TRUE);
	 	}

	 	var $column_order = array('name', 'user_id', 'username' ,'company', 'business_unit');
	    var $search_column = array('name',  'username','company', 'business_unit'); //set column field database for datatable searchable 
	    var $order = array('name' => 'desc'); // default order 

	    private function make_query(){   

	        //$this->db->from('blacklist'); 
	 		//->join('pis.locate_business_unit', 'locate_business_unit.bunit_code = pis.employee3.bunit_code')
	    	$this->db->select('*, users2.status as ustatus, business_unit.business_unit, company.company')
	        	->from('users2')
	        	->join('burole', 'burole.user_id = users2.user_id')
	        	->join('business_unit', 'business_unit.id = burole.bunit_code','left')
	 			->join('company', 'company.company_code = burole.company_code','left')	
	 			->group_by('users2.user_id')
	 			->where('cebu', '0');
	 				

	        $i = 0;
	        foreach ($this->search_column as $item) // loop column 
	        {
	            if($_POST['search']['value']) // if datatable send POST for search
	            {
	                 
	                if($i===0) // first loop
	                {
	                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
	                    $this->db->like($item, $_POST['search']['value']);
	                }
	                else
	                {
	                    $this->db->or_like($item, $_POST['search']['value']);
	                }
	    
	                if(count($this->search_column) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        } 

	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order = $this->order;
	            $this->db->order_by(key($order), $order[key($order)]);
	        }  
	    }  

	    public function get_users(){  
	        $this->make_query();  
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    public function get_filtered_data(){  
	        $this->make_query();  
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('users2');  
	        return $query->num_rows();
	    }


	 	public function find_employee($search)
	 	{
	 		$query = $this->db2->select('emp_id, name, emp_no')
	 				->where('current_status', 'Active')
	 				->group_start()
	 					->like('emp_id', $search)
	 					->or_like('emp_no', $search)
	 					->or_like('name', $search)
	 					
	 				->group_end()
	 				->limit(20)
	 				->get('employee3');
	 		return $query->result();
	 	}

	 	public function employee_details($emp_id)
	 	{
	 		$query = $this->db2->get_where('employee3', array('emp_id' => $emp_id));
	 		return $query->row();
	 	}

	 	public function find_all_employee()
	 	{
	 		$query = $this->db->from('users2')
	 				->join('pis.employee3', 'employee3.emp_id = users2.emp_id')
	 				->get();
	 		return $query->result();
	 	}

	 	public function find_an_employee3($emp_id)
	 	{
	 		$query = $this->db2->from('pis.employee3')
	 				
	 				->join('pis.locate_company', 'locate_company.company_code = pis.employee3.company_code')
	 				->where('employee3.emp_id', $emp_id)
	 				->get();
	 		return $query->row();
	 	}

	 	public function find_an_employee($emp_id)
	 	{
	 		$query = $this->db2->from('pis.employee3')
	 				
	 				->where('employee3.emp_id', $emp_id)
	 				->get();
	 		return $query->row();
	 	}

	 	public function find_an_employee2($emp_id)
	 	{
	 		$query = $this->db2->from('pis.employee3')
	 				->where('employee3.emp_id', $emp_id)
	 				->get();
	 		return $query->result();
	 	}

	 	public function find_employee_name($emp_id)
	 	{
	 		$query = $this->db2->from('pis.applicant')
	 				->where('applicant.app_id', $emp_id)
	 				->get();
	 		return $query->row();
	 	}

	 	public function company_name($company_code)
	 	{
	 		$query = $this->db2->select('company,acroname')
	 					->get_where('locate_company', array('company_code' => $company_code));
	 		return $query->row();
	 	}

	 	public function bu_name($bunit_code, $company_code)
	 	{
	 		$query = $this->db2->select('business_unit')
	 				->where('bunit_code', $bunit_code)
	 				->where('company_code', $company_code)
	 				->get('locate_business_unit');
	 		return $query->row();
	 	}

	 	public function dept_name($bunit_code, $company_code, $dept_code)
	 	{
	 		$query = $this->db2->select('dept_name')
	 				->where('company_code', $company_code)
	 				->where('bunit_code', $bunit_code)
	 				->where('dept_code', $dept_code)
	 				->get('locate_department');
	 		return $query->row();
	 	}

	 	public function sect_name($bunit_code, $company_code, $dept_code, $sect_code)
	 	{
	 		$query = $this->db2->select('section_name')
	 				->where('company_code', $company_code)
	 				->where('bunit_code', $bunit_code)
	 				->where('dept_code', $dept_code)
	 				->where('section_code', $sect_code)
	 				->get('locate_section');
	 		return $query->row();
	 	}

	 	// public function bu_name($bunit_code, $company_code)
	 	// {	
	 		
	 	// 	$this->db2->select('*');
		// 	$this->db->from('locate_bus');
		// 	$this->db->join('tortypes', 'tortypes.id = usertortypes.tor_id');
		// 	$this->db->where('usertortypes.user_id', $userid);
		// 	$this->db->where('status', 'Active');
		// 	$query = $this->db->get();
		// 	return $query->result();
	 	// }

	 	public function group_name($group_id)
	 	{
	 		$query = $this->db->select('groupname')
	 					->get_where('usergroups', array('group_id' => $group_id));
	 		return $query->row();
	 	}

	 	public function rfs_name($rfs_id)
	 	{
	 		$query = $this->db->select('requesttype')
	 					->get_where('rfstypes', array('id' => $rfs_id));
	 		return $query->row();
	 	}

	 	public function tor_name($tor_id)
	 	{
	 		$query = $this->db->select('tortype')
	 					->get_where('tortypes', array('id' => $tor_id));
	 		return $query->row();
	 	}

	 	public function task_name($usertype_id)
	 	{
	 		$query = $this->db->select('usertype')
	 					->get_where('usertype', array('usertype_id' => $usertype_id));
	 		return $query->row();
	 	}

	 	public function task_name2($theorder)
	 	{
	 		$query = $this->db->select('usertype, tasktor, taskrfs')
	 					->get_where('usertype', array('theorder' => $theorder));
	 		return $query->row();
	 	}

	 	

	 
	 }