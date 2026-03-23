<?php include("header.php") ?>

<?php if( !isset($_GET["postid"]) ) exit(0); ?>

<?php $postid = $_GET["postid"];

      $ncomments = countC($postid);

      $link = "blog-single.php?postid=".$postid;

      $sql = "SELECT * FROM post WHERE postid='$postid'";
      $query = mysqli_query($database, $sql);
      $presult = mysqli_fetch_assoc($query);

      $fimage = "user/".$presult['username']."/F".$presult['postid'].".jpg";
      $pdimage = "user/".$presult['username']."/DP.jpg";

      $cand = "<span class='category' style='background-color:black; cursor: pointer;'>".$presult['cname']."</span>";
      $sql = "SELECT * FROM ptag WHERE postid='$postid'";
      $query = mysqli_query($database, $sql);
      while( $tresult = mysqli_fetch_assoc($query) ) {
        $cand .= "<span class='category' style='cursor: pointer;'>".$tresult['tname']."</span>";
      }

      if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["post_comment"]) ) {
          $userid = $_SESSION["user"]["id"];
          $username = $_SESSION["user"]["username"];
          $note = esc( $_POST["note"] );
          $ntime = date("Y-m-d H:i:s");

          $sql = "INSERT INTO comment(postid, userid, username, note, ntime) VALUES('$postid', '$userid', '$username', '$note', '$ntime')";
          mysqli_query($database, $sql);
      }

      $sql = "SELECT * FROM comment WHERE postid='$postid'";
      $cquery = mysqli_query($database, $sql);
?>

<section class="site-section pt-5">
  <div class="container">
    <div class="row blog-entries element-animate">

      <div class="col-md-12 col-lg-8 main-content">
          <img src="<?php echo $fimage; ?>" alt="feature image" class="img-fluid mb-5">

          <div class="post-meta">
              <span class="author mr-2"><img src="<?php echo $pdimage; ?>" alt="dp" class="mr-2"> <?php echo $presult["username"]; ?></span>&bullet;
              <span class="mr-2"><?php echo $presult["ptime"]; ?></span>&bullet;
              <span class="ml-2"><span class="fa fa-comments"></span> <?php echo $ncomments; ?></span>
              <?php $elink = "editPost.php?postid=".$postid; ?>
              <a href="<?php echo $elink; ?>"> <span class='btn-dark btn-sm' style='float:right; color: white;'> Edit Blog </span> </a>
          </div>

          <h1 class="mb-4"><?php echo $presult["title"]; ?></h1>

          <div id="thirty"> <?php echo $cand; ?> </div> <br> <br>
                    
          <div class="twentynine"> <?php echo( html_entity_decode($presult["blog"]) ); ?> </div>
    
          <?php include("commentBox.php"); ?> <!-- END comment-box -->
      </div>
      <!-- END main-content -->

      <div class="col-md-12 col-lg-4 sidebar">
          <?php include("searchBox.php"); ?> <!-- END sidebar-box -->

          <?php if( isset($_SESSION["user"]) && $_SESSION["user"]["id"]==$presult["userid"] ) include("profile.php"); else include("userProfile.php"); ?>  <!-- END sidebar-box -->
          
          <?php include("popularPost.php"); ?> <!-- END sidebar-box -->
          
          <?php include("tag.php"); ?> <!-- END sidebar-box -->
      </div>
    
    </div>
  </div>
</section>

<?php include("relatedPost.php"); ?> <!-- END section -->

<?php include("footer.php"); ?>