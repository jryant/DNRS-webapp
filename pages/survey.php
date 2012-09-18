<h2>Wellness Survey</h2>

<?php

$headings = array("a","b","c","d");

if(isset($_GET['a'])){ // Process survey responce
	$responce = $_POST;
	
	// print_r($responce); // debug
	// die();
		
	if (isset($responce['date'])){
		$date = $responce['date'];
		unset($responce['date']);
	}
	
	if (isset($responce['gender'])){
		$gender = $responce['gender'];
		unset($responce['gender']);
	}
	
	if (isset($responce['age'])){
		$age = $responce['age'];
		unset($responce['age']);
	}
	
	unset($responce['submit']);
	
	if(isset($responce['q1'])){
		$q1 = $responce['q1'];
		unset($responce['q1']);
	}

	// var_dump($responce['cond-m']);
	// var_dump($responce['cond-s']);
	// die();
	$cond_m = ""; //"YES - ".$n;
	if (isset($responce['cond-m']) && $responce['cond-m']!=""){
		foreach($responce['cond-m'] as $key=>$val){
			$cond_m .= $val.", ";
		}
		$cond_ms = substr($cond_m, 0, -2);
		// $cond_m[] = (get_magic_quotes_gpc()) ? $responce['cond-m'] : addslashes($responce['cond-m']) ;
		unset($responce['cond-m']);
	}
	// if (isset($responce['cond-m_other']) && $responce['cond-m_other']!=""){
	// 	$cond_m[] = (get_magic_quotes_gpc()) ? $responce['cond-m_other'] : addslashes($responce['cond-m_other']) ;
	// 	unset($responce['cond-m_other']);
	// }
	
	if (isset($responce['cond-s']) && $responce['cond-s']!=""){
		$cond_s = (get_magic_quotes_gpc()) ? $responce['cond-s'] : addslashes($responce['cond-s']) ;
		unset($responce['cond-s']);
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
	
	if (isset($responce['start']) && $responce['start']=="Not Started"){
		$responce['program_start_date'] = "Not Started";
	}	
	unset($responce['start']);
		
	if(isset($responce['program_start_date'])){
		$program_start_date = $responce['program_start_date'];
		unset($responce['program_start_date']);
	}
	// print_r($responce);
	// die();
		
	/* UPDATE USER TABLE */
	$query = "UPDATE users SET ";	
	$query .= (isset($program_start_date)) ? "`program_start_date`='$program_start_date', " : "" ;
	if(isset($program_method)){
		$query .= "`program_method`='$program_method'";
		// $query .= ",`program_start_date`='$program_start_date'";
		$query .= ",`gender`='$gender'";
		$query .= ",`age`='$age'";
		$query .= ",`cond1`='".$cond_ms."'";
		$query .= ",`cond2`='".$cond_s."'";
		// $query .= (isset($cond[3])) ? ",`cond3`='".$cond[3]."'" : ",`cond3`=NULL" ;
		$query .= ",`referral`='$referral',";
	}

	$next_survey = date("Y-m-d",strtotime(date("Y-m-d", strtotime($date)) . " +1 months"));
	// echo $next_survey;
	$query .= "`last_survey`='$date',`next_survey`='$next_survey'";
	$query .= " WHERE ID='{$_SESSION['uid']}'";
	// echo "<hr/>".$query."<br/>"; die();
	$result = mysql_query($query) or die("Error updating user table: ".mysql_error());
	
	/* UPDATE RESPONSES TABLE */	
	$query = "INSERT INTO responses "; //(uid,date";
	
	$num_q = array("a"=>"26","b"=>"15","c"=>"12","d"=>"19");
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
	
	// var_dump($query);
	$result = mysql_query($query) or die("Error updating responses table: ".mysql_error());

	/* UPDATE SUMMARY TABLE */
	// $response_id = "0014";

	// $query = "SELECT * FROM responses WHERE ID = '$response_id'";
	$query = "SELECT * FROM responses ORDER BY ID DESC LIMIT 1";
	$result = mysql_query($query) or die(mysql_error());
	$response = mysql_fetch_array($result);

	$uid = $response['uid']; // user ID
	$date = $response['date']; // surveyed date
	$sid = $response['ID']; // responses ID
	
	$sections = array();
	foreach($headings as $h){
		$sections[$h] = $num_q[$h] * 4;
	}
	
	// $sections = array("a" => 156, "b" => 90, "c" => 78, "d" => 114); // nuke
	foreach($sections as $section => $max){
		$total[$section] = 0;
		foreach($response as $q => $a){
			if(strpos($q, $section) === 0 && $q != "date"){
				// print $a;
				$total[$section] = $total[$section] + $a;
			}
		}
		// echo "<br/>";
		// $score[$section] = $max - $total[$section]; // old method
		$score[$section] = $total[$section]; // new method
		$perc[$section] = round($score[$section] / $max, 2)*100;
		// echo "Section ".$section.": Total (".$total[$section].") Max (".$max.") Score (".$score[$section].") Percentage (".$perc[$section]."%)<br/>";
	}

	$query = "INSERT INTO summary SET `uid`='$uid', `date`='$date', `sid`='$sid', `a_raw`='{$total["a"]}', `b_raw`='{$total["b"]}', `c_raw`='{$total["c"]}', `d_raw`='{$total["d"]}', `a_percent`='{$perc["a"]}', `b_percent`='{$perc["b"]}', `c_percent`='{$perc["c"]}', `d_percent`='{$perc["d"]}'";
	$result = mysql_query($query) or die(mysql_error());
	// print $result;
	
	/* FINISHED UPDATING TABLES */
	if($result){
		echo "<p>Thank you for taking the time to fill out the survey.<br/>Know that your efforts are assisting us in helping others.</p>\n
		<p>Yours in Good Health,<br/>The DNRS Team</p>";
	}
	// var_dump($result); // debug
}




else{ // Display survey form
	$qPerPage = 9;
	echo "<div id=\"survey\">";
	$result = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='{$_SESSION['uid']}'"));
	if($result['last_survey']){
		// echo "<p>Last survey date: ".$result['last_survey']."</p>";
		// echo "<p>Next survey date: ".$result['next_survey']."</p>";
	}



	$first_survey = false;
	$result = mysql_query("SELECT `date` FROM responses WHERE uid='{$_SESSION['uid']}'");
	if(!$result || (mysql_numrows($result) < 1)){
		$first_survey = true;
	}
	
	$result = mysql_query("SELECT * FROM questions WHERE QID!='q1'");
	$page = 1;
	$pagetot = floor(mysql_num_rows($result)/$qPerPage+1);
		
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
		
		echo "<div class=\"cond\" id=\"cond-m\">
			<ul>
				<li>What are the conditions are you recovering from? <span class=\"ans\"></span></li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Chemical Sensitivities\"> Chemical Sensitivities</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Chronic Fatigue Syndrome\"> Chronic Fatigue Syndrome</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Fibromyalgia\"> Fibromyalgia</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Electric Hypersensitivity Syndrome\"> Electric Hypersensitivity Syndrome</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Anxiety\"> Anxiety</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" value=\"Food Sensitivities\"> Food Sensitivities</li>
				<li><input onChange=\"checkInput('cond-m');\" type=\"checkbox\" name=\"cond-m[]\" id=\"cond-m_other_chk\" value=\"\" class=\"other\"> Other <input type=\"text\" id=\"cond-m_other\"></li>
			</ul>
		</div>\n";
		
		echo "<div class=\"cond\" id=\"cond-s\">
			<ul>
				<li>What is the most severe condition are you recovering from? <span class=\"ans\"></span></li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Chemical Sensitivities\"> Chemical Sensitivities</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Chronic Fatigue Syndrome\"> Chronic Fatigue Syndrome</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Fibromyalgia\"> Fibromyalgia</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Electric Hypersensitivity Syndrome\"> Electric Hypersensitivity Syndrome</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Anxiety\"> Anxiety</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" value=\"Food Sensitivities\"> Food Sensitivities</li>
				<li><input onChange=\"checkInput('cond-s');\" type=\"radio\" name=\"cond-s\" id=\"cond-s_other_radio\" class=\"other\"> Other <input type=\"text\" id=\"cond-s_other\" disabled></li>
			</ul>
		</div>\n";
				
		echo "<div id=\"referral\">
	<ul>
		<li>How did you hear about the Dynamic Neural Retraining System? <span class=\"ans\"></span></li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Internet search\"> Searching the internet</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Word of mouth\"> Word of mouth</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Online support group\"> Online support group</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Family doctor\"> Family doctor</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Naturopath\"> Naturopath</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Environmental doctor\"> Environmental doctor</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Other alternative medical practitioner\"> Other alternative medical practitioner</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Newspaper\"> Newspaper</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Television\"> Television</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Radio\"> Radio</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" value=\"Planet Thrive\"> Planet Thrive</li>
			<li><input onChange=\"checkInput('referral');\" type=\"radio\" name=\"referral\" class=\"other\"> Other <input type=\"text\" name=\"referral_other\" value=\"\" disabled></li>
		</ul>
	</div>
	";
		echo "<ul class=\"pre_survey\">
			<li id=\"gender\">Please select your gender
				<input onChange=\"checkInput('gender');\" type=\"radio\" name=\"gender\" value=\"M\" /> Male
				<input onChange=\"checkInput('gender');\" type=\"radio\" name=\"gender\" value=\"F\" /> Female
			</li>
			<li id=\"age\">How old were you when you began the program? <input onKeyDown=\"checkInput('age');\" name=\"age\" type=\"text\" maxlength=\"3\" size=\"3\" /></li>
			<li id=\"program_method\">In what format are you taking the program?
				<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" value=\"In Person\" /> In Person
				<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" value=\"DVD\" /> DVD
				<input onChange=\"checkInput('program_method');\" type=\"radio\" name=\"program_method\" value=\"Both\" /> Both
			</li>
			<li>Today's date is ".date('Y-m-d')."</li>
			<li><input type=\"hidden\" name=\"program_start_date\" value=\"".date('Y-m-d')."\" /></li>
		</ul>"; // id=\"program_start_date\" 
	}
	else { // Display subsequent survey question
		$result = mysql_query("SELECT * FROM questions WHERE QID='q1'");
		$q1 = mysql_fetch_array($result);
		
		$dresult = mysql_query("SELECT program_start_date FROM users WHERE ID='{$_SESSION['uid']}'");
		$date = mysql_fetch_array($dresult);
		
		if(!$date || $date[0]=="0000-00-00"){
			$not_started = "checked";
			$started = "";
			$nice_date = "";
		} else {
			$not_started = "";
			$started = "checked";
			$nice_date = $date[0];
		}
		
		echo "<div class=\"section follow_up p".$page."\">";
		showMessageBlock($page);
		echo "<div class=\"guide\">\n<p class=\"term\">Pre-Survey Questions</p></div>";
		// echo "<span class=\"heading\">Pre-Survey Questions</span>\n";
		echo "<ul class=\"pre_survey\">
			<li>Please select:
				<ul>
					<li><input type=\"radio\" name=\"start\" value=\"Not Started\" ".$not_started." /> I have not started the program yet.</li>
					<li><input type=\"radio\" name=\"start\" value=\"Started\" ".$started." /> I started the program on <input type=\"text\" id=\"program_start_date\" name=\"program_start_date\" value=\"".$nice_date."\"></li>
				</ul>
			</li>
			<li>Are you practicing the Limbic System Retraining Steps for an hour a day? <br />
				<span id=\"practicing\">
					<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"1\" />Yes
					<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"0\" />No
				</span>
			</li>
			<div class=\"clearme\"></div>
		</ul>";

		/*echo "<p>".$q1[2]."</p>
		<p id=\"practicing\">
			<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"0\" />No
			<input onChange=\"checkInput('practicing');\" type=\"radio\" name=\"".$q1[1]."\" value=\"1\" />Yes
		</p>";*/
	}
		
	echo section_navi($page,$pagetot,true,false);
	echo "</div>\n";
	$page++;	
	// End pre-survey questions
	
	$result = mysql_query("SELECT * FROM questions WHERE QID!='q1'");
	// $page = 1;
	// $pagetot = floor(mysql_num_rows($result)/11-1);
	
	foreach($headings as $heading){
		$head = 'heading_'.$heading;
		$$head = false;
		// var_dump($$head);
	}
	
	while($question = mysql_fetch_array($result)){ // Loop through db for questions	
		
		foreach($headings as $heading){ // Display section headings
			$h = 0;
			$head = 'heading_'.$heading;
			if(strstr($question[1],$heading) && !$$head){
				$q=1;
				// var_dump($head);
				if ($head!="heading_a"){ // End the page for all subsequent sections
					echo section_navi($page,$pagetot,false,false);
					echo "</div>\n"; // .section
					$page++;					
				}
				echo "<div class=\"section p".$page."\">\n"; // Begin new survey "page"
				showMessageBlock($page);
				sectionHeading($heading,$page);
				$$head = true;
			}	
		}
		// Display each question
		if($q%($qPerPage+1)==0){ // Determines number of questions (+1) per "page"
			echo section_navi($page,$pagetot,false,false);
			$page++;
			echo "</div>\n<div class=\"section p".$page."\">\n"; // Begin new survey "page"
			showMessageBlock($page);
			sectionHeading("cont",$page);
			// echo getScale();
		}
		echo "<div class=\"qline\" id=\"".$question[1]."\">\n";
		echo "<span class=\"radios\">\n";
		global $tooltips;
		for($n=1;$n<=6;$n++){
			$v = $n-1;
			echo "<input type=\"radio\" onChange=\"checkInput('".$question[1]."');\" name=\"".$question[1]."\"";
			if ($n==6){	
				echo " title=\"N/A - ".$tooltips[$n]."\" value=\"0\" />";
			} else {
				echo " title=\"".$n." - ".$tooltips[$n]."\" value=\"$v\"/>";
			}
		}
		echo "</span>\n";
		echo "<span class=\"question\">\n";
		echo "<span class=\"num\">".$q.".</span>\n";
		echo $question[2]."</span>\n";
		echo "</div>\n";
	
		$q++;
	} // End questions db loop
	echo section_navi($page,$pagetot,false,true);
	echo "</form>\n";
	echo "</div>\n"; // .section
	echo "</div>\n"; // #survey
}
?>