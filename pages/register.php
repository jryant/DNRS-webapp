<?php
	// session_start();
	require_once('globals.php');
	require_once('functions.php');
	db_connect();

	$logged_in = checkLogin();

	$email = (isset($_GET['email'])) ? $_GET['email'] : "" ;
	
	$regform = "
	<div id=\"register\">
		<h2>Register</h2>
		<p>Please choose a username and password to create your account.</p>
		<form action=\"index.php?p=register\" method=\"post\" id=\"regform\">
			<div class=\"form-item username\">
				<p>Username <font color=\"red\">*</font></p>
				<input id=\"username\" type=\"text\" name=\"username\" class=\"username required\" maxlength=\"16\" value=\"\" onblur=\"checkUsername();\" /><span class=\"busy\"><img src=\"img/ajax-loader.gif\"/></span>
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item password\">
				<p>Password <font color=\"red\">*</font></p>
				<input type=\"password\" id=\"pass1\" maxlength=\"30\" value=\"\" class=\"required\" />
			</div>
			<div class=\"form-item password\">
				<p>Confirm Password <font color=\"red\">*</font></p>
				<input type=\"password\" name=\"password\" id=\"pass2\" maxlength=\"30\" value=\"\" class=\"required\" onblur=\"checkPassMatch();\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item first\">
				<p>First Name <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"first\" id=\"first\" maxlength=\"20\" value=\"\" class=\"required\" onblur=\"checkName('first');\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item last\">
				<p>Last Name <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"last\" id=\"last\" maxlength=\"20\" value=\"\" class=\"required\" onblur=\"checkName('last');\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item email\">
				<p>Email Address <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"email\" id=\"email\" maxlength=\"50\" title=\"Email Address\" class=\"required email\" value=\"".$email."\" onKeyUp=\"validateEmail();\" onKeyUp=\"checkForm();\" />
				<span class=\"msg\"></span>
			</div>
			<p><input id=\"submit\" name=\"submit\" type=\"submit\" value=\"Continue &rarr;\" /></p>
		</form>	
		<a href=\"index.php\">Back to login</a>
	</div>";

	if(isset($_GET['conf'])){
		$id = $_GET['id'];
		$conf = $_GET['conf'];
		ekeyConf($id,$conf);
	}
	elseif(isset($_POST['submit'])){
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$first_name = $_POST['first'];
		$last_name = $_POST['last'];
		$email = $_POST['email'];
		$date_joined = date("Y-m-d");
		$final_remind = date('Y-m-d', strtotime('+180 days'));
		// $ekey = sha1(microtime(true).mt_rand(10000,90000));
		
		$exists = checkEmail($email);
		if($exists=="0" || $exists==0){
			echo "<div class=\"msg_error\"><ul><li>That email address is already registered. Would you like to <a href=\"index.php?pw=reset&email=".$email."\">reset your password?</a></li></ul></div>";
			echo $regform;
		} else {
			$result = addNewUser($username,$first_name,$last_name,$email,$password,$date_joined);
			if ($result=="1"){
				$result = mailNewUser($username);
				echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=11&u=".$username."\">";
				// $content = "
				// <div id=\"register\">
				// 	<h2>Registration complete!</h2>
				// 	<p>Please check your inbox for a confirmation email.</p>
				// </div>";		
			}
			else {
				echo "<div class=\"msg_error\"><ul><li>There was a problem registering your information. Please try again.</li></ul></div>";
				echo $regform;
			}
		}
	}
	else {
		echo $regform;
	}

	// $content = mailNewUser("test1");
	
	// include('includes/header.php');
	
	// displayMessages();
	// echo ($content) ? $content : "" ;
?>

<div id="output"></div>