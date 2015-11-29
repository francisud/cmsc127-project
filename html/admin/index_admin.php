<?php
	include('check_admin.php');
	$host        = "host=localhost";
	$port        = "port=5432";
	$dbname      = "dbname=postgres";
	$credentials = "user=postgres password=password";

	$db = pg_connect( "$host $port $dbname $credentials");
	
	if(!$db){
		echo "Error : Unable to open database\n";
	}
	
	$sql = " SELECT * FROM users where is_pending='true' ";
	$ret = pg_query($db, $sql);
	
	if(!$ret){
	  echo pg_last_error($db);
	  exit;
	}	
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
  <link rel="stylesheet" href="../../css/index_admin.css"> 
</head>
<body>

<div class="container-all">	
	<div>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div>
					<ul class="nav navbar-nav">		
						<li>
						<a href="index_admin.php">Approve Users</a>						
						</li>

						
						<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">View<span class="caret"></span></a>
						<ul class="dropdown-menu">
						<li><a href="view_users_admin.php">View All Users Approved For A Specific Date</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="view_allsongs_admin.php">View All Songs By An Artist</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="view_timesplayed_admin.php">View Total Number A Song Is Played</a></li>
						</ul>
						</li>						
					</ul>
				</div>

				<div class="user-navigation">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown user-navigation-button">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class ="glyphicon glyphicon-chevron-down"></span></a>
						<ul class="dropdown-menu">
						<li><a href="submit_sign_out_admin.php">Log Out</a></li>
						</ul>
						</li>
					</ul>		
				</div>
			</div>	  
		</nav>
	</div>
	
	<div>
		<div class="panel">
			<div class="panel-heading"><h4>Users Waiting For Approval</h4>
			</div>

			<table class="table">
				<tr>
					<td><strong>DATE OF SIGNED UP</strong></td>
					<td><strong>EMAIL</strong></td>
					<td><strong>NAME</strong></td>
					<td><strong>USERNAME</strong></td>
				</tr>
				
				<?php
				while($row = pg_fetch_row($ret)) {
				?>
					<tr>
					<td><?= $row[4]; ?></td>
					<td><?= $row[3]; ?></td>
					<td><?= $row[2]; ?></td>
					<td name="username"><?= $row[0]; ?></td>
					<td><button type="button" class="btn btn-success btn-xs" onclick="approve_user('<?= $row[0]; ?>')">APPROVE USER</button></td>
					</tr>
				<?php
				}
				?>
				
			</table>			
		</div>
	</div>	
</div>

<script>
	function approve_user(username){
		$.ajax({
		  type: "POST",
		  url: "approve_user_admin.php",
		  data: { "username": username},
		}).done(function( msg ) {
			if(alert('Successfully Approved User: ' + username)){}
			else window.location.reload(); 
		});
	}
</script>

</body>
</html>
