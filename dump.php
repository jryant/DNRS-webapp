<?php 
/**
* Checks whether or not the given username is in the
* database, if so it checks if the given password is
* the same password in the database for that user.
* If the user doesn't exist or if the passwords don't
* match up, it returns an error code (1 or 2). 
* On success it returns 0.
*/
function confirmUser($username, $password){
	global $conn;
	/* Add slashes if necessary (for query) */
	if(!get_magic_quotes_gpc()) {
		$username = addslashes($username);
	}

	/* Verify that user is in database */
	$q = "SELECT password FROM users WHERE username = '$username'";
	$result = mysql_query($q,$conn);
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
	if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
		$_SESSION['username'] = $_COOKIE['cookname'];
		$_SESSION['password'] = $_COOKIE['cookpass'];
	}
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
	global $WEBSITE;
	global $logged_in;
	if($logged_in){
		echo "<h1>Logged In!</h1>";
	}
	else {
?>

<h1>Login</h1>

<form action="<?php echo $WEBSITE ?>index.php" method="post" name="login">
	<div class="form-item">
		<p>Username</p>
		<input type="text" class="selectMenu" name="user" maxlength="30" title="Username" />
	</div><!-- end form item -->
	<div class="form-item">
		<p>Password</p>
		<input type="password" class="selectMenu" name="pass" maxlength="30" title="Password" />
	</div><!-- end form item -->
	<div class="form-item checkbox">
		<input type="checkbox" class="checkbox" name="remember" title="Remember Me" value="Remember Me" /><p>Remember Me?</p>
		<div class="clearme"></div>
	</div><!-- end form item -->
	<div class="form-item">
		<input name="sublogin" type="submit" class="buttonSubmit" value="Login" />
	</div><!-- end form item -->
</form>

<?php
   }
}

/**
 * Checks to see if the user has submitted his
 * username and password through the login form,
 * if so, checks authenticity in database and
 * creates session.
 */
if(isset($_POST['sublogin'])){
	/* Check that all fields were typed in */
	if(!$_POST['user'] || !$_POST['pass']){
		die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=6\">");
	}
	/* Spruce up username, check length */
	$_POST['user'] = trim($_POST['user']);
	if(strlen($_POST['user']) > 30){
		die('Sorry, the username is longer than 30 characters, please shorten it. <a href="javascript:history.go(-1)">Try again?</a>');
	}

	/* Checks that username is in database and password is correct */
	$md5pass = md5($_POST['pass']);
	$result = confirmUser($_POST['user'], $md5pass);

	/* Check error codes */
	if($result == 1){
		die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=4\">");
	}
	elseif($result == 2){
		die("<meta http-equiv=\"Refresh\" content=\"0;url=index.php?msg=5\">");
	}

	/* Username and password correct, register session variables */
	$_POST['user'] = stripslashes($_POST['user']);
	$_SESSION['username'] = $_POST['user'];
	$_SESSION['password'] = $md5pass;

	/**
	* This is the cool part: the user has requested that we remember that
	* he's logged in, so we set two cookies. One to hold his username,
	* and one to hold his md5 encrypted password. We set them both to
	* expire in 100 days. Now, next time he comes to our site, we will
	* log him in automatically.
	*/
	if(isset($_POST['remember'])){
		setcookie("cookname", $_SESSION['username'], time()+60*60*24*100, "/");
		setcookie("cookpass", $_SESSION['password'], time()+60*60*24*100, "/");
	}

	/* Quick self-redirect to avoid resending data on refresh */
	echo "<meta http-equiv=\"Refresh\" content=\"0;url=$HTTP_SERVER_VARS[PHP_SELF]\">";
	return;
}

/* Sets the value of the logged_in variable, which can be used in your code */
$logged_in = checkLogin();

?>