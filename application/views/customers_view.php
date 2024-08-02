<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Serverside Datatable Codeigniter Custom Filter</title>
    <link href="<?php echo base_url('asset2/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('asset2/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 

<body>
    <div class="container">
        <h1 style="font-size:20pt">Simple Serverside Datatable Codeigniter Custom Filter</h1>

        <h3>Customers Data</h3>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title" >Custom Filter : </h3>
            </div>
            <div class="panel-body">
                <form id="form-filter" class="form-vertical">
                    <div class="form-group">
                        <label for="country" class="col-sm-2 control-label">Country</label>
                        <div class="col-sm-4">
                            <?php echo $form_country; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="FirstName" class="col-sm-2 control-label">First Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="FirstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Last Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="LastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" id="address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Actions</th>
                    
                    
                </tr>
            </thead>
            <tbody>

            </tbody>

            <tfoot>
                <tr>
                    <th>No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Actions</th>
                               
                </tr>
            </tfoot>
        </table>
    </div>

    <div id="editUserModal" class="modal fade" role="dialog">
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit User Form</b></h4>
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

<script src="<?php echo base_url('asset2/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?php echo base_url('asset2/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('asset2/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('asset2/datatables/js/dataTables.bootstrap.min.js')?>"></script>


<script type="text/javascript">

function edituser_content(ids){
    console.log(ids)
    // $("#editUserModal").modal("show");
    $.ajax({
        url: 'edituser_content',
        type: 'POST',
        data: {ids:ids},
        error: function() {
            alert('Something is wrong');
        },
        success: function(data) {                 
            $("#edituser_content").html(data);
        }
    }); 
}
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('customers/ajax_list')?>",
            "type": "POST",
            "data": function ( data ) {
                data.country = $('#country').val();
                data.FirstName = $('#FirstName').val();
                data.LastName = $('#LastName').val();
                data.address = $('#address').val();
            }
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],

    });

    $('#btn-filter').click(function(){ //button filter event click
        table.ajax.reload();  //just reload table
    });
    $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table
    });

});

</script>

</body>
</html>