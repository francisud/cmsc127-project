<?php	
	include('check_user.php');
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
	$sql = " SELECT * from artist ";
	$ret = pg_query($db, $sql);
   
   if(!$ret){
	  echo pg_last_error($db);
	  exit;
	}
	
	$sql2 = " SELECT * from album ";
	$ret2 = pg_query($db, $sql2);	
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
		<title>Spotify</title>
		<meta charset="utf-8"/>
		<script src="../../js/jquery-1.11.3.min.js"></script>
		<script src="../../js/jquery.tmpl.min.js"></script>
		<link rel="stylesheet" href="../../css/add_song.css">
		<link rel="stylesheet" href="../../bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="../../bootstrap/bootstrap-theme.min.css">
		<script src="../../js/bootstrap.min.js"></script>
	</head>
	
	<style>
		#login-container{
			background-color: rgb(43,43,43);
			color: white;				
		}
		
		.page-header #heading{
			color: white;
		}
		
		body{
			background-image: url("../../res/music4.png");
		}
		
	</style>
<body>
	<div class="container-fluid">
		<div id="log">
			<div class="col-xs-6 col-md-4"></div>
			<div id="login-container" class="col-xs-6 col-md-4">
				<div class="page-header">
					<h3 id="heading">ADD SONG</h3>
				</div>
				
				<form action="submit_add_song.php" method="post">			
					<div class="form-group">
						<div class="">
							<input type="text" class="form-control" placeholder="Song Title" required="required" name="song_title">
						</div>
					</div>			
				
					<div class="form-group">
						<div class="">
							<input type="text" class="form-control" placeholder="Online Link" required="required" name="online_link">
						</div>
					</div>	
					
					<div>FILE</div>
					<div class="form-group">
						<div class="">
							<input type="file"  required="required" name="offline_link">
						</div>
					</div>
				
					
					<div class="form-group">
						<div class="">
						
							<div>
								<p>ARTIST
								<a href="add_artist.php" target="my_iframe" >(ADD ARTIST)</a>						
								</p>
							</div>
							
							<select class="form-control" name="artist" required="required">
							 <option disabled selected style="display:none"> Select An Artist </option>
							<?php
							while($row = pg_fetch_row($ret)) {
							?>
								<option value="<?= $row[0]; ?>"><?= $row[0]; ?></option>
							<?php
							}
							?>
							</select>				
						</div>
					</div>
					
					<div class="form-group">
						<div class="">
							<div>
								<p>ALBUM
								<a href="add_album.php" target="my_iframe">(ADD ALBUM)</a>						
								</p>
							</div>
							
							
							<select class="form-control" name="album" required="required">
							 <option disabled selected style="display:none"> Select An Album </option>
							<?php
							while($row = pg_fetch_row($ret2)) {
							?>
								<option value="<?= $row[0]; ?>"><?= $row[0]; ?></option>
							<?php
							}
							?>
							</select>				
						</div>
					</div>
					
					<div class="form-group">
							<button type="submit" class="btn btn-success">Add Song</button>
					</div>
				</form>
				
			</div>
			<div class="col-xs-6 col-md-4"></div>
		</div>	
	</div>
	
</body>
</html>
