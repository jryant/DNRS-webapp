<?php
if(!isset($_SESSION)){session_start();}
require_once('lib/FirePHPCore/FirePHP.class.php');
ob_start();
$firephp = FirePHP::getInstance(true);

/**
 * Connect to the mysql database.
 */
function db_connect($server="localhost"){
	global $debug;
	// $localhost = array('hostname'=>"localhost:8889",'user'=>"root",'pass'=>"root",'db'=>"healthsurvey");
	$localhost = array('hostname'=>"dnrswebapp3.db.4275239.hostedresource.com",'user'=>"dnrswebapp3",'pass'=>"H3althSurv3y",'db'=>"dnrswebapp3");
	// $localhost = array('hostname'=>"dnrswebappblc.db.4275239.hostedresource.com",'user'=>"dnrswebappblc",'pass'=>"H3althSurv3y",'db'=>"dnrswebappblc");

	$conn = mysql_connect(${$server}['hostname'],${$server}['user'],${$server}['pass']) or die("Could not connect to MySQL server: ".mysql_error());
	$db = mysql_select_db(${$server}['db']) or die("Could not connect to MySQL database: ".mysql_error());
	
	// $db = $localhost['db'];
	// echo ($debug) ? "<script>console.log(\"DB $db connected!\")</script>" : "" ;
}

function confirmUser($username, $password){
	global $conn;
	/* Add slashes if necessary (for query) */
	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
	}

	/* Verify that user is in database */
	$q = "SELECT * FROM `users` WHERE username='$username'";
	// var_dump($q);
	// echo "<br/>";
	$result = mysql_query($q);// or die("error line 14");
	// var_dump($result);
	// echo "<br/>";
	if (!$result) {
	    die('Invalid query: ' . mysql_error());
	}
	if(!$result || (mysql_numrows($result) < 1)){
		return 1; //Indicates username failure
	}

	/* Retrieve password from result, strip slashes */
	$dbarray = mysql_fetch_array($result);
	$dbarray['password']  = stripslashes($dbarray['password']);
	$password = stripslashes($password);
	#$company = $dbarray['company'];
	#$url = $dbarray['url'];

	/* Validate that password is correct */
	if($password == $dbarray['password']){
		return 0; //Success! Username and password confirmed
	}
	else{
		return 2; //Indicates password failure
	}
}

/**
 * checkLogin - Checks if the user has already previously
 * logged in, and a session with the user has already been
 * established. Also checks to see if user has been remembered.
 * If so, the database is queried to make sure of the user's 
 * authenticity. Returns true if the user has logged in.
 */
function checkLogin(){
	/* Check if user has been remembered */
	// if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
	// 	$_SESSION['username'] = $_COOKIE['cookname'];
	// 	$_SESSION['password'] = $_COOKIE['cookpass'];
	// }
	/* Username and password have been set */
	if(isset($_SESSION['username']) && isset($_SESSION['password'])){
		/* Confirm that username and password are valid */
		if(confirmUser($_SESSION['username'], $_SESSION['password']) != 0){
			/* Variables are incorrect, user not logged in */
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			return false;
		}
		return true;
	}
	/* User not logged in */
	else{
		return false;
	}
}

function displayLogin(){
	// global $WEBSITE;
	global $logged_in;
	if($logged_in){
	// 	echo "<h1>Welcome!</h1>";
	// 	echo "Logged in as <b>".$_SESSION['name']."</b><br/>
	// 	Email: <b>".$_SESSION['email']."</b><br/>
	// 	UID: <b>".$_SESSION['uid']."</b><br/>";
	// 	echo ($_SESSION['admin']) ? "<b>Admin user</b><br/>" : "" ;
	// 	// draw_menu();
	// 	// draw_page($page);
	}
	else {
?>
	<div id="login">
		<span class="head"><h2>Login</h2> or <a href="index.php?p=register">Register</a></span>

		<!-- <form onsubmit="submitLogin();return false;" name="login"> -->
		<form action="login.php" name="login" method="post">
			<div class="form-item">
				<p>Username</p>
				<input type="text" class="user" name="user" maxlength="30" title="Username" value="test" />
			</div><!-- end form item -->
			<div class="form-item">
				<p>Password</p>
				<input type="password" class="pass" name="pass" maxlength="30" title="Password" value="password" />
			</div><!-- end form item -->
			<div class="form-item checkbox">
				<!-- <input type="checkbox" class="checkbox" name="remember" title="Remember Me" value="Remember Me" /><p>Remember Me?</p>
				<div class="clearme"></div> -->
			</div><!-- end form item -->
			<div class="form-item">
				<input name="sublogin" type="submit" class="buttonSubmit" value="Login" /><span id="busy"><img src="img/ajax-loader.gif"/></span>
			</div><!-- end form item -->
		</form>
		<div id="output"></div>
	</div>
<?php }
}

function logout(){
	global $logged_in;
	/**
	 * Delete cookies - the time must be in the past,
	 * so just negate what you added when creating the
	 * cookie.
	 */
	if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
	   setcookie("cookname", "", time()-60*60*24*100, "/");
	   setcookie("cookpass", "", time()-60*60*24*100, "/");
	}

	if(!$logged_in){
		// echo "<h1>Error!</h1>\n";
		// echo "You are not currently logged in, logout failed. Back to <a href=\"index.php\">login page</a>.";
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=1\">"; // ?msg=1
	}
	else{
	   /* Kill session variables */
	   unset($_SESSION['username']);
	   unset($_SESSION['password']);
	   $_SESSION = array(); // reset session array
	   session_destroy();   // destroy session.

		if(isset($_GET['msg']) && $_GET['msg']==2){
			$msg = "2";
		}
		else {
			$msg = "1";
		}

	   echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=".$msg."\">";

	   // echo "<h1>Logged Out</h1>\n";
	   // echo "You have successfully <b>logged out</b>. Back to <a href=\"index.php\">index</a>";
	}
}

/**
 * Create the navigation menu
 */
function draw_menu(){
	global $logged_in;
	if(isset($_SESSION['admin'])){
		if($_SESSION['admin']){
			$query = "SELECT * FROM menu WHERE `exclude`='0' ORDER BY id";
		} elseif(!$_SESSION['admin']){
			$query = "SELECT * FROM menu WHERE `restricted`!='1' ORDER BY id";
		} else {
			die("Admin session variable not set");
		}
	}

	// var_dump($query);
	// $firephp->log($query, 'Menu query');

	$output = "<div id=\"menu\">";
	$output .= "<ul>";
	if($logged_in){
		$result = mysql_query($query) or die(mysql_error());
		while($menu_item = mysql_fetch_array($result)){
			$output .= "<li><a href=\"index.php?p=".$menu_item['slug']."\">".$menu_item['name']."</a></li>";
		}
		$output .= "<li><a href=\"index.php?p=logout\">Logout</a></li>";
	}
	else {
		$output .= "<li><a href=\"index.php\">Login</a></li>";
	}
	$output .= "</ul>
	</div>";
	$output .= "<div class=\"back_btn\"><a href=\"http://www.dnrsystem.com\"><img src='img/but-back-website.jpg' alt='Back to Main Website' /></a></div>";
	echo $output;
}

function draw_page($slug){
	include("pages/$slug.php");
}

function displayMessages(){
	if (isset($_GET['msg'])){
		$msg = $_GET['msg'];
		if ($msg==1){
			$output = "<div class=\"msg_success\"><ul><li>You have successfully been logged out.</li></ul></div>";
		}
		if ($msg==2){
			$output = "<div class=\"msg_success\"><ul><li>Your password has successfully been changed and has been emailed to you for your records.</li><li><u><i>Please log in again to confirm your new password.</i></u></li></ul></div>";
		}
		if ($msg==3){
			$output = "<div class=\"msg_error\"><ul><li><b>Error!</b> You are not authorized to access that content.</li></ul></div>";
		}
		if ($msg==4){
			$output = "<div class=\"msg_error\"><ul><li>That username doesn't exist in our database.</li></ul></div>";
		}
		if ($msg==5){
			$output = "<div class=\"msg_error\"><ul><li>Incorrect password, please try again.</li></ul></div>";
		}
		if ($msg==6){
			$output = "<div class=\"msg_warning\"><ul><li>Please fill out both fields to proceed.</li></ul></div>";
		}
		if ($msg==7){
			$output = "<div class=\"msg_success\"><ul><li>Your profile has been updated.</li></ul></div>";
		}
		if ($msg==8){
			$output = "<div class=\"msg_error\"><ul><li>There was a problem updating your profile. Please try again.</li></ul></div>";
		}
		if ($msg==9){
			$output = "<div class=\"msg_success\"><ul><li>Your email address has been confirmed. Please continue with log in.</li></ul></div>";
		}
		echo $output;
	}
	else {
		$msg = "";
	}
}

function showMessageBlock($p){
	echo "<div class=\"msg_error hidden\" id=\"error_p".$p."\"><ul><li>Please answer all questions on this page to continue.</li></ul></div>";	
}

function niceDate($date){
	return strftime("%b %d, %Y", strtotime($date));
}

/**
 * Inserts the given (username, password) pair
 * into the database. Returns true on success,
 * false otherwise.
 */
function addNewUser($username, $first_name, $last_name, $email, $password,$date_joined,$ekey){
	$q = "INSERT INTO users (username, first_name, last_name, email, password, date_joined, email_key) VALUES ('$username', '$first_name', '$last_name', '$email', '$password', '$date_joined', '$ekey')";
	$result = mysql_query($q) or die(mysql_error());
	return $result;
}

function mailNewUser($username){
	$q = "SELECT id,first_name,email,email_key FROM users WHERE username = '$username'";
	$result = mysql_query($q) or die(mysql_error());
	$user = mysql_fetch_array($result);
	// return $user['first_name'] . " - " . $user['email'] . " - " . $user['email_key'];
	
	$subject = "Registration Confirmation | Dynamic Neural Retraining System";
	$headers = "From: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
	    "Reply-To: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
		"Bcc: " . $GLOBALS['EMAIL_BCC'] . "\r\n" .
		"MIME-Version: 1.0 \r\n" .
		"Content-Type: text/HTML; charset=utf-8\r\n" .
	    "X-Mailer: PHP/" . phpversion();

		$message = "Hi ".$user['first_name'].",<br/>
<br/>
Thank you for purchasing the Dynamic Neural Retraining System&trade; To accurately track your progress we ask that you take a few minutes to fill out the following Wellness Survey so that we have an accurate baseline of your starting point. We will send you a survey once a month so that we can track your progress and celebrate your successes with you. Thank you and we look forward to assisting you in your recovery process.<br/>
<br/>
Please click on the link below to activate your account.<br/>
<br/>
".$GLOBALS['WEBSITE']."index.php?p=register&conf=".$user['email_key']."&id=".$user['id']."<br/>
<br/>
Yours in Good Health,<br/>
The DNRS Team<br/>
<br/>
---<br/>
This is an automatically-generated message. Please do not reply.";

	return mail($user['email'], $subject, $message, $headers);
}

function mailInvite($email){
	$subject = "You're Invited! | Dynamic Neural Retraining System";
	$headers = "From: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
	    "Reply-To: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
		"Bcc: " . $GLOBALS['EMAIL_BCC'] . "\r\n" .
		"MIME-Version: 1.0 \r\n" .
		"Content-Type: text/HTML; charset=utf-8\r\n" .
	    "X-Mailer: PHP/" . phpversion();

		$message = "Hello,<br/>
<br/>
Welcome to the DNRS On-line Health and Wellness Survey.  We have designed this survey with your recovery in mind and ask that you take the time to fill out the survey so that together we can track and celebrate your successes.  This data is also important for compiling research information and we appreciate your input.   To accurately track your progress we require an accurate baseline of your starting point.  If you have been training for more than one month already, please fill out this initial survey while keeping in mind your state BEFORE you started the DNRS Program.  Please indicate the month and year of your start date.  You will be sent a reminder to fill out the survey once a month during your six month retraining period.  If you are already past your six month retraining period then we will simply send you one follow up survey so that we can track your journey of recovery.  Thank you and we look forward to assisting you in Retraining Your Brain, Transforming Your Health and Reclaiming Your Life!<br/>
<br/>
".$GLOBALS['WEBSITE']."index.php?p=register&email=".$email."<br/>
<br/>
Yours in Good Health,<br/>
The DNRS Team<br/>
<br/>
---<br/>
This is an automatically-generated message. Please do not reply.";

	return mail($email, $subject, $message, $headers);
}

function mailRemind($id,$first_name,$email){
	$subject = "Survey Reminder | Dynamic Neural Retraining System";
	$headers = "From: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
	    "Reply-To: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
		"Bcc: " . $GLOBALS['EMAIL_BCC'] . "\r\n" .
		"MIME-Version: 1.0 \r\n" .
		"Content-Type: text/HTML; charset=utf-8\r\n" .
	    "X-Mailer: PHP/" . phpversion();

		$message = "Hi ".$first_name.",<br/>
<br/>
It's time to record your progress this month.  Please take a few minutes to complete the Wellness Survey again so that we can accurately record your recovery process.  This data will also assist us with on-going research and development.  We appreciate your dedication and applaud your efforts in Retraining Your Brain, Transforming Your Health and Reclaiming Your Life!<br/>
<br/>
".$GLOBALS['WEBSITE']."<br/>
<br/>
Yours in Good Health,<br/>
The DNRS Team<br/>
<br/>
---<br/>
This is an automatically-generated message. Please do not reply.";

	return mail($email, $subject, $message, $headers);
}

function mailReport($message){
	$subject = "Survey Reminder Log | DNRS Web App";
	$headers = "From: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
	    "Reply-To: " . $GLOBALS['EMAIL_SENDER'] . "\r\n" .
		"Bcc: " . $GLOBALS['EMAIL_BCC'] . "\r\n" .
		"MIME-Version: 1.0 \r\n" .
		"Content-Type: text/HTML; charset=utf-8\r\n" .
	    "X-Mailer: PHP/" . phpversion();
	return mail($GLOBALS['EMAIL_BCC'], $subject, $message, $headers);	
}

function ekeyConf($id,$conf){
	$q = "SELECT email_key FROM users WHERE ID = '$id'";
	$result = mysql_query($q) or die(mysql_error());
	$user = mysql_fetch_array($result);
	var_dump($user);
	if ($conf==$user['email_key']){
		$q = "UPDATE users SET email_conf='1' WHERE ID = '$id'";
		$result = mysql_query($q) or die(mysql_error());
		echo "<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=9\">";
	} else {
		echo "Error confirming email address.";
	}
}

function section_navi($page,$pagetot,$first=false,$last=false){
	$output = "<div class=\"navi\">";
	$output .= ($first) ? "<span class=\"prev\">&nbsp;</span>" : "<span class=\"prev\"><a href=\"#\"><img src='img/but-go-back.jpg' alt='Go Back' /></a></span>";
	$output .= "<span class=\"page_count\">Page $page of $pagetot</span>";
	if ($last){
		$output .= "<input type=\"hidden\" name=\"date\" value=\"".date("Y-m-d")."\" id=\"date\">";
		$output .= "<input type=\"submit\" name=\"submit\" value=\"Submit\" id=\"submit\">";
	}
	else {
		$output .= "<span class=\"next\" id=\"p".$page."\"><a href=\"#\"><img src='img/but-next-step.jpg' alt='Next Step' /></a></span>";
	}
	$output .=  "</div>"; // .navi
	return $output;
}

function calcSummary($id){
	$query = "SELECT * FROM responses WHERE ID = '$id'";
	$result = mysql_query($q) or die(mysql_error());

}

function getName($id){
	$query = "SELECT first_name,last_name FROM users WHERE `ID`='$id'";
	$users = mysql_query($query) or die(mysql_error());
	$user = mysql_fetch_array($users);
	return $user['first_name']." ".$user['last_name'];
}

function getScale(){
	$output = "<div class=\"guide\">
		<p class=\"term\">Enter your answers below:<span id=\"t4\">N/A</span><span id=\"t3\">3</span><span id=\"t2\">2</span><span id=\"t1\">1</span><span id=\"t0\" class=\"active\">0</span></p>
		<!-- <div class=\"clearme\"></div> -->
		<p class=\"def2\">(Please remember the LOWER your score, the HEALTHIER you are.)</p>
		<p class=\"def active\" id=\"st0\">This statement is true for me <b>more than 75% of the time</b> and happened <b>most days</b> over the last 30 days</p>
		<p class=\"def\" id=\"st1\">This statement is true for me <b>more than 50% of the time</b> and happened <b>frequently</b> over the last 30 days</p>
		<p class=\"def\" id=\"st2\">This statement is true for me <b>less than 50% of the time</b> and happened <b>occasionally</b> over the last 30 days</p>
		<p class=\"def\" id=\"st3\">This statement is true for me <b>less than 5% of the time</b> and happened <b>rarely</b> over the last 30 days</p>
		<p class=\"def\" id=\"st4\">This statement is <b>never</b> true for me</p>
	</div>";
	return $output;
}

$tooltips = array(
	1 => "Never (0&#37;)",
	2 => "Rarely (1&#37;-24&#37;)",
	3 => "Sometimes (25&#37;-50&#37;)",
	4 => "Often (51&#37;-75&#37;)",
	5 => "Usually (76&#37;+)",
	6 => "Not Applicable"
);

function sectionHeading($heading,$page){
	global $tooltips;
	global $hsec;
	if ($heading!="cont") {
		$hsec = $heading;
	}
	$disp = ($heading=="cont") ? $hsec." (Continued)" : $hsec ;
	echo "<div class=\"guide\">\n";
	echo "<img src=\"img/legend.png\" width=\"564\" height=\"26\" alt=\"Scoring Legend\" />";
	// echo "<div class=\"legend\">\n";
	// for($n=1;$n<7;$n++){
	// 	echo ($n==6) ? "\t<span>N/A = ".$tooltips[$n]."</span>\n" : "\t<span>".$n." = ".$tooltips[$n]."</span>\n" ;
	// }	
	// echo "</div>";
	echo "<p class=\"term\">Section $disp";
	for($n=6;$n>0;$n--){
		echo ($n==6) ? "<span class=\"last\" title=\"".$tooltips[$n]."\">N/A</span>" : "<span title=\"".$tooltips[$n]."\">".$n."</span>" ;
	}
	echo "</p></div>";
	// echo "<script>console.log(".$page.");</script>";
}

?>