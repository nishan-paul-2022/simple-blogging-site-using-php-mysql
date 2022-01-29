<?php if( !isset($_SESSION) ) exit(0); ?>

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