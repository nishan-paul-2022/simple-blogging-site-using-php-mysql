<?php include("header.php"); ?>

<?php if( !isset($_SESSION["user"]) || !isset($_GET["postid"]) || (isset($_SESSION["user"]) && $_SESSION["user"]["active"]!="c") ) { exit(0); } ?>

<?php include("procedurePost.php"); ?>

<?php   $postid = $_GET["postid"];
        $ncomments = countC($postid);
        $link = "editPost.php?postid=".$postid;
        
        $sql = "SELECT * FROM post WHERE postid='$postid'";
        $query = mysqli_query($database, $sql);
        $presult = mysqli_fetch_assoc($query);

        $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg";
        $dimage = "user/".$presult['username']."/DP.jpg";

        $candO = "<span onclick='R(this,0)' class='category' style='background-color:black; cursor: pointer;'>".$presult['cname']."</span>";
        $sql = "SELECT * FROM ptag WHERE postid='$postid'";
        $query = mysqli_query($database, $sql);
        while( $tresult = mysqli_fetch_assoc($query) ) {
            $candO .= "<span onclick='R(this,1)' class='category' style='cursor: pointer;'>".$tresult['tname']."</span>";
        }

        $bombO  = cnodeO("category", "cname", $presult) . cnode("tag", "tname", $tresult);
?>

<script src="ckeditor/ckeditor.js"></script>

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries element-animate">

      <div class="col-md-12 col-lg-8 main-content">
        <form action="<?php echo $link; ?>" method="post" enctype="multipart/form-data">
            <div class="post-meta">
                <span class="author mr-2"><img src="<?php echo $dimage; ?>" alt="feature" class="mr-2"> <?php echo $_SESSION['user']['username']; ?></span>&bullet;
                <span class="mr-2"> <?php echo date("Y-m-d H:i:s"); ?></span>&bullet;
                <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
            </div>

            <div style="padding:32px;"></div>
            <label for="fifteen"> <img src="<?php echo $fimage; ?>" title=" SELECT  FEATURED  IMAGE  FOR  YOUR  POST " id="twentysix" class="img-fluid mb-2"> </label>
            <input type="file" name="feature" onChange="preview(this, 2)" id="fifteen" class="four"> <br> <br>
            
            <div id="twentyseven"> <?php echo $candO; ?> </div> <br>

            <textarea name="title" class="twentyfive" placeholder="T I T L E"><?php echo $presult["title"]; ?></textarea> <br>

            <textarea name="summary" class="twentyfive" placeholder="Summary of The Blog"><?php echo $presult["summary"]; ?></textarea> <br> <br>
            
            <textarea name="blog" style="width:730px;" id="sixteen"><?php echo $presult["blog"]; ?></textarea>

            <?php echo $bombO."<br>"; ?>

            <button type="submit" name="edit_blog" class="btn btn-dark rounded"> Edit </button>
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