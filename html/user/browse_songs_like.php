<?php	
	include('check_user.php');
	$song_title = $_POST['song_title'];

   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   $song_title = '%'.$song_title.'%';
	$sql = " SELECT * FROM song
				where song_title like $1
				ORDER BY artist
				";
	$result = pg_prepare($db, 'get_songs', $sql);
	$result = pg_execute($db, 'get_songs', array($song_title));
   
   if(!$result){
	  echo pg_last_error($db);
	  exit;
	}
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
	</head>
	
	<body>
		<div class="container-fluid">
			<h3> ALL SONGS </h3>
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
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[6]; ?></td>
							<td><?= $row[1]; ?></td>
							<td><?= $row[7]; ?></td>
							<td><?= $row[5]; ?></td>
							<td><?= $row[2]; ?></td>
							<td><?= $row[3]; ?></td>
							<td><button type="button" class="btn btn-success btn-xs" onclick="update_recommended_status('<?= $row[0]; ?>')">RECOMMEND</button></td>
							<td><button type="button" class="btn btn-success btn-xs" onclick="play_music('<?= $row[0]; ?>')">PLAY MUSIC</button></td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>

		<script>
			function play_music(songid) {
				console.log(songid);			
				
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