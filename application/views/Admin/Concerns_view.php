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
                <li class="active">Concerns</li>
                <?php  
                    echo'<li class="active">'.$type.'</li>';  
                ?>
                <?php  
                    if($status == 'Approved'){
                        echo'<li class="active">Completed</li>'; 
                    }else{
                        echo'<li class="active">'.$status.'</li>'; 
                    }
                ?>
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

        <div id="addConcernModal" class="modal fade" role="dialog" >
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Add Concerns Form</b></h4>
                    </div>
                    <div class="modal-body">
                        <form onsubmit="return require_concern();" action="<?php echo base_url('Request/concern_create') ?>" id="addRequestConcern" method="post" enctype="multipart/form-data">
                            
                            <div id="concern_content"></div>
                            <hr>
                                <label>Attachments</label>
                                <div style="border: solid #ddd 1px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <label>Browse a file &nbsp;</label>
                                    <label>
                                        <input type="file" name="upload_file7" id="upload_file7" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload7"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink7" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore7"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                
                                <br><br>
                                <button type="submit" name="file_upload" class="btn btn-primary" value="Submit">Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset">Reset</button>         
                        </form>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div>

        <div id="editConcernModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content" style="border-radius: 10px">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button> 
                        <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                    <h4 style="text-align: center;" class="modal-title"><b>Edit Concerns Form</b></h4>
                    </div>
                    <div class="modal-body">
                   
                        <form onsubmit="return require_concern();" action="<?php echo base_url('Request/concernupdate') ?>" id="editConcern" method="post" enctype="multipart/form-data">  
                            <div id="editconcern_content"></div>
                                <hr>
                                <label>Choose a file to add more file/s</label>
                                <div style="border: solid #ddd 0px; padding: 10px; margin-bottom: 10px" class="col-md-12">
                                    <!-- <label>Browse a file &nbsp;</label> -->
                                    <label>
                                        <input type="file" name="upload_file8" id="upload_file8" readonly="true"/>
                                    </label>
                                        
                                    <div id="moreImageUpload8"></div>
                                    <div style="clear:both;"></div>
                                    <div style="padding-top: 10px;" id="moreImageUploadLink8" >
                                        <a  class="btn btn-default btn-sm" href="javascript:void(0);" id="attachMore8"><i class="fa fa-plus" aria-hidden="true"></i> Add more file</a>
                                    </div>
                                    <!-- <div id="uploadPreview"></div> -->
                                </div>
                                <br><br>

                                <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
                                <button type="reset" class="btn btn-danger"  value="Reset">Reset</button>
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
                        if($type == 'Concern'){
                        echo'<div class="form-group">
                            <a class="btn btn-primary swalDefaultError swalDefaultSuccess" data-toggle="modal" data-target="#addConcernModal" onclick=concern_content()><i class="fa fa-plus" aria-hidden="true"></i> Add '.$type.'</a>
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
                        if($type == 'Concern'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('view-concern')?>">Pending</a>

                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('view-concern-completed')?>">Completed</a>

                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('view-concern-cancelled')?>">Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>

                        
                        <p style="color: red"><?php echo @$errors; ?> </p>
                        <div style="padding: 0px 10px 10px 10px" class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="editable_table" width="100%">
                                <thead>
                                    <tr role="row">
                                        <!-- <th hidden="">ID</th> -->
                                        <th style="text-align: center;" >Control No.</th>
                                        <th >Transaction Date</th>
                                        <th >Requested To</th>
                                        <th >Company Name</th>
                                        <th >BU</th>
                                        <th style="width: 150px;">Details</th>
                                        
                                        <?php
                                            if($status == 'Approved'){
                                                echo'<th>Executed by</th>';
                                            }

                                            if ($status == 'Cancelled') {
                                                echo'<th>Cancelled by</th>';
                                            }

                                            if ($status == 'Pending') {
                                                
                                            }
                                                    
                                        ?>
                                        
                                        <th >Status</th>
                                        <th style="width: 150px;">Actions</th>                                          
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(!empty($getRequest))
                                {
                                    foreach ($getRequest as $value)
                                    { ?>
                                    <tr>
                                        <!-- <td hidden=""><?=$value->id?></td> -->
                                        <td style="color: red; text-align: center; font-weight: bold"><?=$value->requestnumber?></td>
                                        <td><?=date("D • h:i:s A • M. d, Y ", strtotime($value->datetoday))?></td>
                                        <td><?=$value->groupname?></td>
                                        <td><?=$value->companyname?></td>
                                        <?php
                                          
                                           $bu = $this->Admin_Model->bu_name($value->buid);
                                        ?>
                                        <td><?=$bu->business_unit?></td>
                                        <td style="width: 150px;"><?=$value->details?></td>
                                            <?php
                                                $executedby = $this->Admin_Model->getUserData2($value->executedby);

                                                $cancelledby = $this->Admin_Model->getUserData2($value->cancelledby);

                                                // $name = explode(",", $executedby->name);
                                                // $fname = explode(" ", $name[1]);
                                                // $c = $fname[1]." ".$name[0];
                                                if($value->status == 'Approved'){
                                                    echo'<td>'.$executedby->name.'</td>';
                                                    
                                                }
                                                if($value->status == 'Cancelled') {
                                                    echo'<td>'.$cancelledby->name.'</td>';
                                                }
                                                if($value->status == 'Pending') {
                                                    //echo'<td hidden="">'.$value->cancelledby.'<td>';
                                                }
                
                                            ?>
                                        
                                        </td>
                                        <td> 
                                            <?php
                                                if($value->status == 'Pending'){
                                                    echo'<span class="label label-warning">'.$value->status.'</span></td>';
                                                }elseif ($value->status == 'Cancelled') {
                                                    echo'<span class="label label-danger">'.$value->status.'</span></td>';
                                                }
                                                else{
                                                   echo'<span class="label label-success">Executed</span></td>';
                                                }    
                                            ?>

                                        </td>
                                        
                                        <td style="width: 150px;">
                                            <?php
                                            if($type == 'Concern'){
                                            echo'<form class="form-inline" id="" method="post">';
                                                if($value->executedby == '0' AND $value->cancelledby == '0'){
                                                echo'
                                                    <a title="Modify Concern" style="color: orange"  data-toggle="modal" data-target="#editConcernModal" onclick=editconcern_content('.$value->id.')><i class="fa fa-edit fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;

                                                    <a title="Cancel Request" style="color: #f54254"  onclick=updatestatusrequest('.$value->id.') <i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                }else{
                                                    echo'
                                                    <a title="View Concern Details " style="color: orange"  data-toggle="modal" data-target="#ApproveConcernModal" onclick=approveconcern_content('.$value->id.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                    
                                                }

                                                if($value->isacknowledge == 'No' and $value->executedby != '0'){
                                                    echo'
                                                    <a  title="Acknowledge Request" style="color: #3c8dbc"  onclick=acknowledgeconcern('.$value->id.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                }

                                                if ($value->remarks == '') {
                                                    echo'
                                                        <a title="Add Remarks" style="color: #3c8dbc"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$value->id.')><i class="fa fa-comment-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp;';
                                                }else{
                                                    echo'
                                                        <a title="Edit Remarks" style="color: #3c8dbc"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$value->id.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; ';
                                                }

                                                if ($value->cancelledby != '0'){
                                                    echo'
                                                        <a  title="Recall Request" style="color: #3c8dbc"  onclick=recallstatusrequest('.$value->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                }

                                                echo'    
                                                </form>';
                                            }
                                                
                                        ?>
                                        </td>     
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
<!-- <script type="text/javascript">
  $(document).ready(function() {
    
    $("#requestSideTree").addClass('active');
    $("li.sideMenu").click(function(){
        // $("a.sideMenu").addClass('active');
        // $(this).addClass('active');
        $("li.sideMenu").removeClass("active");
        $(this).addClass("active");
    });
  });
</script> -->

<script type="text/javascript">
  $(document).ready(function() {
   
    $("#requestSideTree").addClass('active');
    $("#concern_r").addClass('active');
    
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
                    icon: 'error',
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
            timer: 10000
            });

            $('.swalDefaultSuccess').fadeIn(function() {
                Toast.fire({
                    icon: 'success',
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
                    icon: 'success',
                    title: 'Request Succcessfully Updated '
                })
            });
        });
    <?php } ?>
</script>



 <!-- <script type="text/javascript">
    $(document).ready(function () {
        $("input[id^='upload_file']").each(function () {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function () {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreFileUploadLink").show();
                }
            });
        });
    });
</script>  -->

<script type="text/javascript">
    function del_file7(eleId) {
        var ele = document.getElementById("delete_file7" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    function del_file8(eleId) {
        var ele = document.getElementById("delete_file8" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore7').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files7' + upload_number + '" name="upload_files7' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file7(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file7' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload7');
            upload_number++;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore8').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>&nbsp;&nbsp;';
            moreUploadTag += '<label>&nbsp;<input type="file" id="upload_files8' + upload_number + '" name="upload_files8' + upload_number + '"/></label>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file8(' + upload_number + ')" style="cursor:pointer;"><i class="fa fa-trash-o " aria-hidden="true" ></i> ' + upload_number + '</a></div>';
            $('<dl id="delete_file8' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload8');
            upload_number++;
        });
    });
</script>


</body>
</html>
