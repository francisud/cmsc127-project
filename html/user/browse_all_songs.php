<?php	
	include('check_user.php');
	
	$song_title = $_GET['song_title'];
	
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
      
	if($_GET['song_title'] == null)
	{
		$sql = " SELECT * FROM song
				ORDER BY song_title
				";
		$result = pg_query($db, $sql);
	   
	   if(!$result){
		  echo pg_last_error($db);
		  exit;
		}
	}
   
   else{
		$sql = " SELECT * FROM song
					where song_title like $1
					ORDER BY song_title
					";		
		
		$result = pg_prepare($db, 'get_song', $sql);
		$result = pg_execute($db, 'get_song', array('%'.$song_title.'%'));
	   
	   if(!$result){
		  echo pg_last_error($db);
		  exit;
		}	
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
		
		<style>
			.search-bar{
				color: black;
			}
			
			.h3div{
				margin-bottom: 5%;
			}
			
			.searching{
				margin-left: -2%;
			}
		</style>
	</head>
	
	<body>
	<div class="container-fluid">				
		<div class="h3div"><h3> ALL SONGS </h3></div>
	
		<div class="searching">
				<form class="navbar-form navbar-left" action="browse_all_songs.php" method="get" target="my_iframe">
					<div class="form-group">
					  <input type="text" class="form-control" placeholder="Search Song" name="song_title" value="<?=  $_GET['song_title']; ?>"/>
					</div>
				<button type="submit" class="btn btn-success">Search</button>
				</form>
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