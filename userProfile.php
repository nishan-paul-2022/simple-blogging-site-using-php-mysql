<?php if( !isset($presult) ) exit(0); ?>

<div class="sidebar-box">
    <div class="bio text-center">
        <img src="<?php echo $pdimage; ?>" alt="dp" class="img-fluid">
        <div class="bio-body">
            <h2><?php echo $presult["username"]; ?></h2>
            <p><?php echo $presult["useremail"]; ?></p>
            <p> <a href="about.php?userid=<?php echo $presult['userid']; ?>"> <button class="btn-primary btn-sm rounded"> read my bio </button> </a> </p>
            <p class="social">
                <a href="https://www.facebook.com/" target="_blank" class="p-2"><span class="fa fa-facebook"></span></a>
                <a href="https://twitter.com/" target="_blank" class="p-2"><span class="fa fa-twitter"></span></a>
                <a href="https://www.instagram.com/" target="_blank" class="p-2"><span class="fa fa-instagram"></span></a>
                <a href="https://www.youtube.com/" target="_blank" class="p-2"><span class="fa fa-youtube-play"></span></a>
            </p>
        </div>
    </div>
</div>