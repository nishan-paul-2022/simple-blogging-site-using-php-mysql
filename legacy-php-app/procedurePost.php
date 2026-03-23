<?php
    function W() {
        $flag = false;
  
        global $database;
        $sql = "SELECT * FROM category";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
          $cname = $result["cname"];
          if( isset($_POST[$cname]) && $_POST[$cname]==1 )
            $flag = true;
        }
  
        $flag = ( $flag && !empty($_POST["title"]) && !empty($_POST["summary"]) && !empty($_POST["blog"]) );
        return $flag;
    }

    function cnode($table, $key) {
        global $database;
        $bomb = "";
        $sql = "SELECT * FROM $table";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
          $bomb .= "<input type='hidden' name=".$result[$key]." value='0'>";
        }
        return $bomb;
    }

    function cnodeO($table, $key, $result) {
        global $database;
        $bomb = "";
        $sql = "SELECT * FROM $table";
        $query = mysqli_query($database, $sql);
        while( $kresult = mysqli_fetch_assoc($query) ) {
            if( $result[$key]==$kresult[$key] )
                $bomb .= "<input type='hidden' name=".$kresult[$key]." value='1'>";
            else
                $bomb .= "<input type='hidden' name=".$kresult[$key]." value='0'>";
        }
        return $bomb;
    }

    function Pupdate($postid) {
        global $database;
        $sql = "SELECT * FROM category";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
            $cname = $result["cname"];
            $cid = $result["cid"];
            if( isset($_POST[$cname]) && $_POST[$cname]==1  ) {
                $sqlC = "UPDATE post SET cid='$cid', cname='$cname' WHERE postid='$postid'";
                mysqli_query($database, $sqlC);
            }
        }
    }

    function Tupdate($postid) {
        global $database;
        $sql = "SELECT * FROM tag";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
            $tname = $result["tname"];
            $tid = $result["tid"];
            if( isset($_POST[$tname]) && $_POST[$tname]==1  ) {
                $sqlT = "UPDATE ptag SET tid='$tid', tname='$tname' WHERE postid='$postid'";
                mysqli_query($database, $sqlT);
            }
        }
    }

    function Tinsert($postid) {
        $yes = false;

        global $database;
        $sql = "SELECT * FROM post WHERE postid='$postid'";
        $query = mysqli_query($database, $sql);
        $presult = mysqli_fetch_assoc($query);

        $userid = $_SESSION["user"]["id"];
        $username = $_SESSION["user"]["username"];
        $useremail = $_SESSION["user"]["email"];
        $title = esc( $presult["title"] );
        $summary = esc( $presult["summary"] );
        $blog = esc( $presult["blog"] );
        $etime = $presult["ptime"];

        mysqli_query($database, "DELETE FROM ptag WHERE postid='$postid'");

        $sql = "SELECT * FROM tag";
        $query = mysqli_query($database, $sql);
        while( $result = mysqli_fetch_assoc($query) ) {
            $tname = $result["tname"];
            $tid = $result["tid"];
            if( isset($_POST[$tname]) && $_POST[$tname]==1  ) {
                $sqlT = "INSERT INTO ptag( tid, tname, postid, userid, username, useremail, title, summary, blog, etime ) VALUES( '$tid', '$tname', '$postid', '$userid', '$username', '$useremail', '$title', '$summary', '$blog', '$etime' )";
                mysqli_query($database, $sqlT);
                $yes = true;
            }
        }
    }

    function uploadO($postid, $PP) {
        if( !empty( $PP["tmp_name"] ) ) {
          $extension = strtolower( pathinfo( $PP["name"], PATHINFO_EXTENSION ) );
          $target = "user/".$_SESSION["user"]["username"]."/F".$postid.".".$extension;
          $temporary = $PP["tmp_name"];
          move_uploaded_file($temporary, $target);
        } else {
          $temporary = "images/FEATURE.jpg";
          $target = "user/".$_SESSION["user"]["username"]."/F".$postid.".jpg";
          copy($temporary, $target);
        }
    }  

    function updateO($postid, $column, $value) {
        if( !empty($value) ) {
            global $database;
            $sql = "UPDATE post SET $column='$value' WHERE postid='$postid'";
            mysqli_query($database, $sql);
        }
    }

    $bomb  = cnode("category", "cname") . cnode("tag", "tname");

    if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["publish_blog"]) && W()==true ) {

      $userid = $_SESSION["user"]["id"];
      $username = $_SESSION["user"]["username"];
      $useremail = $_SESSION["user"]["email"];
      $title = esc( $_POST["title"] );
      $summary = esc( $_POST["summary"] );
      $blog = esc( $_POST["blog"] );
      $ptime = date("Y-m-d H:i:s");
      $etime = date("Y-m-d H:i:s");

      $sql = "INSERT INTO post( userid, username, useremail, title, summary, blog, ptime, etime ) VALUES( '$userid', '$username', '$useremail', '$title', '$summary', '$blog', '$ptime', '$etime' )";
      mysqli_query($database, $sql);
      $postid = mysqli_insert_id($database);

      $sql = "INSERT INTO ptag( postid, userid, username, useremail, title, summary, blog, ptime, etime ) VALUES( '$postid', '$userid', '$username', '$useremail', '$title', '$summary', '$blog', '$ptime', '$etime' )";
      mysqli_query($database, $sql);

      Pupdate($postid);

      Tupdate($postid);

      uploadO( $postid, $_FILES["feature"] );
    }

    if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["edit_blog"]) ) {

        $postid = $_GET["postid"];

        $title = esc( $_POST["title"] );
        $summary = esc( $_POST["summary"] );
        $blog = esc( $_POST["blog"] );
        $etime = date("Y-m-d H:i:s");

        updateO($postid, "title", $title);
        updateO($postid, "summary", $summary);
        updateO($postid, "blog", $blog);
        updateO($postid, "etime", $etime);
        uploadO($postid, $_FILES["feature"] );
    
        Pupdate($postid);

        Tinsert($postid);
    }
?>