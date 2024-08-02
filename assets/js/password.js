 
  
    // function Validate() {
    //   var password = document.getElementById("pass").value;
    //   var confirmPassword = document.getElementById("cpassword").value;
    //   if (password != confirmPassword) {
    //     alert("Passwords do not match.");
    //     return false;
    //   }
    //   return true;
    // }
    function Validate() {
      var password = document.getElementById("pass").value;
      var confirmPassword = document.getElementById("cNewPassword").value;
      if (password != confirmPassword) {
        //alert("Passwords do not match.");
        swal_message('error','Passwords do not match!');
        return false;
      }
      return true;
    }
  
    $(document).ready(function(){
        $("#pass").keyup(function(){
          check_pass();
        });
   });

function check_pass(){
    var val=document.getElementById("pass").value;
    var meter=document.getElementById("meter");
    var no=0;
    if(val!=""){
        // If the password length is less than or equal to 8
        if(val.length<=8)
            no=1;

        // If the password length is greater than 8 and contain any lowercase alphabet or any number or any special character
        if(val.length>8 && (val.match(/[a-z]/) || val.match(/\d+/) || val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)))
            no=2;

        // If the password length is greater than 8 and contain alphabet,number,special character respectively
        // if(val.length>8 && ((val.match(/[a-z]/) && val.match(/\d+/)) || (val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[a-z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))
        //     no=3;

        if (val.length > 8 && ((val.match(/[a-z]/) && val.match(/[A-Z]/) && val.match(/\d+/)) || (val.match(/[a-z]/) && val.match(/[A-Z]/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/)) || (val.match(/[A-Z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))))

            no = 3;


        // If the password length is greater than 8 and must contain alphabets,numbers and special characters
        if(val.length>8 && val.match(/[a-z]/) && val.match(/\d+/) && val.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/))
            no=4;

        if(no==1)
        {
            $("#meter").animate({width:'100px'},300);
            meter.style.backgroundColor="#dd4b39";
            document.getElementById("pass_type").innerHTML="Very Weak!!";
            //pass_type.style.color="#dd4b39";
        }

        else if(no==2)
        {
            $("#meter").animate({width:'170px'},300);
            meter.style.backgroundColor="#dd4b39";
            document.getElementById("pass_type").innerHTML="Weak!!";
            //pass_type.style.color="#dd4b39";
        }

        else if(no==3)
        {
           $("#meter").animate({width:'250px'},300);
           meter.style.backgroundColor="#FF8000";
           document.getElementById("pass_type").innerHTML="Good!!";
           //pass_type.style.color="#FF8000";
        }

        else if(no==4)
        {
           $("#meter").animate({width:'350px'},300);
           meter.style.backgroundColor="green";
           document.getElementById("pass_type").innerHTML="Strong!!";
           //pass_type.style.color="green";
        }

        else
        {
            meter.style.backgroundColor="white";
            document.getElementById("pass_type").innerHTML="";
        }
    }  
}

// function doDate()
// {
        
//     var str = "";

//     var days = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
//     var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
//     var now = new Date();
//     //var hour = c.getHours()%12;
//     var am = now.getHours()/12;

//     str += "" + days[now.getDay()] + ", " + months[now.getMonth()] + " " + format(now.getDate()) + ", " + now.getFullYear() + " " + format(now.getHours()%12) +":" + format(now.getMinutes()) + ":" + format(now.getSeconds()) +" " + (am > 1 ? 'PM' : 'AM');
//     document.getElementById("todaysDate").innerHTML = str;
// }

//     setInterval(doDate, 1000);

// function format(num){
//     return num < 10 ? '0'+num : num;
// }

function showPass(){


  $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});


}

function trimfield(str) 
{ 
    return str.replace(/^\s+|\s+$/g,''); 
}

function require_concern()
{
    
    var details = document.getElementById('details');
    var usergroup = $('#usergroup').select2("val");

        if(usergroup == '') 
        {      
            swal_message('error','Usergroup is required!');
            return false;  
        } 
        else if(trimfield(details.value) == '')
        {      
            swal_message('error','Details is required!');
            details.focus();
            return false;       
        }
        else
        $("#msg").show();
        return true;
}

//validation for adding RFS
function require_rfs()
{
    var purpose = document.getElementById('purpose');
    var details = document.getElementById('details');
    //const detail1 = document.getElementById('details');
    var usergroup = $('#usergroup').select2("val");
    var bu = $('#bu').select2("val");
    var bu4 = $('#company2').select2("val");
    var rfstype = $('#rfstype').select2("val");
    var requests_mode = $('#requests_mode').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(rfstype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(bu4 == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(requests_mode == '')
        {      
            swal_message('warning','Request mode is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(details.value) == '')
        {      
            swal_message('warning','Details is required!');
            details.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Details exceeded the limit of 1000 characters, just have it as an attachment!');
            details.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        $("#msg").show();
        return true;
}

//validation for adding TOR
function require_tor()
{
    var purpose = document.getElementById('purpose');
    var details = document.getElementById('details');
    var usergroup = $('#usergroup').select2("val");
    var bu = $('#bu').select2("val");
    var bu4 = $('#company2').select2("val");
    var tortype = $('#tortype').select2("val");
    // var requests_mode = $('#requests_mode').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(tortype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(bu4 == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(details.value) == '')
        {      
            swal_message('warning','Details is required!');
            details.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Details exceeded the limit of 1000 characters, just have it as an attachment!');
            details.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        return true;
}

//validation for adding ISR
function require_isr()
{
    var purpose = document.getElementById('purpose');
    var generals = document.getElementById('generals');
    var security = document.getElementById('security');
    var output = document.getElementById('output');
    var usergroup = $('#usergroup').select2("val");
    var isrtype = $('#isrtype').select2("val");
    var systype = $('#systype').select2("val");
    var bu = $('#bu').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(isrtype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(systype == '')
        {      
            swal_message('warning','System type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business Unit is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(generals.value) == '')
        {      
            swal_message('warning','Generals is required!');
            generals.focus();
            return false;       
        }
        else if(trimfield(security.value) == '')
        {      
            swal_message('warning','Security is required!');
            security.focus();
            return false;       
        }
        else if(trimfield(output.value) == '')
        {      
            swal_message('warning','Output is required!');
            output.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Generals exceeded the limit of 1000 characters, just have it as an attachment!');
            generals.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        return true;
}

//validation for updating RFS
function require_update_rfs()
{
    var purpose = document.getElementById('purpose');
    var details = document.getElementById('details');
    //const detail1 = document.getElementById('details');
    var usergroup = $('#usergroup').select2("val");
    var bu = $('#bu').select2("val");
    var bu4 = $('#company2').select2("val");
    var rfstype = $('#rfstype').select2("val");
    var requests_mode = $('#requests_mode').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(rfstype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(bu4 == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(requests_mode == '')
        {      
            swal_message('warning','Request mode is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(details.value) == '')
        {      
            swal_message('warning','Details is required!');
            details.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Details exceeded the limit of 1000 characters, just have it as an attachment!');
            details.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        $("#msg").show();
        return true;
}

//validation for updating TOR
function require_update_tor()
{
    var purpose = document.getElementById('purpose');
    var details = document.getElementById('details');
    var usergroup = $('#usergroup').select2("val");
    var bu = $('#bu').select2("val");
    var bu4 = $('#company2').select2("val");
    var tortype = $('#tortype').select2("val");
    // var requests_mode = $('#requests_mode').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(tortype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(bu4 == '')
        {      
            swal_message('warning','Business unit is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(details.value) == '')
        {      
            swal_message('warning','Details is required!');
            details.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Details exceeded the limit of 1000 characters, just have it as an attachment!');
            details.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        return true;
}

//validation for updating ISR
function require_update_isr()
{
    var purpose = document.getElementById('purpose');
    var generals = document.getElementById('generals');
    var security = document.getElementById('security');
    var output = document.getElementById('output');
    var usergroup = $('#usergroup').select2("val");
    var isrtype = $('#isrtype').select2("val");
    var systype = $('#systype').select2("val");
    var bu = $('#bu').select2("val");
        if(usergroup == '') 
        {      
            swal_message('warning','Usergroup is required!');
            return false;  
        }
        else if(isrtype == '')
        {      
            swal_message('warning','Request type is required!');
            return false;       
        }
        else if(systype == '')
        {      
            swal_message('warning','System type is required!');
            return false;       
        }
        else if(bu == '')
        {      
            swal_message('warning','Business Unit is required!');
            return false;       
        }
        else if(trimfield(purpose.value) == '')
        {      
            swal_message('warning','Purpose is required!');
            purpose.focus();
            return false;       
        }
        else if(trimfield(generals.value) == '')
        {      
            swal_message('warning','Generals is required!');
            generals.focus();
            return false;       
        }
        else if(trimfield(security.value) == '')
        {      
            swal_message('warning','Security is required!');
            security.focus();
            return false;       
        }
        else if(trimfield(output.value) == '')
        {      
            swal_message('warning','Output is required!');
            output.focus();
            return false;       
        }
        else if(details.value.length >= 1000)
        {      
            swal_message('warning','Generals exceeded the limit of 1000 characters, just have it as an attachment!');
            generals.focus();

            //console.log(detail1.value.length);
            return false;       
        }
        else
        return true;
}

//for updating BU access
function updatestatusburole(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })
    
    var uid = document.getElementById("user_id_"+id).value;
    var type = document.getElementById("usertype_id_"+id).value;
    var rtype = document.getElementById("rfstype"+id).value;                   
    $.ajax({
        url: 'status_update_burole',
        type: 'POST',
        data: {uid:uid, type:type, rtype:rtype},
        
        success: function(data) { 
           Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating BU access
function updatestatusburole1(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid = document.getElementById("user_id_"+id).value;
    var type = document.getElementById("usertype_id_"+id).value;
    var rtype = document.getElementById("tortype"+id).value;                   
    $.ajax({
        url: 'status_update_burole1',
        type: 'POST',
        data: {uid:uid, type:type, rtype:rtype},
        
        success: function(data) { 
           Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating BU access
function updatestatusburole2(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid = document.getElementById("user_id_"+id).value;
    var type = document.getElementById("usertype_id_"+id).value;
    var rtype = document.getElementById("isrtype"+id).value;                   
    $.ajax({
        url: 'status_update_burole2',
        type: 'POST',
        data: {uid:uid, type:type, rtype:rtype},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating BU access
function updatestatusbu(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid = document.getElementById("user_id_"+id).value;
    var type = document.getElementById("bunit_id_"+id).value;
    var comp = document.getElementById("company_code_"+id).value;    
             
    $.ajax({
        url: 'status_update_bu',
        type: 'POST',
        data: {uid:uid, type:type,comp:comp},
        success: function(data) { 
        //console.log(data)
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })

        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating request attachments status
function updatestatusfiles(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })
    var file_id = document.getElementById("file_id_"+id).value;
    var uid     = document.getElementById("request_number_"+id).value;
    var type    = document.getElementById("request_type_"+id).value;
    //var stat1 = document.getElementById("Ustatus_"+id).value;                   
    $.ajax({
        url: 'status_update_files',
        type: 'POST',
        data: {uid:uid, type:type, file_id:file_id},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'File/s Successfully Removed ! ',
                
            })
            
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

function swal_message(msg_type,msg){
    var Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
      });

    Toast.fire({
        icon: msg_type,
        title: msg
    })
}


// function swal_message(msg_type,msg,){
    
//     const Toast = Swal.mixin({
//             toast: false,
//             position: 'center',
//             showConfirmButton: true
//             //timer: 2000
//         })

//     Swal.fire({
//         icon: msg_type,
//         title: 'Oops...',
//         text: msg,
//     })
// }

function logout()
{
    Swal.fire({
    title: 'Sign out',
    text: "Are you sure you want to sign out?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'logout-a',
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                window.location.reload();
                // swal_message('success','You have successfully logged out');
            }
        });
    }
    })
}

//for recalling a request
function recallstatusrequest(id)
{
    Swal.fire({
    title: 'Are you sure to recall this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, recall it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_recall',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Recalled!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

//for Approve users recalling a request 
function recallstatusrequestA(id)
{
    Swal.fire({
    title: 'Are you sure to disregard this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, disregard it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_recall_a',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Disregarded!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

//for Execute users recalling a request
function recallstatusrequestE(id)
{
    Swal.fire({
    title: 'Are you sure to disregard this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, disregard it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_recall_e',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Disregarded!');
                // setTimeout(function(){
                //     window.location.reload();
                // }, 2000);

                var table = $('#dt-execute').DataTable();
                var currentPage = table.page();

                table.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table.page(currentPage).draw('page');
                }); 
                

                if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                    $('#dt-execute').DataTable({
                        "aoColumnDefs": 
                        [{ "bSortable": false, "aTargets": [0] }]
                    });
                }
            }
        });
    }
    })
}

//for Review users recalling a request
function recallstatusrequestR(id)
{
    Swal.fire({
    title: 'Are you sure to disregard this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, disregard it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_recall_r',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Disregarded!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

//for Verify users recalling a request
function recallstatusrequestV(id)
{
    Swal.fire({
    title: 'Are you sure to disregard this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, disregard it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_recall_v',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Disregarded!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function resetpassword(id) //for reset password
{
    Swal.fire({
    title: 'Are you sure to reset the password?',
    text: "The default password is Torrfs2022",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, reset it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'reset_password',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Password Successfully Resetted!');

                var table_user = $('#dt-users').DataTable();
                var currentPage = table_user.page();

                table_user.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table_user.page(currentPage).draw('page');
                });       
                

                if (!$.fn.DataTable.isDataTable('#dt-users')) {

                    $('#dt-users').DataTable({
                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                        
                    });
                }
                // setTimeout(function(){
                //     window.location.reload();
                // }, 2000);
            }
        });
    }
    })
}

function updatestatusrequest(id) //for cancelling request
{
    Swal.fire({
    title: 'Are you sure to cancel this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, cancel it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_request',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Cancelled!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function approvevalid() //validation message for approving their own requests
{
    Swal.fire({
    title: 'Oops...',
    text: "You won't be able to approve your own request!",
    icon: 'warning'
    
    })
}

function executevalid() //validation message for approving their own requests
{
    Swal.fire({
    title: 'Oops...',
    text: "You won't be able to execute your own request!",
    icon: 'warning'
    
    })
}
function verifyvalid() //validation message for approving their own requests
{
    Swal.fire({
    title: 'Oops...',
    text: "You won't be able to verify your own request!",
    icon: 'warning'
    
    })
}
function disapprovevalid() //validation message for approving their own requests
{
    Swal.fire({
    title: 'Oops...',
    text: "You won't be able to disapprove your own request!",
    icon: 'warning'
    
    })
}

function disapprovestatusrequest(id) //for disapproving request
{
    Swal.fire({
    title: 'Are you sure to disapprove this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Yes, disapprove it!',
    cancelButtonText: 'No'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_request',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Something went wrong!'
                })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Disapproved!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}


var lastOpenedModal = null;

$('.modal').on('shown.bs.modal', function (e) {
    lastOpenedModal = $(this);
});

function approvestatusrequest(id) //for approving request
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_approve',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Approved!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function completestatusrequestA(id) //for approving request, for Approve user when request is already executed and reviewed/verified
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_a',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Approved!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function completestatusrequestE(id) //for approving request, for Execute user when request is already approved and reviewed/verified
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_e',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Executed!');
                // setTimeout(function(){
                //     window.location.reload();
                // }, 2000);

                if (lastOpenedModal) {
                    lastOpenedModal.modal('hide');
                }

                var table = $('#dt-execute').DataTable();
                var currentPage = table.page();

                table.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table.page(currentPage).draw('page');
                }); 
                

                if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                    $('#dt-execute').DataTable({
                        "aoColumnDefs": 
                        [{ "bSortable": false, "aTargets": [0] }]
                    });
                }
            }
        });
    }
    })
}

function completestatusrequestR(id) //for approving request, for Review user when request is already approved, executed and verified
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_r',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Reviewed!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function completestatusrequestV(id) //for approving request, for Review user when request is already approved, executed and reviewed
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_v',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Verified!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function executestatusconcern(id) //for executing concern request
{
    Swal.fire({
    title: 'Are you sure to execute this concern?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_concern',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Executed!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function acknowledgeconcern(id) //for acknowledging request
{
    Swal.fire({
    title: 'Are you sure to acknowledge this concern?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_ack_concern',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Acknowledged!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function executestatusrequest(id) //for executing request
{
    Swal.fire({
    title: 'Are you sure to execute this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_execute',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Executed!');
                // setTimeout(function(){
                //     window.location.reload();
                // }, 2000);

                if (lastOpenedModal) {
                    lastOpenedModal.modal('hide');
                }

                var table = $('#dt-execute').DataTable();
                var currentPage = table.page();

                table.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table.page(currentPage).draw('page');
                }); 
                

                if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                    $('#dt-execute').DataTable({
                        "aoColumnDefs": 
                        [{ "bSortable": false, "aTargets": [0] }]
                    });
                }
            }
        });
    }
    })
}

function reviewstatusrequest(id) //for reviewing request
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_review',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Reviewed!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}

function verifystatusrequest(id) //for verifying request
{
    Swal.fire({
    title: 'Are you sure to approve this request?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_update_verify',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Request Successfully Verified!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }
    })
}



function activategroupstatus(id) //for activating group status 
{
    Swal.fire({
    title: 'Activate?',
    text: "Are you sure to activate this group?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_activate_group',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','User Group Successfully Activated!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        window.location.reload();
    }

    })
}

function deactivategroupstatus(id) //for deactivating group status 
{
    Swal.fire({
    title: 'Deactivate?',
    text: "Are you sure to deactivate this group?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_deactivate_group',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','User Group Successfully Deactivated!');
                setTimeout(function(){
                    window.location.reload();
                }, 2000);
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        window.location.reload();
    }
    })
}

function activateuserstatus(id) //for activating user status 
{
    Swal.fire({
    title: 'Activate?',
    text: "Are you sure to activate this user?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_activate',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','User Successfully Activated!');
                var table_user = $('#dt-users').DataTable();
                var currentPage = table_user.page();

                table_user.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table_user.page(currentPage).draw('page');
                });       
                

                if (!$.fn.DataTable.isDataTable('#dt-users')) {

                    $('#dt-users').DataTable({
                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                        
                    });
                }
                
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        swal_message('info','No changes made!');
        // setTimeout(function(){
        //             window.location.reload();
        //         }, 2000);
        var table_user = $('#dt-users').DataTable();
        var currentPage = table_user.page();

        table_user.ajax.reload(function () {
                // Set the page back to the saved page number
                table_user.page(currentPage).draw('page');
            });       
        

        if (!$.fn.DataTable.isDataTable('#dt-users')) {

            $('#dt-users').DataTable({
            "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
            
            });
        }
        if (!$(this).parents('tr').hasClass('selected')) {
                table_user.$('tr.selected').removeClass('selected');
                $(this).parents('tr').addClass('selected');
        }
    }

    })
}

function deactivateuserstatus(id) //for deactivating user status 
{
    Swal.fire({
    title: 'Deactivate?',
    text: "Are you sure to deactivate this user?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'status_deactivate',
            type: 'POST',
            data: {id:id},
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','User Successfully Deactivated!');
                var table_user = $('#dt-users').DataTable();

                var selectedRow = table_user.row('#row_' + id).node();
                $(selectedRow).addClass('active');
                var currentPage = table_user.page();

                table_user.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table_user.page(currentPage).draw('page');
                });       
                

                if (!$.fn.DataTable.isDataTable('#dt-users')) {

                    $('#dt-users').DataTable({
                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                        
                    });
                }
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        swal_message('info','No changes made!');
        var table_user = $('#dt-users').DataTable();
        var currentPage = table_user.page();

        table_user.ajax.reload(function () {
                // Set the page back to the saved page number
                table_user.page(currentPage).draw('page');
            });       
        

        if (!$.fn.DataTable.isDataTable('#dt-users')) {

            $('#dt-users').DataTable({
                "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                
            });
        }
    }
    })
}

//for tasks access
function updatestatus(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid = document.getElementById("user_id_"+id).value;
    var type = document.getElementById("usertype_id_"+id).value;
    //var stat1 = document.getElementById("Ustatus_"+id).value;                   
    $.ajax({
        url: 'status_update',
        type: 'POST',
        data: {uid:uid, type:type},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })

            swal_message('success','Access Successfully Updated!');
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating RFS type access
function updatestatus2(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid     = document.getElementById("user_id_"+id).value;
    var rfstype = document.getElementById("rfs_id_"+id).value;
           
    $.ajax({
        url: 'status_update_rfs',
        type: 'POST',
        data: {uid:uid, rfstype:rfstype},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating TOR type access
function updatestatus3(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid     = document.getElementById("user_id_"+id).value;
    var tortype = document.getElementById("tor_id_"+id).value;
    
    $.ajax({
        url: 'status_update_tor',
        type: 'POST',
        data: {uid:uid, tortype:tortype},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating ISR type access
function updatestatus4(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid     = document.getElementById("user_id_"+id).value;
    var isrtype     = document.getElementById("isr_id_"+id).value;
                 
    $.ajax({
        url: 'status_update_isr',
        type: 'POST',
        data: {uid:uid, isrtype:isrtype},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
}

//for updating group access
function updatestatus5(id){

    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom-left',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
    })

    var uid     = document.getElementById("user_id_"+id).value;
    var group   = document.getElementById("group_id_"+id).value;
               
    $.ajax({
        url: 'status_update_groups',
        type: 'POST',
        data: {uid:uid, group:group},
        
        success: function(data) { 
            Toast.fire({
                icon: 'success',
                title: 'Access Successfully Updated ! ',
                
            })
        },
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        }
    });
} 

// for execute details remarks
$('#addRemarksrfs').on("submit", function(e){
var formData = new FormData($(this)[0]);
e.preventDefault();
var flag = 0;

    // Check if the remarks field is empty
    if ($('#remarks').val().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Cannot save an empty remarks!'
        });
        return; // Exit the function if remarks are empty
    }
    Swal.fire({
    title: 'Confirmation',
    text: "Are you sure to save the remarks?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: baseurl + 'save_remarks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Remarks Successfully Saved!');
            //$('#addRemarksModal').modal('hide');
            var table = $('#dt-execute').DataTable();
            var currentPage = table.page();

            table.ajax.reload(function () {
                // Set the page back to the saved page number
                table.page(currentPage).draw('page');
            }); 
            

            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                $('#dt-execute').DataTable({
                    "aoColumnDefs": 
                    [{ "bSortable": false, "aTargets": [0] }]
                });
            }
            }
        });
    }
    })
});

// for execute details remarks
$('#addRemarkstor').on("submit", function(e){
var formData = new FormData($(this)[0]);
e.preventDefault();
var flag = 0;

    // Check if the remarks field is empty
    if ($('#remarks').val().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Cannot save an empty remarks!'
        });
        return; // Exit the function if remarks are empty
    }
    Swal.fire({
    title: 'Confirmation',
    text: "Are you sure to save the remarks?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: baseurl + 'save_remarks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Remarks Successfully Saved!');
            //$('#addRemarksModal').modal('hide');
            var table = $('#dt-execute').DataTable();
            var currentPage = table.page();

            table.ajax.reload(function () {
                // Set the page back to the saved page number
                table.page(currentPage).draw('page');
            }); 
            

            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                $('#dt-execute').DataTable({
                    "aoColumnDefs": 
                    [{ "bSortable": false, "aTargets": [0] }]
                });
            }
            }
        });
    }
    })
});

// for execute details remarks
$('#addRemarksisr').on("submit", function(e){
var formData = new FormData($(this)[0]);
e.preventDefault();
var flag = 0;
    // Check if the remarks field is empty
    if ($('#remarks').val().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Cannot save an empty remarks!'
        });
        return; // Exit the function if remarks are empty
    }
    Swal.fire({
    title: 'Confirmation',
    text: "Are you sure to save the remarks?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: baseurl + 'save_remarks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Remarks Successfully Saved!');
            //$('#addRemarksModal').modal('hide');
            var table = $('#dt-execute').DataTable();
            var currentPage = table.page();

            table.ajax.reload(function () {
                // Set the page back to the saved page number
                table.page(currentPage).draw('page');
            }); 
            

            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                $('#dt-execute').DataTable({
                    "aoColumnDefs": 
                    [{ "bSortable": false, "aTargets": [0] }]
                });
            }
            }
        });
    }
    })
});

//for table action buttons
// $('#addRemarks').on("submit", function(e){
//     var formData = new FormData($(this)[0]);
//     e.preventDefault();
//     var flag = 0;
//         $.ajax({
//         url: baseurl + 'save_remarks',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         error: function() {
//             Swal.fire({
//               icon: 'error',
//               title: 'Oops...',
//               text: 'Something went wrong!'
//             })
//         },

//         success: function(data) {            
//             swal_message('success','Remarks Successfully Saved!');
//             $('#addRemarksModal').modal('hide');
//             var table = $('#dt-execute').DataTable();
//             var currentPage = table.page();

//             table.ajax.reload(function () {
//                 // Set the page back to the saved page number
//                 table.page(currentPage).draw('page');
//             }); 
        
       
            
//             if (!$.fn.DataTable.isDataTable('#dt-execute')) {

//             $('#dt-execute').DataTable({
//                 "aoColumnDefs": 
//                 [{ "bSortable": false, "aTargets": [0] }]
//             });
//             }
//             // setTimeout(function(){
//             //     window.location.reload();
//             // }, 2000);
//         }
//     });
// });

$('#addRemarks').on("submit", function(e){
    var formData = new FormData($(this)[0]);
    e.preventDefault();
    var flag = 0;
    
    // Check if the remarks field is empty
    if ($('#remarks').val().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Cannot save an empty remarks!'
        });
        return; // Exit the function if remarks are empty
    }    

    Swal.fire({
    title: 'Confirmation',
    text: "Are you sure to save the remarks?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: baseurl + 'save_remarks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Remarks Successfully Saved!');
            $('#addRemarksModal').modal('hide');
            var table = $('#dt-execute').DataTable();
            var currentPage = table.page();

            table.ajax.reload(function () {
                // Set the page back to the saved page number
                table.page(currentPage).draw('page');
            }); 
            

            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                $('#dt-execute').DataTable({
                    "aoColumnDefs": 
                    [{ "bSortable": false, "aTargets": [0] }]
                });
            }
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        swal_message('info','No changes made!');
        $('#addRemarksModal').modal('hide');
    }
    })
});

//for table action buttons
// $('#editRemarks').on("submit", function(e){
//     var formData = new FormData($(this)[0]);
//     e.preventDefault();
//     var flag = 0;
//         $.ajax({
//         url: baseurl + 'save_remarks',
//         type: 'POST',
//         data: formData,
//         processData: false,
//         contentType: false,
//         error: function() {
//             Swal.fire({
//               icon: 'error',
//               title: 'Oops...',
//               text: 'Something went wrong!'
//             })
//         },

//         success: function(data) {            
//             swal_message('success','Remarks Successfully Saved!');
//             $('#editRemarksModal').modal('hide');
            
            
//             var table = $('#dt-execute').DataTable();
//             var currentPage = table.page();

//             table.ajax.reload(function () {
//                 // Set the page back to the saved page number
//                 table.page(currentPage).draw('page');
//             }); 
//             if (!$.fn.DataTable.isDataTable('#dt-execute')) {
//                 table_apr.destroy();
//                 $('#dt-execute').DataTable({
//                     "aoColumnDefs": 
//                     [{ "bSortable": false, "aTargets": [0] }]
//                 });
//             }

//             var table_apr = $('#dt-approve').DataTable();
//             var currentPage2 = table_apr.page();

//             table_apr.ajax.reload(function () {
//                 // Set the page back to the saved page number
//                 table_apr.page(currentPage2).draw('page');
//             }); 
//             if (!$.fn.DataTable.isDataTable('#dt-approve')) {
//                 table.destroy();
//                 $('#dt-approve').DataTable({
//                     "aoColumnDefs": 
//                     [{ "bSortable": false, "aTargets": [0] }]
//                 });
//             }


//             // setTimeout(function(){
//             //     window.location.reload();
//             // }, 2000);
//         }
//     });
// });

$('#editRemarks').on("submit", function(e){
    var formData = new FormData($(this)[0]);
    e.preventDefault();
    var flag = 0;
    
    // Check if the remarks field is empty
    if ($('#remarks').val().trim() === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Cannot save an empty remarks!'
        });
        return; // Exit the function if remarks are empty
    }  

    Swal.fire({
    title: 'Confirmation',
    text: "Are you sure to update the remarks?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '',
    confirmButtonText: 'Proceed!'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: baseurl + 'save_remarks',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            error: function() {
                Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
            },
            success: function(data) {            
                swal_message('success','Remarks Successfully Saved!');
            $('#editRemarksModal').modal('hide');
            var table = $('#dt-execute').DataTable();
            var currentPage = table.page();

            table.ajax.reload(function () {
                // Set the page back to the saved page number
                table.page(currentPage).draw('page');
            }); 
            

            if (!$.fn.DataTable.isDataTable('#dt-execute')) {

                $('#dt-execute').DataTable({
                    "aoColumnDefs": 
                    [{ "bSortable": false, "aTargets": [0] }]
                });
            }
            }
        });
    }else if (result.dismiss === Swal.DismissReason.cancel){
        swal_message('info','No changes made!');
        $('#editRemarksModal').modal('hide');
    }
    })
});

$('#editUser').on("submit", function(e){
    var formData = new FormData($(this)[0]);
    e.preventDefault();
    var flag = 0;
        $.ajax({
        url: baseurl + 'crudupdate',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },

        success: function(data) {            
            swal_message('success','User Data Successfully Updated!');
            $('#editUserModal').modal('hide');
            var table_user = $('#dt-users').DataTable();
                var currentPage = table_user.page();

                table_user.ajax.reload(function () {
                    // Set the page back to the saved page number
                    table_user.page(currentPage).draw('page');
                });       
                

                if (!$.fn.DataTable.isDataTable('#dt-users')) {

                    $('#dt-users').DataTable({
                        "aoColumnDefs": [{ "bSortable": false, "aTargets": [0] }],
                        
                    });
                }
            // setTimeout(function(){
            //     window.location.reload();
            // }, 2000);
        }
    });
});

function adduser_content()
{  
    //alert('asd');
    // var emp  = document.getElementById("emp_id").value; 
    var pass = $("input[name = 'emp_id']").val();
    alert(pass);
    // console.log('asd');
    $.ajax({
        url: 'adduser_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#adduser_content").html(data);                
        }                
    });
}

function adduser_content_cebu()
{  
    //alert('asd');
    // var emp  = document.getElementById("emp_id").value; 
    // var pass = $("input[name = 'emp_id']").val();
    // alert(pass);
    // console.log('asd');
    $.ajax({
        url: 'adduser_content_cebu',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#adduser_content_cebu").html(data);                
        }                
    });
}

function addcomp_content()
{   
    $.ajax({
        url: 'addcomp_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#addcomp_content").html(data);                
        }                
    });
}

function addgroup_content()
{   
    $.ajax({
        url: 'addgroup_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#addgroup_content").html(data);                
        }                
    });
}

function addbu_content()
{   
    $.ajax({
        url: 'addbu_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#addbu_content").html(data);                
        }                
    });
}

function concern_content()
{   
    $.ajax({
        url: 'concern_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#concern_content").html(data);                
        }                
    });
}

function tor_content()
{   
    $.ajax({
        url: 'tor_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#tor_content").html(data);                
        }                
    });
}

function rfs_content()
{   
    $.ajax({
        url: 'rfs_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#rfs_content").html(data);                
        }                
    });
}

function tor_content()
{   
    $.ajax({
        url: 'tor_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#tor_content").html(data);                
        }                
    });
}

function isr_content()
{   
    $.ajax({
        url: 'isr_content',
        type: 'POST',
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#isr_content").html(data);                
        }                
    });
}

function bu_content(id)
{   
    var uid  = document.getElementById("comp_"+id).value;
    $.ajax({
        url:  'bu_contents',
        type: 'POST',
        data: {uid:uid},

        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#bu_content1").html(data);

        }                
    });
}

function selectbu(id)
{   
    var uid  = document.getElementById("company").value;
    $.ajax({
        url:  'adduser_content',
        type: 'POST',
        data: {uid:uid},

        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#bu").html(data);

        }                
    });
}

function userChange() {
    if (document.getElementById("usertype").value == "4"){
        $("#message").fadeIn();        
    }else{
        $("#message").hide();
    } 
}

//for viewing request status
function approved_view_rfs(ids)
{
    $.ajax({
        url:  'showApprovedRfs', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approved_view_rfs").html(data);
        }
    });
}

//for viewing request status
function approved_view_tor(ids)
{
    $.ajax({
        url:  'showApprovedTor', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approved_view_tor").html(data);
        }
    });
}

//for viewing request status
function approved_view_isr(ids)
{
    $.ajax({
        url:  'showApprovedIsr', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approved_view_isr").html(data);
        }
    });
}

function approverfs_content_e(ids)
{
    $.ajax({
        url:  'approverfs_content_e', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approverfs_content_e").html(data);
        }
    });
}

function approvetor_content_e(ids)
{
    $.ajax({
        url:  'approvetor_content_e', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approvetor_content_e").html(data);
        }
    });
}

function approveisr_content_e(ids)
{
    $.ajax({
        url:  'approveisr_content_e', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approveisr_content_e").html(data);
        }
    });
}

//for viewing request details
function approveconcern_content(ids)
{
    $.ajax({
        url:  'approveconcern_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approveconcern_content").html(data);
        }
    });
}

//for viewing request details
function approverfs_content(ids)
{
    $.ajax({
        url:  'approverfs_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approverfs_content").html(data);
        }
    });
}

//for viewing request details
function approvetor_content(ids)
{
    $.ajax({
        url:  'approvetor_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approvetor_content").html(data);
        }
    });
}

//for viewing request details
function approveisr_content(ids)
{
    $.ajax({
        url:  'approveisr_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#approveisr_content").html(data);
        }
    });
}

function print_isr(ids)
{
    // window.location = 'smdenomdata/'+ddate;
    window.open(baseurl + 'printisr/'+ids, '_blank');
}

function print_rfs(ids)
{
    // window.location = 'smdenomdata/'+ddate;
    window.open(baseurl + 'printrfs/'+ids, '_blank');
}

function print_tor(ids)
{
    // window.location = 'smdenomdata/'+ddate;
    window.open(baseurl + 'printtor/'+ids, '_blank');
}

function addremarks_content(ids)
{
    $.ajax({
        url:  'addremarks_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#addremarks_content").html(data);
        }
    });
}

function editremarks_content(ids)
{
    $.ajax({
        url:  'editremarks_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editremarks_content").html(data);
        }
    });
}

function viewremarks_content(ids)
{
    $.ajax({
        url:  'viewremarks_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#viewremarks_content").html(data);
        }
    });
}



function editconcern_content(ids)
{
    $.ajax({
        url:  'editconcern_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editconcern_content").html(data);
        }
    });
}

function editrfs_content(ids)
{
    $.ajax({
        url:  'editrfs_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editrfs_content").html(data);
        }
    });
}

function edittor_content(ids)
{
    $.ajax({
        url:  'edittor_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#edittor_content").html(data);
        }
    });
}

function editisr_content(ids)
{
    $.ajax({
        url:  'editisr_content', 
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editisr_content").html(data);
        }
    });
}

function editbu_content(ids)
{
    $.ajax({
        url:  'editbu_content',
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editbu_content").html(data);
        }
    });
}


function edituser_content(ids)
{
    $.ajax({
        url: 'edituser_content',
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#edituser_content").html(data);
        }
    }); 
}
    
function edituser_content2(ids)
{
    $.ajax({
        url: 'edituser_content2',
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#edituser_content2").html(data);
        }
    });
}

function editbu_content2(ids)
{

    $.ajax({
        url: 'editbu_content2',
        type: 'POST',
        data: {ids:ids},
        error: function() {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            })
        },
        success: function(data) {                 
            $("#editbu_content2").html(data);
        }
    });
}


