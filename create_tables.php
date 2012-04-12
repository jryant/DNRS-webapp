<?php

// print "INSERT INTO `questions` (<br/>";
// print "`ID` INT( 4 ) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY ,<br/>";

$questions_a = array(
	"I feel rested when I wake up in the morning",
	"I feel energetic, ready to take on tasks",
	"I drink no beverages with caffeine or less than 2 servings per day",
	"I spend 30 minutes at least 3 times each week in moderate activity such as walking, biking, swimming",
	"I have a normal and healthy sense of taste",
	"I eat a well-balanced and nutritious diet",
	"I am able to take the stairs instead of using elevators",
	"I get at least seven hours sleep each night",
	"I am satisfied with my health status",
	"I eat healthy snacks",
	"I drink at least 8 glasses of water each day",
	"I eat my meals in a relaxed environment",
	"I am aware of my unique nutritional needs and am able to eat accordingly",
	"I have a good appetite",
	"I fall asleep easily",
	"My hands and feet are warm at room temperature",
	"I experience good digestion",
	"I am satisfied with the sound, loudness and pitch of my voice",
	"I experience good vision (with corrective lenses)",
	"My eyes tear readily in response to stimuli",
	"My balance is good",
	"I am satisfied with my ability to hear (with corrective aids)",
	"I am able to distinguish scents",
	"I have good airflow through my nasal passages",
	"My nasal passages are clear and moist",
	"I am able to distinguish the four taste sensations: sweet, salty, sour, bitter",
	"I experience skin-to-skin contact with another person or pet",
	"My body feels relaxed and at ease",
	"I am happy with my energy levels",
	"I am able to comfortably participate in activities that require moderate physical exertion",
	"I feel that my drinking habits are within a normal healthy range",
	"My body feels comfortable",
	"I am satisfied with my level and quality of sexual activity",
	"I comfortably do what I want to and when",
	"I can do as much work as I want to",
	"I can look after myself and my personal needs",
	"I take care of my body in a healthy manner",
	"I take pride in my appearance",
	"I have a healthy body temperature",
	"My skin color is even and consistent",
	"My hair is healthy and plentiful",
	"My digestive system is healthy and strong",
	"My hearing is within a normal range",
	"My sense of smell is healthy and normal",
	"My heart feels strong and healthy",
	"My body easily accepts medications that are prescribed by my doctor",
	"My immune system functions well",
	"I am comfortable and able to breathe deeply",
	"My eyes adjust easily and I feel comfortable with changes in lighting"
);

$questions_b = array(
	"I feel clear headed",
	"I am able to concentrate and focus",
	"I am comfortable with silence",
	"I actively participate in my healing",
	"I fully engage in at least one activity or hobby where I lose all sense of time and self",
	"I find it easy to make decisions",
	"I understand written instructions",
	"I am able to do simple math",
	"I learn new things easily",
	"I appreciate the details when someone has made an effort to do something extra for me",
	"I learn from my experiences",
	"I am totally able to care for myself",
	"I choose the content of my thoughts",
	"I am able to access my intuition and creativity",
	"I live in the present, instead of dwelling on the past or future",
	"I am able to manage my own finances",
	"I have goals that I actively pursue",
	"I look forward to the future",
	"I am spontaneous and enjoy new adventures",
	"I feel capable of taking on new projects in life",
	"My thought patterns are generally positive in nature",
	"I feel optimistic about my future",
	"My self-dialogue is loving and supportive",
	"My thoughts are life-affirming"
);

$questions_c = array(
	"I feel happy",
	"I have a sense of humour",
	"I manage the stresses in my daily life",
	"I feel comfortable saying &quot;no&quot; to people",
	"I have at least three close friends",
	"I am able to laugh easily",
	"I allow myself to cry when appropriate",
	"I feel comfortable in my own body",
	"I feel calm and at peace",
	"I take time for myself each day",
	"I take time to celebrate at least one thing each day",
	"I take time to be thankful for one thing each day",
	"I am responsible for my own health and well-being",
	"I have enough energy to accomplish what I plan each day",
	"I am proud of myself and my achievements",
	"I show affection easily",
	"I am slow to anger",
	"I am interested to see what my future holds for me",
	"I feel emotionally stable",
	"I believe my response to stressful situations is healthy",
	"I am actively engaged in an activity that brings me joy",
	"I enjoy life",
	"I am a positive person",
	"I can easily identify if I am over-reacting to a situation",
	"I am peaceful and relaxed",
	"I trust the process of life",
	"I feel good about myself",
	"I enjoy my activities of daily living",
	"I feel confident in my ability to manage stress"
);

$questions_d = array(
	"I am an interesting person to be with",
	"I am able to fulfill my work obligations",
	"I enjoy my family life",
	"I get along with my co-workers and/or clients",
	"I am able to fulfill my family obligations",
	"I regularly spend time with friends",
	"I enjoy spontaneous activities",
	"I am truthful and direct in my communications",
	"I know my values and use these to set my priorities",
	"I am involved in performing service for others",
	"I experience myself as part of a larger community",
	"I have a strong social network I can call on when I feel unhappy or down",
	"I can freely get around in my community without incurring health issues",
	"I enjoy participating in community events, art, theatre, etc.",
	"I am able to travel with ease",
	"I am able to work as much as I want to",
	"I feel at ease in most environments",
	"I enjoy social outings with my friends",
	"I feel supported and understood by my family and friends",
	"I connect easily to other people",
	"My relationships with others are healthy and rewarding",
	"I feel confident in my ability to be a good friend",
	"I enjoy shopping for new or used clothes",
	"I like dining out with my friends or family",
	"When needed I can purchase new furniture that I like",
	"My conversations with others are life affirming",
	"I am comfortable and relaxed in my own home",
	"I often talk to friends on the phone",
	"I use the computer and other electronic devices with comfort",
	"I am able to handle and read newsprint media",
	"I am comfortable in an office environment"
);

// echo count($questions_c)."<br/>";

for($i=0;$i<49;$i++){
	$q = $i;
	if($i<10){
		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	}
	// print "INSERT INTO `questions` (`QID`,`question`) VALUES ('a$i','$questions_a[$q]');<br/>";
}

for($i=0;$i<24;$i++){
	$q = $i;
	if($i<10){
		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	}
	print "INSERT INTO `questions` (`QID`,`question`) VALUES ('b$i','$questions_b[$q]');<br/>";
}

for($i=0;$i<29;$i++){
	$q = $i;
	if($i<10){
		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	}
	print "INSERT INTO `questions` (`QID`,`question`) VALUES ('c$i','$questions_c[$q]');<br/>";
}

for($i=0;$i<31;$i++){
	$q = $i;
	if($i<10){
		$i = str_pad($i, 2, "0", STR_PAD_LEFT);
	}
	print "INSERT INTO `questions` (`QID`,`question`) VALUES ('d$i','$questions_d[$q]');<br/>";
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
