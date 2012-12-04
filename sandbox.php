<?php

require_once('globals.php');
require_once('functions.php');
db_connect();

// $result = mysql_query("SELECT * FROM q2 WHERE QID!='q1' ORDER BY 'QID' DESC");
// while($question = mysql_fetch_array($result)){ // Loop through db for questions	
// 	echo "&quot;".$question['question']."&quot;"."<br>";
// }

/*
$questions = array(
	"(0135, 'a00', 'I feel rested when I wake up in the morning'),",
	"(0136, 'a01', 'I drink less than 2 servings of caffeine beverages per day'),",
	"(0137, 'a02', 'I spend 30 minutes at least 3 times each week in moderate activity such as walking, biking, swimming'),",
	"(0138, 'a03', 'I have a normal and healthy sense of taste'),",
	"(0139, 'a04', 'I eat a well-balanced and nutritious diet'),",
	"(0140, 'a05', 'I get between 6 and 9 hours sleep each night'),",
	"(0141, 'a06', 'I am satisfied with my health status'),",
	"(0142, 'a07', 'I drink at least 8 glasses of water each day'),",
	"(0143, 'a08', 'I fall asleep easily'),",
	"(0144, 'a09', 'My hands and feet are warm at room temperature'),",
	"(0145, 'a10', 'My balance is good'),",
	"(0146, 'a11', 'I experience skin-to-skin contact with another person or pet'),",
	"(0147, 'a12', 'I feel relaxed and comfortable most of the time'),",
	"(0148, 'a13', 'I am happy with my energy levels'),",
	"(0149, 'a14', 'I am able to comfortably participate in activities that require moderate physical exertion'),",
	"(0150, 'a15', 'I comfortably do what I want to and when'),",
	"(0151, 'a16', 'I can do as much work as I want to'),",
	"(0152, 'a17', 'I can look after myself and my personal needs'),",
	"(0153, 'a18', 'I have a healthy body temperature'),",
	"(0154, 'a19', 'My skin color is even and consistent'),",
	"(0155, 'a20', 'My digestive system is healthy and strong'),",
	"(0156, 'a21', 'My sense of smell is healthy and normal'),",
	"(0157, 'a22', 'My heart feels strong and healthy'),",
	"(0158, 'a23', 'I am able to take medication recommended by my doctor'),",
	"(0159, 'a24', 'My immune system functions well'),",
	"(0160, 'a25', 'I am comfortable and able to breathe deeply'),",
	"(0161, 'b00', 'I feel clear headed'),",
	"(0162, 'b01', 'I am able to concentrate and focus'),",
	"(0163, 'b02', 'I find it easy to make decisions'),",
	"(0164, 'b03', 'I understand written instructions'),",
	"(0165, 'b04', 'I am able to do simple math'),",
	"(0166, 'b05', 'I learn new things easily'),",
	"(0167, 'b06', 'I am totally able to care for myself'),",
	"(0168, 'b07', 'I live in the present, instead of dwelling on the past or future'),",
	"(0169, 'b08', 'I am able to manage my own finances'),",
	"(0170, 'b09', 'I have goals that I actively pursue'),",
	"(0171, 'b10', 'I am spontaneous and enjoy new adventures'),",
	"(0172, 'b11', 'I feel capable of taking on new projects in life'),",
	"(0173, 'b12', 'My thought patterns are generally positive in nature'),",
	"(0174, 'b13', 'I feel optimistic about my future'),",
	"(0175, 'b14', 'My self-dialogue is loving and supportive'),",
	"(0176, 'b15', 'My short term memory is good'),",
	"(0177, 'c00', 'I am able to laugh easily'),",
	"(0178, 'c01', 'I have healthy emotional responses to every day living'),",
	"(0179, 'c02', 'I feel comfortable in my own body'),",
	"(0180, 'c03', 'I take time for myself each day'),",
	"(0180, 'c04', 'I have enough energy to accomplish what I plan each day'),",
	"(0181, 'c05', 'I show affection easily'),",
	"(0182, 'c06', 'I am slow to anger'),",
	"(0183, 'c07', 'I feel emotionally stable'),",
	"(0184, 'c08', 'I am actively engaged in an activity that brings me joy'),",
	"(0185, 'c09', 'I consider myself to be a positive person'),",
	"(0186, 'c10', 'I can self regulate my emotions when I feel like I am over-reacting'),",
	"(0187, 'c11', 'I feel good about myself'),",
	"(0188, 'c12', 'I feel confident in my ability to manage stress'),",
	"(0189, 'd00', 'I am able to fulfill my work obligations'),",
	"(0190, 'd01', 'I enjoy my family life'),",
	"(0191, 'd02', 'I am able to fulfill my family obligations'),",
	"(0192, 'd03', 'I enjoy spontaneous activities'),",
	"(0193, 'd04', 'I have a strong social network I can call on when I feel unhappy or down'),",
	"(0194, 'd05', 'I can freely get around in my community without incurring health issues'),",
	"(0195, 'd06', 'I am able to participate in community events, art, theatre, etc.'),",
	"(0196, 'd07', 'I am physically able to travel with ease'),",
	"(0197, 'd08', 'I feel at ease in most environments'),",
	"(0198, 'd09', 'I enjoy social outings with my friends'),",
	"(0199, 'd10', 'I feel supported and understood by my family and friends'),",
	"(0200, 'd11', 'I enjoy shopping for new or used clothes'),",
	"(0201, 'd12', 'I like dining out with my friends or family'),",
	"(0202, 'd13', 'I can comfortably be around new furniture'),",
	"(0203, 'd14', 'I am comfortable and relaxed in my own home'),",
	"(0204, 'd15', 'I use the computer and other electronic devices with comfort'),",
	"(0205, 'd16', 'I am able to handle and read newsprint media'),",
	"(0206, 'd17', 'I am physically comfortable in an office environment'),",
	"(0207, 'd18', 'I enjoy having friends and family in my home'),",
	"(0209, 'd19', 'I am able to use wireless devices when necessary');",
	"(0134, 'q1', 'Are you practicing for an hour a day?'),"
);

// echo "<ol>";
for($n=0;$n<count($questions);$n++){
	$q = substr($questions[$n],6);
	$q = substr($q,0,-1);
	// echo "INSERT INTO `q3` (`QID`,`question`) VALUES (".$q.";<br/>";
	// echo "<li>".$questions[$n]."</li>";
}
// echo "</ol>";
*/

global $conn;

// $cities_q = "SELECT DISTINCT(city),country_code FROM users WHERE country_code='US';";
// $cities_r = mysql_query($cities_q) or die(mysql_error());
// while($row = mysql_fetch_array($cities_r)) {
// 	if($row['city']!=""){
// 		$city_disp = ucwords(strtolower($row['city']));
// 		echo "<li>".urlencode($row['city'])."</li>";
// 		// echo ($row['city']=="SAN FRANSISCO") ? " selected" : "";
// 		// echo ">".$city_disp."</option>";
// 		// echo "\n<input type=\"hidden\" name=\"country_code\" value=\"".$row['code']."\">";
// 	}
// }

$location = "Vancouver, BC, Canada";
// $location = (get_magic_quotes_gpc()) ? $responce['location'] : addslashes($responce['location']) ;
$city = strstr($location,",",true);
$country_name = trim(substr(strrchr($location, ", "), 1));
// $country_name = trim($country_name);
$query = "SELECT code FROM countries WHERE name='".$country_name."'";
$result = mysql_query($query) or die(mysql_error());
while ($row = mysql_fetch_array($result)){
	$country_code = $row[0];
}
var_dump($city);
var_dump($country_name);
var_dump($country_code);

// $str = "('','0020','2012-11-14','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');";
// echo substr_count($str,"'0'");


// $name = explode(" ",$_GET['name']);
// $firstname = $name[0];
// $lastname = $name[1];
// 
// echo "<li>First: ".$firstname."</li><li>Last: ".$lastname."</li>";

// $headings = array("a","b","c","d");
// $num_q = array("a"=>"26","b"=>"15","c"=>"12","d"=>"19");
// 
// $sections = array();
// foreach($headings as $h){
// 	$sections[$h] = $num_q[$h] * 4;
// }
// 
// // $sections = array("a" => 156, "b" => 90, "c" => 78, "d" => 114);
// print_r($sections);

// $query = "SELECT * FROM responses ORDER BY ID DESC LIMIT 1";
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
// 	// echo "Section ".$section.": Total (".$total[$section].") Max (".$max.") Score (".$score[$section].") Percentage (".$perc[$section]."%)<br/>";
// }
// 
// $query = "INSERT INTO summary SET `uid`='$uid', `date`='$date', `sid`='$sid', `a_raw`='{$total["a"]}', `b_raw`='{$total["b"]}', `c_raw`='{$total["c"]}', `d_raw`='{$total["d"]}', `a_percent`='{$perc["a"]}', `b_percent`='{$perc["b"]}', `c_percent`='{$perc["c"]}', `d_percent`='{$perc["d"]}'";
// $result = mysql_query($query) or die(mysql_error());
// print $result;


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