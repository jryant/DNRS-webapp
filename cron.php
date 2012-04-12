<?php
require_once('globals.php');
require_once('functions.php');
db_connect();

$today = date("Y-m-d");

$query = "SELECT * FROM users";
$result = mysql_query($query) or die(mysql_error());
echo "<h1>Survey Users</h1>";
echo "<ol>";
while($user = mysql_fetch_array($result)){
	echo "<li>".$user['first_name']." ".$user['last_name']." - Reminder date: ".$user['next_survey']." (";
	echo (strtotime($user['next_survey']) <= strtotime($today)) ? "SEND" : "don't send" ;
	echo ")</li>";
}
echo "</ol>";

mailRemind($user['ID'],$user['first_name'],$user['email']); // DEBUG

?>