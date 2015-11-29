<?php
	include('check_user.php');

	$playlist_name = $_POST['playlist_name'];
	$playlist_of = $_COOKIE['active_user'];
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " INSERT INTO playlist (playlist_name, username)
				values ($1, $2)";
				
	$result = pg_prepare($db, 'insert_new_album', $sql);
	$result = pg_execute($db, 'insert_new_album', array($playlist_name, $playlist_of));
   
   
   if(!$result){
		echo '<script type="text/javascript">'; 
		echo 'alert("Failed To Create Playlist");'; 
		echo 'window.top.window.location.href = "index.php";';
		echo '</script>';
	} else {		
		echo '<script type="text/javascript">'; 
		echo 'alert("Successfully Created Playlist");'; 
		echo 'window.top.window.location.href = "index.php";';
		echo '</script>';
	}
?>