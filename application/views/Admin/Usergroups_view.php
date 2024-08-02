<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            

            <h1><i class="fa fa-users" aria-hidden="true"></i>
                Manage User Groups 
            </h1>

            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Admin Setup</li>
                <li class="active">User Groups</li>
            </ol>
        </section>
        <style type="text/css">

            @media print {
               table td:last-child {display:none}
               table th:last-child {display:none}
            }

            
           
        </style>

        <div id="addGroupModal" class="modal fade" role="dialog" >
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add User Group</b></h4>
                    </div>
                    <div class="modal-body" style="height: auto;">
                     <?php echo form_open('Admin/groupcreate'); ?> 
                        <form method="post" >
                            <div id="addgroup_content">
                               
                            </div> 
                        </form>        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>              
                </div>
            </div>
        </div>

        <div id="editUserModal" class="modal fade" role="dialog">
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit User Group</b></h4>
                    </div>
                    <div class="modal-body">
                     <?php echo form_open('Admin/crudupdate'); ?>
                        <form method="post">
                            <div id="edituser_content"></div>
                        </form>
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
                <div class="col-xs-12 text-left">
                    <div class="form-group">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#addGroupModal" onclick=addgroup_content()><i class="fa fa-plus" aria-hidden="true"></i> Add User Group</a>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">User Group Record List</h3>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="editable_table1"  width="100%"  >
                                <thead>
                                    <tr role="row">
                                        <th > ID</th>
                                        <th >Groupname</th>
                                       
                                        <th>Status</th>                                          
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($getUsergroup))
                                {
                                    foreach ($getUsergroup as $value)
                                    { ?>
                                    <tr>
                                        <td ><?=$value->group_id?></td>
                                        <td><?=$value->groupname?></td>
                                        <!-- <td><a data-toggle="modal" data-target="#addGroupModal" onclick=addgroup_content()><?=$value->groupname?></a></td> -->
                                        <?php 
                                            if($value->active == 1){
                                            echo'
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" onclick=deactivategroupstatus("'.$value->group_id.'") checked >
                                                        <span class="slider round"></span>
                                                    </label>                                        
                                                </td>';
                                            }else{
                                            echo'
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" onclick=activategroupstatus("'.$value->group_id.'") >
                                                        <span class="slider round"></span>
                                                    </label>                                        
                                                </td>';    

                                            }
                                        ?>
                                        
                                        
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
<!-- page script -->
<script>
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

<script type="text/javascript">
  $(document).ready(function() {
   
    $("#adminSideTree").addClass('active');
    $("#groups").addClass('active');
    
  });
</script>

<script type="text/javascript">
    <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
        swal_message('success','User Group Successfully Added!');
    <?php } ?>

    <?php if($this->session->flashdata('ERRORMSG')) { ?>
        swal_message('error','User Group Already Exist!');
    <?php } ?>
</script>
</body>
</html>
