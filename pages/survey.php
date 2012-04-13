<h2>Wellness Survey</h2>

<?php

if(isset($_GET['a'])){ // Process survey responce
	$responce = $_POST;
	$date = $responce['date'];
	unset($responce['date']);
	unset($responce['submit']);
	
	if(isset($responce['q1'])){
		$q1 = $responce['q1'];
		unset($responce['q1']);
	}

	$cond = array();
	for($n=1;$n<4;$n++){
		$cond[$n] = "YES - ".$n;
		if (isset($responce['cond'.$n.'_other']) && $responce['cond'.$n.'_other']!=""){
			$cond[$n] = (get_magic_quotes_gpc()) ? $responce['cond'.$n.'_other'] : addslashes($responce['cond'.$n.'_other']) ;
			unset($responce['cond'.$n.'_other']);
			unset($responce['cond'.$n]);
		}
		elseif (isset($responce['cond'.$n]) && $responce['cond'.$n]!=""){
			$cond[$n] = (get_magic_quotes_gpc()) ? $responce['cond'.$n] : addslashes($responce['cond'.$n]) ;
			unset($responce['cond'.$n]);
		}

	}

	if (isset($responce['referral_other'])){
		$referral = (get_magic_quotes_gpc()) ? $responce['referral_other'] : addslashes($responce['referral_other']) ;
		unset($responce['referral_other']);
		unset($responce['referral']);
	}
	elseif (isset($responce['referral'])){
		$referral = (get_magic_quotes_gpc()) ? $responce['referral'] : addslashes($responce['referral']) ;
		unset($responce['referral']);
	}
		
	if(isset($responce['program_method'])){
		$program_method = $responce['program_method'];
		unset($responce['program_method']);
	}
	if(isset($responce['program_start_date'])){
		$program_start_date = $responce['program_start_date'];
		unset($responce['program_start_date']);
	}
	// print_r($responce);
		
	/* UPDATE USER TABLE */
	$query = "UPDATE users SET ";	
	if(isset($program_method) && isset($program_start_date)){
		$query .= "`program_method`='$program_method'";
		$query .= ",`program_start_date`='$program_start_date'";
		$query .= ",`cond1`='".$cond[1]."'";
		$query .= (isset($cond[2])) ? ",`cond2`='".$cond[2]."'" : ",`cond2`=NULL" ;
		$query .= (isset($cond[3])) ? ",`cond3`='".$cond[3]."'" : ",`cond3`=NULL" ;
		$query .= ",`referral`='$referral',";
	}
	
	$next_survey = date("Y-m-d",strtotime(date("Y-m-d", strtotime($date)) . " +1 months"));
	// echo $next_survey;
	$query .= "`last_survey`='$date',`next_survey`='$next_survey'";
	$query .= " WHERE ID='{$_SESSION['uid']}'";
	// echo $query."<br/>";
	$result = mysql_query($query) or die("Error updating user table");
	
	/* UPDATE RESPONSES TABLE */	
	$query = "INSERT INTO responses "; //(uid,date";
	
	$num_q = array("a"=>"48","b"=>"23","c"=>"28","d"=>"30");
	foreach($num_q as $key => $value){
		for($i=0;$i<$value;$i++){
			if($i<10){
				$i = str_pad($i, 2, "0", STR_PAD_LEFT);
			}
			// $query .= ",".$key.$i;
		}
	}
		
	$query .= "VALUES (";
	$query .= "'',";
	$query .= "'".$_SESSION['uid']."'";
	$query .= ",'".$date."'";
	foreach($responce as $key => $value){
		// echo "<li>".$key." - ".$value."</li>";
		$query .= ",'".$value."'";
	}
	$query .= (isset($q1)) ? ",'".$q1."'" : ",NULL" ;
	$query .= ");";
	
	// echo $query."<br/>";
	$result = mysql_query($query) or die("Error updating responses table: ").mysql_error();

	/* UPDATE SUMMARY TABLE */
	// $response_id = "0014";

	// $query = "SELECT * FROM responses WHERE ID = '$response_id'";
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
	// print $result;
	
	/* FINISHED UPDATING TABLES */
	if($result){
		echo "Thank you for your survey";
	}
	// var_dump($result);
}




else{ // Display survey form
	echo "<div id=\"survey\">";
	$result = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='{$_SESSION['uid']}'"));
	if($result['last_survey']){
		// echo "<p>Last survey date: ".$result['last_survey']."</p>";
		// echo "<p>Next survey date: ".$result['next_survey']."</p>";
	}

	$headings = array("a","b","c","d");
	foreach($headings as $heading){
		$head = 'heading_'.$heading;
		$$head = false;
	}

	$first_survey = false;
	$result = mysql_query("SELECT `date` FROM responses WHERE uid='{$_SESSION['uid']}'");
	if(!$result || (mysql_numrows($result) < 1)){
		$first_survey = true;
	}
	
	$result = mysql_query("SELECT * FROM questions WHERE QID!='q1'");
	$page = 1;
	$pagetot = floor(mysql_num_rows($result)/10+1);
		
	echo "<ul class=\"tabs\">";
	$pagetot++;
	for($p=1;$p<=$pagetot;$p++){
		echo "<li><a href=\"#\">Page $p</a></li>";
	}
	echo "</ul>";

	// echo "<div class=\"section\">"; // Begin new survey "page"
	echo "<form action=\"index.php?p=survey&a=submit\" name=\"survey\" method=\"post\">";
		
	if($first_survey){ //Display first survey questions
		echo "<div class=\"section pre_survey p".$page."\">";
		showMessageBlock($page);
		echo "<span class=\"heading\">Initial Questions</span>";
		
		$cond = array(
			1 => "is the <span class=\"cond_type\">most severe</span>",
			2 => "<span class=\"cond_type\">secondary</span>",
			3 => "<span class=\"cond_type\">tertiary</span>"
		);
		for($n=1;$n<=3;$n++){
			$s = $n + 1;
			echo "<div class=\"cond\" id=\"cond".$n."\">
				<ul>
					<li>What ".$cond[$n]." condition are you recovering from? <span class=\"ans\"></span></li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Chemical Sensitivities\"> Chemical Sensitivities</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Chronic Fatigue Syndrome\"> Chronic Fatigue Syndrome</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Fibromyalgia\"> Fibromyalgia</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Electric Hypersensitivity Syndrome\"> Electric Hypersensitivity Syndrome</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Anxiety\"> Anxiety</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" value=\"Food Sensitivities\"> Food Sensitivities</li>
					<li><input onChange=\"checkInput('cond".$n."');\" type=\"radio\" name=\"cond".$n."\" class=\"other\"> Other <input type=\"text\" name=\"cond".$n."_other\" value=\"\" disabled>";
			echo ($n!=3) ? " <a href=\"#\" onClick=\"cond_expand('cond".$s."');\" class=\"cond".$s."\">Add another condition?</a>" : "" ;
			echo "</li>
				</ul>
			</div>\n";
		}
		
		echo "<div id=\"referral\">
	<ul>
		<li>How did you hear about the Dynamic Neural Retraining System? <span class=\"ans\"></span></li>
			<li><inputt onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Internet search\"> Internet search</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Word of mouth\"> Word of mouth</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Online support group\"> Online support group</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Family doctor\"> Family doctor</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Naturopath\"> Naturopath</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Environmental doctor\"> Environmental doctor</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Other alternative medical practitioner\"> Other alternative medical practitioner</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Newspaper\"> Newspaper</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Television\"> Television</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Radio\"> Radio</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Radio\"> Planet Thrive</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" class=\"other\"> Other <input type=\"text\" name=\"referral_other\" value=\"\" disabled></li>
		</ul>
	</div>
	";
		echo "<ul class=\"pre_survey\">
		<li id=\"program_method\">In what format did you take the program?
			<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" name=\"program_method\" value=\"In Person\" /> In Person
			<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" value=\"DVD\" /> DVD
			<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" value=\"Both\" /> Both
		</li>\n";
		echo "<li>What date did you begin the program? ";
		echo "<input type=\"text\" id=\"program_start_date\" value=\"".date('Y-m-d')."\">";
		// <input type=\"date\" name=\"program_start_date\" id=\"program_start_date\" value=\"".date('Y-m-d')."\">
		echo "</li>
		</ul>";
	}
	else { // Display subsequent survey question
		$result = mysql_query("SELECT * FROM questions WHERE QID='q1'");
		$q1 = mysql_fetch_array($result);
		echo "<div class=\"section follow_up p".$page."\">";
		showMessageBlock($page);
		echo "<span class=\"heading\">Pre-Survey Questions</span>\n";
		echo "<li id=\"practicing\">".$q1[2]."
			<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"0\" />No
			<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"1\" />Yes
		</li>";
	}
	echo section_navi($page,$pagetot,true,false);
	$page++;
	echo "</div>\n";
	// echo "<div class=\"navi\"><span class=\"next\"><a href=\"#\">Next Page</a></button></div>"; // .navi
	// echo "</div>"; // .section

	$result = mysql_query("SELECT * FROM questions WHERE QID!='q1'");
	// $page = 1;
	// $pagetot = floor(mysql_num_rows($result)/11-1);
	while($question = mysql_fetch_array($result)){
		foreach($headings as $heading){ // Display section headings
			$head = 'heading_'.$heading;
			if(strstr($question[1],$heading) && !$$head){
				$q=1;
				// var_dump($head);
				if ($head!="heading_a"){
					echo section_navi($page,$pagetot,false,false);
					echo "</div>\n"; // .section
					$page++;					
				}
				echo "<div class=\"section p".$page."\">\n"; // Begin new survey "page"
				showMessageBlock($page);
				echo getScale();
				echo "<span class=\"heading\">Section $heading</span>\n";
				$$head = true;
			}	
		}
		// Display each question
		if($q%11==0){
			echo section_navi($page,$pagetot,false,false);
			$page++;
			echo "</div>\n<div class=\"section p".$page."\">\n"; // Begin new survey "page"
			showMessageBlock($page);
			echo getScale();
		}
		echo "<div class=\"qline\" id=\"".$question[1]."\">\n";
		echo "<span class=\"radios\">\n";
		for($n=0;$n<5;$n++){
			echo "<input type=\"radio\" onChange=\"checkInput('".$question[1]."');\" name=\"".$question[1]."\" value=\"$n\" />"; //validate=\"required:true\" class=\"required\"
			echo ($n==4) ? "N/A" : "$n" ;
		}
		echo "</span>\n";
		echo "<span class=\"question\">\n";
		echo "<span class=\"num\">".$q.".</span>\n";
		echo $question[2]."</span>\n";
		echo "</div>\n";
	
		$q++;
	}
	echo section_navi($page,$pagetot,false,true);
	echo "</form>\n";
	echo "</div>\n"; // .section
	echo "</div>\n"; // #survey
}
?>