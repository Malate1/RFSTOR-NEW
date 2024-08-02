<link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
       <!--  <div style="color:green" align="right" id="todaysDate"></div> -->
    
      <h1><i class="fa fa-users" aria-hidden="true"></i>
        Manage Profile
        <!-- <small>advanced tables</small> -->
      </h1>
      <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li >User Setup</li>
                <li class="active">Update Profile</li>
            </ol>
    </section>

    <section class="content">
    
        <div class="row">
            <!-- left column -->
            <div class="col-md-10">
              <!-- general form elements -->
                
                
                
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Update Profile Details</h3>
                    </div><!-- /.box-header -->

                    <?php
                        $data = $this->Admin_Model->getUserData();
                        
                    ?>

                    <ul style="padding-left: 6px;" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#password" aria-controls="password" role="tab" data-toggle="tab">Password</a></li>
                        <li role="presentation" ><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Username</a></li>
                        <!-- <li role="presentation" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Photo</a></li>       -->
                    </ul>    
                    <br>
  
                    <!-- form start -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane " id="home">
                            <form action="<?php echo base_url('Admin/ProfileUpdate') ?>" role="form" method="post" id="editProfile" enctype="multipart/form-data">     
                                <div class="box-body">
                                    
                                    <div class="row">
                                       <div class="col-md-6">                             
                                            <div class="form-group">
                                                <label for="lname">User Name</label>
                                                <input type="text" class="form-control" id="username"  value="<?php echo $data->username;?>" name ="username" required>     
                                            </div>
                                        </div>  
                                    </div>
                                </div><!-- /.box-body -->
        
                                <div class="box-footer">
                                    <button  style="color: white" type="submit" class="btn btn-primary swalDefaultSuccess"  value="Submit" /><i class = "fa fa-save"></i> Submit</button> 
                                    <button style="color: white" type="reset" class="btn btn-danger"  value="Reset" /><i class = "fa fa-close"></i> Reset</button>
                                </div>
                            </form>
                        </div> <!-- closing id home -->

                        <div role="tabpanel" class="tab-pane active" id="password">
                            <form role="form" action="<?php echo base_url() ?>Admin/Change_pass" method="post" role="form">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-6"> 
                                            <p style="color: red;"><b> NOTE: </b>Password must be <b>alphanumeric</b> and have atleast <b>8</b> characters in length e.g (Torrfs2022)</p>
                                            <p style="color: red"><?php echo @$errors; ?> </p>
                                            <div class="form-group">
                                                <label>Old Password</label>
                                                <div class="input-group" id="show_hide_Opassword">
                                                    <input class="form-control" type="password" id="oldPassword" name ="oldPassword" required>
                                                    <div class="input-group-addon">
                                                        <a style="color: #333"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">                             
                                            <div class="form-group">
                                                <label for="newPassword">New Password</label>
                                                    <div class="input-group" id="show_hide_Npassword">
                                                        <input name ="newPassword" class="form-control" type="password" id="pass" oncopy="return false" required>
                                                        <div class="input-group-addon">
                                                            <a style="color: #333;"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                <div  id="meter_wrapper"> 
                                                    <br>
                                                    <span id="meter"><p style="color: white; overflow: none; padding: 5px; text-align: center;" id="pass_type"></p></span>
                                                
                                                        <!-- <span id="pass_type"></span> -->
                                                </div> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">                                                                 
                                            <div class="form-group">
                                                <label for="cNewPassword">Confirm New Password</label>
                                                    <div class="input-group" id="show_hide_Cpassword">
                                                    <input type="password" class="form-control" id="cNewPassword" name ="cNewPassword" required> 
                                                    <div class="input-group-addon">
                                                        <a style="color: #333"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">                   
                                    <button onclick="return Validate()" style="color: white" type="submit" class="btn btn-primary swalDefaultSuccess swalDefaultError"  value="Submit" /><i class = "fa fa-save"></i> Submit</button> 
                                    <button style="color: white" type="reset" class="btn btn-danger"  value="Reset" /><i class = "fa fa-close"></i> Reset</button>
                                </div>
                            </form>
                        </div> <!-- closing id home -->

                        <div role="tabpanel" class="tab-pane" id="profile"> <!-- for photo -->
                            <form action="<?php echo base_url('Admin/ProfilePicUpdate') ?>" role="form" method="post" id="editPatient" enctype="multipart/form-data">     
                                <div class="box-body">
                                    
                                    <div class="row">

                                        <div class="col-md-6"> 
                                            <!-- <img src="<?php echo base_url(); ?>uploads/profile-pic/<?=$this->session->profile_pic ?>" class="img-thumbnail rounded mb-2" alt="User Image" style="height: 200px; width: 200px;">                                  -->
                                            <div class="form-group">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="Editphoto" name ="Editphoto" value="<?php echo $data->profile_pic;?>" required>    
                                            </div>
                                        </div>
                                                              
                                        <div class="col-md-6">   
                                            <div style="display: none;" class="form-group">
                                                <label for="fname">Name</label>
                                                <input type="text" class="form-control" id="fname"  value="<?=$this->session->name ?>" name ="fname" readonly>
                                                
                                            </div>
                                        </div>
                                        

                                        
                                    </div>
                                </div><!-- /.box-body -->
    
                                <div class="box-footer">
                                    <button  style="color: white" type="submit" class="btn btn-primary swalDefaultSuccess"  value="Submit" /><i class = "fa fa-save"></i> Submit</button> 
                                    
                                    <button style="color: white" type="reset" class="btn btn-danger"  value="Reset" /><i class = "fa fa-close"></i> Reset</button>
                                </div>
                            </form>

                        </div> <!-- closing for photo -->
                    </div>
                   <!--  <form role="form" action="<?php echo base_url() ?>Physician/ProfileUpdate" method="post" role="form"> -->
                    
                </div>
            </div>
            
        </div>    
    </section>
    
    
    
</div>

<?php $this->view('templates/footer'); ?> 

<script type="text/javascript">
  $(document).ready(function() {
    
    $("#userSideTree").addClass('active');
    $("#username").addClass('active');
  });
</script>

<script type="text/javascript">
    function swal_message(msg_type,msg){
    var Toast = Swal.mixin({
        toast: false,
        position: 'center',
        showConfirmButton: true,
        
        
      });

    Toast.fire({
        icon: msg_type,
        title: msg
    })
}
    <?php if($this->session->flashdata('success2')) { ?>
        
        swal_message('success','Password Successfully Updated!');
    <?php } ?> 

    <?php if($this->session->flashdata('errormsg2')) { ?>
        
        swal_message('error','Username already exists!');
    <?php } ?> 

    <?php if($this->session->flashdata('errormsg')) { ?>
    
        swal_message('error','Old Password is Incorrect ');
    <?php } ?> 

    <?php if($this->session->flashdata('success')) { ?>
        swal_message('success','Username Successfully Updated!');
    <?php } ?>

    <?php if($this->session->flashdata('success1')) { ?>
        swal_message('success','Profile Picture Successfully Updated!');
    <?php } ?>  

    // <?php if($this->session->flashdata('errormsg1')) { ?>
    
    //     swal_message('error','The password must have atleast 1 capital letter and atleast 1 number ');
    // <?php } ?>

 
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#show_hide_Opassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Opassword input').attr("type") == "text"){
                $('#show_hide_Opassword input').attr('type', 'password');
                $('#show_hide_Opassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Opassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Opassword input').attr("type") == "password"){
                $('#show_hide_Opassword input').attr('type', 'text');
                $('#show_hide_Opassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Opassword i').addClass( "fa-eye" );
            }
        });
        $("#show_hide_Npassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Npassword input').attr("type") == "text"){
                $('#show_hide_Npassword input').attr('type', 'password');
                $('#show_hide_Npassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Npassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Npassword input').attr("type") == "password"){
                $('#show_hide_Npassword input').attr('type', 'text');
                $('#show_hide_Npassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Npassword i').addClass( "fa-eye" );
            }
        });
        $("#show_hide_Cpassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Cpassword input').attr("type") == "text"){
                $('#show_hide_Cpassword input').attr('type', 'password');
                $('#show_hide_Cpassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Cpassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Cpassword input').attr("type") == "password"){
                $('#show_hide_Cpassword input').attr('type', 'text');
                $('#show_hide_Cpassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Cpassword i').addClass( "fa-eye" );
            }
        });
    });
</script>
</body>
</html>