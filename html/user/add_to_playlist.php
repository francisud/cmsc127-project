<?php	
	include('check_user.php');
	$songid = $_POST['songid'];
	$playlistid = $_POST['playlistid'];
	
	echo $songid;
	echo $playlistid;
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	
	$sql = " INSERT INTO  playlist_song(playlist_id, song_id)
				VALUES ($1, $2)";
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($playlistid, $songid));	
	
	
	$sql2 = "UPDATE  playlist
				SET number_of_songs = number_of_songs+1
				WHERE playlist_id = $1
				";
	$result2 = pg_prepare($db, 'update_number_of_songs', $sql2);
	$result2 = pg_execute($db, 'update_number_of_songs', array($playlistid));	
?>