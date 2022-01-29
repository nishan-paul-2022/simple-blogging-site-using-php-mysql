<?php include("header.php") ?>

<?php if(isset($_SESSION["user"]) && $_SESSION['user']["active"]=="a" ) { exit(0); } ?>

<?php include("selectedPost.php"); ?> <!-- END section -->

<section class="site-section py-sm">
  <div class="container">
    <div class="row blog-entries">

      <?php if( isset($_GET["popular"]) ) include("popular.php"); else include("latestPost.php"); ?> <!-- END main-content -->

      <div class="col-md-12 col-lg-4 sidebar">
        <?php include("searchBox.php"); ?> <!-- END sidebar box -->

        <?php include("profile.php"); ?> <!-- END sidebar box -->
        
        <?php include("popularPost.php"); ?> <!-- END sidebar box -->
        
        <?php include("tag.php") ?> <!-- END sidebar box -->
      </div>
      <!-- END sidebar -->
        
    </div>
  </div>
</section>
    
<?php include("footer.php"); ?>