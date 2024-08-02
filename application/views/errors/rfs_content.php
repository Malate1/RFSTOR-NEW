public function rfs_content()
		{
			$data = $this->Admin_Model->getUserData();
			$date = date("m/d/Y"); 
			$data1 = $this->Admin_Model->getUserGroup();
			$data2 = $this->Admin_Model->getUserRfs();
			$data3 = $this->Admin_Model->getUserRfsMode();
            
			echo'<div class="alert alert-danger" id="msg" role="alert" style="display: none">Credentials already exist!</div>';
            echo'<ul class="nav nav-tabs" role="tablist">';
                
            echo'<li role="presentation" class="active"><a href="#details" aria-controls="details" role="tab" data-toggle="tab">RFS Details</a></li>
                <li role="presentation" ><a href="#attachment" aria-controls="attachment" role="tab" data-toggle="tab">Attachments</a></li>';
                 
            echo'</ul><br>';
            echo'<div class="tab-content">      
                    
                    <div role="tabpanel" class="tab-pane active" id="details">';                         
                        echo'<div class ="row">
                            <div class="col-md-6">      
                                <div class="form-group">
                                    <label for="company">Company Name</label>
                                    <input type="text" class="form-control" name="company" id="company" autocomplete="off"  value="'.$data->acroname.'" readonly >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="bu">Business Unit</label>
                                    <input type="text" class="form-control" name="bu" id="bu" autocomplete="off"  value="'.$data->business_unit.'"  readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Contact No.</label>
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
                                    <select style="width: 100%; height: resolve; padding:5px;" class="select-type form-control" name="rfstype" id="rfstype" required">
                                        <option></option>';
                                        foreach ($data2 as $value) {
                                echo   '<option value="'.$value->rfs_id.'">'.$value->requesttype.'</option>';
                                        }
                                echo '</select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Request Mode</label><br>
                                    <select style="width: 100%; height: resolve; padding:5px;" class="select-mode form-control" name="requests_mode" id="requests_mode" required">
                                        <option></option>';
                                        foreach ($data3 as $value) {
                                echo   '<option value="'.$value->id.'">'.$value->themode.'</option>';
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
                        </div>
                    </div>  

                    <div role="tabpanel" class="tab-pane" id="attachment">                     
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="details">Attachments</label><br>
                                    <input required type="file" id="photo" name="photo" class="file-loading"/>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>

            
                <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
                <button type="reset" class="btn btn-danger"  value="Reset">Reset</button>';
	                 
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

        	</script>
        <?php
		}