<?php

require_once('globals.php');
require_once('functions.php');
db_connect();

$action = $_POST["action"];

switch($action){
	case 'editProfile':
		$user = $_SESSION['username'];
		$_SESSION['name'] = $_POST["name"];
		$name = explode(" ",$_SESSION["name"]);
		$firstname = $name[0];
		$lastname = $name[1];
		$email = $_POST["email"];
		$_SESSION['email'] = $email;
		$result = mysql_query("UPDATE users SET email='$email',first_name='$firstname',last_name='$lastname' WHERE username='$user'") or die(mysql_error());
		echo $result;
		break;
		
	case 'checkUsername':
		global $conn;
		$username = $_POST['username'];
		if(!get_magic_quotes_gpc()){
			$username = addslashes($username);
		}
		$q = "SELECT `username` FROM `users` WHERE `username`='$username'";
		$result = mysql_query($q) or die("that's why");
		// echo (mysql_numrows($result) > 0);
		echo (mysql_num_rows($result) > 0) ? 0 : 1 ;
		break;
		
	case 'register':
		global $conn;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$date_joined = date("Y-m-d");
		
		// $query = "INSERT INTO users (username,first_name,last_name,email,password,date_joined) VALUES ('$username','$first_name','$last_name','$email','$password','$date_joined')";
		// $result = mysql_query($result);
		$result = addNewUser($username,$first_name,$last_name,$email,$password);
		echo $result;
		break;
		
	case 'invite':
		global $conn;
		$email = $_POST['email'];
		mailInvite($email);
		echo "An invitation has been sent to $email.<br/>";
		break;
		
	case 'findcity':
		global $conn;
		$country_code = $_POST['country_code']; // debug secure
		$query = "SELECT * FROM cities WHERE country_code='$country_code'";
		$result = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($result) > 1){
			echo "<select name=\"city\">\n\t<option>Select City</option>";
			while($row = mysql_fetch_array($result)) {
				// echo $row['name']."<br/>";
				$city_name = strtoupper($row['name']);
				echo "\n\t<option value=\"".$city_name."\">".$city_name."</option>";
			}
			echo "\n</select>";
		} else {
			echo "<img src=\"img/green-checkmark.png\">";
		}
		break;
		
	default:
		echo "no action specified";
		break;
}

?>