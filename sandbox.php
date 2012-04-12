<?php

require_once('globals.php');
require_once('functions.php');
db_connect();

// $name = explode(" ",$_GET['name']);
// $firstname = $name[0];
// $lastname = $name[1];
// 
// echo "<li>First: ".$firstname."</li><li>Last: ".$lastname."</li>";

$query = "SELECT * FROM responses ORDER BY ID DESC LIMIT 1";
$result = mysql_query($query) or die(mysql_error());
$response = mysql_fetch_array($result);

$uid = $response['uid']; // user ID
$date = $response['date']; // surveyed date
$sid = $response['ID']; // responses ID

$sections = array("a" => 196, "b" => 96, "c" => 116, "d" => 124);
// print_r($sections);
foreach($sections as $section => $max){
	$total[$section] = 0;
	foreach($response as $q => $a){
		if(strpos($q, $section) === 0 && $q != "date"){
			// print $a;
			$total[$section] = $total[$section] + $a;
		}
	}
	// echo "<br/>";
	$score[$section] = $max - $total[$section];
	$perc[$section] = round($score[$section] / $max, 2)*100;
	// echo "Section ".$section.": Total (".$total[$section].") Max (".$max.") Score (".$score[$section].") Percentage (".$perc[$section]."%)<br/>";
}

$query = "INSERT INTO summary SET `uid`='$uid', `date`='$date', `sid`='$sid', `a_raw`='{$total["a"]}', `b_raw`='{$total["b"]}', `c_raw`='{$total["c"]}', `d_raw`='{$total["d"]}', `a_percent`='{$perc["a"]}', `b_percent`='{$perc["b"]}', `c_percent`='{$perc["c"]}', `d_percent`='{$perc["d"]}'";
$result = mysql_query($query) or die(mysql_error());
print $result;


// $response_id = "0014";
// 
// $query = "SELECT * FROM responses WHERE ID = '$response_id'";
// $result = mysql_query($query) or die(mysql_error());
// $response = mysql_fetch_array($result);
// 
// $uid = $response['uid']; // user ID
// $date = $response['date']; // surveyed date
// $sid = $response['ID']; // responses ID
// 
// $sections = array("a" => 196, "b" => 96, "c" => 116, "d" => 124);
// // print_r($sections);
// foreach($sections as $section => $max){
// 	$total[$section] = 0;
// 	foreach($response as $q => $a){
// 		if(strpos($q, $section) === 0 && $q != "date"){
// 			// print $a;
// 			$total[$section] = $total[$section] + $a;
// 		}
// 	}
// 	// echo "<br/>";
// 	$score[$section] = $max - $total[$section];
// 	$perc[$section] = round($score[$section] / $max, 2)*100;
// 	echo "Section ".$section.": Total (".$total[$section].") Max (".$max.") Score (".$score[$section].") Percentage (".$perc[$section]."%)<br/>";
// }
// 
// $query = "INSERT INTO summary SET `uid`='$uid', `date`='$date', `sid`='$sid', `a_raw`='{$total["a"]}', `b_raw`='{$total["b"]}', `c_raw`='{$total["c"]}', `d_raw`='{$total["d"]}', `a_percent`='{$perc["a"]}', `b_percent`='{$perc["b"]}', `c_percent`='{$perc["c"]}', `d_percent`='{$perc["d"]}'";
// $result = mysql_query($query) or die(mysql_error());
// // print $result;

?>