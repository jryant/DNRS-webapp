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
			// $date_joined = strftime("%b %d, %Y", strtotime($date_joined));
		}
	}
	$output = "<ul id=\"profile\">
		<li class=\"name\">Name: <span class=\"response\">$name</span></li>
		<li class=\"email\">Email: <span class=\"response\">$email</span></li>
		<li class=\"date_joined\">Date joined: <span class=\"response\">$date_joined</span></li>
	</ul>";
	echo $output;
}

?>

<script type="text/javascript" charset="utf-8">
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

<h2>My Profile</h2>

<?php displayProfile(); ?>
<form onsubmit="editProfile();return false;" id="profileForm">
	<input name="editSubmit" type="submit" class="editSubmit" value="Edit Profile" /><span id="busy"><img src="img/ajax-loader.gif"/></span>
</form>
<!-- <p><span class="edit"><a href="#">Edit profile</a></span> | <a href="index.php?p=profile&a=pwreset">Change password</a></p> -->