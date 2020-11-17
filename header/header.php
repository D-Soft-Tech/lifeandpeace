<?php
  session_start();

  if(isset($_POST['logoutPassword']))
  {

    unset($_SESSION['username_frontEnd']);
    unset($_SESSION['password_frontEnd']);
    unset($_SESSION['shoppingCart']);

  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta, title, CSS, favicons, etc. -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Life and peace Commission; is church value is reaching the unsaved in the remotest and interior part of the world while equipping the saint for service.
The three most essential aspect of our family are: Sound Teachings, Sweet Fellowship and Strong Prayers">
<meta name="keywords" content="Church, Website, Strong Prayers, Sound Teachings, Sweet Fellowship, Mount Zion Fortress, Life and Peace, Descipleship, Knowing the Christ, Intimacy with the Father">
<meta name="author" content="Oloyede Adebayo (+2349075771869)">
<title>Life and Peace Commission - Mount Zion Fortress</title>
<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- Church Template CSS -->
<link href="css/church.css" rel="stylesheet">
<link rel="stylesheet" href="assets/forala/css/froala_editor.pkgd.min.css">
<link href="css/fancybox.css" rel="stylesheet">
<link rel="stylesheet" href="assets/fontawesomeForWeb/css/all.css">
<link rel="stylesheet" href="assets/jssocial/jssocials.css">
<link rel="stylesheet" href="assets/jssocial/jssocials-theme-flat.css">
<link href="js/aos/aos.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <script src="js/respond.min.js"></script>
<![endif]-->

<!-- Favicons -->
<link rel="shortcut icon" href="images/favicon.png">

<!-- Custom Google Font : Montserrat and Droid Serif -->

<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
<!-- Navigation Bar Starts -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="index.php"> <img src="images/lpc.jpg" alt="church logo" class="img-responsive img-circle"></a> <h5 style="color: white;"> Life And Peace <span class="text-justify">Commission</span></h5></div>
      <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index.php">HOME</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">SERMONS <span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left" role="menu">
                <li><a href="audio-gallery.php">Audio Gallery</a></li>
                <li><a href="video-gallery.php">Video Gallery</a></li>
              </ul>
            </li>
            <li><a href="books.php">BOOKS</a></li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">PAGES <span class="caret"></span></a>
              <ul class="dropdown-menu dropdown-menu-left" role="menu">
                <li><a href="image-gallery.php">Image Gallery</a></li>
                <li><a href="blog.php">Bulletin</a></li>
                <li><a href="events-programs.php">Events &amp; Programs</a></li>
                <li><a href="weeklyProgram.php">Weekly Program</a></li>
                <li><a href="charity-donation.php">Charity &amp; Donations</a></li>
                <li><a href="testimony.php">Testimonies</a></li>
              </ul>
            </li>
            <li><a href="give.php">Give Online</a></li>
            <li><a href="contact.php">CONTACT</a></li>
            <?php
              function href()
              {
                if(!isset($_SESSION['username_frontEnd']) && !isset($_SESSION['password_frontEnd']))
                {
                echo "<li class='dropdown'>". 
                        "<a href='logs.php'>".
                          "<b>Login</b>".
                        "</a>".
                      "</li>";
                }
                else
                {
                  echo '<li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>'.$_SESSION['username_frontEnd'].'<span class="caret"></span></b></a>';
                }
              }

              href();

              function is_loggedIn()
              {
                if(isset($_SESSION['username_frontEnd']) && isset($_SESSION['password_frontEnd']))
                {
                  echo  '<ul class="dropdown-menu dropdown-menu-left" role="menu">'.
                          '<li>'.
                            '<a href="#" type="button" class="mr-0 pr-0 dropdown-item logOut" name="'.$_SESSION['password_frontEnd'].'" id="'.$_SESSION['username_frontEnd'].'"><b>Log out</b></a>'.
                          '</li>'.
                        '</ul>';
                }
              }

              is_loggedIn();
            ?>
            </li>
          </ul>
      </div>
    <!--/.nav-collapse --> 
  </div>
</div>
<!--// Navbar Ends--> 
