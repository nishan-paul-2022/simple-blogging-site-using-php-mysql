<script>
    $check = 0;
    var Tnode = document.getElementById("twentyeight");

    function FilterR(e, flag) {
        if( !flag ) check = 0;
        var f = e.innerHTML.trim();
        document.getElementById(f).setAttribute("value", 0);
        document.querySelector("input[name="+f+"]").setAttribute("value", 0);
        e.parenNode.removeChild(e);
    }

    function FilterC(e) {
        var f = e.innerHTML.trim().split(' ')[0];
        if( document.getElementById(f).getAttribute("value")=="0" ) {                
            node = "<span onclick='R(this,0)' class='category' style='height:30px; padding:6px; margin-bottom: 5px; text-align:center; cursor: pointer; background-color:black;'>" + f + "</span>";
            document.getElementById(f).setAttribute("value", 1);
            document.querySelector("input[name="+f+"]").setAttribute("value", 1);
            if( check )
                Tnode.innerHTML += node;
            else
                Tnode.innerHTML = node, check = 1;
        }
    }

    function FilterT(e) {
        var f = e.innerHTML.trim().split(' ')[0];
        if( document.getElementById(f).getAttribute("value")=="0" ) {
            var node = "<span onclick='R(this,1)' class='category' style='height:30px; padding:6px; margin-bottom: 5px; text-align:center; cursor: pointer;'>" + f + "</span>";
            document.getElementById(f).setAttribute("value", 1);
            document.querySelector("input[name="+f+"]").setAttribute("value", 1);
            if( check )
                Tnode.innerHTML += node;
            else
                Tnode.innerHTML = node, check = 1;
        }
    }
</script>
<div class="sidebar-box">
    <a href="category.php?category=1"> <h3 class="heading">Categories</h3> </a>
    <ul class="categories">
        <?php   $sql = "SELECT * FROM category";
                $query = mysqli_query($database, $sql);
                while( $cresult = mysqli_fetch_assoc($query) ) {
                    $cname = $cresult["cname"];
                    $npostsC = mysqli_num_rows( mysqli_query($database, "SELECT * FROM post WHERE cname='$cname'") ); ?>
                    <div onclick="FilterC(this)" id="<?php echo $cname; ?>" value="0" class="category" style="height:40px; padding:10px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer; background-color:black;"> <?php echo $cname; ?> (<?php echo $npostsC; ?>)</div>
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
                    $tname = $tresult["tname"];
                    $npostsT = mysqli_num_rows( mysqli_query($database, "SELECT * FROM ptag WHERE tname='$tname'") ); ?>
                    <div onclick="FilterT(this)" id="<?php echo $tname; ?>" value="0" class="category" style="height:30px; padding:6px; margin-right:0px; margin-bottom:5px; text-align:center; cursor: pointer;"> <?php echo $tname; ?> (<?php echo $npostsT; ?>)</div>
        <?php   } ?>
    </ul>
</div>
<!-- END sidebar tag box -->