<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/jquery-ui.min.css" />

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
                <li class="active">Requests</li>
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
           
        </style>

        <div id="addRfsModal" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px; ">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add RFS Form</b></h4>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return require_rfs();" action="<?php echo base_url('Request/rfs_create') ?>" id="addRequestRfs" method="post" enctype="multipart/form-data">
                            
                            <div id="rfs_content"></div>
                            <hr>
                               <label>Attachments (optional)</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>

                                <div style="border: solid #ddd 1px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <!-- <label>Browse a file &nbsp;</label>
                                    <label>
                                        <input type="file" name="upload_file1" id="upload_file1" readonly="true"/>
                                    </label> -->

                                    <label>Browse a file &nbsp;</label>
                                    <label>
                                        <input type="file" name="upload_file1" id="upload_file1" readonly="true"/>
                                    </label>
                                    <span id="fileSizeError" style="color: red; display: none;">File size exceeds 20MB.</span>
                                    <span id="fileSizeMessage"></span>


                                        
                                    <div id="moreImageUpload"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                
                                <br><br>
                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>         
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="addTorModal" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add TOR Form</b></h4>
                    </div>
                    <div class="modal-body">
                    <!-- <?php echo form_open('Request/tor_create'); ?>
                        <form method="post" >  -->
                        <form onsubmit="return require_tor();" action="<?php echo base_url('Request/tor_create') ?>" id="addRequestTor" method="post" enctype="multipart/form-data">
                            <div id="tor_content"></div>
                                <hr>
                               <label>Attachments (optional)</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>
                                <div style="border: solid #ddd 1px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <label>Browse a file &nbsp;</label>
                                    <label>
                                        <input type="file" name="upload_file2" id="upload_file2" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload2"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink2" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore2"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>
                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>
                        </form>
                        <br>
                        <div  id="leasing" >
                            <label style="color: red; font-size: 14px;"><b>For Leasing Usergroup:</b></label>
                            <p style="font-size: 14px;"> If requesting to change the <b> MONTHLY RENTAL </b> of tenant specify only the <b> Trade Name, Tenant ID, old Monthly Rental, new Monthly Rental </b> <br>
                            If requesting for change of <b> RENTAL RATE </b> of location specify : <b> Slot No/Location Code, Tenancy Type (Long Term/Short Term), Floor Location, Floor Area, Old Rental Rate, New Rental Rate </b></p>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>

                    
                </div>
            </div>
        </div>

        <div id="addIsrModal" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add ISR Form</b></h4>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return require_isr();" action="<?php echo base_url('Request/isr_create') ?>" id="addRequestIsr" method="post" enctype="multipart/form-data">
                            <div id="isr_content"></div>
                                <hr>
                               <label>Attachments (optional)</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>
                                <div style="border: solid #ddd 1px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <label>Browse a file &nbsp;</label>
                                    <label>
                                        <input type="file" name="upload_file3" id="upload_file3" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload3"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink3" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore3"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>

               
                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editRfsModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit RFS Form</b></h4>
                    </div>
                    <div class="modal-body">
                   
                        <form onsubmit="return require_update_rfs();" action="<?php echo base_url('Request/rfsupdate') ?>" id="editRfs" method="post" enctype="multipart/form-data">  
                            <div id="editrfs_content"></div>
                                <hr>
                                <label>Choose a file to add more file/s</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>
                                <div style="border: solid #ddd 0px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <!-- <label>Browse a file &nbsp;</label> -->
                                    <label>
                                        <input type="file" name="upload_file4" id="upload_file4" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload4"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink4" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore4"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>

                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editTorModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit TOR Form</b></h4>
                    </div>
                    <div class="modal-body">
                   
                        <form onsubmit="return require_update_tor();" action="<?php echo base_url('Request/torupdate') ?>" id="editTor" method="post" enctype="multipart/form-data">  
                            <div id="edittor_content"></div>
                                <hr>
                                <label>Choose a file to add more file/s</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>
                                <div style="border: solid #ddd 0px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <!-- <label>Browse a file &nbsp;</label> -->
                                    <label>
                                        <input type="file" name="upload_file5" id="upload_file5" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload5"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink5" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore5"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>
                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editIsrModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit ISR Form</b></h4>
                    </div>
                    <div class="modal-body">
                   
                        <form onsubmit="return require_update_isr();" action="<?php echo base_url('Request/isrupdate') ?>" id="editTor" method="post" enctype="multipart/form-data">  
                            <div id="editisr_content"></div>
                                <hr>
                                <label>Choose a file to add more file/s</label>
                                <p style="color: red;"><b>Note:</b> Max. file size is 20MB</p>
                                <div style="border: solid #ddd 0px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <!-- <label>Browse a file &nbsp;</label> -->
                                    <label>
                                        <input type="file" name="upload_file6" id="upload_file6" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload6"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink6" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore6"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>
                                <button type="submit" class="btn btn-primary" value="Submit"><i class="fa fa-save"></i> Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset"><i class="fa fa-close"></i> Reset</button>
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

                    <?php
                        if($type == 'RFS'){
                        echo'<div class="form-group" >
                            <a id="addRFS" class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addRfsModal" onclick=rfs_content()><i class="fa fa-plus" aria-hidden="true"></i> Add '.$type.'</a>
                            </div>';
                        }
                    ?>

                    <?php
                        if($type == 'TOR'){
                        echo'<div class="form-group">
                            <a id="addTOR" class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addTorModal" onclick=tor_content()><i class="fa fa-plus" aria-hidden="true"></i> Add '.$type.'</a>
                            </div>';
                        }
                    ?>

                    <?php
                        if($type == 'ISR'){
                        echo'<div class="form-group">
                            <a id="addISR" class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addIsrModal" onclick=isr_content()><i class="fa fa-plus" aria-hidden="true"></i> Add '.$type.'</a>
                            </div>';
                        }
                    ?>
                    
                </div>
            </div> 
            <div class="row" id="rfs">

                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title"><?= $type; ?>  Records List</h3>
                        </div>
                        
                        <?php
                        if($type == 'RFS'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group shadow-0" style="width:100%; text-align: center;">
                                    <input type="hidden" id="typeofrequest" name="typeofrequest" value="rfs">

                                    <a id="Pending" class="btn btn-primary status active">Pending</a>

                                    <a id="Approved" class="btn btn-default status">Completed</a>

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

                                    <a id="Approved" class="btn btn-default status">Completed</a>

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

                                    <a id="Approved" class="btn btn-default status">Completed</a>

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
                            <table class="table table-striped  table-bordered table-hover dataTable no-footer" id="dt-requests" width="100%">
                                <thead>
                                    <tr role="row">
                                        <!-- <th hidden="">ID</th> -->
                                        <th style="text-align: center;" >Control No.</th>
                                        <th >Transaction Date</th>
                                        <th >Requested To</th>
                                        <th >Company Name</th>
                                        <th >BU</th>
                                        <th style="width: 100px;">Purpose</th>
                                        <th >Processed by</th>
                                        <th >Status</th>
                                        <th style="width: 150px;">Actions</th>                                          
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
<!-- InputMask -->
    <script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?=base_url()?>assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>




<script type="text/javascript">
  $(document).ready(function() {
   
        <?php if($type == 'RFS') {  ?>
   
            $("#rfs_r").addClass('active');
        <?php } ?> 

        <?php if($type == 'TOR') {  ?>
   
            $("#tor_r").addClass('active');
        <?php } ?> 

        <?php if($type == 'ISR') {  ?>
   
            $("#isr_r").addClass('active');
        <?php } ?> 

         
    
    });
</script>
<script>
$(document).ready(function(){
    $("#addRFS").click(function(){
        $("#addRfsModal").modal({
            backdrop: "static",
            keyboard: true,
            show: false
        });
    });
    $("#addTOR").click(function(){
        $("#addTorModal").modal({
            backdrop: "static",
            keyboard: true,
            show: false
        });
    });
    $("#addISR").click(function(){
        $("#addIsrModal").modal({
            backdrop: "static",
            keyboard: true,
            show: false
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
                    $('.ui-datepicker').css('z-index', 99999999999999);
                }, 0);
            },
        });
    });

    function viewRequest(req_status, date_from, date_to) {
   
        var typeofrequest = document.getElementById("typeofrequest").value;
        // var table = $('table#dt-requests').removeAttr('width').DataTable({
        var table = $("table#dt-requests").DataTable({
            "destroy": true,
            'serverSide': true,
            'processing': true,
            //'responsive': true,
            "ajax": {
                url: "<?php echo site_url('requests/list'); ?>",
                type: "POST",
                data : {
                    status: req_status,
                    typeofrequest: typeofrequest,
                    date_from:date_from,
                    date_to:date_to
                }
            },
            "order": [ [ 0, 'desc' ]],

            "scrollX": true,
            "fixedColumns":   {
                "leftColumns": 1,
                "rightColumns": 1,
                "width": 200 
                
            },

            "columnDefs": [{
                "targets": [6 , 7, 8],
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

        $('table#dt-requests').on('click', 'a', function() {

            let [action, ids] = this.id.split('-');

            if (!$(this).parents('tr').hasClass('selected')) {
                table.$('tr.selected').removeClass('selected');
                $(this).parents('tr').addClass('selected');
            }

            if (action == "RFS") {

                $("div#editRfsModal").modal({
                    backdrop: "static",
                    keyboard: true,
                    show: false
                });

            }

            if (action == "TOR") {

                $("div#editTorModal").modal({
                    backdrop: "static",
                    keyboard: true,
                    show: false
                });

            }

            if (action == "ISR") {

                $("div#editIsrModal").modal({
                    backdrop: "static",
                    keyboard: true,
                    show: false
                });

            }
        });
    }

</script>


<!-- page script -->
<script>
    $(".btn-group > .btn").click(function(){
        $(".btn-group > .btn").removeClass("active");
        $(this).addClass("active");
    });

</script>

<script type="text/javascript">
  $(document).ready(function() {
   
        $("#requestSideTree").addClass('active'); 
  });
</script>
<!-- $("#navMenus").on('click', 'li', function () {
    $("#navMenus li.active").removeClass("active");
    // adding classname 'active' to current click li 
    $(this).addClass("active");
    }); -->
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
    

    <?php if($this->session->flashdata('SUCCESSMSG')) { ?>
        swal_message('success','Request Successfully Added!');
    <?php } ?>

    <?php if($this->session->flashdata('SUCCESSMSG1')) { ?>
        swal_message('success','Request Successfully Updated!');
    <?php } ?>
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        // $('#attachMore').click(function() {
        //     //add more file
        //     var moreUploadTag = '';
        //     moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
        //     moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files1' + upload_number + '" name="upload_files1' + upload_number + '"/></label>';
        //     moreUploadTag += '&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
        //     $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
        //     upload_number++;
        // });

        $('#attachMore').click(function() {
        //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file' + upload_number + '">Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files1' + upload_number + '" name="upload_files1' + upload_number + '" onchange="checkFileSize(this)"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';

            // Append the new file input element to the container
            $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
            upload_number++;
        });
    });
</script>
<script type="text/javascript">
    function del_file(eleId) {
        var ele = document.getElementById("delete_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    function del_file2(eleId) {
        var ele = document.getElementById("delete_file2" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    function del_file3(eleId) {
        var ele = document.getElementById("delete_file3" + eleId);
        ele.parentNode.removeChild(ele);
    }
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
        $('#attachMore2').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files2' + upload_number + '" name="upload_files2' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file2(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file2' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload2');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore3').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files3' + upload_number + '" name="upload_files3' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file3(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file3' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload3');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore4').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files4' + upload_number + '" name="upload_files4' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file4(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
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
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files5' + upload_number + '" name="upload_files5' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file5(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
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
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files5' + upload_number + '" name="upload_files5' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file6(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file6' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload6');
            upload_number++;
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Check file inputs on page load
        checkFileInputs();

        // Add event listeners to file inputs
        $('#upload_file1, #upload_file2, #upload_file3, #upload_file4, #upload_file5, #upload_file6').on('change', function() {
            checkFileInputs();
        });

        function checkFileInputs() {
            
            function checkFileSize(input, link) {
                var files = input[0].files;

                // Check if files are selected and not empty
                if (files && files.length > 0) {
                    var fileSize = files[0].size; // Size in bytes
                    var maxSize = 20 * 1024 * 1024; // 20MB in bytes

                    // Display file size
                    $('#fileSizeMessage').text(formatBytes(fileSize));
                    
                    if (fileSize > maxSize) {
                        //$('#fileSizeError').show(); // Display error message
                        console.log(fileSize);
                        console.log(maxSize);
                        console.log('yes');
                            Swal.fire('Oops!', 'File size exceeded 20mb', 'error') 

                        input.val(''); // Clear the selected file
                        link.hide(); // Hide the "more" link
                    } else {
                        $('#fileSizeError').hide(); // Hide error message
                        if (input.val() !== '') {
                            link.show(); // Show the "more" link if a file is selected
                        } else {
                            link.hide(); // Hide the "more" link if no file is selected
                        }
                    }
                } else {
                    // Handle case where no file is selected
                    $('#fileSizeMessage').text('');
                    $('#fileSizeError').hide(); // Hide error message
                    link.hide(); // Hide the "more" link
                }
            }


            function formatBytes(bytes) {
                if (bytes === 0) return '0 Bytes';
                var k = 1024;
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Check upload_file1
            var fileInput1 = $('#upload_file1');
            var moreFileLink1 = $('#moreImageUploadLink');
            checkFileSize(fileInput1, moreFileLink1);

            // Check upload_file2
            var fileInput2 = $('#upload_file2');
            var moreFileLink2 = $('#moreImageUploadLink2');
            checkFileSize(fileInput2, moreFileLink2);

            // Check upload_file3
            var fileInput3 = $('#upload_file3');
            var moreFileLink3 = $('#moreImageUploadLink3');
            checkFileSize(fileInput3, moreFileLink3);

            // Check upload_file4
            var fileInput4 = $('#upload_file4');
            var moreFileLink4 = $('#moreImageUploadLink4');
            checkFileSize(fileInput4, moreFileLink4);

            // Check upload_file5
            var fileInput5 = $('#upload_file5');
            var moreFileLink5 = $('#moreImageUploadLink5');
            checkFileSize(fileInput5, moreFileLink5);

            // Check upload_file6
            var fileInput6 = $('#upload_file6');
            var moreFileLink6 = $('#moreImageUploadLink6');
            checkFileSize(fileInput6, moreFileLink6);
        }

    });
</script>
</body>
</html>
