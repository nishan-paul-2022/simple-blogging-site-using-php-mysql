<?php include("header.php"); ?>

    <div class="main">
        <section class="signup">
            <div class="container">
                <?php
                    if( isset($_GET["message"]) && $_GET["message"]=="2" ) {
                        echo("<div class='eleven'> check your email to complete your profile editing </div>");
                        exit(0);
                    }
                    if( !isset($_SESSION["user"]) || (isset($_SESSION["user"]) && $_SESSION["user"]["active"]!="c") ) {
                        exit(0);
                    }
                ?>

                <div class="signup-content">
                    <div class="signup-form">
                        <h3> Edit Profile </h3> <br>
                        <form method="post" class="register-form" id="register-form" action="editProfile.php">
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="old Password"/>
                            </div>

                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="xpassword" id="re_pass" placeholder="new Password"/>
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="new Email"/>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span> agree to the <a href="#" class="term-service">Terms</a></label>
                            </div>

                            <br> <button name="edit" class="btn btn-dark rounded"> edit </button>
                        </form>
                    </div>

                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php include("footer.php"); ?>