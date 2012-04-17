#!/usr/local/bin/php -q
<?php
require_once('globals.php');
require_once('functions.php');
db_connect();

$today = date("Y-m-d");

$query = "SELECT * FROM users";
$result = mysql_query($query) or die(mysql_error());
$output = "";
$output .= "<h1>Survey Users</h1>";
$output .= "<ol>";
while($user = mysql_fetch_array($result)){
	$output .= "<li>".$user['first_name']." ".$user['last_name']." - Reminder date: ".$user['next_survey']." (";
	if ($user['next_survey'] && strtotime($user['next_survey']) <= strtotime($today)){
		$output .= (mailRemind($user['ID'],$user['first_name'],$user['email'])==1) ? "<b>Sent</b>" : "<b color=\"red\">ERROR!</b>";
	} else {
		$output .= "Not sent";
	}
	$output .= ") Email: ".$user['email']."</li>";
}
$output .= "</ol>";

mailReport($output);

?>