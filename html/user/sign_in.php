<?php
	$cookie_key = "active_user";
	$cookie_value = "";
	setcookie($cookie_key, $cookie_value);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Spotify</title>
		<meta charset="utf-8"/>
		<script src="../../js/jquery-1.11.3.min.js"></script>
		<script src="../../js/jquery.tmpl.min.js"></script>
		<link rel="stylesheet" href="../../css/sign_in.css">
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
	</style>
	<body class="">

		<div class="row">
			<nav id="mainNav" class="navbar navbar-inverse navbar-fixed-top affix-top">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand page-scroll" href="">Spotify</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
							<li class="">
								<a class="page-scroll" href="../admin/sign_in_admin.php">Admin Sign In</a>
							</li>
							<li class="">
								<a class="page-scroll" href="sign_in.php">Sign In</a>
							</li>
							<li class="">
								<a class="page-scroll" href="sign_up.php">Sign Up</a>
							</li>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container-fluid -->
			</nav>
		</div>

		<div id="log">
			<div class="col-xs-6 col-md-4"></div>
			<div id="login-container" class="col-xs-6 col-md-4">
				<div class="page-header">
					<h3 id="heading">SIGN IN</h3>
				</div>
				
				<form action="submit_sign_in.php" method="post">																
					<div class="form-group">
						<div class="">
							<input type="text" class="form-control" placeholder="Username" required="required" name="username">
						</div>
					</div>
					<div class="form-group">
						<div class="">
							<input type="password" class="form-control" placeholder="Password" required="required" name="password">
						</div>
					</div>
					<div class="form-group">
							<button type="submit" class="btn btn-success"  onclick="">Sign in</button>
					</div>
				</form>
				
			</div>
			<div class="col-xs-6 col-md-4"></div>
		</div>
	</body>
</html>
