<?php
	if(!isset($_COOKIE['active_user'])) {
		header('Location: sign_in_admin.php');
	}

	$check_host        = "host=localhost";
	$check_port        = "port=5432";
	$check_dbname      = "dbname=postgres";
	$check_credentials = "user=postgres password=password";

	$check_db = pg_connect( "$check_host $check_port $check_dbname $check_credentials");
	if(!$check_db){
		echo "Error : Unable to open database\n";
	}

	$check_username = $_COOKIE['active_user'];
	$check_sql = "select * from users where username = $1 and is_admin = true";
	$check_result = pg_prepare($check_db, 'check_user', $check_sql);
	$check_result = pg_execute($check_db, 'check_user', array($check_username));

	if(!$check_result){
	  echo pg_last_error($check_db);
	  exit;
	}

	if(!pg_fetch_row($check_result)){
		header('Location: sign_in_admin.php');
	}

?>