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

            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li >Admin Setup</li>
                <li class="active">Users</li>
            </ol>
        </section>
        <style type="text/css">

            @media print {
               table td:last-child {display:none}
               table th:last-child {display:none}
            }

            /*div.dataTables_processing div {
              display: none;


            }*/

            /*#loader {
    position: fixed;
    background-color: white;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); 
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; 
  }*/

            /*@keyframes spinner {
              to {transform: rotate(360deg);}
            }
             
            .spinner:before {
              content: '';
              box-sizing: border-box;
              position: absolute;
              top: 50%;
              left: 50%;
              width: 20px;
              height: 20px;
              margin-top: -10px;
              margin-left: -10px;
              border-radius: 50%;
              border: 2px solid #ccc;
              border-top-color: #333;
              animation: spinner .6s linear infinite;
            }*/
           
        </style>

        <div id="addUserModal" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add User Form</b></h4>
                    </div>
                    <form id="add-user" autocomplete="off">
                        <div class="modal-body">
                         <?php // echo form_open('Admin/crudcreate'); ?> 
                            <div id="adduser_content">
                               
                            </div>       
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>   
                    </form>           
                </div>
            </div>
        </div>

        <div id="editUserModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit User Form</b></h4>
                    </div>
                    <div class="modal-body" style="height: auto;">
                     <!-- <?php echo form_open('Admin/crudupdate'); ?> -->
                        <form id="editUser" method="post">
                            <div id="edituser_content"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editUserModal2" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit Roles Form</b></h4>
                    </div>
                    <div class="modal-body">
                        <div id="edituser_content2">
                                         
                        </div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editUserModal3" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>User's Tasks</b></h4>
                    </div>
                    <div class="modal-body">
                        <div id="userTasks_content">
                                         
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
            <!-- <div class="row">
                <div class="col-xs-12 text-left">
                    <div class="form-group">
                        <a class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addUserModal" onclick=adduser_content()><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
                    </div>
                </div>
            </div>  -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" id="emp-details">
                        <p style="color:red;"><b> Note:</b> Users with a check symbol indicate that they are already added</p>
                        <label for="name">Search Employee Name to be added </label>
                        <input type="text" placeholder="Lastname, Firstname Middlename" class="form-control" name="search" autofocus="on">
                    </div>
                </div>
                <div class="col-md-1" style="margin-top: 50px;">
                    <button id="clear-search" class="btn btn-warning " ><i class="fa fa-times"></i></button>
                </div>
            </div> 
            
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Users Record List</h3><br>

                        <div style="color:red; padding-top: 10px;"><b> Note:</b> Click the user's name to view the user's tasks</div>
                        </div>

                        <div style="padding: 0px 10px 10px 10px" class="box-body ">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group ">
                                        <form class="form-horizontal">
                                            <label for="usergroup">User Group:</label>
                                            <select style="width: 100%; padding:5px;" class="form-control select-group" name="usergroup" id="usergroup">
                                                <option></option>;'
                                                <?php
                                                $data1 = $this->Admin_Model->getUserGroup();

                                                foreach ($data1 as $value) {?>
                                                    <option value="<?=$value->group_id?>"> <?=$value->groupname?> </option>
                                               <?php } ?>
                                            </select>
                                        </form>
                                    </div>
                                    
                                </div>

                                <div class="col-xs-9" style="text-align: right; padding-top: 20px;">
                                    <button class="btn btn-warning " id="refreshButton"><i class="fa fa-refresh"></i> Refresh</button>

                                    <?php if ($this->session->emp_id == '02723-2022') {?>
                                        <button class="btn btn-warning " id="refreshButton2"><i class="fa fa-refresh"></i> Update</button>
                                    <?php } ?>
                                </div>

                                <!-- <?php if ($this->session->emp_id == '02723-2022') {?>
                                    <div class="col-xs-9" style="text-align: right; padding-top: 20px;">
                                    
                                </div>
                                <?php } ?> -->
                                
                               
                            </div>

                            <!-- <div class="row" style="padding: 15px; text-align: left;">
                                

                            </div> -->
                            
                            <table class="table table-responsive table-striped  table-bordered table-hover dataTable no-footer" id="dt-users" width="100%" >
                                <thead>
                                    <tr role="row">
                                        
                                        <th style="width:200px">Full Name</th>
                                        <th>Username</th>
                                        <th>Job Position</th>
                                        <th>Company</th>
                                        <th>BU</th>
                                        <th style="width:160px">Department</th>
                                        <th>Section</th>
                                        <th>Status</th>
                                        <th style="width:200px">Actions</th>                                          
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
    <?php $this->view('templates/footer'); ?> 
 <script>
                
                                    $(".select-group").select2({
                                        placeholder: "Select a user group",
                                        allowClear: true
                                    });

                                </script>
<!-- page script -->
<script type="text/javascript">
  $(document).ready(function() {
   
    $("#adminSideTree").addClass('active');
    $("#users").addClass('active');
    
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

</body>

<!-- <script src="<?=base_url()?>assets/plugins/DataTables/Buttons-2.3.3/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/Buttons-2.3.3/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>assets/plugins/DataTables/JSZip-2.5.0/jszip.min.js"></script>
<script src="<?=base_url()?>assets/js/xlsx.js"></script> -->
<script >
    
    $(function() {

        

        $("input[name='search']").autocomplete({
    source: function (request, response) {
        jQuery.get("<?= site_url('employee/search'); ?>", {
            query: request.term
        }, function (data) {
            data = JSON.parse(data);
            response(data);
        });
    },
    search: function (e, u) {
        $(this).addClass('loader');
    },
    response: function (e, u) {
        $(this).removeClass('loader');
    }
}).data("ui-autocomplete")._renderItem = function (ul, item) {
    let listItem = $("<li>").append(
        $("<div>").css("font-family", "Inter-Regular, sans-serif").html(`${item.id} - ${item.name} - ${item.emp_no} ${item.hasCheck ? '&#x2705;' : ''}`)
    );
    return listItem.appendTo(ul);
}.bind($("input[name='search']"));

// Triggered when an item is selected from the autocomplete list
$("input[name='search']").on("autocompleteselect", function (event, ui) {
    let id = ui.item.id;
    viewAddForm(id);
    return true;
});



        $("button#clear-search").click(function() {
            $("input[name = 'search']").val('');
        });

        $("input[name = 'search']").focus(function() {
            $(this).val('');
        })

        const Toast = Swal.mixin({
            toast: false,
            position: 'center',
            showConfirmButton: true
            //timer: 2000
        })
        
        $("form#add-user").submit(function(e) {

            e.preventDefault();
            let formData = $(this).serialize();

            let tasks = $("input[name = 'tasks[]']:checked").length;
            let groups = $("input[name = 'groups[]']:checked").length;
            if (tasks == 0) {
                
                swal_message('warning','Please choose atleast one task!'); 
                return;
            }
            if (groups == 0) {
                
                swal_message('warning','Please choose atleast one group!');
                return;
            }

            

            $.ajax({
                type: "POST",
                url: "<?= site_url('store_user'); ?>",
                data : formData,
                // dataType: 'json',
                success: function(data) {
                    if(trimfield(data) == 'User-exists'){
                     
                        swal_message('error','User already exists!');
                        $('div#addUserModal').modal('hide');
                        //window.setTimeout(function(){location.reload()},2000)
                    }
                    if(trimfield(data) == 'ok'){

                        swal_message('success','User Successfully Added!'); 
                        $('div#addUserModal').modal('hide');
                        window.setTimeout(function(){location.reload()},2000)
                    }
                    
                }
            });
        });
        //let usergroup = null;
        $(document).ready(function(){
            
        let usergroup = $('#usergroup').select2("val");
            // let dateFrom = $("input[name = 'date_from']").val();
            // let dateTo = $(this).val();
        viewUser(usergroup);

        
        $('#usergroup').on('change', function() {
             
            let usergroup = this.value;
            viewUser(usergroup);
        });

        });

        

        function viewUser(usergroup) {// var table = $("table#dt-users").DataTable({
            var table = $('table#dt-users').removeAttr('width').DataTable({
                dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f>>r<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
                buttons: [
                    'copy', 'excel', 'pdf'
                ],

                buttons: [
                    {
                        extend: 'copy',
                        title: 'RFSTOR Users List',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                    },
                    {
                        extend: 'excel',
                        title: 'RFSTOR Users List',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
                            
                        }
                    },

                    {
                        extend: 'pdf',
                        title: 'RFSTOR Users List',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6]
                        },
                    },
                ],

                "destroy": true,
                'serverSide': true,
                'stateSave' : true,
                'processing': true,
                'language': {
                   
                    "processing": '<div id="loader"><img style="background-color: white;" src="<?= base_url('uploads/profile-pic/Fidget-spinner1.gif') ?>" alt="Loading..."></div>'
                     //$("div.emp-details").html('<img src="<?= base_url('uploads/profile-pic/Fidget-spinner.gif') ?>" alt="">');
                   
                }, 
                'lengthMenu': [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Max"]],
                'pageLength': 10,
                'scrollCollapse': true,
                'scrollY': '70vh',

                "ajax": {
                    url: "<?php echo site_url('employee/user_list'); ?>",
                    type: "POST",
                    data : {
                        usergroup:         usergroup,
                        
                    }, 
                    // beforeSend: function () {
                    //     $('#loader').show();
                    //     loaderTimeout = setTimeout(function () {
                    //         $('#loader').hide();
                    //     }, 3000);
                    // }, 

                },
                "order": [ [ 0, 'asc' ]],

                "scrollX": true,
                "fixedColumns":   {
                    "leftColumns": 1,
                    "rightColumns": 1,
                    "width": 200
                     
                    
                },

                "columnDefs": [{
                    "targets": [5,6,7,8,2,1],
                    "orderable": false,
                    "searchable": false,
                    "className": "text-left",
                },
                
                ]
            });

            // var tableWrapper = $("#dt-users-wrapper");
            // tableWrapper.find(".dataTables_length select").select2({
            //     showSearchInput: false //hide search box with special css class
            // }); // initialize select2 dropdown

                $('table#dt-users').on('click', 'a.action', function() {

                let [action, ids] = this.id.split('-');

                if (!$(this).parents('tr').hasClass('selected')) {
                    table.$('tr.selected').removeClass('selected');
                    $(this).parents('tr').addClass('selected');
                }

                if (action == "edit") {
                    $("div.emp-details").html('<img src="<?= base_url('uploads/profile-pic/1480.gif') ?>" alt="">');
                    $("div#editUserModal").modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });

                    
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('edituser_content'); ?>",
                        data : {
                            ids
                        },
                        
                        success: function(data) {
                            $("div.emp-details").show(); // Show the loader
                            $("div#edituser_content").html(data);
                        }
                    });
                }

                if (action == "edit2") {

                    $("div#editUserModal2").modal({
                        backdrop: 'static',
                        keyboard: true,
                        show: true
                    });

                    $("div.emp-details").html('<img src="<?= base_url('uploads/profile-pic/Fidget-spinner.gif') ?>" alt=""> <span>Please Wait...</span>');
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('edituser_content2'); ?>",
                        data : {
                            ids
                        },
                        success: function(data) {

                            $("div#edituser_content2").html(data);
                        }
                    });
                }

                if (action == "edit3") {

                    $("div#editUserModal3").modal({
                        
                        keyboard: true,
                        show: true
                    });

                    $("div.emp-details").html('<img src="<?= base_url('uploads/profile-pic/Fidget-spinner.gif') ?>" alt=""> <span>Please Wait...</span>');
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('userTasks_content'); ?>",
                        data : {
                            ids
                        },
                        success: function(data) {

                            $("div#userTasks_content").html(data);
                        }
                    });
                }

                
            });
        }    
    });

    function trimfield(str) 
    { 
        return str.replace(/^\s+|\s+$/g,''); 
    }

    function viewAddForm(emp_id) {

        $("div#addUserModal").modal({
            backdrop: 'static',
            keyboard: false,
            show: true
        });

        $("div.emp-details").html('<img src="<?= base_url('uploads/profile-pic/Fidget-spinner.gif') ?>" alt=""> <span>Please Wait...</span>');
        $.ajax({
            type: "POST",
            url: "<?= site_url('adduser_content'); ?>",
            data : {
                emp_id
            },
            success: function(data) {

                $("div#adduser_content").html(data);
            }
        });
    }

</script>

<!-- <script>
    $(document).ready(function() {
        function deacRequest() {
            $.ajax({
                url: '<?php echo site_url('employee/deac'); ?>',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    // Display success message
                    //$('#responseMessage').text(response.message).css('color', 'green');
                },
                error: function(xhr, status, error) {
                    // Display error message
                    $('#responseMessage').text('An error occurred. Please try again.').css('color', 'red');
                    //console.error(error);
                }
            });
        }

        $('#refreshButton').on('click', function() {
            deacRequest();
        });

        // //Automatically trigger the deactivaation logic on page load
        // deacRequest();
    }); 
</script> -->

<!-- <script>
    $(document).ready(function() {
        function autoUpdate() {
            $.ajax({
                url: '<?php echo site_url('employee/autoUpdateName'); ?>',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    // Display success message
                    //$('#responseMessage').text(response.message).css('color', 'green');
                },
                error: function(xhr, status, error) {
                    // Display error message
                    $('#responseMessage').text('An error occurred. Please try again.').css('color', 'red');
                    //console.error(error);
                }
            });
        }

        $('#refreshButton2').on('click', function() {
            autoUpdate();
        });

        // //Automatically trigger the deactivaation logic on page load
        // deacRequest();
    });
</script> -->

<script>
    $(document).ready(function() {
        function view() {
            $.ajax({
                url: '<?php echo site_url('employee/view'); ?>',
                method: 'POST',
                dataType: 'json',
                success: function(response) {
                    // Display success message
                    //$('#responseMessage').text(response.message).css('color', 'green');
                },
                error: function(xhr, status, error) {
                    // Display error message
                    //$('#responseMessage').text('An error occurred. Please try again.').css('color', 'red');
                    //console.error(error);
                }
            });
        }

        // $('#refreshButton').on('click', function() {
        //     deacRequest();
        // });

        //Automatically trigger the deactivaation logic on page load
        view();
    });
</script>
</html>
