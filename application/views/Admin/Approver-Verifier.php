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

            <!-- <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Admin Setup</li>
                <li class="active">Pending Requests</li>
            </ol> -->
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
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Approver/Verifier per Group</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group ">
                                        <form class="form-horizontal">
                                            <label for="usergroup">User Group:</label>
                                            <select style="width: 100%; padding:5px;" class="form-control select-group" name="usergroup" id="usergroup">
                                                ;'
                                                <?php
                                                $data1 = $this->Admin_Model->getUserGroup();

                                                foreach ($data1 as $value) {?>
                                                    <option value="<?=$value->group_id?>"> <?=$value->groupname?> </option>
                                               <?php } ?>
                                            </select>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-xs-3">
                                    <div class="form-group ">
                                        <form class="form-horizontal">
                                            <label for="user_type">User Type:</label>
                                            <select style="width: 100%; padding:5px;" class="form-control select-type" name="user_type" id="user_type">
                                                <!-- <option></option> -->
                                                <option value="3">Approver</option>
                                                <option value="6">Verifier</option>
                                                <option value="4">Executer</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                               
                            </div>

                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="dt-usertype" >
                                <thead>
                                    <tr role="row">
                                        
                                        <th >Name</th>
                                        <th >Job Position</th>
                                        <th>Business Unit</th>                                          
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
<!-- page script -->
<script>
    $(document).ready(function(){
            
        let usergroup = $('#usergroup').select2("val");
        let typeofuser = $('#user_type').select2("val");
            // let dateFrom = $("input[name = 'date_from']").val();
            // let dateTo = $(this).val();
        viewPendingRequest(usergroup,typeofuser);

        
        $('select').on('change', function() {
            let usergroup = $('#usergroup').select2("val");
            let typeofuser = $('#user_type').select2("val");
            viewPendingRequest(usergroup,typeofuser);
        });

    });

    function viewPendingRequest(usergroup,typeofuser) {
   
        //var typeofuser = document.getElementById("typeofuser").value;
        //var usertype      = document.getElementById("usertype").value;
        var table = $('table#dt-usertype').removeAttr('width').DataTable({
            "destroy": true,
            'serverSide': true,
            'processing': true,
            // 'responsive': true,
            "ajax": {
                url: "<?php echo site_url('Admin/approvers_list'); ?>",
                type: "POST",
                data : {
                    usergroup:         usergroup,
                    typeofuser:              typeofuser,
                }
            },

            "order": [ [ 0, 'desc' ]],

            "scrollX": true,
            "fixedColumns":   {
                "leftColumns": 1,
                "rightColumns": 1,
                "width": 200
            },

            "columnDefs": [
                {
                    "targets": [6, 7, 8,9],
                    "orderable": false,
                },
                {
                    "targets": [0],
                    "className": "text-center",
                },
                {
                    "searchable": false,
                    "targets": 1
                },
                
            ]
        });


        $('table#dt-usertype').on('click', 'a', function() {

            let [action, ids] = this.id.split('-');

            if (!$(this).parents('tr').hasClass('selected')) {
                table.$('tr.selected').removeClass('selected');
                $(this).parents('tr').addClass('selected');
            }

            if (action == "RFS") {

                $("div#ApproveRfsModal").modal({
                    backdrop: true,
                    keyboard: true,
                    show: false
                });

            }

            if (action == "TOR") {

                $("div#ApproveTorModal").modal({
                    backdrop: true,
                    keyboard: true,
                    show: false
                });

            }

            if (action == "ISR") {

                $("div#ApproveIsrModal").modal({
                    backdrop: true,
                    keyboard: true,
                    show: false
                });

                
            }

            if (action == "rem1") {

                $("div#addRemarksModal").modal({
                    backdrop: true,
                    keyboard: true,
                    show: false
                });

            }

            if (action == "rem2") {

                $("div#editRemarksModal").modal({
                    backdrop: true,
                    keyboard: true,
                    show: false
                });

            }
        });
    }
</script>

<script type="text/javascript">
  $(document).ready(function() {
   
    $("#adminSideTree").addClass('active');
    $("#pending-r").addClass('active');
    
  });


</script>

<script>
                
    $(".select-group").select2({
        placeholder: "Select a user group",
        allowClear: true
    });

    $(".select-type").select2({
        placeholder: "Select a user type",
        allowClear: true
    });

</script>
</body>
</html>
