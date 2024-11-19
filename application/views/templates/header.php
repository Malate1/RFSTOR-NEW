<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Online TOR & RFS | <?php echo $page_title; ?></title>
	
	  <!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.css"/>
	<!-- <link rel="shortcut icon" href="assets/dist/img/logo2.png" style="height: 40px; width: 40px;"> -->
	<link rel="icon" type="image/png" href="assets/dist/img/logo3.png" />
	  <!-- Font Awesome -->
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css"/>
	  <!-- Ionicons -->
	<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css"./>
	 

	<!-- <link type="text/css" rel="stylesheet" href="<?=base_url()?>vendors/select2/css/select2.min.css" />  -->
	 <!-- DataTables -->
	<!-- <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/pages/dataTables.bootstrap.css" /> -->
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/DataTables/datatables.min.css" />
	<!-- JQuery UI CSS -->
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/jquery-ui/jquery-ui.min.css" />
	  
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/AdminLTE.min.css"/>
	<!-- AdminLTE Skins. Choose a skin from the css/skins
		folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?=base_url()?>assets/dist/css/skins/_all-skins.min.css"/>
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/plugins/toastr/toastr.min.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/sweetalert.css"> 
	<link rel="stylesheet" href="<?=base_url()?>assets/css/select2.min.css"> 
	<link rel="stylesheet" href="<?=base_url()?>assets/css/custom.css">
	<link rel="stylesheet" href="<?=base_url()?>assets/css/daterangepicker.css">
	<link type="text/css" rel="stylesheet" href="<?=base_url()?>assets/plugins/DataTables/FixedColumns-4.2.1/css/fixedColumns.bootstrap.min.css" />
	<!-- <link rel="stylesheet" type="text/css" href="assets/plugins/DataTables/Buttons-2.3.3/css/buttons.dataTables.min.css"> -->
	
	<script src="<?=base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?=base_url()?>assets/js/xlsx.js"></script>
	<script src="<?=base_url()?>assets/js/darkreader.js"></script>
	<!--   Google Font   -->
	<!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"> -->
	<!-- <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'> -->

</head>
<body class="hold-transition sidebar-mini fixed">
<div class="wrapper">
<style type="text/css">
	@font-face {
	   font-family: 'robotoregular';
	   src: url('assets/css/roboto-regular-webfont.woff2') format('woff2'),
	        url('assets/css/roboto-regular-webfont.woff') format('woff'),
	        url('assets/css/Roboto-Regular.ttf') format('ttf');
	        
	   font-weight: 500;
	   font-style: normal;
	}

	@font-face {
	    font-family: 'Digital-7 V7';
	    src: url('assets/css/Digital-7 V7.woff2') format('woff2'),
	         url('assets/css/Digital-7 V7.woff') format('woff');
	    font-weight: bold; /* You can set the appropriate font weight here */
	    font-style: normal; /* You can set the appropriate font style here */
	}

	@font-face {
		font-family: 'Inter-Regular';
		font-style: normal;
		font-weight: 400;
		
		src: url('assets/css/Inter-Regular.woff2') format('woff2');
		
	}

	@font-face {
		font-family: 'Poppins';
		font-style: normal;
		font-weight: 400;
		
		src: url('assets/css/Poppins-Regular.woff2') format('woff2');
		
	}

	.custom-toast {
		font-size: 2.5rem; /* Increase font size */
		padding: 40px; /* Add more padding */
		width: 400px !important; /* Adjust width */
		height: 100px !important; /* Allow height to adjust automatically */
	}

	
	.badge-danger {
	    color: #fff;
	    background-color: #dc3545;
	}

	.badge {
	    display: inline-block;
	    
	    font-size: 9px;
	    font-weight: bold;
	    line-height: 1;
	    text-align: center;
	    white-space: nowrap;
	    vertical-align: baseline;
	    border-radius: 10px;
	    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}

	.right {
	    position: absolute;
	    right: 1rem;
	    
	}

	.user-panel>.image>img {
		/*width: 100%;*/
	    width: 45px;
	    height: 45px;
/*	    width: auto;*/
	}

	.navbar-nav>.user-menu .user-image {
	    width: 30px;
	    height: 30px;  
	}

	.click{
		background-color: white;
		color: black;
	}

	.small-box {
	    margin-bottom: 10px;   
	}

	/* Styles for the toggle button */
    .toggle-sun {
      color: #fff;
      font-size: 16px;
      line-height: 20px;
      display: inline-block;
      padding: 15px 5px;
/*      margin-right: 5px;*/
      background: none;
      border: 0;
    }
    
    .toggle-moon {
      color: #fff;
      font-size: 16px;
      line-height: 20px;
      display: inline-block;
      padding: 15px 5px;
/*      margin-right: 5px;*/
      background: none;
      border: 0;
    }

    .dropdown-custom {
        width: 300px; /* Adjust the width as needed */
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .notification-title {
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
        background-color: #333;
        color: #fff;
    }

    .menu li a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 10px;
    }

    .menu li a:hover {
        background-color: #f4f4f4;
    }

    .notification-text {
        display: flex;
        justify-content: space-between;
    }

    .notification-count {
        background-color: #e74c3c;
        color: #fff;
        padding: 2px 6px;
        border-radius: 50%;
    }

    .footer a {
        text-align: center;
        display: block;
        padding: 10px;
        background-color: #f4f4f4;
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    #snow-container {
	  	height: 100vh;
	  	overflow: hidden;
	  	top: 0;
	  	transition: opacity 500ms;
	  	width: 100%;
	}

	.snow {
	  animation: fall 5s ease-in infinite, sway 8s ease-in-out infinite;
	  color: skyblue;
	  position: absolute;
	}

	@keyframes fall {
	  0% {
	    opacity: 0;
	  }
	  10% {
	    opacity: 1;
	  }
	  100% {
	    top: 100vh;
	    opacity: 0;
	  }
	}

	@keyframes sway {
	  0% {
	    transform: translateX(0);
	  }
	  25% {
	    transform: translateX(50px);
	  }
	  50% {
	    transform: translateX(-40px);
	  }
	  75% {
	    transform: translateX(50px);
	  }
	  100% {
	    transform: translateX(0);
	  }
	}

	#clock{
	width:100%;
	padding-bottom:30px;
/*	margin:100px auto 60px;*/
	position:relative;
	}

	#clock:after{
		content:'';
		position:absolute;
		width:400px;
		height:20px;
		border-radius:100%;
		left:50%;
		margin-left:-200px;
		bottom:2px;
		z-index:-1;
	}

	#clock .display{
		text-align:center;
		padding: 40px 20px 20px;
		border-radius:6px;
		position:relative;
		height: auto;
	}

	#clock.light{
	/*	background-color:#f3f3f3;*/
		color:#3c8dbc;
	}

	/*#clock.light:after{
		box-shadow:0 4px 10px rgba(0,0,0,0.15);
	}*/

	#clock.light .digits div span{
		background-color:#3c8dbc;
		border-color:#3c8dbc;	
	}

	#clock.light .digits div.dots:before,
	#clock.light .digits div.dots:after{
		background-color:#3c8dbc;
	}

	#clock.light .display{
		background-color:#ffffff;
/*		box-shadow:0 1px 1px rgba(0,0,0,0.08) inset, 0 1px 1px #fafafa;*/
	}

	#clock .digits div{
		text-align:left;
		position:relative;
		width: 28px;
		height:50px;
		display:inline-block;
		margin:0 4px;
	}

	#clock .digits div span{
		opacity:0;
		position:absolute;

		-webkit-transition:0.25s;
		-moz-transition:0.25s;
		transition:0.25s;
	}

	#clock .digits div span:before,
	#clock .digits div span:after{
		content:'';
		position:absolute;
		width:0;
		height:0;
		border:5px solid transparent;
	}

	#clock .digits .d1{			height:5px;width:16px;top:0;left:6px;}
	#clock .digits .d1:before{	border-width:0 5px 5px 0;border-right-color:inherit;left:-5px;}
	#clock .digits .d1:after{	border-width:0 0 5px 5px;border-left-color:inherit;right:-5px;}

	#clock .digits .d2{			height:5px;width:16px;top:24px;left:6px;}
	#clock .digits .d2:before{	border-width:3px 4px 2px;border-right-color:inherit;left:-8px;}
	#clock .digits .d2:after{	border-width:3px 4px 2px;border-left-color:inherit;right:-8px;}

	#clock .digits .d3{			height:5px;width:16px;top:48px;left:6px;}
	#clock .digits .d3:before{	border-width:5px 5px 0 0;border-right-color:inherit;left:-5px;}
	#clock .digits .d3:after{	border-width:5px 0 0 5px;border-left-color:inherit;right:-5px;}

	#clock .digits .d4{			width:5px;height:14px;top:7px;left:0;}
	#clock .digits .d4:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
	#clock .digits .d4:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}

	#clock .digits .d5{			width:5px;height:14px;top:7px;right:0;}
	#clock .digits .d5:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
	#clock .digits .d5:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}

	#clock .digits .d6{			width:5px;height:14px;top:32px;left:0;}
	#clock .digits .d6:before{	border-width:0 5px 5px 0;border-bottom-color:inherit;top:-5px;}
	#clock .digits .d6:after{	border-width:0 0 5px 5px;border-left-color:inherit;bottom:-5px;}

	#clock .digits .d7{			width:5px;height:14px;top:32px;right:0;}
	#clock .digits .d7:before{	border-width:0 0 5px 5px;border-bottom-color:inherit;top:-5px;}
	#clock .digits .d7:after{	border-width:5px 0 0 5px;border-top-color:inherit;bottom:-5px;}


	/* 1 */

	#clock .digits div.one .d5,
	#clock .digits div.one .d7{
		opacity:1;
	}

	/* 2 */

	#clock .digits div.two .d1,
	#clock .digits div.two .d5,
	#clock .digits div.two .d2,
	#clock .digits div.two .d6,
	#clock .digits div.two .d3{
		opacity:1;
	}

	/* 3 */

	#clock .digits div.three .d1,
	#clock .digits div.three .d5,
	#clock .digits div.three .d2,
	#clock .digits div.three .d7,
	#clock .digits div.three .d3{
		opacity:1;
	}

	/* 4 */

	#clock .digits div.four .d5,
	#clock .digits div.four .d2,
	#clock .digits div.four .d4,
	#clock .digits div.four .d7{
		opacity:1;
	}

	/* 5 */

	#clock .digits div.five .d1,
	#clock .digits div.five .d2,
	#clock .digits div.five .d4,
	#clock .digits div.five .d3,
	#clock .digits div.five .d7{
		opacity:1;
	}

	/* 6 */

	#clock .digits div.six .d1,
	#clock .digits div.six .d2,
	#clock .digits div.six .d4,
	#clock .digits div.six .d3,
	#clock .digits div.six .d6,
	#clock .digits div.six .d7{
		opacity:1;
	}


	/* 7 */

	#clock .digits div.seven .d1,
	#clock .digits div.seven .d5,
	#clock .digits div.seven .d7{
		opacity:1;
	}

	/* 8 */

	#clock .digits div.eight .d1,
	#clock .digits div.eight .d2,
	#clock .digits div.eight .d3,
	#clock .digits div.eight .d4,
	#clock .digits div.eight .d5,
	#clock .digits div.eight .d6,
	#clock .digits div.eight .d7{
		opacity:1;
	}

	/* 9 */

	#clock .digits div.nine .d1,
	#clock .digits div.nine .d2,
	#clock .digits div.nine .d3,
	#clock .digits div.nine .d4,
	#clock .digits div.nine .d5,
	#clock .digits div.nine .d7{
		opacity:1;
	}

	/* 0 */

	#clock .digits div.zero .d1,
	#clock .digits div.zero .d3,
	#clock .digits div.zero .d4,
	#clock .digits div.zero .d5,
	#clock .digits div.zero .d6,
	#clock .digits div.zero .d7{
		opacity:1;
	}


	/* The dots */

	#clock .digits div.dots{
		width:5px;
	}

	#clock .digits div.dots:before,
	#clock .digits div.dots:after{
		width:5px;
		height:5px;
		content:'';
		position:absolute;
		left:0;
		top:14px;
	}

	#clock .digits div.dots:after{
		top:34px;
	}


	/*-------------------------
		The Alarm
	--------------------------*/


	#clock .alarm{
		width:16px;
		height:16px;
		bottom:20px;
		
		position:absolute;
		opacity:0.2;
	}

	#clock .alarm.active{
		opacity:1;
	}


	/*-------------------------
		Weekdays
	--------------------------*/


	#clock .weekdays{
		font-size:16px;
		position:absolute;
		width:100%;
		top:10px;
		left:0;
		text-align:center;
		font-family: "Digital-7 V7";
		font-weight: bold;
	}


	#clock .weekdays span{
		opacity:0.2;
		padding:0 10px;
	}

	#clock .weekdays span.active{
		opacity:1;
	}


	/*-------------------------
			AM/PM
	--------------------------*/


	#clock .ampm{
		position:absolute;
		bottom:20px;
		right:20px;
		font-size:16px;
		font-family: "Digital-7 V7";
	}

	#clock .date {
	    position: absolute;
	/*    bottom: 5px;*/
	    left: 50%; /* Center align the date */
	    transform: translateX(-50%); /* Center align the date */
	    font-size: 14px;
	    padding: 5px;
	    font-family: "Digital-7 V7";
	}

	.box-primary{
        box-shadow: 0 0 20px #3336;
    }

</style>


<header  class="main-header">
	<!-- Logo -->
	<a href="<?=base_url()?>profile" class="logo">
	  <!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>RFS</b>TOR</span>
		  <!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><img src="<?=base_url()?>assets/dist/img/logo1.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"> RFS | TOR</span>
		<!-- <span class="logo-lg"><img src="<?=base_url()?>assets/dist/img/rfs--tor-high-resolution-logo-white-transparent (1).png" class="img-circle"  alt="logo" style="height: 40px; width: 36px;"></span> -->

		
	</a>
  
	<nav class="navbar navbar-static-top">
	  	<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
		<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			
		</a>
		
		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<li class="dropdown messages-menu">
		            <a href="#" class="dropdown-toggle" role="button" id="toggleButton">
		              <i class="fa" id="skinIcon"></i>
		              
		            </a>
            		
		        </li>

		    <?php if($getType4 == true){ ?>
	          	<li class="dropdown notifications-menu">
	            	<a href="#" id="resetCountButton" class="dropdown-toggle" data-toggle="dropdown">
	              		<i  class="fa fa-bell-o" style="font-size: 16px;"></i>
	              		<span class="label label-danger" id="newAllCount"></span>
	            	</a>
	            	<ul class="dropdown-menu">
	              		<li style="font-size: 12px; text-align: center;" class="header"> <span id="newCount"></span> Request Notifications</li>
	              		<li>
		                	<ul  class="menu" style="font-size: 12px;">
			                  	<li id="rfs">
			                    	<a href="<?=base_url('pending-rfs-status-e')?>" >
			                      	<i style="color: #00c0ef;" class="fa fa-clipboard"></i> <span id="newRFSCount"></span> pending RFS to execute 
			                    	</a>
			                  	</li>
			                  	<li id="tor">
			                    	<a href="<?=base_url('pending-tor-status-e')?>" >
			                      		<i style="color: #3c8dbc" class="fa fa-clipboard "></i> <span id="newTORCount"></span> pending TOR to execute 
			                  	</li>
			                  	<li id="isr">
			                    	<a href="<?=base_url('pending-isr-status-e')?>" >
			                      	<i style="color: #d2d6de" class="fa fa-clipboard"></i> <span id="newISRCount"></span> pending ISR to execute 
			                    	</a>
			                  	</li>
		                	</ul>
	              		</li>
	              		<li class="footer"></li>
	            	</ul>
	          	</li>

	        <?php } ?>

			<?php if($getType2 == true){ ?>
	          	<li class="dropdown notifications-menu">
	            	<a href="#" id="resetCountButtonReq" class="dropdown-toggle" data-toggle="dropdown">
	              		<i  class="fa fa-bell-o" style="font-size: 16px;"></i>
	              		<span class="label label-danger" id="newAllCountReq"></span>
	            	</a>
	            	<ul class="dropdown-menu">
	              		<li style="font-size: 12px; text-align: center;" class="header"> <span id="newCountReq"></span> Request Remarks Notifications</li>
	              		<li>
		                	<ul  class="menu" style="font-size: 12px;">
			                  	<li id="rfs">
			                    	<a href="<?=base_url('view-rfs')?>" >
			                      	<i style="color: #00c0ef;" class="fa fa-clipboard"></i> <span id="newRFSCountReq"></span> remarks added to RFS 
			                    	</a>
			                  	</li>
			                  	<li id="tor">
			                    	<a href="<?=base_url('view-tor')?>" >
			                      		<i style="color: #3c8dbc" class="fa fa-clipboard "></i> <span id="newTORCountReq"></span> remarks added to TOR
			                  	</li>
			                  	<li id="isr">
			                    	<a href="<?=base_url('view-isr')?>" >
			                      	<i style="color: #d2d6de" class="fa fa-clipboard"></i> <span id="newISRCountReq"></span> remarks added to ISR
			                    	</a>
			                  	</li>
		                	</ul>
	              		</li>
	              		<li class="footer"></li>
	            	</ul>
	          	</li>

	        <?php } ?>
        
			<script>

				function toggleSkin() {
				    const body = document.querySelector('body');
				    const toggleButton = document.getElementById('toggleButton');
				    const skinIcon = document.getElementById('skinIcon');

				    // Toggle DarkReader settings
				    if (DarkReader.isEnabled()) {
				        DarkReader.disable();
				        localStorage.setItem('darkModeEnabled', 'false');
				    } else {
				        const darkReaderSettings = {
				            brightness: 100,
				            contrast: 100,
				            sepia: 5
				        };
				        DarkReader.enable(darkReaderSettings);
				        localStorage.setItem('darkModeEnabled', 'true');
				    }

				    // Toggle body skin classes
				    body.classList.toggle('skin-blue-light');
				    body.classList.toggle('skin-blue');

				    // Toggle button classes and icon
				    if (body.classList.contains('skin-blue-light')) {
				        toggleButton.classList.remove('toggle-sun');
				        toggleButton.classList.add('toggle-moon');
				        skinIcon.classList.remove('fa-sun-o');
				        skinIcon.classList.add('fa-moon-o');
				    } else {
				        toggleButton.classList.remove('toggle-moon');
				        toggleButton.classList.add('toggle-sun');
				        skinIcon.classList.remove('fa-moon-o');
				        skinIcon.classList.add('fa-sun-o');
				    }

				    // Save the skin preference to browser storage
				    const selectedSkin = body.classList.contains('skin-blue-light') ? 'skin-blue-light' : 'skin-blue';
				    localStorage.setItem('selectedSkin', selectedSkin);
				}

				// Add click event listener to the toggle button
				const toggleButton = document.getElementById('toggleButton');
				toggleButton.addEventListener('click', toggleSkin);

				// Check if a skin preference exists in the browser storage
				const selectedSkin = localStorage.getItem('selectedSkin');
				if (selectedSkin) {
				    const body = document.querySelector('body');
				    body.classList.add(selectedSkin);

				    const skinIcon = document.getElementById('skinIcon');
				    if (selectedSkin === 'skin-blue-light') {
				        toggleButton.classList.add('toggle-moon');
				        skinIcon.classList.add('fa-moon-o');
				    } else {
				        toggleButton.classList.add('toggle-sun');
				        skinIcon.classList.add('fa-sun-o');
				    }
				}

				// Check if DarkReader setting is enabled in the browser storage
				const darkModeEnabled = localStorage.getItem('darkModeEnabled');
				if (darkModeEnabled === 'true') {
				    const darkReaderSettings = {
				        brightness: 100,
				        contrast: 100,
				        sepia: 5
				    };
				    DarkReader.enable(darkReaderSettings);
				}


			  	<?php if($getType4 == true){ ?>
					var originalTitle = document.title;
					var animationInterval; 
					var marqueePosition = 0;
					var stop ='';
					var updateInterval; // Declare the update interval variable
					var restartInterval = true; // Variable to control interval restart

					// Function to handle bell button click
					function handleBellButtonClick() {
						$('#resetCountButton').click(function () {
							
							// Set a flag in session storage to remember that the button was clicked
							localStorage.setItem('bellButtonClicked', 'true');

							// Pause the update interval for 2 minutes (120000 milliseconds)
							if (restartInterval) {
								clearInterval(updateInterval); // Pause the interval
								setTimeout(function () {
									startUpdateInterval(); // Restart the interval after 2 minutes
									restartInterval = true; // Set the flag to true for the next restart
								}, 600000000); // 1 minute (adjust as needed)
								restartInterval = false; // Set the flag to false to prevent multiple restarts
								$('#newAllCount').hide();
							}
							// Hide the count and stop the title animation
							$('#newAllCount').hide();
							stopTitleAnimation();

							
						});
					}

					// Function to play a ringtone
					// function playRingtone() {
					//     var audio = new Audio('<?=base_url()?>assets/alarm4.mp3');
					//     audio.play();
					//     return audio; // Return the Audio object for later use
					// }

			
					function updateMenuCounts() {
						
						$.ajax({
							url: '<?= base_url('Request/getLatestRequests') ?>',
							method: 'GET',
							dataType: 'json',
							success: function(data) {
								// Update the menu item text with the latest count
								var rfs 	 = $('#rfs');
								var tor 	 = $('#tor');
								var isr 	 = $('#isr');
								var rfsCount = parseInt(data.newRequestCount.rfsCount, 10);
								var torCount = parseInt(data.newRequestCount.torCount, 10);
								var isrCount = parseInt(data.newRequestCount.isrCount, 10);
								// Check if the parsed values are valid integers, and if not, default them to 0
								if (isNaN(rfsCount)) {
									rfsCount = 0;
									
								}
								if (isNaN(torCount)) {
									torCount = 0;
									
								}
								if (isNaN(isrCount)) {
									isrCount = 0;
									
								}
								// Calculate the total count
								var totalCount = rfsCount + torCount + isrCount;
								$('#newAllCount').text(totalCount);

								if(rfsCount == 0){
									rfs.hide();;
								} 
								if(torCount == 0){
									tor.hide();
								}
								if(isrCount == 0){
									isr.hide();
								}
						
								$('#newRFSCount').text(rfsCount);
								$('#newTORCount').text(torCount);
								$('#newISRCount').text(isrCount);

								var newAllCountElement 	= $('#newAllCount');
								$('#newCount').text(newAllCountElement.text());
									



								if (totalCount > 0) {
									newAllCountElement.show();
									handleBellButtonClick();

									if (!originalTitle.includes("Execute")) {
										// Animate the page title and show a notification
										startTitleMarquee(' New Pending Requests! ', 60000);
									} else {
										newAllCountElement.hide();
										stopTitleAnimation();

										var bellButtonClicked = localStorage.getItem('bellButtonClicked') || 'false';
										if (bellButtonClicked === 'true') {
											// If it was clicked, hide the count and stop the animation
											$('#newAllCount').hide();
											stopTitleAnimation();
										}

										if (restartInterval) {
											clearInterval(updateInterval); // Pause the interval
											setTimeout(function () {
												startUpdateInterval(); // Restart the interval after 2 minutes
												restartInterval = true; // Set the flag to true for the next restart
											}, 60000); // 1 minute
											restartInterval = false; // Set the flag to false to prevent multiple restarts
											$('#newAllCount').hide();
										}
										

									}
								} else {
									
									newAllCountElement.hide();
									stopTitleAnimation();
								}
							},
							error: function(error) {
								console.error('Error fetching latest requests: ' + JSON.stringify(error));
							}
						});
					}

					// Function to animate the page title and show a notification
					function startTitleMarquee(message, duration) {
						clearInterval(animationInterval);

						// var audio = playRingtone();

						var titleLength = message.length;
						var timer = 0;

						animationInterval = setInterval(function () {
							var animatedTitle = message.substring(marqueePosition, titleLength) + message.substring(0, marqueePosition);
							document.title = animatedTitle;

							marqueePosition = (marqueePosition + 1) % titleLength;
							timer += 100;

							if (timer >= duration) {
								clearInterval(animationInterval);
								document.title = originalTitle; // Restore the original title
								// audio.pause(); // Pause the ringtone when the animation stops
								// audio.currentTime = 0; // Reset the playback position to the beginning
								console.log('Animation executed.'); // Log the animation execution
							}
						}, 500); // Adjust the animation speed as needed (e.g., 500 milliseconds)
					}

					// Function to stop the title animation
					function stopTitleAnimation() {
						clearInterval(animationInterval);
						document.title = originalTitle; // Restore the original title
					}

					// Function to start the update interval
					function startUpdateInterval() {
						updateMenuCounts();
						updateInterval = setInterval(updateMenuCounts, 50000000);
					}

					// Start the initial update interval
					startUpdateInterval();
				<?php } ?>

				<?php if($getType2 == true){ ?>
					var originalTitle = document.title;
					var animationInterval; 
					var marqueePosition = 0;
					var stop ='';
					var updateInterval; // Declare the update interval variable
					var restartInterval = true; // Variable to control interval restart
					let toastCounter = 0;
					let notificationInterval;
					// Function to handle bell button click
					function handleBellButtonClick() {
						$('#resetCountButtonReq').click(function () {
							
							// Set a flag in session storage to remember that the button was clicked
							localStorage.setItem('bellButtonClicked', 'true');

							// Pause the update interval for 2 minutes (120000 milliseconds)
							if (restartInterval) {
								clearInterval(updateInterval); // Pause the interval
								setTimeout(function () {
									startUpdateInterval(); // Restart the interval after 2 minutes
									restartInterval = true; // Set the flag to true for the next restart
								}, 600000000); // 1 minute (adjust as needed)
								restartInterval = false; // Set the flag to false to prevent multiple restarts
								$('#newAllCountReq').hide();
							}
							// Hide the count and stop the title animation
							$('#newAllCountReq').hide();
							stopTitleAnimation();

							
						});
					}

					// Function to play a ringtone
					// function playRingtone() {
					//     var audio = new Audio('<?=base_url()?>assets/alarm4.mp3');
					//     audio.play();
					//     return audio; // Return the Audio object for later use
					// }

			
					function updateMenuCounts() {
						
						$.ajax({
							url: '<?= base_url('Request/getLatestRequestsRemarks') ?>',
							method: 'GET',
							dataType: 'json',
							success: function(data) {
								// Update the menu item text with the latest count
								var rfs 	 = $('#rfs');
								var tor 	 = $('#tor');
								var isr 	 = $('#isr');
								var rfsCount = parseInt(data.newRequestCount.rfsCount, 10);
								var torCount = parseInt(data.newRequestCount.torCount, 10);
								var isrCount = parseInt(data.newRequestCount.isrCount, 10);
								// Check if the parsed values are valid integers, and if not, default them to 0
								if (isNaN(rfsCount)) {
									rfsCount = 0;
									
								}
								if (isNaN(torCount)) {
									torCount = 0;
									
								}
								if (isNaN(isrCount)) {
									isrCount = 0;
									
								}
								// Calculate the total count
								var totalCount = rfsCount + torCount + isrCount;
								$('#newAllCountReq').text(totalCount);

								if (rfsCount > 0) {
								$('#newAllCountReq').show();

								// Show the SweetAlert toast only if it has been shown less than 10 times
								if (toastCounter < 100) {
									console.log('Displaying SweetAlert notification');

									var Toast = Swal.mixin({
										toast: true,
										position: 'top',
										showConfirmButton: false,
										// timer: 2000,
										// timerProgressBar: true,
										customClass: {
											container: 'custom-toast', // Add a custom class for styling
										},
										didOpen: (toast) => {
											toast.addEventListener('click', () => {
												window.location.href = '<?= base_url('Request/ViewRfsPending') ?>';
												clearInterval(notificationInterval); // Stop the interval
												Swal.close(); // Close the Swal
												toastCounter = 100; // Ensure the condition stops further notifications
											});
										},
									});

									Toast.fire({
										icon: 'info',
										title: 'You have ' + rfsCount + ' remarks for RFS.'
									}).then((result) => {
										if (result.isConfirmed || result.dismiss === Swal.DismissReason.close) {
											clearInterval(notificationInterval); // Stop the interval when OK is clicked
											toastCounter = 100; // Ensure the condition stops further notifications
										}
									});

									// Increment the toast counter
									toastCounter++;
								}

							} else {
								$('#newAllCountReq').hide();
							}

						
								$('#newRFSCountReq').text(rfsCount);
								$('#newTORCountReq').text(torCount);
								$('#newISRCountReq').text(isrCount);

								var newAllCountElement 	= $('#newAllCountReq');
								$('#newCountReq').text(newAllCountElement.text());
									



								if (totalCount > 0) {
									newAllCountElement.show();
									handleBellButtonClick();

									if (!originalTitle.includes("Execute")) {
										// Animate the page title and show a notification
										startTitleMarquee(' New Request Remarks! ', 60000);
									} else {
										newAllCountElement.hide();
										stopTitleAnimation();

										var bellButtonClicked = localStorage.getItem('bellButtonClicked') || 'false';
										if (bellButtonClicked === 'true') {
											// If it was clicked, hide the count and stop the animation
											$('#newAllCountReq').hide();
											stopTitleAnimation();
										}

										if (restartInterval) {
											clearInterval(updateInterval); // Pause the interval
											setTimeout(function () {
												startUpdateInterval(); // Restart the interval after 2 minutes
												restartInterval = true; // Set the flag to true for the next restart
											}, 60000); // 1 minute
											restartInterval = false; // Set the flag to false to prevent multiple restarts
											$('#newAllCountReq').hide();
										}
										

									}
								} else {
									
									newAllCountElement.hide();
									stopTitleAnimation();
								}
							},
							error: function(error) {
								console.error('Error fetching latest requests: ' + JSON.stringify(error));
							}
						});
					}

					// Function to animate the page title and show a notification
					function startTitleMarquee(message, duration) {
						clearInterval(animationInterval);

						// var audio = playRingtone();

						var titleLength = message.length;
						var timer = 0;

						animationInterval = setInterval(function () {
							var animatedTitle = message.substring(marqueePosition, titleLength) + message.substring(0, marqueePosition);
							document.title = animatedTitle;

							marqueePosition = (marqueePosition + 1) % titleLength;
							timer += 100;

							if (timer >= duration) {
								clearInterval(animationInterval);
								document.title = originalTitle; // Restore the original title
								// audio.pause(); // Pause the ringtone when the animation stops
								// audio.currentTime = 0; // Reset the playback position to the beginning
								console.log('Animation executed.'); // Log the animation execution
							}
						}, 500); // Adjust the animation speed as needed (e.g., 500 milliseconds)
					}

					// Function to stop the title animation
					function stopTitleAnimation() {
						clearInterval(animationInterval);
						document.title = originalTitle; // Restore the original title
					}

					// Function to start the update interval
					function startUpdateInterval() {
						updateMenuCounts();
						updateInterval = setInterval(updateMenuCounts, 50000000);
					}

					// Start the initial update interval
					startUpdateInterval();
					notificationInterval = setInterval(updateMenuCounts, 5000);
				<?php } ?>


			</script>


			  	<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

						<?php 
							$profile = $this->employee_model->find_employee_name($this->session->emp_id);

		                    if($this->session->location != 'Bohol' || $this->session->emp_id == '03845-2015'){
		                        echo'<img src="http://172.16.161.43/rfstor/uploads/profile-pic/'.$this->session->profile_pic.'" class="user-image" alt="User Image">';
		                    }else{
		                        echo'<img src="http://172.16.161.34:8080/hrms/'.$this->session->profile_pic.'" class="user-image" alt="User Image">';
		                    }// $photo = $this->employee_model->find_employee_photo($this->session->user_id);
							

						?>

						<!-- <img src="http://172.16.161.34:8080/hrms/<?=$this->session->profile_pic ?>" class="user-image" alt="User Image">  -->
						<span class="hidden-xs"><?=$this->session->name ?></span> <i class="fa fa-sign-out"></i>
					</a>
					<ul class="dropdown-menu">
					  <!-- User image -->
						<li class="user-header">

						<?php 
							$profile = $this->employee_model->find_employee_name($this->session->emp_id);

		                    if($this->session->location != 'Bohol' || $this->session->emp_id == '03845-2015'){
		                        echo'<img src="http://172.16.161.43/rfstor/uploads/profile-pic/'.$this->session->profile_pic.'" class="img-circle" alt="User Image">';
		                    }else{
		                        echo'<img src="http://172.16.161.34:8080/hrms/'.$this->session->profile_pic.'" class="img-circle" alt="User Image">';
		                    }
							

						?>
						 <!-- <img src="http://172.16.161.34:8080/hrms/<?=$this->session->profile_pic ?>" class="img-circle" alt="User Image">  -->
						 <!-- <img src="http://172.16.161.34:8080/hrms/<?=$this->session->profile_pic ?>" class="img-circle" alt="User Image">  -->
						 <!-- http://172.16.161.34:8080/hrms/images/users/02723-2022=2022-08-01=Profile=18-34-16-PM.JPG -->
							<p>
							  	
							  	
							  <small><?=$this->session->name ?> </small>
							</p>

						</li>
						<li class="user-footer">    
							<div >
								<!-- <a class="btn btn-default" href="<?=base_url('update-profile')?>"><i class="fa fa-edit"></i> Update Password</a>&nbsp;&nbsp; -->
								<a style="padding: 6px;" class="btn btn-default" href="<?=base_url('update-profile')?>"><i class="fa fa-edit"></i> Update Profile Details</a>&nbsp;
								<!-- <a class="btn btn-default" onclick="return confirmDialogLogout();" href="<?=base_url('logout-a')?>"><i class="fa fa-sign-out"></i>Sign out</a> -->
								<a style="padding: 6px;" class="btn btn-default" onclick="logout();"><i class="fa fa-sign-out"></i>Sign out</a>
								
							</div>
						</li>
					</ul>
				</li>  
			</ul>
		</div>
	</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar"  >
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <!-- Sidebar user panel -->
	  <div class="user-panel">
		<div class="pull-left image">

			<?php 
				$profile = $this->employee_model->find_employee_name($this->session->emp_id);

                if($this->session->location != 'Bohol' || $this->session->emp_id == '03845-2015'){
                    echo'<img src="http://172.16.161.43/rfstor/uploads/profile-pic/'.$this->session->profile_pic.'" class="img-circle" alt="User Image">';
                }else{
                    echo'<img src="http://172.16.161.34:8080/hrms/'.$this->session->profile_pic.'" class="img-circle" alt="User Image">';
                }
				

			?>
		  <!-- <img src="http://172.16.161.34:8080/hrms/<?=$this->session->profile_pic ?>" class="img-circle" alt="User Image"> -->

	  </div>
	  <div class="pull-left info">
		  <!-- <p><?=$this->session->name ?><br><br><?=$this->session->emp_id ?></p> -->
		  <p>Hi, <?=$this->session->fname ?> !<br><br><?=$this->session->emp_id ?></p>

		  
	  </div>
  </div>

  <!-- search form 
  <form action="#" method="get" class="sidebar-form">
	<div class="input-group">
	  <input type="text" name="q" class="form-control" placeholder="Search...">
	  <span class="input-group-btn">
		<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
		</button>
	</span>
</div>
</form>-->

<ul class="sidebar-menu" data-widget="tree" id="snow-container">
   <li class="header">MAIN NAVIGATION</li>
   		
   		<li id="dashboardSideNav"><a href="<?php echo base_url()?>profile"><i class="fa fa-dashboard"></i> 
			<span>Dashboard</span></a>
		</li>

		<?php if($getType1 == true){ ?>
			
			<li class="treeview" id="adminSideTree">
			  	<a href="#">
					<i class="fa fa-wrench"></i> 
					<span>Admin Setup</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li id="users"><a href="<?=base_url('view-users')?>"><i class="fa fa-chevron-circle-right"></i> Users</a></li>
					<!-- <?php if($this->session->superadmin == 'Yes'){ ?>
						<li id="usersC"><a href="<?=base_url('view-users-cebu')?>"><i class="fa fa-chevron-circle-right"></i> Users (Cebu)</a></li>
					<?php } ?> -->
					<li id="usersC"><a href="<?=base_url('view-users-cebu')?>"><i class="fa fa-chevron-circle-right"></i> Users (Cebu)</a></li>
					<li id="bu"><a href="<?=base_url('view-bu')?>"><i class="fa fa-chevron-circle-right"></i> Business Unit</a></li>
					<li id="groups"><a href="<?=base_url('view-usergroup')?>"><i class="fa fa-chevron-circle-right"></i> User Groups</a></li>	
					<li id="pending-r"><a href="<?=base_url('view-pending')?>"><i class="fa fa-chevron-circle-right"></i> Manage Pending Requests</a></li>
					<?php if($this->session->emp_id == '02723-2022' OR $this->session->emp_id == '02483-2023' OR $this->session->emp_id == '03972-2022' ){ ?>
						<li id="pending-d"><a href="<?=base_url('view-deduct')?>"><i class="fa fa-chevron-circle-right"></i> View Deduction</a></li>
					<?php } ?>
				</ul>
			</li>

			<!-- <li id="dashboardSideNav"><a href="<?php echo base_url()?>profile"><i class="fa fa-dashboard"></i> 
				<span>Logs</span></a>
			</li>	 -->
		<?php } ?>
	
		<?php if($getType2 == true){ ?>

			<li class="treeview" id="requestSideTree">
			  	<a href="#">
					<i class="fa fa-clipboard"></i> <span>Requests</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li id="rfs_r"><a href="<?=base_url('view-rfs')?>"><i class="fa fa-chevron-circle-right"></i> RFS</a></li>
					<li id="tor_r"><a href="<?=base_url('view-tor')?>"><i class="fa fa-chevron-circle-right"></i> TOR</a></li>	
					<?php if($getIsr == true){ ?>
						<li id="isr_r"><a href="<?=base_url('view-isr')?>"><i class="fa fa-chevron-circle-right"></i> ISR</a></li>	
					<?php } ?>	
					<?php if($getConcern == true){ ?>
						<li id="concern_r"><a href="<?php echo base_url()?>view-concern"><i class="fa fa-chevron-circle-right"></i><span>Concerns</span></a></li>
					<?php } ?>
				</ul>
			</li>
		<?php } ?>

		<?php if($getType3 == true){ ?>

			<li class="treeview" id="approveSideTree">
			  	<a href="#">
					<i class="fa fa-thumbs-o-up"></i> <span>Approve</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li id="rfs_a"><a href="<?=base_url('pending-rfs-status')?>"><i class="fa fa-chevron-circle-right"></i> RFS
						<?php  
                            foreach($rfsA as $r) {
                                if($r->rfsA != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->rfsA. ' </span>';
                                }
                            }
                            ?>
					</a></li>
					<li id="tor_a"><a href="<?=base_url('pending-tor-status')?>"><i class="fa fa-chevron-circle-right"></i> TOR
						<?php  
                            foreach($torA as $r) {
                                if($r->torA != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->torA. ' </span>';
                                }
                            }
                            ?>
					</a></li>	
					<?php if($getIsr == true){ ?>
						<li id="isr_a"><a href="<?=base_url('pending-isr-status')?>"><i class="fa fa-chevron-circle-right"></i> ISR
							<?php  
                            foreach($isrA as $r) {
                                if($r->isrA != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->isrA. ' </span>';
                                }
                            }
                            ?>
						</a></li>
					<?php } ?>	
							
				</ul>
			</li>
		<?php } ?>

		<?php if($getType4 == true){ ?>

			<li class="treeview" id="executeSideTree">
			  	<a href="#">
					<i class="fa fa-thumbs-o-up"></i> <span>Execute</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li id="rfs_e">
						<a href="<?=base_url('pending-rfs-status-e')?>"><i class="fa fa-chevron-circle-right"></i> RFS
							<?php  
                            foreach($rfs as $r) {
                                if($r->rfs != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->rfs. ' </span>';
                                }
                            }
                            ?>
						</a>
					</li>
					<li id="tor_e">
						<a href="<?=base_url('pending-tor-status-e')?>"><i class="fa fa-chevron-circle-right"></i> TOR
							<?php  
                            foreach($tor as $r) {
                                if($r->tor != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->tor. ' </span>';
                                }
                            }
                            ?>
						</a>
					</li>
					<?php if($getIsr == true){ ?>
						<li id="isr_e">
							<a href="<?=base_url('pending-isr-status-e')?>"><i class="fa fa-chevron-circle-right"></i> ISR
							<?php  
                            foreach($isr as $r) {
                                if($r->isr != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->isr. ' </span>';
                                }
                            }
                            ?>
						</a>
					</li>	
					<?php } ?>		
					<?php if($getConcern == true){ ?>
						<li id="concern_e">
							<a href="<?php echo base_url()?>pending-concern-status"><i class="fa fa-chevron-circle-right"></i>Concerns	
							<?php  
                            foreach($con as $r) {
                                if($r->con != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->con. ' </span>';
                                }
                            }
                            ?>
							</a>
						</li>
					<?php } ?>	
				</ul>
			</li>
		<?php } ?>

		<?php if($getType5 == true){ ?>

			<li class="treeview" id="reviewSideTree">
			  	<a href="#">
					<i class="fa fa-thumbs-o-up"></i> <span>Review</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li><a href="<?=base_url('pending-rfs-status-r')?>"><i class="fa fa-chevron-circle-right"></i> RFS
						<?php  
                            foreach($rfsR as $r) {
                                if($r->rfsR != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->rfsR. ' </span>';
                                }
                            }
                            ?>
					</a></li>
					<li><a href="<?=base_url('pending-tor-status-r')?>"><i class="fa fa-chevron-circle-right"></i> TOR
						<?php  
                            foreach($torR as $r) {
                                if($r->torR != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->torR. ' </span>';
                                }
                            }
                            ?>
					</a></li>
					<?php if($getIsr == true){ ?>
						<li><a href="<?=base_url('pending-isr-status-r')?>"><i class="fa fa-chevron-circle-right"></i> ISR
							<?php  
                            foreach($isrR as $r) {
                                if($r->isrR != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->isrR. ' </span>';
                                }
                            }
                            ?>
						</a></li>	
					<?php } ?>		
						
				</ul>
			</li>
		<?php } ?>

		<?php if($getType6 == true){ ?>

			<li class="treeview" id="verifySideTree">
			  	<a href="#">
					<i class="fa fa-thumbs-o-up"></i> <span>Verify</span>
					<span class="pull-right-container">
					  	<i class="fa fa-chevron-circle-left pull-right"></i>
				  	</span>
				</a>
				<ul class="treeview-menu"> 
					<li><a href="<?=base_url('pending-rfs-status-v')?>"><i class="fa fa-chevron-circle-right"></i> RFS
						<?php  
                            foreach($rfsV as $r) {
                                if($r->rfsV != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->rfsV. ' </span>';
                                }
                            }
                            ?>
					</a></li>
					<li><a href="<?=base_url('pending-tor-status-v')?>"><i class="fa fa-chevron-circle-right"></i> TOR
						<?php  
                            foreach($torV as $r) {
                                if($r->torV != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->torV. ' </span>';
                                }
                            }
                            ?>
					</a></li>
					<?php if($getIsr == true){ ?>
						<li><a href="<?=base_url('pending-isr-status-v')?>"><i class="fa fa-chevron-circle-right"></i> ISR
							<?php  
                            foreach($isrV as $r) {
                                if($r->isrV != 0){
                                    echo '<span class="right badge badge-danger"> ' .$r->isrV. ' </span>';
                                }
                            }
                            ?>
						</a></li>	
					<?php } ?>		
						
				</ul>
			</li>
		<?php } ?>

			<!-- <li class="treeview" id="userSideTree">
				<a href="#">
					<i class="fa fa-gears"></i> <span>User Setup</span>
					<span class="pull-right-container">
					  <i class="fa fa-chevron-circle-left pull-right"></i>
			  		</span>
			  	</a>
				<ul class="treeview-menu"> 
					<li id="password"><a href="<?=base_url('change-pass')?>"><i class="fa fa-chevron-circle-right"></i> Update Password</a></li>

					<li id="username"><a href="<?=base_url('update-profile')?>"><i class="fa fa-chevron-circle-right"></i> Update Profile</a></li>
				</ul>
			</li> -->

			<!-- <?php if($getType4 == true){ ?>
			<li class="treeview" id="trackerSideTree">
				<a href="#">
					<i class="fa fa-list-alt"></i> <span>Requests Tracker</span>
					<span class="pull-right-container">
					  <i class="fa fa-chevron-circle-left pull-right"></i>
			  		</span>
			  	</a>
				<ul class="treeview-menu"> 
					<li id=""><a data-toggle="modal" data-target="#rfsTracker"><i class="fa fa-chevron-circle-right"></i> RFS</a></li>

					<li id=""><a data-toggle="modal" data-target="#torTracker"><i class="fa fa-chevron-circle-right"></i> TOR</a></li>

					<li id=""><a data-toggle="modal" data-target="#isrTracker"><i class="fa fa-chevron-circle-right"></i> ISR</a></li>

				</ul>
			</li>
			<?php } ?> -->
			
			<?php if($this->session->superadmin == 'Yes'){ ?>
		
				<li id="logsSideNav"><a href="<?php echo base_url()?>view-logs"><i class="fa fa-tasks"></i> 
					<span>Activity Logs</span></a>
				</li>	
			<?php } ?>

			<?php if($getType4 == true){ ?>
		
				<li id="rlogsSideNav"><a href="<?php echo base_url()?>view-logs-r"><i class="fa fa-tasks"></i> 
					<span>Request Logs</span></a>
				</li>	
			<?php } ?>
			<!-- <li class="treeview" id="userManualSideTree">
				<a href="#">
					<i class="fa fa-list-alt"></i> <span>User's Manual</span>
					<span class="pull-right-container">
					  <i class="fa fa-chevron-circle-left pull-right"></i>
			  		</span>
			  	</a>
				<ul class="treeview-menu"> 
					
					<li id=""><a data-toggle="modal" data-target="#rfs_manual" href="#"><i class="fa fa-chevron-circle-right"></i> RFS</a></li>
					<li id=""><a data-toggle="modal" data-target="#tor_manual" href="#"><i class="fa fa-chevron-circle-right"></i> TOR</a></li>

					
				</ul>
			</li> -->

			<li id="userManualSideTree"><a data-toggle="modal" data-target="#user_manual" href="#"><i class="fa fa-list-alt"></i> 
				<span>User's Manual</span></a>
			</li>

			<li id="contactSideNav"><a href="<?php echo base_url()?>view-contact"><i class="fa fa-phone"></i> 
				<span>Contact Us</span></a>
			</li>
			

			<!-- <li class="treeview"> <a href="<?php echo base_url()?>view-contact">
				<a href="#">
					<i class="fa fa-folder-open"></i> <span>Reports</span>
					<span class="pull-right-container">
					  <i class="fa fa-chevron-circle-left pull-right"></i>
			  		</span>
			  	</a>
				<ul class="treeview-menu"> 
					<li><a href="<?=base_url('change-pass')?>"><i class="fa fa-chevron-circle-right"></i> Executed Requests per Group</a></li>

					
					<li><a href="<?=base_url('update-profile')?>"><i class="fa fa-chevron-circle-right"></i> Executed Request per User</a></li>
					<li><a href="<?=base_url('update-profile')?>"><i class="fa fa-chevron-circle-right"></i> Top Request Type per Group</a></li>
				</ul>
			</li> -->

			<!-- <li id="pdfLink"><a href="<?=base_url()?>uploads/profile-pic/Request_Side.pdf" target="_blank"><i class="fa fa-chevron-circle-right"></i> RFS</a></li> -->

			

	</ul>
</section>
<!-- /.sidebar -->
</aside>
	
	<div id="user_manual" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="width: 85%;">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h3 style="text-align: center;" class="modal-title"><b>Online TOR & RFS User's Manual</b></h3>
                </div>
                <div class="modal-body">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#rfs_tab" aria-controls="rfs" role="tab" data-toggle="tab">REQUEST FOR SET-UP (RFS)</a></li>
	                	<li role="presentation" ><a href="#tor_tab" aria-controls="tor" role="tab" data-toggle="tab">TRANSACTION OVERRIDE REQUEST (TOR)</a></li>
           			</ul><br>
					
					<div class="tab-content">      
	                    <div role="tabpanel" class="tab-pane active" id="rfs_tab">
	                    	<iframe src="<?=base_url()?>uploads/profile-pic/RFS USER MANUAL.pdf" width="100%" height="600" allow="autoplay"></iframe>
	                    </div>

	                    <div role="tabpanel" class="tab-pane" id="tor_tab">
	                    	<iframe src="<?=base_url()?>uploads/profile-pic/TOR USER MANUAL.pdf" width="100%" height="600" allow="autoplay"></iframe>
	                    </div>
                	</div>
               
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div> 

    <div id="tor_manual" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg"style="width: 85%;" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>TOR User's Manual</b></h4>
                </div>
                <div class="modal-body">
               
                     <iframe src="<?=base_url()?>uploads/profile-pic/TOR USER MANUAL.pdf" width="100%" height="600" allow="autoplay"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>     
	<div id="rfsTracker" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Request Tracker</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                 <?php echo form_open('Admin/ViewReq'); ?> 
                    <form method="post" >
                        <div class="row">

		                    <input type="hidden" class="form-control" name="r_type" id="r_type" value="RFS">
		                        

		                    <div class="col-md-6">      
		                        <div class="form-group">
		                            <label for="request">Request Number</label>
		                            <input type="text" class="form-control" name="rfs_no" id="rfs_no" autocomplete="off" autofocus placeholder="RFS Number" required >
		                        </div>
		                    </div>
	                    

	                	</div>
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

    <div id="torTracker" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Request Tracker</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                 <?php echo form_open('Admin/ViewReqTor'); ?> 
                    <form method="post" >
                        <div class="row">

		                    <input type="hidden" class="form-control" name="r_type" id="r_type" value="TOR">
		                        

		                    <div class="col-md-6">      
		                        <div class="form-group">
		                            <label for="request">Request Number</label>
		                            <input type="text" class="form-control" name="tor_no" id="tor_no" autocomplete="off" autofocus placeholder="TOR Number" required >
		                        </div>
		                    </div>
	                    

	                	</div>
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

	<div id="viewRemarksModal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>View Remarks</b></h4>
                </div>
                <div class="modal-body" style="height: 250px">
                    <form  id="viewRemarks" method="post">
                        <div id="viewremarks_content"></div>   
                        
                        <!-- <button type="submit" class="btn btn-primary" value="Submit">Submit</button>
                        <button type="reset" class="btn btn-danger"  value="Reset">Reset</button>  -->
                    </form>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

	<div id="addRemarksModal" class="modal fade" tabindex="-1" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Add Remarks</b></h4>
                </div>
                <div class="modal-body" style="height: 250px">
                    <form  id="addRemarks" method="post">
                        <div id="addremarks_content"></div>   
                        
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

    <div id="editRemarksModal" class="modal fade" role="dialog" >
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Edit Remarks</b></h4>
                </div>
                <div class="modal-body" style="height: 250px">
                    <form  id="editRemarks" method="post">
                        <div id="editremarks_content"></div> 
                        
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

    <div id="ApproveConcernModal" class="modal fade">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Concern Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form action="<?php echo base_url('Admin/rfsupdate') ?>" id="editRfs" method="post" enctype="multipart/form-data">  
                        <div id="approveconcern_content"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="ApproveRfsModal" class="modal fade">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>RFS Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form action="<?php echo base_url('Admin/rfsupdate') ?>" id="editRfs" method="post" enctype="multipart/form-data">  
                        <div id="approverfs_content"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="ApproveTorModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>TOR Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form action="<?php echo base_url('Admin/torupdate') ?>" id="editTor" method="post" enctype="multipart/form-data">  
                        <div id="approvetor_content"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>

            </div>
        </div>
    </div>

    <div id="ApproveIsrModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>ISR Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form action="<?php echo base_url('Admin/isrupdate') ?>" id="editTor" method="post" enctype="multipart/form-data">  
                        <div id="approveisr_content"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="ApproveRfsModalE" class="modal fade">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>RFS Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form id="addRemarksrfs" method="post" >  
                        <div id="approverfs_content_e"></div>
                           
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="ApproveTorModalE" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>TOR Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form id="addRemarkstor" method="post" >  
                        <div id="approvetor_content_e"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>
    
    <div id="ApproveIsrModalE" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>ISR Details</b></h4>
                </div>
                <div class="modal-body">
               
                    <form id="addRemarksisr" method="post" >  
                        <div id="approveisr_content_e"></div>
                            
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="showApprovedModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Request Status</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                    <div id="approved_view_rfs">
                                     
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="showApprovedModalTor" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog modal-lg-scrollable" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Request Status</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                    <div id="approved_view_tor">
                                     
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

    <div id="showApprovedModalIsr" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog modal-lg-scrollable" >
            <div class="modal-content" style="border-radius: 10px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button> 
                    <center><img src="<?=base_url()?>assets/dist/img/logo.png" class="img-circle"  alt="logo" style="height: 40px; width: 40px;"></center> 
                <h4 style="text-align: center;" class="modal-title"><b>Request Status</b></h4>
                </div>
                <div class="modal-body" style="height: auto;">
                    <div id="approved_view_isr">
                                     
                    </div>
                </div>
                <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                </div>
            </div>
        </div>
    </div>

        
<!-- <script>
	$(document).ready(function() {
   
	   $("#userManualSideTree").addClass('active');
	   $("#addrfs").addClass('active');
	});

</script> -->

<!-- <script src="<?=base_url()?>js/pages/users.js"></script>  -->
<!-- 
<script type="text/javascript">
	DarkReader.enable({
    brightness: 100,
    contrast: 90,
    sepia: 10
	});

	// DarkReader.disable();

	// // Enable when the system color scheme is dark.
	// DarkReader.auto({
	//     brightness: 100,
	//     contrast: 90,
	//     sepia: 10
	// });

	// // Stop watching for the system color scheme.
	// DarkReader.auto(false);

	// // Get the generated CSS of Dark Reader returned as a string.
	// const CSS = await DarkReader.exportGeneratedCSS();

	// // Check if Dark Reader is enabled.
	// const isEnabled = DarkReader.isEnabled();
</script> -->

<script src="<?=base_url()?>assets/js/moment.min.js"></script>


	<script type="text/javascript">

	
	$(function(){

    // Cache some selectors

    var clock = $('#clock'),
        alarm = clock.find('.alarm'),
        ampm = clock.find('.ampm');

    // Map digits to their names (this will be an array)
    var digit_to_name = 'zero one two three four five six seven eight nine'.split(' ');

    // This object will hold the digit elements
    var digits = {};

    // Positions for the hours, minutes, and seconds
    var positions = [
        'h1', 'h2', ':', 'm1', 'm2', ':', 's1', 's2'
    ];

    // Generate the digits with the needed markup,
    // and add them to the clock

    var digit_holder = clock.find('.digits');

    $.each(positions, function(){

        if(this == ':'){
            digit_holder.append('<div class="dots">');
        }
        else{

            var pos = $('<div>');

            for(var i=1; i<8; i++){
                pos.append('<span class="d' + i + '">');
            }

            // Set the digits as key:value pairs in the digits object
            digits[this] = pos;

            // Add the digit elements to the page
            digit_holder.append(pos);
        }

    });

    // Add the weekday names

    var weekday_names = 'SUN MON TUE WED THU FRI SAT'.split(' '),
        weekday_holder = clock.find('.weekdays');

    $.each(weekday_names, function(){
        weekday_holder.append('<span>' + this + '</span>');
    });

    var weekdays = clock.find('.weekdays span');

    // Run a timer every second and update the clock

    (function update_time(){

        // Use moment.js to output the current time as a string
        // hh is for the hours in 12-hour format,
        // mm - minutes, ss-seconds (all with leading zeroes),
        // d is for day of week and A is for AM/PM

        //var now = moment().format("hhmmssdA");
        var now = moment().format("hhmmssdA");


        digits.h1.attr('class', digit_to_name[now[0]]);
        digits.h2.attr('class', digit_to_name[now[1]]);
        digits.m1.attr('class', digit_to_name[now[2]]);
        digits.m2.attr('class', digit_to_name[now[3]]);
        digits.s1.attr('class', digit_to_name[now[4]]);
        digits.s2.attr('class', digit_to_name[now[5]]);

        // The library returns Sunday as the first day of the week.
        // Stupid, I know. Lets shift all the days one position down, 
        // and make Sunday last

        var dow = now[6];
        dow;


        // Sunday!
        if(dow < 0){
            // Make it last
            dow = 6;
        }



        // Mark the active day of the week
        weekdays.removeClass('active').eq(dow).addClass('active');

        // Set the am/pm text:
        ampm.text(now[7]+now[8]);

        // Schedule this function to be run again in 1 sec
        setTimeout(update_time, 1000);

    })();

    // Switch the theme

    $('a.button').click(function(){
        clock.toggleClass('light dark');
    });

});
</script>

<script>
    const snowContainer = document.getElementById("snow-container");
	const snowContent = ['&#10052', '&#10053', '&#10054']

	const random = (num) => {
	  return Math.floor(Math.random() * num);
	}

	const getRandomStyles = () => {
	  const top = random(100);
	  const left = random(100);
	  const dur = random(10) + 10;
	  const size = random(25) + 25;
	  return `
	    top: -${top}%;
	    left: ${left}%;
	    font-size: ${size}px;
	    animation-duration: ${dur}s;
	  `;
	}

	const createSnow = (num) => {
	  for (var i = num; i > 0; i--) {
	    var snow = document.createElement("div");
	    snow.className = "snow";
	    snow.style.cssText = getRandomStyles();
	    snow.innerHTML = snowContent[random(3)]
	    snowContainer.append(snow);
	  }
	}

	

	window.addEventListener("load", () => {
	  createSnow(15)
	  
	});	
</script> 