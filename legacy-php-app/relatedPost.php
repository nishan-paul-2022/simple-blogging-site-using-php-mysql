<?php   $postid = $_GET["postid"];
        $sql = "SELECT * FROM post WHERE postid='$postid'";
        $query = mysqli_query($database, $sql);
        $result = mysqli_fetch_assoc($query);
        $cname = $result["cname"];
        $sql = "SELECT * FROM post WHERE cname='$cname'";
        $query = mysqli_query($database, $sql);
        $link = "category.php?c=".$cname; ?>
<section class="py-5">
    <div class="container">
    <a href="<?php echo $link; ?>"><div class="row col-md-12"> <h2 class="mb-3 ">Related Blogs</h2> </div></a>
    <div class="row">
<?php   while( $result = mysqli_fetch_assoc($query) ) {
            $link = "blog-single.php?postid=".$result["postid"];
            $fimage = "user/".$result["username"]."/F".$result["postid"].".jpg";?>
            <div class="col-md-6 col-lg-4">
                <a href="<?php echo $link; ?>" class="a-block sm d-flex align-items-center height-md" style="background-image: url('<?php echo $fimage; ?>'); ">
                    <div class="text">
                        <div class="post-meta">
                            <span class="category"><?php echo $result["cname"]; ?></span>
                            <span class="mr-2"><?php echo date("Y-m-d",strtotime($result["ptime"])); ?></span>
                            <span class="ml-2"><span class="fa fa-comments"></span> <?php echo countC($result["postid"]); ?></span>
                        </div>
                        <h3><?php echo $result["title"]; ?></h3>
                    </div>
                </a>
            </div>
<?php   } ?>
    </div>
    </div>
</section>