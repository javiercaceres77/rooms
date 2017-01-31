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
    <meta name="description" content="Milton Rooms short stay rooms" />
    <meta name="keywords" content="Milton Keynes short stay accomodation rooms" />
    <meta name="author" content="humans.txt">

    <link rel="icon" href="../../favicon.ico">

    <title>::: MiltonRooms.com ::: Short stay accommodation</title>

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
            <li><a href="https://www.facebook.com/miltonroomsdotcom"><img src="<?= $conf_images_path; ?>facebook-logo.png" height="20" width="20"> /miltonroomsdotcom</a></li>
	    <li><a href="mailto:miltonrooms@outlook.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> contact</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    <!-- Module and side bar ============================================= -->
    <div class="container">
	  <div class="row">
	    <div class="col-md-8">
		  <?php
			# -------------------- INCLUDE THE MODULE view --------------------- #	
			if(!$_GET['view']) $_GET['view'] = 'main';

			$include_file = 'mod/'. $_GET['mod'] .'/'. $_GET['view'] .'.php';

			if($_SESSION['login']['modules'][$_GET['mod']]['read'])
				include $include_file;	
		  ?>
		</div>
	    <div class="col-md-4 sidebar" style="padding:36px;">
		  
		    <h2 class="text-center">Clean &amp; Modern</h2>
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">15 Min to the centre by bus</h2>
		    <img src="<?= $conf_images_path; ?>/rooms/mapa2.jpg" class="img-responsive" alt="15 minutes to the centre by bus">
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">TV, fridge, kettle in the room</h2>
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">Breakfast &amp; Self-serve snacks</h2>
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">Daily cleaning of common areas</h2>
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">From &pound;36 <abbr title="for 1 guest. Ask about prices for longer stays">per night</abbr></h2>
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">Living room, mini-kitchen</h2>
		    <!--<hr style="margin:20px 50px;">
		    <h2 class="text-center testimonial">&#x275D; Great stay in Milton Rooms ... &#x275E;</h2>-->
		    <hr style="margin:20px 50px;">
		    <h2 class="text-center">No deposit or cleaning fees</h2>
			<hr style="margin:20px 50px;">
			<h2 class="text-center">High speed Internet access</h2>
		</div>
	  </div>
	     <div class="container">
		<div class="row">
		    <div class="col-md-4">
		       <div class="airbnb-embed-frame" data-user-id="6768825" data-view="superhost_button" data-city="Milton Keynes" data-city-url="https://www.airbnb.co.uk/s/Milton-Keynes--United-Kingdom" data-eb="1462448162_hw0glUOmHC+FTT9S" data-eu="y+7mh4u+whiCdOk6Zl/EMBQ0jZUBxyxR2B1cAw5OvfeOeecSBWdo666Co3OB /pgLFpfMoMbEqt4iiicEPIp+rHXDZ/kgFMizq/JsaKfYPLaLvNUG7kmblTMR pk0F9cRnA2mA2r+qQ3k+ft0xPLws5ZAf1Sx0gLM31jCSWXWYqd0AZ6LL8Y6c e0+BKjJVTJhLvlcO+I9gjbVodmc2m8t6p9sy5kvsUzxzfCB6wp2iXSAZYrpL p+1qNkSz9CH1XOeNmMzb1PizoV4xK7T+wUGt0Pk1ekQePfT7ar58L/Q6i9Py mrU+W3glkwAr7NQ0Bci7aP4oStoMChaoxMelSBSBiw== " data-trigger-source-type="badge_center" data-embed-source-type="badge_center" style="margin:auto;height:85px;"><a href="https://www.airbnb.co.uk/users/show/6768825" rel="nofollow">Superhost</a><div>in Milton Keynes</div><script async="" src="https://www.airbnb.co.uk/embeddable/airbnb_jssdk"></script></div>
		    </div>
                    <div class="col-md-4">
		       <div class="airbnb-embed-frame" data-review-count="83" data-review-rating="5" data-view="star_rating_button" data-listing-id="5916430" data-eb="1462448162_hw0glUOmHC+FTT9S" data-eu="y+7mh4u+whiCdOk6Zl/EMBQ0jZUBxyxR2B1cAw5OvfeOeecSBWdo666Co3OB /pgLFpfMoMbEqt4iiicEPIp+rHXDZ/kgFMizq/JsaKfYPLaLvNUG7kmblTMR pk0F9cRnA2mA2r+qQ3k+ft0xPLws5ZAf1Sx0gLM31jCSWXWYqd0AZ6LL8Y6c e0+BKjJVTJhLvlcO+I9gjbVodmc2m8t6p9sy5kvsUzxzfCB6wp2iXSAZYrpL p+1qNkSz9CH1XOeNmMzb1PizoV4xK7T+wUGt0Pk1ekQePfT7ar58L/Q6i9Py mrU+W3glkwAr7NQ0Bci7aP4oStoMChaoxMelSBSBiw== " data-trigger-source-type="badge_center" data-embed-source-type="badge_center" data-listing-url="https://www.airbnb.co.uk/rooms/5916430" style="height:75px;margin:auto;"><a href="https://www.airbnb.co.uk/rooms/5916430"><span>5-star with </span><span><span>83 reviews</span></span></a><script async="" src="https://www.airbnb.co.uk/embeddable/airbnb_jssdk"></script></div>
		    </div>
		</div>
	    </div>
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
