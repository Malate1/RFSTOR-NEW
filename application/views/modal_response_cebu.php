<?php 
	if($request == 'add-user-form-cebu') {
		?>
			<div class="alert alert-danger" id="msg" role="alert" style="display: none">Ayaw Kol!</div>
            <div class ="row">
        		<div class="col-md-6">      
            		<div class="form-group">
	                    <label for="emp_id">Employee No.</label>
	                    <input type="hidden" class="form-control" name="allowconcern" id="allowconcern"  value="1">
	                    <input type="hidden" class="form-control" name="comp_code" id="comp_code"  value="07">
	                    
	                    <input type="text" class="form-control" name="emp_id" id="emp_id" autocomplete="off"  value="" required placeholder="Ask this from the HRMS Team (eg. xxxxx-xxxx)">
	                </div>
	            </div>
	            
	            <div class="col-md-6">
	                <div class="form-group">
	                    <label for="name">Name</label>
	                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" value="" required placeholder="Lastname, Firstname Middlename">
	                </div>
	            </div>

	            <div class="col-md-6">      
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" name="company" id="company" autocomplete="off"  value="CEBO" readonly >
                    </div>
                </div>

                <div class="col-md-6">      
                    <div class="form-group">
                        <label for="bu">Business Unit</label>
                        <select style="width: 100%; height: resolve; padding:5px;" class="form-control" name="bu" id="bu">
	                        
	    					<option value="79">COLONNADE- COLON</option>
		                    <option value="80">COLONNADE- MANDAUE</option>
		                </select>
                    </div>
                </div>

                
            </div>
            <hr>
	            <div class="row">
	            	<div class="col-md-6">      
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" autocomplete="off"  value="" required >
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

			    // $(".select-bu").select2({
			    //     placeholder: "Select a Business Unit",
			    //     allowClear: true
			    // });

        	</script>
		<?php
	}

?>