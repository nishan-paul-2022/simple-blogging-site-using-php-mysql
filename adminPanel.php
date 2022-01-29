<?php include("header.php") ?>

<?php if(isset($_SESSION["user"]) && $_SESSION['user']["active"]=="a" ) { exit(0); } ?>


<?php include("selectedPost.php"); ?> <!-- END section -->

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries">

      <div class="col-md-12 col-lg-8 main-content">            
            <div class="row mb-5 mt-5">
                <?php   $sql = "SELECT * FROM post";
                        $query = mysqli_query($database, $sql);
                        while( $presult = mysqli_fetch_assoc($query) ) {
                            $ncomments = countC( $presult['postid'] );
                            $link = "blog-single.php?postid=".$presult['postid'];
                            $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg";
                            $pdimage = "user/".$presult['username']."/DP.jpg"; ?>
                            <div class="col-md-12">
                                <div class="post-entry-horzontal">
                                    <a href="<?php echo $link; ?>">
                                        <div class="image" style="background-image: url(<?php echo $fimage; ?>);"></div>
                                        <span class="text" style="width:730px;">
                                            <div class="post-meta">
                                                <span class="author mr-2"><img src="<?php echo $pdimage; ?>" alt="dp"> <?php echo $presult["username"]; ?></span>&bullet;
                                                <span class="mr-2"><?php echo $presult["ptime"]; ?></span>&bullet;
                                                <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
                                            </div>
                                            <h2><?php echo $presult["title"]; ?></h2>
                                        </span>
                                    </a>
                                </div>
                            </div>
                <?php   } ?>
            </div>

            <div class="sidebar-box">
                <a href="category.php?category=1"> <h3 class="heading">Categories</h3> </a>
                <ul class="categories">
                    <?php   $sql = "SELECT * FROM category";
                            $query = mysqli_query($database, $sql);
                            while( $cresult = mysqli_fetch_assoc($query) ) {
                                $cid = $cresult["cid"];
                                $cname = $cresult["cname"];
                                $npostsC = mysqli_num_rows( mysqli_query($database, "SELECT * FROM post WHERE cname='$cname'") );
                                $clink = "category.php?c=".$cname; ?>
                                <a href="<?php echo $clink; ?>"> <div class="category" style="height:40px; padding:10px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer; background-color:black;"> <?php echo $cname; ?> (<?php echo $npostsC; ?>)</div> </a>
                    <?php   } ?>
                </ul>
            </div>
            <!-- END sidebar category box -->

            <div class="sidebar-box">
                <a href="category.php?category=1"> <h3 class="heading">Tags</h3> </a>
                <ul class="tags">
                    <?php   $sql = "SELECT * FROM tag";
                            $query = mysqli_query($database, $sql);
                            while( $tresult = mysqli_fetch_assoc($query) ) {
                                $tid = $tresult["tid"];
                                $tname = $tresult["tname"];
                                $npostsT = mysqli_num_rows( mysqli_query($database, "SELECT * FROM ptag WHERE tname='$tname'") );
                                $tlink = "category.php?t=".$tname; ?>
                                <a href="<?php echo $tlink; ?>"> <div class="category" style="height:30px; padding:6px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer;"> <?php echo $tname; ?> (<?php echo $npostsT; ?>)</div> </a>
                    <?php   } ?>
                </ul>
            </div>
            <!-- END sidebar tag box -->

            <?php   $sql = "SELECT * FROM user";
                    $query = mysqli_query($database, $sql);
                    while( $result = mysqli_fetch_assoc($query) ) { ?>
                        <div class="sidebar-box">
                            <div class="bio text-center">
                                <img src="<?php echo $pdimage; ?>" alt="dp" class="img-fluid">
                                <div class="bio-body">
                                    <h2><?php echo $result["username"]; ?></h2>
                                    <p><?php echo $result["email"]; ?></p>
                                    <p> <a href="about.php?userid=<?php echo $result['userid']; ?>"> <button class="btn-primary btn-sm rounded"> read my bio </button> </a> </p>
                                </div>
                            </div>
                        </div>
            <?php   } ?>
      </div>
      <!-- END main-content -->

    </div>
  </div>
</section>
    
<?php include("footer.php"); ?>