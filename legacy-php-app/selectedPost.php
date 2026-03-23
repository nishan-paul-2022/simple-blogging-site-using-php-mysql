<section class="site-section pt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="owl-carousel owl-theme home-slider">
<?php   $sql = "SELECT * FROM post";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
            $link = "blog-single.php?postid=".$result["postid"];
            $fimage = "user/".$result["username"]."/F".$result["postid"].".jpg";
            $pdimage = "user/".$result["username"]."/DP.jpg";
            $ncomments = countC($result["postid"]); ?>
            <div>
                <a href="<?php echo $link; ?>" class="a-block d-flex align-items-center height-lg" style="background-image: url('<?php echo $fimage; ?>');">
                    <div class="text half-to-full">
                        <span class="category mb-5"><?php echo $result["cname"];?></span>
                        <div class="post-meta">
                            <span class="author mr-2"><img src="<?php echo $pdimage; ?>" alt="dp"> <?php echo $result["username"];?></span>&bullet;
                            <span class="mr-2"><?php echo $result["ptime"];?></span>&bullet;
                            <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
                        </div>
                        <h3><?php echo $result["title"];?></h3>
                        <p><?php echo $result["summary"];?></p>
                    </div>
                </a>
            </div>
<?php   } ?>
        </div>
      </div>
    </div>
  </div>
</section>