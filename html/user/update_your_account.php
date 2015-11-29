<?php	
	include('check_user.php');
	$username = $_GET['username'];
	
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   if(!$db){
	  echo "Error : Unable to open database\n";
   }
   
	$sql = " SELECT * FROM users
			where username = $1
			";
			
	$result = pg_prepare($db, 'get_info', $sql);
	$result = pg_execute($db, 'get_info', array($username));
	
	
	$row = pg_fetch_row($result);
   
   if(!$result){
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
		<link rel="stylesheet" href="../../css/sign_up.css">
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
				<h3 id="heading">EDIT MY ACCOUNT</h3>
			</div>
			
			<form action="submit_update_your_account.php" method="post">
		
			<p>NAME</p>
				<div class="form-group">
					<div class="">
						<input type="text" class="form-control" required="required" name="user_name" value="<?= $row[2]; ?>">
					</div>
				</div>

				<p>EMAIL</p>
				<div class="form-group">
					<div class="">
						<input type="email" class="form-control" required="required" name="user_email" value="<?= $row[3]; ?>">
					</div>
				</div>
				
				<p>OLD PASSWORD</p>
				<div class="form-group">
					<div class="">
						<input type="password" class="form-control" required="required" name="old_password" placeholder="Old Password">
					</div>
				</div>
				
				<p>NEW PASSWORD</p>
				<div class="form-group">
					<div class="">
						<input type="password" class="form-control" required="required" name="new_password" placeholder="New Password">
					</div>
				</div>
								
				
				<div class="form-group">
						<button type="submit" class="btn btn-success">Submit Changes</button>
				</div>
				
				
			</form>
			
		</div>
		<div class="col-xs-6 col-md-4"></div>
	</div>	
		
</body>
</html>