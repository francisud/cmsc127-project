<?php
	include('check_user.php');
	$username = $_COOKIE['active_user'];

	$user_name = $_POST['user_name'];
	$user_email = $_POST['user_email'];
	$old_password = $_POST['old_password'];
	$new_password = $_POST['new_password'];
		
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   
	$sql = " SELECT * FROM users where username= $1 ";
	
	$result = pg_prepare($db, 'get_info', $sql);
	$result = pg_execute($db, 'get_info', array($username));
	
	
	$row = pg_fetch_row($result);
	
	if($old_password == $row[1]){
		$sql2 = " UPDATE users
					SET password = $1, user_name = $2, user_email = $3
					WHERE username = $4
					";
					
		$result2 = pg_prepare($db, 'update_info', $sql2);
		$result2 = pg_execute($db, 'update_info', array($new_password, $user_name, $user_email, $username));
		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Updated Your Account");'; 
		echo 'window.location.href = "your_account.php";';
		echo '</script>';
		
	}
	
	
	else{
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Update Information, Invalid Password");'; 
		echo 'window.location.href = "your_account.php";';
		echo '</script>';
	}
	
?>