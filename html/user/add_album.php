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
		
		<!-- Include Date Range Picker -->
		<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="http://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
		<script type="text/javascript" src="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
		<link rel="stylesheet" type="text/css" href="http://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
		
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
		
		.search-bar{
			color: black;
		}
		
	</style>
<body>

	<div id="log">
		<div class="col-xs-6 col-md-4"></div>
		<div id="login-container" class="col-xs-6 col-md-4">
			<div class="page-header">
				<h3 id="heading">ADD ALBUM</h3>
			</div>
			
			<form action="submit_add_album.php" method="post">
			
				<div class="form-group">
					<div class="">
						<input type="text" class="form-control" placeholder="Album Name" required="required" name="album_name">
					</div>
				</div>
	
			<p>DATE RELEASED</p>
			<div class="search-bar">
				<span>
					<p><input class="search-bar-field" type="text" name="date" value="<?=  $_GET['date']; ?> "/>
				</span>				
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
						<button type="submit" class="btn btn-success">Add Album</button>
				</div>
			</form>
			
		</div>
		<div class="col-xs-6 col-md-4"></div>
	</div>	
	
<script type="text/javascript">
$(function() {		
	$('input[name="date"]').daterangepicker({
		singleDatePicker: true,
		showDropdowns: true			
	})
});
</script>
	
</body>
</html>