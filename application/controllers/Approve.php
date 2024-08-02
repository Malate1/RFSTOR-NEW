<?php
    class Approve extends CI_Controller {

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
            

        }

        public function request_list() //the details of the requests list table for Approve users
        {
            $payload = $this->input->post(NULL,TRUE);
            // print_r($payload);
            //$requests = $this->Admin_Model->getRequestbyUsertype($payload);
            $requests = $this->execute_model->get_requests($payload);
            $data = [];
            foreach ($requests as $req) {
              
                $bu = $this->Admin_Model->bu_name($req->buid);
                $approvedetails = $this->Admin_Model->getUserData2($req->approvedby);
                //$executedby = $this->employee_model->find_an_employee(@$executedetails->emp_id);
                
                $canceldetails = $this->Admin_Model->getUserData2($req->cancelledby);
                //$cancelledby = $this->employee_model->find_an_employee(@$canceldetails->emp_id);

                $requestedby = $this->Admin_Model->getUserData2($req->userid);

                $sub_array = [];

                // $sub_array[] = '';
                $sub_array[] = '<span style="color: red; align: center; font-weight: bold">'.$req->requestnumber.'</span>';
                // if($req->approvedby != '0'){
                //     $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_approved));
                // }elseif($req->cancelledby != '0'){
                //     $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->date_cancelled));
                // }else{}
                    $sub_array[] = date("D • h:i:s A • M. d, Y ",strtotime($req->datetoday));
                
                
                $sub_array[] = $req->groupname;
                $sub_array[] = $req->companyname;
                $sub_array[] = $bu->business_unit;
                $sub_array[] = $requestedby->name;
                $sub_array[] = $req->purpose;
                
                $stat1="";

                if($req->approvedby != '0'){
                    $stat1 .= $approvedetails->name;        
                }
                elseif($req->reqstatus == 'Cancelled') {
                    $stat1 .= $canceldetails->name;
                }

                elseif($req->reqstatus == 'Cancelled' AND $req->approvedby != '0') {
                    $stat1 .= $canceldetails->name;
                }
                else{
                   $stat1 .= '<span style="color: orange;  align: center";><i class="fa fa-question-circle fa-lg" aria-hidden="true" ></i></span>';
                }

                $sub_array[] = $stat1;

                $stat = "";
                
                if($req->approvedby == '0' AND $req->cancelledby == '0'){
                    $stat .= '<span class="label label-warning">Pending</span></td>';
                }elseif ($req->reqstatus == 'Cancelled') {
                    $stat .= '<span class="label label-danger">'.$req->reqstatus.'</span></td>';
                }elseif ($req->reqstatus == 'Cancelled' AND $req->approvedby != '0') {
                    $stat .= '<span class="label label-danger">'.$req->reqstatus.'</span></td>';
                }
                else{
                   $stat .='<span class="label label-success">Approved</span></td>';
                }    

                $sub_array[] = $stat;

                
                
                    $tor = "";
                    $isr = "";
                    $rfs = "";
                    $taskid1 = 2;
                    $taskid2 = 3;
                    if(strtoupper($payload['typeofrequest']) == 'RFS'){
                    $rfs .= '
                        <a id="RFS-'.$req->reqid.'" title="View Details RFS" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveRfsModal" onclick=approverfs_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                       
                        if($req->approvedby == '0' AND $req->cancelledby == '0'){

                            if($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby != '0' AND $req->userid != $this->session->user_id){

                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($req->userid == $this->session->user_id)
                            {
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvevalid() <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }
                            else{
                                $rfs .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }

                            if ($req->userid != $this->session->user_id){
                                $rfs .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }else{
                                $rfs .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovevalid() <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }   
                        }
                        
                        if ($req->remarks == '') {
                            $rfs .= '
                                <a id="rem1-'.$req->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$req->reqid.')><i class="fa fa-comment-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $rfs .= '
                                <a id="rem2-'.$req->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->cancelledby != '0'){
                            $rfs .= '
                                <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->approvedby != '0' AND $req->cancelledby == '0'){
                            $rfs .= '
                                <a  title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestA('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        $rfs .= '
                            <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModal" onclick=approved_view_rfs('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>';
                        $sub_array[] = $rfs;

                    }elseif (strtoupper($payload['typeofrequest']) == 'TOR') {
                    $tor.= '
                        <a id="TOR-'.$req->reqid.'" title="View Details TOR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveTorModal" onclick=approvetor_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';

                        if($req->approvedby == '0' AND $req->cancelledby == '0'){

                            if($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby != '0' AND $req->userid != $this->session->user_id){

                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($req->userid == $this->session->user_id)
                            {
                                $tor .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvevalid() <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }
                            else{
                                $tor.= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }

                            if ($req->userid != $this->session->user_id){
                                $tor .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }else{
                                $tor .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovevalid() <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }   

                        // $tor.= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        if ($req->remarks == '') {
                            $tor .= '
                                <a id="rem1-'.$req->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$req->reqid.')><i class="fa fa-comment-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $tor .= '
                                <a id="rem2-'.$req->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->cancelledby != '0'){
                            $tor.= '
                                <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        if ($req->approvedby != '0' AND $req->cancelledby == '0'){
                            $tor.= '
                                <a  title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestA('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        $tor.= '
                            <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalTor" onclick=approved_view_tor('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';
                        $sub_array[] = $tor;

                    }elseif (strtoupper($payload['typeofrequest']) == 'ISR') {
                    $isr .= '
                        <a id="ISR-'.$req->reqid.'" title="View Details ISR" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#ApproveIsrModal" onclick=approveisr_content('.$req->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';

                        if($req->approvedby == '0' AND $req->cancelledby == '0'){

                            if($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby != '0' AND $req->userid != $this->session->user_id){

                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->reviewedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == true AND $req->executedby != '0' AND $req->verifiedby == '0' AND $req->userid != $this->session->user_id) 
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid1,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($this->Admin_Model->getTypeBuTask($req->buid,$taskid2,strtoupper($payload['typeofrequest'])) == false AND $req->executedby != '0' AND $req->userid != $this->session->user_id) 
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=completestatusrequestA('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }elseif ($req->userid == $this->session->user_id)
                            {
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvevalid() <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }
                            else{
                                $isr .= '<a  title="Approve Request" style="color: #3c8dbc; cursor: pointer"  onclick=approvestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }if ($req->userid != $this->session->user_id){
                                $isr .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            }else{
                                $isr .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovevalid() <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                            } 

                        // $isr .= '<a  title="Disapprove Request" style="color: #f54254; cursor: pointer"  onclick=disapprovestatusrequest('.$req->reqid.') <i class="fa fa-thumbs-o-down fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        if ($req->remarks == '') {
                            $isr .= '
                                <a id="rem1-'.$req->reqid.'" title="Add Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$req->reqid.')><i class="fa fa-comment-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }else{
                            $isr .= '
                                <a id="rem2-'.$req->reqid.'" title="Edit Remarks" style="color: #3c8dbc; cursor: pointer"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$req->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }

                        if ($req->cancelledby != '0'){
                            $isr .= '
                                <a  title="Recall Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequest('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        if ($req->approvedby != '0' AND $req->cancelledby == '0'){
                            $isr .= '
                                <a  title="Disregard Request" style="color: #3c8dbc; cursor: pointer"  onclick=recallstatusrequestA('.$req->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                        }
                        $isr .= '
                            <a title="Request Status" style="color: orange; cursor: pointer"  data-toggle="modal" data-target="#showApprovedModalIsr" onclick=approved_view_isr('.$req->reqid.')><i class="fa fa-eye fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';
                        $sub_array[] = $isr;
                    }
                $data[] = $sub_array;
            }

            $output = array(  
                "draw"                      =>     intval($_POST["draw"]),  
                "recordsTotal"              =>     $this->execute_model->get_all_data(),  
                "recordsFiltered"           =>     $this->execute_model->get_filtered_data($payload),  
                "data"                      =>     $data  
            );

           echo json_encode($output); 

            //echo json_encode(['data' => $data]);
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

            $data['page_title'] = 'Approve';
            $this->load->view('templates/header', $data); // loads the header.php in views
        }

        // for approve
        public function PendingStatusRfs()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'RFS'; // initiated the request type to RFS
            $data['status'] = 'Pending';
            
            $this->ViewHeader(); // loads the header filtered by usertype
            $this->load->view('Admin/Approve_view',$data); // loads the Approve_view.php in views
        }

        public function PendingStatusTor()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'TOR'; // initiated the request type to TOR
            $data['status'] = 'Pending';
            
            $this->ViewHeader(); // loads the header filtered by usertype   
            $this->load->view('Admin/Approve_view',$data); // loads the Approve_view.php in views
        }

        public function PendingStatusIsr()
        {
            $data['getUsertypes'] = $this->db->get('usertype')->result_array(); // extracts the user type of the currently logged in user
            $data['type'] = 'ISR'; // initiated the request type to ISR
            $data['status'] = 'Pending';
            
            $this->ViewHeader(); // loads the header filtered by usertype   
            $this->load->view('Admin/Approve_view',$data); // loads the Approve_view.php in views
        }

        //called when user disregards the request
        public function RecallStatusRequestA()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
          
            if(!empty($_POST))
            {
                $requestid  = $this->input->post('id');
                
                
                
                $data = array(
                    'status'         => 'Pending',
                    'approvedby'     => 0

                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']); 
                  
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                //$action = $this->session->name . ' has disregarded ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'disregarded ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

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

        //called when user approves the requests
        public function ApproveStatusRequest()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
            
            
            if(!empty($_POST))
            {
                $requestnumber  = $this->input->post('id');
                date_default_timezone_set("Asia/Manila");
                $reqdate = date("Y-m-d H:i:s");
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                $data = array(
                    'date_approved'     => $reqdate,
                    'approvedby'     => $userid
                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']);

                //$action = $this->session->name . ' has approved ' . $request_data->typeofrequest . ' No. ' . $request_data->requestnumber;
                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'approved ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';
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

        //called when the request is already executed and verified/reviewed 
        public function CompleteStatusRequestA()
        {
            $userid = $this->session->userdata['user_id'];
            $fname = $this->session->userdata['name'];
           // $lname = $this->session->userdata['lname'];
            $c = $fname;
            
            if(!empty($_POST))
            {
                date_default_timezone_set("Asia/Manila");
                //$reqdate = date("Y-m-d h:i:s A");
                $reqdate = date("Y-m-d H:i:s");
                $requestnumber  = $this->input->post('id');
                $request_data   = $this->request_model->get_requests_data($_POST['id']);
                $data = array(
                    
                    'date_approved'     => $reqdate,
                    'approvedby'     => $userid,
                    'status'        =>'Approved'
                );
               
                $this->Admin_Model->UpdateStatusRequest($data,$_POST['id']);  

                $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'approved ' . '</b>' . $request_data->typeofrequest . ' No. ' . '<b>'.$request_data->requestnumber.'</b>';

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
    }
?>