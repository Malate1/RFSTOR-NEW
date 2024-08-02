<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Online TOR & RFS | Login </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css"/>
    <!-- <link rel=" icon" href="assets/dist/img/logo2.png"> -->
    <link rel="icon" type="image/png" href="assets/dist/img/logo3.png" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css"./>
    <!-- DataTables -->

    <!-- <link type="text/css" rel="stylesheet" href="<?=base_url()?>vendors/select2/css/select2.min.css" /> 
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/pages/dataTables.bootstrap.css" /> -->
    <!--End of plugin styles-->
    <!--Page level styles-->
    <!--<link type="text/css" rel="stylesheet" href="<?=base_url()?>css/pages/tables.css" /> Ug naa ni maguba ag pagination pero ug wla ni dili responsive -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css"/>
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"> -->
    <!-- <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'> -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css"/>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/DataTables/datatables.min.css" />
    <!-- JQuery UI CSS -->
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" />
      
    
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css"> 
    <link rel="stylesheet" href="<?=base_url()?>assets/css/select2.min.css"> 
    <!-- <link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css"> -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/daterangepicker.css">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/DataTables/FixedColumns-4.2.1/css/fixedColumns.bootstrap.min.css" />
</head>

<body class="login-page" style="height:auto;">
    <style type="text/css">
        body, h4 {
            font-family: "Inter","Roboto", "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            

        }
        h4 {
            font-size: 20px;
            font-weight: 600;
        }

        .card:hover i,.card:hover h5{
            color: #3c8dbc;
        }
        td{
            text-align: left;
            font-size: 12px;
        }

        

        .fa-5x {
            font-size: 4em;
        }

        .inputGroup {
          font-family: 'Segoe UI', sans-serif;
          margin: 1em 0 1em 0;
          max-width: 320px;
          position: relative;
        }

        .inputGroup input {
          font-size: 100%;
          padding: 0.8em;
          outline: none;
          border: 1.5px solid rgb(200, 200, 200);
          background-color: transparent;
          border-radius: 4px;

          width: 100%;
        }

        .inputGroup label {
          font-size: 100%;
          position: absolute;
          left: 0;
          padding: 0.8em;
          margin-left: 0.5em;
          pointer-events: none;
          transition: all 0.3s ease;
          color: rgb(100, 100, 100);
        }

        .inputGroup :is(input:focus, input:valid)~label {
          transform: translateY(-50%) scale(.9);
          margin: 0em;
          margin-left: 1.3em;
          padding: 0.4em;
          background-color: rgb(255, 255, 255);
        }

        .inputGroup :is(input:focus, input:valid) {
          border-color: rgb(150, 150, 200);
        }
    </style>

    <div id="viewContactModal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Contact Us</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                    <div class="row" style="padding-top: 20px; align-content: center;">
                        <p class="text-center" style="font-size: 12px;">For concerns regarding your account and requests access kindly contact your designated group. </p>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5">
                           <div class="card border-0">
                                  <div class="card-body text-center">
                                    <i class="fa fa-map-marker fa-5x mb-3" aria-hidden="true"></i>
                                    <h5 class="text-uppercase mb-5">office location</h5>
                                       <address style="text-align: center; font-size: 12px;">Upper Ground, North Wing,
                                        Island City Mall, Tagbilaran City,
                                        Bohol, Philippines 6300 </address>
                                  </div>
                            </div>
                         </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-phone fa-5x mb-3" aria-hidden="true"></i>
                                    <h5 class="text-uppercase mb-5">call us</h5>
                                    
                                    <table align="center">
                                      
                                      <tr>
                                        <td style="padding: 4px;">1847</td>
                                        <td style="text-align: left;">FARMS, ATP, TSMS, BR, INSTITUTIONAL, CWO</td>
                                      </tr>

                                      
                                      <tr>
                                        <td style="padding: 4px;">1951</td>
                                        <td style="text-align: left;">FAD</td>
                                      </tr>

                                      <tr>
                                        <td style="padding: 4px;">1953</td>
                                        <td style="text-align: left;">GC, MYNETGOSYO</td>
                                      </tr>

                                      <!-- <tr>
                                        <td style="padding: 4px;">1953</td>
                                        <td style="text-align: left;">MYNETGOSYO</td>
                                      </tr> -->

                                      <tr>
                                        <td style="padding: 4px;">1844</td>
                                        <td style="text-align: left;">HRMS, CMS, PMS</td>
                                      </tr>


                                      <tr>
                                        <td style="padding: 4px;">1821</td>
                                        <td style="text-align: left;">EBM, GO</td>
                                      </tr>

                                      
                                      <tr>
                                        <td style="padding: 4px;">1809/1801</td>
                                        <td style="text-align: left;">Navision</td>
                                      </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                         
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-paper-plane fa-5x mb-3" aria-hidden="true"></i>
                                    <h5 class="text-uppercase mb-5">email</h5>
                                    <p style="font-size: 12px;"><a href="mailto:itsysdev@alturasbohol.com">itsysdev@alturasbohol.com</a></p>
                                
                                </div>
                            </div>
                        </div>
 
                    </div>
                </div>

                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div class="login-box" >
        <div class="login-logo">
            <a href="#">
                <img src="<?=base_url()?>assets/dist/img/tor--rfs-high-resolution-logo-transparent.png" class="img-circle"  alt="logo" style="height: 169px; width: 150px; box-shadow: 5px 5px 30px #d2d6de;">
            </a>
        </div>
        <!-- /.login-logo -->

        <div class="login-box-body" style="border-radius: 5px; box-shadow: 0 0 30px #3336;">
            <!-- <p class="login-box-msg"></p> -->
           <!--  <?php if($this->session->flashdata('errormsg')) { ?>
                <div role="alert" class="alert alert-danger">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('errormsg')?>
                </div>
            <?php } ?> -->

            <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
                <div role="alert" class="alert alert-success">
                  <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                  <?=$this->session->flashdata('SUCCESSMSG')?>
                </div>
            <?php } ?>

            <!-- <?php if($this->session->flashdata('errormsg1')) { ?>
                <div role="alert" class="alert alert-danger">
                    <button data-dismiss="alert" class="close" type="button"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('errormsg1')?>
                </div>
            <?php } ?> -->

            <form action="<?php echo base_url(); ?>Login/logAdmin" method="post">
                <b style="text-align: center; display: block; margin: 0 auto;">User Login</b>
                <div class="inputGroup">
                    <input type="text" name="username" required="" autocomplete="off">
                    <label for="name">Username</label>
                </div>
                <div class="inputGroup">
                    <input id="typepass" type="password"  name="password" required />
                    <label for="name">Password</label>
                    
                <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                </div>
                <input type="checkbox" onclick="Toggle()"> 
                    <b>Show Password</b> 
                    <br>

                    <script> 
                        // Change the type of input to password or text 
                        function Toggle() { 
                            var temp = document.getElementById("typepass"); 
                            if (temp.type === "password") { 
                                temp.type = "text"; 
                            } 
                            else { 
                                temp.type = "password"; 
                            } 
                        } 
                    </script> 
                <div class="row">
                    <br>
                    <div class="col-xs-8">    
                        <select style="border-radius: 4px; padding: 6px; width: 200px" name="form" class="form-select" onchange="location = this.value;">
                          <option value="">Switch Location</option>
                          <option value="<?php echo base_url() ?>Login/logAdmin">Bohol</option>
                          <option value="<?php echo base_url() ?>Login/logCebu">Cebu</option>
                          
                        </select>                     
                    </div><!-- /.col -->
                    <div class="col-xs-4">
                        
                        <button type="submit" class="btn btn-primary btn-block btn-icon">
                          <i class="fa fa-sign-in"></i> Sign In
                        </button>
                    </div><!-- /.col -->
                </div>
            </form>
        </div><!-- /.login-box-body -->
        <div class="text-muted" style="text-align: center;"><br>
            <strong> &copy; </strong>2022 - <?php echo date('Y'); ?> <strong>Online TOR & RFS</strong>. All rights
        reserved.
        </div>

    </div><!-- /.login-box -->

    <div class="text-muted" style="text-align: right;margin-right: 20px;">
        For inquiries about the <b>Online TOR & RFS</b>, please click <b><a data-toggle="modal" data-target="#viewContactModal"> here</a></b>.

    </div>

    <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>js/passwordscheck.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="<?=base_url()?>assets/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                    if (input.attr("type") == "password") {
                        input.attr("type", "text");
                    } else {
                        input.attr("type", "password");
                    }
        });
    </script>

    <script type="text/javascript">

        function swal_message1(msg_type,msg){
            var Toast = Swal.mixin({
                toast: false,
                position: 'top-center',
                showConfirmButton: true,
                // timer: 5000,
                // timerProgressBar: false,
              });

            Toast.fire({
                icon: msg_type,
                title: 'Oops!',
                text: msg
            })
        }
        <?php 
        if ($this->session->flashdata('errormsg')) {  
            
            $msg = 'Username or password is invalid';
            
            
            echo "swal_message1('error','$msg')";
        } 
        ?>

        <?php 
        if ($this->session->flashdata('errormsg1')) {  
            
            $msg = 'This account is deactivated';
            
            
            echo "swal_message1('error','$msg')";
        } 
        ?>

    </script>
</body>
</html>