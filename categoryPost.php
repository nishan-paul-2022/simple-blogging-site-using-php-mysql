<?php
        $sql = $userid = "";
        if( isset($_GET["category"]) ) {
            $sql = "SELECT * FROM post";
        }
        elseif( isset($_GET["userid"]) ) {
            $userid = $_GET["userid"];
            $sql = "SELECT * FROM post WHERE userid='$userid'";
        } elseif( isset($_GET["c"]) ) {
            $cname = $_GET["c"];
            $sql = "SELECT * FROM post WHERE cname='$cname'";
        } elseif( isset($_GET["t"]) ) {
            $tname = $_GET["t"];
            $sql = "SELECT * FROM ptag WHERE tname='$tname'";
        }
        else {
            $userid = $_SESSION["user"]["id"];
            $sql = "SELECT * FROM post WHERE userid='$userid'";
        }
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
