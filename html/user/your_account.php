<?php	
	include('check_user.php');
	$username = $_COOKIE['active_user'];
	
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
			
	$result = pg_prepare($db, 'insert_new_song', $sql);
	$result = pg_execute($db, 'insert_new_song', array($username));
   
   if(!$result){
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
		<link rel="stylesheet" href="../../css/browse_by_album.css"> 
	</head>
	
	<body>
		<div class="container-fluid">
			<h3> MY ACCOUNT </h3>
			<table class="table">
				<thead>
					<tr>	
						<th>USERNAME</th>			
						<th>NAME</th>
						<th>EMAIL</th>
						<th>DATE JOINED</th>
						<th>DATE APPROVED</th>
					</tr>
				</thead>
				
				<tbody>
					<?php
					while($row = pg_fetch_row($result)) {
					?>
						<tr>
							<td><?= $row[0]; ?></td>
							<td><?= $row[2]; ?></td>
							<td><?= $row[3]; ?></td>
							<td><?= $row[4]; ?></td>
							<td><?= $row[7]; ?></td>
							
							<td>
							<a href="update_your_account.php?username=<?= $username ?>" target="my_iframe">
							<button type="button" class="btn btn-success btn-xs">UPDATE</button>
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