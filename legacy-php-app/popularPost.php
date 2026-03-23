<div class="sidebar-box">
    <a href="index.php?popular=1"> <h3 class="heading">Popular Blogs</h3> </a>
    <div class="post-entry-sidebar">
    <ul>
<?php   $n = 0;
        $popularPost = sortPopular();
        foreach($popularPost as $index=>$value) {
            if($n<3) {
                $n++ ;
                $presult = $value[0];
                $ncomments = $value[1];
                $link = "blog-single.php?postid=".$presult['postid'];
                $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg"; ?>
                <li>
                    <a href="<?php echo $link; ?>">
                        <img src="<?php echo $fimage; ?>" alt="feature" class="mr-4">
                        <div class="text">
                            <h4><?php echo $presult["title"]; ?></h4>
                            <div class="post-meta">
                                <span class="mr-2"><?php echo date("Y-m-d", strtotime($presult["ptime"])); ?></span>&bullet;
                                <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
                            </div>
                        </div>
                    </a>
                </li>
<?php       } ?>
<?php   } ?>
    </ul>
    </div>
</div>
