<?php
// session_start();
require("functions.php");
$user = $_POST['user'];
$pass = $_POST['pass'];
db_connect();

/**
 * Checks to see if the user has submitted his
 * username and password through the login form,
 * if so, checks authenticity in database and
 * creates session.
 */
/* Check that all fields were typed in */
$error = FALSE;
if(!$user || !$pass){
	// die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=6\">");
	echo "Please fill out both fields to proceed.";
	$error = TRUE;
}
/* Spruce up username, check length */
$user = trim($user);
if(strlen($user) > 30){
	// die('Sorry, the username is longer than 30 characters, please shorten it. <a href="javascript:history.go(-1)">Try again?</a>');
	echo "Sorry, the username is longer than 30 characters, please shorten it.";
	$error = TRUE;
}

if (!$error){
	/* Checks that username is in database and password is correct */
	$md5pass = md5($pass);
	$result = confirmUser($user, $md5pass);

	/* Check error codes */
	if($result == 1){
		// die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=4\">");
		echo "That username doesn't exist in our database.<br/>";
	}
	elseif($result == 2){
		// die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=5\">");
		echo "Incorrect password, please try again.<br/>";
	}
	else {
		/* Username and password correct, register session variables */
		$user = stripslashes($user);
		$_SESSION['username'] = $user;
		$_SESSION['password'] = $md5pass;
		
		/* Retrieve user info from database */
		$q = "SELECT * FROM `users` WHERE username='$user'";
		$result = mysql_query($q);
		if(!$result || (mysql_numrows($result) < 1)){
			die(mysql_error());
		}
		else{
			/* Set session variables to user info */
			$dbarray = mysql_fetch_array($result);
			$dbarray['name'] = $dbarray['first_name']." ".$dbarray['last_name'];
			$_SESSION['name'] = $dbarray['name'];
			$_SESSION['email'] = $dbarray['email'];
			$_SESSION['uid'] = $dbarray['ID'];
			$_SESSION['admin'] = ($dbarray['is_admin']==1) ? TRUE : "" ;
			$logged_in = checkLogin();
			$query = "UPDATE users SET `last_login`='".date("Y-m-d")."' WHERE ID='{$_SESSION['uid']}'";
			$result = mysql_query($query) or die("Error updating user table (on login)");
			// echo ($logged_in) ? "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">" : "";
		}	
	}
}

// echo ($logged_in) ? "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">" : "";

if($logged_in){
// if($_SESSION['username']){
	// echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php\">";
	// echo "Logged in as <b>".$_SESSION['name']."</b><br/>
	// Email: <b>".$_SESSION['email']."</b><br/>
	// Admin status: <b>".$_SESSION['admin']."</b><br/>
	// UID: <b>".$_SESSION['uid']."</b><br/>";
	// var_dump($logged_in);
	// echo "<br/><a href=index.php>Refresh</a>";
	echo "1";
}

// var_dump($logged_in);

?>