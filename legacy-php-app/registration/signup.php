<?php include("header.php"); ?>

<?php include("phpEmail/vendor/autoload.php"); ?>
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php use PHPMailer\PHPMailer\Exception; ?>

    <div class="main">
        <section class="signup">
            <div class="container">
                <?php
                    if( isset($_GET["message"]) && $_GET["message"]=="1" ) {
                        echo("<div class='eleven'> check your email to complete your registration </div>");
                        exit(0);
                    }
                    if( isset($_SESSION["user"]) ) { exit(0); }
                ?>
                <div class="signup-content">
                    <div class="signup-form">
                        <h3> Register Profile </h3> <br>
                        <form method="post" class="register-form" id="register-form" action="signup.php">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="your_name" placeholder="Your Username"/>
                            </div>

                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Your Password"/>
                            </div>

                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="xpassword" id="re_pass" placeholder="Confirm Your Password"/>
                            </div>

                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>

                            <div class="form-group">
                                <input type="checkbox" name="agree-term" id="agree-term" class="agree-term" />
                                <label for="agree-term" class="label-agree-term"><span><span></span></span> agree to the <a href="#" class="term-service">Terms</a></label>
                            </div>

                            <button name="signup" class="btn btn-dark rounded"> register </button>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="signin.php" class="signup-image-link"> already have an account ? </a>
                    </div>
                </div>
            </div>
        </section>
    </div>

<?php include("footer.php"); ?>