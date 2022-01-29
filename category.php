<?php include("header.php"); ?>

<?php if(isset($_SESSION["user"]) && $_SESSION['user']["active"]=="a" ) { exit(0); } ?>

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries">

      <div class="col-md-12 col-lg-8 main-content">
          <?php if( isset($_GET["category"]) ) echo "<h2 class='row col'> Latest Blogs </h2>";
                elseif( isset($_GET["c"]) ) echo "<h2 class='row col'> Category : ".$_GET["c"]."</h2>";
                elseif( isset($_GET["t"]) ) echo "<h2 class='row col'> Category : ".$_GET["t"]."</h2>"; ?>

          <div style="padding-bottom:20px;"></div>
          <div class="row mb-5 mt-5"> <?php include("categoryPost.php"); ?> </div>
      </div>
      <!-- END main-content -->

      <div class="col-md-12 col-lg-4 sidebar">
        <?php include("searchBox.php"); ?> <!-- END sidebar box -->

        <?php include("profile.php"); ?> <!-- END sidebar box -->
        
        <?php include("popularPost.php"); ?> <!-- END sidebar box -->
        
        <?php include("tag.php"); ?> <!-- END sidebar box -->
      </div>
      <!-- END sidebar -->

    </div>
  </div>
</section>
  
<?php include("footer.php"); ?>