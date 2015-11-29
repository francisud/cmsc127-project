<?php
	include('check_user.php');
	$songid = $_POST['songid'];
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	
	$sql = " UPDATE song
				SET is_recommended = 'true'
				where song_id = $1";
	$result = pg_prepare($db, 'update_recommended_status', $sql);
	$result = pg_execute($db, 'update_recommended_status', array($songid));	
?>