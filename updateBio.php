<?php include("connection.php"); ?>

<?php if( !isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"]["active"]!="c") ) exit(0); ?>

<?php $autobio = byID( $_SESSION["user"]["id"], "user" ); ?>

<form action="about.php" method="post" enctype="multipart/form-data">
    <div class="sidebar-box">
        <div class="bio text-center">
            <label for="five">
                <img src="<?php echo $dimage; ?>" alt="dp" id="seven" class="img-fluid">
            </label>
            <input type="hidden" name="track[]" value="0">
            <input type="file" id="five" name="picture[0][]" onChange="preview(this, 0)" class="four">
        </div>
    </div>

    <label for="six">
        <p class="mb-5"><img src="<?php echo $cimage; ?>" alt="cover" id="eight" class="img-fluid"></p>
    </label>
    <input type="hidden" name="track[]" value="1">
    <input type="file" id="six" name="picture[1][]" onChange="preview(this, 1)" class="four">

    <p>
        <label> BIO </label>
        <textarea class="twelve" name="bio"><?php if(!empty($autobio["bio"])) echo $autobio["bio"]; ?></textarea>
    </p>

    <p>
        <label> PROFESSION </label>
        <textarea class="twelve" name="profession"><?php if(!empty($autobio["profession"])) echo $autobio["profession"]; ?></textarea>
    </p>

    <p>
        <label> SKILL </label>
        <textarea class="twelve" name="skill"><?php if(!empty($autobio["skill"])) echo $autobio["skill"]; ?></textarea>
    </p>

    <p>
        <label> HOBBY </label>
        <textarea class="twelve" name="hobby"><?php if(!empty($autobio["hobby"])) echo $autobio["hobby"]; ?></textarea>
    </p>

    <p>
        <label> EDUCATION </label>
        <div>
            <textarea class="thirteen" placeholder="school / background" name="school"><?php if(!empty($autobio["school"]) && !empty($autobio["bschool"])) echo $autobio["school"]." / ".$autobio["bschool"]; ?></textarea> <br>
            <textarea class="thirteen" placeholder="college / background" name="college"><?php if(!empty($autobio["college"]) && !empty($autobio["bcollege"])) echo $autobio["college"]." / ".$autobio["bcollege"]; ?></textarea> <br>
            <textarea class="thirteen" placeholder="university / department" name="university"><?php if(!empty($autobio["university"]) && !empty($autobio["buniversity"])) echo $autobio["university"]." / ".$autobio["buniversity"]; ?></textarea> <br>
        </div>
    </p>

    <p>
        <label> LOCATION </label>
        <div>
            <textarea class="thirteen" placeholder="city, country" name="country"><?php if(!empty($autobio["city"]) && !empty($autobio["country"])) echo $autobio["city"].", ".$autobio["country"]; ?></textarea>
        </div>
    </p>

    <p>
        <div class="twentythree">
            DATE OF BIRTH
            <input onfocusin="this.type='date'" onfocusout="this.type='text'" class="fourteen" name="birth" placeholder='<?php if(!empty($autobio["birth"])) echo $autobio["birth"]; ?>'>
        </div>

        <div class="twentyfour">
            GENDER
            <select id="twentytwo" class="fourteen" name="gender"> 
                <option value="others"> others </option> 
                <option value="male"> male </option> 
                <option value="female"> female </option>
            </select>

            <script> $('#twentytwo').val( "<?php echo $autobio["gender"]; ?>" ).change(); </script>
        </div>
    </p>

    <button name="update" class="btn btn-dark rounded"> update </button>
</form>