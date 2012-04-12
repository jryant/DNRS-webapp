<?php

$result = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='{$_SESSION['uid']}'"));

echo "<h2>Welcome, ".$result['first_name']."</h2>";

if($result['last_survey']){
	echo "<p>Last survey date: ".$result['last_survey']."</p>";
	echo "<p>Next survey date: ".$result['next_survey']."</p>";
}

?>