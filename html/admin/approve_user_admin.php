<?php
	include('check_admin.php');
	$username = $_POST['username'];
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	
	$sql = " UPDATE users 
				SET is_pending = 'false' , date_approved = now() 
				where username = '$username' ";
	$ret = pg_query($db, $sql);
?>