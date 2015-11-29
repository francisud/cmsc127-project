<?php
	include('check_user.php');
	$song_title = $_POST['song_title'];
	$online_link = $_POST['online_link'];
	$offline_link = $_POST['offline_link'];
	$artist = $_POST['artist'];
	$album = $_POST['album'];
	$uploadedby = $_COOKIE['active_user'];
	

	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
	$sql = " INSERT INTO song (song_title, username, artist, album, online_link, offline_link)
				values ($1, $2, $3, $4, $5, $6)
				";
				
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($song_title, $uploadedby, $artist, $album, $online_link, $offline_link));
	
	
	$sql2 = "
				UPDATE album
				SET album_number_of_songs = album_number_of_songs + 1
				WHERE album_name = $1
				";
				
	$result2 = pg_prepare($db, 'update_number_of_songs', $sql2);
	$result2 = pg_execute($db, 'update_number_of_songs', array($album));
	
	
	if(!$result2 || !$result){
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Add Song");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Added New Song");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	}
	
?>