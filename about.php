<?php include("header.php"); ?>

<?php if( isset($_SESSION["user"]) && $_SESSION["user"]["active"]=="a" ) { exit(0); } ?>

<?php $autobio = isset($_GET["userid"])==true? byID( $_GET["userid"], "user" ) : $_SESSION["user"]; ?>

<?php include("procedure.php"); ?>

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries">
      
      <div class="col-md-12 col-lg-8 main-content">
        
        <div class="row">
          <div class="col-md-12">
            <h2 class="mb-4">Hi There! I'm <?php echo( $autobio["name"] ); ?> </h2>
            <div style="padding:25px;"></div>
            <div class="five">
                <?php include("bio.php"); ?>
                <?php if( $autobio["id"]==$_SESSION["user"]["id"] && $_SESSION["user"]["active"]=="c" ) echo "<button onclick='insert()' class='btn-primary btn-sm rounded'> Update Profile </button>"; ?>
            </div>
          </div>
        </div>
        <br>

        <div class="row mb-5 mt-5">
          <div class="col-md-12 mb-5"> <h2> My Blogs </h2> </div>
          <?php include("categoryPost.php"); ?>
        </div>

      </div>
      <!-- END main-content -->

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