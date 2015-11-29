<?PHP
	$username = $_COOKIE['active_user'];
	$cookie_key = "active_user";
	
	unset($_COOKIE[$cookie_key]);
	setcookie($cookie_key, '', time() - 3600);

	header('Location: sign_in_admin.php');
?>