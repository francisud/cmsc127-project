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
				SET number_of_times_played = number_of_times_played+1
				where song_id = $1";
	$result = pg_prepare($db, 'update_song_play', $sql);
	$result = pg_execute($db, 'update_song_play', array($songid));	
?>