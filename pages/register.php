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
		<form action=\"index.php?p=register\" method=\"post\">
			<div class=\"form-item username\">
				<p>Username <font color=\"red\">*</font></p>
				<input id=\"username\" type=\"text\" name=\"username\" class=\"username\" maxlength=\"16\" value=\"\" onblur=\"checkUsername();\" /><span class=\"busy\"><img src=\"img/ajax-loader.gif\"/></span>
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item password\">
				<p>Password <font color=\"red\">*</font></p>
				<input type=\"password\" id=\"pass1\" maxlength=\"30\" value=\"\" />
			</div>
			<div class=\"form-item password\">
				<p>Confirm Password <font color=\"red\">*</font></p>
				<input type=\"password\" name=\"password\" id=\"pass2\" maxlength=\"30\" value=\"\" onblur=\"checkPassMatch();\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item first\">
				<p>First Name <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"first\" id=\"first\" maxlength=\"20\" value=\"\" onblur=\"checkName('first');\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item last\">
				<p>Last Name <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"last\" id=\"last\" maxlength=\"20\" value=\"\" onblur=\"checkName('last');\" />
				<span class=\"msg\"></span>
			</div>
			<div class=\"form-item email\">
				<p>Email Address <font color=\"red\">*</font></p>
				<input type=\"text\" name=\"email\" id=\"email\" maxlength=\"50\" title=\"Email Address\" value=\"".$email."\" onKeyUp=\"validateEmail();\" onKeyUp=\"checkForm();\" />
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
		$ekey = sha1(microtime(true).mt_rand(10000,90000));
	
		$result = addNewUser($username,$first_name,$last_name,$email,$password,$date_joined,$ekey);
		if ($result=="1"){
			$result = mailNewUser($username);
			$content = "
			<div id=\"register\">
				<h2>Registration complete!</h2>
				<p>Please check your inbox for a confirmation email.</p>
			</div>";		
		}
		else {
			$content = "<div class=\"error\"><ul><li>There was a problem registering your information. Please try again.</li></ul></div>";
			$content .= $regform;
		}
	}
	else {
		$content = $regform;
	}

	// $content = mailNewUser("test1");
	
	// include('includes/header.php');
	
	// displayMessages();
	echo $content;
?>

<div id="output"></div>