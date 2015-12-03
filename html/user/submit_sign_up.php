<?php
	$email = $_POST['email'];
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	$sql = " INSERT INTO users (user_email, user_name, username, password) values ($1, $2, $3, $4) ";
	
	
	$result = pg_prepare($db, 'new_user', $sql);
	$result = pg_execute($db, 'new_user', array($email, $name, $username, $password));

	if(!$result){
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Sign Up");'; 
		echo 'window.location.href = "sign_up.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Signed Up, Please Wait For Admin Approval");'; 
		echo 'window.location.href = "sign_in.php";';
		echo '</script>';
	}
?>