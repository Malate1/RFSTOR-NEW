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
                <li class="active">Approve</li>
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
           <div class="row">
                
            </div> 
            <div class="row">

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= $type; ?>  Records List</h3>
                        </div>
                        <input type="hidden" id="usertype" name="usertype" value="Approve">
                        <?php
                        if($type == 'RFS'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <input type="hidden" id="typeofrequest" name="typeofrequest" value="rfs">

                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Approved</a>

                                    <a id="Cancelled" class="btn btn-default status">Disapproved/Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if($type == 'TOR'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                     <input type="hidden" id="typeofrequest" name="typeofrequest" value="tor">

                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Approved</a>

                                    <a id="Cancelled" class="btn btn-default status">Disapproved/Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        if($type == 'ISR'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                     <input type="hidden" id="typeofrequest" name="typeofrequest" value="isr">

                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Approved</a>

                                    <a id="Cancelled" class="btn btn-default status">Disapproved/Cancelled</a>
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
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="dt-approve" width="100%" >
                                <thead>
                                    <tr role="row">
                                        <!-- <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th> -->
                                        <th style="text-align: center;" >Control No.</th>
                                        <th >Transaction Date</th>
                                        <th >Requested To</th>
                                        <th >Company</th>
                                        <th >BU</th>
                                        <th >Requested By</th>
                                        <th style="width: 100px;">Purpose</th>
                                        <th >Processed by</th>
                                        <th >Status</th>
                                        <th style="width:220px; text-align: center;">Actions</th>                                          
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
   
            $("#rfs_a").addClass('active');
        <?php } ?> 

        <?php if($type == 'TOR') {  ?>
   
            $("#tor_a").addClass('active');
        <?php } ?> 

        <?php if($type == 'ISR') {  ?>
   
            $("#isr_a").addClass('active');
        <?php } ?>  
    
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
        var table = $('table#dt-approve').removeAttr('width').DataTable({
        //var table = $("table#dt-requests").DataTable({
        // var table = $('table#dt-approve').DataTable({
            "destroy": true,
            'serverSide': true,
            'processing': true,
            "ajax": {
                url: "<?php echo site_url('approve/list'); ?>",
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

            "scrollX": true,
            "fixedColumns":   {
                "leftColumns": 1,
                "rightColumns": 1,
                "width": 200 
                
            },

            "select": {
                "style": 'os',
                "selector": 'td:first-child'
            },

            "columnDefs": [{
                "targets": [6,7,8,9],
                "orderable": false,
                
            },
            {
                "targets": [0],
                "className": "text-center",
            },

            // {
            //     "orderable": false,
            //     "className": 'select-checkbox',
            //     "targets": 0
            // },

            {   "searchable": false, 
                "targets": 1 
            },
            ]
        });

        $('table#dt-approve').on('click', 'a', function() {

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
                    backdrop: 'static',
                    keyboard: true,
                    show: false
                });

            }

            if (action == "ISR") {

                $("div#ApproveIsrModal").modal({
                    backdrop: 'static',
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

        // table.on("click", "th.select-checkbox", function() {
        //     if ($("th.select-checkbox").hasClass("selected")) {
        //         table.rows().deselect();
        //         $("th.select-checkbox").removeClass("selected");
        //     } else {
        //         table.rows().select();
        //         $("th.select-checkbox").addClass("selected");
        //     }
        // }).on("select deselect", function() {
        //     ("Some selection or deselection going on")
        //     if (table.rows({
        //             selected: true
        //         }).count() !== table.rows().count()) {
        //         $("th.select-checkbox").removeClass("selected");
        //     } else {
        //         $("th.select-checkbox").addClass("selected");
        //     }
        // });
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
    
    $("#approveSideTree").addClass('active');
    
  });
</script>
<script>
    var baseurl = "<?php echo base_url(); ?>";
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
            position: 'center',
            showConfirmButton: true,
            
            });

            $('.swalDefaultSuccess').fadeIn(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Remarks Succcessfully Added '
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
            
            });

            $('.swalDefaultSuccess').fadeIn(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Remarks Succcessfully Updated '
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
