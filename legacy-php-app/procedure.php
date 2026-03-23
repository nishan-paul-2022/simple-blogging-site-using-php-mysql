<?php
    function update($column, $value) {
        if( !empty($value) ) {
            global $database;
            $id = $_SESSION["user"]["id"];
            $sql = "UPDATE user SET $column='$value' WHERE id='$id'";
            mysqli_query($database, $sql);
        }
    }

    function upload($bob, $no, $PP) {
      if( !empty( $PP["tmp_name"][$no][0] ) ) {
        $extension = strtolower( pathinfo( $PP["name"][$no][0], PATHINFO_EXTENSION ) );
        $temporary = $PP["tmp_name"][$no][0];
        $target = "user/".$_SESSION["user"]["username"]."/".$bob.".".$extension;

        move_uploaded_file($temporary, $target);
      }
    }

    function grab($pattern, $value, &$c1, &$c2) {
        $container = explode( $pattern, $value );
        $c1 = isset($container[0])? esc( $container[0] ) : $c1;
        $c2 = isset($container[1])? esc( $container[1] ) : $c2;
    }

    if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["update"]) ) {
        $bio = $profession = $skill = $hobby = $school = $college = $university = $bschool = $bcollege = $buniversity = $country = $city = $birth = $gender = "";

        $bio = esc( $_POST["bio"] );
        $profession = esc( $_POST["profession"] );
        $skill = esc( $_POST["skill"] );
        $hobby = esc( $_POST["hobby"] );
        grab( "/", $_POST["school"], $school, $bschool );
        grab( "/", $_POST["college"], $college, $bcollege );
        grab( "/", $_POST["university"], $university, $buniversity );
        grab( ",", $_POST["country"], $city, $country );
        $birth = $_POST["birth"];
        $gender = esc( $_POST["gender"] );

        update("bio", $bio);
        update("profession", $profession);
        update("skill", $skill);
        update("hobby", $hobby);
        update("school", $school);
        update("college", $college);
        update("university", $university);
        update("bschool", $bschool);
        update("bcollege", $bcollege);
        update("buniversity", $buniversity);
        update("country", $country);
        update("city", $city);
        update("birth", $birth);
        update("gender", $gender);

        upload("DP", 0, $_FILES["picture"]);
        upload("COVER", 1, $_FILES["picture"]);
    }
?>