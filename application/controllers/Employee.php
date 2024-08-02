<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {

	function __construct()
    {
        parent::__construct();				
        $this->load->model('employee_model');
        if($this->session->username == "")
		{
			redirect('login');
		}
		$this->load->model('admin_model','Admin_Model');
		$this->load->model('user_model', 'usermodel');
    } 

    // public function search() {

	// 	$search = $this->input->get('query', TRUE);
    //     $employees = $this->employee_model->find_employee($search);
    //     $add = '&#x2705;';
    //     $str = html_entity_decode($add);
    //     $data = [];
    //     foreach ($employees as $employee) {
    //     	if($this->Admin_Model->checkUser2($employee->emp_id) == true)
    //     	{
    //         	$data[] = "{$employee->emp_id} = {$employee->name} = {$employee->emp_no} = {$str}";
    //     	}else{
    //     		$data[] = "{$employee->emp_id} = {$employee->name} = {$employee->emp_no} ";
    //     	}
    //     }
    //     echo json_encode($data);
	// }


    public function search() {
	    $search = $this->input->get('query', TRUE);
	    $employees = $this->employee_model->find_employee($search);
	    $add = '&#x2705;';
	    $str = html_entity_decode($add);
	    $data = [];

	    foreach ($employees as $employee) {
	        if ($this->Admin_Model->checkUser2($employee->emp_id)) {
	            $data[] = [
	                'id' => $employee->emp_id,
	                'name' => $employee->name,
	                'emp_no' => $employee->emp_no,
	                'check' => $str,
	                'hasCheck' => true,
	            ];
	        } else {
	            $data[] = [
	                'id' => $employee->emp_id,
	                'name' => $employee->name,
	                'emp_no' => $employee->emp_no,
	                'hasCheck' => false,
	            ];
	        }
	    }

	    echo json_encode($data);
	}

	public function search_incharge() 
    {
        $search = $this->input->get('query', TRUE);
        $employees = $this->employee_model->find_employee($search);
        $data = [];
    
        foreach ($employees as $employee) {
            $data[] = [
                'emp_id' => $employee->emp_id,
                'name' => $employee->name,
            ];
        }
        echo json_encode($data);
    } 


	public function view(){
		$employees = $this->employee_model->get_employee();

		var_dump($employees);
	}

	public function store() //passing data to model for adding user details
	{
		$data = $this->input->post(NULL, TRUE);
		// print_r($data);
		if($this->Admin_Model->checkUser2($this->input->post('emp_id')) == true)
        {
 			echo 'User-exists';
 			return false;
			// echo 'try';
        }else{
		// insert user info
			$user_id = $this->Admin_Model->store_user();

			// insert user group
			foreach ($data['tasks'] as $task) {
				
				$this->Admin_Model->store_task_role($user_id, $task);
			}

			// insert user groups
			foreach ($data['groups'] as $group) {
				
				$this->Admin_Model->store_user_group($user_id, $group);
			}

			$this->Admin_Model->store_bu($user_id);
			echo 'ok';
			//$action = $this->session->name . ' has added a new user ' ;
			$action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added'. '</b>' . ' a new user';

                $data1 = array(
                    'user_id'   => $this->session->user_id,
                    'action'   => $action,
                    'type'     => 'Setup'
                );
            $this->Admin_Model->addLogs($data1);
			return false;

               
		}
		// echo json_encode(['status' => 200, 'message' => 'User successfully added.']);
	}

	public function autoDeactivateResigned() {
        // Perform the cancellation logic
        $this->employee_model->autoDeactivateResigned();
        // You can also pass any necessary data or parameters to the model method if required

        // Return a response (optional)
        $response = array('status' => 'success', 'message' => 'Success.');
        echo json_encode($response);
    }

    public function autoUpdateName() {
        // Perform the cancellation logic
        $this->employee_model->autoUpdateName();
        // You can also pass any necessary data or parameters to the model method if required

        // Return a response (optional)
        $response = array('status' => 'success', 'message' => 'Success.');
        echo json_encode($response);
    }

	public function store_cebu() //passing data to model for adding user details
	{
		$data = $this->input->post(NULL, TRUE);
		// print_r($data);
		if($this->Admin_Model->checkUser2($this->input->post('emp_id')) == true)
        {
 			echo 'User-exists';
 			return false;
			// echo 'try';
        }else{
		// insert user info
			$user_id = $this->Admin_Model->store_user_cebu();

			// insert user group
			foreach ($data['tasks'] as $task) {
				
				$this->Admin_Model->store_task_role($user_id, $task);
			}

			// insert user groups
			foreach ($data['groups'] as $group) {
				
				$this->Admin_Model->store_user_group($user_id, $group);
			}

			$this->Admin_Model->store_bu_cebu($user_id);
			echo 'ok';
			//$action = $this->session->name . ' has added a new user ' ;
			$action = '<b>'. $this->session->name . '</b>' . ' has ' . '<b>' .'added'. '</b>' . $user_id . ' user no.';

                $data1 = array(
                    'user_id'   => $this->session->user_id,
                    'action'   => $action,
                    'type'     => 'Setup'
                );
            $this->Admin_Model->addLogs($data1);
			return false;

               
		}
		// echo json_encode(['status' => 200, 'message' => 'User successfully added.']);
	}

	public function user_list() //displays the list of users in the table for Admin users
	{
		$payload = $this->input->post(NULL,TRUE);
		$users = $this->employee_model->get_users($payload);
		//$fetch_data = $this->blacklist_model->get_blacklist();
		$data = [];

		foreach ($users as $user) {
			$userdetails = $this->employee_model->find_an_employee($user->emp_id);
			$cc = $this->employee_model->company_name($userdetails->company_code);
			$bu = $this->employee_model->bu_name($userdetails->bunit_code, $userdetails->company_code);
			$dept = $this->employee_model->dept_name($userdetails->bunit_code, $userdetails->company_code, $userdetails->dept_code);
			$sect = $this->employee_model->sect_name($userdetails->bunit_code, $userdetails->company_code, $userdetails->dept_code, $userdetails->section_code);
			$id = $user->user_id;

			$sub_array = [];
			
			$sub_array[] = '<a id="edit3-'.$id.'" class="action" style="color: inherit; cursor: pointer;">'.$user->name.'</a>';
			$sub_array[] = $user->username;
			$sub_array[] = @$userdetails->position;
			$sub_array[] = @$user->company;
			$sub_array[] = @$bu->business_unit;
			$sub_array[] = @$dept->dept_name;
			$sub_array[] = @$sect->section_name;
			$sub_array[] = ($user->ustatus == '1') ? 
			'<label class="switch">
			  	<input type="checkbox" onclick=deactivateuserstatus("'.$id.'") checked >
				<span class="slider round"></span>
			</label>' : 
			'<label class="switch">
			  	<input type="checkbox" onclick=activateuserstatus("'.$id.'")>
			  	<span class="slider round"></span>
			</label>';

			// $stat = "";
                
            //     if($user->ustatus == '1'){
            //         $stat .= '<input type="checkbox" onclick=deactivateuserstatus("'.$id.'") checked >
			// 				<span class="slider round"></span>';
            //     }elseif ($userdetails->current_status != 'Active') {
            //         $stat .= '<input type="checkbox" disabled>
			//   					<span class="slider round"></span>';
            //     }
            //     else{
            //        $stat .='<input type="checkbox" onclick=activateuserstatus("'.$id.'")>
			//   				<span class="slider round"></span>';
            //     }    

            // $sub_array[] = $stat;


			$sub_array[] = ($user->ustatus == '1' || $this->session->user_id == 1) ?
						'<a id="edit-'.$id.'" class="action" title="Modify User" style="color: orange; cursor: pointer"><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                        <a id="edit2-'.$id.'" class="action" title="Modify User" style="color: orange; cursor: pointer" ><i class="fa fa-cog fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;
                        	|| &nbsp;

                        <a title="Reset Password" style="color: orange; cursor: pointer" onclick=resetpassword("'.$id.'") <i class="fa fa-refresh fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; '
                        :

                        '<a id="edit-'.$id.'" class="action" title="Modify User" style="color: #ccc; pointer-events: none;"><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                        <a id="edit3-'.$id.'" class="action" title="Modify User" style="color: #ccc; pointer-events: none;" ><i class="fa fa-cog fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;
                        	|| &nbsp;

                        <a title="Reset Password" style="color: #ccc; pointer-events: none;" onclick=resetpassword("'.$id.'") <i class="fa fa-refresh fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; ';
			$data[] = $sub_array;
		}

		$output = array(  
            "draw"                      =>     intval($_POST["draw"]),  
            "recordsTotal"              =>     $this->employee_model->get_all_data(),  
            "recordsFiltered"           =>     $this->employee_model->get_filtered_data($payload),  
            "data"                      =>     $data  
        );  
       echo json_encode($output); 

		// echo json_encode(['data' => $data]); '<a id="edit2-'.$id.'" class="action" style="color: inherit">'.$user->name.'</a>';
	}

	public function user_list_cebu() //displays the list of users in the table for Admin users
	{

		$payload = $this->input->post(NULL,TRUE);
		$users = $this->employee_model->get_users2($payload);
		//$fetch_data = $this->blacklist_model->get_blacklist();
		$data = [];

		foreach ($users as $user) {
			// $userdetails = $this->employee_model->find_an_employee($user->emp_id);
			// $cc = $this->employee_model->company_name($userdetails->company_code);
			// $bu = $this->employee_model->bu_name($userdetails->bunit_code, $userdetails->company_code);
			// $dept = $this->employee_model->dept_name($userdetails->bunit_code, $userdetails->company_code, $userdetails->dept_code);
			// $sect = $this->employee_model->sect_name($userdetails->bunit_code, $userdetails->company_code, $userdetails->dept_code, $userdetails->section_code);
			$id = $user->user_id;

			$sub_array = [];
			
			$sub_array[] = '<a href="javascript:void(0);" id="edit3-'.$id.'" class="action" style="color: inherit">'.$user->name.'</a>';
			$sub_array[] = $user->username;
			// $sub_array[] = @$userdetails->position;
			// $sub_array[] = @$user->company;
			// $sub_array[] = @$user->business_unit;
			// $sub_array[] = @$dept->dept_name;
			// $sub_array[] = @$sect->section_name;
			$sub_array[] = ($user->ustatus == '1') ? 
			'<label class="switch">
			  	<input type="checkbox" onclick=deactivateuserstatus("'.$id.'") checked >
				<span class="slider round"></span>
			</label>' : 
			'<label class="switch">
			  	<input type="checkbox" onclick=activateuserstatus("'.$id.'")>
			  	<span class="slider round"></span>
			</label>';
			$sub_array[] = '
						<a id="edit-'.$id.'" class="action" title="Modify User" style="color: orange; cursor: pointer"><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                        <a id="edit2-'.$id.'" class="action" title="Modify User" style="color: orange; cursor: pointer" ><i class="fa fa-cog fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;
                        	|| &nbsp;

                        <a title="Reset Password" style="color: orange; cursor: pointer" onclick=resetpassword("'.$id.'") <i class="fa fa-refresh fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;
                        ';
			$data[] = $sub_array;
		}

		$output = array(  
            "draw"                      =>     intval($_POST["draw"]),  
            "recordsTotal"              =>     $this->employee_model->get_all_data(),  
            "recordsFiltered"           =>     $this->employee_model->get_filtered_data2($payload),  
            "data"                      =>     $data  
        );  
       echo json_encode($output); 

		// echo json_encode(['data' => $data]); '<a id="edit2-'.$id.'" class="action" style="color: inherit">'.$user->name.'</a>';
	}
	
}