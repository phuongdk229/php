<?php
if (!defined('APP_PATH')) {
	die('can not access');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css">
	<style type="text/css">
		form{
			border: 1px solid #ccc;
			padding: 20px;
			border-radius: 5px;
		}
	</style>	
</head>
<body>
	<div class="container">
		<h3 class="text-center">Admin-Login</h3>
		<div class="row">
			<div class="col-md-6 offset-3">
				<form action="?c=login&m=handle" method="POST">
					<div class="form-group">
						<label for="txtUser">User Name</label>
						<input type="text" name="txtUser" class="form-control" placeholder="Enter Username">
					</div>
					<div class="form-group">
						<label for="txtPass">Pass Word</label>
						<input type="password" name="txtPass" placeholder="Enter Password" class="form-control" >
					</div>
					<button type="submit" class="btn btn-primary" name="btnSubmit">Login</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>