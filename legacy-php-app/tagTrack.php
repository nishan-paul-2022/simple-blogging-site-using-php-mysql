<div class="sidebar-box">
    <h3 class="heading">Categories</h3>
    <ul class="categories">
        <?php
                $sql = "SELECT * FROM category";
                $query = mysqli_query($database, $sql);
                while( $result = mysqli_fetch_assoc($query) ) { ?>
                    <div onclick="TrackC(this)" id="<?php echo $result['cname']; ?>" value="0" class="category" style="height:40px; padding:10px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer; background-color:black;"> <?php echo $result["cname"]; ?> </div>
        <?php   } ?>
    </ul>
</div>
<!-- END sidebar category box -->

<div class="sidebar-box">
    <h3 class="heading">Tags</h3>
    <ul class="tags">
        <?php
                $sql = "SELECT * FROM tag";
                $query = mysqli_query($database, $sql);
                while( $result = mysqli_fetch_assoc($query) ) { ?>
                    <div onclick="TrackT(this)" id="<?php echo $result['tname']; ?>" value="0" class="category" style="height:30px; padding:6px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer;"> <?php echo $result['tname']; ?> </div>
        <?php   } ?>
    </ul>
</div>
<!-- END sidebar tag box -->