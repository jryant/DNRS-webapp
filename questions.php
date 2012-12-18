<?php

require_once('globals.php');
require_once('functions.php');
db_connect();

$result = mysql_query("SELECT * FROM q3 WHERE QID!='q1' ORDER BY 'QID' DESC");
while($question = mysql_fetch_array($result)){ // Loop through db for questions	
	if(isset($_GET['ids']) && $_GET['ids']=="yes"){
		echo $question['QID'].". ";
	}
	echo $question['question']."<br>";
}

?>