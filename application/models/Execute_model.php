	 <?php
	 class Execute_Model extends CI_Model {

	 	private $db2 = '';

	 	function __construct() {
	 		parent::__construct();
	 		$this->db2 = $this->load->database('pis', TRUE);
	 	}

	 	var $column_order = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name');
	    var $search_column = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name'); //set column field database for datatable searchable 
	    var $order = array('requestnumber' => 'asc'); // default order 

	    private function make_query1($table, $field, $field2, $type, $where){   

	        $userid = $this->session->userdata['user_id'];
			
	 		
	 		$query = $this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname, requests.remarks')
	 					->from('requests')
	 					->join('grouprole', 'grouprole.group_id = requests.togroup')
						->join('burole', 'burole.bunit_code = requests.buid')
						// ->join('butaskrole', 'butaskrole.buid = burole.bunit_code')
	 					->join('usergroups', 'usergroups.group_id = requests.togroup')
	 					->join('company', 'company.acroname = requests.companyname')
	 					->join('business_unit', 'business_unit.id = requests.buid')
	 					->join('users2', 'users2.user_id = requests.userid')
	 					->where("typeofrequest = '$type' AND $where 
								AND grouprole.user_id='$userid' AND grouprole.status='Active'
								AND burole.user_id= '$userid' AND burole.status='Active'");

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

	    public function get_requests($data){

	    	$userid = $this->session->userdata['user_id'];

	 		if (!empty($data['date_from']) && !empty($data['date_to']) != '') {
	 			
	 			$this->db->where("datetoday BETWEEN '".date('Y-m-d 00:00:00', strtotime($data['date_from']))."' AND '".date('Y-m-d 23:59:00', strtotime($data['date_to']))."'");
	 		}

	 		//usertype
	 		if($data['usertype'] == "Execute"){
	 			$usertype = "executedby";
	 		}else if($data['usertype'] == "Approve"){
	 			$usertype = "approvedby";
	 		}else if($data['usertype'] == "Review"){
	 			$usertype = "reviewedby";
	 		}else{
	 			$usertype = "verifiedby";
	 			//$where2 = "butaskrole.requesttype= '$type' AND butaskrole.status='Active' AND butaskrole.taskid = 3";

	 		}

	 		//status
	 		if($data['status'] == "Approved") {
				$where = "requests.".$usertype." != '0' AND requests.cancelledby = '0'";
			}else if($data['status'] == "Cancelled") {
				$where ="requests.cancelledby != '0'";	
			}else{
				$where = "requests.$usertype = '0' AND requests.cancelledby = '0'";
			}

			// types
			if($data['typeofrequest'] == 'rfs'){

				$table = "userrfstypes";
				$field = "rfs_id";
				$field2 = "rfstype";
				$type 	= "RFS";
			}else if($data['typeofrequest'] == 'tor') {
				
				$table = "usertortypes";
				$field = "tor_id";
				$field2 = "tortypes";
				$type 	= "TOR";
			}else{

				$table = "userisrtypes";
				$field = "isr_id";
				$field2 = "rfstype";
				$type 	= "ISR";
			}



	        $this->make_query1($table, $field, $field2, $type, $where);
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    public function get_filtered_data($data){  

	    	

	 		if (!empty($data['date_from']) && !empty($data['date_to']) != '') {
	 			
	 			$this->db->where("datetoday BETWEEN '".date('Y-m-d 00:00:00', strtotime($data['date_from']))."' AND '".date('Y-m-d 23:59:00', strtotime($data['date_to']))."'");
	 		}

	 		//usertype
	 		if($data['usertype'] == "Execute"){
	 			$usertype = "executedby";
	 		}else if($data['usertype'] == "Approve"){
	 			$usertype = "approvedby";
	 		}else if($data['usertype'] == "Review"){
	 			$usertype = "reviewedby";
	 		}else{
	 			$usertype = "verifiedby";
	 		}

	 		//status
	 		if($data['status'] == "Approved") {
				$where = "requests.".$usertype." != '0'";
			}else if($data['status'] == "Cancelled") {
				$where ="requests.cancelledby != '0'";	
			}else{
				$where = "requests.$usertype = '0' AND requests.cancelledby = '0'";
			}

			// types
			if($data['typeofrequest'] == 'rfs'){

				$table = "userrfstypes";
				$field = "rfs_id";
				$field2 = "rfstype";
				$type 	= "RFS";
			}else if($data['typeofrequest'] == 'tor') {
				
				$table = "usertortypes";
				$field = "tor_id";
				$field2 = "tortypes";
				$type 	= "TOR";
			}else{

				$table = "userisrtypes";
				$field = "isr_id";
				$field2 = "rfstype";
				$type 	= "ISR";
			}
	        $this->make_query1($table, $field, $field2, $type, $where);  
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('requests');  
	        return $query->num_rows();
	    }

	    public function totalPendingRfsA()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as rfsA');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->where("typeofrequest = 'RFS' AND requests.approvedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingTorA()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as torA');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
			$this->db->where("typeofrequest = 'TOR' AND requests.approvedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingIsrA()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as isrA');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->where("typeofrequest = 'ISR' AND requests.approvedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingRfsE()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as rfs');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->where("typeofrequest = 'RFS' AND requests.executedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingTorE()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as tor');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
			$this->db->where("typeofrequest = 'TOR' AND requests.executedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingIsrE()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as isr');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->where("typeofrequest = 'ISR' AND requests.executedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingConE()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as con');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->where("typeofrequest = 'Concern' AND requests.executedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'");
			
			$query = $this->db->get();
			return $query->result();
	 	}
	 
	}