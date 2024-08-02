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
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Users Record List</h3><br>

                        <div style="color:red; padding-top: 10px;"><b> Note:</b> Click the user's name to view the user's tasks</div>
                        </div>

                        <div style="padding: 0px 10px 10px 10px" class="box-body ">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group ">
                                        <center>
                                            <form id="inputForm" class="form-inline mb-3" method="POST" action="#">
                                                <div class="form-group mr-2">
                                                    <label for="ded_date" class="mr-5">Deduction Date:</label>
                                                    <input type="date" id="ded_date" name="ded_date" class="form-control">
                                                </div>
                                                <div class="form-group mr-2">
                                                    <label for="emp_id" class="mr-5">Employee :</label>
                                                    <input type="search" id="emp_id" name="emp_id" class="form-control" size="40" placeholder="Search Employee">
                                                </div>
                                                <button type="submit" class="btn btn-primary" id="viewButton"><i class="fa fa-eye"></i> View</button>
                                            </form>
                                        </center>

                                    </div>
                                    
                                </div>
                               
                            </div>
                           
                            <table class="table table-responsive table-striped  table-bordered table-hover dataTable no-footer" id="deduct" width="100%" >
                                <thead>
                                    <tr role="row" align="center">
                                        
                                        <th style="width:200px; text-align: center;" >Deduction Type</th>
                                        <th style="text-align: center;">Debit</th>
                                        <th style="text-align: center;">Credit</th>
                                        <th style="text-align: center;">Balance</th>
                                                                                
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <td colspan="3" style="text-align:right"><strong>Total:</strong></td>
                                        <td style="text-align: center; font-weight: bold;" id="totalBalance"> </td>
                                    </tr>
                                </tfoot>
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
<script >
    
    $("input[name='emp_id']").autocomplete({
        source: function(request, response) {
            $.get("<?= site_url('employee/search_incharge'); ?>", {
                query: request.term
            }, function(data) {
                data = JSON.parse(data);
                response(data);
            });
        },
        select: function(event, ui) {
            $(this).val(`${ui.item.emp_id} - ${ui.item.name}`);
            $(this).data('id', ui.item.emp_id);
            return false;
        }
    }).autocomplete("instance")._renderItem = function(ul, item) {
        return $("<li>")
            .append(`<div>${item.emp_id} - ${item.name}</div>`)
            .appendTo(ul);
    };

    
    var table = $('#deduct').DataTable({
        "serverSide": true,
        "scrollCollapse": true,
        "scrollY": '50vh',
        "lengthMenu": [ [10, 25, 50, 100, 10000], [10, 25, 50, 100, "Max"] ],
        "pageLength": 10,
        "ajax": {
            "url": "<?= base_url('Admin/view_deduction_date'); ?>",
                "type": "POST",
                "data": function (d)  {
                    d.ded_date = $('#ded_date').val();
                    d.emp_id = $('#emp_id').data('id');
                }
            },
            "columns": [
                { "data": "ldg_type" },
                { "data": "ldg_debit" },
                { render : function(data, type ,row){
                    if (row.ldg_credit == null){
                        return '0.00';
                    }else{
                        return row.ldg_credit;
                    } 
                }},
                { "data": "ldg_balance" }
            ],
            "columnDefs": [
                { "targets": "_all", "className": "text-center" },
            ],
        });

        function updateTotalBalance() {
            $.ajax({
                url: '<?= base_url('Admin/sum_ldg_balance'); ?>', // Replace with your API endpoint to get the sum of ldg_balance
                type: 'POST',
                data: {
                    ded_date: $('#ded_date').val(),
                    emp_id: $('#emp_id').data('id')
                },
                dataType: 'json',
                success: function(data) {
                    console.log('Received data:', data);
                    if (data && data.total_balance !== undefined) {
                let totalBalance = data.total_balance !== null ? parseFloat(data.total_balance).toFixed(2) : '0.00';
                $('#totalBalance').text(totalBalance);
            } else {
                        console.error('Unexpected response format:', data);
                        $('#totalBalance').text('Error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching total balance:', xhr.responseText);
                    $('#totalBalance').text('Error');
                }
            });
        }

        // Update the total balance initially
        updateTotalBalance();

        // Update the total balance when the table is reloaded
        table.on('draw', function() {
            updateTotalBalance();
        });

        $('#viewButton').click(function (event) {
            event.preventDefault();

            var ded_date = $('#ded_date').val();
            var emp_id = $('#emp_id').data('id');

            if (!emp_id && !ded_date) {
                Swal.fire({
                    title: 'Input Error',
                    text: 'Please select a sales date to view.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            table.ajax.reload(function (json) {
                if (json.data.length === 0) {
                    Swal.fire({
                        title: 'No Records Found',
                        text: 'No records found .',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }else{
                    Swal.fire({
                        title: 'Data Found',
                        text: 'Records found for the selected sales date and officer in charge.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                }

            });
        });



</script>
</html>
