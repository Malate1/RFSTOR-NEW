<style type="text/css">
.responsive-cell-block {
    min-height: 75px;
}

.text-blk {
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0px;
    margin-left: 0px;
    line-height: 25px;
}

.responsive-container-block {
    min-height: 80px;
    height: fit-content;
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    margin-top: 0px;
    margin-right: auto;
    margin-bottom: 0px;
    margin-left: auto;
    justify-content: space-evenly;
}

.team-head-text {
    font-size: 48px;
    font-weight: 900;
    text-align: center;
}

.team-head-text {
    line-height: 50px;
    width: 100%;
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 50px;
    margin-left: 0px;
}

.container {
    max-width: 1380px;
    margin-top: 60px;
    margin-right: auto;
    margin-bottom: 60px;
    margin-left: auto;
    padding-top: 0px;
    padding-right: 30px;
    padding-bottom: 0px;
    padding-left: 30px;
}

.card {
    text-align: center;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 4px 20px 7px;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 30px;
    padding-right: 25px;
    padding-bottom: 30px;
    padding-left: 25px;
    border-radius: 10px;
}

.card-container {
    width: 280px;
    margin-top: 0px;
    margin-right: 10px;
    margin-bottom: 25px;
    margin-left: 10px;
}

.name {
    margin-top: 20px;
    margin-right: 0px;
    margin-bottom: 5px;
    margin-left: 0px;
    font-size: 18px;
    font-weight: 800;
}

.position {
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 10px;
    margin-left: 0px;
}

.feature-text {
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;
    color: rgb(122, 122, 122);
    line-height: 30px;
}

.social-icons {
    width: 70px;
    display: flex;
    justify-content: space-between;
}

.team-image-wrapper {
    clip-path: circle(50% at 50% 50%);
    width: 160px;
    height: 160px;
}

.team-member-image {
    max-width: 100%;
}

@media (max-width: 500px) {
    .card-container {
        width: 100%;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 25px;
        margin-left: 0px;
    }
}
</style>
<!-- <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/password.css" /> -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <style type="text/css">
    .card:hover i,
    .card:hover h4 {
        color: #3c8dbc;
    }

    td {
        text-align: left;
    }

    .main {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /*.top-profile {
            width: 250px;
            margin: 10px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            background: #fff;
        }*/

    .top-profile .profile-card img {
        max-width: 100%;
        height: auto;
    }

    .bottom-profiles {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .bottom-profiles .profile-card {
        /*width: 250px;
            margin: 10px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            background: #fff;*/

        position: relative;
        /*     font-family: sans-serif;*/
        width: 220px;
        height: 220px;
        background: #fff;
        padding: 30px;
        border-radius: 50%;
        box-shadow: 0 0 22px #3336;
        transition: .6s;
        margin: 0 50px 50px;
        /* Added 20px bottom margin */
    }

    .bottom-profiles .profile-card img {
        max-width: 100%;
        height: auto;
    }


    .profile-card {
        position: relative;
        /*     font-family: sans-serif;*/
        width: 220px;
        height: 220px;
        background: #fff;
        padding: 30px;
        border-radius: 50%;
        box-shadow: 0 0 22px #3336;
        transition: box-shadow 0.3s, border-radius 0.3s, height 0.3s;
        margin: 0 50px;
    }

    .profile-card:hover {
        border-radius: 10px;
        height: 260px;
    }

    .profile-card .img {
        position: relative;
        width: 100%;
        height: 100%;
        transition: .6s;
        z-index: 99;
    }

    .profile-card:hover .img {
        transform: translateY(-60px);
    }

    .img img {
        width: 100%;
        border-radius: 50%;
        box-shadow: 0 0 22px #3336;
        transition: .6s;
    }

    .profile-card:hover img {
        border-radius: 10px;
    }

    .caption {
        text-align: center;
        transform: translateY(-100px);
        opacity: 0;
        transition: .6s;
    }

    .profile-card:hover .caption {
        opacity: 1;
    }

    .caption h3 {
        font-size: 18px;
        font-family: sans-serif;
    }

    h4 {
        font-size: 21px;
        font-family: sans-serif;
    }

    .caption p {
        font-size: 15px;
        color: #3c8dbc;
        font-family: sans-serif;
        margin: 2px 0 9px 0;
    }

    .caption .social-links a {
        color: #333;
        margin-right: 15px;
        font-size: 21px;
        transition: .6s;
    }

    .social-links a:hover {
        color: #0c52a1;
    }
    </style>

    <section class="content-header">
        <!-- <div style="color:green" align="right" id="todaysDate"></div> -->

        <h1><i class="fa fa-users" aria-hidden="true"></i>
            Contact Us
            <!-- <small>advanced tables</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="profile"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Contact Us</li>
            <!-- <li class="active">Update Password</li> -->
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <!-- <h3 class="box-title">Contact Us</h3> -->
                    </div><!-- /.box-header -->
                    <!-- <p class="text-blk team-head-text">
                        Contact Us
                    </p> -->
                    <p class="text-center m-auto" style="font-size: 14px;">For concerns regarding your account and
                        requests access kindly contact your designated group. </p>
                    <div class="row" style="padding-top: 20px; align-content: center; margin: 15px;">
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5" style="margin-bottom: 30px;">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-map-marker fa-5x mb-3" aria-hidden="true"></i>
                                    <h4 class="text-uppercase mb-5">office location</h4>
                                    <address style="text-align: center;font-size: 14px;padding-bottom: 13px; ">Upper
                                        Ground, North Wing, Island City Mall, Tagbilaran City, Bohol, Philippines 6300
                                    </address>
                                    <br><br><br><br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4 my-5" style="margin-bottom: 30px;">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-phone fa-5x mb-3" aria-hidden="true"></i>
                                    <h4 class="text-uppercase mb-5">call us</h4>
                                    <table style="font-size: 14px; " align="center">
                                        <tr>
                                            <td style="padding: 4px;">1847</td>
                                            <td style="text-align: left;">FARMS, GLASS SERVICE, AGRI, CWO, INSTITUTIONAL, ATP</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1822</td>
                                            <td style="text-align: left;">PMS/LEASING, BR, HMO, TMS
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1951</td>
                                            <td style="text-align: left;">FAD, TSMS</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1953</td>
                                            <td style="text-align: left;">GC</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1819</td>
                                            <td style="text-align: left;">WMS, MMS, VRS</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1844</td>
                                            <td style="text-align: left;">HRMS, TIMEKEEPING, CMS, ALTURUSH, VMS</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1821</td>
                                            <td style="text-align: left;">EBM, GO</td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px;">1825</td>
                                            <td style="text-align: left;">ICS, PAYPARKING </td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 4px; text-align: center;">1815/1801</td>
                                            <td style="text-align: left;">NAVISION </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4 my-5" style="margin-bottom: 30px;">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-paper-plane fa-5x mb-3" aria-hidden="true"></i>
                                    <h4 class="text-uppercase mb-5">email</h4>
                                    <p style="font-size: 14px; "><a
                                            href="mailto:itsysdev@alturasbohol.com">itsysdev@alturasbohol.com</a></p>
                                    <br><br><br><br><br><br><br><br><br><br><br>
                                </div>
                            </div>
                        </div>

                        <br><br><br><br>

                    </div>


                </div>
            </div>

            <div class="col-md-12">
                <div class="box box-default">
                    <!-- <div class="box-header"> -->

                    <div class="responsive-container-block container">
                        <p class="text-blk team-head-text">
                            Our Team
                        </p>

                        <div class="responsive-container-block">
                            <?php if (isset($emp['43864-2013'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['43864-2013']->photo?>">
                                    </div>
                                    <p class="text-blk name" style="text-uppercase">
                                        <?php echo $emp['43864-2013']->name?>
                                    </p>
                                    <p class="text-blk position">
                                        <span>CPA, CIA, CSCU, CISA, REB, REA, CICA, CrFA , REC</span>
                                        <br>
                                        <?php echo $emp['43864-2013']->position?>


                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['43864-2013']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['43864-2013']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="responsive-container-block">
                            <?php if (isset($emp['21114-2013'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['21114-2013']->photo?>">
                                    </div>
                                    <p class="text-blk name" style="text-uppercase">
                                        <?php echo $emp['21114-2013']->name?>
                                    </p>
                                    <p class="text-blk position">
                                        <?php echo $emp['21114-2013']->position?>
                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['21114-2013']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['21114-2013']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="responsive-container-block">
                            <?php if (isset($emp['02723-2022'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card ">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['02723-2022']->photo?>">
                                    </div>
                                    <p class="text-blk name text-uppercase">
                                        <?php echo $emp['02723-2022']->name?>
                                    </p>
                                    <p class="text-blk position">
                                        <?php echo $emp['02723-2022']->position?>
                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['02723-2022']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['02723-2022']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (isset($emp['03845-2015'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['03845-2015']->photo?>">
                                    </div>
                                    <p class="text-blk name">
                                        <?php echo $emp['03845-2015']->name?>
                                    </p>
                                    <p class="text-blk position">
                                        <?php echo $emp['03845-2015']->position?>
                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['03845-2015']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['03845-2015']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (isset($emp['03075-2022'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['03075-2022']->photo?>">
                                    </div>
                                    <p class="text-blk name text-uppercase">
                                        <?php echo $emp['03075-2022']->name?>
                                    </p>
                                    <p class="text-blk position">
                                        <?php echo $emp['03075-2022']->position?>
                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['03075-2022']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['03075-2022']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if (isset($emp['01472-2018'])): ?>
                            <div
                                class="responsive-cell-block wk-desk-3 wk-ipadp-3 wk-tab-6 wk-mobile-12 card-container">
                                <div class="card">
                                    <div class="team-image-wrapper">
                                        <img class="team-member-image"
                                            src="http://172.16.161.34:8080/hrms/<?php echo $emp['01472-2018']->photo?>">
                                    </div>
                                    <p class="text-blk name">
                                        <?php echo $emp['01472-2018']->name?>
                                    </p>
                                    <br>
                                    <p class="text-blk position">
                                        <?php echo $emp['01472-2018']->position?>
                                    </p>
                                    <p class="text-blk feature-text">
                                        <?php if($emp['01472-2018']->current_status != 'Active'){ ?>
                                        <span class="label label-danger" style="font-size: 100%;"> Inactive </span>
                                        <?php }else{ ?>
                                        <span class="label label-success" style="font-size: 100%;">
                                            <?php echo $emp['01472-2018']->current_status?> </span>
                                        <?php } ?>
                                    </p>
                                    <div class="social-icons">
                                        <!-- <a href="https://www.twitter.com" target="_blank">
                                        <img class="twitter-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon.svg">
                                      </a>
                                      <a href="https://www.facebook.com" target="_blank">
                                        <img class="facebook-icon" src="https://workik-widget-assets.s3.amazonaws.com/widget-assets/images/Icon-1.svg">
                                      </a> -->
                                    </div>

                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- </div>  -->
                </div>

            </div>

        </div>
    </section>

</div>

<?php $this->view('templates/footer'); ?>

<script type="text/javascript">
$(document).ready(function() {

    // $("#userSideTree").addClass('active');
    $("#contactSideNav").addClass('active');
});
</script>
<script type="text/javascript">
function swal_message(msg_type, msg) {
    var Toast = Swal.mixin({
        toast: false,
        position: 'center',
        showConfirmButton: true,


    });

    Toast.fire({
        icon: msg_type,
        title: msg
    })
}
<?php if($this->session->flashdata('success')) { ?>

swal_message('success', 'Password Successfully Updated!');
<?php } ?>

<?php if($this->session->flashdata('errormsg')) { ?>

swal_message('error', 'Old Password is Incorrect ');
<?php } ?>

// <?php if($this->session->flashdata('errormsg1')) { ?>

//     swal_message('error','The password must have atleast 1 capital letter and atleast 1 number ');
// <?php } ?>
</script>
<!-- <script type="text/javascript">
    $(document).ready(function() {
        $("#show_hide_Opassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Opassword input').attr("type") == "text"){
                $('#show_hide_Opassword input').attr('type', 'password');
                $('#show_hide_Opassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Opassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Opassword input').attr("type") == "password"){
                $('#show_hide_Opassword input').attr('type', 'text');
                $('#show_hide_Opassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Opassword i').addClass( "fa-eye" );
            }
        });
        $("#show_hide_Npassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Npassword input').attr("type") == "text"){
                $('#show_hide_Npassword input').attr('type', 'password');
                $('#show_hide_Npassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Npassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Npassword input').attr("type") == "password"){
                $('#show_hide_Npassword input').attr('type', 'text');
                $('#show_hide_Npassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Npassword i').addClass( "fa-eye" );
            }
        });
        $("#show_hide_Cpassword a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_Cpassword input').attr("type") == "text"){
                $('#show_hide_Cpassword input').attr('type', 'password');
                $('#show_hide_Cpassword i').addClass( "fa-eye-slash" );
                $('#show_hide_Cpassword i').removeClass( "fa-eye" );
            }else if($('#show_hide_Cpassword input').attr("type") == "password"){
                $('#show_hide_Cpassword input').attr('type', 'text');
                $('#show_hide_Cpassword i').removeClass( "fa-eye-slash" );
                $('#show_hide_Cpassword i').addClass( "fa-eye" );
            }
        });
    });
</script> -->


</body>

</html>