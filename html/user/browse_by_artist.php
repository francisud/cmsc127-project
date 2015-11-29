<?php	
	include('check_user.php');
	
	$artist_name = $_GET['artist_name'];
	
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   
   if($_GET['artist_name'] == null)
	{
		$sql = " SELECT stage_name, artist_name from artist ";
		$result = pg_query($db, $sql);
	   
	   if(!$result){
		  echo pg_last_error($db);
		  exit;
		}
	}
	
	
	else{
		$sql = " SELECT stage_name, artist_name from artist 
				WHERE artist_name = $1
				";
		
		$result = pg_prepare($db, 'get_artist', $sql);
		$result = pg_execute($db, 'get_artist', array($artist_name));
	   
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
		<link rel="stylesheet" href="../../css/browse_by_artist.css"> 
		
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
			<div class="h3div"><h3> ALL ARTISTS </h3></div>
	
			<div class="searching">
					<form class="navbar-form navbar-left" action="browse_by_artist.php" method="get" target="my_iframe">
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Search Artist" name="artist_name" value="<?=  $_GET['artist_name']; ?>"/>
						</div>
					<button type="submit" class="btn btn-success">Search</button>
					</form>
			</div>
			
			<table class="table">
				<thead>
					<tr>	
						<th>ARTIST</th>			
						<th>ARTIST REALNAME</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[0]; ?></td>
							<td><?= $row[1]; ?></td>
							
							<td>
							<a href="view_all_albums_by_artist.php?artist=<?= $row[0]; ?>" target="my_iframe">
							<button type="button" class="btn btn-success btn-xs">VIEW ALL ALBUMS OF ARTIST</button>
							</a>
							</td>
							
							<td>
							<a href="view_all_songs_by_artist.php?artist=<?= $row[0]; ?>" target="my_iframe">
							<button type="button" class="btn btn-success btn-xs">VIEW ALL SONGS OF ARTIST</button>
							</a>
							</td>
							
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</body>
	
</html>