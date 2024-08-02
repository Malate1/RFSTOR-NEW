<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            <div style="color:#3c8dbc" align="right" id="todaysDate"></div>

            <h1><i class="fa fa-users" aria-hidden="true"></i>
                Manage Business Units 
            </h1>

            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Admin Setup</li>
                <li class="active">Business Unit</li>
            </ol>
        </section>
        <style type="text/css">

            @media print {
               table td:last-child {display:none}
               table th:last-child {display:none}
            } 
        </style>
       

        <div id="addBuModal" class="modal fade" role="dialog" >
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add Business Unit Form</b></h4>
                    </div>
                    <div class="modal-body">
                     <?php echo form_open('Admin/bucreate'); ?> 
                        <form method="post" >
                            <div id="addbu_content"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                     <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    </div>
                </div>
            </div>
        </div>

        <div id="addCompModal" class="modal fade" role="dialog" >
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add Company Form</b></h4>
                    </div>
                    <div class="modal-body">
                     <?php echo form_open('Admin/compcreate'); ?> 
                        <form method="post" >
                            <div id="addcomp_content"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editBuModal" class="modal fade" role="dialog">
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit Business Unit Form</b></h4>
                    </div>
                    <div style="height: auto;" class="modal-body">
                     <?php echo form_open('Admin/buupdate'); ?>
                        <form method="post">
                            <div id="editbu_content"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editBuModal2" class="modal fade" role="dialog">
            <div style="height: auto;" class="modal-dialog modal-dialog-scrollable" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit BU Roles Form</b></h4>
                    </div>
                    <div class="modal-body">
                        <div id="editbu_content2">
                                         
                        </div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>


        <!-- Main content -->
        <section class="content">
           <div class="row">
                
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Business Unit Record List</h3>

                            <?php if($this->session->emp_id == '02723-2022') {?>
                                <a style="margin-left: 75%;" class="btn btn-primary" href="http://172.16.161.34:8080/hrms/placement/company_structure.php" target="_blank">View Structure
                                
                                </a>
                            <?php } ?>
                        </div> 
                           
                        <div class="tableft tableft1">
                            <div class="scroll" style="width: 14.5%; padding: unset; ">
                                <div class="tableftheader">
                                <?php
                                    foreach ($getComp as $m)
                                    { ?>                               
                                    <div id="mydiv" class="tableftheaderitems" >
                                        <!-- <?php echo form_open('Admin/bu_content'); ?>  -->
                                        <!-- <form  method="post"> -->
                                        <button type="button" value="<?=$m->company_code?>" id="comp_<?=$m->company_code?>" onclick="bu_content('<?=$m->company_code?>')" style="border-color: transparent; padding: 10px;"  class="btn-block "><b><?=$m->acroname?></b></button>
                                        <!-- </form> -->
                                    </div>
                                <?php } ?>  
                                </div>
                            </div>   
                            <div class="tableftbody"> 
                                <div class="tableftbodywrapper">
                                    <div class="table-responsive" >
                                        <table style="table-layout: fixed; " class="table  table-striped  table-bordered table-hover" role="grid" >
                                            <thead class="thead-dark">
                                                <tr>
                                                    
                                                    <th style="width: 70%; text-align: center;">Business Unit</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bu_content1">
                                                
                                            </tbody>
                                        </table>
                                    </div>    
                                </div>
                            </div>

                        </div>      
                    </div>
                </div>
            </div> <!-- /.row -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
    <?php $this->view('templates/footer'); ?> 

<!-- <script type="text/javascript">
    $('.tableftheaderitems').click(function() {
        if ($("#mydiv").hasClass( "active" )) {
            $(this).removeClass('active');
        }else{
           $(this).addClass('active'); 
        }
       style="border-color: transparent; background-color: inherit;" 
});
</script> -->
<!-- page script -->
<script type="text/javascript">
  $(document).ready(function() {
   
    $("#adminSideTree").addClass('active');
    $("#bu").addClass('active');

    $(".btn-block").click(function () {
        $(".btn-block").removeClass("click");
        $(this).addClass("click");
    });
    
  });
</script>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    } 
  });
}
</script>

<script type="text/javascript">
    <?php if($this->session->flashdata('errormsg1')) { ?>
        $(function() {
        const Toast = Swal.mixin({
            toast: false,
            position: 'top',
            showConfirmButton: true,
            timer: 7000,
            timerProgressBar: true,
            });

            $('.swalDefaultError').fadeIn(function(){
                Toast.fire({
                    type: 'error',
                    title: 'Credentials already exists'
                })
            });
        });
    <?php } ?>

    <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
        $(function() {
        const Toast = Swal.mixin({
            toast: false,
            position: 'top',
            showConfirmButton: true,
            timer: 7000
            });

            $('.swalDefaultSuccess').fadeIn(function() {
                Toast.fire({
                    type: 'success',
                    title: 'User Succcessfully Added '
                })
            });
        });
    <?php } ?>

    <?php if($this->session->flashdata('SUCCESSMSG1')) { ?>
        $(function() {
        const Toast = Swal.mixin({
            toast: false,
            position: 'center',
            showConfirmButton: true,
            timer: 10000
            });

            $('.swalDefaultSuccess').fadeIn(function() {
                Toast.fire({
                    type: 'success',
                    title: 'Business Unit Succcessfully Updated '
                })
            });
        });
    <?php } ?>
</script>
</body>
</html>
