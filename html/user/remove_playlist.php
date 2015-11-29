<?php	
	include('check_user.php');
	$playlistid = $_POST['playlistid'];
		
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	
	$sql = " DELETE FROM  playlist_song
				WHERE playlist_id = $1";
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($playlistid));	
	
	
	$sql2 = " DELETE FROM  playlist
					WHERE playlist_id = $1";
					
	$result2 = pg_prepare($db, 'update_number_of_songs', $sql2);
	$result2 = pg_execute($db, 'update_number_of_songs', array($playlistid));
?>