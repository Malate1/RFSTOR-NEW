<!DOCTYPE html>
<!-- saved from url=(0023)https://mis.hnu.edu.ph/ -->
<html lang="en"><!-- Mirrored from twitter.github.com/bootstrap/examples/carousel.html by HTTrack Website Copier/3.x [XR&CO'2010], Sat, 17 Nov 2012 05:01:30 GMT --><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <!-- <title>Holy Name University Management Information System</title> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles 
    <link href="./Holy Name University Management Information System_files/bootstrap.css" rel="stylesheet">
    <link href="./Holy Name University Management Information System_files/bootstrap-responsive.css" rel="stylesheet">
    -->
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>hnu/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>hnu/bootstrap-responsive.css"/>
    
    <style>

    /* GLOBAL STYLES
    -------------------------------------------------- */
    /* Padding below the footer and lighter body text */

    body {
      padding-bottom: 40px;
      color: #5a5a5a;
    }



    /* CUSTOMIZE THE NAVBAR
    -------------------------------------------------- */

    /* Special class on .container surrounding .navbar, used for positioning it into place. */
    .navbar-wrapper {
      position: relative;
      z-index: 10;
      margin-top: 20px;
      margin-bottom: -90px; /* Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
    }

    /* Remove border and change up box shadow for more contrast */
    .navbar .navbar-inner {
      border: 0;
      -webkit-box-shadow: 0 2px 10px green;
         -moz-box-shadow: 0 2px 10px green;
              box-shadow: 0 2px 10px rgba(0,0,0,.25);
    }

    /* Downsize the brand/project name a bit */
    .navbar .brand {
      padding: 14px 20px 16px; /* Increase vertical padding to match navbar links */
      font-size: 16px;
      font-weight: bold;
      text-shadow: 0 -1px 0 rgba(0,0,0,.5);
    }
    
    .brand {
    color: #;
    }

    /* Navbar links: increase padding for taller navbar */
    .navbar .nav > li > a {
      padding: 15px 20px;
    }

    /* Offset the responsive button for proper vertical alignment */
    .navbar .btn-navbar {
      margin-top: 10px;
    }



    /* CUSTOMIZE THE NAVBAR
    -------------------------------------------------- */

    /* Carousel base class */
    .carousel {
      margin-bottom: 20px;
    }

    .carousel .container {
      position: absolute;
      right: 0;
      bottom: 0;
      left: 0;
    }

    .carousel-control {
      background-color: transparent;
      border: 0;
      font-size: 120px;
      margin-top: 0;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
    }

    .carousel .item {
      height: 450px;
    }
    .carousel img {
      min-width: 100%;
      height: 450px;
    }

    .carousel-caption {
      background-color: transparent;
      position: static;
      max-width: 900px;
      padding: 0 20px;
      margin-bottom: 80px;
    }
    .carousel-caption h1,
    .carousel-caption .lead {
      margin: 0;
      line-height: 1.25;
      color: #fff;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
    }
    .carousel-caption .btn {
      margin-top: 10px;
    }



    /* MARKETING CONTENT
    -------------------------------------------------- */

    /* Center align the text within the three columns below the carousel */
    .marketing .span3 {
      text-align: center;
    }
    .marketing h2 {
      font-weight: normal;
    }
    .marketing .span3 p {
      margin-left: 10px;
      margin-right: 10px;
    }


    /* Featurettes
    ------------------------- */

    .featurette-divider {
      margin: 40px 0; /* Space out the Bootstrap <hr> more */
      border-bottom: 1px solid #c0c0c0;
    }
    .featurette {
      padding-top: 90px; /* Vertically center images part 1: add padding above and below text. */
      overflow: hidden; /* Vertically center images part 2: clear their floats. */
    }
    .featurette-image {
      margin-top: -120px; /* Vertically center images part 3: negative margin up the image the same amount of the padding to center it. */
    }

    /* Give some space on the sides of the floated elements so text doesn't run right into it. */
    .featurette-image.pull-left {
      margin-right: 40px;
    }
    .featurette-image.pull-right {
      margin-left: 40px;
    }

    /* Thin out the marketing headings */
    .featurette-heading {
      font-size: 50px;
      font-weight: 300;
      line-height: 1;
      letter-spacing: -1px;
    }



    /* RESPONSIVE CSS
    -------------------------------------------------- */

    @media (max-width: 979px) {

      .container.navbar-wrapper {
        margin-bottom: 0;
        width: auto;
      }
      .navbar-inner {
        border-radius: 0;
        margin: -20px 0;
      }

      .carousel .item {
        height: 500px;
      }
      .carousel img {
        width: auto;
        height: 500px;
      }

      .featurette {
        height: auto;
        padding: 0;
      }
      .featurette-image.pull-left,
      .featurette-image.pull-right {
        display: block;
        float: none;
        max-width: 40%;
        margin: 0 auto 20px;
      }
    }


    @media (max-width: 1000px) {

      .navbar-inner {
        margin: -20px;
      }

      .carousel {
        margin-left: -20px;
        margin-right: -20px;
      }
      .carousel .container {

      }
      .carousel .item {
        height: 300px;
      }
      .carousel img {
        height: 300px;
      }
      .carousel-caption {
        width: 65%;
        padding: 0 40px;
        margin-bottom: 40px;
      }
      .carousel-caption h1 {
        font-size: 30px;
      }
      .carousel-caption .lead,
      .carousel-caption .btn {
        font-size: 18px;
      }

      .marketing .span3 + .span3 {
        margin-top: 40px;
      }

      .featurette-heading {
        font-size: 30px;
      }
      .featurette .lead {
        font-size: 18px;
        line-height: 1.5;
      }

    }
    </style>
  </head>
  <body>
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
         <!--  <img src="./Holy Name University Management Information System_files/slide-06.jpg" alt=""> -->

          <img  src="<?=base_url()?>hnu/c1.jpg">
          <div class="container">
            
            <div class="carousel-caption">
              <h1>HNU Medical Center Clinic's Appointment Management System</h1>

             <!--  <div class="login-logo">
        <a href="#"><img src="<?=base_url()?>assets/dist/img/hnumcfi.jpg" class="img-circle"  alt="logo" style="height: 100px; width: 100px;"><br><h3>Clinics Appointment Management System</h3></a>
      </div> -->


<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br><br><br><br><br>
          </div>
              
          </div>
          
        </div>
       
     </div> 
     </div>
    



    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">

        <div class="span12">
        	<p class="info"></p> 
 		</div>   

         <div class="span4" style="text-align: center;">
          <h2>Admin</h2>
          <p >Manage, and monitor users and clinics. Keep track of users' records.</p>
          <p><a class="btn" href="<?php echo base_url() ?>Login/logAdmin">Click to Login</a></p>
        </div> <!-- /.span3 -->
        <div class="span4" style="text-align: center;">
          <h2>Physician</h2>
          <p>Keep track of your appointments. View and manage your appointment list.</p>
          <p><a class="btn" href="<?php echo base_url() ?>Login/logDoctor">Click to Login</a></p>
        </div><!-- /.span3 -->
        <div class="span4" style="text-align: center;">
          <h2>Secretary</h2>
          <p>Keep track of the  appointments. View and manage the appointment list.</p>
          <p><a class="btn" href="<?php echo base_url() ?>Login/logSec">Click to Login</a></p>
        </div><!-- /.span3 -->

        <!-- <div class="span3" style="text-align: center;">
          <h2>Patient</h2>
          <p>Keep track of the physician's schedule. View and manage the appointment list.</p>
          <p><a class="btn" href="<?php echo base_url() ?>Login/logPatient">Click to Login</a></p>
        </div> -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


      <!-- FOOTER -->
      <footer>
		 <p class="pull-right text-success">For inquiries about the HNUMC CAMS, please e-mail: <b>mis@hnu.edu.ph</b>.</p>
        <p class="text-success">© 2018 HNU Medical Center Clinic's Appointment Management System</a></p> 
      </footer>

    </div><!-- /.container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <script>
      !function ($) {
        $(function(){
          // carousel demo
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    </script>
  


</body></html>