<div class="col-md-7">
    <h3>Latest Blogs</h3>
    <div class="post-entry-sidebar">
        <ul>
<?php   $sql = "SELECT * FROM post";
        $query = mysqli_query($database, $sql);
        $n = 0;
        while( ($presult = mysqli_fetch_assoc($query)) && $n<3 ) {
            $ncomments = countC( $presult['postid'] );
            $link = "blog-single.php?postid=".$presult['postid'];
            $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg";
            $n++; ?>
            <li>
                <a href="<?php echo $link; ?>">
                    <img src="<?php echo $fimage; ?>" alt="Image placeholder" class="mr-4">
                    <div class="text">
                        <h4><?php echo $presult["title"]; ?></h4>
                        <div class="post-meta">
                            <span class="mr-2"><?php echo $presult["ptime"]; ?></span>
                            <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
                        </div>
                    </div>
                </a>
            </li>
<?php   } ?>
        </ul>
    </div>
</div>
