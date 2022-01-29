<!doctype html>
<html lang="en">

  <head>
    <title> EXPRESSO - express your thoughts in your own style </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php include("connection.php"); ?>

    <link rel="icon" type="image/ico" href="images/ICON.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700|Inconsolata:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap">
    <link rel="stylesheet" href="selfmade.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    
    <div class="wrap">

      <header role="banner">

        <div class="top-bar">
          <div class="container">
            <div class="row">
              <div class="col-9 social">
                <a href="https://www.facebook.com/" target="_blank"><span class="fa fa-facebook"></span></a>
                <a href="https://twitter.com" target="_blank"><span class="fa fa-twitter"></span></a>
                <a href="https://www.instagram.com/" target="_blank"><span class="fa fa-instagram"></span></a>
                <a href="https://www.youtube.com/" target="_blank"><span class="fa fa-youtube-play"></span></a>
              </div>
              <div class="col-3 search-top">
                <form action="#" class="search-top-form">
                  <span class="icon fa fa-search"></span>
                  <input type="text" id="s" placeholder="Type keyword to search...">
                </form>
              </div>
            </div>
          </div>
        </div>

        <div class="container logo-wrap">
          <div class="row pt-5">
            <div class="two"> <a href="<?php echo $reference1;?>"> <button class="btn-primary btn-sm rounded one"> <?php echo $notation1;?> </button> </a> </div>
            <div> <a href="<?php echo $reference2;?>"> <button class="btn-primary btn-sm rounded one"> <?php echo $notation2;?> </button> </a> </div>
            <div class="three"> <a href="#"> <button class="btn-primary btn-sm rounded one"> About </button> </a> </div>
            <div> <a href="contact.php"> <button class="btn-primary btn-sm rounded one"> Contact </button> </a> </div>
            <div> <a href="#"> <button class="btn-primary btn-sm rounded one"> Terms </button> </a> </div>

            <div class="col-12 text-center">
              <h1 class="site-logo ten"> <a href="index.php"> EXPRESSO </a> </h1>
              <?php if( !isset($_SESSION["user"]) ) echo("<h3> express your thoughts in your own style <h3>"); ?>
            </div>
          </div>
        </div>
        
        <nav class="navbar navbar-expand-md navbar-light bg-light">
          <div class="container">
            <div class="collapse navbar-collapse" id="navbarMenu">
              <ul class="navbar-nav mx-auto">
                <?php
                      $sql = "SELECT * FROM category";
                      $query = mysqli_query($database, $sql);
                      while( $cresult = mysqli_fetch_assoc($query) ) {
                        $clink = "index.php?cname=".$cresult['cname']; ?>
                        <li class="nav-item"> <a class="nav-link" href="<?php echo $clink; ?>"> <?php echo $cresult["cname"]; ?> </a> </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </nav>

      </header>
      <!-- END header -->