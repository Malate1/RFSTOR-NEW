<?php 

	if($request == 'add-user-form') {
		?>
			<div class="alert alert-danger" id="msg" role="alert" style="display: none">Ayaw Kol!</div>

			<div class ="row">

            	<div class="col-md-3">
            		<?php 

            			@$profile = $this->employee_model->find_employee_name($emp->emp_id);
            			@$profile2 = $this->employee_model->find_employee_exp($emp->emp_id);

            			//@$profile2 = $this->employee_model->find_an_employee7($emp->emp_id);

            			@$inputteddob = date("Y-m-d",strtotime($profile->birthdate));

            			@$inputteddob1 = date("Y-m",strtotime($profile2->date_hired));
            			//@$inputtedstart = date("Y-m-d",strtotime($profile2->date_hired));

						// Get the current date
						$currentDate = new DateTime();

						// Create a DateTime object for the inputted DOB
						$DOB = new DateTime($inputteddob);
						$DOB1 = new DateTime($inputteddob1);
						//$EXP = new DateTime($inputtedstart);
						// Calculate the difference between the current date and the DOB
						$age = $currentDate->diff($DOB)->y;
						//$exp = $currentDate->diff($DOB1)->y;

						$interval = $currentDate->diff($DOB1);

				        $years = $interval->y;
						$months = $interval->m;
						$DOB1Formatted = $DOB1->format('Y-m-d H:i:s.u');

						if ($DOB1Formatted == '1970-01-01 00:00:00.000000') {
						    $year1 = '0';
						    $month1 = '0';
						} else {
						    $year1 = $years;
						    $month1 = $months;
						}
				        

				        //var_dump($DOB1);
						//$exp = $currentDate->diff($EXP)->y;
	                    if(@$profile == ''){
	                        @$str = $emp->profile_pic;
	                    }else{
	                        @$str = ltrim($profile->photo, '.');
	                    }
                        
                        echo'<div class="form-group">
                                <img src="http://172.16.161.34:8080/hrms'.$str.'" class="img-thumbnail rounded mb-2" alt="User Image" style="height: 200px; width: 200px;">

                            </div> 
                            ';
                        

                    ?>
                </div>
                <?php if($this->session->superadmin == "Yes"){ ?>
	                <div class="col-md-5">
		                <div style="height: 200px;">
		                	
		                	
		                	<table style="padding: 15px;">
						
							  <tr>
							    <td style="font-weight: bold;">Age:</td>
							    <td style="padding-left: 10px"><?php echo $age?></td>
							    
							  </tr>
							  <tr>
							    <td style="font-weight: bold;">Date of Birth:</td>
							    <td style="padding-left: 10px"><?php echo date("M. d, Y",strtotime(@$profile->birthdate)) ?></td>
							    
							  </tr>

							 <tr>
							    <td style="font-weight: bold;">Address:</td>
							    <td style="padding-left: 10px"><?php echo @$profile->home_address ?></td>
							    
							  </tr>

							  <tr>
							    <td style="font-weight: bold;">Civil Status:</td>
							    <td style="padding-left: 10px"><?php echo @$profile->civilstatus ?></td>
							    
							  </tr>

							  <tr>
							    <td style="font-weight: bold;">School:</td>
							    <td style="padding-left: 10px"><?php echo @$profile->school ?></td>
							    
							  </tr>

							  <tr>
							    <td style="font-weight: bold;">Course:</td>
							    <td style="padding-left: 10px"><?php echo @$profile->course ?></td>
							    
							  </tr>

							  <tr>
							    <td style="font-weight: bold;">Start Date:</td>
							    <td style="padding-left: 10px"><?php echo date("M. d, Y",strtotime(@$profile2->date_hired)) ?></td>
							    
							  </tr>

							  <tr>
							    <td style="font-weight: bold;">Years Experience:</td>
							    <td style="padding-left: 10px"><?php echo @$year1 ?>&nbsp; year(s) & <?php echo @$month1 ?>&nbsp; month(s)</td>
							    
							  </tr>
							</table>
		                </div>
		            </div>

		            <div class="col-md-4">
		                <div>
		                	
		                	
		                	<table style="padding: 15px;">
						
							<tr>
							    
							    <!-- <td style="padding-left: 10px"><?php echo @$profile->home_address ?></td> -->
							    <td >
						        <iframe
						            width="250"
						            height="200"
						            frameborder="0"
						            style="border:0"
						            src="https://www.google.com/maps/embed/v1/place?q=<?php echo urlencode(@$profile->home_address); ?>&key=AIzaSyCHYkil-wqTshtbxYcqr3EbDUh5CLk0PTk"
						            allowfullscreen
						        ></iframe>
						    	</td>
							    
							</tr>

							  
							</table>
		                </div>
		            </div>
	            <?php } ?>
        	</div>
        	<br>
            <div class ="row">
        		<div class="col-md-6">      
            		<div class="form-group">
	                    <label for="emp_id">Employee No.</label>
	                    <input type="hidden" class="form-control" name="allowconcern" id="allowconcern"  value="1">
	                    <input type="hidden" class="form-control" name="comp_code" id="comp_code"  value="<?= @$emp->company_code; ?>">
	                    <input type="hidden" class="form-control" name="bunit_code" id="bunit_code" value="<?= @$emp->bunit_code; ?>">
	                    <input type="hidden" class="form-control" name="business_unit_id" id="business_unit_id" value="<?= @$business_unit_id->id; ?>">
	                    <input type="text" class="form-control" name="emp_id" id="emp_id" autocomplete="off"  value="<?= $emp->emp_id; ?>" readonly>
	                </div>
	            </div>
	            
	            <div class="col-md-6">
	                <div class="form-group">
	                    <label for="name">Name</label>
	                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" value="<?= ucwords(strtolower(htmlentities($emp->name))); ?>" readonly>
	                </div>
	            </div>
	            

	            <div class="col-md-6">
	                <div class="form-group">
	                    <label for="position">Position</label>
	                    <input type="text" class="form-control" name="position" id="position" autocomplete="off" value="<?= @$emp->position; ?>" readonly>
	                </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" name="company" id="company" autocomplete="off"  value="<?=@$cc->acroname; ?>" readonly >
                    </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="bu">Business Unit</label>
                        <input type="text" class="form-control" name="bu" id="bu" autocomplete="off"  value="<?= @$bu->business_unit; ?>" readonly >
                    </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="bu">Department</label>
                        <input type="text" class="form-control" name="department" id="department" autocomplete="off"  value="<?= @$dept->dept_name; ?>" readonly >
                    </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="bu">Section</label>
                        <input type="text" class="form-control" name="section" id="section" autocomplete="off"  value="<?= @$sect->section_name; ?>" readonly >
                    </div>
                </div>
            </div>
            <hr>
	            <div class="row">
	            	<div class="col-md-6">      
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" autocomplete="off"  value="<?= $emp->emp_id; ?>" readonly >
                    </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" name="password" id="password" autocomplete="off"  value="Torrfs2022" readonly >
                    </div>
                </div>
	            </div>
            <hr>
            <div class="row" style="margin-top: 25px;">
            		<!-- <div class="col-md-4">
	            		<label for="allowcheck"> Multiple Approval Execution: </label>
		                <input type="checkbox" id="allowcheck" name="allowcheck" value="1">
	                </div> -->
	                <!-- <div class="col-md-4">
	            		<label for="allowconcern"> Concern Menu: </label>
	                    <input type="checkbox" id="allowconcern" name="allowconcern" value="1">
	                </div> -->
	                <div class="col-md-4">
	            		<label for="allowisr"> ISR Menu: </label>
                        <input type="checkbox" id="allowisr" name="allowisr" value="1">
	                </div>
                </div>
            </div>
            <hr>
            <div class="row" style="margin-top: 20px;">
	            <div class="col-md-6">
	                <div class="form-group">
	                    <label for="usertype">Tasks</label><br>
	                    <ul style="padding-left: 20px;">
	                    	<?php foreach($tasks as $task) : ?>
	                    	<li style="list-style-type: none;">
	                    		<div style="margin-bottom: 8px;" class="form-group">
	                				<input class="largerCheckbox" type="checkbox" id="tasks" name="tasks[]" value="<?= $task->usertype_id; ?>">
	                    			<label for="tasks1" style="margin-left: 5px;"><?= $task->usertype; ?>  </label>
	                    		</div>
	                    	</li>
	                    <?php endforeach; ?>
	                    </ul>
	                </div>
                </div>
                
                <div class="col-md-6">
	                <div class="form-group">
	                    <label for="usergroup">User Groups</label><br>
	                    <ul style="padding-left: 20px;">
	                    	<?php foreach($groups as $group) : ?>
	                    	<li style="list-style-type: none;">
	                    		<div style="margin-bottom: 8px;" class="form-group">
	                				<input class="largerCheckbox" type="checkbox" id="groups" name="groups[]" value="<?= $group->group_id; ?>">
	                    			<label for="groups" style="margin-left: 5px;"><?= $group->groupname; ?>  </label>
	                    		</div>
	                    	</li>
	                    <?php endforeach; ?>
	                    </ul>
	                </div>
                </div>
            </div>
        	<script>
        		$(".select-task").select2({
			        placeholder: "Select a Main Task",
			        allowClear: true
			    });

			    $(".select-ugroup").select2({
			        placeholder: "Select a User Group",
			        allowClear: true
			    });

			    $(".select-comp").select2({
			        placeholder: "Select a Company",
			        allowClear: true
			    });

			    $(".select-bu").select2({
			        placeholder: "Select a Business Unit",
			        allowClear: true
			    });

        	</script>
		<?php
	}

?>