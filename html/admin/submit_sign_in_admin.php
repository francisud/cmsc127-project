<?PHP
	$username = $_POST['username'];
	$password = $_POST['password'];
	$checker = 0;		
	
   $host        = "host=localhost";
   $port        = "port=5432";
   $dbname      = "dbname=postgres";
   $credentials = "user=postgres password=password";

   $db = pg_connect( "$host $port $dbname $credentials");
   
	$sql = " SELECT * FROM users where username='$username' and password='$password' and is_admin='true' ";
	$ret = pg_query($db, $sql);
		
	if(!$ret){
	  echo pg_last_error($db);
	  exit;
	}
		
	else{
		while($row = pg_fetch_row($ret)) {
		if($username == $row[0] && $password == $row[1] && $is_admin == 'true')
		  echo "Username = ". $row[0] . "\n";
		  echo "Password = ". $row[1] ."\n";
		  echo "Is_Admin = ". $row[5] ."\n";
		  $checker = 1;
		  
		  //should add cookies
		  $cookie_key = "active_user";
		  $cookie_value = $username;
		  setcookie($cookie_key, $cookie_value);
		  
		  header('Location: index_admin.php');
		}					
	}
		
	if($checker == 0) {
		echo '<script type="text/javascript">'; 
		echo 'alert("No Such User In The Database");'; 
		echo 'window.location.href = "sign_in_admin.php";';
		echo '</script>';
	}	

?>