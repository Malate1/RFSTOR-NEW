<?php

	class Request extends CI_Controller {

		function __construct()
		{
			parent::__construct();            
			if($this->session->username == "")
			{
				redirect('login');
			}

            // $ip_address = '172.16.161.43';
            // $port = ''; // Change the port if necessary

            // // You can customize this condition based on your requirements
            // if (!$this->is_server_reachable($ip_address, $port)) {
            //     // Show custom error page
            //     echo "<h1>Hi</h1>";
            //     exit; // Stop further execution if you want
            // }


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

		}

        private function is_server_reachable($ip_address, $port) {
            $fp = @fsockopen($ip_address, $port, $errno, $errstr, 1);
            if ($fp) {
                fclose($fp);
                return true;
            } else {
                return false;
            }
        }

        private function handle_error($err) {
            $this->error .= $err . "\r\n";
        }

        private function handle_success($succ) {
            $this->success .= $succ . "\r\n";
        }

        public function getLatestRequests() {
            
            $newRequestCount = $this->request_model->countRequestsAddedWithinInterval();
            
            $data = array(
                'newRequestCount' => $newRequestCount
            );

            header('Content-Type: application/json');
            echo json_encode($data);
        }

        public function request_list() //the details of the requests list table for Request users
        {
            $payload = $this->input->post(NULL,TRUE);
            // $requests = $this->Admin_Model->getRequest($payload);
            $requests = $this->request_model->get_requests($payload);
            //print_r($payload);
            $data = [];
            foreach ($requests as $req) {
              
                $bu = $this->Admin_Model->bu_name($req->buid);
                $executedby = $this->Admin_Model->getUserData2($req->executedby);


                $cancelledby = $this->Admin_Model->getUserData2($req->cancelledby);

                $sub_array = [];
                $sub_array[] = '<span style="color: red; align: center; font-weight: bold">'.$req->requestnumber.'</span>';
                
                if($req->reqstatus == 'Approved'){
                    $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_executed));
                }elseif($req->cancelledby != '0'){
                    $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_cancelled));
                }else{
                    $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->datetoday));
                }
                $sub_array[] = $req->groupname;
                $sub_array[] = $req->companyname;
                $sub_array[] = $req->business_unit;
                $sub_array[] = $req->purpose;

                // $stat1="";
                if($req->reqstatus == 'Approved'){
                    $sub_array[] = $executedby->name;        
                }
                if($req->reqstatus == 'Cancelled') {
                    $sub_array[] = $cancelledby->name;
                }
                if($req->reqstatus == 'Pending')  {
                   $sub_array[] = '<span class="pending"><i class="fa fa-question-circle fa-lg" aria-hidden="true" ></i></span>';
                }

                // $sub_array[] = $stat1;

                $stat = "";
                if($req->reqstatus == 'Pending'){
                    $stat .= '<span class="label label-warning">'.$req->reqstatus.'</span></td>';
                }elseif ($req->reqstatus == 'Cancelled') {
                    $stat .= '<span class="label label-danger">'.$req->reqstatus.'</span></td>';
                }
                else{
                   $stat .= '<span class="label label-success">Approved</span></td>';
                }    
                $sub_array[] = $stat;

                
                
                    $tor = "";
                    $isr = "";
                    $rfs = "";
                    if(strtoupper($payload['typeofrequest']) == 'RFS'){
                        if($req->approvedby == '0' AND $req->cancelledby == '0' AND $req->executedby == '0' AND $req->reviewedby == '0' AND $req->verifiedby == '0'){
                        $rfs .= '
                            <a id="RFS-'.$req->reqid.'" title="Modify RFS" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#editRfsModal" onclick=editrfs_content('.$req->reqid.')><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                            <a title="Cancel Request" style="color: #f54254; cursor: pointer"  onclick=updatestatusrequest('.$req->reqid.') <i class="fa fa-times fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $rfs .='
                            <a title="View Details RFS" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveRfsModal" onclick=approverfs_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->remarks != '') {
                            $rfs .= '
                            <a title="View Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#viewRemarksModal" onclick=viewremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->reqstatus == 'Approved') {
                           $rfs .= '<a title="Print" style="color: #3c8dbc; cursor: pointer;cursor: pointer" onclick=print_rfs('.$req->reqid.') <i class="fa fa-print fa-lg"></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        // if ($req->cancelledby != '0'){
                        //     $rfs .= '
                        //         <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        // }

                        if($req->approvedby != '0'){
                            $rfs .= '
                                <a title="Request Status" style="color:  #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>';
                        }else{
                            $rfs .= '
                                <a title="Request Status" style="color:  orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>';
                        }

                        // $rfs .= '<a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        $sub_array[] = $rfs;
                    }else if (strtoupper($payload['typeofrequest']) == 'TOR') {
                        if($req->approvedby == '0' AND $req->cancelledby == '0' AND $req->executedby == '0' AND $req->reviewedby == '0' AND $req->verifiedby == '0'){
                        
                        $tor.= '
                            <a id="TOR-'.$req->reqid.'" title="Modify TOR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#editTorModal" onclick=edittor_content('.$req->reqid.')><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                            <a title="Cancel Request" style="color: #f54254; cursor: pointer"  onclick=updatestatusrequest('.$req->reqid.') <i class="fa fa-times fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $tor.= '
                            <a title="View Details TOR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveTorModal" onclick=approvetor_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->remarks != '') {
                            $tor.= '
                            <a title="View Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#viewRemarksModal" onclick=viewremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->reqstatus == 'Approved') {
                            $tor.= '<a title="Print" style="color: #3c8dbc; cursor: pointer;cursor: pointer" onclick=print_tor('.$req->reqid.') <i class="fa fa-print fa-lg"></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        // if ($req->cancelledby != '0'){
                        //     $tor.= '
                        //         <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        // }

                        if($req->approvedby != '0'){
                            $tor.= '
                                <a title="Request Status" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }else{
                            $tor.= '
                                <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }

                        // $tor.= '<a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        $sub_array[] = $tor;
                    }else if (strtoupper($payload['typeofrequest']) == 'ISR') {
                        if($req->approvedby == '0' AND $req->cancelledby == '0' AND $req->executedby == '0' AND $req->reviewedby == '0' AND $req->verifiedby == '0'){
                        $isr .= '
                            <a id="ISR-'.$req->reqid.'" title="Modify ISR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#editIsrModal" onclick=editisr_content('.$req->reqid.')><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                            
                            <a title="Cancel Request" style="color: #f54254; cursor: pointer"  onclick=updatestatusrequest('.$req->reqid.') <i class="fa fa-times fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $isr .= '
                            <a title="View Details ISR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveIsrModal" onclick=approveisr_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->remarks != '') {
                            $isr .= '
                            <a title="View Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#viewRemarksModal" onclick=viewremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        // if ($req->approvedby != '0') {
                            
                        // }

                        $isr .= '<a title="Print" style="color: #3c8dbc; cursor: pointer;cursor: pointer" onclick=print_isr('.$req->reqid.') <i class="fa fa-print fa-lg"></i></a>&nbsp;&nbsp; || &nbsp;';

                        // if ($req->cancelledby != '0'){
                        //     $isr .= '
                        //         <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        // }

                        if($req->approvedby != '0'){
                            $isr .= '
                                <a title="Request Status" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }else{
                            $isr .= '
                                <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';

                        }
                        // $isr .= '<a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';
                        $sub_array[] = $isr;
                    }

                $data[] = $sub_array;
            }

            $output = array(  
                "draw"                      =>     intval($_POST["draw"]),  
                "recordsTotal"              =>     $this->request_model->get_all_data(),  
                "recordsFiltered"           =>     $this->request_model->get_filtered_data($payload),  
                "data"                      =>     $data  
            );

           echo json_encode($output); 

            // echo json_encode(['data' => $data]);
        }

        public function ViewHeader() //displays the header
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
            $data['page_title'] = 'Request';
            
            $data['rfs']      = $this->execute_model->totalPendingRfsE();  
            $data['tor']      = $this->execute_model->totalPendingTorE(); 
            $data['isr']      = $this->execute_model->totalPendingIsrE();
            $data['con']    = $this->execute_model->totalPendingConE();

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
	
        public function ViewConcernPending() //displays pending concerns 
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'Concern'; 
            $data['status'] = 'Pending'; // initiated the request type to RFS  
            $data['getRequest'] = $this->Admin_Model->getRequestPending($data['type']); // returns the record of all requests which is RFS from requests table
            $this->ViewHeader(); // loads the header filtered by usertype
            
            $this->load->view('Admin/Concerns_view',$data); // loads the Concerns_view.php in views
        }

        public function ViewConcernCompleted() //displays completed concerns 
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'Concern';  // initiated the request type to Concern  
            $data['status'] = 'Approved';
            $data['getRequest'] = $this->Admin_Model->getRequestCompleted($data['type']); // returns the record of all requests which is Concern from requests table
            $this->ViewHeader(); // loads the header filtered by usertype
            $this->load->view('Admin/Concerns_view',$data); // loads the Concerns_view.php in views
        }

        public function ViewConcernCancelled() //displays cancelled concerns 
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'Concern';  // initiated the request type to RFS 
            $data['status'] = 'Cancelled'; 
            $data['getRequest'] = $this->Admin_Model->getRequestCancelled($data['type']); // returns the record of all requests which is RFS from requests table
            $this->ViewHeader(); // loads the header filtered by usertype
            $this->load->view('Admin/Concerns_view',$data); // loads the Concerns_view.php in views
        }

		public function ViewRfsPending() //displays pending RFS 
		{
			$data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'RFS';  // initiated the request type to RFS 
            $data['status'] = 'Pending'; 
			
            $this->ViewHeader(); // loads the header filtered by usertype
            
			$this->load->view('Admin/Requests_view',$data); // loads the Requests_view.php in views
		}

		public function ViewTorPending() //displays pending TOR 
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'TOR';  // initiated the request type to RFS  
            $data['status'] = 'Pending';
            
            $this->ViewHeader(); // loads the header filtered by usertype
            
            $this->load->view('Admin/Requests_view',$data); // loads the Requests_view.php in views
        }

        public function ViewIsrPending() //displays pending ISR 
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'ISR';  // initiated the request type to ISR  
            $data['status'] = 'Pending';
            
            $this->ViewHeader(); // loads the header filtered by usertype
            
            $this->load->view('Admin/Requests_view',$data); // loads the Requests_view.php in views
        }
        
        //displays the RFS status whether it is approved, executed and reviewed/verified
        public function showApprovedRfs()
        {
            
            $row = $this->Admin_Model->getDataRequestRfs($_POST['ids']);
            // $row1 = $this->Admin_Model->getUserData();
            $taskid1 = 2;
            $taskid2 = 3;
            $rtype = "RFS";
            echo'<div class="table-responsive" >
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">

                        <thead  class="thead-dark">
                            <tr>
                                <th style="text-align: center;">Control No</th>
                                <th style="text-align: center;">Approved by<br><i style="font-size: 10px; font-weight: normal;">Business Unit Head/Accounting Manager</i></th>'; 

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    echo'<th style="text-align: center;">Reviewed by<br><i style="font-size: 10px; font-weight: normal;">IAD Manager/Compliance Officer/Asst.Head Sys Dev</i> </th>';
                                }else{
                                    echo'<th hidden style="text-align: center;">Reviewed by</th>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    echo'<th style="text-align: center;">Verified by<br><i style="font-size: 10px; font-weight: normal;">Supervisor/IAD</i></th> ';
                                }else{
                                    echo'<th hidden style="text-align: center;">Verified by</th>';
                                }                                            
                            echo'<th style="text-align: center;">Implemented by<br><i style="font-size: 10px; font-weight: normal;">Programmer/MIS</i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td style="text-align: center; color: red; font-weight: bold;">'.$row->requestnumber.'</td>';
                                if($row->approvedby != '0'){

                                    $approvedetails = $this->user_model->getuserDetails2($row->approvedby);
                                    $approvedby = $this->employee_model->find_an_employee(@$approvedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$approvedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }
                                                     
                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    if($row->reviewedby != '0'){
                                        $reviewdetails = $this->user_model->getuserDetails2($row->reviewedby);
                                        $reviewedby = $this->employee_model->find_an_employee(@$reviewdetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$reviewedby->name.'</td>';

                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    if($row->verifiedby != '0'){
                                        $verifydetails = $this->user_model->getuserDetails2($row->verifiedby);
                                        $verifiedby = $this->employee_model->find_an_employee(@$verifydetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$verifiedby->name.'</td>';
                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }                                      
                                if($row->executedby != '0'){
                                    $executedetails = $this->user_model->getuserDetails2($row->executedby);
                                    $executedby = $this->employee_model->find_an_employee(@$executedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$executedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }
                        echo'</tr>
                        </tbody>
                    </table>';
                    if($row->approvedby != '0' || $row->executedby != '0' || $row->verifiedby != '0' || $row->reviewedby != '0' || $row->cancelledby != '0'){
                        echo'<hr>

                        <h5 style="text-align: center; font-weight: bold;">Timestamps</h5>';
                    }
                    
                    echo'<div>';
                        if($row->approvedby != '0'){

                            echo'<p><b>Approved on: </b>' .date("D • h:i:s A • M. d, Y ",strtotime($row->date_approved)).'</p>';
                        }

                        if($row->executedby != '0'){

                            echo'<p><b>Executed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_executed)).'</p>';
                        }

                        if($row->verifiedby != '0'){

                            echo'<p><b>Verified on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_verified)).'</p>';
                        }

                        if($row->reviewedby != '0'){

                            echo'<p><b>Reviewed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_reviewed)).'</p>';
                        }

                        if($row->cancelledby != '0'){

                            echo'<p><b>Cancelled on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_cancelled)).'</p>';
                        }
                        
                    echo'</div>
                </div>';
        }

        //displays the TOR status whether it is approved, executed and reviewed/verified
        public function showApprovedTor()
        {
            $row = $this->Admin_Model->getDataRequestTor($_POST['ids']);
            // $row1 = $this->Admin_Model->getUserData();
            $taskid1 = 2;
            $taskid2 = 3;
            $rtype = "TOR";
            echo'<div class="table-responsive" >
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">

                        <thead  class="thead-dark">
                            <tr>
                                <th style="text-align: center;">Control No</th>
                                <th style="text-align: center;">Approved by<br><i style="font-size: 10px; font-weight: normal;">Business Unit Head/Accounting Manager</i></th>'; 

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    echo'<th style="text-align: center;">Reviewed by<br><i style="font-size: 10px; font-weight: normal;">IAD Manager/Compliance Officer/Asst.Head Sys Dev</i> </th>';
                                }else{
                                    echo'<th hidden style="text-align: center;">Reviewed by</th>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    echo'<th style="text-align: center;">Verified by<br><i style="font-size: 10px; font-weight: normal;">Supervisor/IAD</i></th>';
                                }else{
                                    echo'<th hidden style="text-align: center;">Verified by</th>';
                                }                                            
                            echo'<th style="text-align: center;">Adjusted/Reprinted by<br><i style="font-size: 10px; font-weight: normal;">Programmer/MIS</i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td style="text-align: center; color: red; font-weight: bold;">'.$row->requestnumber.'</td>';
                                if($row->approvedby != '0'){

                                    $approvedetails = $this->user_model->getuserDetails2($row->approvedby);
                                    $approvedby = $this->employee_model->find_an_employee(@$approvedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$approvedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }
                                                     
                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    if($row->reviewedby != '0'){
                                        $reviewdetails = $this->user_model->getuserDetails2($row->reviewedby);
                                        $reviewedby = $this->employee_model->find_an_employee(@$reviewdetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$reviewedby->name.'</td>';

                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    if($row->verifiedby != '0'){
                                        $verifydetails = $this->user_model->getuserDetails2($row->verifiedby);
                                        $verifiedby = $this->employee_model->find_an_employee(@$verifydetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$verifiedby->name.'</td>';
                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }                                      
                                if($row->executedby != '0'){
                                    $executedetails = $this->user_model->getuserDetails2($row->executedby);
                                    $executedby = $this->employee_model->find_an_employee(@$executedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$executedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }      
                        echo'</tr>
                        </tbody>
                    </table>';
                    if($row->approvedby != '0' || $row->executedby != '0' || $row->verifiedby != '0' || $row->reviewedby != '0' || $row->cancelledby != '0'){
                        echo'<hr>

                        <h5 style="text-align: center; font-weight: bold;">Timestamps</h5>';
                    }
                    
                    echo'<div>';
                        if($row->approvedby != '0'){

                            echo'<p><b>Approved on: </b>' .date("D • h:i:s A • M. d, Y ",strtotime($row->date_approved)).'</p>';
                        }

                        if($row->executedby != '0'){

                            echo'<p><b>Executed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_executed)).'</p>';
                        }

                        if($row->verifiedby != '0'){

                            echo'<p><b>Verified on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_verified)).'</p>';
                        }

                        if($row->reviewedby != '0'){

                            echo'<p><b>Reviewed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_reviewed)).'</p>';
                        }

                        if($row->cancelledby != '0'){

                            echo'<p><b>Cancelled on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_cancelled)).'</p>';
                        }
                        
                    echo'</div>
                </div>';
        }

        //displays the ISR status whether it is approved, executed and reviewed/verified
        public function showApprovedIsr()
        {
            $row = $this->Admin_Model->getDataRequestIsr($_POST['ids']);
            // $row1 = $this->Admin_Model->getUserData();
            $taskid1 = 2;
            $taskid2 = 3;
            $rtype = "ISR";
            echo'<div class="table-responsive" >
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">

                        <thead  class="thead-dark">
                            <tr>
                                <th style="text-align: center;">Control No</th>
                                <th style="text-align: center;">Approved by<br><i style="font-size: 10px; font-weight: normal;">Business Unit Head/Accounting Manager</i></th>'; 

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    echo'<th style="text-align: center;">Reviewed by<br><i style="font-size: 10px; font-weight: normal;">IAD Manager/Compliance Officer/Asst.Head Sys Dev</i> </th>';
                                }else{
                                    echo'<th hidden style="text-align: center;">Reviewed by</th>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    echo'<th style="text-align: center;">Verified by<br><i style="font-size: 10px; font-weight: normal;">Supervisor/IAD</i></th>';
                                }else{
                                    echo'<th hidden style="text-align: center;">Verified by</th>';
                                }                                            
                            echo'<th style="text-align: center;">Implemented by <br><i style="font-size: 10px; font-weight: normal;">Programmer/MIS</i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td style="text-align: center; color: red; font-weight: bold;">'.$row->requestnumber.'</td>';
                                if($row->approvedby != '0'){

                                    $approvedetails = $this->user_model->getuserDetails2($row->approvedby);
                                    $approvedby = $this->employee_model->find_an_employee(@$approvedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$approvedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }
                                                     
                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,$rtype) == true){
                                    if($row->reviewedby != '0'){
                                        $reviewdetails = $this->user_model->getuserDetails2($row->reviewedby);
                                        $reviewedby = $this->employee_model->find_an_employee(@$reviewdetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$reviewedby->name.'</td>';

                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }

                                if($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,$rtype) == true){
                                    if($row->verifiedby != '0'){
                                        $verifydetails = $this->user_model->getuserDetails2($row->verifiedby);
                                        $verifiedby = $this->employee_model->find_an_employee(@$verifydetails->emp_id);

                                        echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$verifiedby->name.'</td>';
                                    }else{
                                       echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                    }
                                }else{
                                    echo'<td hidden style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }                                      
                                if($row->executedby != '0'){
                                    $executedetails = $this->user_model->getuserDetails2($row->executedby);
                                    $executedby = $this->employee_model->find_an_employee(@$executedetails->emp_id);

                                    echo'<td style="text-align: center; color: #3c8dbc; cursor: pointer;">'.$executedby->name.'</td>';
                                }else{
                                   echo'<td style="text-align: center;"><span class="label label-warning">Pending</span></td>';
                                }                                     
                            
                        echo'</tr>
                        </tbody>
                    </table>';
                    if($row->approvedby != '0' || $row->executedby != '0' || $row->verifiedby != '0' || $row->reviewedby != '0' || $row->cancelledby != '0'){
                        echo'<hr>

                        <h5 style="text-align: center; font-weight: bold;">Timestamps</h5>';
                    }
                    
                    echo'<div>';
                        if($row->approvedby != '0'){

                            echo'<p><b>Approved on: </b>' .date("D • h:i:s A • M. d, Y ",strtotime($row->date_approved)).'</p>';
                        }

                        if($row->executedby != '0'){

                            echo'<p><b>Executed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_executed)).'</p>';
                        }

                        if($row->verifiedby != '0'){

                            echo'<p><b>Verified on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_verified)).'</p>';
                        }

                        if($row->reviewedby != '0'){

                            echo'<p><b>Reviewed on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_reviewed)).'</p>';
                        }

                        if($row->cancelledby != '0'){

                            echo'<p><b>Cancelled on: </b>'.date("D • h:i:s A • M. d, Y ",strtotime($row->date_cancelled)).'</p>';
                        }
                        
                    echo'</div>
                </div>';
        }

		

        public function concern_content() //called via ajax to be display the modal form contents for adding RFS 
        {
            $data = $this->Admin_Model->getUserData();
            $date = date("m/d/Y"); 
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserRfs();
            $data3 = $this->Admin_Model->getUserRfsMode();
            $data4 = $this->Admin_Model->getUserBurole();
            //$code = $this->employee_model->find_an_employee3($data->emp_id);

            if($this->session->location == 'Cebu'){
                $code = $this->employee_model->company_name($this->session->cc);
            }

            if($this->session->location == 'Bohol'){
                $code = $this->employee_model->find_an_employee3($data->emp_id);
            }
            
            //$cc = $this->employee_model->company_name($code->company_code);
            // echo     '<div class="alert alert-danger" id="msg" role="alert" ">'.validation_errors().'</div>';
            //var_dump($code->id);
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$code->acroname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="company" id="company" autocomplete="off"  value="" readonly >
                                <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
                            <select style="width: 100%; padding:5px;" class="select-bu3 form-control" name="bu" id="bu" required">
                                <option></option>';
                                foreach ($data4 as $value) {
                                    if($value->user_id == $data->user_id){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.$date.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group form-control" name="usergroup" id="usergroup">
                                <option></option>';
                                foreach ($data1 as $value) {
                        echo   '<option value="'.$value->group_id.'">'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>
                    
                </div>
                <div class="row">

                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="60"></textarea>
                        </div>
                    </div>
                </div>';

                     
        ?>
            <script>
                
                $(".select-group").select2({
                    placeholder: "Select a user group your'e requesting to",
                    allowClear: true
                });

                $(".select-bu3").select2({
                    placeholder: "Select a Business Unit",
                    allowClear: true
                });

                $(document).ready(function(){
            
                    let bu = $('#bu').select2("val");
                    $('select').on('change', function() {
                         
                        let bu = $('#bu').select2("val");
                        //let company = 
                        document.getElementById('company').value= bu;

                    });

                });

            </script>
        <?php
        }

		public function rfs_content() //called via ajax to be display the modal form contents for adding RFS 
		{
			$data = $this->Admin_Model->getUserData();
			$date = date("m/d/Y"); 
			// $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
			$data2 = $this->Admin_Model->getUserRfs();
			$data3 = $this->Admin_Model->getUserRfsMode();
            $data4 = $this->Admin_Model->getUserBurole();
            if($this->session->location == 'Cebu'){
                $code = $this->employee_model->company_name($this->session->cc);
            }

            if($this->session->location == 'Bohol'){
                $code = $this->employee_model->find_an_employee3($data->emp_id);
            }
            
            
            //$cc = $this->employee_model->company_name($code->company_code);
			// echo   	'<div class="alert alert-danger" id="msg" role="alert" ">'.validation_errors().'</div>';
            //var_dump($code->id);
            echo 	'<p style="color: red;"> <b>Note:</b> If the request details are about to reach up to 1000 characters, it is recommended to just have it as an attachment. </p>
                    <div class ="row">
            		<div class="col-md-6">      
	            		<div class="form-group">
		                    <label for="company">Company Name</label>
		                    <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$code->acroname.'" readonly >
		                </div>
		            </div>
		            <div class="col-md-6">
		                <div class="form-group">
		                    <input type="hidden" class="form-control" name="company" id="company" autocomplete="off"  value="" readonly >
                                <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
		                    <select style="width: 100%; padding:5px;" class="select-bu3 form-control" name="bu" id="bu" required">
                                <option></option>';
                                foreach ($data4 as $value) {
                                    if($value->user_id == $data->user_id){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
		                </div>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <label for="contact">IP Phone No. (if necessary)</label>
		                   
                        <input type="text" class="form-control" name="contact" id="contact" autocomplete="off" data-mask>
		                </div>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <label for="date">Date</label>
		                    <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.$date.'"  readonly>
		                </div>
		            </div>
		            
		            <div class="col-md-12">
		                <div class="form-group">
		                    <label for="usergroup">User Group</label><br>
		                    <select style="width: 100%; padding:5px;" class="select-group form-control" name="usergroup" id="usergroup">
		                        <option></option>';
		    					foreach ($data1 as $value) {
		                echo   '<option value="'.$value->group_id.'">'.$value->groupname.'</option>';
		                    	}
		                echo '</select>
		                </div>
	                </div>

	                <div class="col-md-12">
		                <div class="form-group">
		                    <label for="type">Type of Request</label><br>
		                    <select style="width: 100%; height: resolve; padding:5px;" class="select-type form-control" name="rfstype" id="rfstype">
		                        <option></option>';
		    					foreach ($data2 as $value) {
		                echo   '<option value="'.$value->rfs_id.'">'.$value->requesttype.'</option>';
		                    	}
		                echo '</select>
		                </div>
	                </div>

	                

	                
	            
	            </div>
	            <div class="row">

	            	<div class="col-md-6">
		                <div class="form-group">
		                    <label for="purpose">Purpose</label><br>
		                    <textarea id="purpose" name="purpose" rows="5" cols="60"></textarea>
		                </div>
	                </div>

	                <div class="col-md-6">
		                <div class="form-group">
		                    <label for="details">Details</label><br>
		                    <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="60"></textarea>
		                </div>
	                </div>
                </div>';

	                // <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="" >  
                    // <div class="col-md-12">
                    //     <div class="form-group">
                    //         <label for="type">Request Mode</label><br>
                    //         <select style="width: 100%; height: resolve; padding:5px;" class="select-mode form-control" name="requests_mode" id="requests_mode">
                    //             <option></option>';
                    //             foreach ($data3 as $value) {
                    //     echo   '<option value="'.$value->id.'">'.$value->themode.'</option>';
                    //             }
                    //     echo '</select>
                    //     </div>
                    // </div>
        ?>
        	<script>
        		$(".select-type").select2({
			        placeholder: "Select a Request Type",
			        allowClear: true
			    });

			    $(".select-group").select2({
			        placeholder: "Select a user group your'e requesting to",
			        allowClear: true
			    });

			    // $(".select-mode").select2({
			    //     placeholder: "Select a Request Mode",
			    //     allowClear: true
			    // });

                $(".select-bu3").select2({
                    // placeholder: "Select a Business Unit",
                    selectOnClose: true,
                    allowClear: false
                });

                $(document).ready(function(){
            
                    let bu = $('#bu').select2("val");
                    $('select').on('change', function() {
                         
                        let bu = $('#bu').select2("val");
                        //let company = 
                        document.getElementById('company').value= bu;

                    });

                });



        	</script>

            
        <?php
		}

		public function tor_content() //called via ajax to be display the modal form contents for adding TOR 
		{
			$data = $this->Admin_Model->getUserData();
			$date = date("m/d/Y");
			// $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
			$data2 = $this->Admin_Model->getUserTor();
			// $data3 = $this->Admin_Model->getUserRfsMode();
            $data4 = $this->Admin_Model->getUserBurole();
            if($this->session->location == 'Cebu'){
                $code = $this->employee_model->company_name($this->session->cc);
            }

            if($this->session->location == 'Bohol'){
                $code = $this->employee_model->find_an_employee3($data->emp_id);
            }
			echo   	'<div class="alert alert-danger" id="msg" role="alert" style="display: none">Credentials already exist!</div>';
            echo 	'<p style="color: red;"> <b>Note:</b> If the request details are about to reach up to 1000 characters, it is recommended to just have it as an attachment. </p>
                    <div class ="row">

            		<div class="col-md-6">      
	            		<div class="form-group">
		                    <label for="company">Company Name</label>
		                    <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$code->acroname.'" readonly >
		                </div>
		            </div>
		            <div class="col-md-6">
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="company" id="company" autocomplete="off"  value="" readonly >
                            <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
                            <select style="width: 100%; padding:5px;" class="select-bu3 form-control" name="bu" id="bu" required">
                                <option></option>';
                                foreach ($data4 as $value) {
                                    if($value->user_id == $data->user_id){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <label for="contact">IP Phone No. (if necessary)</label>
		                    <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="" >
		                </div>
		            </div>

		            <div class="col-md-6">
		                <div class="form-group">
		                    <label for="date">Date</label>
		                    <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.$date.'"  readonly>
		                </div>
		            </div>
		            
		            <div class="col-md-6">
		                <div class="form-group">
		                    <label for="usergroup">User Group</label><br>
		                    <select style="width: 100%; padding:5px;" class="select-group form-control" name="usergroup" id="usergroup" required">
		                        <option></option>';
		    					foreach ($data1 as $value) {
		                echo   '<option value="'.$value->group_id.'">'.$value->groupname.'</option>';
		                    	}
		                echo '</select>
		                </div>
	                </div>

	                <div class="col-md-6">
		                <div class="form-group">
		                    <label for="type">Type of Request</label><br>
		                    <select style="width: 100%; height: resolve; padding:5px;" class="select-type form-control" name="tortype" id="tortype" required">
		                        <option></option>';
		    					foreach ($data2 as $value) {
		                echo   '<option value="'.$value->tor_id.'">'.$value->tortype.'</option>';
		                    	}
		                echo '</select>
		                </div>
	                </div>

	            </div>
	            <div class="row">

	            	<div class="col-md-6">
		                <div class="form-group">
		                    <label for="purpose">Purpose</label><br>
		                    <textarea id="purpose" name="purpose" rows="5" cols="42"></textarea>
		                </div>
	                </div>

	                <div class="col-md-6">
		                <div class="form-group">
		                    <label for="details">Details</label><br>
		                    <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42"></textarea>
		                </div>
	                </div>
	            </div>';

        ?>
        	<script>
        		$(".select-type").select2({
			        placeholder: "Select a Request Type",
			        allowClear: true
			    });

			    $(".select-group").select2({
			        placeholder: "Select a User Group",
			        allowClear: true
			    });

			    $(".select-mode").select2({
			        placeholder: "Select a Request Mode",
			        allowClear: true
			    });

                $(".select-bu3").select2({
                    selectOnClose: true,
                    allowClear: false
                });

                $(document).ready(function(){
            
                    let bu = $('#bu').select2("val");
                    $('select').on('change', function() {
                         
                        let bu = $('#bu').select2("val");
                        //let company = 
                        document.getElementById('company').value= bu;

                    });

                });

        	</script>
        <?php
		}

        public function isr_content() //called via ajax to display the modal form contents for adding ISR 
        {
            $data = $this->Admin_Model->getUserData();
            $date = date("m/d/Y");
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserIsr();
            $data3 = $this->Admin_Model->getBu();

            if($this->session->location == 'Cebu'){
                $code = $this->employee_model->company_name($this->session->cc);
            }

            if($this->session->location == 'Bohol'){
                $code = $this->employee_model->find_an_employee3($data->emp_id);
            }
            echo    '<div class="alert alert-danger" id="msg" role="alert" style="display: none">Credentials already exist!</div>';
            echo    '<p style="color: red;"><b> NOTE: </b>When requesting for other business unit, please change the Requesting Party BU Information below</p>
                    <div class ="row">

                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="text" class="form-control" name="company" id="company" autocomplete="off"  value="'.$code->acroname.'" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <select style="width: 100%; padding:5px;" class="select-bu form-control" name="bu" id="bu" required">
                                ';

                                foreach ($data3 as $value) {
                                    if($value->id == $data->id){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.$date.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group form-control" name="usergroup" id="usergroup" required">
                                <option></option>';
                                foreach ($data1 as $value) {
                        echo   '<option value="'.$value->group_id.'">'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <select style="width: 100%; height: resolve; padding:5px;" class="select-type form-control" name="isrtype" id="isrtype" required">
                                <option></option>';
                                foreach ($data2 as $value) {
                        echo   '<option value="'.$value->isr_id.'">'.$value->requesttype.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">Type of System</label><br>
                            <select style="width: 100%; padding:5px;" class="select-system form-control" name="systype" id="systype" required">
                                <option></option>
                                <option value="NAV">NAV</option>
                                <option value="IHS">IHS</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="50"> </textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">General Specifications/Explanations</label><br>
                            <textarea placeholder="(effects as inputs,processes,databases,etc.)" id="generals" name="generals" rows="5" cols="42"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Security Control Specifications</label><br>
                            <textarea id="security" name="security" rows="5" cols="50"> </textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Output Specifications</label><br>
                            <textarea placeholder="(Report format, target drive/location)" id="output" name="output" rows="5" cols="42"></textarea>
                        </div>
                    </div>
                </div>';

        ?>
            <script>
                $(".select-type").select2({
                    placeholder: "Select a Request Type",
                    allowClear: true
                });

                $(".select-group").select2({
                    placeholder: "Select a User Group",
                    allowClear: true
                });

                $(".select-system").select2({
                    placeholder: "Select a System Type",
                    allowClear: true
                });

                $(".select-bu").select2({
                    selectOnClose: true,
                    allowClear: false
                });

            </script>
        <?php
        }

        public function concern_create() //called via modal form to gather data to be passed to model for adding Concern
        {
            if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
                $userid = $this->session->userdata['user_id'];
                $companyname = $this->employee_model->find_an_employee4($this->input->post('company'));
                $type   = "Concern";
                $status = "Pending";
                $sql    = "SELECT MAX(requestnumber) AS `controlno` FROM `requests` WHERE typeofrequest = '$type'";
                $controlno =  $this->db->query($sql)->row()->controlno;
               
                $data = array(
                    'companyname'       => $companyname->acro,
                    'buid'             => $this->security->xss_clean($this->input->post('bu')),
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),
                    'userid'            => $userid,
                    'typeofrequest'     => $type,
                    'details'           => $this->security->xss_clean($this->input->post('details')),
                    'requestnumber'     => $controlno +1,
                    'status'            => $status,
                    'iscompleted'       => 'No'
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '0';
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                    if ($_FILES['upload_file7']['size'] <= 0) {
                        $this->handle_error('Select at least one file.');
                    }else{
                        foreach ($_FILES as $key => $value) {
                            if (!empty($value['name'])) {
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if (!$this->upload->do_upload($key)) {
                                    $this->handle_error($this->upload->display_errors());
                                    $is_file_error = TRUE;
                                } else {
                                    $files[$i] = $this->upload->data();
                                    ++$i;
                                }
                            }
                        }
                    }

                    // There were errors, you have to delete the uploaded files
                    if ($is_file_error && $files) {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }

                    if (!$is_file_error && $files) {
                        $resp = $this->file->save_files_info($files,$controlno,$type);
                        if ($resp === TRUE) {
                            $this->handle_success('File(s) was/were successfully uploaded.');
                        } else {
                            for ($i = 0; $i < count($files); $i++) {
                                $file = $dir_path . $files[$i]['file_name'];
                                if (file_exists($file)) {
                                    unlink($file);
                                }
                            }
                            $this->handle_error('Error while saving file info to Database.');
                        }
                    }
                $this->Admin_Model->insertRequests($data);

                $ctr = $controlno + 1;
                $request_data   = $this->request_model->get_requests_data2($ctr);
                //$action = $this->session->name . ' has added ' . $type . ' No. ' . $request_data->requestnumber;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . $type . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);
                $this->session->set_flashdata('SUCCESSMSG','success');
                redirect('view-concern');
            }
            
        }

		public function tor_create() //called via modal form to gather data to be passed to model for adding TOR  
        {
			if(!empty($_POST))
            {
     			//$attachment = $this->uploadAttachments();
     			$userid = $this->session->userdata['user_id'];
				//echo $this->input->post('company');
     			$companyname = $this->employee_model->find_an_employee4($this->input->post('bu'));	
     			$type   = "TOR";
     			$status = "Pending";
     			$sql 	= "SELECT MAX(requestnumber) AS `controlno` FROM `requests` WHERE typeofrequest = '$type'";
				$controlno =  $this->db->query($sql)->row()->controlno;

                var_dump($controlno);

				$data = array(
    				'companyname'     	=> @$companyname->acro,
    			    'buid'              => $this->security->xss_clean($this->input->post('bu')),
    			    'contactno'     	=> $this->security->xss_clean($this->input->post('contact')),   			 
    			    'togroup'   		=> $this->security->xss_clean($this->input->post('usergroup')),
    			    'userid'  			=> $userid,  			 
    			   	'tortypes'   		=> $this->security->xss_clean($this->input->post('tortype')),
    			    'typeofrequest'   	=> $type,
    			    'purpose'     		=> $this->security->xss_clean($this->input->post('purpose')),
    			    'details'     		=> $this->security->xss_clean($this->input->post('details')),
    			    'requestnumber'   	=> $controlno +1,
                    //'attachments'       => $attachment,
    				'status'    		=> $status,
                    'iscompleted'       => 'No'
				);

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file2']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info($files,$controlno,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while saving file info to Database.');
                    }
                }
				
				
				$this->Admin_Model->insertRequests($data);

                $ctr = $controlno + 1;
                $request_data   = $this->request_model->get_requests_data2($ctr);
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . $type . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);

				$this->session->set_flashdata('SUCCESSMSG','success');
				redirect('view-tor');
            }			
        }

		public function rfs_create() //called via modal form to gather data to be passed to model for adding RFS
        {
 			if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
     			$userid = $this->session->userdata['user_id'];
                $companyname = $this->employee_model->find_an_employee4($this->input->post('company'));
     			$reqdate = date("Y-m-d h:i:s A");
                
     			$type   = "RFS";
     			$status = "Pending";
     			$sql 	= "SELECT MAX(requestnumber) AS `controlno` FROM `requests` WHERE typeofrequest = '$type'";
    			$controlno =  $this->db->query($sql)->row()->controlno;
               
				$data = array(
    				'companyname'     	=> $companyname->acro,
                    'buid'             => $this->security->xss_clean($this->input->post('bu')),
    			    'contactno'     	=> $this->security->xss_clean($this->input->post('contact')),
    			    'togroup'   		=> $this->security->xss_clean($this->input->post('usergroup')),
                    // 'datetoday'         => $reqdate,
    			    'userid'  			=> $userid,
    			   	// 'requestmode'   	=> $this->security->xss_clean($this->input->post('requests_mode')),
    			   	'rfstype'   		=> $this->security->xss_clean($this->input->post('rfstype')),
    			    'typeofrequest'   	=> $type,
    			    'purpose'     		=> $this->security->xss_clean($this->input->post('purpose')),
    			    'details'     		=> $this->security->xss_clean($this->input->post('details')),
    			    'requestnumber'   	=> $controlno +1,
    				'status'    		=> $status,
                    'iscompleted'       => 'No'
				);

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                    if ($_FILES['upload_file1']['size'] <= 0) {
                        $this->handle_error('Select at least one file.');
                    }else{
                        foreach ($_FILES as $key => $value) {
                            if (!empty($value['name'])) {
                                $this->load->library('upload', $config);
                                $this->upload->initialize($config);
                                if (!$this->upload->do_upload($key)) {
                                    $this->handle_error($this->upload->display_errors());
                                    $is_file_error = TRUE;
                                } else {
                                    $files[$i] = $this->upload->data();
                                    ++$i;
                                }
                            }
                        }
                    }

                    // There were errors, you have to delete the uploaded files
                    if ($is_file_error && $files) {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                    }

                    if (!$is_file_error && $files) {
                        $resp = $this->file->save_files_info($files,$controlno,$type);
                        if ($resp === TRUE) {
                            $this->handle_success('File(s) was/were successfully uploaded.');
                        } else {
                            for ($i = 0; $i < count($files); $i++) {
                                $file = $dir_path . $files[$i]['file_name'];
                                if (file_exists($file)) {
                                    unlink($file);
                                }
                            }
                            $this->handle_error('Error while saving file info to Database.');
                        }
                    }
				$this->Admin_Model->insertRequests($data);

                $ctr = $controlno + 1;
                $request_data   = $this->request_model->get_requests_data2($ctr);
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . $type . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);

				$this->session->set_flashdata('SUCCESSMSG','success');
				redirect('view-rfs');
            }
            
        }

        public function isr_create() //called via modal form to gather data to be passed to model for adding ISR
        {
            if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
                $userid = $this->session->userdata['user_id'];
                $group  = $this->session->userdata['maingroup']; 
                $date   = date("Y-m-d h:i:sa");
                $type   = "ISR";
                $status = "Pending";
                $sql    = "SELECT MAX(requestnumber) AS `controlno` FROM `requests` WHERE typeofrequest = '$type'";
                $controlno =  $this->db->query($sql)->row()->controlno;
                //$attachment = $this->upload_files();

                $data = array(
                    'companyname'       => $this->security->xss_clean($this->input->post('company')),
                    'buid'              => $this->security->xss_clean($this->input->post('bu')),
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),
                    'userid'            => $userid,
                    'rfstype'           => $this->security->xss_clean($this->input->post('isrtype')),
                    'typeofsystem'      => $this->security->xss_clean($this->input->post('systype')),
                    'typeofrequest'     => $type,
                    'purpose'           => $this->security->xss_clean($this->input->post('purpose')),
                    'generals'          => $this->security->xss_clean($this->input->post('generals')),
                    'security'          => $this->security->xss_clean($this->input->post('security')),
                    'output'            => $this->security->xss_clean($this->input->post('output')),
                    'requestnumber'     => $controlno +1,
                    //'attachments'       => $attachment,
                    'status'            => $status,
                    'iscompleted'       => 'No'
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file3']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info($files,$controlno,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while saving file info to Database.');
                    }
                }

                $this->Admin_Model->insertRequests($data);

                $ctr = $controlno + 1;
                $request_data   = $this->request_model->get_requests_data2($ctr);
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added ' . '</b>' . $type . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);

                $this->session->set_flashdata('SUCCESSMSG','success');
                redirect('view-isr');    
            }
                
        }

        public function approveconcern_content() //displays concern details 
        {
            $row = $this->Admin_Model->getConcernApprovebyRequest($_POST['ids']);
            //$group = $row->togroup;
            $data1 = $this->Admin_Model->getUserGroup();
            $data2 = $this->Admin_Model->getUserRfs();
            $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'Concern';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            $emp = $this->employee_model->find_an_employee5($row->userid); 
            $dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            $dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if($dept->dept_name == "MANURE PLANT"){
                $dept_name = $dept->dept_name;
            }else{
                $dept_name = "";
            }

            if ($row->executedby != '0') {
                echo    '<p style="color: red;"><b> NOTE: </b>If the IT Support already addresses your concern or the status of your concern is "Executed". Please click the <i style="color:#3c8dbc; cursor: pointer" class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i> button!</p>';
            }
            
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <input type="text" class="form-control" name="usergroup" id="usergroup"   value="'.$row->groupname.'" readonly>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" readonly>';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                    
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

        ?>
            <script>
                $(".select-type1").select2({
                    placeholder: "Select a Request Type",
                    allowClear: true
                });

                $(".select-group1").select2({
                    placeholder: "Select a User Group",
                    allowClear: true
                });

                // $(".select-mode1").select2({
                //     placeholder: "Select a Request Mode",
                //     allowClear: true
                // });

            </script>

            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
        <?php        
        }

        public function approverfs_content_e() //displays RFS details 
        {
            $row = $this->Admin_Model->getReqRfsApprovebyRequest($_POST['ids']);
            @$group = $row->togroup;
            $data1 = $this->Admin_Model->getUserGroup();
            $data2 = $this->Admin_Model->getUserRfs();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'RFS';
            @$data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            @$data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            @$bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }
            
            @$stat = $row->status;

            @$req_name = $this->Admin_Model->getUserData2($row->userid);
            echo'<p style="color: red;"> <b>Note:</b> You can also execute, cancel, print, recall and disregard requests or add/update remarks here, just scroll for the buttons below. </p><br>';
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.@$row->requestnumber.'</b></div><br>';
            
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.@$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.@$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Requested By</label>
                            <input type="text" class="form-control" name="requestedby_name" id="requestedby_name"   value="'.$req_name->name.'"  readonly>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group (in case the requester selected the wrong Group)</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group1 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->requesttype.'" readonly>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose"  readonly>';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details"  readonly>';echo $row->details; echo'</textarea>
                        </div>
                    </div>';

                    if($row->remarks != ''){
                    echo'
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus  id="remarks" name="remarks">';echo $row->remarks; echo'</textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button> 
                            </div>
                        </div>';
                    }else{
                    echo'
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus id="remarks" name="remarks" ></textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button> 
                            </div>
                        </div>';
                    }
                    
                echo'</div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div><br><hr>
                <div class="row" style="float: right;">';

                    $taskid1 = 2;
                    $taskid2 = 3;
                    if($row->executedby == '0' AND $row->cancelledby == '0'){

                        if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('rfs')) == true AND $row->approvedby != '0' AND $row->reviewedby != '0' AND $row->userid != $this->session->user_id){

                            echo '<a class="btn btn-default btm-sm" title="Approve Request1" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('rfs')) == true AND $row->approvedby != '0' AND $row->verifiedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request2" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('rfs')) == true AND $row->approvedby != '0' AND $row->reviewedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request3" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('rfs')) == true AND $row->approvedby != '0' AND $row->verifiedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request4" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('rfs')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request5" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }
                        elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('rfs')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request6" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($row->userid == $this->session->user_id )
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request7" style="color: #3c8dbc; cursor: pointer; floa: right;"  onclick=executevalid()> <i class="fa fa-thumbs-o-up " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span></i></a>&nbsp;&nbsp;  &nbsp;';
                        }

                        else{
                            echo '<a class="btn btn-default btm-sm" title="Approve Request8" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }


                    echo '<a class="btn btn-default btm-sm" title="Cancel Request" style="color: #F03649; cursor: pointer"  onclick=updatestatusrequest('.$row->reqid.')> <i class="fa fa-times " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Cancel </span></i></a>&nbsp;&nbsp;  &nbsp;';


                    }
                    // if ($row->remarks == '') {
                    //     echo '
                    //         <a class="btn btn-default btm-sm" id="rem1-'.$row->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$row->reqid.')><i class="fa fa-comment-o " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }else{
                    //     echo '
                    //         <a class="btn btn-default btm-sm"id="rem2-'.$row->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$row->reqid.')><i class="fa fa-comment " aria-hidden="true" ><span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }

                    if ($row->reqstatus == 'Approved') {
                        echo '<a class="btn btn-default btm-sm" title="Print" style="color: #3c8dbc; cursor: pointer;" onclick=print_rfs('.$row->reqid.')> <i class="fa fa-print "> <span style="font-family: Inter-Regular;; font-size: 12px;"> Print </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                    if ($row->cancelledby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Recall </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }
                    if($row->executedby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestE('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Disregard </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                       
                echo'</div><br>
                </div><br>';
                  //<img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

                // <div class="col-md-6">
                //         <div class="form-group">
                //             <label for="type">Request Mode</label><br>
                //             <input type="text" class="form-control" name="requests_mode" id="requests_mode"  value="'.$row->themode.'" readonly>
                            
                //         </div>
                //     </div>

            ?>
            <script>
                $(".select-type1").select2({
                    placeholder: "Select a Request Type",
                    allowClear: true
                });

                $(".select-group1").select2({
                    
                    allowClear: false
                });

                // $(".select-mode1").select2({
                //     placeholder: "Select a Request Mode",
                //     allowClear: true
                // });

                $(document).ready(function() {
                    $("#usergroup").change(function() {
                        var req_id = document.getElementById("id").value;
                        var selectedValue = $(this).val(); // Get the selected value
                        
                        Swal.fire({
                            title: 'Confirmation',
                            text: "Are you sure to update the usergroup?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '',
                            confirmButtonText: 'Proceed!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Create a FormData object to send data
                                var formData = new FormData();
                                formData.append('selectedValue', selectedValue);
                                formData.append('req_id', req_id);
                                
                                $.ajax({
                                    url: baseurl + 'groupsupdate',
                                    type: 'POST',
                                    data: formData, // Use formData here
                                    processData: false,
                                    contentType: false,
                                    error: function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        });
                                    },
                                    success: function(data) {
                                        // Call a function if 'swal_message' is defined
                                        if (typeof swal_message === 'function') {
                                            swal_message('success', 'User Group Successfully Updated!');
                                            var table = $('#dt-execute').DataTable();
                                            var currentPage = table.page();

                                            table.ajax.reload(function () {
                                                // Set the page back to the saved page number
                                                table.page(currentPage).draw('page');
                                            }); 
                                            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                                            $('#dt-execute').DataTable({
                                                "aoColumnDefs": 
                                                [{ "bSortable": false, "aTargets": [0] }]
                                            });
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    });
                });
                
            </script>

            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function approvetor_content_e() //displays TOR details 
        {
            $row = $this->Admin_Model->getReqTorApprovebyRequest($_POST['ids']);
            $group = $row->togroup;
            $data1 = $this->Admin_Model->getUserGroup();
            // $data2 = $this->Admin_Model->getUserTor();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'TOR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }
            $req_name = $this->Admin_Model->getUserData2($row->userid);
            //$stat = $row->status;
            echo'<p style="color: red;"> <b>Note:</b> You can also execute, cancel, print, recall and disregard requests or add/update remarks here, just scroll for the buttons below. </p><br>';
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Requested By</label>
                            <input type="text" class="form-control" name="requestedby_name" id="requestedby_name"   value="'.$req_name->name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group (in case the requester selected the wrong Group)</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group1 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->tortype.'" readonly>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="42" readonly>';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" readonly>';echo $row->details; echo'</textarea>
                        </div>
                    </div>';

                    if($row->remarks != ''){
                    echo'
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus  id="remarks" name="remarks">';echo $row->remarks; echo'</textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button> 
                            </div>
                        </div>';
                    }else{
                    echo'
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus id="remarks" name="remarks" ></textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button> 
                            </div>
                        </div>';
                    }
                    
                echo'</div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div><br><hr>
                <div class="row" style="float: right;">';

                    $taskid1 = 2;
                    $taskid2 = 3;
                    if($row->executedby == '0' AND $row->cancelledby == '0'){

                        if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('tor')) == true AND $row->approvedby != '0' AND $row->reviewedby != '0' AND $row->userid != $this->session->user_id){

                            echo '<a class="btn btn-default btm-sm" title="Approve Request1" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('tor')) == true AND $row->approvedby != '0' AND $row->verifiedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request2" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('tor')) == true AND $row->approvedby != '0' AND $row->reviewedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request3" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('tor')) == true AND $row->approvedby != '0' AND $row->verifiedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request4" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('tor')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request5" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }
                        elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('tor')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request6" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($row->userid == $this->session->user_id )
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request7" style="color: #3c8dbc; cursor: pointer; floa: right;"  onclick=executevalid()> <i class="fa fa-thumbs-o-up " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span></i></a>&nbsp;&nbsp;  &nbsp;';
                        }

                        else{
                            echo '<a class="btn btn-default btm-sm" title="Approve Request8" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }


                    echo '<a class="btn btn-default btm-sm" title="Cancel Request" style="color: #F03649; cursor: pointer"  onclick=updatestatusrequest('.$row->reqid.')> <i class="fa fa-times " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Cancel </span></i></a>&nbsp;&nbsp;  &nbsp;';


                    }
                    // if ($row->remarks == '') {
                    //     echo '
                    //         <a class="btn btn-default btm-sm" id="rem1-'.$row->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$row->reqid.')><i class="fa fa-comment-o " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }else{
                    //     echo '
                    //         <a class="btn btn-default btm-sm"id="rem2-'.$row->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$row->reqid.')><i class="fa fa-comment " aria-hidden="true" ><span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }

                    if ($row->reqstatus == 'Approved') {
                        echo '<a class="btn btn-default btm-sm" title="Print" style="color: #3c8dbc; cursor: pointer;" onclick=print_tor('.$row->reqid.')> <i class="fa fa-print "> <span style="font-family: Inter-Regular;; font-size: 12px;"> Print </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                    if ($row->cancelledby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Recall </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }
                    if($row->executedby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestE('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Disregard </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                       
                echo'</div><br>
                </div><br>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

            ?>
            
            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }

                $(".select-group1").select2({
                    
                    allowClear: false
                });

                $(document).ready(function() {
                    $("#usergroup").change(function() {
                        var req_id = document.getElementById("id").value;
                        var selectedValue = $(this).val(); // Get the selected value
                        
                        Swal.fire({
                            title: 'Confirmation',
                            text: "Are you sure to update the usergroup?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '',
                            confirmButtonText: 'Proceed!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Create a FormData object to send data
                                var formData = new FormData();
                                formData.append('selectedValue', selectedValue);
                                formData.append('req_id', req_id);
                                
                                $.ajax({
                                    url: baseurl + 'groupsupdate',
                                    type: 'POST',
                                    data: formData, // Use formData here
                                    processData: false,
                                    contentType: false,
                                    error: function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        });
                                    },
                                    success: function(data) {
                                        // Call a function if 'swal_message' is defined
                                        if (typeof swal_message === 'function') {
                                            swal_message('success', 'User Group Successfully Updated!');
                                            var table = $('#dt-execute').DataTable();
                                            var currentPage = table.page();

                                            table.ajax.reload(function () {
                                                // Set the page back to the saved page number
                                                table.page(currentPage).draw('page');
                                            }); 
                                            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                                            $('#dt-execute').DataTable({
                                                "aoColumnDefs": 
                                                [{ "bSortable": false, "aTargets": [0] }]
                                            });
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    });
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function approveisr_content_e() //displays ISR details 
        {
            $row = $this->Admin_Model->getReqIsrApprovebyRequest($_POST['ids']);
            $group = $row->togroup;
            $data1 = $this->Admin_Model->getUserGroup();
            // $data2 = $this->Admin_Model->getUserTor();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'ISR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }
            $req_name = $this->Admin_Model->getUserData2($row->userid);
            //$stat = $row->status;
            echo'<p style="color: red;"> <b>Note:</b> You can also execute, cancel, print, recall and disregard requests or add/update remarks here, just scroll for the buttons below. </p><br>';
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Requested By</label>
                            <input type="text" class="form-control" name="requestedby_name" id="requestedby_name"   value="'.$req_name->name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group (in case the requester selected the wrong Group)</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group1 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->requesttype.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">Type of System</label><br>
                            <input type="text" class="form-control" name="systype" id="systype"   value="'.$row->typeofsystem.'" readonly>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="50" readonly>';echo $row->purpose; echo' </textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">General Specifications/Explanations</label><br>
                            <textarea  id="generals" name="generals" rows="5" cols="42" readonly>';echo $row->generals; echo'</textarea>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Security Control Specifications</label><br>
                            <textarea id="security" name="security" rows="5" cols="50" readonly>';echo $row->security; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Output Specifications</label><br>
                            <textarea  id="output" name="output" rows="5" cols="42" readonly>';echo $row->output; echo'</textarea>
                        </div>
                    </div>';

                    if($row->remarks != ''){
                    echo'
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus  id="remarks" name="remarks">';echo $row->remarks; echo'</textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button>
                            </div>
                        </div>';
                    }else{
                    echo'
                    
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="remarks">Remarks</label><br>
                                <input type="hidden" class="form-control" name="id" id="id" value="'.$row->reqid.'">
                                <textarea rows="4" cols="50" autofocus id="remarks" name="remarks" ></textarea>
                                <button type="submit" class="btn btn-primary" value="Submit">Save Remarks</button> 
                                <button type="reset" class="btn btn-danger" value="Reset">Reset Remarks</button> 
                            </div>
                        </div>';
                    }
                    
                echo'</div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> <br><hr>
                <div class="row" style="float: right;">';

                    $taskid1 = 2;
                    $taskid2 = 3;
                    if($row->executedby == '0' AND $row->cancelledby == '0'){

                        if($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('isr')) == true AND $row->approvedby != '0' AND $row->reviewedby != '0' AND $row->userid != $this->session->user_id){

                            echo '<a class="btn btn-default btm-sm" title="Approve Request1" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('isr')) == true AND $row->approvedby != '0' AND $row->verifiedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request2" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('isr')) == true AND $row->approvedby != '0' AND $row->reviewedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request3" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('isr')) == true AND $row->approvedby != '0' AND $row->verifiedby == '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request4" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid1,strtoupper('isr')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request5" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }
                        elseif ($this->Admin_Model->getTypeBuTask($row->buid,$taskid2,strtoupper('isr')) == false AND $row->approvedby != '0' AND $row->userid != $this->session->user_id) 
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request6" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestE('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }elseif ($row->userid == $this->session->user_id )
                        {
                            echo '<a class="btn btn-default btm-sm" title="Approve Request7" style="color: #3c8dbc; cursor: pointer; floa: right;"  onclick=executevalid()> <i class="fa fa-thumbs-o-up " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span></i></a>&nbsp;&nbsp;  &nbsp;';
                        }

                        else{
                            echo '<a class="btn btn-default btm-sm" title="Approve Request8" style="color: #3c8dbc; cursor: pointer"  onclick=executestatusrequest('.$row->reqid.')> <i class="fa fa-thumbs-o-up " aria-hidden="true"> <span style="font-family: Inter-Regular;; font-size: 12px;">Execute </span> </i></a>&nbsp;&nbsp;  &nbsp;';
                        }


                    echo '<a class="btn btn-default btm-sm" title="Cancel Request" style="color: #F03649; cursor: pointer"  onclick=updatestatusrequest('.$row->reqid.')> <i class="fa fa-times " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Cancel </span></i></a>&nbsp;&nbsp;  &nbsp;';


                    }
                    // if ($row->remarks == '') {
                    //     echo '
                    //         <a class="btn btn-default btm-sm" id="rem1-'.$row->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$row->reqid.')><i class="fa fa-comment-o " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }else{
                    //     echo '
                    //         <a class="btn btn-default btm-sm"id="rem2-'.$row->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$row->reqid.')><i class="fa fa-comment " aria-hidden="true" ><span style="font-family: Inter-Regular;; font-size: 12px;">Remarks </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    // }

                    if ($row->reqstatus == 'Approved') {
                        echo '<a class="btn btn-default btm-sm" title="Print" style="color: #3c8dbc; cursor: pointer;" onclick=print_tor('.$row->reqid.')> <i class="fa fa-print "> <span style="font-family: Inter-Regular;; font-size: 12px;"> Print </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                    if ($row->cancelledby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Recall </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }
                    if($row->executedby != '0'){
                        echo '
                            <a class="btn btn-default btm-sm" title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestE('.$row->reqid.')> <i class="fa fa-undo " aria-hidden="true" > <span style="font-family: Inter-Regular;; font-size: 12px;"> Disregard </span></i></a>&nbsp;&nbsp;  &nbsp;';
                    }

                       
                echo'</div><br>
                </div><br>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

            ?>
            
            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }

                $(".select-group1").select2({
                    
                    allowClear: false
                });

                $(document).ready(function() {
                    $("#usergroup").change(function() {
                        var req_id = document.getElementById("id").value;
                        var selectedValue = $(this).val(); // Get the selected value
                        
                        Swal.fire({
                            title: 'Confirmation',
                            text: "Are you sure to update the usergroup?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '',
                            confirmButtonText: 'Proceed!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Create a FormData object to send data
                                var formData = new FormData();
                                formData.append('selectedValue', selectedValue);
                                formData.append('req_id', req_id);
                                
                                $.ajax({
                                    url: baseurl + 'groupsupdate',
                                    type: 'POST',
                                    data: formData, // Use formData here
                                    processData: false,
                                    contentType: false,
                                    error: function() {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!'
                                        });
                                    },
                                    success: function(data) {
                                        // Call a function if 'swal_message' is defined
                                        if (typeof swal_message === 'function') {
                                            swal_message('success', 'User Group Successfully Updated!');
                                            var table = $('#dt-execute').DataTable();
                                            var currentPage = table.page();

                                            table.ajax.reload(function () {
                                                // Set the page back to the saved page number
                                                table.page(currentPage).draw('page');
                                            }); 
                                            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                                            $('#dt-execute').DataTable({
                                                "aoColumnDefs": 
                                                [{ "bSortable": false, "aTargets": [0] }]
                                            });
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    });
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function approverfs_content() //displays RFS details 
        {
            $row = $this->Admin_Model->getReqRfsApprovebyRequest($_POST['ids']);
            $group = $row->togroup;
            $data1 = $this->Admin_Model->getUserGroup();
            $data2 = $this->Admin_Model->getUserRfs();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'RFS';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }
            
            $stat = $row->status;
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <input type="text" class="form-control" name="usergroup" id="usergroup"   value="'.$row->groupname.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->requesttype.'" readonly>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="42" readonly>';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" readonly>';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                    
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

                    // <div class="col-md-6">
                    //     <div class="form-group">
                    //         <label for="type">Request Mode</label><br>
                    //         <input type="text" class="form-control" name="requests_mode" id="requests_mode"  value="'.$row->themode.'" readonly>
                            
                    //     </div>
                    // </div>

            ?>
            <script>
                $(".select-type1").select2({
                    placeholder: "Select a Request Type",
                    allowClear: true
                });

                $(".select-group1").select2({
                    placeholder: "Select a User Group",
                    allowClear: true
                });

                // $(".select-mode1").select2({
                //     placeholder: "Select a Request Mode",
                //     allowClear: true
                // });

            </script>

            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function approvetor_content() //displays TOR details 
        {
            $row = $this->Admin_Model->getReqTorApprovebyRequest($_POST['ids']);
            //$group = $row->togroup;
            // $data1 = $this->Admin_Model->getUserGroup();
            // $data2 = $this->Admin_Model->getUserTor();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'TOR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }

            //$stat = $row->status;
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <input type="text" class="form-control" name="usergroup" id="usergroup"   value="'.$row->groupname.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->tortype.'" readonly>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="42" readonly>';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" readonly>';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                    
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

            ?>
            
            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function approveisr_content() //displays ISR details 
        {
            $row = $this->Admin_Model->getReqIsrApprovebyRequest($_POST['ids']);
            //$group = $row->togroup;
            // $data1 = $this->Admin_Model->getUserGroup();
            // $data2 = $this->Admin_Model->getUserTor();
            // $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'ISR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid); 

            @$emp = $this->employee_model->find_an_employee5($row->userid); 
            @$dept_code = $this->employee_model->find_an_employee3($emp->emp_id);
            @$dept = $this->employee_model->dept_name($dept_code->bunit_code, $dept_code->company_code, $dept_code->dept_code);

            if(@$dept->dept_name == "MANURE PLANT"){
                @$dept_name = $dept->dept_name;
            }else{
                @$dept_name = "";
            }
            //$stat = $row->status;
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id"  value="'.$row->reqid.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no"  value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company"   value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu"   value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dept">Department</label>
                            <input type="text" class="form-control" name="dept" id="dept"   value="'.@$dept_name.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact"   value="'.$row->contactno.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date"   value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <input type="text" class="form-control" name="usergroup" id="usergroup"   value="'.$row->groupname.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <input type="text" class="form-control" name="rfstype" id="rfstype"   value="'.$row->requesttype.'" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">Type of System</label><br>
                            <input type="text" class="form-control" name="systype" id="systype"   value="'.$row->typeofsystem.'" readonly>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="50" readonly>';echo $row->purpose; echo' </textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">General Specifications/Explanations</label><br>
                            <textarea  id="generals" name="generals" rows="5" cols="42" readonly>';echo $row->generals; echo'</textarea>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Security Control Specifications</label><br>
                            <textarea id="security" name="security" rows="5" cols="50" readonly>';echo $row->security; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Output Specifications</label><br>
                            <textarea  id="output" name="output" rows="5" cols="42" readonly>';echo $row->output; echo'</textarea>
                        </div>
                    </div>

                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images  </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

            ?>
            
            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
            <?php        
        }

        public function printisr($ids) //prints the completed ISR
        {
            $data = $this->Admin_Model->getReqIsrApprovebyRequest($ids);
            //$c = $data->fname." ".$data->lname;
            $bu = $this->Admin_Model->bu_name($data->buid);
            $requestdetails     = $this->user_model->getuserDetails2($data->userid);
            $requestedby        = $this->employee_model->find_an_employee(@$requestdetails->emp_id);
            $requestedby_name   = $this->employee_model->find_employee_name(@$requestdetails->emp_id);
            
            @$approvedetails     = $this->user_model->getuserDetails2($data->approvedby);
            @$approvedby         = $this->employee_model->find_an_employee(@$approvedetails->emp_id);
            @$approvedby_name    = $this->employee_model->find_employee_name(@$approvedetails->emp_id);
            
            // $executedby = $this->Admin_Model->getUserData2($data->executedby);
            @$executedetails     = $this->user_model->getuserDetails2(@$data->executedby);
            @$executedby         = $this->employee_model->find_an_employee(@$executedetails->emp_id);
            @$executedby_name    = $this->employee_model->find_employee_name(@$executedetails->emp_id);
            

            $pdf = new FPDF('P','mm',array(216,279)); //letter 
            $pdf->AliasNbPages();
            
            $pdf->Header();
            $pdf->SetTopMargin(10);
            $pdf->SetAutoPageBreak(TRUE, 10);
            $pdf->AddPage("P","Letter");
            $pdf->SetFont('Times','',8);
            $x = 0;

            

            $pdf->Image('uploads/profile-pic/alturaslogo.png',10,6,30);     
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,-5,'INFORMATION SYSTEM REQUEST (ISR) FORM',0,1,'C');
            

            $pdf->setXY(10,17);$pdf->Cell(0,15,'TO : ');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(20,17);$pdf->Cell(0,15, $data->groupname. ' TEAM - '.@$executedby_name->firstname." ".@$executedby_name->lastname);
            // $pdf->setXY(20, 17);
            // $pdf->Cell(0, 15, $data->groupname . ' TEAM - Elison Tan');


            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,17);$pdf->Cell(0,15,'ISR No : ');
            $pdf->SetFont('Helvetica','B',11);
            $pdf->SetTextColor(225,0,0);
            $pdf->setXY(130,17);$pdf->Cell(0,15,$data->requestnumber);
            $pdf->SetTextColor(0,0,0);

            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,22);$pdf->Cell(0,15,'Date:');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(130,22);$pdf->Cell(0,15,date(" M. d, Y h:i:s A", strtotime($data->datetoday)));
            
            $pdf->setXY(10,40);$pdf->Cell(0,15,'1.0 Requesting Party Info');
            $pdf->SetFont('Helvetica','',9);

            $pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
            $pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper($requestedby_name->firstname." ".$requestedby_name->lastname));
            $pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(35,50);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
            $pdf->setXY(35,55);$pdf->Cell(0,15,strtoupper($requestedby->position));


            // $pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
            // $pdf->setXY(35,45);$pdf->Cell(0,15);
            // $pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
            // $pdf->setXY(35,50);$pdf->Cell(0,15);
            // $pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
            // $pdf->setXY(35,55);$pdf->Cell(0,15);

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,70);$pdf->Cell(0,15,'1.1 Request Approved By');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(10,75);$pdf->Cell(0,15,'Full Name:');
            $pdf->setXY(10,80);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(10,85);$pdf->Cell(0,15,'Job Position:');

            $pdf->setXY(35,75);$pdf->Cell(0,15,strtoupper(@$approvedby_name->firstname." ".@$approvedby_name->lastname));
            $pdf->setXY(35,80);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(35,85);$pdf->Cell(0,15,strtoupper(@$approvedby->position));

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,120);$pdf->Cell(0,0,'2.0 Nature of Request');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,125);$pdf->MultiCell(90,4,strtoupper($data->requesttype),0,'L',0);


            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,150);$pdf->Cell(0,0,'3.0 Purpose');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,155);$pdf->MultiCell(90,4,strtoupper($data->purpose),0,'L',0);

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(110,47);$pdf->Cell(0,0,'4.0 General Specifications/Explanations');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(115,51);$pdf->Cell(0,0,'(effects as inputs, processes, database, etc.)');
            $pdf->SetFont('Helvetica','',9);
            if($data->generals == "" or is_null($data->generals)){
                $pdf->setXY(115,53);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,58);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,63);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,68);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,73);$pdf->Cell(0,15,'______________________________________________');
            }
            else{
                $pdf->setXY(115,56);
                //$pdf->MultiCell(90,4,strtoupper($data->generals),0,'L',0);
                $pdf->MultiCell(90, 4, $data->generals, 0, 'L', 0);
            }

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(110,120);$pdf->Cell(0,0,'5.0 Security Control Specification');
            $pdf->SetFont('Helvetica','',9);
            if($data->security == "" or is_null($data->security)){
                $pdf->setXY(115,125);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,130);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,135);$pdf->Cell(0,15,'______________________________________________');
            }
            else{
                $pdf->setXY(115,125);$pdf->MultiCell(90,4,strtoupper($data->security),0,'L',0);
            }

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(110,150);$pdf->Cell(0,0,'6.0 Output Specification');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(115,154);$pdf->Cell(0,0,'(Report format/Textfile copy format, target drive/location)');
            $pdf->SetFont('Helvetica','',9);
            if($data->output =="" or is_null($data->output)){
                $pdf->setXY(115,134);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,139);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,144);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,149);$pdf->Cell(0,15,'______________________________________________');
            }
            else{
                $pdf->setXY(115,158);$pdf->MultiCell(90,4,strtoupper($data->output),0,'L',0);
            }

                        /*                    REQUESTED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,220);$pdf->Cell(0,0,'Requested By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(10,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',9);
            $pdf->setXY(28,235);$pdf->Cell(0,0,strtoupper($requestedby_name->firstname." ".$requestedby_name->lastname));   
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    REQUESTED BY                             */


            /*                    APPROVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(80,220);$pdf->Cell(0,0,'Approved By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,230);$pdf->Cell(0,0,'Signature:  __________________');
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',9);
            $pdf->setXY(98,235);$pdf->Cell(0,0,strtoupper(@$approvedby_name->firstname." ".@$approvedby_name->lastname));
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    APPROVED BY                             */


            /*                    RECEIVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name: __________________');
            $pdf->setXY(150,240);$pdf->Cell(0,0,'Date:     __________________');
            /*                    RECEIVED BY                          */



            $pdf->Output('ISR_'.$data->requestnumber.'('.date("m-d-Y", strtotime($data->datetoday)).').pdf', 'I');

            
        }

        public function printrfs($ids) //prints the completed RFS
        {
            $data = $this->Admin_Model->getReqRfsApprovebyRequest($ids);
            //$c = $data->fname." ".$data->lname;
            $bu = $this->Admin_Model->bu_name($data->buid);

            @$requestdetails     = $this->user_model->getuserDetails2($data->userid);
            @$requestedby        = $this->employee_model->find_an_employee(@$requestdetails->emp_id);
            @$requestedby_name   = $this->employee_model->find_employee_name(@$requestdetails->emp_id);

            if(@$requestedby_name->firstname == '' || @$requestedby_name->lastname == ''){
                @$requester1   = $this->employee_model->find_an_employee6(@$requestdetails->emp_id);
            }else{
                @$requester   = $this->employee_model->find_employee_name(@$requestdetails->emp_id);
            }

            
            $approvedetails     = $this->user_model->getuserDetails2($data->approvedby);
            $approvedby         = $this->employee_model->find_an_employee(@$approvedetails->emp_id);
            $approvedby_name    = $this->employee_model->find_employee_name(@$approvedetails->emp_id);
            
            // $executedby = $this->Admin_Model->getUserData2($data->executedby);
            $executedetails     = $this->user_model->getuserDetails2($data->executedby);
            $executedby         = $this->employee_model->find_an_employee(@$executedetails->emp_id);
            $executedby_name    = $this->employee_model->find_employee_name(@$executedetails->emp_id);

            $pdf = new FPDF('P','mm',array(216,279)); //letter 
            $pdf->AliasNbPages();
            
            $pdf->Header();
            $pdf->SetTopMargin(10);
            $pdf->SetAutoPageBreak(TRUE, 10);
            $pdf->AddPage("P","Letter");
            $pdf->SetFont('Times','',8);
            $x = 0;

            

            $pdf->Image('uploads/profile-pic/alturaslogo.png',10,6,30);     
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,-5,'REQUEST FOR SETUP (RFS) FORM',0,1,'C');
            

            $pdf->setXY(10,17);$pdf->Cell(0,15,'TO : ');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(20,17);$pdf->Cell(0,15, $data->groupname. ' TEAM - '.$executedby_name->firstname." ".$executedby_name->lastname);

            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,17);$pdf->Cell(0,15,'RFS No : ');
            $pdf->SetFont('Helvetica','B',11);
            $pdf->SetTextColor(225,0,0);
            $pdf->setXY(130,17);$pdf->Cell(0,15,$data->requestnumber);
            $pdf->SetTextColor(0,0,0);

            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,22);$pdf->Cell(0,15,'Date:');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(130,22);$pdf->Cell(0,15,date(" M. d, Y h:i:s A", strtotime($data->datetoday)));
            
            $pdf->setXY(10,40);$pdf->Cell(0,15,'1.0 Requesting Party Info');
            $pdf->SetFont('Helvetica','',9);

            $pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
            // $pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper(@$requestedby_name->firstname." ".@$requestedby_name->lastname));
            if(@$requestedby_name->firstname == '' || @$requestedby_name->lastname == ''){
                 $pdf->setXY(35, 45);$pdf->Cell(0, 15, strtoupper(@$requester1->name));
            }else{
                // $pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper(@$requester->firstname." ".@$requester->lastname)); 
                
                $pdf->setXY(35, 45);

                // Concatenate the firstname and lastname
                $name = mb_strtoupper(@$requester->firstname . " " . @$requester->lastname, 'UTF-8');

                // Encode the concatenated name using UTF-8 (optional, depending on your application's encoding)
                // $name = utf8_encode($name);
                $name = utf8_decode($name);
                // Display the uppercase name in the Cell
                $pdf->Cell(0, 15, $name);

            }

            $pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(35,50);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
            $pdf->setXY(35,55);$pdf->Cell(0,15,strtoupper(@$requestedby->position));

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,70);$pdf->Cell(0,15,'1.1 Request Approved By');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(10,75);$pdf->Cell(0,15,'Full Name:');
            $pdf->setXY(10,80);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(10,85);$pdf->Cell(0,15,'Job Position:');

            $pdf->setXY(35,75);$pdf->Cell(0,15,strtoupper($approvedby_name->firstname." ".$approvedby_name->lastname));
            $pdf->setXY(35,80);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(35,85);$pdf->Cell(0,15,strtoupper($approvedby->position));

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,105);$pdf->Cell(0,0,'2.0 Nature of Request');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,110);$pdf->MultiCell(90,4,strtoupper($data->requesttype),0,'L',0);


            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,130);$pdf->Cell(0,0,'3.0 Purpose');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,135);$pdf->MultiCell(90,4,strtoupper($data->purpose),0,'L',0);

            // $pdf->SetFont('Helvetica','B',10);
            // $pdf->setXY(110,105);$pdf->Cell(0,0,'2.1 Request Mode');
            // $pdf->SetFont('Helvetica','',9);
            // $pdf->setXY(115,110);$pdf->MultiCell(90,4,strtoupper($data->themode),0,'L',0);
            

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(110,130);$pdf->Cell(0,0,'4.0 Details');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(115,134);$pdf->Cell(0,0,'(effects as inputs, processes, database, etc.)');
            $pdf->SetFont('Helvetica','',9);
            if($data->details =="" or is_null($data->details)){
                $pdf->setXY(115,134);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,139);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,144);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,149);$pdf->Cell(0,15,'______________________________________________');
            }
            else{
                $pdf->setXY(115,138);$pdf->MultiCell(90,4,strtoupper($data->details),0,'L',0);
            }

                        /*                    REQUESTED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,220);$pdf->Cell(0,0,'Requested By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(10,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',10);
            

            if(@$requestedby_name->firstname == '' || @$requestedby_name->lastname == ''){
                 $pdf->setXY(28,235);$pdf->Cell(0,0, strtoupper(@$requester1->name));
            }else{
                // $pdf->setXY(28,235);$pdf->Cell(0,0,strtoupper(@$requestedby_name->firstname." ".@$requestedby_name->lastname)); 

                $pdf->setXY(28,235);

                // Concatenate the firstname and lastname
                $name1 = mb_strtoupper(@$requester->firstname . " " . @$requester->lastname, 'UTF-8');

                // Encode the concatenated name using UTF-8 (optional, depending on your application's encoding)
                // $name = utf8_encode($name);
                $name1 = utf8_decode($name1);
                // Display the uppercase name in the Cell
                $pdf->Cell(0, 0, $name1);
            }  
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    REQUESTED BY                             */


            /*                    APPROVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(80,220);$pdf->Cell(0,0,'Approved By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,230);$pdf->Cell(0,0,'Signature:  __________________');
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',10);
            $pdf->setXY(98,235);$pdf->Cell(0,0,strtoupper($approvedby_name->firstname." ".$approvedby_name->lastname));
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    APPROVED BY                             */


            // /*                    RECEIVED BY                             */
            // $pdf->SetFont('Helvetica','B',10);
            // $pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');

            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name:');
            // $pdf->SetFont('Helvetica','U',10);
            // $pdf->setXY(168,235);$pdf->Cell(0,0,strtoupper($this->session->name));

            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,240);$pdf->Cell(0,0,'Date:          __________________');
            // /*                    RECEIVED BY                             */

            /*                    RECEIVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name: __________________');
            $pdf->setXY(150,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    RECEIVED BY                             */



            $pdf->Output('RFS_'.$data->requestnumber.'('.date("m-d-Y", strtotime($data->datetoday)).').pdf', 'I');

            
        }

        public function printtor($ids) //prints the completed TOR
        {
            $data = $this->Admin_Model->getReqTorApprovebyRequest($ids);
            //$c = $data->fname." ".$data->lname;
            $bu = $this->Admin_Model->bu_name($data->buid);
            $requestdetails     = $this->user_model->getuserDetails2($data->userid);
            $requestedby        = $this->employee_model->find_an_employee(@$requestdetails->emp_id);
            $requestedby_name   = $this->employee_model->find_employee_name(@$requestdetails->emp_id);
            
            $approvedetails     = $this->user_model->getuserDetails2($data->approvedby);
            $approvedby         = $this->employee_model->find_an_employee(@$approvedetails->emp_id);
            $approvedby_name    = $this->employee_model->find_employee_name(@$approvedetails->emp_id);
            
            // $executedby = $this->Admin_Model->getUserData2($data->executedby);
            $executedetails     = $this->user_model->getuserDetails2($data->executedby);
            $executedby         = $this->employee_model->find_an_employee(@$executedetails->emp_id);
            $executedby_name    = $this->employee_model->find_employee_name(@$executedetails->emp_id);
            

            $pdf = new FPDF('P','mm',array(216,279)); //letter 
            $pdf->AliasNbPages();
            
            $pdf->Header();
            $pdf->SetTopMargin(10);
            $pdf->SetAutoPageBreak(TRUE, 10);
            $pdf->AddPage("P","Letter");
            $pdf->SetFont('Times','',8);
            $x = 0;

            

            $pdf->Image('uploads/profile-pic/alturaslogo.png',10,6,30);     
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(190,-5,'TRANSACTION OVERRIDE REQUEST (TOR) FORM',0,1,'C');
            

            $pdf->setXY(10,17);$pdf->Cell(0,15,'TO : ');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(20,17);$pdf->Cell(0,15, $data->groupname. ' TEAM - '.$executedby_name->firstname." ".$executedby_name->lastname);

            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,17);$pdf->Cell(0,15,'TOR No : ');
            $pdf->SetFont('Helvetica','B',11);
            $pdf->SetTextColor(225,0,0);
            $pdf->setXY(130,17);$pdf->Cell(0,15,$data->requestnumber);
            $pdf->SetTextColor(0,0,0);

            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(110,22);$pdf->Cell(0,15,'Date:');
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(130,22);$pdf->Cell(0,15,date(" M. d, Y h:i:s A", strtotime($data->datetoday)));
            
            $pdf->setXY(10,40);$pdf->Cell(0,15,'1.0 Requesting Party Info');
            $pdf->SetFont('Helvetica','',9);

            $pdf->setXY(10,45);$pdf->Cell(0,15,'Full Name:');
            $pdf->setXY(35,45);$pdf->Cell(0,15,strtoupper($requestedby_name->firstname." ".$requestedby_name->lastname));
            $pdf->setXY(10,50);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(35,50);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(10,55);$pdf->Cell(0,15,'Job Position:');
            $pdf->setXY(35,55);$pdf->Cell(0,15,strtoupper($requestedby->position));

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,70);$pdf->Cell(0,15,'1.1 Request Approved By');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(10,75);$pdf->Cell(0,15,'Full Name:');
            $pdf->setXY(10,80);$pdf->Cell(0,15,'Representing:');
            $pdf->setXY(10,85);$pdf->Cell(0,15,'Job Position:');

            $pdf->setXY(35,75);$pdf->Cell(0,15,strtoupper($approvedby_name->firstname." ".$approvedby_name->lastname));
            $pdf->setXY(35,80);$pdf->Cell(0,15,strtoupper($bu->business_unit));
            $pdf->setXY(35,85);$pdf->Cell(0,15,strtoupper($approvedby->position));

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,105);$pdf->Cell(0,0,'2.0 Nature of Request');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,110);$pdf->MultiCell(90,4,strtoupper($data->tortype),0,'L',0);


            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,130);$pdf->Cell(0,0,'3.0 Purpose');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(15,135);$pdf->MultiCell(90,4,strtoupper($data->purpose),0,'L',0);

            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(110,130);$pdf->Cell(0,0,'4.0 Details');
            $pdf->SetFont('Helvetica','',9);
            $pdf->setXY(115,134);$pdf->Cell(0,0,'(effects as inputs, processes, database, etc.)');
            $pdf->SetFont('Helvetica','',9);
            if($data->details =="" or is_null($data->details)){
                $pdf->setXY(115,134);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,139);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,144);$pdf->Cell(0,15,'______________________________________________');
                $pdf->setXY(115,149);$pdf->Cell(0,15,'______________________________________________');
            }
            else{
                $pdf->setXY(115,138);$pdf->MultiCell(90,4,strtoupper($data->details),0,'L',0);
            }

                        /*                    REQUESTED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(10,220);$pdf->Cell(0,0,'Requested By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(10,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',10);
            $pdf->setXY(28,235);$pdf->Cell(0,0,strtoupper($requestedby_name->firstname." ".$requestedby_name->lastname));   
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(10,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    REQUESTED BY                             */


            /*                    APPROVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(80,220);$pdf->Cell(0,0,'Approved By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,230);$pdf->Cell(0,0,'Signature:  __________________');
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,235);$pdf->Cell(0,0,'Full Name:');
            $pdf->SetFont('Helvetica','U',10);
            $pdf->setXY(98,235);$pdf->Cell(0,0,strtoupper($approvedby_name->firstname." ".$approvedby_name->lastname));
            
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(80,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    APPROVED BY                             */


            // /*                    RECEIVED BY                             */
            // $pdf->SetFont('Helvetica','B',10);
            // $pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');

            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name:');
            // $pdf->SetFont('Helvetica','U',10);
            // $pdf->setXY(168,235);$pdf->Cell(0,0,strtoupper($this->session->name));

            // $pdf->SetFont('Helvetica','',10);
            // $pdf->setXY(150,240);$pdf->Cell(0,0,'Date:          __________________');
            // /*                    RECEIVED BY                             */

            /*                    RECEIVED BY                             */
            $pdf->SetFont('Helvetica','B',10);
            $pdf->setXY(150,220);$pdf->Cell(0,0,'Received By:');
            $pdf->SetFont('Helvetica','',10);
            $pdf->setXY(150,230);$pdf->Cell(0,0,'Signature:  __________________');
            $pdf->setXY(150,235);$pdf->Cell(0,0,'Full Name: __________________');
            $pdf->setXY(150,240);$pdf->Cell(0,0,'Date:          __________________');
            /*                    RECEIVED BY                             */



            $pdf->Output('TOR_'.$data->requestnumber.'('.date("m-d-Y", strtotime($data->datetoday)).').pdf', 'I');

            
        }

        public function addremarks_content() //displays content for adding remarks
        {
            $row = $this->Admin_Model->getDataRequest($_POST['ids']);
           
            echo'<div class ="row">
                    <div class="col-md-12">      
                        <div class="form-group">
                            
                            <input type="hidden" class="form-control" name="id" id="id" value="'.$row->id.'">
                            
                            <textarea id="remarks" name="remarks" ></textarea>
                        </div>
                    </div> 
                </div>
                </div>';
       
        }

        public function editremarks_content() //displays content for updating remarks
        {
            $row = $this->Admin_Model->getDataRequest($_POST['ids']);
           
            echo'<div class ="row">
                    <div class="col-md-12">      
                        <div class="form-group">
                            <p style="color: red"><b>Note: </b> Please do not delete or update the previous remarks if there are any.</p>
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no" autocomplete="off" value="'.$row->requestnumber.'" required>
                            <textarea id="remarks" name="remarks">';echo $row->remarks; echo'</textarea>
                        </div>
                    </div>  
                </div>
                </div>';
       
        }

        public function viewremarks_content() //displays content for viewing remarks
        {
            $row = $this->Admin_Model->getDataRequest($_POST['ids']);
           
            echo'<div class ="row">
                    <div class="col-md-12">      
                        <div class="form-group">
                            
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" >
                            
                            <textarea id="remarks" name="remarks" readonly>';echo $row->remarks; echo'</textarea>
                        </div>
                    </div>  
                </div>
                </div>';
       
        }

        public function save_remarks() //passing the data to Admin_model for saving the remarks 
        {
            if(!empty($_POST))
            {
                $request_id = $this->input->post('id');
                $userid     = $this->session->userdata['user_id'];
                $name      = $this->session->userdata['name'];
                $remarks = $this->security->xss_clean($this->input->post('remarks'));
                // if($remarks == ''){
                //     $remarks1 = '';
                // }else{
                //     $remarks1 = $remarks."  (by: ".$name .")" ;
                // }
                
                $data = array(
                    
                    'remarks'           => $remarks     
                );
                $this->Admin_Model->saveRemarks($data,$request_id);

                $request_data   = $this->request_model->get_requests_data($request_id);
                //$action = $this->session->name . ' has saved a remarks for ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'saved ' . '</b>' . ' a remarks for ' . $request_data->typeofrequest . ' No. ' . '<b>' .$request_data->requestnumber. '</b>';
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $request_data->typeofrequest
                    );
                $this->Admin_Model->addLogs($data1);
                $this->session->set_flashdata('SUCCESSMSG1', "success");
            }
            
            $this->session->set_flashdata('SUCCESSMSG1', "success");
            redirect('pending-rfs-status');

        }

        public function editconcern_content() //displays content for updating the concern details 
        {
            $row = $this->Admin_Model->getDataRequestConcern($_POST['ids']);
            $group = $row->togroup;
            $bu = $row->buid;
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserRfs();
            $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'Concern';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid);
            $data6 = $this->Admin_Model->getUserBurole();
            //$stat = $row->status;
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" required>
                            <input type="hidden" class="form-control" name="c_no" id="c_no" autocomplete="off" value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$row->companyname.'" readonly >
                            <input type="hidden" class="form-control" name="company2" id="company2" autocomplete="off"  value="" readonly >
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
                            <select style="width: 100%; padding:5px;" class="select-bu4 form-control" name="bu4" id="bu4" required">
                                <option></option>';
                                foreach ($data6 as $value) {
                                    if($value->id == $bu){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="'.$row->contactno.'" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group1 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" >';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                    
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images (Files will be completely removed once you submit or close the form) </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                <a title="Remove File" style="color: #F03649" id="delete_file_rfs" onclick=updatestatusfiles('.$index.')><i class="fa fa-trash fa-lg" aria-hidden="true" ></i></a>
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

        ?>
            <script>
                $(".select-type1").select2({
                    placeholder: "Select a Request Type",
                    allowClear: true
                });

                $(".select-group1").select2({
                    placeholder: "Select a User Group",
                    allowClear: true
                });

                $(".select-mode1").select2({
                    placeholder: "Select a Request Mode",
                    allowClear: true
                });

                $(".select-bu4").select2({
                    placeholder: "Select a Business Unit",
                    allowClear: true
                });

                $(document).ready(function(){
            
                    let bu = $('#bu4').select2("val");
                    $('select').on('change', function() {
                         
                        let bu = $('#bu4').select2("val");
                        //let company = 
                        document.getElementById('company2').value= bu;

                    });

                });

            </script>

            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
        <?php        
        }

        public function editrfs_content() //displays content for updating the RFS details
        {
            $row = $this->Admin_Model->getDataRequestRfs($_POST['ids']);
            $group = $row->togroup;
            $bu = $row->buid;
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserRfs();
            $data3 = $this->Admin_Model->getUserRfsMode();
            $type = 'RFS';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid);
            $data6 = $this->Admin_Model->getUserBurole();
            //$stat = $row->status;
            echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" required>
                            <input type="hidden" class="form-control" name="rfs_no" id="rfs_no" autocomplete="off" value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$row->companyname.'" readonly >
                            <input type="hidden" class="form-control" name="company2" id="company2" autocomplete="off"  value="" readonly >
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
                            <select style="width: 100%; padding:5px;" class="select-bu4 form-control" name="bu4" id="bu4" required">
                                ';
                                foreach ($data6 as $value) {
                                    if($value->id == $bu){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="'.$row->contactno.'" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group1 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <select style="width: 100%; height: resolve; padding:5px;" class="select-type1 form-control" name="rfstype" id="rfstype" required">
                                <option></option>';
                                foreach ($data2 as $value) {
                                    if($value->rfs_id == $row->rfstype){
                                        $rfstype ='selected';
                                    }else{
                                        $rfstype ='';
                                    }
                        echo   '<option value="'.$value->rfs_id.'" '.$rfstype.'>'.$value->requesttype.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="42" >';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" >';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                    
                </div>
               
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        ';

                        if ($data5->file > 0) {
                            
                            echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-default btm-sm" id="view_files"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                                <a class="btn btn-default btm-sm" id="hide_files" style="display:none;">
                                <i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files
                            </a>';
                        }
                        echo'

                        <div id="files_panel" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images (Files will be completely removed once you submit or close the form) </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                <a title="Remove File" style="color: #F03649" id="delete_file_rfs" onclick=updatestatusfiles('.$index.')><i class="fa fa-trash fa-lg" aria-hidden="true" ></i></a>
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 

                </div>';

                  //  <img src="uploads/profile-pic/'.$m->file_name.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 100px; width: 100px;"><p> '.$m->file_name.'</p> <br>  onclick=updatestatusfiles('.$index.')

                // <div class="col-md-12">
                //         <div class="form-group">
                //             <label for="type">Request Mode</label><br>
                //             <select style="width: 100%; height: resolve; padding:5px;" class="select-mode1 form-control" name="requests_mode" id="requests_mode" required">
                //                 <option></option>';
                //                 foreach ($data3 as $value) {
                //                     if($value->id == $row->requestmode){
                //                         $requestmode ='selected';
                //                     }else{
                //                         $requestmode ='';
                //                     }
                //         echo   '<option value="'.$value->id.'" '.$requestmode.'>'.$value->themode.'</option>';
                //                 }
                //         echo '</select>
                //         </div>
                //     </div>

        ?>
            <script>
                $(".select-type1").select2({
                    // placeholder: "Select a Request Type"
                    selectOnClose: true,
                    allowClear: false
                });

                $(".select-group1").select2({
                    // placeholder: "Select a User Group"
                    selectOnClose: true,
                    allowClear: false
                });

                // $(".select-mode1").select2({
                //     // placeholder: "Select a Request Mode"
                //     selectOnClose: true,
                //     allowClear: false
                // });

                $(".select-bu4").select2({
                    //placeholder: "Select a Business Unit",
                    allowClear: false,
                    selectOnClose: true
                });

                $(document).ready(function(){
            
                    let bu = $('#bu4').select2("val");
                    $('select').on('change', function() {
                         
                        let bu = $('#bu4').select2("val");
                        //let company = 
                        document.getElementById('company2').value= bu;

                    });

                });

            </script>

            <script type="text/javascript">
                function del_files(eleId) {
                    var ele = document.getElementById("delete_file_rfs" + eleId);
                    ele.parentNode.removeChild(ele);
                }
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files]").click(function(){
                    $("#files_panel").fadeIn();
                    $("#view_files").hide();
                    $("#hide_files").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    $("#view_files").fadeIn();
                    $("#hide_files").hide();
                    });       
                });
            </script>
        <?php        
        }

        public function edittor_content() //displays content for updating the TOR details
        {
            $row = $this->Admin_Model->getDataRequestTor($_POST['ids']);
            $group = $row->togroup;
            $bu = $row->buid;
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserTor();
            $type = 'TOR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $data6 = $this->Admin_Model->getUserBurole();
            //$stat = $row->status;
           echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" required>
                            <input type="hidden" class="form-control" name="tor_no" id="tor_no" autocomplete="off" value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company1" id="company1" autocomplete="off"  value="'.$row->companyname.'" readonly >
                            <input type="hidden" class="form-control" name="company2" id="company2" autocomplete="off"  value="" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit (If you have multiple BU Access)</label>
                             
                            <select style="width: 100%; padding:5px;" class="select-bu4 form-control" name="bu4" id="bu4" required">
                                <option></option>';
                                foreach ($data6 as $value) {
                                    if($value->id == $bu){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->id.'" '.$togroup.'>'.$value->business_unit.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="'.$row->contactno.'" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group2 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <select style="width: 100%; height: resolve; padding:5px;" class="select-type2 form-control" name="tortype" id="tortype" required">
                                <option></option>';
                                foreach ($data2 as $value) {
                                    if($value->tor_id == $row->tortypes){
                                        $tortypes ='selected';
                                    }else{
                                        $tortypes ='';
                                    }
                        echo   '<option value="'.$value->tor_id.'" '.$tortypes.'>'.$value->tortype.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="42" >';echo $row->purpose; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Details</label><br>
                            <textarea placeholder="Include I.P. if necessary" id="details" name="details" rows="5" cols="42" >';echo $row->details; echo'</textarea>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-default btm-sm" id="view_files2"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                        <p id="hide_panel" hidden><a class="btn btn-default btm-sm" id="hide_files"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files</a></p>

                        <div id="files_panel2" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images (Files will be completely removed once you submit or close the form) </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.100/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                <a title="Remove File" style="color: #F03649" id="delete_file_rfs" onclick=updatestatusfiles('.$index.')><i class="fa fa-trash fa-lg" aria-hidden="true" ></i></a>
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 
                    

                    
                </div>';

                  // <img src="uploads/profile-pic/'.$row->attachments.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 150px; width: 150px;"> <br>  

            ?>
                <script>
                    $(".select-type2").select2({
                        selectOnClose: true,
                        allowClear: false
                    });

                    $(".select-group2").select2({
                        // placeholder: "Select a User Group",
                        selectOnClose: true,
                        allowClear: false
                    });
                    $(".select-bu4").select2({
                        // placeholder: "Select a Business Unit",
                        selectOnClose: true,
                        allowClear: false
                    });

                    $(document).ready(function(){
                
                        let bu = $('#bu4').select2("val");
                        $('select').on('change', function() {
                             
                            let bu = $('#bu4').select2("val");
                            //let company = 
                            document.getElementById('company2').value= bu;

                        });

                    });
                </script>

                <script type="text/javascript">
                    $(document).ready(function(){
                        $("[id=view_files2]").click(function(){
                        $("#files_panel2").fadeIn();
                        $("#view_files2").hide();
                        $("#hide_files2").fadeIn();
                        });
                        $("[id=hide_files]").click(function(){
                        $("#files_panel").hide();
                        });       
                    });
                </script>
            <?php        
        }

        public function editisr_content() //displays content for updating the ISR details
        {
            $row    = $this->Admin_Model->getDataRequestIsr($_POST['ids']);
            $group = $row->togroup;
            $systype = $row->typeofsystem;
            // $data1 = $this->Admin_Model->getUserGroup();
            $data1 = $this->Admin_Model->getUserGrouprole();
            $data2 = $this->Admin_Model->getUserIsr();
            $type = 'ISR';
            $data4 = $this->Admin_Model->getFiles($row->requestnumber,$type); 
            $data5 = $this->Admin_Model->getFilesCount($row->requestnumber,$type); 
            $bu_name = $this->Admin_Model->bu_name($row->buid);
            //$stat = $row->status;
           echo'<div><label for="company">Control No:</label>  <b style="color:red">'.$row->requestnumber.'</b></div><br>';
            echo    '<div class ="row">
                    <div class="col-md-6">      
                        <div class="form-group">
                            <label for="company">Company Name</label>
                            <input type="hidden" class="form-control" name="id" id="id" autocomplete="off" value="'.$row->id.'" required>
                            <input type="hidden" class="form-control" name="isr_no" id="isr_no" autocomplete="off" value="'.$row->requestnumber.'" required>
                            <input type="text" class="form-control" name="company" id="company" autocomplete="off"  value="'.$row->companyname.'" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bu">Business Unit</label>
                            <input type="text" class="form-control" name="bu" id="bu" autocomplete="off"  value="'.$bu_name->business_unit.'"  readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="contact">IP Phone No. (if necessary)</label>
                            <input type="text" class="form-control" name="contact" id="contact" autocomplete="off"  value="'.$row->contactno.'" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="text" class="form-control" name="date" id="date" autocomplete="off"  value="'.date("m-d-Y | h:i:s A", strtotime($row->datetoday)).'"  readonly>
                        </div>
                    </div>
                               
                    

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">User Group</label><br>
                            <select style="width: 100%; padding:5px;" class="select-group3 form-control" name="usergroup" id="usergroup" required">
                                ';

                                foreach ($data1 as $value) {
                                    if($value->group_id == $group){
                                        $togroup ='selected';
                                    }else{
                                        $togroup ='';
                                    }
                        echo   '<option value="'.$value->group_id.'" '.$togroup.'>'.$value->groupname.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="type">Type of Request</label><br>
                            <select style="width: 100%; height: resolve; padding:5px;" class="select-type3 form-control" name="isrtype" id="isrtype" required">
                                <option></option>';
                                foreach ($data2 as $value) {
                                    if($value->isr_id == $row->rfstype){
                                        $rfstypes ='selected';
                                    }else{
                                        $rfstypes ='';
                                    }
                        echo   '<option value="'.$value->isr_id.'" '.$rfstypes.'>'.$value->requesttype.'</option>';
                                }
                        echo '</select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="usergroup">Type of System</label><br>
                            <select style="width: 100%; padding:5px;" class="select-system3 form-control" name="systype" id="systype" required">';
                                if($systype == 'NAV'){$systype1 = 'selected';}else{$systype1 = '0';}
                                if($systype == 'IHS'){$systype2 = 'selected';}else{$systype2 = '0';}
                            echo'<option></option>
                                <option value="NAV" '.$systype1.'>NAV</option>
                                <option value="IHS" '.$systype2.'>IHS</option>
                            </select>

                            
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Purpose</label><br>
                            <textarea id="purpose" name="purpose" rows="5" cols="50">';echo $row->purpose; echo' </textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">General Specifications/Explanations</label><br>
                            <textarea  id="generals" name="generals" rows="5" cols="42">';echo $row->generals; echo'</textarea>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purpose">Security Control Specifications</label><br>
                            <textarea id="security" name="security" rows="5" cols="50">';echo $row->security; echo'</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="details">Output Specifications</label><br>
                            <textarea  id="output" name="output" rows="5" cols="42">';echo $row->output; echo'</textarea>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="details">Attachments</label><br>
                        
                        Current File/s:<b style="color:red"> ( ';echo $data5->file; echo' files )</b>&nbsp;&nbsp;&nbsp;
                        <a class="btn btn-default btm-sm" id="view_files2"><i class="fa fa-eye" aria-hidden="true"></i> Show Files</a>
                        <p id="hide_panel" hidden><a class="btn btn-default btm-sm" id="hide_files"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Files</a></p>

                        <div id="files_panel2" hidden>
                        <p style="color: red;"> <b>Note:</b> Click filename to download files or view images (Files will be completely removed once you submit or close the form) </p>
                        <div class="table-responsive" >
                            <table style="padding: none; border-color: white" class="table " id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-dark">
                                    <tr>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
                                    $index = 1; 
                                    foreach($data4 as $m) :
                                echo'<tr> 
                                        <td style="border-top: 0px solid #BEBBBB;" id="file"><a href="http://172.16.161.43/rfstor/uploads/profile-pic/'.$m->file_name.'" target="_blank">
                                        '.$m->file_name.'</td>

                                        <td  style="border-top: 0px solid #BEBBBB;">
                                            <form class="form-inline" id="updatestatus2" method="post">
                                                <input type="hidden" id="file_id_'.$index.'" name="file_id" value="'.$m->file_id.'">
                                                <input type="hidden" id="request_number_'.$index.'" name="request_number" value="'.$m->request_number.'">
                                                <input type="hidden" id="request_type_'.$index.'" name="request_type" value="'.$m->request_type.'">                   
                                                
                                                <a title="Remove File" style="color: #F03649" id="delete_file_rfs" onclick=updatestatusfiles('.$index.')><i class="fa fa-trash fa-lg" aria-hidden="true" ></i></a>
                                            </form>
                                        </td>


                                    </tr>
                                    ';

                                    $index++; 
                                    endforeach;
                            echo'
                                </tbody>
                            </table>
                        </div></div>
                    </div>
                </div> 
                    

                    
                </div>';

                  // <img src="uploads/profile-pic/'.$row->attachments.'" class="img-thumbnail rounded mb-2" alt="Preview available for images only" style="height: 150px; width: 150px;"> <br>  

        ?>
            <script>
                $(".select-type3").select2({
                    // placeholder: "Select a Request Type",
                   selectOnClose: true,
                    allowClear: false
                });

                $(".select-group3").select2({
                    // placeholder: "Select a User Group",
                   selectOnClose: true,
                    allowClear: false
                });

                $(".select-system3").select2({
                    // placeholder: "Select a System Type",
                   selectOnClose: true,
                    allowClear: false
                });

                $(".select-bu3").select2({
                    // placeholder: "Select a Business Unit",
                   selectOnClose: true,
                    allowClear: false
                });
            </script>

            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_files2]").click(function(){
                    $("#files_panel2").fadeIn();
                    $("#view_files2").hide();
                    $("#hide_files2").fadeIn();
                    });
                    $("[id=hide_files]").click(function(){
                    $("#files_panel").hide();
                    });       
                });
            </script>
        <?php        
        }

        public function concernupdate() //passing the data to Admin_model for updating the concern details 
        {
            if(!empty($_POST))
            {
                $request_id = $this->input->post('id');
                $type   = "Concern";
                $request_number = $this->input->post('c_no');
                $companyname = $this->employee_model->find_an_employee4($this->input->post('company2'));
                $data = array(
                    'companyname'       => $companyname->acro,
                    'buid'              => $this->security->xss_clean($this->input->post('bu4')),
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),                  
                    'details'           => $this->security->xss_clean($this->input->post('details'))            
                    //'attachments'       => $attachment
                    
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = '0';
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file8']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info_update($files,$request_number,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while updating file info to Database.');
                    }
                }
                
                $this->Admin_Model->updateRfs($data,$request_id);

                //$action = $this->session->name . ' has updated ' . $type . ' No. ' . $request_number;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . $type . ' No. ' . '<b>'.$request_number.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_number,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);

                $this->session->set_flashdata('SUCCESSMSG1', "success");
                // $this->session->set_userdata($data);
                // echo 'try';
            }
                
            $this->session->set_flashdata('SUCCESSMSG1', "success");
            redirect('view-concern');
        }

        public function reqgroupupdate()
        {
            if (!empty($_POST))
            {
                $request_id = $this->input->post('req_id');
                $group_id = $this->input->post('selectedValue'); // Change this line
                
                $data = array(
                    'togroup' => $this->security->xss_clean($group_id) // Use $group_id here
                );

                $this->Admin_Model->updateRfs($data, $request_id);

                // You might want to handle session flash messages and userdata differently
                $this->session->set_flashdata('SUCCESSMSG1', "success");
                $this->session->set_userdata($data);
                echo 'try';
            }

            // You don't need to set flash messages here again, as it's already done inside the if block
        }

        public function rfsupdate() //passing the data to Admin_model for updating the RFS details 
        {
            if(!empty($_POST))
            {
                $request_id = $this->input->post('id');
                $type   = "RFS";
                $request_number = $this->input->post('rfs_no');
                if($this->input->post('company2') == ""){
                    $company = $this->input->post('company1');
                }else{
                    $companyname = $this->employee_model->find_an_employee4($this->input->post('company2'));
                    $company = $companyname->acro;
                }
                
                $data = array(
                    'companyname'       => $company,
                    'buid'              => $this->security->xss_clean($this->input->post('bu4')),
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),                  
                    // 'requestmode'       => $this->security->xss_clean($this->input->post('requests_mode')),
                    'rfstype'           => $this->security->xss_clean($this->input->post('rfstype')),                 
                    'purpose'           => $this->security->xss_clean($this->input->post('purpose')),
                    'details'           => $this->security->xss_clean($this->input->post('details'))            
                    //'attachments'       => $attachment
                    
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file4']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info_update($files,$request_number,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while updating file info to Database.');
                    }
                }
                
                $this->Admin_Model->updateRfs($data,$request_id);

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . $type . ' No. ' . '<b>'.$request_number.'</b>';
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_number,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);
                $this->session->set_flashdata('SUCCESSMSG1', "success");
                // $this->session->set_userdata($data);
                // echo 'try';
            }
                
            $this->session->set_flashdata('SUCCESSMSG1', "success");
            redirect('view-rfs');
        }

        public function torupdate() //passing the data to Admin_model for updating the TOR details 
        {
            if(!empty($_POST))
            {
                $request_id = $this->input->post('id');
                $request_number = $this->input->post('tor_no');
                $type   = "TOR";
                if($this->input->post('company2') == ""){
                    $company = $this->input->post('company1');
                }else{
                    $companyname = $this->employee_model->find_an_employee4($this->input->post('company2'));
                    $company = $companyname->acro;
                }
                
                $data = array(
                    'companyname'       => $company,
                    'buid'              => $this->security->xss_clean($this->input->post('bu4')),
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),                  
                    'tortypes'          => $this->security->xss_clean($this->input->post('tortype')),                 
                    'purpose'           => $this->security->xss_clean($this->input->post('purpose')),
                    'details'           => $this->security->xss_clean($this->input->post('details'))           
                    //'attachments'       => $attachment
                    
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file5']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info_update($files,$request_number,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while updating file info to Database.');
                    }
                }
                
                $this->Admin_Model->updateTor($data,$request_id);

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . $type . ' No. ' . '<b>'.$request_number.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_number,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);
                $this->session->set_flashdata('SUCCESSMSG1', "success");
                // $this->session->set_userdata($data);
                // echo 'try';
            }
                
            $this->session->set_flashdata('SUCCESSMSG1', "success");
            redirect('view-tor');
        }

        public function isrupdate() //passing the data to Admin_model for updating the ISR details 
        {
            if(!empty($_POST))
            {
                $request_id = $this->input->post('id');
                $request_number = $this->input->post('isr_no');
                $type   = "ISR";
                $data = array(
                    
                    'contactno'         => $this->security->xss_clean($this->input->post('contact')),
                    'togroup'           => $this->security->xss_clean($this->input->post('usergroup')),                  
                    'rfstype'           => $this->security->xss_clean($this->input->post('isrtype')),
                    'typeofsystem'      => $this->security->xss_clean($this->input->post('systype')),              
                    'purpose'           => $this->security->xss_clean($this->input->post('purpose')),
                    'generals'          => $this->security->xss_clean($this->input->post('generals')),
                    'security'          => $this->security->xss_clean($this->input->post('security')),
                    'output'            => $this->security->xss_clean($this->input->post('output'))           
                    //'attachments'       => $attachment
                    
                );

                $config['upload_path'] = './uploads/profile-pic/';
                $config['allowed_types'] = '*';
                $config['max_size'] = 20971520;
                $config['max_filename'] = '255';
                $config['encrypt_name'] = FALSE;

                //upload file
                $i = 0;
                $files = array();
                $is_file_error = FALSE;

                if ($_FILES['upload_file6']['size'] <= 0) {
                    $this->handle_error('Select at least one file.');
                } else {
                    foreach ($_FILES as $key => $value) {
                        if (!empty($value['name'])) {
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload($key)) {
                                $this->handle_error($this->upload->display_errors());
                                $is_file_error = TRUE;
                            } else {
                                $files[$i] = $this->upload->data();
                                ++$i;
                            }
                        }
                    }
                }

                // There were errors, you have to delete the uploaded files
                if ($is_file_error && $files) {
                    for ($i = 0; $i < count($files); $i++) {
                        $file = $dir_path . $files[$i]['file_name'];
                        if (file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

                if (!$is_file_error && $files) {
                    $resp = $this->file->save_files_info_update($files,$request_number,$type);
                    if ($resp === TRUE) {
                        $this->handle_success('File(s) was/were successfully uploaded.');
                    } else {
                        for ($i = 0; $i < count($files); $i++) {
                            $file = $dir_path . $files[$i]['file_name'];
                            if (file_exists($file)) {
                                unlink($file);
                            }
                        }
                        $this->handle_error('Error while updating file info to Database.');
                    }
                }
                
                $this->Admin_Model->updateIsr($data,$request_id);

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'updated ' . '</b>' . $type . ' No. ' . '<b>'.$request_number.'</b>';

                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_number,
                        'rtype'    => $type
                    );
                $this->Admin_Model->addLogs($data1);
                $this->session->set_flashdata('SUCCESSMSG1', "success");
                // $this->session->set_userdata($data);
                // echo 'try';
            }
                
            $this->session->set_flashdata('SUCCESSMSG1', "success");
            redirect('view-isr');
        }

        
        public function UpdateStatusFiles() //passing the data to Admin_model for updating the attachment status 
        {
            if(!empty($_POST))
            {
                $requestnumber  = $this->input->post('uid');
                $rtype          = $this->input->post('type');
                $file_id        = $this->input->post('file_id');
                $data = array(
                    'status'         => 'Inactive'
                );
                
                $this->Admin_Model->updateStatusFilesRfs($data,$requestnumber,$rtype,$file_id);   
            }              
        }

        public function UpdateStatusRequest() //called when the user cancels a request
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
          
            if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
                $reqdate = date("Y-m-d H:i:s");
                $requestnumber  = $this->input->post('id');
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                
                $data = array(
                    'date_cancelled'     => $reqdate,
                    'status'         => 'Cancelled',
                    'cancelledby'     => $userid

                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']);   

                //$action = $this->session->name . ' has cancelled ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'cancelled ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $request_data->typeofrequest
                    );
                $this->Admin_Model->addLogs($data1);
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }

        public function AcknowledgeStatusConcern() //called when the user acknowledge an executed concern request
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
           // $lname = $this->session->userdata['lname'];
            $c = $fname;
            
            if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
                $reqdate = date("Y-m-d H:i:s");
                $requestnumber  = $this->input->post('id');
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                $data = array(
                    
                    'isacknowledge'   =>'YES'
                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']);  

                //$action = $this->session->name . ' has acknowledged ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'acknowledged ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $request_data->typeofrequest
                    );
                $this->Admin_Model->addLogs($data1);

            } 
                   
        }

        public function RecallStatusRequest() //called when the user recalls a cancelled request
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
          
            if(!empty($_POST))
            {
                $requestnumber  = $this->input->post('id');
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                $data = array(
                    'status'         => 'Pending',
                    'cancelledby'     => 0,
                    'date_cancelled'  => ''

                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']);   

                //$action = $this->session->name . ' has recalled ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'recalled ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';
                    $data1 = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'     => 'Request',
                        'request_id' => $request_data->requestnumber,
                        'rtype'    => $request_data->typeofrequest
                    );
                $this->Admin_Model->addLogs($data1);
            } 
            //$this->session->set_flashdata('SUCCESSMSG','success');
            // redirect('view-rfs');           
        }
        
        
	}
?>
