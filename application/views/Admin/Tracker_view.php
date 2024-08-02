<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            

            <h1><i class="fa fa-tasks" aria-hidden="true"></i>
                Manage Requests 
            </h1>

            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Tracker</li>
                
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
                <div class="col-xs-12 text-left">

                    <?php
                        if($type == 'RFS'){
                        echo'<div class="form-group" >
                            <a class="btn btn-primary " data-toggle="modal" data-target="#rfsTracker"><i class="fa fa-search" aria-hidden="true"></i> Track ' .$type.'</a>
                            </div>';
                        }
                    ?>

                    <?php
                        if($type == 'TOR'){
                        echo'<div class="form-group" >
                            <a class="btn btn-primary " data-toggle="modal" data-target="#torTracker"><i class="fa fa-search" aria-hidden="true"></i> Track ' .$type.'</a>
                            </div>';
                        }
                    ?>

                    <?php
                        if($type == 'ISR'){
                        echo'<div class="form-group" >
                            <a class="btn btn-primary " data-toggle="modal" data-target="#"><i class="fa fa-search" aria-hidden="true"></i> Track ' .$type.'</a>
                            </div>';
                        }
                    ?>
                    
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">
                            Requests Tracker</h3>
                        </div>

                        <div class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="dt-logs" width="100%">
                                <thead>
                                    <tr role="row">
                                        
                                        <th style="display: none;"> ID</th>
                                        <th>Request Number</th>
                                        <th>Date Requested</th>
                                        <th>Date Approved</th>
                                        <th>Date Executed</th>
                                        <th>Date Cancelled</th>
                                                                          
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($getTracker))

                                {
                                    foreach ($getTracker as $value)
                                    { ?>
                                    <tr>
                                        <td style="display: none;"><?=$value->id?></td> 
                                        <td style="color: red; font-weight: bold"><?=$value->requestnumber?></td>
                                        
                                        <td ><?=date("D • h:i:s A • M. d, Y ",strtotime($value->datetoday))?></td> 
                                        <?php
                                            
                                            if($value->approvedby == '0'){
                                                echo'<td> Not yet approved </td>';

                                            }else{

                                                echo'<td>'.date("D • h:i:s A • M. d, Y ",strtotime($value->date_approved)).'</td>';
                                            }
                                            if($value->executedby == '0'){
                                                echo'<td> Not yet executed </td>';

                                            }else{

                                                echo'<td>'.date("D • h:i:s A • M. d, Y ",strtotime($value->date_executed)).'</td>';
                                            }
                                            if($value->cancelledby == '0'){
                                                echo'<td> N/A </td>';

                                            }else{

                                                echo'<td>'.date("D • h:i:s A • M. d, Y ",strtotime($value->date_cancelled)).'</td>';
                                            }?>
                                        
                                        
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

<script type="text/javascript">
  $(document).ready(function() {
    $("#trackerSideTree").addClass('active');
  });
</script>
<!-- page script -->
<script>
    function confirmDialog() {
      return confirm("Are you sure you want to delete this record?")
    }

$(document).ready(function() {
    var table = $('#editable_table1');
    table.DataTable({
        dom: "<'text-right'B><f>lr<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        buttons: [
            'copy', 'csv', 'print'
        ],
        "order": [[ 0, "desc" ]],
        'processing': true,
        "columnDefs": [{
                "targets": [2],
                "orderable": false,
                
            },
            {
                "targets": [0],
                "className": "text-center",
            },

            {   "searchable": false, 
                "targets": [0,1] 
            },
            ]
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
    //var table = $('table#dt-execute').removeAttr('width').DataTable({
    var table = $("table#dt-logs").DataTable({
        "destroy": true,
        
        'processing': true,
        //'responsive': true,
        //dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f>>r<'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        //dom: "<'text-right'B><'row'<'col-md-5 col-12'l><'col-md-7 col-12'f><'table-responsive't><'row'<'col-md-5 col-12'i><'col-md-7 col-12'p>>",
        // dom: '<'text-right'B><f>lrtip>',
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "order": [ [ 0, 'desc' ]],

        "columnDefs": [{
            "targets": [2],
            "orderable": false,   
        },
        {
            "targets": [0],
            "className": "text-center",
        },

        {   "searchable": false, 
            "targets": [0,1] 
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
