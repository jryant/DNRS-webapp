<?php
	// session_start();
	require_once('globals.php');
	require_once('functions.php');
	db_connect("localhost");

	$logged_in = checkLogin();

	$firephp->log($_SESSION, 'Session');
	$firephp->log($logged_in, '$logged_in');

	$page = (isset($_GET['p'])) ? $_GET['p'] : "home" ;

	switch($page){
		case 'logout':
			logout();
			die();
		break;
	}

	include('includes/header.php');

	echo "<div id=\"sidebar\">";
	draw_menu();
	echo "</div>";
	echo "<div id=\"banner\">
			<img src=\"http://www.dnrsystem.com/images/Dynamic_Neural_Retraining.jpg\" width=\"594\" height=\"200\" />
		</div>";
	echo ($page=="results" && $_SESSION['admin']) ? "<div id=\"content\" class=\"admin_results\">" : "<div id=\"content\">";
	displayMessages();
	if($logged_in){
		draw_page($page);
	}
	elseif($page=="register"){
		draw_page($page);
	}
	else {
		displayLogin();
	}
	echo "</div>";
?>

</div>
</body>
</html>