	 <?php
	 class Verify_Model extends CI_Model {

	 	private $db2 = '';

	 	function __construct() {
	 		parent::__construct();
	 		$this->db2 = $this->load->database('pis', TRUE);
	 	}

	 	var $column_order = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name');
	    var $search_column = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name'); //set column field database for datatable searchable 
	    var $order = array('requestnumber' => 'asc'); // default order 

	    private function make_query1($table, $field, $field2, $type, $where,$type,$taskid){   

	        $userid = $this->session->userdata['user_id'];
			
	 		$query = $this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname,requests.remarks')
	 					->from('requests')
	 					->join('grouprole', 'grouprole.group_id = requests.togroup')
						->join('burole', 'burole.bunit_code = requests.buid')
						->join('butaskrole', 'butaskrole.buid = burole.bunit_code')
	 					->join('usergroups', 'usergroups.group_id = requests.togroup')
	 					->join('company', 'company.acroname = requests.companyname')
	 					->join('business_unit', 'business_unit.id = requests.buid')
	 					->join('users2', 'users2.user_id = requests.userid')
	 					->where("typeofrequest = '$type' AND $where 
	 							AND grouprole.user_id='$userid' AND grouprole.status='Active'
	 							AND butaskrole.requesttype= '$type' AND butaskrole.status='Active' AND butaskrole.taskid = '$taskid'
								AND burole.user_id= '$userid' AND burole.status='Active'");
								
								// AND burole.user_id= '$userid' AND burole.status='Active'
								// AND butaskrole.requesttype= '$type' AND butaskrole.status='Active' AND butaskrole.taskid = '$taskid' ");
	 					// ->join('pis.employee3', 'pis.employee3.emp_id = users2.emp_id'); AND $where2

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
	 			$taskid = 2;
	 		}else{
	 			$usertype = "verifiedby";
	 			$taskid = 3;

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

			//group
			// if($userid != '232'){
			// 	$where2 = "grouprole.user_id='$userid' AND grouprole.status='Active'";
			// }else{
			// 	$where2 = "usergroups.group_id='20'";
			// }

			// usergroups.group_id='20' $where2,

	        $this->make_query1($table, $field, $field2, $type, $where,$type, $taskid);
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    public function get_filtered_data($data){  

	    	
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
	 			$taskid = 2;
	 		}else{
	 			$usertype = "verifiedby";
	 			$taskid = 3;

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

			//group
			// if($userid != '232'){
			// 	$where2 = "grouprole.user_id='$userid' AND grouprole.status='Active'";
			// }else{
			// 	$where2 = "usergroups.group_id='20'";
			// }
	        $this->make_query1($table, $field, $field2, $type, $where,$type,$taskid);  
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('requests');  
	        return $query->num_rows();
	    }

	    public function totalPendingRfsR()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as rfsR');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'RFS' AND requests.reviewedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'RFS' AND butaskrole.status='Active' AND butaskrole.taskid = 2");
			
			$query = $this->db->get();
			return $query->result();

			// AND userrfstypes.user_id= '$userid' AND userrfstypes.status='Active'
	 	}

	 	public function totalPendingTorR()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as torR');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'TOR' AND requests.reviewedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'TOR' AND butaskrole.status='Active' AND butaskrole.taskid = 2");
			
			$query = $this->db->get();
			return $query->result();

			// AND usertortypes.user_id= '$userid' AND usertortypes.status='Active'
	 	}

	 	public function totalPendingIsrR()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(requests.id) as isrR');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			// $this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'ISR' AND requests.reviewedby = '0' AND requests.cancelledby = '0' 
						AND grouprole.user_id='$userid' AND grouprole.status='Active'
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'ISR' AND butaskrole.status='Active' AND butaskrole.taskid = 2");
			
			$query = $this->db->get();
			return $query->result();

			// AND userisrtypes.user_id= '$userid' AND userisrtypes.status='Active'
	 	}

	 	public function totalPendingRfsV()
	 	{

	 		$userid = $this->session->userdata['user_id'];

	 		//group
			if($userid != '232'){
				$where2 = "grouprole.user_id='$userid' AND grouprole.status='Active'";
			}else{
				$where2 = "usergroups.group_id='20'";
			}
	 		$this->db->select('COUNT(requests.id) as rfsV');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			// $this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'RFS' AND requests.verifiedby = '0' AND requests.cancelledby = '0' 
						AND $where2
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'RFS' AND butaskrole.status='Active' AND butaskrole.taskid = 3");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingTorV()
	 	{	
	 		$userid = $this->session->userdata['user_id'];

	 		//group
			if($userid != '232'){
				$where2 = "grouprole.user_id='$userid' AND grouprole.status='Active'";
			}else{
				$where2 = "usergroups.group_id='20'";
			}
	 		$this->db->select('COUNT(requests.id) as torV');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			// $this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'TOR' AND requests.verifiedby = '0' AND requests.cancelledby = '0' 
						AND $where2
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'TOR' AND butaskrole.status='Active' AND butaskrole.taskid = 3");
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function totalPendingIsrV()
	 	{	
	 		$userid = $this->session->userdata['user_id'];

	 		//group
			if($userid != '232'){
				$where2 = "grouprole.user_id='$userid' AND grouprole.status='Active'";
			}else{
				$where2 = "usergroups.group_id='20'";
			}
	 		$this->db->select('COUNT(requests.id) as isrV');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			// $this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->join('butaskrole', 'butaskrole.buid = burole.bunit_code');
			$this->db->where("typeofrequest = 'ISR' AND requests.verifiedby = '0' AND requests.cancelledby = '0' 
						AND $where2
						AND burole.user_id= '$userid' AND burole.status='Active'
						AND butaskrole.requesttype= 'ISR' AND butaskrole.status='Active' AND butaskrole.taskid = 3");
			
			$query = $this->db->get();
			return $query->result();
	 	}
	 
	}