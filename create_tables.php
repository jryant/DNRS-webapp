<?php

// print "INSERT INTO `questions` (<br/>";
// print "`ID` INT( 4 ) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY ,<br/>";
$questions = array(
	"a" => $questions_a = array(
	"I feel rested when I wake up in the morning",

	"I drink no beverages with caffeine or less than 2 servings per day",
	"I spend 30 minutes at least 3 times each week in moderate activity such as walking, biking, swimming",
	"I have a normal and healthy sense of taste",
	"I eat a well-balanced and nutritious diet",

	"I get at least seven hours sleep each night",
	"I am satisfied with my health status",

	"I drink at least 8 glasses of water each day",



	"I fall asleep easily",
	"My hands and feet are warm at room temperature",




	"My balance is good",





	"I experience skin-to-skin contact with another person or pet",
	"My body feels relaxed and at ease",
	"I am happy with my energy levels",
	"I am able to comfortably participate in activities that require moderate physical exertion",



	"I comfortably do what I want to and when",
	"I can do as much work as I want to",
	"I can look after myself and my personal needs",


	"I have a healthy body temperature",
	"My skin color is even and consistent",

	"My digestive system is healthy and strong",

	"My sense of smell is healthy and normal",
	"My heart feels strong and healthy",
	"I am able to take medication recommended by my doctor",
	"My immune system functions well",
	"I am comfortable and able to breathe deeply",

),

"b" => $questions_b = array(
	"I feel clear headed",
	"I am able to concentrate and focus",



	"I find it easy to make decisions",
	"I understand written instructions",
	"I am able to do simple math",
	"I learn new things easily",


	"I am totally able to care for myself",


	"I live in the present, instead of dwelling on the past or future",
	"I am able to manage my own finances",
	"I have goals that I actively pursue",

	"I am spontaneous and enjoy new adventures",
	"I feel capable of taking on new projects in life",
	"My thought patterns are generally positive in nature",
	"I feel optimistic about my future",
	"My self-dialogue is loving and supportive",

),

"c" => $questions_c = array(





	"I am able to laugh easily",
	"I allow myself to cry when appropriate",
	"I feel comfortable in my own body",

	"I take time for myself each day",



	"I have enough energy to accomplish what I plan each day",

	"I show affection easily",
	"I am slow to anger",

	"I feel emotionally stable",

	"I am actively engaged in an activity that brings me joy",

	"I am a positive person",
	"I can easily identify if I am over-reacting to a situation",


	"I feel good about myself",

	"I feel confident in my ability to manage stress"
),

"d" => $questions_d = array(

	"I am able to fulfill my work obligations",
	"I enjoy my family life",

	"I am able to fulfill my family obligations",

	"I enjoy spontaneous activities",




	"I have a strong social network I can call on when I feel unhappy or down",
	"I can freely get around in my community without incurring health issues",
	"I enjoy participating in community events, art, theatre, etc.",
	"I am able to travel with ease",

	"I feel at ease in most environments",
	"I enjoy social outings with my friends",
	"I feel supported and understood by my family and friends",



	"I enjoy shopping for new or used clothes",
	"I like dining out with my friends or family",
	"When needed I can purchase new furniture that I like",

	"I am comfortable and relaxed in my own home",

	"I use the computer and other electronic devices with comfort",
	"I am able to handle and read newsprint media",
	"I am comfortable in an office environment",
	"I enjoy having friends and family in my home"
)
);

// echo count($questions_c)."<br/>";

foreach($questions as $key => $section){
	echo $key." - ".count($section)."<br/>"; //." - Max: ".(count($section)*6)."<br/>";
	for($i=0;$i<count($section);$i++){
		$q = $i;
		if($i<10){
			$i = str_pad($i, 2, "0", STR_PAD_LEFT);
		}
		print "INSERT INTO `questions` (`QID`,`question`) VALUES ('$key$i','$section[$q]');<br/>";
	}
	print "<hr/>";
}

// print "`q1` INT( 1 ) NULL<br />";
// print ") ENGINE = MYSIAM ;"

	// print "CREATE TABLE  `healthsurvey`.`responses` (<br/>";
	// print "`ID` INT( 4 ) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY ,<br/>";
	// 
	// for($i=0;$i<=49;$i++){
	// 	if($i<10){
	// 		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	// 	}
	// 	print "`a$i` INT( 1 ) NULL ,<br/>";
	// }
	// 
	// for($i=0;$i<=24;$i++){
	// 	if($i<10){
	// 		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	// 	}
	// 	print "`b$i` INT( 1 ) NULL ,<br/>";
	// }
	// 
	// for($i=0;$i<=29;$i++){
	// 	if($i<10){
	// 		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	// 	}
	// 	print "`c$i` INT( 1 ) NULL ,<br/>";
	// }
	// 
	// for($i=0;$i<=31;$i++){
	// 	if($i<10){
	// 		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	// 	}
	// 	print "`d$i` INT( 1 ) NULL ,<br/>";
	// }
	// 
	// print "`q1` INT( 1 ) NULL<br />";
	// print ") ENGINE = MYSIAM ;"

?>

<!-- CREATE TABLE  `healthsurvey`.`responses` (
`ID` INT( 4 ) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`UID` INT( 4 ) NULL ,
`date` DATE NULL ,
`sid` VARCHAR( 255 ) NULL ,
`a_raw` VARCHAR( 255 ) NULL ,
`b_raw` VARCHAR( 255 ) NULL ,
`c_raw` VARCHAR( 255 ) NULL ,
`d_raw` VARCHAR( 255 ) NULL ,
`a_percent` VARCHAR( 255 ) NULL ,
`b_percent` VARCHAR( 255 ) NULL ,
`c_percent` VARCHAR( 255 ) NULL ,
`d_percent` VARCHAR( 255 ) NULL
) ENGINE = MYISAM ; -->