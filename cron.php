#!/usr/local/bin/php -q
<?php
require_once('globals.php');
require_once('functions.php');
db_connect();

$today = date("Y-m-d");
$send = FALSE;

$query = "SELECT * FROM users";
$result = mysql_query($query) or die(mysql_error());
$output = "";
$output .= "<h1>Survey Users</h1>";
// $output .= "<ol>";
$output .= "<table cellpadding='5'><thead style='font-weight:bold;'><tr><td>Name</td><td>Next Reminder</td><td>Sent?</td><td>Final Survey</td><td>Email address</td></tr></thead><tbody>";
while($user = mysql_fetch_array($result)){
	$last_survey = strtotime($user['date_joined']." +6 month");
	// $output .= "<li>".$user['first_name']." ".$user['last_name']." - Reminder date: ".$user['next_survey']." (";
	$output .= "<tr><td>".$user['first_name']." ".$user['last_name']."</td><td>".$user['next_survey']."</td><td>";
	if ($user['next_survey'] && strtotime($user['next_survey']) == strtotime($today) && strtotime($user['next_survey']) <= $user['last_survey']){
		// $output .= (mailRemind($user['ID'],$user['first_name'],$user['email'])==1) ? "<b>Sent</b>" : "<b color=\"red\">ERROR!</b>";
		$output .= (mailRemind($user['ID'],$user['first_name'],$user['email'])==1) ? "<b>Sent</b>" : "<b color=\"red\">ERROR!</b>";
		$send = TRUE;
	} else {
		$output .= "Not sent";
	}
	// $output .= ") Final reminder: ".strtotime($last_survey)." Email: ".$user['email']."</li>";
	$output .= "</td><td>".strftime('%Y-%m-%d', $last_survey)."</td><td>".$user['email']."</td></tr>";
}
// $output .= "</ol>";
$output .= "</tbody></table>";

if($send){
	mailReport($output);
}

// echo $output;

?>