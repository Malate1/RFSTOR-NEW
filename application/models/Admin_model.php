	 <?php
	 class Admin_Model extends CI_Model {

	 	function __construct() {
	 		parent::__construct();
	 		$this->db2 = $this->load->database('pis', TRUE);
	 		$this->db3 = $this->load->database('ebs', TRUE);
	 	}

	 	public function getDataCountByMonth($year = null) {
			$this->db->select("DATE_FORMAT(datetoday, '%b-%y') AS month, 
							   SUM(CASE WHEN typeofrequest = 'RFS' THEN 1 ELSE 0 END) AS rfs_count, 
							   SUM(CASE WHEN typeofrequest = 'TOR' THEN 1 ELSE 0 END) AS tor_count,
							   SUM(CASE WHEN typeofrequest = 'ISR' THEN 1 ELSE 0 END) AS isr_count", false);
			
			if ($year) {
				// Add a where condition to filter by the specified year
				$this->db->where("YEAR(datetoday)", $year);
			}
		
			$this->db->group_by("DATE_FORMAT(datetoday, '%Y-%m')");
			$query = $this->db->get('requests');
		
			$dataByMonth = array();
			foreach ($query->result_array() as $row) {
				$dataByMonth[$row['month']] = array(
					'rfs_count' => $row['rfs_count'],
					'tor_count' => $row['tor_count'],
					'isr_count' => $row['isr_count']
				);
			}
		
			return $dataByMonth;
		}
		

		// public function getDataCountByMonth($year = null)
		// {
		//     $this->db->select("DATE_FORMAT(datetoday, '%M-%Y') AS month, 
		//                        SUM(CASE WHEN typeofrequest = 'RFS' THEN 1 ELSE 0 END) AS rfs_count, 
		//                        SUM(CASE WHEN typeofrequest = 'TOR' THEN 1 ELSE 0 END) AS tor_count,
		//                        SUM(CASE WHEN typeofrequest = 'ISR' THEN 1 ELSE 0 END) AS isr_count", false);

		//     // If a year is provided, filter the results by that year
		//     if ($year) {
		//         $this->db->where('YEAR(datetoday)', $year);
		//     }

		//     $this->db->group_by("DATE_FORMAT(datetoday, '%Y-%m')");
		//     $query = $this->db->get('requests');

		//     $dataByMonth = array();
		//     foreach ($query->result_array() as $row) {
		//         $dataByMonth[$row['month']] = array(
		//             'rfs_count' => $row['rfs_count'],
		//             'tor_count' => $row['tor_count'],
		//             'isr_count' => $row['isr_count']
		//         );
		//     }

		//     return $dataByMonth;
		// }


		public function getPendingCountByGroup()
		{
		    $this->db->select("usergroups.groupname AS group_name, COUNT(*) AS total_pending_requests,
		                       SUM(CASE WHEN typeofrequest = 'RFS' THEN 1 ELSE 0 END) AS rfs_count, 
		                       SUM(CASE WHEN typeofrequest = 'TOR' THEN 1 ELSE 0 END) AS tor_count", false);
		    $this->db->from('requests');
		    $this->db->join('usergroups', 'requests.togroup = usergroups.group_id', 'left');
		    $this->db->where('requests.status', 'Pending');
		    $this->db->group_by("usergroups.group_id");
		    //$this->db->order_by('total_pending_requests', 'DESC');
		    //$this->db->limit(10);
		    //$this->db->having('rfs_count > 0 OR tor_count > 0');
		    $this->db->having('total_pending_requests > 10');
		    $query = $this->db->get();

		    $dataByGroup = array();
		    foreach ($query->result_array() as $row) {
		        $dataByGroup[$row['group_name']] = array(
		            'rfs_count' => $row['rfs_count'],
		            'tor_count' => $row['tor_count']
		        );
		    }

		    return $dataByGroup;
		}

		var $column_order2 = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name');
	    var $search_column2 = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name'); //set column field database for datatable searchable 
	    var $order2 = array('requestnumber' => 'asc'); // default order 

	    private function make_query1($usergroup,$type){   

	     
	 		$query = $this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname, requests.remarks')
	 					->from('requests')
	 					// ->join('grouprole', 'grouprole.group_id = requests.togroup')
						// ->join('burole', 'burole.bunit_code = requests.buid')
						// ->join('butaskrole', 'butaskrole.buid = burole.bunit_code')
	 					->join('usergroups', 'usergroups.group_id = requests.togroup')
	 					->join('company', 'company.acroname = requests.companyname')
	 					->join('business_unit', 'business_unit.id = requests.buid')
	 					->join('users2', 'users2.user_id = requests.userid')
	 					->where("requests.togroup = '$usergroup' AND requests.typeofrequest='$type' AND requests.status = 'Pending' ");

	 		// $query = $this->db->select('*, requests.status as reqstatus, requests.id as reqid, usergroups.groupname, requests.remarks')
			//     ->from('requests')
			//     ->join('butaskrole', 'butaskrole.buid = requests.buid')
			//     ->join('usergroups', 'usergroups.group_id = requests.togroup')
			//     ->join('company', 'company.acroname = requests.companyname')
			//     ->join('business_unit', 'business_unit.id = requests.buid')
			//     ->join('users2', 'users2.user_id = requests.userid')
			//     ->where("requests.togroup = '$usergroup' AND requests.typeofrequest='$type' AND requests.status= 'Pending' AND butaskrole.status = 'Active' AND butaskrole.requesttype = '$type' AND butaskrole.taskid IN (2, 3)");

	        $i = 0;
	        foreach ($this->search_column2 as $item) // loop column 
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
	    
	                if(count($this->search_column2) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        } 

	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order2 = $this->order;
	            $this->db->order_by(key($order2), $order2[key($order2)]);
	        }  
	    }  

	    public function get_requests($data){

	    	$usergroup = $data['usergroup'];
	    	$type = $data['typeofrequest'];
	        $this->make_query1($usergroup,$type);
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    var $column_order4 = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name');
	    var $search_column4 = array('requestnumber', 'groupname', 'companyname', 'business_unit', 'purpose' , 'name'); //set column field database for datatable searchable 
	    // var $order2 = array('requestnumber' => 'asc'); // default order 

	    private function make_query4($usergroup,$type){   

	     
	 		$query = 	$this->db->select('*');
						$this->db->from('taskrole');
						$this->db->join('grouprole', 'grouprole.user_id = taskrole.user_id');
						$this->db->where("taskrole.usertype_id = '$type' AND taskrole.status= 'Active' AND taskrole.status= 'Active' AND grouprole.status= 'Active' ");
	 					

	 					

	        $i = 0;
	        foreach ($this->search_column4 as $item) // loop column 
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
	    
	                if(count($this->search_column4) - 1 == $i) //last loop
	                    $this->db->group_end(); //close bracket
	            }
	            $i++;
	        } 

	        if(isset($_POST['order'])) // here order processing
	        {
	            $this->db->order_by($this->column_order4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
	        } 
	        else if(isset($this->order))
	        {
	            $order2 = $this->order;
	            $this->db->order_by(key($order2), $order2[key($order2)]);
	        }  
	    }

	    public function get_approvers($data){

	    	$usergroup = $data['usergroup'];
	    	$type = $data['typeofuser'];
	        $this->make_query4($usergroup,$type);
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    } 

	    public function get_filtered_data1($data){  

	 		$usergroup = $data['usergroup'];
	        $type = $data['typeofrequest'];
	        $this->make_query1($usergroup,$type);
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data1(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('requests');  
	        return $query->num_rows();
	    }

	 	var $column_order = array('date', 'request_id','action', 'rtype','type');
	    var $search_column = array('date', 'request_id','action'); //set column field database for datatable searchable 
	    var $order = array('id' => 'desc'); // default order 

	    private function make_query($condition){   

	        //$this->db->from('blacklist'); 
	 		//->join('pis.locate_business_unit', 'locate_business_unit.bunit_code = pis.employee3.bunit_code')
	    	$this->db->select('*')
	        	->from('logs')
	        	//->join('burole', 'burole.user_id = users2.user_id')
	  
	 			->where("$condition");
	 				

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

	    private function make_query2(){   

	        //$this->db->from('blacklist'); 
	 		//->join('pis.locate_business_unit', 'locate_business_unit.bunit_code = pis.employee3.bunit_code')
	    	$this->db->select('*')
	        	->from('logs');
	        	//->join('burole', 'burole.user_id = users2.user_id')
	  
	 			// ->where("$condition");
	 				

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

	    public function get_reqlogs(){
	    	$condition = "type = 'Request'";  
	    	//$group_id = $data['group_id'];
	        $this->make_query($condition);  
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    }

	    public function get_logs(){
	    	$condition = "type ='Setup'";  
	    	//$group_id = $data['group_id'];
	        $this->make_query2();  
	        if(@$_POST["length"] != -1)  
	        {  
	            $this->db->limit($_POST['length'], $_POST['start']);  
	        }  
	        $query = $this->db->get();  
	        return $query->result();  
	    }

	    public function get_filtered_data(){  
	        $condition = "type = 'Request'"; 
	    	//$group_id = $data['group_id'];
	        $this->make_query($condition); 
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    } 

	    public function get_filtered_data2(){  
	        $condition = "type = 'Request' OR type ='Setup'";   
	    	//$group_id = $data['group_id'];
	        $this->make_query2(); 
	        $query = $this->db->get();  
	        return $query->num_rows();  
	    }       
	      
	    public function get_all_data(){  
	    
	        //$this->db->get('users2');  
	        // return $this->db->count_all_results();  
	        $query = $this->db->get('logs');  
	        return $query->num_rows();
	    }
	 	
	 	public function view_info ($user_id) {
	 		$this->db->select("*");
	 		$this->db->where('user_id',$user_id);
	 		$this->db->from('users');

	 		$query = $this->db->get();
	 		return $query->result();
	 	}
	 	
	 	public function addLogs($data) {

			date_default_timezone_set('Asia/Manila');
			if ($this->db->insert("logs", $data)) {
				return true;
			}
		}

	 	private $request = 'requests';   // files    
	 	private $file = 'files';   // files    
    
	    function save_files_info($files) {
	        //start db traction
	        $this->db->trans_start();
			$userid = $this->session->userdata['user_id'];
	        //file data
	        $file_data = array();
	        foreach ($files as $file) {
	            $file_data[] = array(
	                'file_name' => $file['file_name'],
	                'file_orig_name' => $file['orig_name'],
	                'file_path' => $file['full_path'],
	                'upload_date' => date('Y-m-d H:i:s'),
	                'requestnumber' => $userid
	            );
	        }
	        
			//insert file data
	        $this->db->insert_batch($this->file, $file_data);
	        
			//complete the transaction
	        $this->db->trans_complete();
	        
			//check transaction status
	        if ($this->db->trans_status() === FALSE) {
	            foreach ($files as $file) {
	                $file_path = $file['full_path'];
					
	                //delete the file from destination
	                if (file_exists($file_path)) {
	                    unlink($file_path);
	                }
	            }
				
	            //rollback transaction
	            $this->db->trans_rollback();
	            
				return FALSE;
	        } else {
	            //commit the transaction
	            $this->db->trans_commit();
				
	            return TRUE;
	        }
	    }


	 	public function getData($id)
        {
        	//$db2 = $this->load->database('database2', TRUE);
            $query = $this->db->query('SELECT * FROM users2 WHERE user_id = '.$id);
            return $query->row();
        }

        public function getDataUsers($emp)
        {
        	$query = $this->db->query('SELECT * FROM pis.employee3 T1 WHERE T1.name = "'.$emp.'" ');
            	
            return $query->row();
        }

        public function getDataUserNamePass($emp)
        {
        	$query = $this->db->query('SELECT * FROM pis.users T2 WHERE T2.emp_id ="'.$emp.'" ');
            	
            return $query->row();
        }

        

        public function getDataRequest($id)
        {
            $query = $this->db->query('SELECT * FROM requests WHERE id = '.$id);
            return $query->row();
        }

        public function getDataRequestConcern($id)
        {
        	
            $query = $this->db->query('SELECT a.*,c.groupname, a.status as rstat FROM requests a 
            	
            	INNER JOIN usergroups c ON c.group_id=a.togroup 
            	
            	WHERE a.id = '.$id);
            return $query->row();
        }

        public function getDataRequestRfs($id)
        {
        	
            $query = $this->db->query('SELECT a.*,b.requesttype,c.groupname,a.status as rstat FROM requests a 
            	INNER JOIN rfstypes b ON b.id=a.rfstype 
            	INNER JOIN usergroups c ON c.group_id=a.togroup 
            	-- INNER JOIN requestmode d ON d.id=a.requestmode d.themode, 
            	
            	
            	WHERE a.id = '.$id);
            return $query->row();
        }

        public function getDataRequestTor($id)
        {
        	
            $query = $this->db->query('SELECT a.*,b.tortype,c.groupname, a.status as rstat  FROM requests a 
            	INNER JOIN tortypes b ON b.id=a.tortypes 
            	INNER JOIN usergroups c ON c.group_id=a.togroup
            	
            	WHERE a.id = '.$id);
            return $query->row();
        }

        public function getDataRequestIsr($id)
        {
        	
            $query = $this->db->query('SELECT a.*,b.requesttype,c.groupname, a.status as rstat FROM requests a 
            	INNER JOIN rfstypes b ON b.id=a.rfstype 
            	INNER JOIN usergroups c ON c.group_id=a.togroup
            	
            	WHERE a.id = '.$id);
            return $query->row();
        }

        public function getDataBu($id)
        {
            $query = $this->db->query('SELECT * FROM business_unit WHERE id = '.$id);
            return $query->row();
        }

        public function getData1($id)
        {
            $query = $this->db->query('SELECT * FROM taskrole WHERE usertype_id = 2 AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        public function getData2($id)
        {
            $query = $this->db->query('SELECT * FROM taskrole WHERE user_id = '.$id.' ');
            
            return  $query->row();
        }

        public function getData3($uid,$id)
        {
            $query = $this->db->query('SELECT * FROM taskrole WHERE usertype_id = '.$uid.' AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getData4($uid,$id)
        {
            $query = $this->db->query('SELECT * FROM userrfstypes WHERE rfs_id = '.$uid.' AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getData5($uid,$id)
        {
            $query = $this->db->query('SELECT * FROM usertortypes WHERE tor_id = '.$uid.' AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getData6($uid,$id)
        {
            $query = $this->db->query('SELECT * FROM userisrtypes WHERE isr_id = '.$uid.' AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getData7($uid,$id)
        {
            $query = $this->db->query('SELECT * FROM grouprole WHERE group_id = '.$uid.' AND user_id = '.$id.' AND status = "Active"');
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function getBu1($code,$id,$company)
        {
            $query = $this->db->query('SELECT * FROM burole WHERE bunit_code = '.$code.' AND user_id = '.$id.' AND company_code = '.$company.' AND status = "Active"');
            //echo "$code";
            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

         public function getBu2($uid,$id, $rtype)
        {
            $query = $this->db->query('SELECT * FROM butaskrole WHERE taskid = '.$uid.' AND buid = '.$id.' AND status = "Active" AND requesttype = "'.$rtype.'" ');
            //echo "$rtype";

            
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
                //var_dump($result);
            }
            else
            {
                return false;
            }
        }

        
	 	public function CheckExists($fname,$lname)
		{
			$this ->db->select(' * ');
			$this ->db->from('users2');
			$this ->db->where('fname', $fname);
			$this ->db->where('lname', $lname);
			$this ->db->limit(1);
			$query = $this->db-> get();
			return $query;
		}

		public function updateStatus($data2,$old_app_id, $utype_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("usertype_id", $utype_id);
			$this->db->update("taskrole", $data2);

	 		return $this->db->affected_rows();
		} 

		public function updateStatusRfs($data2,$old_app_id, $utype_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("rfs_id", $utype_id);
			$this->db->update("userrfstypes", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusTor($data2,$old_app_id, $utype_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("tor_id", $utype_id);
			$this->db->update("usertortypes", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusIsr($data2,$old_app_id, $utype_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("isr_id", $utype_id);
			$this->db->update("userisrtypes", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusGroup($data2,$old_app_id, $utype_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("group_id", $utype_id);
			$this->db->update("grouprole", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusBu($data2,$old_app_id, $utype_id,$comp) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			$this->db->where("bunit_code", $utype_id);
			$this->db->where("company_code", $comp);
			$this->db->update("burole", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusBuRoles($data2,$old_app_id, $utype_id,$comp) {
			$this->db->set($data2);
			$this->db->where("buid", $old_app_id);
			$this->db->where("taskid", $utype_id);
			$this->db->where("requesttype", $comp);
			$this->db->update("butaskrole", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateStatusFilesRfs($data2,$old_app_id, $utype_id,$file_id) {
			$this->db->set($data2);
			$this->db->where("request_number", $old_app_id);
			$this->db->where("request_type", $utype_id);
			$this->db->where("file_id", $file_id);
			$this->db->update("files", $data2);

	 		return $this->db->affected_rows();
		}
		public function updateStatusRequest($data2,$old_app_id) {
			$this->db->set($data2);
			$this->db->where("id", $old_app_id);
			
			$this->db->update("requests", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateUserStatus($data2,$old_app_id) {
			$this->db->set($data2);
			$this->db->where("user_id", $old_app_id);
			
			$this->db->update("users2", $data2);

	 		return $this->db->affected_rows();
		}

		public function updateGroupStatus($data2,$old_app_id) {
			$this->db->set($data2);
			$this->db->where("group_id", $old_app_id);
			
			$this->db->update("usergroups", $data2);

	 		return $this->db->affected_rows();
		}

		public function checkUser($username)
        {
            $query = $this->db->query('SELECT * FROM users2 WHERE username ="'.$username.'" ');

            // $query = $this->db->query('SELECT * FROM users WHERE username = "'.$name.'"');
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
        public function checkUser2($emp_id)
        {
            $query = $this->db->query('SELECT * FROM users2 WHERE emp_id = "'.$emp_id.'"');

            // $query = $this->db->query('SELECT * FROM users WHERE username = "'.$name.'"');
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function checkGroup($name)
        {
            $query = $this->db->query('SELECT * FROM usergroups WHERE groupname = "'.$name.'"');

            // $query = $this->db->query('SELECT * FROM users WHERE username = "'.$name.'"');
            $result = $query->num_rows();
            if($result > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public function bu_name($buid)
	 	{
	 		$query = $this->db->select('*')
	 					->get_where('business_unit', array('id' => $buid));
	 		return $query->row();
	 	}

	 	public function request_no($id, $rtype)
		{
			$query = $this->db->select('*')
							->get_where('requests', array('requestnumber' => $id, 'typeofrequest' => $rtype));
			return $query->row();
		}


	 	
	 	public function getUsers()
		{
			$userid = $this->session->userdata['user_id'];
			$group = $this->session->userdata['maingroup'];
			$this->db->select('*,usertype.usertype,usergroups.groupname, company.acroname,business_unit.business_unit');
			$this->db->from('users');
			$this->db->join('usertype', 'usertype.usertype_id = users.maintask');
			$this->db->join('usergroups', 'usergroups.group_id = users.maingroup');
			$this->db->join('business_unit', 'business_unit.id = users.mainbu');
			$this->db->join('company', 'company.company_code = users.maincomp');
			//$this->db->where('taskrole.status', 'Active');
			$this->db->where("maingroup = '$group' AND superadmin = 'No'");
			$query = $this->db->get();
			return $query->result();
		}

		public function getUsersSuper()
		{
			$userid = $this->session->userdata['user_id'];
			$group = $this->session->userdata['maingroup'];
			$this->db->select('*,usertype.usertype,usergroups.groupname,company.company, company.acroname,business_unit.business_unit,usertype.theorder');
			$this->db->from('users');
			$this->db->join('usertype', 'usertype.usertype_id = users.maintask');
			$this->db->join('usergroups', 'usergroups.group_id = users.maingroup');
			$this->db->join('business_unit', 'business_unit.id = users.mainbu');
			$this->db->join('company', 'company.company_code = users.maincomp');
			//$this->db->where('taskrole.status', 'Active');
			// $this->db->where("maingroup = '$group' AND superadmin = 'Yes'");
			$query = $this->db->get();
			return $query->result();
		}

		public function getUserData()
		{
			$userid = $this->session->userdata['user_id'];
			$this->db->select('*');
			$this->db->from('users2');
			$this->db->where('users2.user_id', $userid);
			$query = $this->db->get();
			return $query->row();
		}

		public function getUserData2($user_id)
		{
			//$userid = $this->session->userdata['user_id'];
			$this->db->select('*');
			$this->db->from('users2');
			$this->db->where('users2.user_id', $user_id);
			$query = $this->db->get();
			return $query->row();
		}

		public function getUserBu($bu, $comp)
		{
			$userid = $this->session->userdata['user_id'];
			$this->db->select('*');
			$this->db->from('business_unit');
			$this->db->where('bunit_code', $bu);
			$this->db->where('company_code', $comp);
			$query = $this->db->get();
			return $query->row();
		}



		public function getUserBurole()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, business_unit.business_unit');
			$this->db->from('burole');
			$this->db->join('business_unit', 'business_unit.id = burole.bunit_code');
			$this->db->where('burole.user_id', $userid);
			$this->db->where('burole.status', 'Active');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getUserGrouprole()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, usergroups.groupname');
			$this->db->from('grouprole');
			$this->db->join('usergroups', 'usergroups.group_id = grouprole.group_id');
			$this->db->where('grouprole.user_id', $userid);
			$this->db->where('grouprole.status', 'Active');
			$query = $this->db->get();
			return $query->result();
	 	}

		public function getUserRfsMode()
	 	{	
	 		$this->db->select('*');
			$this->db->from('requestmode');
			$this->db->where('fortype = 0');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getUserRfs()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, rfstypes.requesttype');
			$this->db->from('userrfstypes');
			$this->db->join('rfstypes', 'rfstypes.id = userrfstypes.rfs_id');
			$this->db->where('userrfstypes.user_id', $userid);
			$this->db->where('status', 'Active');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getUserTor()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, tortypes.tortype');
			$this->db->from('usertortypes');
			$this->db->join('tortypes', 'tortypes.id = usertortypes.tor_id');
			$this->db->where('usertortypes.user_id', $userid);
			$this->db->where('status', 'Active');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	// retrieve ISR data for update per user 
	 	public function getUserIsr()
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, rfstypes.requesttype');
			$this->db->from('userisrtypes');
			$this->db->join('rfstypes', 'rfstypes.id = userisrtypes.isr_id');
			$this->db->where('userisrtypes.user_id', $userid);
			// $this->db->where('status', 'Active');
			// $this->db->where('rfstypes.isr', '1');
			$this->db->where("status = 'Active' AND rfstypes.isr = '1'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getRequestPending($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*,usergroups.groupname');
			$this->db->from('requests');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			//$this->db->where('typeofrequest', 'RFS');
			if($type == 'RFS'){
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status = 'Pending'");
			}elseif ($type == 'TOR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status = 'Pending'");
			}elseif ($type == 'ISR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status = 'Pending'");
			}else{
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status = 'Pending'");
			}
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getRequestCompleted($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*,usergroups.groupname');
			$this->db->from('requests');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			//$this->db->where('typeofrequest', 'RFS');
			if($type == 'RFS'){
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Approved'");
			}elseif ($type == 'TOR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Approved'");
			}elseif ($type == 'ISR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Approved'");
			}else{
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Approved'");
			}
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getRequestCancelled($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*,usergroups.groupname');
			$this->db->from('requests');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			//$this->db->where('typeofrequest', 'RFS');
			if($type == 'RFS'){
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Cancelled'");
			}elseif ($type == 'TOR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Cancelled'");
			}elseif ($type == 'ISR') {
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Cancelled'");
			}else{
				$this->db->where("typeofrequest = '$type' AND userid = '$userid' AND requests.status='Cancelled'");
			}
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getCancelledStatus($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			
			if($type == 'RFS'){
				$this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type' AND requests.status='Cancelled'
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userrfstypes.user_id= '$userid' AND userrfstypes.status='Active'");
			}elseif ($type == 'TOR') {
				$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.status='Cancelled' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND usertortypes.user_id= '$userid' AND usertortypes.status='Active'");
			}elseif ($type == 'Concern') {
				// $this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.status='Cancelled' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'");
			}
			else{
				$this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type' AND requests.status='Cancelled' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userisrtypes.user_id= '$userid' AND userisrtypes.status='Active'");
			}
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getApproveStatusExecute($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			
			if($type == 'RFS'){
				$this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type' AND requests.executedby != '0'
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userrfstypes.user_id= '$userid' AND userrfstypes.status='Active'");
			}elseif ($type == 'TOR') {
				$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.executedby != '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND usertortypes.user_id= '$userid' AND usertortypes.status='Active'");
			}elseif ($type == 'Concern') {
				//$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.executedby != '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'");
			}else{
				$this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type' AND requests.executedby != '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userisrtypes.user_id= '$userid' AND userisrtypes.status='Active'");
			}
			$query = $this->db->get();
			return $query->result();
	 	}
	 	
	 	public function getPendingStatusExecute($type)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid,usergroups.groupname');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.group_id = requests.togroup');
			$this->db->join('burole', 'burole.bunit_code = requests.buid');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			
			if($type == 'RFS'){
				$this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type' AND requests.executedby = '0' AND requests.cancelledby = '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userrfstypes.user_id= '$userid' AND userrfstypes.status='Active'");
			}elseif ($type == 'TOR') {
				$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.executedby = '0' AND requests.cancelledby = '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND usertortypes.user_id= '$userid' AND usertortypes.status='Active'");
			}elseif ($type == 'Concern') {
				//$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
				$this->db->where("typeofrequest = '$type' AND requests.executedby = '0' AND requests.cancelledby = '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'");
			}else{
				$this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
				$this->db->where("typeofrequest = '$type'AND requests.executedby = '0' AND requests.cancelledby = '0' 
							AND grouprole.user_id='$userid' AND grouprole.status='Active'
							AND burole.user_id= '$userid' AND burole.status='Active'
							AND userisrtypes.user_id= '$userid' AND userisrtypes.status='Active'");
			}
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//counts the total number of pending RFS per requester
	 	public function totalPendingRfs() 
	 	{
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(id) as rfs');
			$this->db->from('requests');
			$this->db->where("typeofrequest = 'RFS' AND userid = '$userid' AND requests.status = 'Pending'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//counts the total number of pending TOR per requester
	 	public function totalPendingTor() 
	 	{
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(id) as tor');
			$this->db->from('requests');
			$this->db->where("typeofrequest = 'TOR' AND userid = '$userid' AND requests.status = 'Pending'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//counts the total number of pending ISR per requester
	 	public function totalPendingIsr() 
	 	{
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(id) as isr');
			$this->db->from('requests');
			$this->db->where("typeofrequest = 'ISR' AND userid = '$userid' AND requests.status = 'Pending'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//counts the total number of pending Concerns per requester
	 	public function totalPendingConcerns() 
	 	{
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('COUNT(id) as rfs');
			$this->db->from('requests');
			// $this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			$this->db->where("typeofrequest = 'Concern' AND userid = '$userid' AND requests.status = 'Pending'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getConcernApprovebyRequest($id)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid, usergroups.groupname');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.id = requests.togroup');
			$this->db->join('burole', 'burole.id = requests.buid');
			//$this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			
			//$this->db->join('rfstypes', 'rfstypes.id = requests.rfstype');
			//$this->db->join('requestmode', 'requestmode.id = requests.requestmode');
			$this->db->where("requests.id='$id'");
			$query = $this->db->get();
			return $query->row();
	 	}

	 	public function getReqRfsApprovebyRequest($id)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid, usergroups.groupname, rfstypes.requesttype');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.id = requests.togroup');
			$this->db->join('burole', 'burole.id = requests.buid');
			$this->db->join('userrfstypes', 'userrfstypes.rfs_id = requests.rfstype');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			
			$this->db->join('rfstypes', 'rfstypes.id = requests.rfstype');
			//$this->db->join('requestmode', 'requestmode.id = requests.requestmode');
			// $this->db->limit(1);
			$this->db->where("requests.id='$id'");
			$query = $this->db->get();
			
			return $query->row();
	 	}

	 	public function getReqTorApprovebyRequest($id)
	 	{	
	 		//var_dump($id);
			$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid, usergroups.groupname, tortypes.tortype');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.id = requests.togroup');
			$this->db->join('burole', 'burole.id = requests.buid');
			$this->db->join('usertortypes', 'usertortypes.tor_id = requests.tortypes');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			// $this->db->join('users2', 'users.user_id = requests.userid');
			$this->db->join('tortypes', 'tortypes.id = requests.tortypes');
			
			$this->db->where("requests.id='$id'");
			
			$query = $this->db->get();
			return $query->row();
	 	}

	 	public function getReqIsrApprovebyRequest($id)
	 	{	
	 		$userid = $this->session->userdata['user_id'];
	 		$this->db->select('*, requests.status as reqstatus,requests.id as reqid, usergroups.groupname,rfstypes.requesttype');
			$this->db->from('requests');	
			$this->db->join('grouprole', 'grouprole.id = requests.togroup');
			$this->db->join('burole', 'burole.id = requests.buid');
			$this->db->join('userisrtypes', 'userisrtypes.isr_id = requests.rfstype');
			$this->db->join('usergroups', 'usergroups.group_id = requests.togroup');
			// $this->db->join('users2', 'users.user_id = requests.userid');
			$this->db->join('rfstypes', 'rfstypes.id = requests.rfstype');
			
			$this->db->where("requests.id='$id'");
			$query = $this->db->get();
			return $query->row();
	 	}

	 	
	 	//checks if the user has admin access
	 	public function getType1($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 1 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has request access
	 	public function getType2($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 2 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has approve access
	 	public function getType3($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 3 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has execute access
	 	public function getType4($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 4 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has review access
	 	public function getType5($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 5 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has verify access
	 	public function getType6($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM taskrole WHERE user_id = "'.$user_id.'" AND usertype_id = 6 AND status = "Active"' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has concern menu access
	 	public function getConcernMenu($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM users2 WHERE user_id = "'.$user_id.'" AND allowconcern = 1 AND status = 1' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	//checks if the user has ISR menu access
	 	public function getAllowIsr($user_id)
	 	{
	 		$query = $this->db->query('SELECT * FROM users2 WHERE user_id = "'.$user_id.'" AND allowisr = 1 AND status = 1' );
                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	public function getTypeBuTask($buid,$taskid,$rtype)
	 	{
	 		
	 		$query = $this->db->query('SELECT * FROM butaskrole WHERE buid = "'.$buid.'" AND taskid = "'.$taskid.'" AND requesttype="'.$rtype.'"  AND status = "Active"' );

                $result = $query->num_rows();
                if($result > 0)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	 	}

	 	
	 	public function getUserGroupbyUser($id)
	 	{
	 		$this->db->select('*');
			$this->db->from('usergroups');
			$this->db->where("group_id = '$id'");
			$query = $this->db->get();
			return $query->row();
	 	}
	 	//gets all usergroups
	 	public function getAllUserGroup()
	 	{
	 		$query = $this->db->get('usergroups');
	 		return $query->result();
	 	}
	 	//get the usergroups which is active and it is used on adding/editing request
	 	public function getUserGroup()
	 	{
	 		$this->db->select('*');
			$this->db->from('usergroups');
			$this->db->where("active = 1");
			$this->db->order_by('group_id', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of usertypes
	 	public function getTask()
	 	{
	 		
	 		$this->db->select('*');
			$this->db->from('usertype');
			$this->db->order_by('usertype_id', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getTaskperUser($userid)
	 	{
	 		
	 		$this->db->select('*,usertype.usertype');
			$this->db->from('taskrole');
			$this->db->join('usertype', 'usertype.usertype_id = taskrole.usertype_id');
			$this->db->where("user_id = '$userid'");
			$this->db->where("status = 'Active'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of usertypes 
	 	public function getTask2()
	 	{
	 		$this->db->select('*');
			$this->db->from('usertype');
			$this->db->where("theorder != 0");
			$this->db->order_by('theorder', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of rfs types
	 	public function getRfs()
	 	{
	 		$this->db->select('*');
			$this->db->from('rfstypes');
			$this->db->where("isr = 0");
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}
	 	//gets the request's attachment details filtered by request number and type
	 	public function getFiles($id,$type) 
	 	{
	 		$this->db->select('*');
			$this->db->from('files');
			$this->db->where("request_number = '$id' AND request_type = '$type' AND status= 'Active'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the total number of request's attachment details filtered by request number and type
	 	public function getFilesCount($id,$type) 
	 	{
	 		$this->db->select('*,COUNT(file_id) as file');
			$this->db->from('files');
			$this->db->where("request_number = '$id' AND request_type = '$type' AND status= 'Active'");
			$query = $this->db->get();
			return $query->row();
	 	}

	 	//gets the total number of approvers filtered by bu 
	 	public function getApproversCount() 
	 	{
	 		$this->db->select('*, COUNT(taskrole.user_id) as approver');
			$this->db->from('taskrole');
			// $this->db->join('burole', 'burole.user_id = taskrole.user_id');
			// $this->db->join('users2', 'users2.user_id = taskrole.user_id');
			
			$this->db->where("taskrole.usertype_id = 3 AND taskrole.status= 'Active'");
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of approvers filtered by bu 
	 	public function getApprovers() 
	 	{
	 		$this->db->select('*');
			$this->db->from('taskrole');
			$this->db->join('burole', 'burole.user_id = taskrole.user_id');
			$this->db->where("taskrole.usertype_id = 3 AND taskrole.status= 'Active' AND burole.status= 'Active' ");
			//$this->db->group_by('taskrole.user_id');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of tor types
	 	public function getTor()
	 	{
	 		$this->db->select('*');
			$this->db->from('tortypes');
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of isr types
	 	public function getIsr()
	 	{
	 		$this->db->select('*');
			$this->db->from('rfstypes');
			$this->db->where("isr = 1");
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getCompany()
	 	{
	 		$this->db->select('*');
			$this->db->from('company');
			$this->db->where('status', 'active');
			$this->db->order_by('company_code', 'ASC');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function fetch_bu($ids)
		{
		  	$this->db->select('*');
			$this->db->from('business_unit');
		  	$this->db->where('company_code', $ids);
		  	$this->db->where('status', 'active');
		  	$this->db->order_by('business_unit', 'ASC');
		  	$query = $this->db->get();
			return $query->result();

		  	// $query = $this->db->get('business_unit');
		  	// $output = '<option value="">Select Business Unit</option>';
		  	// foreach($query->result() as $row)
		  	// {
		   // 		$output .= '<option value="'.$row->id.'">'.$row->business_unit.'</option>';
		  	// }
		  	// return $output;
		}

		//gets the list of bu which is active
	 	public function getBu()
	 	{
	 		$this->db->select('*');
			$this->db->from('business_unit');
			$this->db->where('status', 'active');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of logs
	 	public function getLogs()
	 	{
	 		$this->db->select('*');
	 		
			$this->db->from('logs');
			
			$query = $this->db->get();
			return $query->result();
	 	}

	 	public function getRLogs()
	 	{
	 		$this->db->select('*');
	 		
			$this->db->from('logs');
			$this->db->where('type', 'Request');
			$query = $this->db->get();
			return $query->result();
	 	}

	 	//gets the list of bu filtered by company code
	 	public function getBuCompcode($ids)
	 	{
	 		$this->db->select('*');
			$this->db->from('business_unit');
			$this->db->where('status', 'active');
			$this->db->where('company_code', $ids );
			$query = $this->db->get();
			return $query->result();
	 	}

	 	
	 	public function insertUsers($data) {
	 		if ($this->db->insert("users", $data)) {
	 			return true;
	 		}
	 	}

	 	//adds bu access to the user
	 	public function insert_Burole($data2) {
	 		if ($this->db->insert("burole", $data2)) {
	 			return true;
	 		}
	 	}

	 	//adds task to the bu 
	 	public function insert_BuTaskrole($data2) {
	 		if ($this->db->insert("butaskrole", $data2)) {
	 			return true;
	 		}
	 	}

	 	//adds access to the user
	 	public function insert_Taskrole($data3) {
	 		if ($this->db->insert("taskrole", $data3)) {
	 			return true;
	 		}
	 	}

	 	//adds rfs access to the user
	 	public function insert_Rfsrole($data3) {
	 		if ($this->db->insert("userrfstypes", $data3)) {
	 			return true;
	 		}
	 	}

	 	//adds tor access to the user
	 	public function insert_Torrole($data3) {
	 		if ($this->db->insert("usertortypes", $data3)) {
	 			return true;
	 		}
	 	}

	 	//adds isr access to the user
	 	public function insert_Isrrole($data3) {
	 		if ($this->db->insert("userisrtypes", $data3)) {
	 			return true;
	 		}
	 	}

	 	//adds group access to the user
	 	public function insert_Grouprole($data2) {
	 		if ($this->db->insert("grouprole", $data2)) {
	 			return true;
	 		}
	 	}

	 	public function insertRequests($data) {
	 		date_default_timezone_set('Asia/Manila');
	 		if ($this->db->insert("requests", $data)) {
	 			return true;
	 		}
	 	}

	 	public function insertAttachments($data) {
	 		date_default_timezone_set('Asia/Manila');
	 		if ($this->db->insert("attachments", $data)) {
	 			return true;
	 		}
	 	}

	 	public function insertComp($data) {
	 		if ($this->db->insert("company", $data)) {
	 			return true;
	 		}
	 	}

	 	public function insertGroup($data) {
	 		if ($this->db->insert("usergroups", $data)) {
	 			return true;
	 		}
	 	}

	 	public function insertBu($data) {
	 		if ($this->db->insert("business_unit", $data)) {
	 			return true;
	 		}
	 	}

	 	public function insertBu2($data) {
	 		if ($this->db->insert("business_unit", $data)) {
	 			return true;
	 		}
	 	}

	 	public function updateBu($data,$id) {
	 		$this->db->set($data);
	 		$this->db->where("id", $id);
	 		$this->db->update("business_unit", $data);
	 	}

	 	public function updateUsers($data,$user_id) {
	 		$this->db->set($data);
	 		$this->db->where("user_id", $user_id);
	 		$this->db->update("users2", $data);
	 	}

	 	public function saveRemarks($data,$request_id) {
	 		$this->db->set($data);
	 		$this->db->where("id", $request_id);
	 		$this->db->update("requests", $data);
	 	}

	 	public function updateRfs($data,$request_id) {
	 		$this->db->set($data);
	 		$this->db->where("id", $request_id);
	 		$this->db->update("requests", $data);
	 	}

	 	public function updateTor($data,$request_id) {
	 		$this->db->set($data);
	 		$this->db->where("id", $request_id);
	 		$this->db->update("requests", $data);
	 	}
	 	public function updateIsr($data,$request_id) {
	 		$this->db->set($data);
	 		$this->db->where("id", $request_id);

	 		$this->db->update("requests", $data);
	 	}
	 	
	 	public function delete($id) {
	 		if ($this->db->delete("admin", "admin_id = ".$id)) {
	 			return true;
	 		}
	 	}

	 	public function checkOld($id,$password)
	 	{
	 		$this -> db->select(' * ');
	 		$this -> db->from('users2');
	 		$this -> db->where('user_id', $id);
	 		$this -> db->where('password', $password);
	 		$this -> db->limit(1);
	 		$query = $this->db-> get();
	 		return $query;
	 	} 

	 	public function changePassword($user_id, $info)
	 	{
	 		$this->db->set($info);
	 		$this->db->where('user_id', $user_id);

	 		$this->db->update('users2', $info);

	 		return $this->db->affected_rows();
	 	}

	 	public function updateProfile($data,$user_id)
	 	{
	 		$this->db->set($data);
	 		$this->db->where('user_id', $user_id);

	 		$this->db->update('users2', $data);  

	 	}

	 	public function updateProfilePic($data,$user_id)
	 	{
	 		$this->db->set($data);
	 		$this->db->where('user_id', $user_id);

	 		$this->db->update('users2', $data);  
	 		return $this->db->affected_rows();

	 	}

	public function store_user()
	{
		
		$insert = [
			'name' 			=> $this->security->xss_clean(html_entity_decode($this->input->post('name'))),
			'username' 		=> $this->security->xss_clean($this->input->post('username')),
			'company_code'        => $this->security->xss_clean($this->input->post('comp_code')),
            'bunit_code'      => $this->security->xss_clean($this->input->post('bunit_code')),
            'business_unit_id'      => $this->security->xss_clean($this->input->post('business_unit_id')),
			'password'  	=> $this->security->xss_clean(md5($this->input->post('password'))),
			'emp_id' 		=> $this->security->xss_clean($this->input->post('emp_id')),
			'profile_pic' 	=> 'default-pic.jpg',
			'allowconcern'	=> $this->security->xss_clean($this->input->post('allowconcern')),
			'allowcheck'	=> $this->security->xss_clean($this->input->post('allowcheck')),
			'allowisr'		=> $this->security->xss_clean($this->input->post('allowisr')),

		];

		$this->db->insert('users2',$insert);
		return $this->db->insert_id();
	}

	public function store_user_cebu()
	{
		if ($this->input->post('bu') == '80') {
			$bunit_code = '02';
		}else{
			$bunit_code = '01';
		}

		$insert = [
			'name' 			=> $this->security->xss_clean(html_entity_decode($this->input->post('name'))),
			'username' 		=> $this->security->xss_clean($this->input->post('username')),
			'company_code'  => $this->security->xss_clean($this->input->post('comp_code')),
            'bunit_code'      => $bunit_code,
            'business_unit_id'   => $this->security->xss_clean($this->input->post('bu')),
			'password'  	=> $this->security->xss_clean(md5($this->input->post('password'))),
			'emp_id' 		=> $this->security->xss_clean($this->input->post('emp_id')),
			'profile_pic' 	=> 'default-pic.jpg',
			'allowconcern'	=> $this->security->xss_clean($this->input->post('allowconcern')),
			'allowcheck'	=> $this->security->xss_clean($this->input->post('allowcheck')),
			'allowisr'		=> $this->security->xss_clean($this->input->post('allowisr')),
			'cebu'			=> 1,
		];

		$this->db->insert('users2',$insert);
		return $this->db->insert_id();
	}

	public function store_task_role($user_id, $task)
	{
		$insert = [
			'usertype_id' 	=> $task,
			'user_id' 		=> $user_id
		];

		return $this->db->insert('taskrole', $insert);
	}

	public function store_user_group($user_id, $group)
	{
		$insert = [
			'group_id' 	=> $group,
			'user_id' 	=> $user_id
		];

		return $this->db->insert('grouprole', $insert);
	}

	public function store_bu($user_id)
	{
		$bunit_code = $this->Admin_Model->getUserBu($this->input->post('bunit_code'),$this->input->post('comp_code') );
		$insert = [
			'bunit_code' 	=> $bunit_code->id,
			'company_code' 	=> $this->security->xss_clean($this->input->post('comp_code')),
			'user_id' 	=> $user_id
		];

		return $this->db->insert('burole', $insert);
	}

	public function store_bu_cebu($user_id)
	{
		//$bunit_code = $this->Admin_Model->getUserBu($this->input->post('bunit_code'),$this->input->post('comp_code') );
		$insert = [
			'bunit_code' 	=> $this->security->xss_clean($this->input->post('bu')),
			'company_code' 	=> $this->security->xss_clean($this->input->post('comp_code')),
			'user_id' 	=> $user_id
		];

		return $this->db->insert('burole', $insert);
	}
}
?>
