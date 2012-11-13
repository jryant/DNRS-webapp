<?php

$result = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='{$_SESSION['uid']}'"));

echo "<h2>Welcome, ".$result['first_name']."</h2>";

echo "<p>Welcome to the DNRS On-line Health and Wellness Survey. We have designed this survey with your recovery in mind.  We ask that you kindly take the time to fill out the survey so that together we can track and celebrate your successes.</p>

<p>This data is also important for compiling research information and we deeply appreciate your input. Please note that your information will be kept confidential.</p>

<p>You will be sent a reminder to fill out the survey once a month during your six month retraining period. Thank you and we look forward to assisting you in Retraining Your Brain, Transforming Your Health and Reclaiming Your Life!</p>

<p>Yours in Good Health,<br/>The DNRS Team";

if($result['last_survey']){
	echo "<p>Last survey: ".$result['last_survey']." &bull; Next survey: ".$result['next_survey']."</p>";
}

?>