<div>
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">


<style type="text/css">
    
    .birthday-gift {
        position: relative;
    }

    .birthday-gift:before {
        content: "";
        position: absolute;
        width: 170px;
        height: 20px;
        border-radius: 50%;
        background-color: rgba(0,0,0,0.4);
        top: 130px;
        left: -10px;
    }

    .gift {
        position: relative;
        width: 150px;
        height: 100px;
        background-color: #e9c46a;
        border-radius: 10px 10px 0 0;
        box-shadow: inset 0 10px rgba(0,0,0,0.3);
        margin-top: 30px;
    }

    .candle {
        position: absolute;
        width: 10px;
        height: 50px;
        background-color: #ffffff;
        left: 70px;
        top: -40px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        z-index: 2; /* Ensure the candle is above the gift */
    }

    .flame {
        position: absolute;
        width: 10px;
        height: 20px;
        background-color: #ffcc00;
        border-radius: 50% 50% 50% 50%;
        top: -20px;
        left: -2px;
        animation: flicker 0.5s infinite alternate;
    }

    .wishes {
        position: absolute;
        color: #333;
        font-size: 25px;
        font-family: 'Brush Script MT';
        text-align: center;
        z-index: 3; /* Ensure the wishes are above the candle */
        left: 5px;
        transform: translateY(-150px); /* Adjust to position above the candle */
        transition: transform 0.5s;
        animation: showWishes 0.5s forwards 0.3s;
        
    }

    .hidden {
        display: none;
    }


    @keyframes showWishes {
        from { transform: translateY(0); }
        to { transform: translateY(-100px); }
    }

    @keyframes showSparkles {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fire3 {
        100% { transform: translateX(20px) translateY(-93px); opacity: 1; }
    }

    @keyframes fire2 {
        100% { transform: translateX(-5px) translateY(-90px); opacity: 1; }
    }

    @keyframes fire {
        100% { transform: translateX(-25px) translateY(-95px); opacity: 1; }
    }

    @keyframes color {
        from { background-color: #d00000; }
        to { background-color: #0081a7; }
    }

    @keyframes color2 {
        from { background-color: #8cff00; }
        to { background-color: #1d2d44; }
    }

    @keyframes flicker {
        from { transform: scale(1); }
        to { transform: scale(1.2); }
    }

    .bday{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 180px;
      margin-top: 50px;
    }

    .module-title {
      font-size: 16px;
      font-weight: bold;
      margin-top: 10px;
    }
    
    /* Style for module descriptions */
    .module-description {
      font-size: 14px;
      margin-bottom: 10px;
    }

    .section_padding_130 {
    padding-top: 10px;
    padding-bottom: 10px;
    }
    .faq_area {
        /*position: relative;
        z-index: 1;*/
        background-color: #ecf0f5;
        font-size: 14px;
        border-radius: 4px;
    }

        ./*faq-accordian {
        position: relative;
        z-index: 1;
    }*/
    .faq-accordian .card {
    /*    position: relative;*/
    /*    z-index: 1;*/
    /*    margin-bottom: 1.5rem;*/
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        
    }

    .faq-accordian .card .card-header:hover,
    .faq-accordian .card .card-header.clicked {
        
        font-weight: bold;
    }


    .faq-accordian .card:last-child {
        margin-bottom: 0;
    }
    .faq-accordian .card .card-header {
        background-color: #ffffff;
        padding: 0;
        border-bottom-color: #f0f0f0;
    }
    .faq-accordian .card .card-header h6 {
        cursor: pointer;
        padding: 10px;
        font-size: 14px;
        font-weight: bold;
        font-family: 'Inter-Regular','robotoregular', Arial, sans-serif;
        border-radius: 8px;

        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -ms-grid-row-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
        
        
    }

    h6, .h6 {
        margin-top: 10px;
        margin-bottom: 0px;
    }
    .faq-accordian .card .card-header h6 span {
        font-size: 15px;
        font-weight: bold;

    }
    .faq-accordian .card .card-header h6.collapsed {
        
    /*    font-weight: bold;*/

    }
    .faq-accordian .card .card-header h6.collapsed span {
        -webkit-transform: rotate(-180deg);
        transform: rotate(-180deg);
    }
    .faq-accordian .card .card-body {
    /*    padding: 14px;*/
        padding: 1.75rem 2rem;
        background-color: #ffffff;
    /*    line-height: 1rem;*/
    }
    .faq-accordian .card .card-header h6::after {
        font-family: 'FontAwesome';
        content: '\f106'; /* Unicode for the arrow-up icon in Font Awesome */
        font-weight: 900;
        margin-left: 8px;
        transition: transform 0.3s ease;
    }

    .faq-accordian .card .card-header h6.collapsed::after {
        content: '\f106'; /* Unicode for the arrow-down icon in Font Awesome */
        transform: rotate(180deg);
    }

    .faq-accordian .card .card-body p:last-child {
        margin-bottom: 0;
    }

    .blinking-text {
        animation: blink 1.5s infinite;
    }
    .box-primary{
        box-shadow: 0 0 20px #3336;
    }    
</style>
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
        <section class="content-header">
        <!-- <div style="color:#3c8dbc" align="right" id="todaysDate"></div> -->
        <a class="weatherwidget-io" href="https://forecast7.com/en/9d67123d87/tagbilaran-city/" data-label_1="TAGBILARAN CITY" data-label_2="WEATHER" data-font="Open Sans" data-icons="Climacons Animated" data-theme="weather_one" >TAGBILARAN CITY WEATHER</a>
        <script>
        !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
        </script>

        <!-- <iframe src="https://api.wo-cloud.com/content/widget/?geoObjectKey=17965514&language=en&region=US&timeFormat=HH:mm&windUnit=mph&systemOfMeasurement=imperial&temperatureUnit=fahrenheit" name="CW2" scrolling="no" width="318" height="318" frameborder="0" style="border: 1px solid #A0A0A0;border-radius: 8px"></iframe> -->
        <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
        <small>Control panel</small>
        </h1>
        </section>

        <section class="content">

            <?php 
                $currentDate = date("m-d");
                $birthday = "06-13";
                @$birthday1 = $this->session->bday;
                //var_dump($birthday1);
                //if($birthday == $currentDate AND $this->session->bday != "" AND $this->session->user_id == '622'){ 
                if(@$birthday1 == $currentDate){ 
                    // var_dump($birthday1);
                ?>
                <br>

                
                    <!-- <div class="bday">
                        <div class="birthday-gift" >
                        <div class="gift">
                            <input id='click' type='checkbox'>
                        
                        <label class='click' for='click' ><span style="color: #e76f51; padding: 5px; text-align: left; animation: blink 1s infinite;">open</span></label>
                        <div class="wishes">Happy Birthday!</div>
                            <div class="sparkles">
                                <div class="spark1"></div>
                                <div class="spark2"></div>
                                <div class="spark3"></div>
                                <div class="spark4"></div>
                                <div class="spark5"></div>
                                <div class="spark6"></div>
                            </div>
                        </div>
                        
                        </div>  
                    </div> -->

                    <div class="bday">
                    <div class="birthday-gift">
                        <div class="gift">
                            <div class="candle">
                                <div class="flame"></div>
                            </div>
                            <div class="wishes">Happy Birthday! <?= $this->session->fname?></div>
                            
                        </div>
                    </div>
                </div>
                
            <?php } ?>
            <script type="text/javascript" src="<?=base_url()?>assets/scripts/components/jquery.min.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $("[id=view_btn]").click(function(){
                    $("#hide_btn").removeClass("hidden");
                    $("#view_btn").addClass("hidden");
                    $("#view_panel").fadeIn();
                    
                    });
                    $("[id=hide_btn]").click(function(){
                    $("#hide_btn").addClass("hidden");
                    $("#view_btn").removeClass("hidden");
                    $("#view_panel").hide();
                    });       
                });
            </script>
            
            <div class="row">
                
                <div class="col-md-8">

                    <div class="box box-primary" style="box-shadow: 0 0 20px #3336;">
                        <div class="box-header ">
                            <h3 style="font-family: 'Inter-Regular'; color: red;" class="box-title blinking-text"> <i class="fa fa-question-circle-o" aria-hidden="true"> </i> <span >Frequently Asked Questions:</span></h3>
                            <div class="box-tools pull-right">
                                <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            
                            </div>
                        </div>
                            
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="faq_area section_padding_130" id="faq">
                                        <div style="padding: 10px;" class="row">
                                            <div class="col-md-6">
                                                <div class="accordion faq-accordian" id="faqAccordion">

                                                    
                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp; border-radius: 50px;">
                                                        <div class="card-header" id="headingOne">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">What is REQUEST FOR SETUP (RFS)?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#faqAccordion">
                                                            <div class="card-body">
                                                                <p>This module is intended only for those who have requested set-up.<br>
                                                              <i style="color: red;">Kini nga module gituyo lamang alang niadtong nangayo og set-up.</i><br>
                                                              (ex. Set up new Item/Account/Customer/Supplier).</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                                                        <div class="card-header" id="headingTwo">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">What is TRANSACTION OVERRIDE (TOR)?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#faqAccordion">
                                                            <div class="card-body">
                                                                <p>This module is intended only for those with adjustments, reprints, and a transaction to be canceled.<br>
                                                                    <i style="color: red;">Kini nga module gituyo lamang alang niadtong adunay mga kausaban, reprints, ug usa ka transaksyon nga kanselahon.</i><br>
                                                                    (ex. Requesting to cancel order slip)
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                                                        <div class="card-header" id="headingThree">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">What is INFORMATION SYSTEM REQUEST (ISR)?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#faqAccordion">
                                                            <div class="card-body">
                                                                <p>This module is intended only for those who request a New System Module/System Enhancement. <br>
                                                                  <i style="color: red;">Kini nga module gituyo lamang alang niadtong nangayo og Bag-ong System Module/System Enhancement.</i><br>
                                                                  (ex. To request an Inhouse System for Meat Processing)</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="col-md-6">
                                                <div class="accordion faq-accordian" id="faqAccordion2">

                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                                                        <div class="card-header" id="heading4">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">Why can't I access/locate the request?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapse4" aria-labelledby="heading4" data-parent="#faqAccordion2">
                                                            <div class="card-body">
                                                                <p>Check first the tagged <b>business unit, type of request and usergroup</b> of the request through REQUEST LOGS then check if those tagged items matches your access.<br> If it doesn't match, call <b>1847</b> to update your access.
                                                              </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeInUp;">
                                                        <div class="card-header" id="heading5">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">When to call or contact IT SysDev or MIS to execute the request?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapse5" aria-labelledby="heading5" data-parent="#faqAccordion2">
                                                            <div class="card-body">
                                                                <p>You can <b>only</b> call the executor once the request is already approved and verified or if it is an urgent matter.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                                                        <div class="card-header" id="heading6">
                                                            <h6 class="mb-0 collapsed" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">What is my default username and password?<span class="lni-chevron-up"></span></h6>
                                                        </div>
                                                        <div class="collapse" id="collapse6" aria-labelledby="heading6" data-parent="#faqAccordion2">
                                                            <div class="card-body">
                                                                <p>The default username is your <b>Employee No.</b> (you can locate it on your HRMS profile) then the default password is <b>Torrfs2022</b></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>           
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-primary">

                        <div class="box-header ">
                            <h3 class="box-title"><i class="fa fa-clock-o"></i> </h3>

                            <div class="box-tools pull-right">
                                <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            
                            </div>
                        </div>

                        <div class="box-body">
                            <div id="clock" class="light ">
                                <div class="display">
                                    <div class="weekdays"></div>
                                    <div class="ampm"></div>
                                    <div class="alarm"></div>
                                    <div class="digits"></div>

                                    <div class="date" style="text-align: center;">
                                        <span><?= date("m-d-Y") ?></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
            <?php if($getType1 == true){ ?>

                

                <!-- <div class="row">
                    <p style="padding-left: 12px; color: #367fa9; font-weight: bold; margin: 0 0 5px;">(Admin)</p> <i class="fa fa-clock-o"></i> Clock
                </div> -->
                <div class="row">
                    <div class="col-lg-4 col-xs-12">
                      
                        <div class="small-box bg-blue">
                            <div class="inner">
                               
                                <h3 class="counter"><?php echo $this->db->where('status', '1')->count_all_results('users2');?></h3>
                                <p>Active Users</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="<?=base_url('view-users')?>" class="small-box-footer">
                                 <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    

                    <div class="col-lg-4 col-xs-12">
                      
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <!-- <h3><?php echo $this->db->count_all('business_unit') ;?></h3> -->
                                <h3 class="counter"><?php echo $this->db->where('status', 'active')->count_all_results('business_unit');?></h3>

                                <p>Business Units</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="<?=base_url('view-bu')?>" class="small-box-footer">
                                 <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-xs-12">
                      <!-- small box -->
                        <div class="small-box bg-blue">
                            <div class="inner">
                              <h3 class="counter"><?php echo $this->db->count_all('company') ;?></h3>
                              <p>Companies</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clipboard"></i>
                            </div>
                            <a href="<?=base_url('view-bu')?>" class="small-box-footer">
                               <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                </div>

                <script type="text/javascript">
                        $(document).ready(function() {
                            $('.counter').each(function () {
                                $(this).prop('Counter',0).animate({
                                    Counter: $(this).text()
                                }, {
                                    duration: 5000,
                                    easing: 'swing',
                                    step: function (now) {
                                        $(this).text(Math.ceil(now));
                                    }
                                });
                            });
                        });
                    </script>
            <?php } ?>
            <br>

            
            <div class="row">
                <?php if($getType2 == true){ ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header ">
                          <h3 class="box-title">Request</h3>

                          <div class="box-tools pull-right">
                            <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <!-- <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="chart-responsive">
                                <canvas id="pieChart4" height="150"></canvas>

                                <script>
                                  $( document ).ready(function () {
                                    
                                    const canvas = document.getElementById('pieChart4');
                                    
                                    const ctx = canvas.getContext('2d');
                                    var pieChart       = new Chart(ctx)
                                    var PieData        = [
                                      
                                      {
                                        value    : <?php  
                                                    foreach($rfs1 as $r) {
                                                        {
                                                            echo($r->rfs);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#00c0ef',
                                        highlight: '#00c0ef',
                                        label    : 'Pending RFS'
                                      },
                                      {
                                        value    : <?php  
                                                    foreach($tor1 as $r) {
                                                        {
                                                            echo($r->tor);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#3c8dbc',
                                        highlight: '#3c8dbc',
                                        label    : 'Pending TOR'
                                      },
                                      {
                                        value    : <?php  
                                                    foreach($isr1 as $r) {
                                                        {
                                                            echo($r->isr);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#d2d6de',
                                        highlight: '#d2d6de',
                                        label    : 'Pending ISR'
                                      }
                                    ]
                                    var pieOptions     = {
                                      //Boolean - Whether we should show a stroke on each segment
                                      segmentShowStroke    : true,
                                      //String - The colour of each segment stroke
                                      segmentStrokeColor   : '#fff',
                                      //Number - The width of each segment stroke
                                      segmentStrokeWidth   : 2,
                                      //Number - The percentage of the chart that we cut out of the middle
                                      percentageInnerCutout: 50, // This is 0 for Pie charts
                                      //Number - Amount of animation steps
                                      animationSteps       : 100,
                                      //String - Animation easing effect
                                      animationEasing      : 'easeOutBounce',
                                      //Boolean - Whether we animate the rotation of the Doughnut
                                      animateRotate        : true,
                                      //Boolean - Whether we animate scaling the Doughnut from the centre
                                      animateScale         : false,
                                      //Boolean - whether to make the chart responsive to window resizing
                                      responsive           : true,
                                      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                      maintainAspectRatio  : true,
                                      //String - A legend template
                                      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
                                    }
                                    //Create pie or douhnut chart
                                    // You can switch between pie and douhnut using the method below.
                                    pieChart.Doughnut(PieData, pieOptions)

                                    
                                  })
                                </script>
                              </div>
                              <!-- ./chart-responsive -->
                            </div>
                            <div style="text-align: center;" class="col-md-12">
                              
                                
                                <i class="fa fa-circle-o text-aqua fa-lg fa-lg"></i> RFS &nbsp;
                                <i class="fa fa-circle-o text-light-blue fa-lg fa-lg"></i> TOR &nbsp;
                                <i class="fa fa-circle-o text-gray fa-lg"></i> ISR &nbsp;
                              
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                          <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?=base_url('view-rfs')?>">Pending RFS
                                <span class="pull-right "> <b><?php  
                                                    foreach($rfs1 as $r) {
                                                        {
                                                            echo($r->rfs);
                                                        }
                                                    }
                                                    ?></b></span></a></li>
                            <li><a href="<?=base_url('view-tor')?>">Pending TOR 
                                <span class="pull-right "> <b><?php  
                                                    foreach($tor1 as $r) {
                                                        {
                                                            echo($r->tor);
                                                        }
                                                    }
                                                    ?></b></span></a>
                            </li>
                            <?php if($getIsr == true){ ?>
                            <li><a href="<?=base_url('view-isr')?>">Pending ISR
                                <span class="pull-right "> <b><?php  
                                                    foreach($isr1 as $r) {
                                                        {
                                                            echo($r->isr);
                                                        }
                                                    }
                                                    ?></b>
                                </span>
                            </a></li>
                            <?php } ?>
                          </ul>
                        </div>
                        <!-- /.footer -->
                    </div>
                </div>
                <?php } ?>

                <?php if($getType3 == true){ ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header ">
                          <h3 class="box-title">Approve</h3>

                          <div class="box-tools pull-right">
                            <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <!-- <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="chart-responsive">
                                <canvas id="pieChart5" height="150"></canvas>

                                <script>
                                  $( document ).ready(function () {
                                    
                                    const canvas = document.getElementById('pieChart5');
                                    
                                    const ctx = canvas.getContext('2d');
                                    var pieChart       = new Chart(ctx)
                                    var PieData        = [
                                      
                                      {
                                        value    : <?php  
                                                    foreach($rfsA as $r) {
                                                        {
                                                            echo($r->rfsA);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#00c0ef',
                                        highlight: '#00c0ef',
                                        label    : 'Pending RFS'
                                      },
                                      {
                                        value    : <?php  
                                                    foreach($torA as $r) {
                                                        {
                                                            echo($r->torA);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#3c8dbc',
                                        highlight: '#3c8dbc',
                                        label    : 'Pending TOR'
                                      },
                                      {
                                        value    : <?php  
                                                    foreach($isrA as $r) {
                                                        {
                                                            echo($r->isrA);
                                                        }
                                                    }
                                                    ?>,
                                        color    : '#d2d6de',
                                        highlight: '#d2d6de',
                                        label    : 'Pending ISR'
                                      }
                                    ]
                                    var pieOptions     = {
                                      //Boolean - Whether we should show a stroke on each segment
                                      segmentShowStroke    : true,
                                      //String - The colour of each segment stroke
                                      segmentStrokeColor   : '#fff',
                                      //Number - The width of each segment stroke
                                      segmentStrokeWidth   : 2,
                                      //Number - The percentage of the chart that we cut out of the middle
                                      percentageInnerCutout: 50, // This is 0 for Pie charts
                                      //Number - Amount of animation steps
                                      animationSteps       : 100,
                                      //String - Animation easing effect
                                      animationEasing      : 'easeOutBounce',
                                      //Boolean - Whether we animate the rotation of the Doughnut
                                      animateRotate        : true,
                                      //Boolean - Whether we animate scaling the Doughnut from the centre
                                      animateScale         : false,
                                      //Boolean - whether to make the chart responsive to window resizing
                                      responsive           : true,
                                      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                      maintainAspectRatio  : true,
                                      //String - A legend template
                                      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
                                    }
                                    //Create pie or douhnut chart
                                    // You can switch between pie and douhnut using the method below.
                                    pieChart.Doughnut(PieData, pieOptions)

                                    
                                  })
                                </script>
                              </div>
                              <!-- ./chart-responsive -->
                            </div>
                            <div style="text-align: center;" class="col-md-12">
                              
                                
                                <i class="fa fa-circle-o text-aqua fa-lg"></i> RFS &nbsp;
                                <i class="fa fa-circle-o text-light-blue fa-lg"></i> TOR &nbsp;
                                <i class="fa fa-circle-o text-gray fa-lg"></i> ISR &nbsp;
                              
                            </div>
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                          <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?=base_url('pending-rfs-status')?>">Pending RFS
                                <span class="pull-right "> <b><?php  
                                                    foreach($rfsA as $r) {
                                                        {
                                                            echo($r->rfsA);
                                                        }
                                                    }
                                                    ?></b></span></a></li>
                            <li><a href="<?=base_url('pending-tor-status')?>">Pending TOR 
                                <span class="pull-right "> <b><?php  
                                                    foreach($torA as $r) {
                                                        {
                                                            echo($r->torA);
                                                        }
                                                    }
                                                    ?></b></span></a>
                            </li>
                            <?php if($getIsr == true){ ?>
                            <li><a href="<?=base_url('pending-isr-status')?>">Pending ISR
                                <span class="pull-right "> <b><?php  
                                                    foreach($isrA as $r) {
                                                        {
                                                            echo($r->isrA);
                                                        }
                                                    }
                                                    ?></b>
                                </span>
                            </a></li>
                            <?php } ?>
                          </ul>
                        </div>
                        <!-- /.footer -->
                    </div>
                </div>
                <?php } ?>

                <?php if($getType4 == true){ ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-header ">
                          <h3 class="box-title">Execute</h3>

                          <div class="box-tools pull-right">
                            <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <!-- <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="chart-responsive">
                                <canvas id="pieChart6" height="150"></canvas>

                                <script>
                                    $( document ).ready(function () {
                                    
                                    const canvas = document.getElementById('pieChart6');
                                    
                                    const ctx = canvas.getContext('2d');
                                    var pieChart       = new Chart(ctx)

                                    var PieData        = [
                                      
                                      {
                                        value    : <?php  
                                                foreach($rfs as $r) {
                                                    {
                                                        echo($r->rfs);
                                                    }
                                                }
                                                ?>,
                                        color    : '#00c0ef',
                                        highlight: '#00c0ef',
                                        label    : 'Pending RFS'
                                      },
                                      {
                                        value    : <?php  
                                                foreach($tor as $r) {
                                                    {
                                                        echo($r->tor);
                                                    }
                                                }
                                                ?>,
                                        color    : '#3c8dbc',
                                        highlight: '#3c8dbc',
                                        label    : 'Pending TOR'
                                      },
                                      {
                                        value    : <?php  
                                                foreach($isr as $r) {
                                                    {
                                                        echo($r->isr);
                                                    }
                                                }
                                                ?>,
                                        color    : '#d2d6de',
                                        highlight: '#d2d6de',
                                        label    : 'Pending ISR'
                                      }



                                    ]

                        
                                    var pieOptions     = {

                                      
                                      //Boolean - Whether we should show a stroke on each segment
                                      segmentShowStroke    : true,
                                      //String - The colour of each segment stroke
                                      segmentStrokeColor   : '#fff',
                                      //Number - The width of each segment stroke
                                      segmentStrokeWidth   : 2,
                                      //Number - The percentage of the chart that we cut out of the middle
                                      percentageInnerCutout: 50, // This is 0 for Pie charts
                                      //Number - Amount of animation steps
                                      animationSteps       : 100,
                                      //String - Animation easing effect
                                      animationEasing      : 'easeOutBounce',
                                      //Boolean - Whether we animate the rotation of the Doughnut
                                      animateRotate        : true,
                                      //Boolean - Whether we animate scaling the Doughnut from the centre
                                      animateScale         : false,
                                      //Boolean - whether to make the chart responsive to window resizing
                                      responsive           : true,
                                      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                      maintainAspectRatio  : true,
                                      //String - A legend template
                                      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
                                    }
                                    //Create pie or douhnut chart
                                    // You can switch between pie and douhnut using the method below.
                                    pieChart.Doughnut(PieData, pieOptions)

                                    
                                  })
                                </script>
                              </div>
                              <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div style="text-align: center;" class="col-md-12">
                              
                                
                                <i class="fa fa-circle-o text-aqua fa-lg"></i> RFS &nbsp;
                                <i class="fa fa-circle-o text-light-blue fa-lg"></i> TOR &nbsp;
                                <i class="fa fa-circle-o text-gray fa-lg fa-lg"></i> ISR &nbsp;
                              
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer no-padding">
                          <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?=base_url('pending-rfs-status-e')?>">Pending RFS
                                <span class="pull-right "> <b><?php  
                                                    foreach($rfs as $r) {
                                                        {
                                                            echo($r->rfs);
                                                        }
                                                    }
                                                    ?></b></span></a></li>
                            <li><a href="<?=base_url('pending-tor-status-e')?>">Pending TOR 
                                <span class="pull-right "> <b><?php  
                                                    foreach($tor as $r) {
                                                        {
                                                            echo($r->tor);
                                                        }
                                                    }
                                                    ?></b></span></a>
                            </li>
                            <?php if($getIsr == true){ ?>
                            <li><a href="<?=base_url('pending-isr-status-e')?>">Pending ISR
                               <span class="pull-right "> <b><?php  
                                                    foreach($isr as $r) {
                                                        {
                                                            echo($r->isr);
                                                        }
                                                    }
                                                    ?></b>
                                </span>
                            </a></li>
                            <?php } ?>
                          </ul>
                        </div>
                        <!-- /.footer -->
                    </div>
                </div>
                <?php } ?>
            </div>

            <?php if($getType1 == true){ ?>
                <div class="row" style="margin-top: 10px;">
                    <!-- <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header " style="text-align: center;">
                                <h3 class="box-title" >Number of Requests per Month</h3>

                                <div class="box-tools pull-right">
                                    <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                               
                                </div>
                            </div>
                            
                            <div class="box-body">
                                <div style="text-align: center;" >
                                  
                                    
                                    <i class="fa fa-circle-o text-aqua fa-lg"></i> RFS &nbsp;
                                    <i class="fa fa-circle-o text-light-blue fa-lg"></i> TOR &nbsp;
                                    <i class="fa fa-circle-o text-gray fa-lg"></i> ISR &nbsp;
                                  
                                </div>

                                <div class="chart-responsive">
                                    <canvas id="areaChart" height="100"></canvas>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            
                                            const canvas = document.getElementById('areaChart');
                                            
                                            const ctx = canvas.getContext('2d');
                                            var areaChart       = new Chart(ctx)
                                        
                                            function fetchDataCountByMonth() {
                                            
                                           
                                            //const selectedYear = document.getElementById('yearFilter').value;
                                            // const apiUrl = `<?= site_url('Admin/getDataCountByYear'); ?>?year=${selectedYear}`;
                                            const apiUrl = '<?= site_url('Admin/getDataCountByMonth'); ?>';
                                            // Make an AJAX request to fetch the data
                                            fetch(apiUrl)
                                                .then(response => response.json())
                                                .then(data => {
                                                    // Process the data to extract labels and data points
                                                    
                                                    const labels = Object.keys(data); // Dynamically get the months from the data
                                                    const dataPointsRfs = [];
                                                    const dataPointsTor = [];
                                                    const dataPointsIsr = [];

                                                    labels.forEach(month => {
                                                        dataPointsRfs.push(data[month].rfs_count);
                                                        dataPointsTor.push(data[month].tor_count);
                                                        dataPointsIsr.push(data[month].isr_count);
                                                    });
                                                    
                                                    // Create the areaChartData object
                                                    var areaChartData = {
                                                        labels  : labels,
                                                          datasets: [
                                                            {
                                                                label               : 'RFS',
                                                                fillColor           : '#00c0ef',
                                                                strokeColor         : '#00c0ef',
                                                                pointColor          : '#00c0ef',
                                                                pointStrokeColor    : '#c1c7d1',
                                                                pointHighlightFill  : '#fff',
                                                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                data                :  dataPointsRfs
                                                            },
                                                            {
                                                                labels              : 'TOR', 
                                                                fillColor           : '#3c8dbc',
                                                                strokeColor         : '#3c8dbc',
                                                                pointColor          : '#3c8dbc',
                                                                pointStrokeColor    : '#c1c7d1',
                                                                pointHighlightFill  : '#fff',
                                                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                data                :  dataPointsTor
                                                            },
                                                            {
                                                                labels              : 'ISR', 
                                                                fillColor           : '#d2d6de',
                                                                strokeColor         : '#d2d6de',
                                                                pointColor          : '#d2d6de',
                                                                pointStrokeColor    : '#c1c7d1',
                                                                pointHighlightFill  : '#fff',
                                                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                data                :  dataPointsIsr
                                                            }
                                                        ]
                                                    };

                                                    var areaChartOptions = {
                                                        //Boolean - If we should show the scale at all
                                                        showScale               : true,
                                                        //Boolean - Whether grid lines are shown across the chart
                                                        scaleShowGridLines      : false,
                                                        //String - Colour of the grid lines
                                                        scaleGridLineColor      : 'rgba(0,0,0,.05)',
                                                        //Number - Width of the grid lines
                                                        scaleGridLineWidth      : 1,
                                                        //Boolean - Whether to show horizontal lines (except X axis)
                                                        scaleShowHorizontalLines: true,
                                                        //Boolean - Whether to show vertical lines (except Y axis)
                                                        scaleShowVerticalLines  : true,
                                                        //Boolean - Whether the line is curved between points
                                                        bezierCurve             : true,
                                                        //Number - Tension of the bezier curve between points
                                                        bezierCurveTension      : 0.3,
                                                        //Boolean - Whether to show a dot for each point
                                                        pointDot                : true,
                                                        //Number - Radius of each point dot in pixels
                                                        pointDotRadius          : 2,
                                                        //Number - Pixel width of point dot stroke
                                                        pointDotStrokeWidth     : 0.5,
                                                        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                                                        pointHitDetectionRadius : 20,
                                                        //Boolean - Whether to show a stroke for datasets
                                                        datasetStroke           : true,
                                                        //Number - Pixel width of dataset stroke
                                                        datasetStrokeWidth      : 2,
                                                        //Boolean - Whether to fill the dataset with a color
                                                        datasetFill             : false,
                                                        //String - A legend template
                                                      
                                                        legendTemplate: '<p class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></p>',
                                                        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                                        maintainAspectRatio     : true,
                                                        //Boolean - whether to make the chart responsive to window resizing
                                                        responsive              : true,
                                                        
                                                      
                                                    }

                                                    // Create the line chart with the fetched data
                                                    var areaChart = new Chart(ctx).Line(areaChartData, areaChartOptions);
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching data:', error);
                                                });
                                            }

                                            // Call the fetchDataCountByMonth function to fetch data count for each month.
                                            fetchDataCountByMonth();
                                        })
                                    </script> 
                                </div>
                            </div>
                            
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header" style="text-align: center;">
                                <h3 class="box-title">Number of Requests per Month</h3>
                                <div class="box-tools pull-right">
                                    <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>

                            <div class="box-body">
                                <div style="text-align: center;">
                                    <i class="fa fa-circle-o text-aqua fa-lg"></i> RFS &nbsp;
                                    <i class="fa fa-circle-o text-light-blue fa-lg"></i> TOR &nbsp;
                                    <i class="fa fa-circle-o text-gray fa-lg"></i> ISR &nbsp;
                                </div>

                                <!-- Year Filter Dropdown -->
                                <div style="text-align: center; margin-bottom: 10px;">
                                    <select id="yearFilter" class="form-control" style="width: auto; display: inline-block;">
                                        <option value="">Select Year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <!-- Add more years as needed -->
                                    </select>
                                </div>

                                <div class="chart-responsive">
                                    <canvas id="areaChart" height="100"></canvas>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const canvas = document.getElementById('areaChart');
                                            const ctx = canvas.getContext('2d');
                                            let areaChart = new Chart(ctx);

                                            function fetchDataCountByMonth(year) {
                                                const apiUrl = `<?= site_url('Admin/getDataCountByMonth'); ?>?year=${year}`;
                                                fetch(apiUrl)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        const labels = Object.keys(data);
                                                        const dataPointsRfs = [];
                                                        const dataPointsTor = [];
                                                        const dataPointsIsr = [];

                                                        labels.forEach(month => {
                                                            dataPointsRfs.push(data[month].rfs_count);
                                                            dataPointsTor.push(data[month].tor_count);
                                                            dataPointsIsr.push(data[month].isr_count);
                                                        });

                                                        const areaChartData = {
                                                            labels: labels,
                                                            datasets: [
                                                                {
                                                                    label: 'RFS',
                                                                    fillColor: '#00c0ef',
                                                                    strokeColor: '#00c0ef',
                                                                    pointColor: '#00c0ef',
                                                                    pointStrokeColor: '#c1c7d1',
                                                                    pointHighlightFill: '#fff',
                                                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                    data: dataPointsRfs
                                                                },
                                                                {
                                                                    label: 'TOR',
                                                                    fillColor: '#3c8dbc',
                                                                    strokeColor: '#3c8dbc',
                                                                    pointColor: '#3c8dbc',
                                                                    pointStrokeColor: '#c1c7d1',
                                                                    pointHighlightFill: '#fff',
                                                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                    data: dataPointsTor
                                                                },
                                                                {
                                                                    label: 'ISR',
                                                                    fillColor: '#d2d6de',
                                                                    strokeColor: '#d2d6de',
                                                                    pointColor: '#d2d6de',
                                                                    pointStrokeColor: '#c1c7d1',
                                                                    pointHighlightFill: '#fff',
                                                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                    data: dataPointsIsr
                                                                }
                                                            ]
                                                        };

                                                        const areaChartOptions = {
                                                            showScale: true,
                                                            scaleShowGridLines: false,
                                                            scaleGridLineColor: 'rgba(0,0,0,.05)',
                                                            scaleGridLineWidth: 1,
                                                            scaleShowHorizontalLines: true,
                                                            scaleShowVerticalLines: true,
                                                            bezierCurve: true,
                                                            bezierCurveTension: 0.3,
                                                            pointDot: true,
                                                            pointDotRadius: 2,
                                                            pointDotStrokeWidth: 0.5,
                                                            pointHitDetectionRadius: 20,
                                                            datasetStroke: true,
                                                            datasetStrokeWidth: 2,
                                                            datasetFill: false,
                                                            maintainAspectRatio: true,
                                                            responsive: true,
                                                        };

                                                        // areaChart.destroy(); // Destroy the previous chart instance
                                                        canvas.width = canvas.width;
                                                        areaChart = new Chart(ctx).Line(areaChartData, areaChartOptions);
                                                    })
                                                    .catch(error => {
                                                        console.error('Error fetching data:', error);
                                                    });
                                            }

                                            // Call the fetchDataCountByMonth function initially for all years.
                                            fetchDataCountByMonth('');

                                            // Update chart when year is changed
                                            document.getElementById('yearFilter').addEventListener('change', function () {
                                                const selectedYear = this.value;
                                                fetchDataCountByMonth(selectedYear);
                                            });
                                        });

                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header " style="text-align: center;">
                              <h3 class="box-title">Number of Pending Requests per Group</h3>

                              <div class="box-tools pull-right">
                                <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <!-- <button style="border: none;" type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                              </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div style="text-align: center;" >
                                    
                                    <i class="fa fa-circle-o text-aqua fa-lg"></i> RFS &nbsp;
                                    <i class="fa fa-circle-o text-light-blue fa-lg"></i> TOR &nbsp;
                                   
                                  
                                </div>
                                <div class="chart-responsive">
                                    <canvas id="areaChart2" height="100" ></canvas>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            
                                            const canvas = document.getElementById('areaChart2');
                                            
                                            const ctx = canvas.getContext('2d');
                                            var areaChart       = new Chart(ctx)
                                        
                                            function fetchDataCountByGroup() {
                                            
                                            const apiUrl = '<?= site_url('Admin/getPendingCountByGroup'); ?>';

                                            // Make an AJAX request to fetch the data
                                            fetch(apiUrl)
                                                .then(response => response.json())
                                                .then(data => {
                                                    // Process the data to extract labels and data points
                                                    
                                                    const labels = Object.keys(data); // Dynamically get the months from the data
                                                    const dataPointsRfs = [];
                                                    const dataPointsTor = [];
                                                    

                                                    labels.forEach(group_name => {
                                                        dataPointsRfs.push(data[group_name].rfs_count);
                                                        dataPointsTor.push(data[group_name].tor_count);
                                                        
                                                    });
                                                    
                                                    // Create the areaChartData object
                                                    var areaChartData = {
                                                        labels  : labels,
                                                          datasets: [
                                                            {
                                                                label               : 'RFS',
                                                                fillColor           : '#00c0ef',
                                                                strokeColor         : '#00c0ef',
                                                                pointColor          : '#00c0ef',
                                                                pointStrokeColor    : '#c1c7d1',
                                                                pointHighlightFill  : '#fff',
                                                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                data                :  dataPointsRfs
                                                            },
                                                            {
                                                                labels              : 'TOR', 
                                                                fillColor           : '#3c8dbc',
                                                                strokeColor         : '#3c8dbc',
                                                                pointColor          : '#3c8dbc',
                                                                pointStrokeColor    : '#c1c7d1',
                                                                pointHighlightFill  : '#fff',
                                                                pointHighlightStroke: 'rgba(220,220,220,1)',
                                                                data                :  dataPointsTor
                                                            }
                                                        ]
                                                    };

                                                    var areaChartOptions = {
                                                        //Boolean - If we should show the scale at all
                                                        showScale               : true,
                                                        //Boolean - Whether grid lines are shown across the chart
                                                        scaleShowGridLines      : false,
                                                        //String - Colour of the grid lines
                                                        scaleGridLineColor      : 'rgba(0,0,0,.05)',
                                                        //Number - Width of the grid lines
                                                        scaleGridLineWidth      : 1,
                                                        //Boolean - Whether to show horizontal lines (except X axis)
                                                        scaleShowHorizontalLines: true,
                                                        //Boolean - Whether to show vertical lines (except Y axis)
                                                        scaleShowVerticalLines  : true,
                                                        //Boolean - Whether the line is curved between points
                                                        bezierCurve             : true,
                                                        //Number - Tension of the bezier curve between points
                                                        bezierCurveTension      : 0.3,
                                                        //Boolean - Whether to show a dot for each point
                                                        pointDot                : true,
                                                        //Number - Radius of each point dot in pixels
                                                        pointDotRadius          : 2,
                                                        //Number - Pixel width of point dot stroke
                                                        pointDotStrokeWidth     : 0.5,
                                                        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                                                        pointHitDetectionRadius : 20,
                                                        //Boolean - Whether to show a stroke for datasets
                                                        datasetStroke           : true,
                                                        //Number - Pixel width of dataset stroke
                                                        datasetStrokeWidth      : 2,
                                                        //Boolean - Whether to fill the dataset with a color
                                                        datasetFill             : false,
                                                        //String - A legend template
                                                      
                                                        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                                                        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                                                        maintainAspectRatio     : true,
                                                        //Boolean - whether to make the chart responsive to window resizing
                                                        responsive              : true,
                                                        legend: {
                                                            display: true, // Set this to true to show the legend
                                                            position: 'top', // You can change the position of the legend (top, bottom, left, right)
                                                            labels: {
                                                                fontColor: '#333', // Set the font color for the legend labels
                                                                fontSize: 12 // Set the font size for the legend labels
                                                            }
                                                        },
                                                      
                                                    }

                                                    // Create the line chart with the fetched data
                                                    var areaChart = new Chart(ctx).Line(areaChartData, areaChartOptions);
                                                })
                                                .catch(error => {
                                                    console.error('Error fetching data:', error);
                                                });
                                            }

                                            // Call the fetchDataCountByMonth function to fetch data count for each month.
                                            fetchDataCountByGroup();
                                        })
                                    </script> 
                                </div>
                            </div>
                            <!-- /.box-body-->
                        </div>
                    </div> 
                </div>

                <!-- <div class="row" style="margin-top: 10px;">
                    
                </div> -->
            <?php } ?>

            <!-- <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Memo</h3>
                        </div>
                    
                        <div class="box-body"> 

                            <img src="http://172.16.161.43/rfstor/uploads/profile-pic/TOR&RFS MEMO.jpg" class="img-fluid mx-auto" style="margin: 20px;  position: center;">   
                        </div>
                    </div>
                </div>
                
            </div> -->

            <div id="memoModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg" style="width: 85%;">
                    <div class="modal-content" style="border-radius: 10px">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button> 
                            <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                        <h4 style="text-align: center;" class="modal-title"><b>Memo</b></h4>
                        </div>
                        <div class="modal-body">
                    
                            <iframe src="<?=base_url()?>uploads/profile-pic/TOR&RFS MEMO.jpg" width="100%" height="600" allow="autoplay"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row" >

                <div class="col-xs-12 text-left">
                    <div style="margin-top: 5px;" class="form-group">
                        <a class="btn btn-primary" data-toggle="modal" data-target="#memoModal"><i class="fa fa-eye" aria-hidden="true"></i> Show Memo</a>
                        <a class="btn btn-primary " id="view_btn"><i class="fa fa-eye" aria-hidden="true"></i> Show Profile</a>
                        <a class="btn btn-primary hidden" id="hide_btn"><i class="fa fa-eye-slash" aria-hidden="true"></i> Hide Profile</a>
                    </div>

                    
                </div>
            </div>

            <div class="row" id="view_panel" hidden>

                <?php
                $data = $this->Admin_Model->getUserData();
                ?>
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-body box-profile">

                            <?php 
                                //$profile = $this->employee_model->find_employee_name($this->session->emp_id);

                                if($this->session->location != 'Bohol' || $this->session->emp_id == '03845-2015'){
                                    echo'<img src="http://172.16.161.43/rfstor/uploads/profile-pic/'.$this->session->profile_pic.'" class="profile-user-img img-responsive img-circle" alt="User Image">';
                                }else{
                                    echo'<img src="http://172.16.161.34:8080/hrms/'.$this->session->profile_pic.'" class="profile-user-img img-responsive img-circle" alt="User Image">';
                                }
                                

                            ?>
                            <!-- <img src="http://172.16.161.34:8080/hrms<?=$this->session->profile_pic ?>" style="height: 100px; width: 100px;" class="profile-user-img img-responsive img-circle" alt="User Image"> -->

                            <!-- <h3 class="profile-username text-center"><?=$this->session->fname ?> <?=$this->session->lname ?></h3> -->

                            <p class="text-muted text-center"><?php echo $data->username; ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                  <b> ID</b> <a class="pull-right text-muted"><?php echo $data->user_id; ?></a>
                                </li>
                                <li class="list-group-item">
                                  <b>Username</b> <a class="pull-right text-muted"> <?php echo $data->username; ?></a>
                                </li>
                            </ul>

                            <a class="btn btn-primary btn-block" href="<?=base_url('update-profile')?>"><i class="fa fa-edit"></i> Update Profile</a>
                            <!-- <a class="btn btn-primary btn-block" href="<?=base_url('change-pass')?>"><i class="fa fa-edit"></i> Update Password</a> -->
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
                
                <div class="col-md-8"><!-- About Me Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">About Me</h3>
                        </div><!-- /.box-header -->
                    
                        <div class="box-body">
                            <strong><i class="fa fa-user margin-r-5"></i> Full Name</strong>
                                <p class="text-muted">
                                    <?php echo $this->session->name; ?>
                                </p>
                                <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Position</strong>
                                <p class="text-muted">
                                    <?php echo $this->session->position; ?></p>
                                <hr>
                            <!-- <strong><i class="fa fa-venus margin-r-5"></i> Main Task</strong>
                                <p class="text-muted">
                                    <?php echo $data->usertype; ?> </p>
                                <hr>
                            <strong><i class="fa fa-phone margin-r-5"></i> Main Group</strong>
                                <p class="text-muted"><?php echo $data->groupname; ?></p>
                            <hr> -->
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Company</strong>
                                <p class="text-muted">
                                    <?php echo @$this->session->cc->acroname; ?>  -  <?php echo @$this->session->cc->company; ?></p> 
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Business Unit</strong>
                                <p class="text-muted">
                                    <?php echo @$this->session->bu->business_unit; ?></p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Department</strong>
                                <p class="text-muted">
                                    <?php echo @$this->session->dept->dept_name; ?></p>
                            <hr>
                            <strong><i class="fa fa-map-marker margin-r-5"></i> Section</strong>
                                <p class="text-muted">
                                    <?php echo @$this->session->sect->section_name; ?></p>  

                             
                        </div><!-- /.box-body -->   
                    </div><!-- /.box -->
                </div><!-- /.col -->
                
            </div>
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            For inquiries about the <b>Online TOR & RFS</b>, please click <b><a href="<?=base_url('view-contact')?>"> here </a></b>.

        </div>
         <strong> &copy; </strong>2022 - <?php echo date('Y'); ?> <strong>Online TOR & RFS</strong>. All rights
        reserved.
    </footer>
</div><!-- ./wrapper -->


<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
<script src="<?=base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?=base_url()?>assets/dist/js/adminlte.min.js"></script>
<script src="<?=base_url()?>assets/dist/js/demo.js"></script>
<!-- <script src="<?=base_url()?>assets/dist/js/pages/dashboard2.js"></script> -->
<script src="<?=base_url()?>assets/js/password.js"></script>
<script src="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?=base_url()?>assets/plugins/toastr/toastr.min.js"></script>
<!-- ChartJS -->
<script src="<?=base_url()?>assets/bower_components/chart.js/Chart.js"></script>
<script src="<?=base_url()?>assets/js/confetti.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script> -->


<script type="text/javascript">
  $(document).ready(function() {
    $("#dashboardSideNav").addClass('active');
  });
</script>
<script type="text/javascript">

    function swal_message1(msg_type,msg){
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
          });

        Toast.fire({
            icon: msg_type,
            title: msg
        })
    }
<?php 
if ($this->session->flashdata('SUCCESSMSG')) {  
    $hour = date("H"); // Get the current hour in 24-hour format
    $name = $this->session->name;

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning, ';
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Good afternoon, ';
    } else {
        $greeting = 'Good evening, ';
    }
    
    echo "swal_message1('success','$greeting$name')";
} 
?>

<?php 
    $currentDate = date("m-d");
    $birthday = "06-13";
    @$birthday1 = $this->session->bday;
    //var_dump($birthday1);
    //if($birthday == $currentDate AND $this->session->bday != "" AND $this->session->user_id == '622'){  
    if(@$birthday1 == $currentDate){  ?>
        //var_dump($birthday1);
    
    const duration = 15 * 1000,
      animationEnd = Date.now() + duration,
      defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

    function randomInRange(min, max) {
      return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function() {
      const timeLeft = animationEnd - Date.now();

      if (timeLeft <= 0) {
        return clearInterval(interval);
      }

      const particleCount = 50 * (timeLeft / duration);

      // since particles fall down, start a bit higher than random
      confetti(
        Object.assign({}, defaults, {
          particleCount,
          origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 },
        })
      );
      confetti(
        Object.assign({}, defaults, {
          particleCount,
          origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 },
        })
      );
    }, 250);

    //Hide the cake after the animation ends
    setTimeout(function() {
        document.querySelector('.bday').classList.add('hidden');
    }, duration);
<?php } ?>


</script>

</body>
</html>