<?php
	include('check_user.php');
	$playlistid = $_GET['playlistid'];
   
   	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " SELECT song.artist, song.song_title, song.album, song.song_id, playlist_song.playlist_song_id
				FROM playlist_song, song
				WHERE playlist_song.playlist_id = $1
				and (playlist_song.song_id = song.song_id)
				ORDER BY song.song_title
			";

	$result = pg_prepare($db, 'get_songs', $sql);
	$result = pg_execute($db, 'get_songs', array($playlistid));
	
	
	$sql2 = "SELECT * from song";	
	$ret2 = pg_query($db, $sql2);
	
	
	$sql3 = "SELECT playlist_name
				FROM playlist
				WHERE playlist_id = $1
				";
	$result3 = pg_prepare($db, 'get_playtlist_name', $sql3);
	$result3 = pg_execute($db, 'get_playtlist_name', array($playlistid));
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
			<?php
			while($row = pg_fetch_row($result3)) {
			?>
						<h3> SONGS IN <?= $row[0]; ?></h3>
			<?php
			}
			?>
			</div>
		
			<table class="table">
				<thead>
					<tr>	
						<th>ARTIST</th>
						<th>SONG TITLE</th>					
						<th>ALBUM</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[0]; ?></td>
							<td><?= $row[1]; ?></td>
							<td><?= $row[2]; ?></td>
			
							<td><button type="button" class="btn btn-danger btn-xs" onclick="remove_music_from_playlist('<?= $row[4]; ?>', '<?= $playlistid?>')">REMOVE SONG FROM PLAYLIST</button></td>
							
							<td><button type="button" class="btn btn-success btn-xs" onclick="update_recommended_status('<?= $row[3]; ?>')">RECOMMEND</button></td>
							
							<td><button type="button" class="btn btn-success btn-xs" onclick="play_music('<?= $row[3]; ?>')">PLAY MUSIC</button></td>
							
						</tr>
					<?php
					}
					?>					
				</tbody>
			</table>
			
			<div class="divider">
			<h3>ALL SONGS</h3>
			</div>
			
			<table class="table">
				<thead>
					<tr>	
						<th>ARTIST</th>
						<th>SONG TITLE</th>					
						<th>ALBUM</th>
						<th>UPLOADED BY</th>
						<th>DATE ADDED</th>
						<th>NUMBER OF TIMES PLAYED</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($ret2)) {
					?>
						<tr>
							<td><?= $row[6]; ?></td>
							<td><?= $row[1]; ?></td>
							<td><?= $row[7]; ?></td>
							<td><?= $row[5]; ?></td>
							<td><?= $row[2]; ?></td>
							<td><?= $row[3]; ?></td>
							<td><button type="button" class="btn btn-success btn-xs" onclick="add_to_playlist('<?= $row[0]; ?>', '<?= $playlistid?>')">ADD TO PLAYLIST</button></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			
		</div>
		
		<script>
			function add_to_playlist(songid, playlistid){
			
				$.ajax({
					  type: "POST",
					  url: "add_to_playlist.php",
					  data: { "songid": songid, "playlistid": playlistid},
					}).done(function( msg ) {
						window.location.reload(); 
					});
			}
			
			
			function remove_music_from_playlist(playlistsongid, playlistid){
				
				$.ajax({
					  type: "POST",
					  url: "remove_music_from_playlist.php",
					  data: { "playlistsongid": playlistsongid, "playlistid": playlistid},
					}).done(function( msg ) {
						window.location.reload(); 
					});
			}
			
			
			
			function play_music(songid) {
				$.ajax({
					  type: "POST",
					  url: "play_music.php",
					  data: { "songid": songid},
					}).done(function( msg ) {
						window.location.reload(); 
					});				
			}
			
			
			function update_recommended_status(songid){
				$.ajax({
					  type: "POST",
					  url: "change_recommend.php",
					  data: { "songid": songid},
					}).done(function( msg ) {
						window.location.reload(); 
					});
			}
		</script>
		
	</body>	
</html>