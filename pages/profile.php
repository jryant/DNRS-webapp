<script type="text/javascript" charset="utf-8">
	function relAccount(action){
		console.log(action);
		if(action=="show"){
			$("#relAccount").slideDown();
		} else if(action=="do") {
			var username = <?php echo "\"".$_SESSION['username']."\";"; ?>
			var email = $('#email').val();
			$('#busy').css("visibility", "visible");
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: "action=relinquish&username="+username+"&email="+email,
				success: function(html){
					$('#busy').css("visibility", "hidden");
					console.log(html);
					if(html=="10"){
						window.location = "index.php?p=profile&msg=10";
					} else {
						// window.location = "index.php?p=profile&msg=8";
					}
				}
			});
		} else {
			console.log("error: no action specified for relAccount();");
		}
	}

	function editProfile(submit){
		if(submit=="submit"){ // add error checking
			var name = $('#name').val();
			var email = $('#email').val();
			$('#busy').css("visibility", "visible");
			$.ajax({
				url: "ajax.php",
				type: "POST",
				data: "action=editProfile&name="+name+"&email="+email,
				success: function(html){
					$('#busy').css("visibility", "hidden");
					if(html=="1"){
						window.location = "index.php?p=profile&msg=7";
					}else{
						window.location = "index.php?p=profile&msg=8";
					}
				}
			});
		} else {
			var name = $('#profile .name span').text();
			var email = $('#profile .email span').text();
			$('#profile .name').html('<input type="text" name="name" value="'+name+'" id="name">');
			$('#profile .email').html('<input type="text" name="email" value="'+email+'" id="email">');
			var form = '<input name="editSubmit" onclick="editProfile(\'submit\');return false;" type="submit" class="editSubmit" value="Submit" /><span id="busy"><img src="img/ajax-loader.gif"/></span></form>';
			$('#profileForm').html(form);
			// console.log(name + email);
		}
	}
</script>

<?php

function displayProfile(){
	if(isset($_SESSION['username'])){
		$user = $_SESSION['username'];
		$result = mysql_query("SELECT * FROM users WHERE username='$user'");
		if(!$result || (mysql_numrows($result) < 1)){
			die(mysql_error());
		}
		else{
			$dbarray = mysql_fetch_array($result);
			$name = $dbarray['first_name']." ".$dbarray['last_name'];
			$email = $dbarray['email'];
			$date_joined = niceDate($dbarray['date_joined']);
			$one_page = ($dbarray['managed']==0) ? FALSE : TRUE ;
			// $last_survey = niceDate($dbarray['final_remind']);
		}
	}
	
	echo ($one_page) ? "<p class=\"msg_warning\">This user account controlled is managed. <a href=\"#\" onclick=\"relAccount('show');\">Reliquish account to user.</a></p>" : "" ;
	echo "<form onsubmit=\"relAccount('do');return false;\" id=\"relAccount\" style=\"display:none;\">
	Email address: <input name=\"email\" id=\"email\" type=\"input\" /> <input name=\"editSubmit\" type=\"submit\" class=\"editSubmit\" value=\"Relinquish\" /><span id=\"busy\"><img src=\"img/ajax-loader.gif\"/></span>
</form>";
	$output = "<ul id=\"profile\">
		<li class=\"name\">Name: <span class=\"response\">$name</span></li>
		<li class=\"email\">Email: <span class=\"response\">$email</span></li>
		<li class=\"date_joined\">Date joined: <span class=\"response\">$date_joined</span></li>";
		/* <li>Final remind: <span class=\"response\">$final_remind</span></li> */
	$output .= "</ul>";
	echo $output;
}

?>

<h2>My Profile</h2>

<?php displayProfile(); ?>

<!-- <form onsubmit="editProfile();return false;" id="profileForm">
	<input name="editSubmit" type="submit" class="editSubmit" value="Edit Profile" /><span id="busy"><img src="img/ajax-loader.gif"/></span>
</form> -->
<!-- <p><span class="edit"><a href="#">Edit profile</a></span> | <a href="index.php?p=profile&a=pwreset">Change password</a></p> -->