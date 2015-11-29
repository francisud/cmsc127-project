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
	
	$sql = " INSERT INTO users (user_email, user_name, username, password) values ('$email', '$name','$username', '$password') ";
	$ret = pg_query($db, $sql);

	if(!$ret){
		echo '<script type="text/javascript">'; 
		echo 'alert("Username is Already Used");'; 
		echo 'window.location.href = "sign_up.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Signed Up, Please Wait For Admin Approval");'; 
		echo 'window.location.href = "sign_in.php";';
		echo '</script>';
	}
?>