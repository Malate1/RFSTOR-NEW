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
                <li class="active">Execute</li>
                <?php  
                    echo'<li class="active">'.$type.'</li>';  
                ?>
                <?php  
                    if($status == 'Approved'){
                        echo'<li class="active">Executed</li>'; 
                    }else{
                        echo'<li class="active">'.$status.'</li>'; 
                    }
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
                        <?php
                        if($type == 'Concern'){ ?>
                            <div align="center" style="padding: 0px 12px 0px 12px;" >
                                <div  class="btn-group" style="width:100%; text-align: center;">
                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('pending-concern-status')?>">Pending</a>

                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('approve-concern-status')?>">Executed</a>

                                    <a class="btn btn-default swalDefaultError swalDefaultSuccess" href="<?=base_url('cancel-concern-status')?>">Cancelled</a>
                                </div>
                            </div>
                        <?php } ?>

                       
                        <div class="alert alert-danger" id="msg" role="alert" style="display: none">New Request was been added!</div>
                        <div style="padding: 0px 10px 10px 10px" class="box-body table-responsive">
                            <table class="table  table-striped  table-bordered table-hover dataTable no-footer" id="editable_table" width="100%" >
                                <thead>
                                    <tr role="row">
                                        <!-- <th hidden="">ID</th> -->
                                        <th style="text-align: center;" >Control No.</th>
                                        <th >Transaction Date</th>
                                        <th >Requested To</th>
                                        <th >Company</th>
                                        <th >BU</th>
                                        <th >Requested By</th>
                                        <th style="width: 150px;">Details</th>
                                        <?php
                                            if($status == 'Approved'){
                                                echo'<th>Acknowledge</th>';
                                            }else{
                                                echo'<th>Acknowledge</th>';
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
                                        <!-- <td hidden=""><?=$value->reqid?></td> -->
                                        <td style="color: red; text-align: center; font-weight: bold"><?=$value->requestnumber?></td>
                                        <td><?=date("D • h:i:s A • M. d, Y ", strtotime($value->datetoday))?></td>
                                        <td><?=$value->groupname?></td>
                                        <td><?=$value->companyname?></td>
                                        <?php
                                          
                                           $bu = $this->Admin_Model->bu_name($value->buid);
                                        ?>
                                        <td><?=$bu->business_unit?></td>
                                        <?php
                                          
                                           // $requestedby = $this->employee_model->find_an_employee($value->userid);
                                            $requestedby = $this->Admin_Model->getUserData2($value->userid);
                                        ?>
                                        <td><?=$requestedby->name?></td>
                                        <td style="width: 150px;"><?=$value->details?></td>
                                        <?php
                                            
                                            if($value->isacknowledge == 'Yes'){
                                                echo'<td>'.$value->isacknowledge.'</td>';
                                                
                                            }

                                            if($value->isacknowledge == 'No'){
                                                
                                                echo'<td>'.$value->isacknowledge.'</td>';
                                            }
                                            
                                            
            
                                        ?>
                                        
                                            <?php
                                                if($value->executedby == '0' AND $value->cancelledby == '0'){
                                                    echo'<td><span class="label label-warning">Pending</span></td>';
                                                }elseif ($value->reqstatus == 'Cancelled') {
                                                    echo'<td><span class="label label-danger">'.$value->reqstatus.'</span></td>';
                                                }
                                                else{
                                                   echo'<td><span class="label label-success">Executed</span></td>';
                                                }    
                                            ?>
                                        <td style="width: 150px;">
                                            <?php
                                            $taskid1 = 2;
                                            $taskid2 = 3;
                                            if($type == 'Concern'){
                                            echo'
                                                <a title="View Concern Details " style="color: orange"  data-toggle="modal" data-target="#ApproveConcernModal" onclick=approveconcern_content('.$value->reqid.')><i class="fa fa-file-text-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                               
                                                if($value->executedby == '0' AND $value->cancelledby == '0'){

                                                echo'<a  title="Approve Request" style="color: #3c8dbc"  onclick=executestatusconcern('.$value->reqid.') <i class="fa fa-thumbs-o-up fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                
                                                echo'<a  title="Cancel Request" style="color: #F03649"  onclick=updatestatusrequest('.$value->reqid.') <i class="fa fa-trash-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                }
                                                if ($value->remarks == '') {
                                                    echo'
                                                        <a title="Add Remarks" style="color: #3c8dbc"  data-toggle="modal" data-target="#addRemarksModal" onclick=addremarks_content('.$value->reqid.')><i class="fa fa-comment-o fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; ';
                                                }else{
                                                    echo'
                                                        <a title="Edit Remarks" style="color: #3c8dbc"  data-toggle="modal" data-target="#editRemarksModal" onclick=editremarks_content('.$value->reqid.')><i class="fa fa-comment fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; ';
                                                }

                                                if ($value->cancelledby != '0'){
                                                    echo'
                                                        <a  title="Recall Request" style="color: #3c8dbc"  onclick=recallstatusrequest('.$value->reqid.') <i class="fa fa-undo fa-lg" aria-hidden="true" ></i></a>&nbsp;&nbsp; || &nbsp;';
                                                }
                                            
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
<script type="text/javascript">
  $(document).ready(function() {
    
    $("#executeSideTree").addClass('active');
    $("#concern_e").addClass('active');
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
