<?php
	include('check_user.php');
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

	<div id="log">
		<div class="col-xs-6 col-md-4"></div>
		<div id="login-container" class="col-xs-6 col-md-4">
			<div class="page-header">
				<h3 id="heading">ADD ARTIST</h3>
			</div>
			
			<form action="submit_add_artist.php" method="post">
			
				<div class="form-group">
					<div class="">
						<input type="text" class="form-control" placeholder="Artist Stage Name" required="required" name="stage_name">
					</div>
				</div>			
			
				<div class="form-group">
					<div class="">
						<input type="text" class="form-control" placeholder="Artist Real Name" required="required"  name="real_name">
					</div>
				</div>
				
				<div class="form-group">
					<div class="">
						<textarea class="form-control" placeholder="Artist Description" rows="3"></textarea name="description">
					</div>
				</div>				
				
				
				<div class="form-group">
						<button type="submit" class="btn btn-success">Add Artist</button>
				</div>
			</form>
			
		</div>
		<div class="col-xs-6 col-md-4"></div>
	</div>	
	
</body>
</html>