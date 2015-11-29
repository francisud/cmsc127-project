<?php
	include('check_user.php');
	$playlist_of = $_COOKIE['active_user'];
	
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
   $sql = " SELECT * from playlist 
				where username = $1";
				
	$result = pg_prepare($db, 'insert_new_album', $sql);
	$result = pg_execute($db, 'insert_new_album', array($playlist_of));

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>CMSC 127</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../css/index.css"> 
</head>
<body>

<div class="container-all">	
	
	<nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
		<div>
		  <ul class="nav navbar-nav">	  
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">File<span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="add_song.php" target="my_iframe">Add Song</a></li>
				<li><a href="add_artist.php" target="my_iframe">Add Artist</a></li>
				<li><a href="add_album.php" target="my_iframe">Add Album</a></li>
				<li><a href="add_playlist.php" target="my_iframe">New Playlist</a></li>
				<li><a href="update_playlist.php" target="my_iframe">Update Playlist</a></li>
			  </ul>
			</li>
			
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Project<span class="caret"></span></a>
			  <ul class="dropdown-menu">
				<li><a href="about_designers.php" target="my_iframe">About Designers</a></li>
			  </ul>
			</li>			
		  </ul>
		  
		  <ul class="nav navbar-nav navbar-right">
					<li class="dropdown user-navigation-button">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class ="glyphicon glyphicon-chevron-down"> </span></a>
						<ul class="dropdown-menu">
							<li><a href="your_account.php" target="my_iframe">My Account</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="submit_sign_out.php">Log Out</a></li>
						</ul>
					</li>
				</ul>
		  
		</div>		
	  </div>			
	</nav>
	
	
	<div class="dynamic-section">
		<div id="left">		
			<div class="wrapper-left-options">
				<ul class="left-navbar">				
					<li>Main</li>			
					<a href="recommended_music.php" target="my_iframe"><button class="link"><span class="glyphicon glyphicon-folder-open"></span>Browse All Recommended Songs</button></a>
					
					<a href="browse_all_songs.php" target="my_iframe"><button class="link"><span class="glyphicon glyphicon-folder-open"></span>Browse All Songs</button></a>
					
					<a href="browse_by_album.php" target="my_iframe"><button class="link"><span class="glyphicon glyphicon-folder-open"></span>Browse By Album</button></a>
					
					<a href="browse_by_artist.php" target="my_iframe"><button class="link"><span class="glyphicon glyphicon-folder-open"></span>Browse By Artist</button></a>
						
					<li>Playlists</li>
					
					<a href="update_playlist.php" target="my_iframe"><button class="link">View All My Playlists</button></a>
					
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<a href="view_songs_of_playlist.php?playlistid=<?= $row[0]; ?>" target="my_iframe"><button class="link"><?= $row[1]; ?></button></a>
					<?php
					}
					?>
					
				</ul>
				<div class="btn-group btn-group-justified" role="group" aria-label="...">
					<div class="btn-group" role="group">
						<a href="add_playlist.php" target="my_iframe"><button type="button" class="btn btn-success">New Playlist</button></a>
					</div>
				</div>
			
			</div>
			

		</div>
		
		<div id="middle">
				<iframe src="recommended_music.php" width="100%" height="100%" frameborder="0" name="my_iframe">
				</iframe>
		</div>		
		
	</div>

</div>


</body>
</html>
