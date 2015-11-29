<?php
	include('check_user.php');

	$album_name = $_POST['album_name'];
	$album_date_released = $_POST['date'];
	
	//$album_date_released = to_date('$album_date_released', 'DD Mon YYYY');
	$artist = $_POST['artist'];

	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " INSERT INTO album (album_name, album_date_released, artist)
				values ($1, to_date($2, 'MM/DD/YYYY'), $3)";
				
	$result = pg_prepare($db, 'insert_new_album', $sql);
	$result = pg_execute($db, 'insert_new_album', array($album_name, $album_date_released, $artist));
   
   
   if(!$result){
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Add Album");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Added New Album");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	}
?>