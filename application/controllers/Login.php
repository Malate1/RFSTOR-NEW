<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        			
        $this->load->model('Loginmodel','LoginModel');
        $this->load->model('employee_model');
        $this->load->model('Admin_model');
        $this->load->model('user_model', 'usermodel');
        
    } 

    public function index()
    {
        if($this->session->username != "")
        {
            redirect('profile');
        }	
        $this->load->view('Admin/loginAdmin');
    }

    public function logAdmin()
    {
        if(!empty($_POST))
        {
            $uname = $this->security->xss_clean($this->input->post('username'));
            //$password = $this->input->post('password');
            $password = $this->security->xss_clean(md5($this->input->post('password')));
            $override = $this->security->xss_clean(md5('or'));
            $result = $this->LoginModel->loginAdmin($uname,$password,$override);

            if($result -> num_rows() > 0){
            //if (password_verify($password, $result->row()->password)) {
                $users = $this->employee_model->find_an_employee2($result->row()->emp_id);
                foreach ($users as $user) {
                    $userdetails = $this->usermodel->getuserDetails($user->emp_id);
                    $profile = $this->employee_model->find_employee_name($user->emp_id);

                    if($profile == '' || $user->emp_id == '03845-2015'){
                        $str = $userdetails->profile_pic;
                    }else{
                        $str = ltrim($profile->photo, '.');
                    }

                    $bday = date("m-d",strtotime($profile->birthdate));
                    $cc = $this->employee_model->company_name($user->company_code);
                    $bu = $this->employee_model->bu_name($user->bunit_code,$user->company_code);
                    $dept = $this->employee_model->dept_name($user->bunit_code, $user->company_code, $user->dept_code);
                    $sect = $this->employee_model->sect_name($user->bunit_code, $user->company_code, $user->dept_code, $user->section_code);
                    // $profile = $this->employee_model->find_employee_photo($user->emp_id);
                    @$id = @$user->user_id;
                    $loc = 'Bohol';

                    $this->session->user_id     =  $userdetails->user_id;
                    $this->session->emp_id      =  $user->emp_id;
                    $this->session->username    =  $userdetails->username;
                    $this->session->name        =  $user->name;
                    $this->session->fname       =  $profile->firstname;
                    $this->session->status      =  $userdetails->status;
                    $this->session->superadmin  =  $userdetails->superadmin;
                    $this->session->profile_pic =  $str;
                    $this->session->position    =  $user->position;
                    $this->session->location    =  $loc;
                    $this->session->cc          =  $cc;
                    $this->session->bu          =  $bu;
                    $this->session->dept        =  $dept; 
                    $this->session->sect        =  $sect;
                    $this->session->bday        =  $bday;

                    if ($this->session->status == "0") {
                        $this->session->set_flashdata('errormsg1','This account is deactivated');
                        $this->load->view('Admin/loginAdmin');
                    }
                    else{
                        echo ('success');
                        $this->session->set_flashdata('SUCCESSMSG','success');

                        $act = 'logged in';
                        $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'logged in'. '</b>';

                        $data = array(
                            'user_id'   => $this->session->user_id,
                            'action'   => $action,
                            'type'  => 'Setup'
                        );
                        $this->Admin_model->addLogs($data);
                        redirect('profile');
                    }
                }

            }
            else
            {
                $data['username'] = $uname;
                $data['password'] = $password;
                $this->session->set_flashdata('errormsg','Username and Password is Wrong');
                $this->load->view('Admin/loginAdmin',$data);
            }
        }
        else
        {
            $this->load->view('Admin/loginAdmin');
        }
    }

    public function logCebu()
    {
      if(!empty($_POST))
      {
        $uname = $this->security->xss_clean($this->input->post('username'));
            //$password = $this->input->post('password');
            $password = $this->security->xss_clean(md5($this->input->post('password')));
            $result = $this->LoginModel->loginAdmin2($uname,$password);

        if($result -> num_rows() > 0 )
        {
            foreach ($result->result() as $row)
            {
                $cc = '07';
                $loc = 'Cebu';
                $this->session->user_id     = $row->user_id;
                $this->session->name        =  $row->name;
                $this->session->username    =  $row->username;
                $this->session->emp_id      =  $row->emp_id;
                $this->session->status      =  $row->status;
                $this->session->location    =  $loc;
                $this->session->profile_pic =  $row->profile_pic;
                $this->session->cc        =  $cc;

                

                if ($this->session->status == "0") {
                        $this->session->set_flashdata('errormsg1','This account is deactivated');
                        $this->load->view('Admin/loginCebu');
                }
                else{
                    echo ('success');
                    $this->session->set_flashdata('SUCCESSMSG','success');

                    $act = 'logged in';
                    $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'logged in'. '</b>';

                    $data = array(
                        'user_id'   => $this->session->user_id,
                        'action'   => $action,
                        'type'  => 'Setup'
                    );
                    $this->Admin_model->addLogs($data);
                    redirect('profile');
                }
            }
        }
        else
        {
            $data['username'] = $uname;
            $data['password'] = $password;
            $this->session->set_flashdata('errormsg','Username and Password is Wrong');
            $this->load->view('Admin/loginCebu',$data);
        }
    }
    else
    {
       $this->load->view('Admin/loginCebu');
   }
}

    public function logoutAdmin()
    {
        if($this->session->user_id == "")
        {

            redirect('login-a');
            //$this->session->set_flashdata('errormsg2','Session Expired');
        }else{
           $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'logged out'. '</b>';
        
            $data = array(
                'user_id'   => $this->session->user_id,
                'action'   => $action,
                'type'  => 'Setup'
            );
            $this->Admin_model->addLogs($data);
            $this->session->set_flashdata('SUCCESSMSG','You have successfully logged out');
            $this->session->sess_destroy();
            redirect('login-a'); 
            // var_dump()
        }    
        
    }

    public function logoutCebu()
    {
        
        $action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'logged out'. '</b>';
        
        $data = array(
            'user_id'   => $this->session->user_id,
            'action'   => $action,
            'type'  => 'Setup'
        );
        $this->Admin_model->addLogs($data);
        $this->session->set_flashdata('SUCCESSMSG','You have successfully logged out');
        $this->session->sess_destroy();
        redirect('login-a');
    }
}
