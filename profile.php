<?php if( !isset($_SESSION) ) exit(0); ?>

<?php if( !isset($_SESSION['user']) ) { ?>

        <div class="sidebar-box">
            <div class="bio text-center">
                <img src="images/DP.jpg" alt="dp" class="img-fluid">

                <div class="bio-body">
                    <a href="registration/signup.php" class="nine"> REGISTER </a> / <a href="registration/signin.php" class="nine"> LOGIN </a> TO CREATE OR EXPLORE YOUR OWN PROFILE
                </div>
            </div>
        </div>

<?php } elseif( $_SESSION['user']["active"]=="b" ) { ?>
        <div class="sidebar-box">
            <div class="bio text-center">
                <img src="<?php echo "user/".$_SESSION["user"]["username"]."/DP.jpg"; ?>" alt="dp" class="img-fluid">

                <div class="bio-body">
                    <a href="about.php">
                        <h2> <?php echo($_SESSION["user"]["username"]); ?> </h2>
                        <p class="twentyone"> <?php echo($_SESSION["user"]["email"]); ?> </p>
                    </a>
                    <br>
                    sorry, your ID is temporarily banned due to direct violation of our community
                </div>
            </div>
        </div>

<?php } elseif( $_SESSION['user']["active"]=="c" ) { ?>
        <div class="sidebar-box">
            <div class="bio text-center">
                <img src="<?php echo "user/".$_SESSION["user"]["username"]."/DP.jpg"; ?>" alt="dp" class="img-fluid">

                <div class="bio-body">
                    <a href="about.php">
                        <h2> <?php echo($_SESSION["user"]["username"]); ?> </h2>
                        <p class="twentyone"> <?php echo($_SESSION["user"]["email"]); ?> <br> </p>
                    </a>
                    <br>
                    
                    <a href="registration/editProfile.php"> <button class="btn-primary btn-sm rounded"> Edit Profile </button> </a>
                    <a href="createPost.php"> <button class="btn-primary btn-sm rounded"> Create Post </button> </a>

                    <p class="social"> <br>
                        <a href="https://www.facebook.com/" target="_blank" class="p-2"><span class="fa fa-facebook"></span></a>
                        <a href="https://twitter.com/" target="_blank" class="p-2"><span class="fa fa-twitter"></span></a>
                        <a href="https://www.instagram.com/" target="_blank" class="p-2"><span class="fa fa-instagram"></span></a>
                        <a href="https://www.youtube.com/" target="_blank" class="p-2"><span class="fa fa-youtube-play"></span></a>
                    </p>
                </div>
            </div>
        </div>

<?php } else { } ?>