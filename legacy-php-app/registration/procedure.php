<?php include("phpEmail/vendor/autoload.php"); ?>
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php use PHPMailer\PHPMailer\Exception; ?>

<?php
	function settings() {
		$mail = new PHPMailer(true); // Instantiation and passing `true` enables exceptions
		$mail->isSMTP();
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'np007MLF@gmail.com';
		$mail->Password   = 'math1201';
		$mail->SMTPSecure = 'ssl';
		$mail->Port       = 465;
		$mail->smtpConnect(
			array(
				"ssl" => array(
					"verify_peer" => false,
					"verify_peer_name" => false,
					"allow_self_signed" => true
				)
			)
		);
		$mail->isHTML(true);
		$mail->addReplyTo("np007mlf@gmail.com");
		return $mail;
	}
	
	function sendMail($Body) {
		$mail = settings();

		$from = "np007mlf@gmail.com";
		$to = $_SESSION["user"]["email"];
		$Subject = "Confirmation Email from Expresso";
		
		$mail->setFrom($from);
		$mail->addAddress($to);
		$mail->Subject = $Subject;
		$mail->Body = $Body;
		$mail->send();
	}

	
	function only($value, $no) {
		global $database;
		$sql = "";
		if( $no == 0 )
			$sql = "SELECT * FROM signup WHERE username='$value' LIMIT 1";
		elseif( $no == 1 )
			$sql = "SELECT * FROM signup WHERE email='$value' LIMIT 1";
		elseif( $no == 2 ) {
			$value = md5($value);
			$sql = "SELECT * FROM signup WHERE password='$value' LIMIT 1";
		}
		$query = mysqli_query($database, $sql);
		return mysqli_num_rows($query);
    }

	function T( $iname ) {
		$current = "../images/".$iname;
		$target = "../user/".$_SESSION["user"]["username"]."/".$iname;
		copy( $current , $target );
	}

	if( isset($_SESSION["user"]) && isset($_GET["tag"]) && isset($_GET["id"]) && isset($_GET["code"]) && $_GET["id"]==$_SESSION["user"]["id"] ) {
		if( $_GET["tag"]=="1" && isset($_SESSION["code1"]) && $_SESSION["code1"]==$_GET["code"] ) {
			unset($_SESSION["code1"]);
			
			$id = $_SESSION["user"]["id"];
			$sql = "UPDATE signup SET active='c' WHERE id='$id'";
			$result = mysqli_query($database, $sql);
			$_SESSION["user"] = byID($id, "signup");

			mkdir( "../user/".$_SESSION["user"]["username"] );
            T("DP.jpg");
            T("COVER.jpg");

			header('Location: ../about.php');
		}

		if( $_GET["tag"]=="2" && isset($_SESSION["code2"]) && $_SESSION["code2"]==$_GET["code"] && (empty($_SESSION["nemail"]) || empty($_SESSION["npassword"])) ) {
			$id = $_SESSION['user']['id'];
			$nemail = $_SESSION["nemail"];
			$npassword = $_SESSION["npassword"];

			unset($_SESSION["code2"]);
			unset($_SESSION["nemail"]);
			unset($_SESSION["npassword"]);

			if( !empty($nemail) ) {
				$sql = "UPDATE signup SET email='$nemail' WHERE id='$id'";
				mysqli_query($database, $sql);

				$sql = "UPDATE user SET email='$nemail' WHERE id='$id'";
				mysqli_query($database, $sql);
			}
			if( !empty($npassword) ) {
				$npassword = md5($npassword);
				$sql = "UPDATE signup SET password='$npassword' WHERE id='$id'";
				mysqli_query($database, $sql);
			}

			header('Location: ../about.php');
		}
	}

	if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['signup']) ) {
		$errors = array();

        $name = esc($_POST['name']);
        $username = esc($_POST['username']);
		$email = esc($_POST['email']);
		$password = esc($_POST['password']);
		$cpassword = esc($_POST['xpassword']);

        if( empty($name) ) {  array_push($errors, "you forgot your name"); }
		if( empty($username) ) {  array_push($errors, "we need your username"); }
		if( empty($email) ) { array_push($errors, "email is missing"); }
		if( empty($password) ) { array_push($errors, "you forgot to enter the password"); }
		if( empty($cpassword) ) { array_push($errors, "you forgot to confirm the password"); }
		if( !empty($password) && !empty($cpassword) && $password != $cpassword ) { array_push($errors, "the two passwords did not match"); }
		if( only($username,0) ) { array_push($errors, "username already exists"); }
		// if( only($email,1) ) { array_push($errors, "email already exists"); }
		// if( only($password,2) ) { array_push($errors, "password quality low"); }
		
		if( empty($errors) ) {
			$password = md5($password);
			$sql = "INSERT INTO signup(name, username, email, password, role, active) VALUES('$name', '$username', '$email', '$password', 'author', 'a')";
			mysqli_query($database, $sql);

			$id = mysqli_insert_id($database);
			$sql = "INSERT INTO user(id, name, username, email) VALUES('$id', '$name', '$username', '$email')";
			mysqli_query($database, $sql);

			$_SESSION["user"] = byID($id, "signup");
			
			$code = md5(uniqid(rand(),true));
			$_SESSION['code1'] = $code;
			$link = "https://ex-presso.000webhostapp.com/registration/signup.php?tag=1&id=$id&code=$code";
			$Body = "<p> Warmest wishes from us for registering at our website <a href='https://ex-presso.000webhostapp.com/'> Expresso </a>. </p>
					 <p> To activate your account, please <a href='$link' style='text-decoration:none;'> click </a> on this link. </p>
					 <br>
					 <b> regards site admin </b>";
// 			sendMail($Body);
			$mail = mail($_SESSION["user"]["email"], "Confirmation Email from Expresso", $Body, "From:expresso@gmail.com");

            if($mail) {
			    header("Location: signup.php?message=1");
            }
		}
	}

	if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['signin']) ) {
		$errors = array();

		$username = esc($_POST['username']);
		$password = esc($_POST['password']);

		if( empty($username) ) { array_push($errors, "Username required"); }
		if( empty($password) ) { array_push($errors, "Password required"); }
		if( empty($errors) ) {
			$password = md5($password);
			$sql = "SELECT * FROM signup WHERE username='$username' and password='$password'";
			$query = mysqli_query($database, $sql);
			if( mysqli_num_rows($query) == 1 ) {
                $_SESSION['user'] = mysqli_fetch_assoc($query);
				header('Location: ../about.php');
			}
			else {
				array_push($errors, 'Wrong credentials');
			}
		}
	}

	if( $_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST['edit']) ) {
		$errors = array();

		$id = $_SESSION['user']['id'];
		$password = esc($_POST['password']);
		$npassword = esc($_POST['xpassword']);
		$nemail = esc($_POST['email']);
		
		if( empty($password)) { array_push($errors, "old password is must for confirmation"); }
		if( !empty($password) && md5($password) != $_SESSION['user']['password'] ) { array_push($errors, "wrong old password"); }
		if( empty($nemail) && empty($npassword) ) { array_push($errors, "both email and password fields can not be empty at a time"); }
		if( !empty($nemail) && $nemail == $_SESSION['user']['email'] ) { array_push($errors, "same old email"); }
		if( !empty($npassword) && !empty($password) && $npassword == $password ) { array_push($errors, "same old password"); }
		if( !empty($nemail) && $nemail != $_SESSION['user']['email'] && only($nemail,1) ) { array_push($errors, "email already exists"); }
		// if( !empty($npassword) && !empty($password) && $npassword != $password  && only($npassword,2) ) { array_push($errors, "password quality low"); }

		if( empty($errors) ) {
			$code = md5(uniqid(rand(),true));
			$_SESSION['code2'] = $code;
			$link = "https://ex-presso.000webhostapp.com/registration/editProfile.php?tag=2&id=$id&code=$code";
			$Body = "<p> You have just submitted some confidential information to edit your current profile at <a href='https://ex-presso.000webhostapp.com/' style='text-decoration:none;'> Expresso </a>. </p>
					 <p> If you did that by yourself and want to confirm this editing, please go through this <a href='$link' style='text-decoration:none;'> link </a>. </p>
					 <br>
					 <b> regards site admin </b>";
// 			sendMail($Body);
			mail($_SESSION["user"]["email"], "Confirmation Email from Expresso", $Body, "From:expresso@gmail.com");
			   
			$_SESSION["nemail"] = $nemail;
			$_SESSION["npassword"] = $npassword;
			header('Location: editProfile.php?message=2');
		}
	}
?>