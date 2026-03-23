<?php if( !isset($postid) ) exit(0); ?>

<div class="pt-5">
    <h3 class="mb-5"><?php echo $ncomments; ?> Comments</h3>
    <ul class="comment-list">
        <?php   while( $cresult = mysqli_fetch_assoc($cquery) ) {
                    $cdimage = "user/".$cresult["username"]."/DP.jpg" ?>
                    <li class="comment">
                        <div class="vcard"> <img src="<?php echo $cdimage; ?>" alt="dp"> </div>
                        <div class="comment-body">
                            <h3><?php echo $cresult["username"]; ?></h3>
                            <div class="meta"><?php echo $cresult["ntime"]; ?></div>
                            <p><?php echo $cresult["note"]; ?></p>
                        </div>
                    </li>
        <?php   } ?>
    </ul>
</div>
<!-- END comment-list -->

<?php if(isset($_SESSION["user"])) { ?>
        <div class="comment-form-wrap pt-4">
            <h3 class="mb-2">Leave a comment</h3>
            <form action="<?php echo $link; ?>" method="post">
                <div class="form-group">
                    <textarea name="note" class="form-control" style="width:730px;"></textarea>
                </div>
                <button type="submit" name="post_comment" class="btn btn-dark rounded"> post comment </button>
            </form>
        </div>
        <!-- END comment-form -->
<?php } ?>