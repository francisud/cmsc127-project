<?php
	include('check_user.php');

	$stage_name = $_POST['stage_name'];
	$real_name = $_POST['real_name'];
	$description = $_POST['description'];

	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " INSERT INTO artist (stage_name, artist_name, description)
				values ($1, $2, $3)";
				
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($stage_name, $real_name, $description));
   
   
   if(!$result){
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Add Artist");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Added New Artist");'; 
		echo 'window.location.href = "add_song.php";';
		echo '</script>';
	}
?>