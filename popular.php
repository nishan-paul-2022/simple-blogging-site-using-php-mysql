<?php   echo "<div class='col-md-12 col-lg-8 main-content thirty'>"; ?>
<?php   echo "<div class='row col'> <h2 class='mb-4'>Popular Blogs</h2> </div>"; ?>
<?php   echo "<div class='row mb-5 mt-5'>"; ?>
<?php   $popularPost = sortPopular();

        foreach($popularPost as $index=>$value) {
            $presult = $value[0];
            $ncomments = $value[1];
            $link = "blog-single.php?postid=".$presult['postid'];
            $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg";
            $pdimage = "user/".$presult['username']."/DP.jpg"; ?>            

            <div class="col-md-6">
                <a href="<?php echo $link; ?>" class="blog-entry element-animate" data-animate-effect="fadeIn">
                    <img src="<?php echo $fimage; ?>" alt="feature image">
                    <div class="blog-content-body">
                        <div class="post-meta">
                            <span class="author mr-2"><img src="<?php echo $pdimage; ?>" alt="dp"> <?php echo $presult["username"]; ?></span>&bullet;
                            
                            <span class="mr-2"><?php echo $presult["ptime"]; ?></span>&bullet;

                            <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
                        </div>

                        <h2> <?php echo $presult["title"]; ?> </h2>
                        
                        <p style="height:70px;"><?php echo $presult["summary"]; ?></p>
                    </div>
                </a>
            </div>
<?php   } ?>
<?php   echo "</div>"; ?>
<?php   echo "</div>"; ?>
