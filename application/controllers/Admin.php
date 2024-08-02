<?php
	class Admin extends CI_Controller {

		function __construct()
		{
			parent::__construct();            
			if($this->session->username == "")
			{
				redirect('login');
			}


			$this->load->model('admin_model','Admin_Model');
            $this->load->model('employee_model');
            $this->load->model('execute_model');
            $this->load->model('verify_model');
            $this->load->model('request_model');
            $this->load->model('user_model');
            $this->load->model('File_model', 'file');
			$this->load->library('form_validation');	
            $this->load->library('fpdf');	
			$this->load->helper('url');
			$this->load->database();    
			$this->load->helper('form'); 
			$this->load->library('session');
            //$this->db3 = $this->load->database('ebs', TRUE);
		}
	
		public function index() {
            $userid = $this->session->userdata['user_id'];
            $title = 'Home';
            $this->ViewHeader($title); // loads the header filtered by usertype 
            $data['approver'] = $this->Admin_Model->getApproversCount();
            $data['rfs1']      = $this->Admin_Model->totalPendingRfs();  
            $data['tor1']      = $this->Admin_Model->totalPendingTor(); 
            $data['isr1']      = $this->Admin_Model->totalPendingIsr(); 

            $data['rfs']      = $this->execute_model->totalPendingRfsE();  
            $data['tor']      = $this->execute_model->totalPendingTorE(); 
            $data['isr']      = $this->execute_model->totalPendingIsrE();
            $data['con']      = $this->execute_model->totalPendingConE();

            $data['rfsA']      = $this->execute_model->totalPendingRfsA();  
            $data['torA']      = $this->execute_model->totalPendingTorA(); 
            $data['isrA']      = $this->execute_model->totalPendingIsrA(); 

            $data['rfsR']      = $this->verify_model->totalPendingRfsR();  
            $data['torR']      = $this->verify_model->totalPendingTorR(); 
            $data['isrR']      = $this->verify_model->totalPendingIsrR();

            $data['rfsV']      = $this->verify_model->totalPendingRfsV();  
            $data['torV']      = $this->verify_model->totalPendingTorV(); 
            $data['isrV']      = $this->verify_model->totalPendingIsrV();
            //$data['concern']      = $this->Admin_Model->totalPendingConcerns();            
            //$this->load->view('Admin/dashboard'); // loads the dashboard
            $this->load->view('Admin/dashboard',$data);
		}

        public function getDataCountByMonth() {
            //$this->load->model('ChartModel');
            $data = $this->Admin_Model->getDataCountByMonth();
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        // public function getDataCountByMonth($year = null) {
        //     // Load the model if not already loaded
        //     //$this->load->model('Admin_Model');

        //     // Call the model function with the year parameter
        //     $data = $this->Admin_Model->getDataCountByMonth($year);

        //     // Set the content type and echo the JSON-encoded data
        //     header('Content-Type: application/json');
        //     echo json_encode($data);
        // }


        public function getPendingCountByGroup() {
            //$this->load->model('ChartModel');
            $data = $this->Admin_Model->getPendingCountByGroup();
            header('Content-Type: application/json');
            echo json_encode($data);
        }

        private function handle_error($err) {
            $this->error .= $err . "\r\n";
        }

        private function handle_success($succ) {
            $this->success .= $succ . "\r\n";
        }

        public function pending_request_list() //the details of the requests list table for Execute users
        {
            $payload = $this->input->post(NULL,TRUE);
            // print_r($payload);
            // $requests = $this->Admin_Model->getRequestbyUsertype($payload);
            $requests = $this->Admin_Model->get_requests($payload);
            $data = [];
            foreach ($requests as $req) {
              
                $bu = $this->Admin_Model->bu_name($req->buid);
                $executedetails = $this->Admin_Model->getUserData2($req->executedby);
                //$executedby = $this->employee_model->find_an_employee(@$executedetails->emp_id);
                
                $canceldetails = $this->Admin_Model->getUserData2($req->cancelledby);
                //$cancelledby = $this->employee_model->find_an_employee(@$canceldetails->emp_id);
                // $executedby = $this->employee_model->find_employee_photo(@$executedetails->emp_id);
                $requestedby = $this->Admin_Model->getUserData2($req->userid);

                $sub_array = [];

                $sub_array[] = '<span style="color: red; align: center; font-weight: bold">'.$req->requestnumber.'</span>';
                
                // if($req->executedby != '0'){
                //     $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_executed));
                // }elseif($req->cancelledby != '0'){
                //     $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_cancelled));
                // }else{
                    $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->datetoday));
                // }
                $sub_array[] = $req->groupname;
                $sub_array[] = $req->companyname;
                $sub_array[] = $bu->business_unit;
                $sub_array[] = $requestedby->name;
                $sub_array[] = $req->purpose;

                
                $stat1="";

                if($req->executedby != '0'){
                    $stat1 .= $executedetails->name;        
                }
                elseif($req->reqstatus == 'Cancelled') {
                    $stat1 .= $canceldetails->name;
                }

                elseif($req->reqstatus == 'Cancelled' AND $req->executedby != '0') {
                    $stat1 .= $canceldetails->name;
                }
                else{
                   $stat1 .= '<span style="color: orange;  align: center";><i class="fa fa-question-circle fa-lg" aria-hidden="true" ></i></span>';
                }

                $sub_array[] = $stat1;

                $stat = "";
                
                if($req->executedby == '0' AND $req->cancelledby == '0'){
                    $stat .= '<span class="label label-warning">Pending</span></td>';
                }elseif ($req->reqstatus == 'Cancelled') {
                    $stat .= '<span class="label label-danger">'.$req->reqstatus.'</span></td>';
                }
                else{
                   $stat .='<span class="label label-success">Executed</span></td>';
                }    

                $sub_array[] = $stat;

                    $tor = "";
                    $isr = "";
                    $rfs = "";
                    $taskid1 = 2;
                    $taskid2 = 3;
                    if(strtoupper($payload['typeofrequest']) == 'RFS'){
                    $rfs .= '
                        <a id="RFS-'.$req->reqid.'" title="View Details RFS" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveRfsModalE" onclick=approverfs_content_e('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                       
                        
                        if($req->approvedby != '0'){
                            $rfs .= '
                                <a title="Request Status" style="color:  #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>';
                        }else{
                            $rfs .= '
                                <a title="Request Status" style="color:  orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>';
                        }
                        $sub_array[] = $rfs;
                    
                    }elseif(strtoupper($payload['typeofrequest']) == 'TOR') {
                    $tor.= '
                        <a id="TOR-'.$req->reqid.'" title="View Details TOR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveTorModalE" onclick=approvetor_content_e('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';

                        
                        if($req->approvedby != '0'){
                            $tor.= '
                                <a title="Request Status" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }else{
                            $tor.= '
                                <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }
                        $sub_array[] = $tor;
                    
                    }elseif(strtoupper($payload['typeofrequest']) == 'ISR') {
                    $isr .= '
                        <a id="ISR-'.$req->reqid.'" title="View Details ISR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveIsrModalE" onclick=approveisr_content_e('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';

                        
                        if($req->approvedby != '0'){
                            $isr .= '
                                <a title="Request Status" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }else{
                            $isr .= '
                                <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }
                        $sub_array[] = $isr;
                    }
                $data[] = $sub_array;
            }

            $output = array(  
                "draw"                      =>     intval($_POST["draw"]),  
                "recordsTotal"              =>     $this->Admin_Model->get_all_data1(),  
                "recordsFiltered"           =>     $this->Admin_Model->get_filtered_data1($payload),  
                "data"                      =>     $data  
            );

           echo json_encode($output); 

            //echo json_encode(['data' => $data]);
        }

        public function approvers_list() //the details of the requests list table for Execute users
        {
            $payload = $this->input->post(NULL,TRUE);
            // print_r($payload);
            // $requests = $this->Admin_Model->getRequestbyUsertype($payload);
            $lists = $this->Admin_Model->get_approvers($payload);
            $data = [];
            foreach ($lists as $list) {
              
                $sub_array = [];

                
                $sub_array[] = $list->name;
                $sub_array[] = $list->position;
                $sub_array[] = $list->bu;
                
               
                $data[] = $sub_array;
            }

            $output = array(  
                "draw"                      =>     intval($_POST["draw"]),  
                "recordsTotal"              =>     $this->Admin_Model->get_all_data1(),  
                "recordsFiltered"           =>     $this->Admin_Model->get_filtered_data1($payload),  
                "data"                      =>     $data  
            );

           echo json_encode($output); 

            //echo json_encode(['data' => $data]);
        }

        public function reqlogs_list() //displays the list of users in the table for Admin users
        {
        //$payload = $this->input->post(NULL,TRUE);
            $logs = $this->Admin_Model->get_reqlogs();
            //$fetch_data = $this->blacklist_model->get_blacklist();
            // print_r($logs);
            $data = [];

            foreach ($logs as $reqlog) {
                
                $request_no = $this->Admin_Model->request_no($reqlog->request_id);

                $sub_array = [];

                // $sub_array[] = '<span style="display: hidden;">'.$reqlog->id.'</span>';
                $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($reqlog->date));
                $sub_array[] = $reqlog->rtype;
                // $requesttype = "";
                    if($reqlog->rtype == 'RFS'){
                        $sub_array[] = '<a style="color: red; font-weight: bold; cursor: pointer"  data-toggle="modal" data-target="#ApproveRfsModal" onclick=approverfs_content('.$request_no->id.')>'.$reqlog->request_id.'</a>';
                    }elseif ($reqlog->rtype == 'TOR') {
                        $sub_array[] = '<a style="color: red; font-weight: bold; cursor: pointer"  data-toggle="modal" data-target="#ApproveTorModal" onclick=approvetor_content('.$request_no->id.')>'.$reqlog->request_id.'</a>';
                    }elseif ($reqlog->rtype == "" AND $reqlog->type == "Request") {
                        $sub_array[] ='<td><a style="color: red; font-weight: bold; ">'.$reqlog->request_id.'</a>';
                    }else{
                       $sub_array[] ='<td><a style="color: red; font-weight: bold; cursor: pointer"  data-toggle="modal" data-target="#ApproveIsrModal" onclick=approveisr_content('.$request_no->id.')>'.$reqlog->request_id.'</a>';
                    }    
                // $sub_array[] = $requesttype;
                $sub_array[] = $reqlog->action;
                 
                $data[] = $sub_array;
                }

                $output = array(  
                    "draw"                      =>     intval($_POST["draw"]),  
                    "recordsTotal"              =>     $this->Admin_Model->get_all_data(),  
                    "recordsFiltered"           =>     $this->Admin_Model->get_filtered_data(),  
                    "data"                      =>     $data  
                );  
               echo json_encode($output); 

            // echo json_encode(['data' => $data]); '<a id="edit2-'.$id.'" class="action" style="color: inherit">'.$user->name.'</a>';
        }

        public function logs_list() //displays the list of users in the table for Admin users
        {
        //$payload = $this->input->post(NULL,TRUE);
            $logs = $this->Admin_Model->get_logs();
            //$fetch_data = $this->blacklist_model->get_blacklist();
            // print_r($logs);
            $data = [];

            foreach ($logs as $reqlog) {
                
                //$request_no = $this->Admin_Model->request_no($reqlog->request_id);

                $sub_array = [];

                // $sub_array[] = '<span style="display: hidden;">'.$reqlog->id.'</span>';
                $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($reqlog->date));
                $sub_array[] = $reqlog->action;
                 
                $data[] = $sub_array;
                }

                $output = array(  
                    "draw"                      =>     intval($_POST["draw"]),  
                    "recordsTotal"              =>     $this->Admin_Model->get_all_data(),  
                    "recordsFiltered"           =>     $this->Admin_Model->get_filtered_data2(),  
                    "data"                      =>     $data  
                );  
               echo json_encode($output); 

            // echo json_encode(['data' => $data]); '<a id="edit2-'.$id.'" class="action" style="color: inherit">'.$user->name.'</a>';
        }

		public function ViewHeader($title) //displays the header
        {

			$userid = $this->session->userdata['user_id']; // extracts the user id of the currently logged in user
			$data['getType1'] = $this->Admin_Model->getType1($userid); // returns usertype which is admin for the sidebar menu
			$data['getType2'] = $this->Admin_Model->getType2($userid); // returns usertype which is request for the sidebar menu
			$data['getType3'] = $this->Admin_Model->getType3($userid); // returns usertype which is approve for the sidebar menu
			$data['getType4'] = $this->Admin_Model->getType4($userid); // returns usertype which is execute for the sidebar menu
			$data['getType5'] = $this->Admin_Model->getType5($userid);
            $data['getType6'] = $this->Admin_Model->getType6($userid);
            $data['getIsr']     = $this->Admin_Model->getAllowIsr($userid);
            $data['getConcern'] = $this->Admin_Model->getConcernMenu($userid);
            $data['page_title'] = $title;
            //$data['approver'] = $this->Admin_Model->getApproversCount();
            
            $data['rfs']      = $this->execute_model->totalPendingRfsE();  
            $data['tor']      = $this->execute_model->totalPendingTorE(); 
            $data['isr']      = $this->execute_model->totalPendingIsrE();
            $data['con']      = $this->execute_model->totalPendingConE();

            $data['rfsA']      = $this->execute_model->totalPendingRfsA();  
            $data['torA']      = $this->execute_model->totalPendingTorA(); 
            $data['isrA']      = $this->execute_model->totalPendingIsrA(); 

            $data['rfsR']      = $this->verify_model->totalPendingRfsR();  
            $data['torR']      = $this->verify_model->totalPendingTorR(); 
            $data['isrR']      = $this->verify_model->totalPendingIsrR();

            $data['rfsV']      = $this->verify_model->totalPendingRfsV();  
            $data['torV']      = $this->verify_model->totalPendingTorV(); 
            $data['isrV']      = $this->verify_model->totalPendingIsrV(); 
			$this->load->view('templates/header', $data); // loads the header.php in views
		}

        public function ViewContact()
        {
            $title = 'Contact';
            $data['emp'] = $this->employee_model->find_employee_photo();
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Contact_view',$data); // loads the Users_view.php in views

        }

		public function ViewUsers()
		{
            $title = 'Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype   
			$this->load->view('Admin/Users_view'); // loads the Users_view.php in views

		}

        public function ViewUsersCebu()
        {
            $title = 'Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Users_view_Cebu'); // loads the Users_view.php in views

        }


        public function ViewReq()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user

            $req = $this->security->xss_clean($this->input->post('rfs_no'));
            $data['type'] = 'RFS';
            $data['getTracker'] = $this->request_model->get_requests_data3($req,$data['type']); // returns the record of all users from users table
            $title = 'Request';
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Tracker_view',$data); // loads the Users_view.php in views
            //redirect('view-users');
        }

        public function ViewReqTor()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user

            $req = $this->security->xss_clean($this->input->post('tor_no'));
            $data['type'] = 'TOR';
            $data['getTracker'] = $this->request_model->get_requests_data3($req,$data['type']); // returns the record of all users from users table
            $title = 'Request';
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Tracker_view',$data); // loads the Users_view.php in views
            //redirect('view-users');
        }

        public function ViewUsergroup()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['getUsergroup'] = $this->Admin_Model->getAllUserGroup(); // returns the record of all users from users table
            $title = 'Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Usergroups_view',$data); // loads the Users_view.php in views
        }

        public function ViewPending()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $title = 'Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype   
            $this->load->view('Admin/Pending_request'); // loads the Users_view.php in views
        }

        public function ViewApprovers()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['getApprovers'] = $this->Admin_Model->getApprovers();  
            $title = 'Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype    
            $this->load->view('Admin/Approver_list_view',$data);
        }

		public function ViewBu()
		{
			$data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
			$title = 'BU Setup';
            $this->ViewHeader($title); // loads the header filtered by usertype   
			$data['getComp'] = $this->Admin_Model->getCompany(); //  returns the record of all companies from company table
			$code = $this->input->post('uid'); // company code passed through AJAX from Bu_view.php in views   
            $data['getComp1'] = $this->Admin_Model->getBuCompcode($code); // returns the record of companies filtered by company code from company table
			$this->load->view('Admin/Bu_view',$data);  // loads the Users_view.php in views
			
		}

        public function ViewLogs()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            //$data['getLogs'] = $this->Admin_Model->getLogs();  // returns the record of all logs from logs table
            $title = 'Logs';
            $this->ViewHeader($title); // loads the header filtered by usertype   
              
            $this->load->view('Admin/Logs_view');
        }

        public function ViewReqLogs()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
           // $data['getLogs'] = $this->Admin_Model->getRLogs();  // returns the record of all logs from logs table
            $title = 'Logs';
            $this->ViewHeader($title); // loads the header filtered by usertype   
              
            $this->load->view('Admin/Reqlogs_view');
        }

        //loads the page to edit the bu access for rfs, tor, isr
		public function editbu_content2()
        {
        	$row = $this->Admin_Model->getData2($_POST['ids']);
        	$row1 = $this->Admin_Model->getDataBu($_POST['ids']);
        	$data3 = $this->Admin_Model->getTask2();
        	

        	echo'<div class="alert alert-success" id="msg" role="alert" style="display: none">Access updated! <button data-dismiss="alert"  class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button></div><br>';       
        	echo'<div> Current Bu: <b>'.$row1->business_unit.'</b></div><br>';
        	
        	echo'<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#rfs_access" aria-controls="rfs" role="tab" data-toggle="tab">RFS</a></li>
                	<li role="presentation" ><a href="#tor_access" aria-controls="tor" role="tab" data-toggle="tab">TOR</a></li>
                	<li role="presentation" ><a href="#isr_access" aria-controls="isr" role="tab" data-toggle="tab">ISR</a></li>';
                
            echo'</ul><br>';
            echo'<div class="tab-content">      
                    <div role="tabpanel" class="tab-pane active" id="rfs_access">
						<table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>User Type</th>	                                        
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    $rfstype = "RFS";
                                	$index = 1; 
                                	foreach($data3 as $m) :
                            	echo'<tr>   
                                        <td>'.$m->taskrfs.'</td>
                                        <td>';                                               	
                                        	if($this->Admin_Model->getBu2($m->theorder,$row1->id, $rfstype) == true){
                                               
                                        	echo'<form class="form-inline" id="updatestatus" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                	<input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
		                                     		<input type="hidden" id="rfstype'.$index.'" name="rfstype" value="RFS">
                                      				<input class="largerCheckbox" type="checkbox" id="" name="" checked onclick="updatestatusburole('.$index.')">	                                      	
                                         		</form>';
                                        	}else{

                                        	echo'<form class="form-inline" id="updatestatus" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                	<input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
		                                     		<input type="hidden" id="rfstype'.$index.'" name="rfstype" value="RFS">
                                      				<input class="largerCheckbox" type="checkbox" id="" name="" onclick="updatestatusburole('.$index.')">                                      		
                                        		</form>';
                                        	}  
                                	echo'</td>
                                    </tr>';
                                	$index++; 
                                	endforeach;
                    		echo'</tbody>
                        </table>                   
                	</div>

                    <div role="tabpanel" class="tab-pane" id="tor_access">';	                    
                	echo'<div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>User Type</th>	                                        
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    $torrtype = "TOR";
                                	$index = 1; 
                                	foreach($data3 as $m) :
                            	echo'<tr>   
                                        <td>'.$m->tasktor.'</td>
                                        <td>';                                               	
                                        	if($this->Admin_Model->getBu2($m->theorder,$row1->id, $torrtype) == true){
                                            echo'<form class="form-inline" id="updatestatusburole1" method="post">
                                                    <input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                    <input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
                                                    <input type="hidden" id="tortype'.$index.'" name="tortype" value="TOR">
                                                    <input class="largerCheckbox" type="checkbox" id="" name="" checked onclick="updatestatusburole1('.$index.')">                                           
                                                </form>';
                                            }else{

                                            echo'<form class="form-inline" id="updatestatusburole1" method="post">
                                                    <input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                    <input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
                                                    <input type="hidden" id="tortype'.$index.'" name="tortype" value="TOR">
                                                    <input class="largerCheckbox" type="checkbox" id="" name="" onclick="updatestatusburole1('.$index.')">                                           
                                                </form>';
                                            }  
                                	echo'</td>
                                    </tr>';
                                	$index++; 
                                	endforeach;
                    		echo'</tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="isr_access">';	                        
               		echo'<div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>User Type</th>                                          
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                    $isrtype = "ISR";
                                    $index = 1; 
                                    foreach($data3 as $m) :
                                echo'<tr>   
                                        <td>'.$m->taskrfs.'</td>
                                        <td>';                                                  
                                            if($this->Admin_Model->getBu2($m->theorder,$row1->id, $isrtype) == true){
                                            echo'<form class="form-inline" id="updatestatus" method="post">
                                                    <input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                    <input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
                                                    <input type="hidden" id="isrtype'.$index.'" name="isrtype" value="ISR">
                                                    <input class="largerCheckbox" type="checkbox" id="" name="" checked onclick="updatestatusburole2('.$index.')">                                           
                                                </form>';
                                            }else{

                                            echo'<form class="form-inline" id="updatestatus" method="post">
                                                    <input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row1->id.'">
                                                    <input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$m->theorder.'">
                                                    <input type="hidden" id="isrtype'.$index.'" name="isrtype" value="ISR">
                                                    <input class="largerCheckbox" type="checkbox" id="" name="" onclick="updatestatusburole2('.$index.')">                                           
                                                </form>';
                                            }  
                                    echo'</td>
                                    </tr>';
                                    $index++; 
                                    endforeach;
                            echo'</tbody>
                            </table>
                        </div>
                    </div>

                	
        		</div>';
        }

        public function fetch_bu()
        {
            if($this->input->post('comp_id'))
            {
                $this->Admin_Model->fetch_bu($this->input->post('comp_id'));
            }
        }

        // loads the content for adding new user and the data is coming from hrms
		public function adduser_content()
		{
            $emp_id = $this->input->post('emp_id', TRUE);

            $emp = $this->employee_model->employee_details($emp_id);

            $cc = $this->employee_model->company_name($emp->company_code);
            $bu = $this->employee_model->bu_name($emp->bunit_code, $emp->company_code);
            $buid = $this->Admin_Model->getUserBu($emp->bunit_code, $emp->company_code);
            $dept = $this->employee_model->dept_name($emp->bunit_code, $emp->company_code, $emp->dept_code);
            $sect = $this->employee_model->sect_name($emp->bunit_code, $emp->company_code, $emp->dept_code, $emp->section_code);
            $tasks = $this->Admin_Model->getTask();
            $groups = $this->Admin_Model->getUserGroup();
            
            $data = [
                'request' => 'add-user-form',
                'emp' => $emp,
                'cc'    =>$cc,
                'bu' =>$bu,
                'business_unit_id' =>$buid,
                'dept' =>$dept,
                'sect' =>$sect,
                'tasks' => $tasks,
                'groups' => $groups
            ];

            $this->load->view('modal_response', $data);
			
		}

        public function adduser_content_cebu()
        {
            $emp_id = $this->input->post('emp_id', TRUE);

            //$emp = $this->employee_model->employee_details($emp_id);

            // $cc = $this->employee_model->company_name($emp->company_code);
            // $bu = $this->employee_model->bu_name($emp->bunit_code, $emp->company_code);
            // $buid = $this->Admin_Model->getUserBu($emp->bunit_code, $emp->company_code);
            // $dept = $this->employee_model->dept_name($emp->bunit_code, $emp->company_code, $emp->dept_code);
            // $sect = $this->employee_model->sect_name($emp->bunit_code, $emp->company_code, $emp->dept_code, $emp->section_code);
            $tasks = $this->Admin_Model->getTask();
            $groups = $this->Admin_Model->getUserGroup();
            
            $data = [
                'request' => 'add-user-form-cebu',
                
                
                'tasks' => $tasks,
                'groups' => $groups
            ];

            $this->load->view('modal_response_cebu', $data);
            
        }

        //displays the list of bu by company
		public function bu_contents()
        {
	        $code = $this->input->post('uid');    
		    $data9 = $this->Admin_Model->getBuCompcode($code);
        	$index = 1; 
            foreach($data9 as $m) :
    	echo'<tr> 
                
                <td>'.$m->business_unit.'</td>
                <td> 
                
                <a title="Modify BU" style="color: orange"  data-toggle="modal" data-target="#editBuModal2" onclick="editbu_content2('.$m->id.')"><i class="fa fa-cog fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;</td>
        	</tr>';
            $index++; 
            endforeach;
            // <a title="Modify BU" style="color: orange" data-toggle="modal" data-target="#editBuModal" onclick="editbu_content('.$m->id.')"><i class="fa fa-edit fa-lg" aria-hidden="true" ></a>&nbsp;&nbsp; || &nbsp;
        }

		//displays content for updating user details
		public function edituser_content()
        {
            //$row = $this->employee_model->find_an_employee($_POST['ids']);
            //$userdetails = $this->user_model->getuserDetails2($_POST['ids']);
            // <input type="hidden" class="form-control" name="cc" id="cc" autocomplete="off" value="'.$userdetails->company_code.'" required>
            // <input type="hidden" class="form-control" name="bu" id="bu" autocomplete="off" value="'.$userdetails->bunit_code.'" required>
            $row  = $this->Admin_Model->getUserData2($_POST['ids']);
            $buid = $this->Admin_Model->getUserBu($row->bunit_code, $row->company_code);
            $userdetails = $this->employee_model->find_an_employee($row->emp_id);
            $profile = $this->employee_model->find_employee_name($row->emp_id);

                    if($profile == ''){
                        $str = $row->profile_pic;
                    }else{
                        $str = ltrim($profile->photo, '.');
                    }
            @$cc = $this->employee_model->company_name(@$userdetails->company_code);
            @$bu = $this->employee_model->bu_name(@$userdetails->bunit_code, @$userdetails->company_code);
           
			echo   	'<div class="alert alert-danger" id="msg" role="alert" style="display: none">Ayaw Kol!</div>';
            echo 	'<div class ="row">
                        <div id="responseMessage" class="emp-details"></div>
    	                <div class="col-md-6">';
                        if($this->session->superadmin == 'Yes'){
                        echo'<div class="form-group">
                                <img src="http://172.16.161.34:8080/hrms'.$str.'" class="img-thumbnail rounded mb-2" alt="User Image" style="height: 200px; width: 200px;">
                            </div> ';
                        }
                            
    		            echo'<div class="form-group">
    		                    <label for="username">Username</label>
                                <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->user_id.'" required>
                                <input type="hidden" class="form-control" name="bu" id="bu" autocomplete="off" value="'.$buid->id.'" required>
    		                    <input type="text" class="form-control" name="username" id="username" autocomplete="off" value="'.$row->username.'" required ">
    		                </div>
    	                </div>
	                
	                </div>
	                
	                <div class="form-group">
	                    <label for=""> Concern Menu: </label>&nbsp;';
	                    if($row->allowconcern == '1'){
	        echo            '<input type="checkbox" id="allowconcern" name="allowconcern" value="1" checked>';
	                    }else{
	        echo   			'<input type="checkbox" id="allowconcern" name="allowconcern" value="1">';
	                    }                            
	        echo	'</div>

                    <div class="form-group">
                        <label for=""> ISR Menu: </label>&nbsp;';
                        if($row->allowisr == '1'){
            echo            '<input type="checkbox" id="allowisr" name="allowisr" value="1" checked>';
                        }else{
            echo            '<input type="checkbox" id="allowisr" name="allowisr" value="1">';
                        }                            
            echo    '</div>
	                
	                <button type="submit" class="btn btn-primary"  value="Submit"><i class="fa fa-save"></i> Submit</button>
	                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>';
        }

        public function userTasks_content()
        {
            
            $row  = $this->Admin_Model->getUserData2($_POST['ids']);
            $data3 = $this->Admin_Model->getTaskperUser($_POST['ids']);
            echo'<div> Current User: <b>'.$row->name.'</b></div><br>';
            echo'<div class ="row">';
                foreach($data3 as $m) :
                echo'<ul>   
                        <li>'.$m->usertype.'</li>
                    </ul>';
                endforeach;    
            echo'</div>';
        }
        //displays content for updating user access 
        public function edituser_content2()
        {
        	$row   = $this->Admin_Model->getData2($_POST['ids']);
            $userdetails = $this->user_model->getuserDetails2($_POST['ids']);
        	//$row1  = $this->employee_model->find_an_employee($userdetails->emp_id);
            $row1  = $this->Admin_Model->getUserData2($_POST['ids']);
        	$data3 = $this->Admin_Model->getTask();
        	$data4 = $this->Admin_Model->getRfs();
        	$data5 = $this->Admin_Model->getTor();
        	$data6 = $this->Admin_Model->getIsr();
        	$data7 = $this->Admin_Model->getUserGroup();
        	
        	$company = $this->Admin_Model->getCompany();

        	echo'<div class="alert alert-success" id="msg" role="alert" style="display: none">Access updated! <button data-dismiss="alert"  class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button></div><br>';       
        	echo'<div> Current User: <b>'.$row1->name.'</b></div><br>';
        	
        	echo'<ul class="nav nav-tabs" role="tablist">';
				
            	echo'<li role="presentation" class="active"><a href="#requests" aria-controls="requests" role="tab" data-toggle="tab">Requests</a></li>
                	<li role="presentation" ><a href="#tasks1" aria-controls="tasks1" role="tab" data-toggle="tab">Tasks</a></li>
                	<li role="presentation" ><a href="#groups1" aria-controls="groups1" role="tab" data-toggle="tab">User Groups</a></li>
                	<li role="presentation" ><a href="#bu1" aria-controls="bu1" role="tab" data-toggle="tab">Business Unit</a></li>';
                
            echo'</ul><br>';
            echo'<div class="tab-content">      
                    <div role="tabpanel" class="tab-pane active" id="requests">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						    
						    <div class="panel panel-default">
							    <div class="panel-heading" role="tab" id="headingOne">
							        <h5 class="panel-title">
							        	<a style="padding:10px;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								          	<b>RFS - Request for Setup</b>
								        </a>
							      	</h5>
							    </div>
							    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
							        <div  class="panel-body">
										<div class="table-responsive" >
		                                    <table style="padding: none; " class="table table-bordered table-striped" cellspacing="0">
		                                        <thead  style="width: 70%;" class="thead-dark">
		                                            <tr>
			                                            
		                                            </tr>
		                                        </thead>
		                                        <tbody>';
		                                        	$index = 1; 
		                                            foreach($data4 as $m) :			                                       		
                                        		echo'<tr >
		                                                <td style="width: 80%;">'.$m->requesttype.'</td>
		                                                <td>';
		                                                	if($this->Admin_Model->getData4($index,$_POST['ids']) == true){
	                                                		echo'<form class="form-inline" id="updatestatus2" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="rfs_id_'.$index.'" name="rfs_id" value="'.$index.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1" checked onchange="updatestatus2('.$index.')">
			                                      				</form>';
		                                                	}
		                                                	else{
	                                                		echo'<form class="form-inline" id="updatestatus2" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="rfs_id_'.$index.'" name="rfs_id" value="'.$index.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1"  onchange="updatestatus2('.$index.')">
	                                                 			</form>';
		                                                	}                                                          
		                                       		echo'</td>
                                            		</tr>';
			                                        $index++; 
			                                        endforeach;
		                                	echo'</tbody>
		                                    </table>
		                                </div>
							        </div>
							    </div>
						    </div>

						    <div class="panel panel-default">
						      	<div class="panel-heading" role="tab" id="headingTwo">
							        <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><b>TOR - Transaction Override Request</b>
								        </a>
							      	</h4>
						      	</div>
						      	<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						        	<div class="panel-body">
						          		<div class="table-responsive" >
		                                    <table style="padding: none;" class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
		                                        <thead class="thead-dark">
		                                            <tr>
			                                            
		                                            </tr>
		                                        </thead>
		                                        <tbody>';
		                                        	$index = 1; 
		                                            foreach($data5 as $m) :
	                                        	echo'<tr> 
		                                                <td style="width: 80%;">'.$m->tortype.'</td>
		                                                <td>';
		                                                	if($this->Admin_Model->getData5($index,$_POST['ids']) == true){
	                                                		echo'<form class="form-inline" id="updatestatus3" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="tor_id_'.$index.'" name="tor_id" value="'.$index.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1" checked onchange="updatestatus3('.$index.')">
	                                                 			</form>';
		                                                	}
		                                                	else{
		                                                	echo'<form class="form-inline" id="updatestatus3" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="tor_id_'.$index.'" name="tor_id" value="'.$index.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1"  onchange="updatestatus3('.$index.')">
		                                                 		</form>';
		                                                	}                                              
		                                       		echo'</td>
	                                            	</tr>';
			                                        $index++; 
			                                        endforeach;
			                                echo'</tbody>
		                                    </table>
	                                	</div>
						        	</div>
						      	</div>
						    </div>

						    <div class="panel panel-default">
						      	<div class="panel-heading" role="tab" id="headingThree">
						        	<h4 class="panel-title">
						        		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><b>ISR - Information System Request</b>
						        		</a>
						      		</h4>
						      	</div>
						      	<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							        <div class="panel-body">
							        	<div class="table-responsive" >
		                                    <table style="padding: none;" class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
		                                        <thead class="thead-dark">
		                                            <tr>
			                                            
		                                            </tr>
		                                        </thead>
		                                        <tbody>';
		                                        	$index = 1; 
		                                            foreach($data6 as $m) :
                                        		echo'<tr>
		                                                <td style="width: 80%;">'.$m->requesttype.'</td>
		                                                <td>';
		                                                	if($this->Admin_Model->getData6($m->id,$_POST['ids']) == true){
	                                                		echo'<form class="form-inline" id="updatestatus4" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="isr_id_'.$index.'" name="isr_id" value="'.$m->id.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1" checked onclick="updatestatus4('.$index.')">		                                      	
	                                                 			</form>';
		                                                	}
		                                                	else{
	                                                		echo'<form class="form-inline" id="updatestatus4" method="post">
				                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
				                                                	<input type="hidden" id="isr_id_'.$index.'" name="isr_id" value="'.$m->id.'">
						                                     		
				                                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1"  onclick="updatestatus4('.$index.')">			                                      	
	                                                 			</form>';
		                                                	}                                                 
		                                        	echo'</td>
                                            		</tr>';
				                                    $index++; 
				                                     endforeach;
				                            echo'</tbody>
				                            </table>
		                                </div>
							        </div>
						      	</div>
						    </div>

						</div>	                   
                	</div>

                    <div role="tabpanel" class="tab-pane" id="tasks1">';	                    
                	echo'<div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>User Type</th>	                                        
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                	$index = 1; 
                                	foreach($data3 as $m) :
                            	echo'<tr>   
                                        <td style="width: 80%;">'.$m->usertype.'</td>
                                        <td>';                                               	
                                        	if($this->Admin_Model->getData3($index,$_POST['ids']) == true){
                                        	echo'<form class="form-inline" id="updatestatus" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
                                                	<input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$index.'">
		                                     			
                                      				<input class="largerCheckbox" type="checkbox" id="" name="" checked onclick="updatestatus('.$index.')">	                                      	
                                         		</form>';
                                        	}else{

                                        	echo'<form class="form-inline" id="updatestatus" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
                                                	<input type="hidden" id="usertype_id_'.$index.'" name="usertype_id" value="'.$index.'">
		                                     		
                                      				<input class="largerCheckbox" type="checkbox" id="" name="" onclick="updatestatus('.$index.')">                                      		
                                        		</form>';
                                        	}  
                                	echo'</td>
                                    </tr>';
                                	$index++; 
                                	endforeach;
                    		echo'</tbody>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="groups1">';	                        
               		echo'<div class="table-responsive" >
                            <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>User Groups</th>	                                      
                                        <th>Access</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                	$index = 1; 
                                    foreach($data7 as $m) :
                               	echo'<tr>
                                        <td style="width: 80%;">'.$m->groupname.'</td>
                                        <td>';                                             	
                                        	if($this->Admin_Model->getData7($index,$_POST['ids']) == true){
                                        	echo'<form class="form-inline" id="updatestatus5" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
                                                	<input type="hidden" id="group_id_'.$index.'" name="group_id" value="'.$index.'">
		                                     		
                                      				<input class="largerCheckbox" type="checkbox" id="" name="" checked onclick="updatestatus5('.$index.')">
                                  				</form>';
                                        	}else{

                                        	echo'<form class="form-inline" id="updatestatus5" method="post">
                                                	<input type="hidden" id="user_id_'.$index.'" name="user_id" value="'.$row->user_id.'">
                                                	<input type="hidden" id="group_id_'.$index.'" name="group_id" value="'.$index.'">
		                                     		
                                      				<input class="largerCheckbox" type="checkbox" id="" name=""  onclick="updatestatus5('.$index.')">
                                         		</form>';
                                        	}  
                                    echo'</td>
                                    </tr>';
                                $index++; 
                                endforeach;
                    		echo'</tbody>
                            </table>
                        </div>
                    </div>

                	<div role="tabpanel" class="tab-pane" id="bu1">
                		<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">';
                                $index = 1;		                                        
                                $bu = 1;
                                	 
                                foreach($company as $m) :			                                       		                     	
                            echo '<div class="panel panel-default">
                            		<div class="panel-heading" role="tab" id="heading'.$index.'">
								        <h4 class="panel-title">
									        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse'.$index.'" aria-expanded="false" aria-controls="collapse'.$index.'"><b>'.$m->company.'</b>
									        </a>
								      	</h4>
							      	</div>
							      	<div id="collapse'.$index.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading'.$index.'">
										<div class="panel-body">
									  		<div class="table-responsive" >
									            <table style="padding: none;" class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
									                <thead class="thead-dark">
									                    
									                </thead>
									                <tbody style="padding: 10px;">';
									            		                                        
									                	$bu = 1;
									                	
									                	$data9 = $this->Admin_Model->getBuCompcode($m->company_code);
									                    foreach($data9 as $n) :			                                       		
									        		echo'<tr>
									                        <td style="width: 80%;">'.$n->business_unit.'</td>
									                        <td>';
									                        	if($this->Admin_Model->getBu1($n->id,$_POST['ids'],$m->company_code) == true){
									                    		echo'<form class="form-inline" id="updatestatusbu" method="post">
									                                	<input type="hidden" id="user_id_'.$n->id.'" name="user_id" value="'.$row->user_id.'">
									                                	<input type="hidden" id="bunit_id_'.$n->id.'" name="bunit_id" value="'.$n->id.'">
									                                	<input type="hidden" id="company_code_'.$n->id.'" name="company_code" value="'.$m->company_code.'">
									                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1" checked onchange=updatestatusbu("'.$n->id.'")>
									                  				</form>';
									                        	}
									                        	else{
									                    		echo'<form class="form-inline" id="updatestatusbu" method="post">
									                                	<input type="hidden" id="user_id_'.$n->id.'" name="user_id" value="'.$row->user_id.'">
									                                	<input type="hidden" id="bunit_id_'.$n->id.'" name="bunit_id" value="'.$n->id.'">
									                                	<input type="hidden" id="company_code_'.$n->id.'" name="company_code" value="'.$m->company_code.'">
									                      				<input class="largerCheckbox" type="checkbox" id="" name="" value="1"  onchange=updatestatusbu("'.$n->id.'")>
									                     			</form>';
									                        	}                                                          
									               		echo'</td>
									            		</tr>';
									                    
									                    $bu++; 
									                    endforeach;
									        	echo'</tbody>
									            </table>
									        </div>
										</div>
									</div>
                            	 </div>';
                                    $index++;
                                    $bu++; 
                                    endforeach;
					      echo'</div>
	               	</div>
        		</div>';
        }

        //function to update user details, passing data to Admin_model 
        public function crudupdate()
        {
			if(!empty($_POST))
            {
     			$user_id = $this->input->post('id');

				$data = array(
				//'name'     	=> $this->security->xss_clean($this->input->post('name')),
			    // 'lname'     	=> $this->security->xss_clean($this->input->post('lname')),
			    'username'      => $this->security->xss_clean($this->input->post('username')),
			    // 'company_code'        => $this->security->xss_clean($this->input->post('cc')),
                'business_unit_id'          => $this->security->xss_clean($this->input->post('bu')),
			    'allowcheck'   	=> $this->security->xss_clean($this->input->post('allowcheck')),
			    'allowconcern'  => $this->security->xss_clean($this->input->post('allowconcern')),
                'allowisr'      => $this->security->xss_clean($this->input->post('allowisr'))
				//'status'    	=> $status
				);
				
				
				$this->Admin_Model->updateUsers($data,$user_id);
				$this->session->set_flashdata('SUCCESSMSG1', "success ");

                $user_data  = $this->Admin_Model->getUserData2($user_id);
                
                //$action = $this->session->name . ' has updated the user details of ' . $user_data->name ;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . ' the user details of ' . '<b>'.$user_data->name.'</b>';
            
        
                $data1 = array(
                    'user_id'   => $this->session->user_id,
                    'action'   => $action,
                    'type'  => 'Setup'
                );
                $this->Admin_Model->addLogs($data1);
				// $this->session->set_userdata($data);
				// echo 'try';
            }
				
			$this->session->set_flashdata('SUCCESSMSG1', "success");
			redirect('view-users');
        }

        public function addgroup_content()
        {
            $sql    = "SELECT MAX(group_id) AS `controlno` FROM `usergroups`";
            $controlno =  $this->db->query($sql)->row()->controlno;
            $group_id = $controlno + 1;

            echo'<div class="alert alert-danger" id="msg" role="alert" style="display: none">Credentials already exist!</div>';
            echo'<div class ="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Group ID</label>
                            <input type="text" class="form-control" name="group_id" id="group_id" readonly autocomplete="off" value="'.$group_id.'">
                        </div>
                    </div>

                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="group">Group Name</label>
                            <input type="text" class="form-control" name="group" id="group" autocomplete="off"  placeholder="Group Name" required >
                        </div>
                    </div>
                    

                </div>
                    <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                    <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>';
        
        }

        public function groupcreate()
        {
            if(!empty($_POST))
            {
                
                $data = array(
                
                    'groupname'   => strtoupper($this->security->xss_clean($this->input->post('group'))),
                    'active'      =>  1
                
                );
                
                if($this->Admin_Model->checkGroup($this->input->post('group')) == true)
                {
                    $this->session->set_flashdata('ERRORMSG', "error ");
                    redirect('view-usergroup');
                    // echo 'try';
                }else{
                    $this->Admin_Model->insertGroup($data);

                    $group_data = $this->employee_model->group_name($_POST['id']);
                    //$action = $this->session->name . ' has activated the status of ' . $group_data->groupname ;

                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' the group ' . '<b>'.$this->security->xss_clean($this->input->post('group')).'</b>';

                        $data1 = array(
                            'user_id'   => $this->session->user_id,
                            'action'   => $action,
                            'type'  => 'Setup'
                        );
                    $this->Admin_Model->addLogs($data1);

                    $this->session->set_flashdata('SUCCESSMSG', "success ");
                    redirect('view-usergroup');
                }
            }    
        }

        //reset user's password
        public function resetPassword()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $user_id  = $this->input->post('id');
               
                $data = array(
                    
                    'password'     => $this->security->xss_clean(md5('Torrfs2022'))
                );
               
                $this->Admin_Model->updateUserStatus($data,$_POST['id']);   

                //$request_data   = $this->request_model->get_requests_data($_POST['id']);
                $user_data  = $this->Admin_Model->getUserData2($_POST['id']);
                //$action = $this->session->name . ' has activated the status of ' . $user_data->name ;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'resetted ' . '</b>' . ' the password of ' . '<b>'.$user_data->name.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        //set user status to active
        public function ActivateUserStatus()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $user_id  = $this->input->post('id');
               
                $data = array(
                    
                    'status'     => 1
                );
               
                $this->Admin_Model->updateUserStatus($data,$_POST['id']);   

                //$request_data   = $this->request_model->get_requests_data($_POST['id']);
                $user_data  = $this->Admin_Model->getUserData2($_POST['id']);
                //$action = $this->session->name . ' has activated the status of ' . $user_data->name ;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the status of ' . '<b>'.$user_data->name.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        //set user status to inactive
        public function DeactivateUserStatus()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $user_id  = $this->input->post('id');
               
                $data = array(
                    
                    'status'     => 0
                );
               
                $this->Admin_Model->updateUserStatus($data,$_POST['id']);   

                $user_data  = $this->Admin_Model->getUserData2($_POST['id']);

                //$action = $this->session->name . ' has deactivated the status of ' . $user_data->name ;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the status of ' . '<b>'.$user_data->name.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        //set usergroup status to active
        public function ActivateGroupStatus()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $user_id  = $this->input->post('id');
               
                $data = array(
                    
                    'active'     => 1
                );
               
                $this->Admin_Model->updateGroupStatus($data,$_POST['id']);

                $group_data = $this->employee_model->group_name($_POST['id']);
                //$action = $this->session->name . ' has activated the status of ' . $group_data->groupname ;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the status of the group ' . '<b>'.$group_data->groupname.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);   
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        //set usergroup status to inactive
        public function DeactivateGroupStatus()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $user_id  = $this->input->post('id');
               
                $data = array(
                    
                    'active'     => 0
                );
               
                $this->Admin_Model->updateGroupStatus($data,$_POST['id']);  

                $group_data = $this->employee_model->group_name($_POST['id']);
                //$action = $this->session->name . ' has deactivated the status of ' . $group_data->groupname ;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the status of the group ' . '<b>'.$group_data->groupname.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);  
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        //update bu rfs access status
        public function UpdateStatusBuRoles()
		{
			$data = array(

				'buid' 		   => $this->input->post('uid'),
                'requesttype'  => $this->input->post('rtype'),
            	'taskid' 	   => $this->input->post('type')	
			);
			$result = $this->db->get_where('butaskrole', $data);
			 
			if ($result->num_rows() > 0) {
				$bu_id     = $this->input->post('uid');
				$task_id   = $this->input->post('type');
                $rtype     = $this->input->post('rtype');
				if($result1 = $this->Admin_Model->getBu2($task_id,$bu_id, $rtype) == true)
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}

				$data1 = array(
				
	            	'status'	=>$stat	
				);
				 
            	$this->Admin_Model->updateStatusBuRoles($data1,$bu_id,$task_id,$rtype);

                $task_data  = $this->employee_model->task_name2($task_id);
                $bu_data  = $this->Admin_Model->bu_name($bu_id);
                
                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the RFS usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the RFS usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }
            
                    $data1 = array( 
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            	
	        } 
	        else {
	            
				$data2 = array(
					'buid'         =>  $this->input->post('uid'),
                    'requesttype'  =>  $this->input->post('rtype'),
                    'taskid'       =>  $this->input->post('type'),
	            	'status'	   =>'Active'	
				);
				$this->Admin_Model->insert_BuTaskrole($data2);

                $task_data  = $this->employee_model->task_name2($this->input->post('type'));
                $bu_data  = $this->Admin_Model->bu_name($this->input->post('uid'));

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . 'RFS usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') to the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
				
	        }
		}

        //update bu tor access status
        public function UpdateStatusBuRoles1()
        {
            $data = array(

                'buid'         => $this->input->post('uid'),
                'requesttype'  => $this->input->post('rtype'),
                'taskid'       => $this->input->post('type')    
            );
            $result = $this->db->get_where('butaskrole', $data);
             
            if ($result->num_rows() > 0) {
                $bu_id     = $this->input->post('uid');
                $task_id   = $this->input->post('type');
                $rtype     = $this->input->post('rtype');
                if($result1 = $this->Admin_Model->getBu2($task_id,$bu_id, $rtype) == true)
                {
                    $stat = 'Inactive';
                }
                else
                {
                    $stat = "Active";
                }

                $data1 = array(
                
                    'status'        =>$stat 
                );
                 
                $this->Admin_Model->updateStatusBuRoles($data1,$bu_id,$task_id,$rtype);

                $task_data  = $this->employee_model->task_name2($task_id);
                $bu_data  = $this->Admin_Model->bu_name($bu_id);
                
                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the TOR usertype access (' . '<b>' .$task_data->tasktor . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the TOR usertype access (' . '<b>' .$task_data->tasktor . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }
            
                    $data1 = array( 
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
                
            } 
            else {
                
                $data2 = array(
                    'buid'         =>  $this->input->post('uid'),
                    'requesttype'  =>  $this->input->post('rtype'),
                    'taskid'       =>  $this->input->post('type'),
                    'status'       =>'Active'   
                );
                $this->Admin_Model->insert_BuTaskrole($data2);

                $task_data  = $this->employee_model->task_name2($this->input->post('type'));
                $bu_data  = $this->Admin_Model->bu_name($this->input->post('uid'));

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . 'TOR usertype access (' . '<b>' .$task_data->tasktor . '</b>' . ') to the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
                
            }
        }

        //update bu isr access status
        public function UpdateStatusBuRoles2()
        {
            $data = array(

                'buid'         => $this->input->post('uid'),
                'requesttype'  => $this->input->post('rtype'),
                'taskid'       => $this->input->post('type')    
            );
            $result = $this->db->get_where('butaskrole', $data);
             
            if ($result->num_rows() > 0) {
                $bu_id     = $this->input->post('uid');
                $task_id   = $this->input->post('type');
                $rtype     = $this->input->post('rtype');
                if($result1 = $this->Admin_Model->getBu2($task_id,$bu_id, $rtype) == true)
                {
                    $stat = 'Inactive';
                }
                else
                {
                    $stat = "Active";
                }

                $data1 = array(
                
                    'status'        =>$stat 
                );
                 
                $this->Admin_Model->updateStatusBuRoles($data1,$bu_id,$task_id,$rtype);

                $task_data  = $this->employee_model->task_name2($task_id);
                $bu_data  = $this->Admin_Model->bu_name($bu_id);
                
                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the ISR usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the ISR usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') of the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';
                }
            
                    $data1 = array( 
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
                
            } 
            else {
                
                $data2 = array(
                    'buid'         =>  $this->input->post('uid'),
                    'requesttype'  =>  $this->input->post('rtype'),
                    'taskid'       =>  $this->input->post('type'),
                    'status'       =>'Active'   
                );
                $this->Admin_Model->insert_BuTaskrole($data2);

                $task_data  = $this->employee_model->task_name2($this->input->post('type'));
                $bu_data  = $this->Admin_Model->bu_name($this->input->post('uid'));

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . 'ISR usertype access (' . '<b>' .$task_data->taskrfs . '</b>' . ') to the (' . '<b>' .$bu_data->business_unit. '</b>' .') business unit';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
                
            }
        }

        //bu access
        public function UpdateStatusBu()
		{
			$data = array(

				'user_id' 		=> $this->input->post('uid'),
				'company_code' 	=> $this->input->post('comp'),
            	'bunit_code' 	=> $this->input->post('type')
            	
			);
			$result = $this->db->get_where('burole', $data);
			 	$user_id 	=	$this->input->post('uid');
				$utype_id 	= 	$this->input->post('type');
				$comp 		=	$this->input->post('comp');
			if ($result->num_rows() > 0) {
				if($result1 = $this->Admin_Model->getBu1($utype_id,$user_id,$comp) == true)
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}

				$data1 = array(
				
	            	'status'		=>$stat	
				);
				 //echo $stat; die(); 
            	$this->Admin_Model->updateStatusBu($data1,$user_id,$utype_id,$comp);
            	
                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $bu_data  = $this->Admin_Model->bu_name($utype_id);

                if($stat == 'Active'){
                    //$action = $this->session->name . ' has activated the user BU access (' .$bu_data->business_unit. ') of ' . $user_data->name ;

                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the user BU access (' . '<b>' .$bu_data->business_unit . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the user BU access (' . '<b>' .$bu_data->business_unit . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=> $this->input->post('uid'),
	            	'bunit_code' 	=>$this->input->post('type'),
	            	'company_code' 	=>$this->input->post('comp'),
	            	'status'		=>'Active'
				);
				$this->Admin_Model->insert_Burole($data2);

                $user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $bu_data  = $this->Admin_Model->bu_name($utype_id);

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' user BU access (' . '<b>' .$bu_data->business_unit . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
				
	        }
		}

        //tasks
	    public function UpdateStatus()
		{
			$data = array(

				'user_id' 		=> 	$this->input->post('uid'),
            	'usertype_id' 	=>	$this->input->post('type')
            	
			);
			$result = $this->db->get_where('taskrole', $data);
			 
			if ($result->num_rows() > 0) {
				$user_id = $this->input->post('uid');
				$utype_id = $this->input->post('type');
				if($result1 = $this->Admin_Model->getData3($utype_id,$user_id) == true)
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}

				$data1 = array(
				
	            	'status'		=>$stat	
				);
				 
            	$this->Admin_Model->updateStatus($data1,$user_id,$utype_id);

                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $task_data  = $this->employee_model->task_name($utype_id);

                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the user type access (' . '<b>' .$task_data->usertype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the user type access (' . '<b>' .$task_data->usertype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            	
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=> $this->input->post('uid'),
	            	'usertype_id' 	=>$this->input->post('type'),
	            	'status'		=>'Active'	
				);
				$this->Admin_Model->insert_Taskrole($data2);

                $user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $task_data  = $this->employee_model->task_name($this->input->post('type'));
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' user type access (' . '<b>' .$task_data->usertype . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
				
	        }
		}

        //requests
		public function UpdateStatusRfs()
		{
			$data = array(

				'user_id' 	=> 	$this->input->post('uid'),
            	'rfs_id' 	=>	$this->input->post('rfstype')
            	
			);
			$result = $this->db->get_where('userrfstypes', $data);
			 
			if ($result->num_rows() > 0) {
				$user_id = $this->input->post('uid');
				$rfs_id = $this->input->post('rfstype');
				if($result1 = $this->Admin_Model->getData4($rfs_id,$user_id) == true)	
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}
					$data1 = array(
					
		            	'status'		=>$stat	
					);

            	$this->Admin_Model->updateStatusRfs($data1,$user_id,$rfs_id);

                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $rfs_data  = $this->employee_model->rfs_name($rfs_id);

                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the RFS type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the RFS type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            	//$this->session->set_userdata($data);
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=>$this->input->post('uid'),
	            	'rfs_id' 		=>$this->input->post('rfstype'),
	            	'status'		=>'Active'	
				);
				$this->Admin_Model->insert_Rfsrole($data2);

                $user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $rfs_data  = $this->employee_model->rfs_name($this->input->post('rfstype'));
                //$action = $this->session->name . ' has added RFS type access (' .$rfs_data->requesttype. ') to ' . $user_data->name ;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' RFS type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
				//$this->session->set_userdata($data2);
	        }
		}

		public function UpdateStatusTor()
		{
			$data = array(

				'user_id' 		=> 	$this->input->post('uid'),
            	'tor_id' 	=>	$this->input->post('tortype')
            	
			);
			$result = $this->db->get_where('usertortypes', $data);
			 
			if ($result->num_rows() > 0) {
				$user_id = $this->input->post('uid');
				$tor_id = $this->input->post('tortype');
				if($result1 = $this->Admin_Model->getData5($tor_id,$user_id) == true)	
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}
					$data1 = array(
					
		            	'status'		=>$stat	
					);
            	$this->Admin_Model->updateStatusTor($data1,$user_id,$tor_id);
            	
                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $tor_data  = $this->employee_model->tor_name($tor_id);

                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the TOR type access (' . '<b>' .$tor_data->tortype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the TOR type access (' . '<b>' .$tor_data->tortype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=>$this->input->post('uid'),
	            	'tor_id' 		=>$this->input->post('tortype'),
	            	'status'		=>'Active'	
				);
				$this->Admin_Model->insert_Torrole($data2);
				
                $user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $tor_data  = $this->employee_model->tor_name($this->input->post('tortype'));
                //$action = $this->session->name . ' has added TOR type access (' .$tor_data->tortype. ') to ' . $user_data->name ;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' TOR type access (' . '<b>' .$tor_data->tortype . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        }
		}

		public function UpdateStatusIsr()
		{
			$data = array(

				'user_id' 		=> 	$this->input->post('uid'),
            	'isr_id' 	=>	$this->input->post('isrtype')
            	
			);
			$result = $this->db->get_where('userisrtypes', $data);
			 
			if ($result->num_rows() > 0) {
				$user_id = $this->input->post('uid');
				$isr_id = $this->input->post('isrtype');
				if($result1 = $this->Admin_Model->getData6($isr_id,$user_id) == true)	
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}
					$data1 = array(
					
		            	'status'		=>$stat	
					);
            	$this->Admin_Model->updateStatusIsr($data1,$user_id,$isr_id);
            	
                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $rfs_data  = $this->employee_model->rfs_name($isr_id);

                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the ISR type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the ISR type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=>$this->input->post('uid'),
	            	'isr_id' 		=>$this->input->post('isrtype'),
	            	'status'		=>'Active'	
				);
				$this->Admin_Model->insert_Isrrole($data2);
				
                $user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $rfs_data  = $this->employee_model->rfs_name($this->input->post('isrtype'));
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' ISR type access (' . '<b>' .$rfs_data->requesttype . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        }
		}

        //groups
		public function UpdateStatusGroup()
		{
			$data = array(

				'user_id' 		=> 	$this->input->post('uid'),
            	'group_id' 	=>	$this->input->post('group')
            	
			);
			$result = $this->db->get_where('grouprole', $data);
			 
			if ($result->num_rows() > 0) {
				$user_id = $this->input->post('uid');
				$group_id = $this->input->post('group');
				if($result1 = $this->Admin_Model->getData7($group_id,$user_id) == true)	
				{
					$stat = 'Inactive';
				}
				else
				{
					$stat = "Active";
				}
					$data1 = array(
					
		            	'status'		=>$stat	
					);
            	$this->Admin_Model->updateStatusGroup($data1,$user_id,$group_id);

                $user_data  = $this->Admin_Model->getUserData2($user_id);
                $group_data  = $this->employee_model->group_name($group_id);

                if($stat == 'Active'){
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'activated ' . '</b>' . ' the user group access (' . '<b>' .$group_data->groupname . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';

                }else{
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'deactivated ' . '</b>' . ' the user group access (' . '<b>' .$group_data->groupname . '</b>' . ') of ' . '<b>' .$user_data->name. '</b>';
                }
            
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
            	//$this->session->set_userdata($data);
	        } 
	        else {
	            
				$data2 = array(
					'user_id' 		=>$this->input->post('uid'),
	            	'group_id' 		=>$this->input->post('group'),
	            	'status'		=>'Active'	
				);
				$this->Admin_Model->insert_Grouprole($data2);

				$user_data  = $this->Admin_Model->getUserData2($this->input->post('uid'));
                $group_data  = $this->employee_model->group_name($this->input->post('group'));
                
                //$action = $this->session->name . ' has added the user group access (' .$group_data->groupname. ') to ' . $user_data->name ;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . ' user group access (' . '<b>' .$group_data->groupname . '</b>' . ') to ' . '<b>' .$user_data->name. '</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
	        }
		}

        function alpha_dash_space($str)
        {
            if (preg_match('#[0-9]#', $str) && preg_match('#[a-z]#', $str) && preg_match('/[A-Z]/', $str)) {
                return TRUE;
        }
        return FALSE;

        }

		public function Change_pass ()
		{
			$data['getUsertypes'] = $this->db->get('usertype')->result_array();
			$title = 'Setup';
            $this->ViewHeader($title); 
			$this->load->library('form_validation');
            $new = $this->input->post('newPassword');

			$this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
			$this->form_validation->set_rules('newPassword','New password','required|max_length[20]|min_length[8]|callback_alpha_dash_space');
			$this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
            $this->form_validation->set_message('alpha_dash_space', 'The password must have atleast 1 capital letter and atleast 1 number'); 

			if($this->form_validation->run() == FALSE)
			{
				
                $data['errors'] = validation_errors('<p style="color:red;">', '</p>'); 

                $this->load->view('Admin/Update_profile',$data);
			}
            
			else
			{
						//$old = $this->input->post('oldPassword');
				$old = $this->security->xss_clean(md5($this->input->post('oldPassword')));
				$admin_id = $this->session->user_id;
				$info = array(
					'password' => $this->security->xss_clean(md5($this->input->post('newPassword'))),

				);
				$query = $this->Admin_Model->CheckOld($admin_id,$old);
				if($query -> num_rows() > 0){
					$result = $this->Admin_Model->changePassword($admin_id, $info);     
					$this->session->set_flashdata('success2', 'Password updation successful the new password is: ' .$this->security->xss_clean($this->input->post('newPassword'))); 
                
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . ' his/her password';
                
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
					  
					redirect('update-profile');
				}else{
					$this->session->set_flashdata('errormsg','Old password is incorrect');
					redirect('update-profile');
				} 
			}
		}

		public function ProfileUpdateView() {
			$data['getUsertypes'] = $this->db->get('usertype')->result_array();
			$title = 'Setup';
            $this->ViewHeader($title); 
			$this->load->helper('form');
			$userid = $this->session->user_id;
			$query = $this->db->get_where("users2", $userid);
			$data['records'] = $query->row();
            
			$this->load->view('Admin/Update_profile',$data);
		}

		public function ProfileUpdate()
		{
            $data['getUsertypes'] = $this->db->get('usertype')->result_array();

            $title = 'Setup';
            $this->ViewHeader($title);
            
			if(!empty($_POST))
			{ 				
				$data = array(

					'username'     => $this->security->xss_clean($this->input->post('username'))
				);
				$user_id = $this->session->user_id;
                $check =$this->Admin_Model->checkUser($this->input->post('username')); 
                //var_dump($check);
                
                if ($check == false){
                    $this->Admin_Model->updateProfile($data,$user_id);
                    $this->session->set_flashdata('success', "Admin Record Updated Successfully!!");
                    $this->session->set_userdata($data);

                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . ' his/her username';
                    
                        $data1 = array(
                            'user_id'   => $this->session->user_id,
                            'action'   => $action,
                            'type'  => 'Setup'
                        );
                    $this->Admin_Model->addLogs($data1);
                    redirect('update-profile');
                }else{
                    $this->session->set_flashdata('errormsg2','error');
                    $user_id = $this->session->user_id;
                    //$this->Admin_Model->updateProfile($data,$admin_id);
                // $data['records'] = $this->Admin_Model->view_info($user_id);
                // $this->load->view('Admin/Update_profile',$data);
                    redirect('update-profile');
                }
				
				
				
			}
			else
			{
				$user_id = $this->session->user_id;
					//$this->Admin_Model->updateProfile($data,$admin_id);
				$data['records'] = $this->Admin_Model->view_info($user_id);
				$this->load->view('Admin/Update_profile',$data);
			}
		}


        public function ProfilePicUpdateView() {

            $data['getUsertypes'] = $this->db->get('usertype')->result_array();
            $title = 'Setup';
            $this->ViewHeader($title); 
            $this->load->helper('form');
            $userid = $this->session->user_id;
            $query = $this->db->get_where("users2", $userid);
            $data['records'] = $query->row();
            
            $this->load->view('Admin/Update_profile',$data);
        }

        public function ProfilePicUpdate()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array();

            $title = 'Setup';
            $this->ViewHeader($title);
            if(!empty($_POST))
            {
                $imgUrl = $this->EdituploadImage();
                $data = array(

                    'profile_pic'   => $imgUrl
                );
                // $physician_id = $this->session->userid;

                // $fname = $this->session->fname;
                // $lname = $this->session->lname;
                // $user = 'Physician';
                // $date = date("Y-m-d h:i:sa");
                // $action = 'Profile picture updated by ' . $fname . " ".$lname;
                       
                // $data1 = array(

                //     'usertype' => $user, 'userid'   => $this->session->userid,
                //     //'date'=> $date,
                //     'action'   => $action,
                //'type'  => 'Setup'
                     
                //     );
                //     $this->Patient_Model->addLogs($data1);
                $user_id = $this->session->user_id;
                $this->Admin_Model->updateProfilePic($data,$user_id);
                $this->session->set_flashdata('success1', "success");
                $this->session->set_userdata($data);

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . ' his/her profile picture';
                
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                $this->Admin_Model->addLogs($data1);
                
                redirect('update-profile');
            }
            else
            {
                $user_id = $this->session->user_id;
                    //$this->Admin_Model->updateProfile($data,$admin_id);
                $data['records'] = $this->Admin_Model->view_info($user_id);
                $this->load->view('Admin/Update_profile',$data);
            }
        }

        // public function EdituploadImage() 
        //  {
        //     $type = explode('.', $_FILES['Editphoto']['name']);       
        //     $type = $type[count($type)-1];    
        //     $url = 'uploads/profile-pic/'.$_FILES['Editphoto']['name'];
        //     $filename = $_FILES['Editphoto']['name'];

        //     if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
        //       if(is_uploaded_file($_FILES['Editphoto']['tmp_name'])) {      
        //         if(move_uploaded_file($_FILES['Editphoto']['tmp_name'], $url)) {
        //           return $filename;
        //         } else {
        //           return false;
        //         }     
        //       }
        //     } 
        //  }

        public function EdituploadImage() 
        {
            $type = explode('.', $_FILES['Editphoto']['name']);       
            $type = $type[count($type)-1];    
            $url = 'uploads/profile-pic/'.$_FILES['Editphoto']['name'];
            $filename = $_FILES['Editphoto']['name'];

            if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
              if(is_uploaded_file($_FILES['Editphoto']['tmp_name'])) {      
                if(move_uploaded_file($_FILES['Editphoto']['tmp_name'], $url)) {
                    return $filename;
                } else {
                    return false;
                }     
            }
            } 
        }

        public function ViewDeduction()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            // $id = $_POST['id'];
            // $date = $_POST['date'];
            //$data['getDeduct'] = $this->Admin_Model->getDeduct($id, $date);  // returns the record of all logs from logs table
            $title = 'Deduct';
            $this->ViewHeader($title); // loads the header filtered by usertype   
              
            $this->load->view('Admin/Deduct_view');
        }

        public function view_deduction_date()
        {
            $start = $this->input->post('start');
            $length = $this->input->post('length');
            $searchValue = $this->input->post('search')['value'];
            $this->db3 = $this->load->database('ebs', TRUE);

            $dedDate = $this->input->post('ded_date');
            $emp_id = $this->input->post('emp_id');

            $this->db3->select("*")
                ->from('ebm_consolidated_ledger')
                // ->join('pis.employee3 as staff', 'staff.emp_no = nav.staff_id')
                // ->join('pis.employee3 as officer', 'officer.emp_id = nav.officer_incharge')
                // ->join('pis.locate_business_unit as bu', 'bu.bcode = nav.bu_code')
                ->where('ebm_consolidated_ledger.ldg_deduction_date', $dedDate)
                ->where('ebm_consolidated_ledger.ldg_hrmsid', $emp_id)

                ->group_start()
                ->like('ebm_consolidated_ledger.ldg_type', $searchValue)
                ->or_like('ebm_consolidated_ledger.ldg_balance', $searchValue)
               
                ->group_end();

            // Get total records count before pagination
            $totalRecords = $this->db3->count_all_results('', false);

            // Apply pagination
            $this->db3->limit($length, $start);

            $query = $this->db3->get();
            $result_ = $query->result_array();

            $data = array(
                'draw' => $this->input->post('draw'),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $result_
            );

            echo json_encode($data);
        } 

        public function sum_ldg_balance() {
            $this->db3 = $this->load->database('ebs', TRUE);

            $dedDate = $this->input->post('ded_date');
            $emp_id = $this->input->post('emp_id');

            $this->db3->select("SUM(ldg_balance) as total_balance")
                ->from('ebm_consolidated_ledger')
                ->where('ldg_deduction_date', $dedDate)
                ->where('ldg_hrmsid', $emp_id);

            $query = $this->db3->get();
            if (!$query) {
                // Log the error
                log_message('error', 'Database error: ' . $this->db3->last_query());
                echo json_encode(['total_balance' => 0]);
                return;
            }

            $result = $query->row_array();

            if ($result) {
                echo json_encode(['total_balance' => $result['total_balance']]);
            } else {
                echo json_encode(['total_balance' => 0]);
            }
        }
	}
?>
