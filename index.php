<?php

header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
session_start();

# control $_SESSION inactivity time
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	// last request was more than 30 minates ago
	@session_destroy(); // destroy session data in storage
	session_unset(); // unset $_SESSION variable for the runtime
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
if($_GET['func'] == 'logout') session_unset();

# Includes ----------------------------------
include 'inc/config.php';
include $conf_include_path .'comm.php';
include $conf_include_path .'connect.php';
include $conf_include_path .'oops_comm.php';

if(!$_GET['lang'] && !$_SESSION['misc']['lang']) $_GET['lang'] = $conf_default_lang;
if($_GET['lang']) $_SESSION['misc']['lang'] = $_GET['lang'];
include $conf_include_path .'translation.php';
date_default_timezone_set($conf_timezone);

# Sanitize get and post ----------------------------------
sanitize_input();

# Logout user ----------------------------------
if($_GET['func'] == 'logout') {
	# store record of user logging out?
	session_unset(); session_destroy();
	jump_to($conf_main_page);
	exit();
}

# Get user info ----------------------------------
if(!isset($_SESSION['login']['user_id']))
	$_SESSION['login']['user_id'] = $conf_generic_user_id;
# Create objects for this page. ----------------------------------
if(!isset($ob_user))
	$ob_user = new user($_SESSION['login']['user_id'], $_SESSION['login']['name']);

$now = new date_time('now');
# Manage modules ----------------------------------
if(!$_GET['mod']) $_GET['mod'] = $conf_default_mod;
	refresh_users_modules(true);

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="LCGaste Ltd" />
	<meta name="keywords" content="LCGaste Rocaya ersmsk" />
	<meta name="author" content="humans.txt">

	<link rel="icon" href="../../favicon.ico">

    <title>::: MiltonRooms.com :::</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.miltonrooms.com">MiltonRooms.com &nbsp;<small><em>Short stay rooms</em></small></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#map"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Find us</a></li>
            <li><a href="#rooms"><span class="glyphicon glyphicon-bed" aria-hidden="true"></span> Our rooms</a></li>
			<li><a href="mailto:miltonrooms@outlook.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> contact</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
	<!-- Carousel   ================================================== -->
   <div class="carousel slide" id="myCarousel" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li class="active" data-target="#myCarousel" data-slide-to="0"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
	<li data-target="#myCarousel" data-slide-to="3"></li>
	<li data-target="#myCarousel" data-slide-to="4"></li>
	<li data-target="#myCarousel" data-slide-to="5"></li>
	<li data-target="#myCarousel" data-slide-to="6"></li>
	<li data-target="#myCarousel" data-slide-to="7"></li>
	<li data-target="#myCarousel" data-slide-to="8"></li>
	<li data-target="#myCarousel" data-slide-to="9"></li>
	<li data-target="#myCarousel" data-slide-to="10"></li>
	<li data-target="#myCarousel" data-slide-to="11"></li>
	<li data-target="#myCarousel" data-slide-to="12"></li>
	<li data-target="#myCarousel" data-slide-to="13"></li>
	<li data-target="#myCarousel" data-slide-to="14"></li>
	<li data-target="#myCarousel" data-slide-to="15"></li>
	<li data-target="#myCarousel" data-slide-to="16"></li>
	<li data-target="#myCarousel" data-slide-to="17"></li>
	<li data-target="#myCarousel" data-slide-to="18"></li>
	<li data-target="#myCarousel" data-slide-to="19"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <div class="container">
		    <img src="<?= $conf_images_path; ?>/rooms/001RoomA5.jpg" class="img-responsive" alt="Responsive image">
		    <!--<img class="first-slide" alt="First slide" src="<?= $conf_images_path; ?>/rooms/001RoomA5.jpg">
            <div class="carousel-caption">
              <h1>Example headline.</h1>
              <p>Note: If you're viewing this page via a <code>file://</code> URL, the "next" and "previous" Glyphicon buttons on the left and right might not load/display properly due to web browser security rules.</p>
              <p><a class="btn btn-lg btn-primary" role="button" href="#">Sign up today</a></p>
            </div>-->
          </div>
        </div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living01.jpg" class="img-responsive" alt="Living area for breakfast, dinner or just relax"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/001RoomA5.jpg" class="img-responsive" alt="Room 1, clean and spacious"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/001RoomB1.jpg" class="img-responsive" alt="Room 2, clean and luminous"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/008Captura2.jpg" class="img-responsive" alt="20 min by bus to city centre"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/001RoomB2.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/001RoomB4.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/002RoomA4.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/002RoomB2.JPG" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living04.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living02.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living03.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/003RoomA1.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living05.jpg" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/004RoomA2.JPG" class="img-responsive" alt="Responsive image"></div></div>
        <div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/004RoomB3.JPG" class="img-responsive" alt="Responsive image"></div></div>
	<div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/005RoomA3.JPG" class="img-responsive" alt="Responsive image"></div></div>
	<div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/011Living06.jpg" class="img-responsive" alt="Responsive image"></div></div>
	<div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/009Bathroom1.jpg" class="img-responsive" alt="Responsive image"></div></div>
	<div class="item"><div class="container"><img src="<?= $conf_images_path; ?>/rooms/010Bathroom2.jpg" class="img-responsive" alt="Responsive image"></div></div>
      </div>
      <a class="left carousel-control" role="button" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" role="button" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
	<!-- /.carousel -->
   <!--<div class="jumbotron">
      <div class="container">
        <h1>LCGaste ltd.</h1>
        <p>IT consultancy and web development.</p>
        <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p>
      </div>
    </div>-->
	<a name="map"></a>
    <div class="container">
	  <div class="row">
	   <div class="col-md-6" align="center">
	  	<p class="lead">Less than 20 min by bus from Milton Keynes Central</p>
	  	<a target="_blank" href="https://www.google.co.uk/maps/dir/52.049633,-0.69185/Milton+Keynes+Central,+Milton+Keynes+MK9/@52.0442926,-0.7454961,14z/data=!4m9!4m8!1m0!1m5!1m1!1s0x4877000979c605f3:0x589bc8778e2ba794!2m2!1d-0.77413!2d52.0343!3e3">
		   <img class="img-responsive" src="<?= $conf_images_path; ?>MKC.JPG" alt="Google maps" height="300" width="400">
		</a>
	   </div>
	   <div class="col-md-6" align="center">
	     <p class="lead">Very close to Cranfield University</p>
	    <a target="_blank" href="https://www.google.co.uk/maps/dir/52.049633,-0.69185/Cranfield+University,+College+Rd,+Cranfield,+Bedford+MK43+0AL/@52.0693912,-0.6659084,13z/data=!4m9!4m8!1m0!1m5!1m1!1s0x4877ac4d48c8faeb:0x44c903e6bd92ce97!2m2!1d-0.629225!2d52.074389!3e3">
		<img class="img-responsive" src="<?= $conf_images_path; ?>cranfield.JPG" alt="Google maps" height="300" width="400"></a>
	   </div>
	  </div>
     </div>
     <a name="rooms"></a>
      <footer>
        <p>&copy; Lcgaste ltd. <?= date('Y'); ?></p>
      </footer>
    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="<?= $conf_include_path; ?>js/bootstrap.min.js"></script>
    <script language="javascript" src="<?= $conf_include_path; ?>comm.js"></script>
    <script language="javascript" src="<?= $conf_include_path; ?>ajax.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
