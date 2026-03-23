<?php if( !isset($_SESSION) || (isset($_SESSION["user"]) && $_SESSION["user"]["active"]=="a") ) exit(0); ?>

<?php $autobio = isset($_GET["userid"])==true? byID( $_GET["userid"], "user" ) : byID( $_SESSION["user"]["id"], "user" ); ?>
<?php $adimage = "user/".$autobio["username"]."/DP.jpg"; ?>
<?php $acimage = "user/".$autobio["username"]."/COVER.jpg"; ?>

<div class="sidebar-box">
    <div class="bio text-center">
        <label>
            <img src="<?php echo $adimage; ?>" alt="dp" class="img-fluid">
        </label>
    </div>
</div>

<label>
    <p class="mb-5"> <img src="<?php echo $acimage; ?>" alt="cover" class="img-fluid"> </p>
</label>

<div>
    <label> BIO </label>
    <div class="seventeen"> <?php if(!empty($autobio["bio"])) echo $autobio["bio"]; ?> </div>
</div>
<br>

<div>
    <label> PROFESSION </label>
    <div class="seventeen"> <?php if(!empty($autobio["profession"])) echo $autobio["profession"]; ?> </div>
</div>
<br>

<div>
    <label> SKILL </label>
    <div class="seventeen"> <?php if(!empty($autobio["skill"])) echo $autobio["skill"]; ?> </div>
</div>
<br>

<div>
    <label> HOBBY </label>
    <div class="seventeen"> <?php if(!empty($autobio["hobby"])) echo $autobio["hobby"]; ?> </div>
</div>
<br>

<div>
    <label> EDUCATION </label>
    <div>
        <div placeholder="school / background" class="eighteen"> <?php if(!empty($autobio["school"]) && !empty($autobio["bschool"])) echo $autobio["school"]." / ".$autobio["bschool"]; ?> </div>
        <div placeholder="college / background" class="eighteen"> <?php if(!empty($autobio["college"]) && !empty($autobio["bcollege"])) echo $autobio["college"]." / ".$autobio["bcollege"]; ?> </div>
        <div placeholder="university / department" class="eighteen"> <?php if(!empty($autobio["university"]) && !empty($autobio["buniversity"])) echo $autobio["university"]." / ".$autobio["buniversity"]; ?> </div>
    </div>
</div>
<br>

<div>
    <label> LOCATION </label>
    <div placeholder="city, country" class="eighteen"> <?php if(!empty($autobio["city"]) && !empty($autobio["country"])) echo $autobio["city"].", ".$autobio["country"]; ?> </div>
</div>
<br>

<div>
    <label> DATE OF BIRTH </label>
    <div class="nineteen"> <?php if(!empty($autobio["birth"])) echo $autobio["birth"]; ?> </div>

    <label> GENDER </label>
    <div class="twenty"> <?php if(!empty($autobio["gender"])) echo $autobio["gender"]; ?> </div> 
</div>
<br>