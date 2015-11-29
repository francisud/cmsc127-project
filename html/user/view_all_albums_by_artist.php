<?php
	include('check_user.php');
	$artist = $_GET['artist'];
   
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
	$sql = " SELECT * FROM album
				WHERE artist = '$artist'
				ORDER BY album_name
				";
	$ret = pg_query($db, $sql);
   
   if(!$ret){
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
			<table class="table">
				<thead>
					<tr>	
						<th>ALBUM NAME</th>
						<th>ALBUM DATE RELEASED</th>					
						<th>ALBUM NUMBER OF SONGS</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($ret)) {
					?>
						<tr>
							<td><?= $row[0]; ?></td>
							<td><?= $row[1]; ?></td>
							<td><?= $row[2]; ?></td>
			
							<td>
							<a href="view_lists_of_songs.php?albumname=<?= $row[0]; ?>" target="my_iframe">
							<button type="button" class="btn btn-success btn-xs">VIEW LISTS OF SONGS</button>
							</a>
							</td>
							
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