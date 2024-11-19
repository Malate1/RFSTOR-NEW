<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- <div style="color:#3c8dbc" align="right" id="todaysDate"></div> -->

            <h1><i class="fa fa-briefcase" aria-hidden="true"></i>
                Manage Requests 
            </h1>
            <ol class="breadcrumb">
                <li ><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
                <li >Execute</li>
                <?php  
                    echo'<li class="active">'.$type.'</li>';  
                ?>
                
                
            </ol>
        </section>
        <style type="text/css">

            @media print {
               table td:last-child {display:none}
               table th:last-child {display:none}
            }

            .thumb{
                margin: 24px 5px 20px 0;
                width: 150px;
                float: left;
            }

            td.dtfc-fixed-right {
                width: 220px;
/*                text-align: center;*/
            }
           
        </style>

        <!-- Main content -->
        <section class="content">
           <div  class="row">
                <!-- <div class="col-xs-12 text-left">
                    <div class="form-group" >
                        <a class="btn btn-primary swalDefaultError swalDefaultSuccess" ><i class="fa fa-plus" aria-hidden="true"></i> Add </a>
                    </div>
                </div> -->
            </div> 
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= $type; ?>  Records List</h3>
                        </div>
                        <input type="hidden" id="usertype" name="usertype" value="Execute">
                        <?php
                        if($type == 'RFS'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <input type="hidden" id="typeofrequest" name="typeofrequest" value="rfs">

                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Executed</a>

                                    <a id="Cancelled" class="btn btn-default status">Cancelled</a>

                                    
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if($type == 'TOR'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <input type="hidden" id="typeofrequest" name="typeofrequest" value="tor">
                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Executed</a>

                                    <a id="Cancelled" class="btn btn-default status">Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if($type == 'ISR'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <input type="hidden" id="typeofrequest" name="typeofrequest" value="isr">
                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Executed</a>

                                    <a id="Cancelled" class="btn btn-default status">Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <div style="padding: 0px 10px 10px 10px" class="box-body ">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label for="date_from">Date From</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                            <input type="text" name="date_from" class="form-control input-sm datepicker" autocomplete="off">
                                    </div>
                                    
                                </div>
                                <div class="col-xs-3">
                                    <label for="date_to">Date To</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                            <input type="text" name="date_to" class="form-control input-sm datepicker" autocomplete="off">
                                    </div>
                                    
                                </div>

                                <div class="col-xs-1" style="margin-top: 22px;">
                                    <button id="clear-date" class="btn btn-warning " ><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <br>
                            <?php
                                if($this->session->user_id == '1'){ ?>
                                    <div class="row" style="padding-right: 15px; text-align: right;">
                                        <button id="approve-status-btn" class="btn btn-primary">Approve Status</button>
                                    </div>

                                    
                                    
                                    <div id="responseMessage"></div>
                            <?php } ?>    
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="dt-execute" >
                            <!-- <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="editable_table" width="100%" > -->
                                <thead>
                                    <tr role="row">
                                        
                                        <th style="text-align: center;" >Control No.</th>
                                        <th >Transaction Date</th>
                                        <th >Requested To</th>
                                        <th >Company</th>
                                        <th >BU</th>
                                        <th >Requested By</th>
                                        <th style="width: 200px;">Purpose</th>
                                        <th >Processed by</th>
                                        <th >Status</th>
                                        <th style="width:220px;">Actions</th>                                          
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

<script type="text/javascript">
  $(document).ready(function() {
   
        <?php if($type == 'RFS') {  ?>
   
            $("#rfs_e").addClass('active');
        <?php } ?> 

        <?php if($type == 'TOR') {  ?>
   
            $("#tor_e").addClass('active');
        <?php } ?> 

        <?php if($type == 'ISR') {  ?>
   
            $("#isr_e").addClass('active');
        <?php } ?> 

         
    
    });
</script>

<script>
    $(document).ready(function() {
        $('#approve-status-btn').click(function() {
            $.ajax({
                url: '<?php echo site_url('execute/update_status_to_approve'); ?>',  
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        alert(response.message);
                        // You can reload the page or update the UI here
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Error occurred while updating status.');
                }
            });
        });
    });
</script>

<script>

    $(document).ready(function(){
            
        var status = $("a.active").attr('id');
        let dateFrom = $("input[name = 'date_from']").val();
        let dateTo = $("input[name = 'date_to']").val();

        viewRequest(status, dateFrom, dateTo);

        $("a.status").click(function() {

            $("a.btn-primary").removeClass('btn-primary').addClass('btn-default');
            $(this).addClass('btn-primary');
            let status = this.id;
            let dateFrom = $("input[name = 'date_from']").val();
            let dateTo = $("input[name = 'date_to']").val();
            viewRequest(status, dateFrom, dateTo);
        });

        $("input[name = 'date_to']").change(function() {

            var status = $("a.active").attr('id');
            let dateFrom = $("input[name = 'date_from']").val();
            let dateTo = $(this).val();
            viewRequest(status, dateFrom, dateTo);
        });

        $("button#clear-date").click(function() {
            $("input[name = 'date_from']").val('');
            $("input[name = 'date_to']").val('');
            var status = $("a.active").attr('id');
            let dateFrom = $("input[name = 'date_from']").val();
            let dateTo = $(this).val();
            viewRequest(status, dateFrom, dateTo);
        });

        $('.datepicker').datepicker({
            //comment the beforeShow handler if you want to see the ugly overlay
            changeMonth:true,
            changeYear:true,
            
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 9999999999999);
                }, 0);
            },
        });
    });

    function viewRequest(req_status, date_from, date_to) {
   
        var typeofrequest = document.getElementById("typeofrequest").value;
        var usertype      = document.getElementById("usertype").value;
        var table = $('table#dt-execute').removeAttr('width').DataTable({
        // var table = $("table#dt-execute").DataTable({
            "destroy": true,
            'serverSide': true,
            'stateSave' : true,
            'processing': true,
            // 'responsive': true,
            "ajax": {
                url: "<?php echo site_url('execute/list'); ?>",
                type: "POST",
                data : {
                    status:         req_status,
                    typeofrequest:  typeofrequest,
                    usertype:       usertype,
                    date_from:      date_from,
                    date_to:        date_to
                }
            },
            "order": [ [ 0, 'desc' ]],
            'scrollCollapse': true,
            'scrollY': '60vh',
            "scrollX": true,
            "fixedColumns":   {
                "leftColumns": 1,
                "rightColumns": 1,
                "width": 200 
                
            },

            "columnDefs": [{
                "targets": [6,7,8,9],
                "orderable": false,
                
            },
            {
                "targets": [0],
                "className": "text-center",
            },

            {   "searchable": false, 
                "targets": 1 
            },
            ]
        });

        $('table#dt-execute').on('click', 'a', function() {

            let [action, ids] = this.id.split('-');

            if (!$(this).parents('tr').hasClass('selected')) {
                table.$('tr.selected').removeClass('selected');
                $(this).parents('tr').addClass('selected');
            }

            if (action == "RFS") {

                $("div#ApproveRfsModal").modal({
                    backdrop: 'static',
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
                    backdrop: 'static',
                    keyboard: true,
                    show: false
                });

            }

            if (action == "rem2") {

                $("div#editRemarksModal").modal({
                    backdrop: 'static',
                    keyboard: true,
                    show: false
                });

            }
        });
    }

</script>

<script>
    $(".btn-group > .btn").click(function(){
        $(".btn-group > .btn").removeClass("active");
        $(this).addClass("active");
    });

</script>

<script type="text/javascript">
  $(document).ready(function() {
    
    $("#executeSideTree").addClass('active');

    $("#executeSideMenuRFS").click(function () {
        $("#executeSideMenuRFS").removeClass("active");
        $(this).addClass("active");
    });
    
  });
</script>

<!-- page script -->
<script>
    function confirmDialog() {
      return confirm("Are you sure you want to delete this record?")
    }

    
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
                    title: 'Request Succcessfully Added '
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
                    title: 'Request Succcessfully Updated '
                })
            });
        });
    <?php } ?>
</script>


<script type="text/javascript">
    function del_file4(eleId) {
        var ele = document.getElementById("delete_file4" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    function del_file5(eleId) {
        var ele = document.getElementById("delete_file5" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    function del_file6(eleId) {
        var ele = document.getElementById("delete_file6" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore4').click(function() {
            //add more file
            var moreUploadTag = '0';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files4' + upload_number + '" name="upload_files4' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file4(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file4' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload4');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore5').click(function() {
            //add more file
            var moreUploadTag = '0';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files5' + upload_number + '" name="upload_files5' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file5(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file5' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload5');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore6').click(function() {
            //add more file
            var moreUploadTag = '0';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files5' + upload_number + '" name="upload_files5' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file6(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file6' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload6');
            upload_number++;
        });
    });
</script>


</body>
</html>
