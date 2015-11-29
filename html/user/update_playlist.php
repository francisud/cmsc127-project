<?php
	include('check_user.php');
	$playlistid = $_GET['playlistid'];
	$username = $_COOKIE['active_user'];
   
   	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " SELECT * from playlist
				where username = $1
				ORDER BY playlist_name
			";				
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($username));
	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CMSC 127</title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../../css/browse_all_songs.css"> 
		
		<style>
		
		.divider {
			padding-top: 100px;
			
		}
		
		</style>
		
	</head>
	
	<body>
		<div class="container-fluid">
			<div class="">
			<h3>MY PLAYLISTS</h3>
			</div>
		
			<table class="table">
				<thead>
					<tr>	
						<th>PLAYLIST NAME</th>
						<th>NUMBER OF SONGS</th>					
						<th>NUMBER OF TIMES PLAYED</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[1]; ?></td>
							<td><?= $row[2]; ?></td>
							<td><?= $row[3]; ?></td>
			
							<td><button type="button" class="btn btn-danger btn-xs" onclick="remove_playlist('<?= $row[0]; ?>')">REMOVE PLAYLIST</button></td>
							
							<td><a href="view_songs_of_playlist.php?playlistid=<?= $row[0]; ?>" target="my_iframe"><button class="btn btn-success btn-xs">VIEW SONGS IN PLAYLIST</button></a></td>
							
							<td><button type="button" class="btn btn-success btn-xs" onclick="play_playlist('<?= $row[0]; ?>')">PLAY PLAYLIST</button></td>
							
						</tr>
					<?php
					}
					?>					
				</tbody>
			</table>		
			
		</div>
		
		<script>
			function remove_playlist(playlistid){
			
				$.ajax({
					  type: "POST",
					  url: "remove_playlist.php",
					  data: { "playlistid": playlistid},
					}).done(function( msg ) {
						window.top.window.location.reload(); 
					});
			}			
			

			function play_playlist(playlistid) {
				$.ajax({
					  type: "POST",
					  url: "play_playlist.php",
					  data: { "playlistid": playlistid},
					}).done(function( msg ) {
						window.location.reload(); 
					});				
			}			
			
			
		</script>
		
	</body>	
</html>