<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            

            <h1><i class="fa fa-tasks" aria-hidden="true"></i>
                Manage Logs 
            </h1>

            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Logs</li>
                
            </ol>
        </section>
        <style type="text/css">

            @media print {
               table td:first-child {display:none}
               table th:first-child {display:none}
            }

            
           
        </style>

        

        <!-- Main content -->
        <section class="content">
           <div class="row">
                
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Requests Logs</h3>
                            <div style="color:red; padding-top: 10px;"><b> Note:</b> Click the request number to view the request's details</div>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="dt-logs" width="100%">
                                <thead>
                                    <tr role="row">
                                        
                                        <!-- <th style="display: none;"> ID</th> -->
                                        <th>Date/Time</th>
                                        <th>Type</th>
                                        <th>Request Number</th>
                                        <th >Details</th>

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
    var baseurl = "<?php echo base_url(); ?>";
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $("#rlogsSideNav").addClass('active');
  });
</script>
<!-- page script -->
<script>
    function confirmDialog() {
      return confirm("Are you sure you want to delete this record?")
    }
</script>

<script type="text/javascript">
$(document).ready(function() {
    //var table = $('table#dt-execute').removeAttr('width').DataTable({
    var table = $("table#dt-logs").DataTable({
        "destroy": true,
        'serverSide': true,
        'processing': true,
        "ajax": {
            url: "<?php echo site_url('admin/reqlogs_list'); ?>",
            type: "POST",
        },
        dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f>>r<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        //dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        // dom: '<'text-right'B><f>lrtip>',
        buttons: [
            'copy', 'csv', 'print'
        ],
        "order": [ [ 0, 'desc' ]],

        "columnDefs": [{
            "targets": [1,3],
            "orderable": false,   
        },
        // {
        //     "targets": [0],
        //     "className": "text-center",
        // },

        {   "searchable": false, 
            "targets": [0,2] 
        },
        ]
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

</body>
</html>
