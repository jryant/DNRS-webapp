<?php

if($_SESSION['admin']==0){ // User screen
	echo "<h2>Survey Results</h2>";
	$query = "SELECT * FROM summary WHERE uid={$_SESSION['uid']} ORDER BY `date`";
	$result = mysql_query($query) or die(mysql_error());
	// var_dump($result);

	$first_survey = false;
	if(!$result || (mysql_numrows($result) < 1)){
		$first_survey = true;
	}

	if($first_survey){
		echo "<p>You have not taken the survey yet.</p>";
	}
	else {
		echo "<table class=\"results\"><tr>";
		echo "<td>Date</td>";
		echo "<td>Section A</td>";
		echo "<td>Section B</td>";
		echo "<td>Section C</td>";
		echo "<td>Section D</td>";
		echo "</tr>";

		while($summary = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>".$summary['date']."</td>";
			echo "<td>".$summary['a_raw']." / ".$summary['a_percent']."%</td>";
			echo "<td>".$summary['b_raw']." / ".$summary['b_percent']."%</td>";
			echo "<td>".$summary['c_raw']." / ".$summary['c_percent']."%</td>";
			echo "<td>".$summary['d_raw']." / ".$summary['d_percent']."%</td>";
			echo "</tr>";
		}

		echo "</table>";
	}
}
else { // Admin screen
	$orderby = (isset($_GET['orderby'])) ? $_GET['orderby'] : "" ;
	$order = (isset($_GET['order'])) ? mysql_real_escape_string($_GET['order']) : "ASC" ;
	$view = (isset($_GET['view'])) ? $_GET['view'] : "" ;
	$sid = (isset($_GET['sid'])) ? mysql_real_escape_string($_GET['sid']) : "" ;
	$uid = (isset($_GET['uid'])) ? mysql_real_escape_string($_GET['uid']) : "" ;
	$pm_raw = (isset($_GET['program_method'])) ? mysql_real_escape_string($_GET['program_method']) : "" ;
	if(isset($pm_raw)){
		switch($pm_raw){
			case 'in_person':
				$program_method = "In Person";
				break;
			case 'dvd':
				$program_method = "DVD";
				break;
			case 'both':
				$program_method = "Both";
				break;
			default:
				$program_method = "";
		}
	}
	
	$conds_name = array("Chemical Sensitivities", "Chronic Fatigue Syndrome", "Fibromyalgia", "Electric Hypersensitivity Syndrome", "Anxiety", "Food Sensitivities");
	$conds_raw = array();
	$conds_query = "(";
	if (isset($_GET['cond'])){
		$cond = $_GET['cond'];
		if(!empty($cond)){
			$c = count($cond);
			for($i=0; $i < $c; $i++){
				$conds_raw[] = $cond[$i];
				$conds_query .= ($i!=0) ? "," : "" ;
				$conds_query .= "\"".$conds_name[$cond[$i]]."\"";
			}
		}
	}
	$conds_query .= ")";

	// echo $_SERVER['QUERY_STRING'];
	// echo "<br/>";
	// var_dump($conds_query);
	// echo "<br/>";
		
	if($view=="detail" && $sid){ // Survey results detail view
		
		$headings = array("a","b","c","d");
		foreach($headings as $heading){
			$head = 'heading_'.$heading;
			$$head = false;
		}
		
		$questions = mysql_query("SELECT * FROM questions WHERE QID!='q1'");
		$response = mysql_fetch_array(mysql_query("SELECT * FROM responses WHERE ID='$sid'"));
		$user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE ID='".$response['uid']."'"));
		
		echo "<h2>Survey Results &mdash; Detailed Results</h2>";
		echo "<span class=\"heading\">User Information</span>";
		echo "<p>Name: <span class=\"response\">".$user['first_name']." ".$user['last_name']."</span>";
		echo "<br/>Survey date: <span class=\"response\">".$response['date']."</span>";

		$q1q = mysql_fetch_array(mysql_query("SELECT question FROM questions WHERE QID='q1'"));
		$q1r = mysql_fetch_array(mysql_query("SELECT q1 FROM responses WHERE ID='$sid'"));
		switch ($q1r[0]){
			case '0':
				echo "<br/>".$q1q[0]." <span class=\"response\">No</span>";
				break;
			case '1':
				echo "<br/>".$q1q[0]." <span class=\"response\">Yes</span>";
				break;
			default:
				echo "<br/><span class=\"response\">First survey</span>";
				break;
		}
		echo "</p>";
		
		while($question = mysql_fetch_array($questions)){
			foreach($headings as $heading){ // Display section headings
				$head = 'heading_'.$heading;
				if(strstr($question[1],$heading) && !$$head){
					$q=1;
					echo "<span class=\"heading\">Section $heading</span>";
					$$head = true;
				}	
			}
			$r = ($response[$question[1]]==6) ? "N/A" : $response[$question[1]] ;
			echo "<p><span class=\"num\">".$q.".</span>";
			echo "<span class=\"response\"> (".$r.")</span> ";
			echo $question[2];
			echo "</p>";
			$q++;
		}		
		
		// $query = "SELECT * FROM responses r
		// -- INNER JOIN questions q
		// WHERE ID='$id'";
		// 
		// $result = mysql_query($query) or die(mysql_error());
		// while ($response = mysql_fetch_array($result)){
		// 	foreach($response as $q => $a){
		// 		echo $q." - ".$a."<br/>";
		// 	}
	}
	else {
		$query = "SELECT *
		FROM summary s
		INNER JOIN users u
		ON s.uid = u.ID";
		if($uid){
			$query .= " WHERE s.uid='".$uid."'";
		}
		else {
			$query .= (isset($program_method) && $program_method!="") ? " WHERE (u.program_method='".$program_method."')" : "" ;
			$query .= (!empty($conds_raw)) ? " AND (u.cond1 IN ".$conds_query." OR u.cond2 IN ".$conds_query." OR u.cond3 IN ".$conds_query.")" : "" ;
		}
		$query .= ($orderby) ? " ORDER BY s.$orderby $order" : "" ;
		
		$result = mysql_query($query) or die(mysql_error());
		// var_dump($pm_raw);
		echo "<h2>Survey Results &mdash; Summmaries <span class=\"reset\">(<a href=\"index.php?p=results\">Reset All Filters</a>)</span></h2>";

		echo "<div class=\"cond_res\"><ul>";
		echo "Narrow results by condition:<br/><form action=\"index.php\" method=\"get\">";
		foreach($conds_name as $key => $value){
			echo ($key==0) ? "<div class=\"col2\">" : "" ;
			echo "<li><input type=\"checkbox\" name=\"cond[]\" value=\"".$key."\" onchange=\"form.submit()\"";
			echo ($uid) ? " disabled" : "" ;
			echo (!empty($conds_raw) && in_array($key,$conds_raw)) ? " checked" : "" ;
			echo " /> ".$value."</li>";
			echo ($key==2) ? "</div>" : "" ;
		}
		echo "</ul>";
		echo "<input type=\"hidden\" name=\"p\" value=\"results\">";
		echo ($orderby) ? "<input type=\"hidden\" name=\"orderby\" value=\"".$orderby."\">" : "" ;
		echo ($order) ? "<input type=\"hidden\" name=\"order\" value=\"".$order."\">" : "" ;
		echo (isset($pm_raw) && $pm_raw!="") ? "<input type=\"hidden\" name=\"program_method\" value=\"".$pm_raw."\">" : "" ;
		echo ($uid) ? "<input type=\"hidden\" name=\"uid\" value=\"".$uid."\">" : "" ;
		echo "</form>
			<div class=\"clearme\"></div>
		</div>";

		echo "<table class=\"results\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
		echo "<td>Name</td>";
		echo "<td>Program Method
		<br/>Limit to<form action=\"index.php\" method=\"get\">
			<select name=\"program_method\" id=\"program_method\" onchange=\"form.submit()\"";
		echo ($uid) ? " disabled" : "" ;
		echo ">
				<option value=\"\"";
		echo (!isset($pm_raw)) ? " selected" : "" ;
		echo ">All</option>
				<option value=\"in_person\"";
		echo (isset($pm_raw) && $pm_raw=="in_person") ? " selected" : "" ;
		echo ">In Person</option>
				<option value=\"dvd\"";
		echo (isset($pm_raw) && $pm_raw=="dvd") ? " selected" : "" ;
		echo ">DVD</option>
				<option value=\"both\"";
		echo (isset($pm_raw) && $pm_raw=="both") ? " selected" : "" ;
		echo ">Both</option>
			<input type=\"hidden\" name=\"p\" value=\"results\">
			";
		echo ($orderby) ? "<input type=\"hidden\" name=\"orderby\" value=\"".$orderby."\">" : "" ;
		echo ($order) ? "<input type=\"hidden\" name=\"order\" value=\"".$order."\">" : "" ;
		if(!empty($conds_raw)){
			for($i=0; $i < count($conds_raw); $i++){
				echo "<input type=\"hidden\" name=\"cond[]\" value=\"".$conds_raw[$i]."\">";
			}
		}
		echo "</select>
		</form></td>";
		echo "<td><a href=\"index.php?p=results&orderby=date&order=";
		echo ($order=="ASC") ? "DESC" : "ASC" ;
		echo ($uid) ? "&uid=".$uid : "" ;
		echo (isset($pm_raw) && $pm_raw!="") ? "&program_method=".$pm_raw : "" ;
		if(!empty($conds_raw)){
			for($i=0; $i < count($conds_raw); $i++){
				echo "&cond[]=".$conds_raw[$i];
			}
		}
		echo "\">Date";
		if($order){
			echo "<span class=\"arrow ";
			echo ($order=="DESC") ? "down" : "up" ;
			echo "\"></span>";
		}
		echo "</a></td>";
		echo "<td>Condition #1</td>";
		echo "<td>Condition #2</td>";
		echo "<td>Condition #3</td>";
		echo "<td>Section A</td>";
		echo "<td>Section B</td>";
		echo "<td>Section C</td>";
		echo "<td>Section D</td>";
		echo "<td></td>";
		echo "</tr>";
		// var_dump($result);
		// while($summary = mysql_fetch_array($result)){
			
		$n = 0;
		if(!$result || (mysql_numrows($result) < 1)){
			echo "<tr class=\"odd\"><td colspan=\"10\">No results</td></tr>";
			// die(mysql_error());
		}
		while($summary = mysql_fetch_assoc($result)){
		
			// $uquery = "SELECT first_name,last_name FROM users WHERE ID='{$summary['uid']}'";
			// $users = mysql_query($uquery) or die(mysql_error());
			// $user = mysql_fetch_array($users);
			// var_dump($user);
			echo ($n %2 == 1) ? "<tr>" : "<tr class=\"odd\">" ;
			$n++;
			// echo "<td>".getName($summary['uid'])."</td>";
			echo "<td><a href=\"index.php?p=results&uid=".$summary['ID'];
			echo ($orderby) ? "&orderby=".$orderby : "" ;
			echo ($order) ? "&order=".$order : "" ;
			echo "\">".$summary['first_name']." ".$summary['last_name']."</a></td>";
			echo "<td>".$summary['program_method']."</td>";
			echo "<td>".$summary['date']."</td>";
			echo "<td>".$summary['cond1']."</td>";
			echo "<td>".$summary['cond2']."</td>";
			echo "<td>".$summary['cond3']."</td>";			
			echo "<td>".$summary['a_raw']."<br/>".$summary['a_percent']."%</td>";
			echo "<td>".$summary['b_raw']."<br/>".$summary['b_percent']."%</td>";
			echo "<td>".$summary['c_raw']."<br/>".$summary['c_percent']."%</td>";
			echo "<td>".$summary['d_raw']."<br/>".$summary['d_percent']."%</td>";
			echo "<td><a href=\"index.php?p=results&view=detail&sid=".$summary['sid']."\">Detail</a>";
			echo "</tr>";
	
			// mysql_free_result($users);	
		}
		echo "</table>";
	}
}
?>