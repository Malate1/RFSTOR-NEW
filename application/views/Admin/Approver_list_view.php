<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            

            <h1><i class="fa fa-users" aria-hidden="true"></i>
                Manage Users 
            </h1>
        </section>
        <style type="text/css">

            @media print {
               table td:last-child {display:none}
               table th:last-child {display:none}
            }

            
           
        </style>

        

        <!-- Main content -->
        <section class="content">
           <div class="row">
                <div class="col-xs-12 text-left">
                    <div class="form-group">
                        <!-- <a class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addUserModal" onclick=adduser_content()><i class="fa fa-plus" aria-hidden="true"></i> Add User Group</a> -->
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Approvers List</h3>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="editable_table1" width="100%">
                                <thead>
                                    <tr role="row">
                                        
                                        <th >Name</th>
                                        <th >Job Position</th>
                                        <th>Business Unit</th>                                          
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($getApprovers))

                                {
                                    foreach ($getApprovers as $value)
                                    { ?>
                                    <tr>
                                        <?php
                                            $userdetails = $this->user_model->getuserDetails2($value->user_id);
                                            //$executedby = $this->employee_model->find_an_employee(@$userdetails->emp_id);
                                           $name = $this->employee_model->find_an_employee(@$userdetails->emp_id);
                                           $bu = $this->Admin_Model->bu_name($value->bunit_code);
                                        ?>
                                        
                                        <td><?=$userdetails->name?></td>
                                        <td><?=$name->position?></td>
                                        <td><?=$bu->business_unit?></td> 
                                        
                                        <!-- <td><?=$value->business_unit?> </td> -->
                                        <!-- <a title="Modify User" style="color: orange"  data-toggle="modal" data-target="#editUserModal" onclick=edituser_content(<?php echo $value->group_id; ?>)><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a> -->
                                            
                                            <!-- <a title="Delete User" style="color: #F03649"  onclick="return confirmDialog();" href = "<?php echo base_url("Admin/cruddelete/$value->user_id"); ?>"><i class="fa fa-trash fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp; -->
                                    </tr>   
                                    <?php }
                                }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
    <?php $this->view('templates/footer'); ?> 
<script>
    var baseurl = "<?php echo base_url(); ?>";
</script>
<!-- page script -->
<script>
    function confirmDialog() {
      return confirm("Are you sure you want to delete this record?")
    }

$(document).ready(function() {
    var table = $('#editable_table1');
    table.DataTable({
        dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f>>r<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        buttons: [
            'copy', 'csv', 'print'
        ],
        "order": [[ 0, "asc" ]]
    });
    var tableWrapper = $("#editable_table_wrapper");
    tableWrapper.find(".dataTables_length select").select2({
        showSearchInput: false //hide search box with special css class
    }); // initialize select2 dropdown
    $("#editable_table_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    $(".dataTables_wrapper").removeClass("form-inline");
    $(".dataTables_paginate .pagination").addClass("float-right");
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
            position: 'center',
            showConfirmButton: true,
            timer: 20000,
            timerProgressBar: true,
            });

            $('.swalDefaultError').fadeIn(function(){
                Toast.fire({
                    type: 'error',
                    title: 'Ayaw Kol! Bata pako kol!'
                })
            });
        });
    <?php } ?>

    <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
        $(function() {
        const Toast = Swal.mixin({
            toast: false,
            position: 'center',
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
                    // title: 'User Succcessfully Updated '
                    title: 'User Succcessfully Updated! '
                })
            });
        });
    <?php } ?>
</script>
</body>
</html>
