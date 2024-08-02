	 <?php
	 class Request_Model extends CI_Model {

	 	private $db2 = '';

	 	function __construct() {
	 		parent::__construct();
	 		//$this->db2 = $this->load->database('pis', TRUE);
	 	}

	 	var $column_order = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose');
	    var $search_column = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose'); //set column field database for datatable searchable 
	    var $order = array('requestnumber' => 'asc'); // default order 

	    private function make_query1(){   

	        $userid = $this->session->userdata['user_id'];
			
			$this->db->where('userid', $userid);
	 		$query = $this->db->select('*,requests.id as reqid, requests.status as reqstatus, usergroups.groupname, business_unit.business_unit')
	 					->from('requests')
	 					->join('usergroups', 'usergroups.group_id = requests.togroup')
	 					->join('company', 'company.acroname = requests.companyname')
	 					->join('business_unit', 'business_unit.id = requests.buid');

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

	    	foreach ($data as $key => $value) {

	 			if ($key == 'status' || $key == 'typeofrequest') {
	 				
	 				$this->db->where("requests.{$key}", $value);
	 			} else {
	 				continue;
	 			}
	 		}

	 		if (!empty($data['date_from']) && !empty($data['date_to']) != '') {
	 			
	 			$this->db->where("datetoday BETWEEN '".date('Y-m-d 00:00:00', strtotime($data['date_from']))."' AND '".date('Y-m-d 23:59:00', strtotime($data['date_to']))."'");
	 		}  
	        
	        $this->make_query1();
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    public function get_filtered_data($data){  

	    	foreach ($data as $key => $value) {

	 			if ($key == 'status' || $key == 'typeofrequest') {
	 				
	 				$this->db->where("requests.{$key}", $value);
	 			} else {
	 				continue;
	 			}
	 		}

	 		if (!empty($data['date_from']) && !empty($data['date_to']) != '') {
	 			
	 			$this->db->where("datetoday BETWEEN '".date('Y-m-d 00:00:00', strtotime($data['date_from']))."' AND '".date('Y-m-d 23:59:00', strtotime($data['date_to']))."'");
	 		}
	        $this->make_query1();  
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('requests');  
	        return $query->num_rows();
	    }

	    public function get_requests_data($id)
	 	{
	 		$query = $this->db->select('typeofrequest, requestnumber')
	 					->get_where('requests', array('id' => $id));
	 		return $query->row();
	 	}

	 	public function get_requests_data2($id)
	 	{
	 		$query = $this->db->select('typeofrequest, requestnumber')
	 					->get_where('requests', array('requestnumber' => $id));
	 		return $query->row();
	 	}

	 	// public function get_requests_data3($id, $type)
	 	// {
	 	// 	$query = $this->db->select('*')
	 	// 				->get_where('requests', array('requestnumber' => $id && 'typeofrequest' => $type));
	 	// 	return $query->row();
	 	// }

	 	// public function get_requests_data3($id, $type)
	 	// {
	 	// 	$this->db->select('*');
		// 	$this->db->from('requests');
		// 	$this->db->where('requestnumber', $id);
		// 	$this->db->where('typeofrequest', $type );
		// 	$query = $this->db->get();
		// 	return $query->row();
	 	// }

	 	public function get_requests_data3($id,$type) 
	 	{
	 		$this->db->select('*');
			$this->db->from('requests');
			$this->db->where("requestnumber = '$id' AND typeofrequest = '$type'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function countRequestsAddedWithinInterval() {
	         $userid = $this->session->userdata['user_id'];
    
		    $this->db->select("
		        SUM(CASE WHEN typeofrequest = 'RFS' THEN 1 ELSE 0 END) AS rfsCount,
		        SUM(CASE WHEN typeofrequest = 'TOR' THEN 1 ELSE 0 END) AS torCount,
		        SUM(CASE WHEN typeofrequest = 'ISR' THEN 1 ELSE 0 END) AS isrCount
		    ");
		    $this->db->from('requests');
		    $this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
		    $this->db->join('burole', 'burole.bunit_code = requests.buid');
		    $this->db->where("requests.executedby = '0' AND requests.cancelledby = '0' AND requests.approvedby != '0'
		        AND grouprole.user_id='$userid' AND grouprole.status='Active'
		        AND burole.user_id= '$userid' AND burole.status='Active' 
		        AND date_approved >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)");
		    $query = $this->db->get();
		    
		    if ($query->num_rows() > 0) {
		        $result = $query->row();
		        return [
		            'rfsCount' => $result->rfsCount,
		            'torCount' => $result->torCount,
		            'isrCount' => $result->isrCount,
		        ];
		    } else {
		        return [
		            'rfsCount' => 0,
		            'torCount' => 0,
		            'isrCount' => 0,
		        ];
		    }
	    }

	 	
	 
	}