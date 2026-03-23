<?php include("header.php"); ?>

<?php if( !isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"]["active"]!="c") ) { exit(0); } ?>

<?php include("procedurePost.php"); ?>

<script src="ckeditor/ckeditor.js"></script>

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries element-animate">

      <div class="col-md-12 col-lg-8 main-content">
        <form action="createPost.php" method="post" enctype="multipart/form-data">
            <div class="post-meta">
                <span class="author mr-2"><img src="<?php echo $dimage; ?>" alt="feature" class="mr-2"> <?php echo($_SESSION['user']['username']); ?></span>&bullet;
                <span class="mr-2"> <?php echo date("Y-m-d H:i:s"); ?></span>&bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> 0</span>
            </div>

            <div style="padding:31px;"></div>
            <label for="fifteen"> <img src="images/FEATURE.jpg" title=" SELECT  FEATURED  IMAGE  FOR  YOUR  POST " id="twentysix" class="img-fluid mb-2"> </label>
            <input type="file" name="feature" onChange="preview(this, 2)" id="fifteen" class="four"> <br> <br>
            
            
            <div id="twentyseven"> </div> <br>

            <textarea name="title" class="twentyfive" placeholder="T I T L E"></textarea> <br>

            <textarea name="summary" class="twentyfive" placeholder="Summary of The Blog"></textarea> <br> <br>
            
            <textarea name="blog" style="width:730px;" id="sixteen"></textarea>

            <?php echo $bomb."<br>"; ?>

            <button type="submit" name="publish_blog" class="btn btn-dark rounded"> Publish Blog </button>
        </form>
      </div>
      <!-- END main-content -->

      <div class="col-md-12 col-lg-4 sidebar">
        <?php include("searchBox.php"); ?> <!-- END sidebar-box -->

        <?php include("profile.php"); ?> <!-- END sidebar-box -->
        
        <?php include("popularPost.php"); ?> <!-- END sidebar-box -->
        
        <?php include("tagTrack.php"); ?> <!-- category and tag -->
      </div>
        
    </div>
  </div>
</section>
  
<?php include("footer.php"); ?>