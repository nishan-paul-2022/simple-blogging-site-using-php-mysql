<?php
	date_default_timezone_set('UTC');
	
	session_start();
	$database = mysqli_connect("localhost", "root", "", "13_expresso");
	if( !$database ) {
		die("Error connecting to database: " . mysqli_connect_error());
	}

	function countC($postid) {
		global $database;
		$sql = "SELECT * FROM comment WHERE postid='$postid'";
		$query = mysqli_query($database, $sql);
		$ncomments = mysqli_num_rows($query);
		return $ncomments;
	}

	function basis($a, $b) { return $b['1'] - $a['1']; }
	
	function sortPopular() {
		global $database;
		$popularPost = array();
		$sql = "SELECT * FROM post";
		$query = mysqli_query($database, $sql);
		while( $presult = mysqli_fetch_assoc($query) ) {
			$ncomments = countC( $presult['postid'] );
			$popularPost[$presult['postid']] = array($presult, $ncomments);
		}
		usort($popularPost, "basis");
		return $popularPost;
	}

	function esc($value) {
		global $database;
		$value = trim($value);
		$value = htmlspecialchars($value);
		$value = mysqli_real_escape_string($database, $value);
		return $value;
	}

	function byID($id, $key) {
		global $database;
		$sql = "SELECT * FROM $key WHERE id='$id' LIMIT 1";
		$query = mysqli_query($database, $sql);
		$result = mysqli_fetch_assoc($query);
		return $result;
	}

	$reference1 = "registration/signin.php"; 
	$reference2 = "registration/signup.php";
	$notation1 = "LOGIN";
	$notation2 = "REGISTER";
	
	
	if( isset($_SESSION["user"]) ) {
		$_SESSION["user"] = byID( $_SESSION["user"]["id"], "signup" );

		$dimage = "user/".$_SESSION["user"]["username"]."/DP.jpg";
		$cimage = "user/".$_SESSION["user"]["username"]."/COVER.jpg";

		$reference1 = "registration/signout.php"; 
		$reference2 = "about.php";
		$notation1 = "LOGOUT";
		$notation2 = $_SESSION["user"]["username"];
	}
?>
