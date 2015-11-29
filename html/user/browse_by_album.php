<?php	
	include('check_user.php');
	
	$album_name = $_GET['album_name'];
	
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   if($_GET['album_name'] == null){
		$sql = " SELECT * FROM album";
		$result = pg_query($db, $sql);
	   
	   if(!$result){
		  echo pg_last_error($db);
		  exit;
		}
   }
   
   else{
	   
	   $sql = " SELECT * FROM album 
				where album_name like $1
				";
	   $result = pg_prepare($db, 'get_album', $sql);
	   $result = pg_execute($db, 'get_album', array('%'.$album_name.'%'));
	   
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
		<link rel="stylesheet" href="../../css/browse_by_album.css"> 
		
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
		
			<div class="h3div"><h3> ALL ALBUMS </h3></div>
	
			<div class="searching">
					<form class="navbar-form navbar-left" action="browse_by_album.php" method="get" target="my_iframe">
						<div class="form-group">
						  <input type="text" class="form-control" placeholder="Search Album" name="album_name" value="<?=  $_GET['album_name']; ?>"/>
						</div>
					<button type="submit" class="btn btn-success">Search</button>
					</form>
			</div>
		
			<table class="table">
				<thead>
					<tr>	
						<th>ARTIST</th>			
						<th>ALBUM NAME</th>
						<th>ALBUM DATE RELEASED</th>
						<th>ALBUM NUMBER OF SONGS</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[4]; ?></td>
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
		function view_lists_of_songs(albumname){
				console.log(albumname);		
				
				//window.open("view_lists_of_songs.html");
				
				$.ajax({
					  type: "POST",
					  url: "view_lists_of_songs.php",
					  data: { "albumname": albumname},
					}).done(function( msg ) {
						window.location.reload(); 
					});
		}
	</script>
	</body>	
</html>